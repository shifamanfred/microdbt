<?php

$title = "Welcome Home | Partner | Your loan gateway system";
$page = "loans";
$sub_page = "disburse_loan";
include 'includes/header.php';
include 'includes/classes.php';

if (isset($_GET['b_id'])) {
  $borrower_id = intval($_GET['b_id']);
} else {
  $borrower_id = 0;
}

if (isset($_GET['acc_id'])) {
  $account_id = intval($_GET['acc_id']);
} else if (isset($_GET['account_id'])) {
  $account_id = intval($_GET['account_id']);
} else {
  $account_id = 0;
}

if ($borrower_id != 0) {
  $borrower_obj = new Borrower($connect, $borrower_id);
}

if ($account_id != 0) {
  $account_obj = new LoanAccount($connect, $account_id);
}

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
                if (strpos(strtolower($_GET['msg']), 'success') !== false || strpos(strtolower($_GET['msg']), 'approved') !== false) {
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
              <h1 class="page-header">Disburse Loan: <a href="manage_loans.php" class="btn btn-success pull-right"> <i class="fa fa-edit"> </i>Loans</a></h1>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main">

                <?php

                // if borrower and accounts are not in session
                // show the borrower selector

                if ($borrower_id == 0 || $account_id == 0) {
                  $borrower_condition = 'borrowers_with_loans_only';
                  include 'includes/borrower_selector.php';

                  $zero_loans = true;

                  ?>

                  <form class="form" action="" method="get" role="form">
                    <input type="hidden" value="<?php echo $client_found = ($client_id > 0) && isset($borrower_id) ? $borrower_id : '' ?>" name="b_id" required>

                    <?php
                    if ($client_found) {
                      $loan_condition = 'loans_approved_but_not_disbursed';
                      include 'includes/loan_selector.php';
                    }
                    ?>


                    <div class="form-group text-center">
                      <a class="btn btn-theme04" href="manage_loans.php">Cancel</a>
                      <button class="btn btn-theme03" type="submit" <?php echo (isset($zero_loans) && $zero_loans) ? 'disabled' : ''; ?>>Continue</button>
                    </div>
                  </form>
                  <?php

                } else { ?>
              <div class="row mt mb">
                <div class="col-lg-12">
                  <form id="disburse-form" action="proc_form.php?ops=loan+disbursement&part_id=<?php echo $part_id; ?>&acc_id=<?php echo $account_id; ?>&b_id=<?php echo $borrower_id?>" method="post" role="form">
                    <div class="col-lg-4 col-md-4 col-sm-12 mt">
                      <div class="dmbox">
                        <button id="pay-cash-btn" type="button" class="btn btn-primary-outline" style="background-color: transparent;" href="#">
                        <div class="service-icon">
                          <i class="dm-icon fa fa-money fa-3x"></i>
                        </div>
                        <h4>1. Pay Cash</h4>
                        <p>Amount: <?php echo $account_obj->base_amount; ?></p>
                        </button>
                        <input id="pay-cash" class="btn btn-default" type="radio" value="CASH" name="disburse_method">
                      </div>
                    </div>
                    <!-- end dmbox -->
                    <div class="col-lg-4 col-md-4 col-sm-12 mt">
                      <div class="dmbox">
                        <button id="bank-transfer-btn" type="button" class="btn btn-primary-outline" style="background-color: transparent;" href="#">
                        <div class="service-icon">
                          <i class="dm-icon fa fa-building-o fa-3x"></i>
                        </div>
                        <h4>2. Bank Transfer</h4>
                        <p>Amount: <?php echo $account_obj->base_amount; ?></p>
                        </button>
                        <input id="bank-transfer" type="radio" value="BANK" name="disburse_method">
                      </div>
                    </div>
                    <!-- end dmbox -->
                    <div class="col-lg-4 col-md-4 col-sm-12 mt">
                      <div class="dmbox">
                        <button id="e-wallet-btn" type="button" class="btn btn-primary-outline" style="background-color: transparent;" href="#">
                        <div class="service-icon">
                          <i class="dm-icon fa fa-suitcase fa-3x"></i>
                        </div>
                        <h4>3. Electronic Wallet</h4>
                        <p>Bank Windhoek Easy-wallet</p>
                        <p>FNB E-wallet</p>
                        <p>Standard Bank Blue-wallet</p>
                        <p>Amount: <?php echo $account_obj->base_amount; ?></p>
                        </button>
                        <input id="e-wallet" type="radio" value="EWALLET" name="disburse_method">

                      </div>
                    </div>
                    <!-- end dmbox -->

                    <div class="form-group text-center">
                      <button type="submit" class="btn btn-theme col-sm-4 col-sm-offset-3" name="submit-btn">Disburse Loan &raquo;</button>
                    </div>

                  </form>
                </div>
                <!--  /col-lg-12 -->
              </div>
              <?php } ?>

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
