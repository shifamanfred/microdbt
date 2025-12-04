<?php
$title = "Financial Details";
$page = "customer_management";
$sub_page = 'financial_details';
$enable_datepicker = true;
include 'includes/header.php';
include 'includes/classes.php';
?>

<?php include "includes/sidebar.php"; ?>

<section id="main-content">
  <section class="wrapper">
    <div class="col-lg-12 mt">
      <div class="row content-panel">
        <div class="col-lg-10 col-lg-offset-1">
          <?php include "includes/top_panel.php"; ?>
          <div class="invoice-body">
            <div class="container-fluid">
              <?php
              if (isset($_GET['msg'])) {
                if (strpos(strtolower($_GET['msg']), 'success') !== false) {
                  ?>
                  <div class="alert alert-success alert-dismissible mt" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $_GET['msg']; ?>
                  </div>
                <?php } else {?>
                  <div class="alert alert-danger alert-dismissible mt" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $_GET['msg']; ?>
                  </div>
                <?php } ?>
              <?php } ?>
              <h1 class="page-header">Financial Details <a href="add-client.php" class="btn btn-success pull-right"> <i class="fa fa-edit"> </i>Add New Client</a></h1>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main">
                <?php $borrower_condition = 'borrowers_added_by_this partner_only'; ?>
                <?php include 'includes/borrower_selector.php'; ?>
                <form action="proc_form.php?ops=financial+details&part_id=<?php echo $part_id; ?>" id="finance-form" method="post" class="form-horizontal myaccount" role="form" enctype="multipart/form-data">
                  <input type="hidden" value="<?php echo ($client_id > 0) && isset($borrower_id) ? $borrower_id : '' ?>" name="borrower_id" required>

                  <?php

                  // get borrower object if borrower id has been found
                  if (($client_id > 0) && isset($borrower_id)) {
                    $borrower_obj = new Borrower($connect, $borrower_id);
                  }

                  ?>

                  <div class="load-animate mt">
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Gross Salary</label>
                      <div class="col-sm-10">
                        <input type="number" step="0.01" class="form-control" placeholder="Gross Salary" name="gross_salary" value="<?php echo isset($borrower_obj) ? $borrower_obj->gross_salary : '0.00'; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="load-animate">
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Net Salary</label>
                      <div class="col-sm-10">
                        <input type="number" step="0.01" class="form-control" placeholder="Net Salary" name="net_salary" value="<?php echo isset($borrower_obj) ? $borrower_obj->net_salary : '0.00'; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="load-animate">
                    <div class="form-group">
                      <label class="control-label col-sm-2 col-sm-2">Pay Date</label>
                      <div class="col-sm-10">
                        <input class="form-control form-control-inline input-medium default-date-picker" size="16" type="text" value="<?php echo isset($borrower_obj) ? date_format(date_create($borrower_obj->pay_date), "m-d-Y") : '' ?>" name="pay_date">
                      </div>
                    </div>
                  </div>

									<div class="load-animate">
                    <div class="form-group">
                      <label class="control-label col-sm-2 col-sm-2">Expenses</label>
                      <div class="col-sm-10">
												<button id="exp-plus" class="btn btn-theme03 btn-sm col-md-2 col-md-offset-1" type="button" value=""><i class="fa fa-plus-square"></i> Expense</button>
                    		<button id="exp-minus" class="btn btn-theme04 btn-sm col-md-2 col-md-offset-1" type="button" value=""><i class="fa fa-minus-square"></i> Expense</button>
                      </div>
                    </div>
                  </div>

                  <div class="load-animate">
										<div id="expense-container">
                    <?php
                    if (isset($borrower_obj)) {

                      foreach ($borrower_obj->expenses_arr as $key => $exp) { ?>
                        <div class="form-group">
                          <label class="col-sm-2 col-sm-2 control-label">Expense <?php echo $key + 1; ?></label>
                          <div class="col-sm-10">
                            <input type="number" step="0.01" class="form-control" placeholder="Expense 1 Amount" name="expenses[]" value="<?php echo $exp; ?>">
                          </div>
                        </div>
                      <?php
                      }
                    }?>

                    </div>
                  </div>

                  <div class="load-animate">
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Bank</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Bank Name" name="bank" value="<?php echo isset($borrower_obj) ? $borrower_obj->bank : '' ?>">
                      </div>
                    </div>
                  </div>

                  <div class="load-animate">
                    <div class="form-group row">
                      <label class="col-sm-2">Branch</label>
                      <div class="col-sm-8">
                        <label class="sr-only" for="exampleInputEmail2">Branch</label>
                        <input type="text" class="form-control" placeholder="Branch" name="branch" value="<?php echo isset($borrower_obj) ? $borrower_obj->branch : '' ?>">
                      </div>
                      <div class="col-sm-2">
                        <label class="sr-only" for="exampleInputPassword2">Branch Code</label>
                        <input type="number" class="form-control" placeholder="Code" name="branch_code" value="<?php echo isset($borrower_obj) ? $borrower_obj->branch_code : '' ?>">
                      </div>
                    </div>
                  </div>

                  <div class="load-animate">
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Account Number</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Account Number" name="account_number" value="<?php echo isset($borrower_obj) ? $borrower_obj->acc_num : '' ?>">
                      </div>
                    </div>
                  </div>

                  <div class="load-animate">
                    <div class="form-group">
                      <label class="col-sm-2 col-sm-2 control-label">Account Type</label>
                      <div class="col-sm-10">
                        <label class="checkbox-inline">
                          <input type="radio" id="inlineCheckbox1" value="check" name="account_type" <?php echo isset($borrower_obj) && $borrower_obj->acc_type == "check" ? 'checked': '' ?>> Check
                        </label>
                        <label class="checkbox-inline">
                          <input type="radio" id="inlineCheckbox2" value="savings" name="account_type" <?php echo isset($borrower_obj) && $borrower_obj->acc_type == "savings" ? 'checked': '' ?>> Savings
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="form-group last col-xs-12 col-sm-6">
                    <label class="control-label col-md-3">Pay Slip</label>
                    <div class="col-md-9">
                      <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">
                          <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt="" />
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                          <span class="btn btn-theme02 btn-file">
                            <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                            <input type="file" class="default" name="pay_slip" />
                          </span>
                          <a href="advanced_form_components.html#" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group last col-xs-12 col-sm-6">
                    <label class="control-label col-md-3">Bank Statements</label>
                    <div class="col-md-9">
                      <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="fileupload-new thumbnail" style="width: 100px; height: 100px;">
                          <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&text=no+image" alt="" />
                        </div>
                        <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        <div>
                          <span class="btn btn-theme02 btn-file">
                            <span class="fileupload-new"><i class="fa fa-paperclip"></i> Select image</span>
                            <span class="fileupload-exists"><i class="fa fa-undo"></i> Change</span>
                            <input type="file" class="default" name="bank_statements" />
                          </span>
                          <a href="advanced_form_components.html#" class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload"><i class="fa fa-trash-o"></i> Remove</a>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="load-animate">
                    <div class="form-group">
                      <div class="text-center">
                        <button id="submit_btn" type="submit" class="btn btn-primary" name="client_details" value="<?php echo isset($borrower_obj) && $borrower_obj->finance_rec ? 'UPDATE' : 'CREATE' ?>" <?php echo isset($borrower_obj) ? '' : 'disabled' ?>>Save Client Details</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <script src="js/jquery-ui-custom.min.js"></script>
            <script src='js/grid.locale-en.js'></script>
            <script src='js/jquery.jqGrid.min.js'></script>
            <script>
            jQuery("#list2").jqGrid({
              url:'ajax-client.php',
              datatype: "json",
              colNames:['ID','Customer Name', 'Phone Number', 'Country', 'Action'],
              colModel:[
                {name:'id',index:'id', align:"center"},
                {name:'customerName',index:'customerName', align:"center"},
                {name:'phone',index:'phone', align:"center"},
                {name:'country',index:'country', align:"center"},
                {name:'result',index:'result', align:"center"}
              ],
              rowNum:10,
              rowList:[10,20,30],
              pager: '#pager2',
              recordpos: 'left',
              viewrecords: true,
              sortorder: "asc",
              height: '100%'
            });
            </script>
            <div class="clearfix"></div>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/bootstrap-datepicker.js"></script>
          </div>
        </div>
      </div>
    </div>
  </section>
</section>

<?php $page = $sub_page; ?>

<?php include "includes/footer.php"; ?>
