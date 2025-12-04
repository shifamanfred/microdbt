<?php

$title = "Admin | Welcome | Your loan gateway system";
$page = 'products';
$sub_page = 'add_product';

include 'pages/header.php';
include 'pages/classes.php';
?>

<?php include "pages/sidebar.php"; ?>

<?php
if (isset($_GET['code'])) {
  $pro_obj = new Product($connect, $_GET['code']);
} else {
  $pro_obj = null;
}

?>

<div class="container-fluid">

	<section id="main-content">
		<section class="wrapper">
			<div class="col-lg-12 mt">
				<div class="row content-panel">
					<div class="col-lg-10 col-lg-offset-1">
						<div class="invoice-body">
							<div class="pull-left">
								<h1 class="page-header">Update Product: <a href="manage_product.php" class="btn btn-success pull-right"> <i class="fa fa-reply"> </i>Manage Product</a></h1>
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

                  <?php if ($pro_obj == null ) {?>
                  <div class="alert alert-danger alert-dismissible mt" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    Unexpected Error Occured!
                  </div>
                  <?php } else { ?>
									<form action="proc_form.php?ops=edit+product&code=<?php $pro_obj->code; ?>" id="product-form" method="post" class="form-horizontal myaccount" role="form">
										<div class="load-animate">
											<div class="form-group">
												<span for="productCode" class="col-sm-4 control-span">Product Code &nbsp;&nbsp;&nbsp;<abbr class="req" title="required">*</abbr></span>
												<div class="col-sm-8">

                          <?php
                          $set = new CompanySettings($connect);
                          ?>
													<input value="<?php echo $pro_obj->code; ?>" name="productCode" id="productCode" type="text" class="form-control">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<span for="productName" class="col-sm-4 control-span"> Product Name &nbsp;&nbsp;&nbsp;<abbr class="req" title="required">*</abbr></span>
												<div class="col-sm-8">
													<input value="<?php echo $pro_obj->pro_name; ?>" name="productName" id="productName" type="text" class="form-control">
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<span for="productDescription" class="col-sm-4 control-span"> Product Description</span>
												<div class="col-sm-8">
													<textarea name="productDescription" id="productDescription" class="form-control" rows="3"><?php echo $pro_obj->pro_desc; ?></textarea>
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<span for="quantityInStock" class="col-sm-4 control-span"> Quantity </span>
												<div class="col-sm-8">
													<input value="<?php $pro_obj->quantity; ?>" name="quantityInStock" id="quantityInStock" type="text" class="form-control">
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
													<input value="<?php echo $pro_obj->mrp; ?>" name="mrp" id="mrp" type="text" class="form-control">
													<span class="help-block"></span>
												</div>
											</div>
											<input type="hidden" id="id" name="id" value="">
											<div class="form-group">
												<div class="col-sm-offset-4 col-sm-8">
													<button id="submit_btn" type="submit" class="btn btn-primary">Save Changes</button>
												</div>
											</div>
										</div>
									</form>
                  <?php } ?>
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
