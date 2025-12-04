<?php

$title = "Welcome Home | Partner | Your loan gateway system";
$page = "loans";
$sub_page = "approve_loan";
include 'includes/header.php';
include 'includes/classes.php';

if (isset($_GET['b_id'])) {
  $borrower_id = intval($_GET['b_id']);
} else {
  $borrower_id = 0;
}

if (isset($_GET['acc_id'])) {
  $account_id = intval($_GET['acc_id']);
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
						<div class="container-fluid mt">
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
							<h1 class="page-header">Approve Loan: <a href="manage_loans.php" class="btn btn-success pull-right"> <i class="fa fa-edit"> </i>Loans</a></h1>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main">

								<!-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">

								</div> -->

                <?php

                // if borrower and accounts are not in session
                // show the borrower selector

                if ($borrower_id == 0 && $account_id == 0) {
                  $borrower_condition = 'borrowers_with_loans_only';
                  include 'includes/borrower_selector.php';

                  $zero_loans = true;

                  ?>

                  <form class="form" action="" method="get" role="form">
                    <input type="hidden" value="<?php echo $client_found = ($client_id > 0) && isset($borrower_id) ? $borrower_id : '' ?>" name="b_id" required>

                    <?php
                    if ($client_found) {
                      $loan_condition = 'loans_not_approved';
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


                <div class="chat-room mt">
                  <aside class="mid-side">
                    <div class="chat-room-head">
                      <h3><?php echo $borrower_obj->name . ' ' . $borrower_obj->last_name?></h3>
                    </div>

                    <?php


                    ?>
                    <div class="room-desk">
                      <div class="room-box">
                        <h5 class="text-primary"><a href="#">Loan Details</a></h5>
                        <p>Expected Loan Amount: <strong><?php echo $account_obj->base_amount; ?></strong></p>
                        <p>Loan Percentage: <strong><?php echo $account_obj->percent; ?>%</strong></p>
                        <p>Number Of Installments: <strong><?php echo $account_obj->inst; ?></strong></p>
                      </div>
                      <div class="room-box">
                        <h5 class="text-primary"><a href="#">Repayment Details</a></h5>
                        <p>Total Loan Repayment: <strong><?php echo $account_obj->total_repay; ?></strong></p>
                        <p>Estimated Monthly Installment: <strong><?php echo $account_obj->emi; ?></strong></p>
                      </div>
                      <div class="room-box">
                        <h5 class="text-primary"><a href="#">Financial Status</a></h5>
                        <p>Net Salary: <strong><?php echo $borrower_obj->net_salary; ?></strong></p>
                        <p>Total Expenses: <strong><?php echo $borrower_obj->total_expenses; ?></strong></p>
                        <p>Total Current Loan Repayments: <strong><?php echo $borrower_obj->total_loans; ?></strong></p>
                      </div>
                    </div>
                    <!-- <div class="room-desk">
                      <h4 class="pull-left">private room</h4>
                      <div class="room-box">
                        <h5 class="text-primary"><a href="chat_room.html">Dash Stats</a></h5>
                        <p>Private chat regarding our site statics.</p>
                        <p><span class="text-muted">Admin :</span> Sam Soffes | <span class="text-muted">Member :</span> 13 | <span class="text-muted">Last Activity :</span> 15 min ago</p>
                      </div>
                      <div class="room-box">
                        <h5 class="text-primary"><a href="chat_room.html">Gold Clients</a></h5>
                        <p>Exclusive support for our Gold Members. Membership $98/year</p>
                        <p><span class="text-muted">Admin :</span> Sam Soffes | <span class="text-muted">Member :</span> 13 | <span class="text-muted">Last Activity :</span> 15 min ago</p>
                      </div>
                    </div> -->
                  </aside>
                  <aside class="right-side">
                    <div class="chat-room-head">
                      <div class="pull-right">
                        <form class="form" action="proc_form.php?ops=loan+approval&part_id=<?php echo $part_id; ?>&acc_id=<?php echo $account_id; ?>&b_id=<?php echo $borrower_id?>" method="post">
                          <button class="btn btn-theme02" name="approve">Approve</button>
                          <button class="btn btn-theme04" name="decline">Decline</button>
                        </form>
                      </div>
                    </div>
                    <div class="invite-row">
                      <h4 class="pull-left">Affordability</h4>
                    </div>
                    <ul class="chat-available-user">
                      <li>
                        <a href="#">
                          <!-- <img class="img-circle" src="img/friends/fr-02.jpg" width="32"> -->
                          Maximum Loan Affordability
                          <span class="text-muted"><strong><?php echo $borrower_obj->net_salary - $borrower_obj->total_expenses ?></strong></span>
                        </a>

                        <?php // TODO: Loan Calculator (See Kloans) ?>
                      </li>
                      <li>
                        <a href="#">
                          Short Term Affordability
                          <?php // TODO: SHORT TERM Affordability CALCULATION ?>
                          <span class="text-muted">1h:08m</span>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          Long Term Affordability
                          <?php // TODO: LONG TERM Affordability CALCULATION ?>
                          <span class="text-muted">1h:10m</span>
                          </a>
                      </li>
                    </ul>
                  </aside>
                </div>
                <?php } ?>

							</div>
						</div>
				</div>
			</div>
		</div>
	</section>
</section>

<?php $page = $sub_page; ?>

<?php require "includes/footer.php"; ?>
