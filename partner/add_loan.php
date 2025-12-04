<?php

$title = "Welcome Home | Partner | Your loan gateway system";
$page = "loans";
$sub_page = "add_loan";
include 'includes/header.php';
include 'includes/classes.php';

$set = new CompanySettings($connect);

?>

<?php require "includes/sidebar.php"; ?>
<!--sidebar end-->
<!-- **********************************************************************************************************************************************************
MAIN CONTENT
*********************************************************************************************************************************************************** -->
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
							<h1 class="page-header">Add Loan: <a href="manage_loans.php" class="btn btn-success pull-right"> <i class="fa fa-edit"> </i>Loans</a></h1>
							<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 main">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">

                  <?php include 'includes/borrower_selector.php'; ?>

                  <form id="myform" name="myform" class="form-horizontal style-form" action="proc_form.php?ops=add+loan&part_id=<?php echo $part_id; ?>" method="post" role="form">
                    <input type="hidden" value="<?php echo ($client_id > 0) && isset($borrower_id) ? $borrower_id : '' ?>" name="borrower_id" required>

                    <div class="form-group mt">
											<label class="col-sm-2 col-sm-2 control-label">REFERENCE NO</label>
											<div class="col-sm-10">
                        <?php
                        $query = 'SELECT COUNT(*) AS "num" FROM loan_account_lookup ';
                        $query .= 'WHERE partner_id = ' . $part_id;

                        $result = $connect->query($query);

                        if (!$result) {
                          $loan_number = -1;
                        } else {
                          $loan_number = $result->fetch_assoc()['num'];
                        }

                        $loan_alias = strtoupper(substr($company , 0, 3)) . sprintf("%05d", ++$loan_number);
                        $loan_alias2 = 'MF'. sprintf("%08d", $loan_number);
                        ?>
												<input id="loan-alias" type="text" class="form-control" name="loan_alias" value="<?php echo $loan_alias ; ?>" readonly required>
											</div>
										</div>

                    <div class="">
                      <div class="form-group">
                        <label title="Select 'No' if the loan was approved today." class="col-sm-2 col-sm-2 control-label">Pre Approved Loan? </label>
                        <div class="col-sm-10">
                          <label class="checkbox-inline">
                            <input type="radio" id="trueCheck" value="TRUE" name="ancient"> YES
                          </label>
                          <label class="checkbox-inline">
                            <input type="radio" id="falseCheck" value="FALSE" name="ancient" checked> NO
                          </label>
                        </div>
                      </div>
                    </div>

                    <div id="loanDateGroup">
                      <div class="form-group">
                        <span for="loanDate" class="col-sm-2 control-span">Application Date <br><small>(Date of Approval)</small></span>
                        <div class="col-sm-10">
                          <input type="date" name="approve_date" class="form-control is-datepick" id="loanDate" value="">
                          <span class="help-block"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <span for="loanDate" class="col-sm-2 control-span">Disburement Date</span>
                        <div class="col-sm-10">
                          <input type="date" name="disburse_date" class="form-control is-datepick" id="loanDate" value="">
                          <span class="help-block"></span>
                        </div>
                      </div>
                    </div>

										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Loan Amount</label>
											<div class="col-sm-10">
												<input type="number" step="0.01" onkeyup="calculateEMI()"  class="form-control" placeholder="Enter Expected Loan Amount" name="loan_amount" id="loan_amount" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Loan Percentage</label>
											<div class="col-sm-10">
												<input type="number" onkeyup="calculateEMI()" name="loan_percent" class="form-control" id="loan_percent" placeholder="Enter loan percent" required>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Set number of installments</label>
											<div class="col-sm-10">
												<input id="installments" type="number" onkeyup="calculateEMI()" name="installments" class="form-control"  placeholder="Enter installments number" required>
											</div>
										</div>

                    <?php
                    if (($p = new Partner($connect, $part_id))->debit_order_fee != 'TRUE') { ?>

                      <!-- <div class="form-group">
                        <label class="col-sm-2 col-sm-2 control-label">Debit Order Fee</label>
                        <div class="col-sm-10">
                          <input type="text" name="debit_order_fee" class="form-control positive-integer" id="debit_order_fee" value="<?php echo $set->debit; ?>" readonly required>
                        </div>
                      </div> -->

                      <input type="hidden" name="debit_order_fee" class="form-control positive-integer" id="debit_order_fee" value="0.00" readonly required>

                      <?php
                    } else  { ?>
                      <input type="hidden" name="debit_order_fee" class="form-control positive-integer" id="debit_order_fee" value="0.00" readonly required>

                    <?php } unset($p); ?>

                    <div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Namfisa Fee</label>
											<div class="col-sm-10">
												<input type="text" name="namfisa_fee" onkeyup="calculateEMI()" class="form-control positive-integer" id="namfisa_fee" required>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Total amount including interest</label>
											<div class="col-sm-10">
												<input type="text"  name="total_amount" class="form-control" readonly required>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Automated calculated EMI</label>
											<div class="col-sm-10">
												<input type="text" name="borrower_emi" class="form-control positive-integer" id="inputBorrowerMobile" readonly required>
											</div>
										</div>

										<div class="form-group">
											<label class="col-sm-2 col-sm-2 control-label">Borrower Files (Required)</label>
											<div class="col-sm-10">
												<input type="file"  name="borrower_files">
											</div>
										</div>


										<div class="form-group text-center">
											<button class="btn btn-success" type="submit" <?php echo ($client_id > 0) ? '' : 'disabled' ?>><i class="fa fa-money"></i> Issue Loan</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</section>

<?php $page = $sub_page; ?>

<?php require "includes/footer.php"; ?>
