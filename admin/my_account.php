<?php

$title = "Admin | Welcome | Your loan gateway system";
include 'pages/header.php';
?>

<?php include "pages/sidebar.php"; ?>
			<section id="main-content">
				<section class="wrapper">
					<div class="col-lg-12 mt">
						<div class="row content-panel">
							<div class="col-lg-10 col-lg-offset-1">
								<div class="invoice-body">
									<div class="pull-left">
										<div class="container-fluid">
											<h1 class="page-header">My Account: <a href="invoice.php" class="btn btn-success pull-right"> <i class="fa fa-edit"> </i>Create New Invoice</a></h1>
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
												<form action="/invoice-script-php/account.php" id="account-form" method="post" class="form-horizontal myaccount" role="form">
													<div class="load-animate">
														<div class="form-group">
															<span for="inputEmail3" class="col-sm-4 control-span">Name</span>
															<div class="col-sm-8">
																<p> <!-- echo the name of the current user here --> </p>
															</div>
														</div>
														<div class="form-group">
															<span for="inputPassword3" class="col-sm-4 control-span">Email</span>
															<div class="col-sm-8">
																<p> <!-- echo an email of the current user here --> </p>
															</div>
														</div>
														<hr>
														<div class="form-group">
															<span for="inputPassword3" class="col-sm-4 control-span">Current Password</span>
															<div class="col-sm-8">
																<input name="old_password" id="old_password" type="text" class="form-control">
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<span for="inputPassword3" class="col-sm-4 control-span"> New Password</span>
															<div class="col-sm-8">
																<input name="password" id="password" type="text" class="form-control">
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<span for="inputPassword3" class="col-sm-4 control-span"> Confirm Password</span>
															<div class="col-sm-8">
																<input name="confirm_password" id="confirm_password" type="text" class="form-control">
																<span class="help-block"></span>
															</div>
														</div>
														<input type="hidden" id="user_id" name="user_id" value="">
														<input type="hidden" id="email" value="muni@smartinvoice.com" class="form-control"/>
														<div class="form-group">
															<div class="col-sm-offset-4 col-sm-8">
																<button type="submit" class="btn btn-default">Change Password</button>
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
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</section>

<?php require "pages/footer.php"; ?>