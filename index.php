<?php include 'inc/header.php';?>
<?php include 'inc/slider.php';?>

 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    		<h3>Sản phẩm bán chạy nhất</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
	      <div class="section group " style="overflow-x: scroll; display: inline-flex; white-space: nowrap; width: 100%">

	      	<?php
	      	$getFpd = $pd->getFeaturedProduct();
	      	if ($getFpd) {
	      		while ($result = $getFpd->fetch_assoc()) { 
	      
	      			
	      	?>

				<div class="grid_1_of_4 images_1_of_4" style="	display: flex; flex-direction: column; justify-content: space-between; max-height: 500px; max-width: 200px; text-wrap: wrap; /* Sử dụng flex linh hoạt */
  min-width: 250px; /* Đảm bảo mỗi ô có đủ không gian */
  flex-shrink: 0; /* Ngăn chặn co lại quá mức */
  margin-right: 5px;">
					 <a href="details.php?proid=<?php echo $result['productId']; ?>"><img src="admin/<?php echo $result['image']; ?>" alt="" /></a>
					 <h2><?php echo $result['productName']; ?></h2>
					 <p><?php echo $fm->textShorten($result['body'],60); ?></p>
					 <p><span class="price"><?php echo $result['price']; ?> VNĐ</span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>" class="details">Chi tiết</a></span></div>
				</div>
				
				<?php } } ?>
				
			</div>
			<div class="content_bottom">
    		<div class="heading">
    		<h3>Sản phẩm mới</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
			<div class="section group">


	      	<?php
	      	$getNpd = $pd->getNewProduct();
	      	if ($getNpd) {
	      		while ($result = $getNpd->fetch_assoc()) { 
	      			
	      
	      	?>

				<div class="grid_1_of_4 images_1_of_4" >
					 <a href="details.php?proid=<?php echo $result['productId']; ?>"><img class="img1" src="admin/<?php echo $result['image']; ?>" /></a>
					 <h2><?php echo $result['productName']; ?></h2>
					 <p><span class="price"><?php echo $result['price']; ?> VNĐ</span></p>
				     <div class="button"><span><a href="details.php?proid=<?php echo $result['productId']; ?>" class="details">Chi tiết</a></span></div>
				</div>
				<?php } } ?>
		
			</div>
    </div>
 </div>

 <?php include 'inc/footer.php';?>
