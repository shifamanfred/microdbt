<?php
$title = "Add Client";
$page = 'customer_management';
$sub_page = 'add_client';
include 'includes/header.php';
include 'includes/classes.php';
?>

<?php include "includes/sidebar.php"; ?>

<section id="main-content">
	<section class="wrapper">
		<div class="col-lg-12 mt">
			<div class="row content-panel">
				<div class="col-lg-10 col-lg-offset-1">
					<?php include 'includes/top_panel.php'; ?>
					<div class="invoice-body">
						<div class="pull-left">
							<div class="container-fluid">
                <?php include "includes/alert_dialog.php"; ?>
								<h1 class="page-header">Add Client: <a href="manage_clients.php" class="btn btn-success pull-right"> <i class="fa fa-chevron-left"></i> Manage Client</a></h1>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main">
									<form action="proc_form.php?ops=add+client&part_id=<?php echo $part_id ?>" id="product-form" method="post" class="form-horizontal myaccount" role="form">
										<div class="load-animate">
											<div id="client-id" class="form-group">
												<span for="customerID" class="col-sm-4 control-span">Customer ID / Passport No:</span>
												<div class="col-sm-8">
													<input value="<?php echo isset($_GET['id_num']) ? $_GET['id_num'] : ''; ?>" name="customer_id" id="customerID" type="text" class="form-control" placeholder="ID or Passport Number">
													<small id="customerIDHelp" class="help-block"></small>
												</div>
                        <a href="#" id="btn-edit" class="btn btn-theme02"><i class="fa fa-pencil-square-o"></i></a>
											</div>
                      <div id="customer-details-container">
                        <div class="form-group">
  												<span for="customerName" class="col-sm-4 control-span">Customer Name</span>
  												<div class="col-sm-8">
  													<input value="" name="customer_name" id="customerName" type="text" class="form-control" placeholder="First Name and Surname">
  													<span class="help-block"></span>
  												</div>
  											</div>

  											<div class="form-group">
  												<span for="customerGender" class="col-sm-4 control-span">Gender</span>
  												<div class="col-sm-8">
  													<select id="customerGender" class="form-control" name="borrower_gender">
  														<option value="Male">Male</option>
  														<option value="Female">Female</option>
  													</select>
  												</div>
  											</div>

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Marital Status</label>
                          <div class="col-sm-8">
                            <label class="checkbox-inline">
                              <input type="radio" id="inlineCheckbox1" value="single" name="marital"> Single
                            </label>
                            <label class="checkbox-inline">
                              <input type="radio" id="inlineCheckbox2" value="married" name="marital"> Married
                            </label>
                            <label class="checkbox-inline">
                              <input type="radio" id="inlineCheckbox3" value="divorced" name="marital"> Divorced
                            </label>
                            <label class="checkbox-inline">
                              <input type="radio" id="inlineCheckbox3" value="widowed" name="marital"> Widowed
                            </label>
                          </div>
                        </div>

  											<div class="form-group">
  												<span for="customerName" class="col-sm-4 control-span">Date of Birth</span>
  												<div class="col-sm-8">
  													<input type="date" name="borrower_dob" class="form-control is-datepick" id="inputBorrowerDob" value="">
  													<span class="help-block"></span>
  												</div>
  											</div>

  											<div class="form-group">
  												<span for="phone" class="col-sm-4 control-span"> Phone Number </span>
  												<div class="col-sm-8">
  													<input value="" name="phone" id="phone" type="text" class="form-control" placeholder="e.g. +264812345678 or 0812345678">
  													<span class="help-block"></span>
  												</div>
  											</div>
  											<div class="form-group">
  												<span for="addressLine1" class="col-sm-4 control-span"> Postal Address</span>
  												<div class="col-sm-8">
  													<textarea name="address_line1" id="addressLine1" class="form-control" rows="3" placeholder="Postal Address"></textarea>
  													<span class="help-block"></span>
  												</div>
  											</div>
  											<div class="form-group">
  												<span for="addressLine2" class="col-sm-4 control-span"> Physical Address </span>
  												<div class="col-sm-8">
  													<textarea name="address_line2" id="addressLine2" class="form-control" rows="3" placeholder="Street Address">  </textarea>
  													<span class="help-block"></span>
  												</div>
  											</div>

  											<div class="form-group">
                          <span for="customerName" class="col-sm-4 control-span">Email</span>
                          <div class="col-sm-8">
                            <input value="" name="customer_email" id="customer_email" type="text" class="form-control" placeholder="Customer's Email">
                            <span class="help-block"></span>
                          </div>
                        </div>

  											<div class="form-group">
  												<span for="city" class="col-sm-4 control-span"> City Name</span>
  												<div class="col-sm-8">
  													<input value="" name="city" id="city" type="text" class="form-control" placeholder="City">
  													<span class="help-block"></span>
  												</div>
  											</div>
  											<div class="form-group">
  												<span for="state" class="col-sm-4 control-span"> Region </span>
  												<div class="col-sm-8">
  													<input value="" name="state" id="state" type="text" class="form-control" placeholder="Name of Region">
  													<span class="help-block"></span>
  												</div>
  											</div>
  											<div class="form-group">
  												<span for="country" class="col-sm-4 control-span"> Country </span>
  												<div class="col-sm-8">
  													<select name="country" id="country" class="form-control">
  														<option value="">Choose Country</option>
  														<option value="Angola">Angola</option>
  														<option value="Botswana">Botswana</option>
  														<option value="Namibia">Namibia</option>
  														<option value="South Africa">South Africa</option>
  														<option value="Zambia">Zambia</option>
  														<option value="Zimbabwe">Zimbabwe</option>
  													</select>
  													<span class="help-block"></span>
  												</div>
  											</div>

                        <div class="form-group">
  												<span for="country" class="col-sm-4 control-span"> Employment Status </span>
  												<div class="col-sm-8">
                            <select class="form-control" name="borrower_working_status" id="inputBorrowerEORS">
                              <option value="Employee">Employee</option>
                              <option value="Owner">Owner</option>
                              <option value="Student">Student</option>
                              <option value="Unemployed">Unemployed</option>
                              <option value="other">Other</option>
                            </select>
  													<span class="help-block"></span>
  												</div>
  											</div>

                        <!-- <div class="form-group last col-xs-12 col-sm-12">
                          <label class="control-label col-md-3">Bank Statements</label>
                          <div class="col-md-9">
                            <div class="fileupload fileupload-new" data-provides="fileupload">
                              <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt="" />
                              </div>
                              <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                              <div>
                                <span class="btn btn-theme02 btn-file">
                                  <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                                  <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                                  <input type="file" class="default" />
                                </span>
                                <a href="advanced_form_components.html#" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                              </div>
                            </div>
                          </div>
                        </div> -->

  											<input value="" id="country_hidden" type="hidden" class="form-control">
  											<input type="hidden" id="id" name="id" value="">
  											<div class="form-group">
  												<div class="col-sm-offset-4 col-sm-8 text-center">
  													<button id="submit_btn" type="submit" class="btn btn-theme02" style="width: 150px">Save Client</button>
  												</div>
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
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>


<?php $page = $sub_page; ?>

<?php include "includes/footer.php"; ?>
