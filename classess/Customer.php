<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Formate.php');

?>


<?php

class Customer{
	
private $db;
private $fm;

	public function __construct()
	{
		
		$this->db = new Database();
		$this->fm = new Format();
	}
public function customerRegistration($data){

$name = mysqli_real_escape_string($this->db->link, $data['name']);
$address = mysqli_real_escape_string($this->db->link, $data['address']);
$city = mysqli_real_escape_string($this->db->link, $data['city']);
$country = mysqli_real_escape_string($this->db->link, $data['country']);
$zip = mysqli_real_escape_string($this->db->link, $data['zip']);
$phone = mysqli_real_escape_string($this->db->link, $data['phone']);
$email = mysqli_real_escape_string($this->db->link, $data['email']);
$pass = mysqli_real_escape_string($this->db->link, md5($data['pass']));


	$query = "INSERT INTO tbl_customer(name,address,city,country,zip,phone,email,pass) VALUES('$name','$address','$city','$country','$zip','$phone','$email','$pass')";
 	$query1 = "INSERT INTO tbl_cus_order(name,address,city,country,zip,phone,email) VALUES('$name','$address','$city','$country','$zip','$phone','$email')";
    if ($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == "" || $pass == "") {
        $msg = "<span class='error'>Các trường không được trống!</span>";
        return $msg;
    }

    $mailquery = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1";
    $mailchk = $this->db->select($mailquery);
    if ($mailchk != false) {
        $msg = "<span class='error'>Thư điện tử đã tồn tại!</span>";
        return $msg;
    } else {
        $query = "INSERT INTO tbl_customer(name,address,city,country,zip,phone,email,pass) VALUES('$name','$address','$city','$country','$zip','$phone','$email','$pass')";
        $inserted_row = $this->db->insert($query);
        if ($inserted_row) {
            $customer_id = $this->db->link->insert_id;
            $query1 = "INSERT INTO tbl_cus_order(name,address,city,country,zip,phone,email,id) VALUES('$name','$address','$city','$country','$zip','$phone','$email','$customer_id')";
            $inserted_row2 = $this->db->insert($query1);
            if ($inserted_row2) {
                $msg = "<span class='success'>Dữ liệu khách hàng được chèn vào cả hai bảng thành công.</span>";
            } else {
                $msg = "<span class='error'>Dữ liệu khách hàng không được chèn vào bảng đơn hàng.</span>";
            }
        } else {
            $msg = "<span class='error'>Dữ liệu khách hàng không được chèn.</span>";
        }
        return $msg;
}

}

public function customerLogin($data){
	$email = mysqli_real_escape_string($this->db->link, $data['email']);
	$pass = mysqli_real_escape_string($this->db->link, md5($data['pass']));
	if (empty($email) || empty($pass)) {
	$msg = "<span class='error'>Các trường không được trống!</span>";
		return $msg;
	}
	$query = "SELECT * FROM tbl_customer WHERE email = '$email' AND pass = '$pass'";
	$result = $this->db->select($query);
	if ($result != false) {
		$value = $result->fetch_assoc();
		Session::set("cuslogin",true);
		Session::set("cmrId",$value['id']);
		Session::set("cmrName",$value['name']);
		header("Location:cart.php");
	
	}else{
		$msg = "<span class='error'>Email hoặc mật khẩu không khớp!</span>";
					return $msg;
	}
	}
	
	public function getCustomerData($id){
		$query = "SELECT * FROM tbl_customer WHERE id = '$id'";
			$result = $this->db->select($query);
			return $result;
	}
	
	public function getCustomerData_Order($id){
		$query = "SELECT * FROM tbl_cus_order WHERE id = '$id'";
			$result = $this->db->select($query);
			return $result;
	}
	
