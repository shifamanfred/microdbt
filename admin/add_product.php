<?php

$title = "Admin | Welcome | Your loan gateway system";
$page = 'products';
$sub_page = 'add_product';

include 'pages/header.php';
include 'pages/classes.php';
?>

<?php include "pages/sidebar.php"; ?>

<?php
?>

<div class="container-fluid">

	<section id="main-content">
		<section class="wrapper">
			<div class="col-lg-12 mt">
				<div class="row content-panel">
					<div class="col-lg-10 col-lg-offset-1">
						<div class="invoice-body">
							<div class="pull-left">
								<h1 class="page-header">Add Product: <a href="manage_product.php" class="btn btn-success pull-right"> <i class="fa fa-reply"> </i>Manage Product</a></h1>
								<div class="col-xs-9 col-sm-10 col-md-10 col-lg-10 col-xs-offset-3 col-sm-offset-2 col-md-offset-2 col-lg-offset-2 main">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:20px;">
											<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
											<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-4997600402648823" data-ad-slot="1675608998"></ins>
											<script>
											(adsbygoogle = window.adsbygoogle || []).push({});
											</script>
										</div>
									</div>

									<form action="proc_form.php?ops=add+product" id="product-form" method="post" class="form-horizontal myaccount" role="form">
										<div class="load-animate">
											<div class="form-group">
												<span for="productCode" class="col-sm-4 control-span">Product Code &nbsp;&nbsp;&nbsp;<abbr class="req" title="required">*</abbr></span>
												<div class="col-sm-8">

                          <?php
                          // autogen product code based on type of product and product count
                          $sql = 'SELECT COUNT(*) AS "pro_num" FROM products;';

                          $product_number = (mysqli_fetch_assoc(mysqli_query($connect, $sql))['pro_num']) + 1;

                          $set = new CompanySettings($connect);
                          ?>
													<input value="<?php echo $formatted_value = sprintf("LN%03d", $product_number); ?>" name="productCode" id="productCode" type="text" class="form-control">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<span for="productName" class="col-sm-4 control-span"> Product Name &nbsp;&nbsp;&nbsp;<abbr class="req" title="required">*</abbr></span>
												<div class="col-sm-8">
													<input value="" name="productName" id="productName" type="text" class="form-control">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<span for="productDescription" class="col-sm-4 control-span"> Product Description</span>
												<div class="col-sm-8">
													<textarea name="productDescription" id="productDescription" class="form-control" rows="3"></textarea>
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<span for="quantityInStock" class="col-sm-4 control-span"> Quantity </span>
												<div class="col-sm-8">
													<input value="" name="quantityInStock" id="quantityInStock" type="text" class="form-control">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<span for="buyPrice" class="col-sm-4 control-span"> Buy Price <?php echo $set->getCurrency(); ?></span>
												<div class="col-sm-8">
													<input value="" name="buyPrice" id="buyPrice" type="text" class="form-control">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<span for="mrp" class="col-sm-4 control-span"> MRP <?php echo $set->getCurrency(); ?></span>
												<div class="col-sm-8">
													<input value="" name="mrp" id="mrp" type="text" class="form-control">
													<span class="help-block"></span>
												</div>
											</div>
											<input type="hidden" id="id" name="id" value="">
											<div class="form-group">
												<div class="col-sm-offset-4 col-sm-8">
													<button id="submit_btn" type="submit" class="btn btn-primary">Save Product</button>
												</div>
											</div>
										</div>
									</form>
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
											<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
											<ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-4997600402648823" data-ad-slot="1675608998"></ins>
											<script>
											(adsbygoogle = window.adsbygoogle || []).push({});
											</script>
										</div>
									</div>
								</div>
							</div>
							<script src="js/jquery.validate.min.js"></script>
							<script src="js/add-product.js"></script>
						</div>
					</div>
				</div>
			</div>
		</section>
	</section>




	<?php require "pages/footer.php"; ?>
