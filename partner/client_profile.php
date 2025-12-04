<?php
$page = 'customer_management';
$sub_page = 'client_profile';
$title = "Admin | Welcome | Your loan gateway system";

include 'includes/header.php';
include 'includes/classes.php';

if (isset($_GET['id'])) {
  $client_id = $_GET['id'];
} else if(isset($_GET['id_num'])) {
  $client_id = $_GET['id_num'];
} else {
  $client_id = 1;
}

$borrower_obj = new Borrower($connect, $client_id);

?>

<aside>
  <div id="sidebar" class="nav-collapse ">
    <!-- sidebar menu start-->
    <ul class="sidebar-menu" id="nav-accordion">
      <p class="centered"><a href="client_profile.php"><img src="../img/ui-sam.jpg" class="img-circle" width="80"></a></p>
      <h5 class="centered"><?php echo $company ?></h5>
      <li class="sub-menu">
        <a class="<?php echo isset($page) && $page == 'partner' ? 'active' : '' ?>" href="manage_clients.php">
          <span><i class="fa fa-chevron-left"></i> Customer Management</span>
        </a>
      </li>
    </ul>
    <!-- sidebar menu end-->
  </div>
</aside>

<section id="main-content">
  <section class="wrapper site-min-height">
    <div class="row mt">
      <div class="col-lg-12">
        <div class="row content-panel">
          <!-- /col-md-4 -->
          <div class="col-md-4 centered">
            <div class="profile-pic">
              <p><img src="../img/ui-sam.jpg" class="img-circle"></p>
              <p>
                <button class="btn btn-theme"><i class="fa fa-check"></i> Follow</button>
                <button class="btn btn-theme02">Add</button>
              </p>
            </div>
          </div>

          <!-- /col-md-4 -->
          <div class="col-md-8 profile-text">
            <h3><?php echo $borrower_obj->name . ' ' . $borrower_obj->last_name; ?></h3>
            <p><strong>ID Number: </strong> <?php echo $borrower_obj->id_num; ?> </p>
            <p><strong>Email: </strong> <?php echo $borrower_obj->email; ?> </p>
            <br>
            <p><button class="btn btn-theme03"><i class="fa fa-money"></i> Issue Loan</button></p>
          </div>

          <!-- /col-md-4 -->
        </div>
        <!-- /row -->
      </div>

      <div class="col-lg-12 mt">
        <div class="row content-panel">
          <?php
          if (isset($_GET['mode'])) {
            switch ($_GET['mode']) {
              case 'contact':
                $mode = 'contact';
                break;

              case 'edit':
                $mode = 'edit';
                break;

              default:
                $mode = 'overview';
                // code...
                break;
            }
          } else {
            $mode = 'overview';
          }
          ?>
          <div class="panel-heading">
            <ul class="nav nav-tabs nav-justified">
              <li class="<?php echo ($mode == 'overview') ? 'active' : ''; ?>">
                <a data-toggle="tab" href="#overview">Overview</a>
              </li>
              <li class="<?php echo ($mode == 'credit') ? 'active' : ''; ?>">
                <a data-toggle="tab" href="#credit">Credit History</a>
              </li>
              <li class="<?php echo ($mode == 'contact') ? 'active' : ''; ?>">
                <a data-toggle="tab" href="#contact" class="contact-map">Contact</a>
              </li>
              <li class="<?php echo ($mode == 'edit') ? 'active' : ''; ?>">
                <a data-toggle="tab" href="#edit">Edit Profile</a>
              </li>
            </ul>
          </div>
          <div class="panel-body">
            <div class="tab-content">
              <div id="overview" class="tab-pane <?php echo ($mode == 'overview') ? 'active' : ''; ?>">
                <div class="row">
                  <div class="col-md-8 detailed">
                    <h4>Financial Overview</h4>
                    <div class="row centered mt mb">
                      <div class="col-sm-4">
                        <h1><i class="fa fa-money"></i></h1>
                        <h3>$ <?php echo $borrower_obj->total_loans; ?></h3>
                        <h6>CURRENT LOANS (REPAYABLE)</h6>
                      </div>
                      <div class="col-sm-4">
                        <h1><i class="fa fa-shopping-cart"></i></h1>
                        <h3>$ <?php echo $borrower_obj->total_expenses; ?></h3>
                        <h6>TOTAL EXPENSES</h6> <!-- kindly include the current loans on this system for the customer -->
                      </div>
                      <div class="col-sm-4">
                        <h1><i class="fa fa-credit-card"></i></h1>
                        <h3>$ <?php echo $borrower_obj->net_salary; ?></h3>
                        <h6>NET SALARY</h6>
                      </div>
                    </div>
                    <!-- /row -->
                    <!-- /row -->
                    <h4>Loan History</h4>
                    <?php
                    $result = LoanAccount::getBorrowerLoanRecords($connect, $borrower_obj->id);

                    if (!$result) {
                      echo '<span class="text-danger">DATABASE error! Please contact the webmaster. </span>';
                      $loan_obj = null;
                    } else {
                      if ($row = $result->fetch_assoc()) {
                        $loan_obj = new LoanAccount($connect, $row['account_id']);
                      } else {
                        $loan_obj = null;
                      }
                    }

                    if ($loan_obj != null) {
                    ?>
                    <div class="row left">
                      <div class="col-md-10 col-md-offset-1">
                        <div class="group-rom data">
                          <div class="first-part"><strong>Date (Loan was Taken)</strong></div>
                          <div class="second-part"><?php echo date_format(date_create($loan_obj->disbursed_date), 'd F Y'); ?></div>
                        </div>
                        <?php
                        // Get Creditor name
                        $partner_obj = $loan_obj->getPartnerObject($connect);
                        ?>
                        <div class="group-rom data">
                          <div class="first-part"><strong>Creditor</strong></div>
                          <div class="second-part"><?php echo $partner_obj->business_name; ?></div>
                        </div>
                        <div class="group-rom data">
                          <div class="first-part"><strong>Total Loan (Repayable)</strong></div>
                          <div class="second-part"><?php echo $loan_obj->total_loan; ?></div>
                        </div>
                        <div class="group-rom data">
                          <div class="first-part"><strong>Total Outstanding</strong></div>
                          <div class="second-part"><?php echo $loan_obj->total_remain; ?></div>
                        </div>
                      </div>
                      <!-- /col-md-8 -->
                    </div>
                    <!-- /row -->
                    <?php } ?>

                    <!-- Payment History -->
                    <h4 class="mt" style="margin-top: 20px;">Payment History</h4>
                    <div class="row left">
                      <div class="col-md-10 col-md-offset-1">
                        <div class="group-rom data">
                          <div class="first-part"><strong>Payment Pattern</strong></div>
                          <div class="second-part">[data]</div>
                        </div>

                        <div class="group-rom data">
                          <div class="first-part"><strong>Frequency of Payment</strong></div>
                          <div class="second-part">[data]</div>
                        </div>

                        <div class="group-rom data">
                          <div class="first-part"><strong>Blacklisting</strong></div>
                          <div class="second-part">[data]</div>
                        </div>

                        <div class="group-rom data">
                          <div class="first-part"><strong>Risk Analysis</strong></div>
                          <div class="second-part">[data]</div>
                        </div>
                      </div>
                      <!-- /col-md-8 -->
                    </div>
                  </div>
                  <!-- /col-md-6 -->

                  <div class="col-md-4">
                    <div class="detailed mt">
                      <h4>Financial Qualifying Amounts</h4>
                      <div class="recent-activity">
                        <div class="activity-panel">
                          <h5>6 Months</h5>
                          <p>N$0000.00</p>
                        </div>
                        <div class="activity-panel">
                          <h5>5 Months</h5>
                          <p>N$0000.00</p>
                        </div>
                        <div class="activity-panel">
                          <h5>4 Months</h5>
                          <p>N$0000.00</p>
                        </div>
                        <div class="activity-panel">
                          <h5>3 Months</h5>
                          <p>N$0000.00</p>
                        </div>
                        <div class="activity-panel">
                          <h5>2 Months</h5>
                          <p>N$0000.00</p>
                        </div>
                        <div class="activity-panel">
                          <h5>Short Term</h5>
                          <p>N$0000.000</p>
                        </div>
                      </div>
                      <!-- /recent-activity -->
                    </div>
                    <!-- /detailed -->
                  </div>
                </div>
                <!-- /row -->
              </div>
              <!-- /tab-pane -->

              <div id="credit" class="tab-pane <?php echo ($mode == 'credit') ? 'active' : ''; ?>">
                <div class="row">
                  <div class="col-md-8 detailed">
                    <h4>Partners Owed</h4>
                    <div class="row centered mt mb">
                      <div class="col-sm-4">
                        <h1><i class="fa fa-money"></i></h1>
                        <h4>0</h4>
                        <h6>Number of Partners</h6>
                      </div>
                      <div class="col-sm-4">
                        <h1><i class="fa fa-shopping-cart"></i></h1>
                        <h4>0</h4>
                        <h6>Closed Loans</h6>
                      </div>
                      <div class="col-sm-4">
                        <h1><i class="fa fa-credit-card"></i></h1>
                        <h4>0</h4>
                        <h6>Complaints</h6>
                      </div>
                      <div class="col-sm-4">
                        <h1><i class="fa fa-credit-card"></i></h1>
                        <h4>0</h4>
                        <h6>Outstanding Loans</h6>
                      </div>
                    </div>
                    <!-- /row -->
                    <!-- /row -->
                    <h4>Credit Risk</h4>
                    <div class="row left">
                      <div class="col-md-8 col-md-offset-2">
                        <h5>Date</h5>
                        <div class="">

                        </div>

                        <h5>Arranged Payments</h5>
                        <div class="">

                        </div>
                        <h5>Declined Applications</h5>
                        <div class="">

                        </div>
                        <h5>Reported Cases</h5>
                        <div class="">

                        </div>
                      </div>
                      <!-- /col-md-8 -->
                    </div>
                    <!-- /row -->

                    <!-- Payment History -->
                    <h4>Partner's Decision</h4>
                    <div class="row left">
                      <div class="col-md-8 col-md-offset-2">
                        <h5>Accept Customer</h5>
                        <div class="">

                        </div>

                        <h5>Buy Out other Partners</h5>
                        <div class="">

                        </div>
                        <h5>Consolidate Loans</h5>
                        <div class="">

                        </div>
                        <h5>Rehabilitate Customer</h5>
                        <div class="">

                        </div>
                      </div>
                      <!-- /col-md-8 -->
                    </div>
                  </div>
                  <!-- /col-md-6 -->

                  <div class="col-md-4">
                    <div class="detailed mt">
                      <h4>Recent Activity</h4>
                      <div class="recent-activity">
                        <div class="activity-panel">
                          <h5>Date</h5>
                          <p>Approved/Declined by (Partner)<!-- Please show this information on recent activities of the client --></p>
                        </div>
                        <div class="activity-panel">
                          <h5>Reasons</h5>
                          <p><!-- Please insert comment box for partners to give when declining loans -->Over committed with financial burdens</p>
                        </div>
                        <div class="activity-panel">
                          <h5>Helped By</h5>
                          <p>Employee of the Partner as well as the Partner Name</p>
                        </div>
                        <div class="activity-panel">
                          <h5>Any other information</h5>
                          <p>Employee of the Partner as well as the Partner Name</p>
                        </div>
                        <div class="activity-panel">
                          <h5>Any other Information</h5>
                          <p>Employee of the Partner as well as the Partner Name</p>
                        </div>
                      </div>
                      <!-- /recent-activity -->
                    </div>
                    <!-- /detailed -->
                  </div>
                </div>
                <!-- /row -->
              </div>
              <!-- /tab-pane -->

              <div id="contact" class="tab-pane <?php echo ($mode == 'contact') ? 'active' : ''; ?>">
                <div class="row mb">
                  <!-- /col-md-6 -->
                  <div class="col-md-10 col-md-offset-1 detailed">
                    <h4>Location</h4>
                    <div class="col-md-10 col-md-offset-1 row">
                      <div class="group-rom data">
                        <div class="first-part">Postal Address: </div>
                        <div class="second-part"><?php echo $borrower_obj->address; ?></div>
                      </div>
                      <div class="group-rom data">
                        <div class="first-part">Physical Address: </div>
                        <div class="second-part"><?php echo $borrower_obj->address2; ?></div>
                      </div>
                    </div>

                    <div class="clearfix mb"></div>

                    <h4>Contact Information</h4>
                    <div class="col-md-10 col-md-offset-1 row">
                      <div class="group-rom data">
                        <div class="first-part">Phone:</div>
                        <div class="second-part"><?php echo $borrower_obj->phone; ?></div>
                      </div>
                      <div class="group-rom data">
                        <div class="first-part">Email:</div>
                        <div class="second-part"><?php echo $borrower_obj->email; ?></div>
                      </div>
                    </div>
                  </div>
                  <!-- /col-md-6 -->
                </div>
                <!-- /row -->
              </div>
              <!-- /tab-pane -->



              <!-- /tab-pane -->
              <div id="edit" class="tab-pane <?php echo ($mode == 'edit') ? 'active' : ''; ?>">
                <div class="row">
                  <div class="col-lg-8 col-lg-offset-2 detailed">
                    <?php include 'includes/alert_dialog.php'; ?>
                    <h4 class="mb">Personal Information</h4>
                    <form action="proc_form.php?ops=add+client&part_id=<?php echo $part_id ?>&submit=edit" role="form" class="form-horizontal" method="post">
                      <div class="form-group">
                        <label class="col-sm-4 control-label"> Avatar</label>
                        <div class="col-sm-8">
                          <input type="file" id="exampleInputFile" class="file-pos">
                        </div>
                      </div>
                      <div id="client-id" class="form-group">
												<span for="customerID" class="col-sm-4 control-span">Customer ID / Passport No:</span>
												<div class="col-sm-8">
													<input value="<?php echo $borrower_obj->id_num; ?>" name="customer_id" id="customerID" type="text" class="form-control" placeholder="ID or Passport Number">
													<small id="customerIDHelp" class="help-block"></small>
												</div>
											</div>
                      <div id="customer-details-container">
                        <div class="form-group">
  												<span for="customerName" class="col-sm-4 control-span">Customer Name</span>
  												<div class="col-sm-8">
  													<input value="<?php echo $borrower_obj->name . ' ' . $borrower_obj->last_name; ?>" name="customer_name" id="customerName" type="text" class="form-control" placeholder="First Name and Surname">
  													<span class="help-block"></span>
  												</div>
  											</div>

  											<div class="form-group">
  												<span for="customerGender" class="col-sm-4 control-span">Gender</span>
  												<div class="col-sm-8">
  													<select id="customerGender" class="form-control" name="borrower_gender">
  														<option value="Male" <?php echo strtoupper($borrower_obj->gender) == 'MALE' ? 'selected' : '' ?>>Male</option>
  														<option value="Female" <?php echo strtoupper($borrower_obj->gender) == 'FEMALE' ? 'selected' : '' ?>>Female</option>
  													</select>
  												</div>
  											</div>

                        <div class="form-group">
                          <label class="col-sm-4 control-label">Marital Status</label>
                          <div class="col-sm-8">
                            <label class="checkbox-inline">
                              <input type="radio" id="inlineCheckbox1" value="single" name="marital" <?php echo strtoupper($borrower_obj->marital) == 'SINGLE' ? 'checked': ''; ?>> Single
                            </label>
                            <label class="checkbox-inline">
                              <input type="radio" id="inlineCheckbox2" value="married" name="marital" <?php echo strtoupper($borrower_obj->marital) == 'MARRIED' ? 'checked': ''; ?>> Married
                            </label>
                            <label class="checkbox-inline">
                              <input type="radio" id="inlineCheckbox3" value="divorced" name="marital" <?php echo strtoupper($borrower_obj->marital) == 'DIVORCED' ? 'checked': ''; ?>> Divorced
                            </label>
                            <label class="checkbox-inline">
                              <input type="radio" id="inlineCheckbox3" value="widowed" name="marital" <?php echo strtoupper($borrower_obj->marital) == 'WIDOWED' ? 'checked': ''; ?>> Widowed
                            </label>
                          </div>
                        </div>

  											<div class="form-group">
  												<span for="customerName" class="col-sm-4 control-span">Date of Birth</span>
  												<div class="col-sm-8">
  													<input type="date" name="borrower_dob" class="form-control is-datepick" id="inputBorrowerDob" value="<?php echo $borrower_obj->dob ?>">
  													<span class="help-block"></span>
  												</div>
  											</div>

  											<div class="form-group">
  												<span for="phone" class="col-sm-4 control-span"> Phone Number </span>
  												<div class="col-sm-8">
  													<input value="<?php echo $borrower_obj->phone; ?>" name="phone" id="phone" type="text" class="form-control" placeholder="e.g. +264812345678 or 0812345678">
  													<span class="help-block"></span>
  												</div>
  											</div>
  											<div class="form-group">
  												<span for="addressLine1" class="col-sm-4 control-span"> Address Line1</span>
  												<div class="col-sm-8">
  													<textarea name="address_line1" id="addressLine1" class="form-control" rows="3" placeholder="Postal Address"><?php echo $borrower_obj->address; ?></textarea>
  													<span class="help-block"></span>
  												</div>
  											</div>
  											<div class="form-group">
  												<span for="addressLine2" class="col-sm-4 control-span"> Address Line2 </span>
  												<div class="col-sm-8">
  													<textarea name="address_line2" id="addressLine2" class="form-control" rows="3" placeholder="Street Address"><?php echo $borrower_obj->address2; ?></textarea>
  													<span class="help-block"></span>
  												</div>
  											</div>

  											<div class="form-group">
                          <span for="customerName" class="col-sm-4 control-span">Email</span>
                          <div class="col-sm-8">
                            <input value="<?php echo $borrower_obj->email; ?>" name="customer_email" id="customer_email" type="text" class="form-control" placeholder="Customer's Email">
                            <span class="help-block"></span>
                          </div>
                        </div>

  											<div class="form-group">
  												<span for="city" class="col-sm-4 control-span"> City Name</span>
  												<div class="col-sm-8">
  													<input value="<?php echo $borrower_obj->city; ?>" name="city" id="city" type="text" class="form-control" placeholder="City">
  													<span class="help-block"></span>
  												</div>
  											</div>
  											<div class="form-group">
  												<span for="state" class="col-sm-4 control-span"> Region </span>
  												<div class="col-sm-8">
  													<input value="<?php echo $borrower_obj->region; ?>" name="state" id="state" type="text" class="form-control" placeholder="Name of Region">
  													<span class="help-block"></span>
  												</div>
  											</div>
  											<div class="form-group">
  												<span for="country" class="col-sm-4 control-span"> Country </span>
  												<div class="col-sm-8">
  													<select name="country" id="country" class="form-control">
  														<option value="">Choose Country</option>
  														<option value="Angola" <?php echo strtolower($borrower_obj->country) == 'angola' ? 'selected' : ''; ?>>Angola</option>
  														<option value="Botswana" <?php echo strtolower($borrower_obj->country) == 'botswana' ? 'selected' : ''; ?>>Botswana</option>
  														<option value="Namibia" <?php echo strtolower($borrower_obj->country) == 'namibia' ? 'selected' : ''; ?>>Namibia</option>
  														<option value="South Africa" <?php echo strtolower($borrower_obj->country) == 'south africa' ? 'selected' : ''; ?>>South Africa</option>
  														<option value="Zambia" <?php echo strtolower($borrower_obj->country) == 'zambia' ? 'selected' : ''; ?>>Zambia</option>
  														<option value="Zimbabwe" <?php echo strtolower($borrower_obj->country) == 'zimbabwe' ? 'selected' : ''; ?>>Zimbabwe</option>
  													</select>
  													<span class="help-block"></span>
  												</div>
  											</div>

                        <div class="form-group">
  												<span for="country" class="col-sm-4 control-span"> Employment Status </span>
  												<div class="col-sm-8">
                            <select class="form-control" name="borrower_working_status" id="inputBorrowerEORS">
                              <option value="Employee" <?php echo strtolower($borrower_obj->working_status) == 'employee' ? 'selected' : ''; ?>>Employee</option>
                              <option value="Owner <?php echo strtolower($borrower_obj->working_status) == 'owner' ? 'selected' : ''; ?>">Owner</option>
                              <option value="Student <?php echo strtolower($borrower_obj->working_status) == 'student' ? 'selected' : ''; ?>">Student</option>
                              <option value="Unemployed <?php echo strtolower($borrower_obj->working_status) == 'unemployed' ? 'selected' : ''; ?>">Unemployed</option>
                              <option value="other <?php echo strtolower($borrower_obj->working_status) == 'other' ? 'selected' : ''; ?>">Other</option>
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
  											<input type="hidden" id="id" name="id" value="<?php echo $borrower_obj->id; ?>">
  											<div class="form-group">
  												<div class="col-sm-offset-4 col-sm-8 text-center">
  													<button id="submit_btn" type="submit" class="btn btn-theme02" style="width: 120px;">Save</button>
                            <a id="cancel_btn" data-toggle="tab" href="#overview" class="btn btn-theme04" style="width: 120px;">Cancel</a>
  												</div>
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
                    </form>
                  </div>
                  <div class="col-lg-8 col-lg-offset-2 detailed mt text-center">
                    <h4 class="mb">Work Information <a href="work_details.php?client_id=<?php echo $borrower_obj->id; ?>" class="btn btn-default pull-right"> <i class="fa fa-pencil-square-o"></i> </a></h4>

                  </div>

                  <div class="col-lg-8 col-lg-offset-2 detailed mt text-center">
                    <h4 class="mb">Financial Information <a href="financial_details.php?client_id=<?php echo $borrower_obj->id; ?>" class="btn btn-default pull-right"> <i class="fa fa-pencil-square-o"></i> </a></h4>

                  </div>
                  <!-- /col-lg-8 -->
                </div>
                <!-- /row -->
              </div>
              <!-- /tab-pane -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</section>

<?php $page = $sub_page; ?>

<?php require "includes/footer.php"; ?>