	public function customerUpdate_Order($data,$cmrId){
	
	$name = mysqli_real_escape_string($this->db->link, $data['name']);
	$address = mysqli_real_escape_string($this->db->link, $data['address']);
	$city = mysqli_real_escape_string($this->db->link, $data['city']);
	$country = mysqli_real_escape_string($this->db->link, $data['country']);
	$zip = mysqli_real_escape_string($this->db->link, $data['zip']);
	$phone = mysqli_real_escape_string($this->db->link, $data['phone']);
	$email = mysqli_real_escape_string($this->db->link, $data['email']);
	
	
	if ($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == "") {
		
		$msg = "<span class='error'>Các trường không được trống!</span>";
		return $msg;
	}else{
	
	
		   $query = "INSERT INTO tbl_cus_order(name,address,city,country,zip,phone,email) VALUES('$name','$address','$city','$country','$zip','$phone','$email',)";
	
		$query = "UPDATE tbl_cus_order
	
		SET
		name = '$name',
		address = '$address', 
		city = '$city', 
		country = '$country', 
		zip = '$zip', 
		phone = '$phone', 
		email = '$email' 
	
		WHERE id = '$cmrId'";
	
		$updated_row = $this->db->update($query);
		if ($updated_row) {
			$msg = "<span class='success'>Dữ liệu khách hàng được cập nhật thành công.</span>";
					return $msg;
		} else{
				$msg = "<span class='error'>Dữ liệu khách hàng chưa được cập nhật!</span>";
					return $msg;
		}
	  }
	}

/* public function customerLogin($data){
$email = mysqli_real_escape_string($this->db->link, $data['email']);
$pass = mysqli_real_escape_string($this->db->link, md5($data['pass']));
if (empty($email) || empty($pass)) {
$msg = "<span class='error'>Các trường không được trống!</span>";
	return $msg;
}
$query = "SELECT * FROM tbl_customer WHERE email = '$email' AND pass = '$pass'";
$result = $this->db->select($query);
if ($result != false) {
	$value = $result->fetch_assoc();
	Session::set("cuslogin",true);
	Session::set("cmrId",$value['id']);
	Session::set("cmrName",$value['name']);
	header("Location:cart.php");

}else{
	$msg = "<span class='error'>Email hoặc mật khẩu không khớp!</span>";
				return $msg;
}
} */

/* public function getCustomerData($id){
	$query = "SELECT * FROM tbl_customer WHERE id = '$id'";
		$result = $this->db->select($query);
		return $result;
}

public function getCustomerData_Order($id){
	$query = "SELECT * FROM tbl_cus_order WHERE id = '$id'";
		$result = $this->db->select($query);
		return $result;
}
 */
public function customerUpdate($data,$cmrId){

$name = mysqli_real_escape_string($this->db->link, $data['name']);
$address = mysqli_real_escape_string($this->db->link, $data['address']);
$city = mysqli_real_escape_string($this->db->link, $data['city']);
$country = mysqli_real_escape_string($this->db->link, $data['country']);
$zip = mysqli_real_escape_string($this->db->link, $data['zip']);
$phone = mysqli_real_escape_string($this->db->link, $data['phone']);
$email = mysqli_real_escape_string($this->db->link, $data['email']);


if ($name == "" || $address == "" || $city == "" || $country == "" || $zip == "" || $phone == "" || $email == "") {
	
	$msg = "<span class='error'>Các trường không được trống!</span>";
	return $msg;
}else{


  	 $query = "INSERT INTO tbl_customer(name,address,city,country,zip,phone,email) VALUES('$name','$address','$city','$country','$zip','$phone','$email',)";

	$query = "UPDATE tbl_customer

	SET
	name = '$name',
	address = '$address', 
	city = '$city', 
	country = '$country', 
	zip = '$zip', 
	phone = '$phone', 
	email = '$email' 

	WHERE id = '$cmrId'";

	$updated_row = $this->db->update($query);
	if ($updated_row) {
		$msg = "<span class='success'>Dữ liệu khách hàng được cập nhật thành công.</span>";
				return $msg;
	} else{
			$msg = "<span class='error'>Dữ liệu khách hàng chưa được cập nhật!</span>";
				return $msg;
	}
  }
}

}


?>