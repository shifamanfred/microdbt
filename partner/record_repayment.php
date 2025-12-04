<?php

$title = "Welcome Home | Partner | Your loan gateway system";
$page = "repayments";
$sub_page = "record_repayment";
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
							<h1 class="page-header">Record Loan Repayment: <a href="repayments.php" class="btn btn-success pull-right"> <i class="fa fa-edit"> </i>Repayments</a></h1>
							<div class="col-xs-12 col-sm-11 col-md-11 col-lg-11 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 main">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">

                  <?php $borrower_condition = 'borrowers_with_loans_only' ?>

                  <?php  include 'includes/borrower_selector.php'; ?>

                  <form id="myform" name="myform" class="form-horizontal style-form" action="proc_form.php?ops=record+repay&part_id=<?php echo $part_id; ?>" method="post" role="form">
                    <input type="hidden" value="<?php echo $client_found = ($client_id > 0) && isset($borrower_id) ? $borrower_id : '' ?>" name="borrower_id" required>

                    <?php
                    if ($client_found) {
                      $loan_condition = 'loans_disbursed';
                      include 'includes/loan_selector.php';
                    }
                    ?>

										<div class="form-group mt">
											<label class="col-sm-2 col-sm-2 control-label">Repayment Amount</label>
											<div class="col-sm-10">
												<input type="number" step="0.01" onkeyup="calculateEMI()"  class="form-control" placeholder="Enter Repayment Amount" name="repayment" id="repayment_amount" required>
											</div>
										</div>

                    <div class="form-group">
                      <span for="repay_date" class="col-sm-2 control-span">Repayment Date</span>
                      <div class="col-sm-10">
                        <input type="date" name="repay_date" class="form-control is-datepick" id="repay_date" value="">
                        <span class="help-block"></span>
                      </div>
                    </div>

										<div class="form-group text-center">
											<button class="btn btn-success" type="submit" <?php echo $client_found ? '' : 'disabled' ?>>Record Repayment</button>
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
