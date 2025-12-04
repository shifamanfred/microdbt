<?php
$title = "Create Invoice";
$page = "loans";
$sub_page = 'view_loans';

// get loan id first
if (!isset($_GET['id'])) {
  header('Location: manage_loans.php?status=null');
  exit;
} else {
  $acc_id = $_GET['id'];
}


include 'includes/header.php';
?>

<?php
include "includes/sidebar.php";
include "includes/classes.php";
include "includes/functions.php";


$loan_obj = new LoanAccount($connect, $acc_id);

$borrower_obj = $loan_obj->getBorrowerObject($connect);

?>

<!--main content start-->
<section id="main-content">
  <section class="wrapper site-min-height">
    <!-- page start-->
    <div class="chat-room mt">
      <aside class="mid-side">
        <div class="chat-room-head">
          <h3>Loan Account [<?php echo $loan_obj->status ?>]</h3>
          <h3 class="pull-right">#: <?php echo $loan_obj->loan_alias; ?></h3>
        </div>
        <div class="group-rom">
          <div class="first-part odd" style="font-weight: normal;"><?php echo ($loan_obj->status == 'DISBURSED') ? 'Disbursed' : '' ?> Loan Amount</div>
          <div class="second-part"> <strong><?php echo $loan_obj->base_amount; ?> <?php if ($loan_obj->disburse_method !== NULL) {echo '['. $loan_obj->disburse_method .']';} ?></strong> </div>
        </div>
        <div class="group-rom">
          <div class="first-part">Percentage</div>
          <div class="second-part"><strong><?php echo $loan_obj->percent; ?></strong></div>
        </div>
        <div class="group-rom">
          <div class="first-part odd" style="font-weight: normal;">Total Repayment Amount</div>
          <div class="second-part"><strong><?php echo $loan_obj->total_loan; ?></strong>  [Remaining: <?php echo $loan_obj->total_remain; ?>]</div>
        </div>
        <div class="group-rom">
          <div class="first-part">Estimated Monthly Installment</div>
          <div class="second-part"><strong><?php echo $loan_obj->emi; ?></strong></div>
        </div>
        <div class="group-rom">
          <div class="first-part odd" style="font-weight: normal;">Number of Installments</div>
          <div class="second-part"><strong><?php echo $loan_obj->inst; ?></strong></div>
        </div>

        <div class="group-rom">
          <div class="first-part">Current Installment</div>
          <div class="second-part"><strong><?php echo addOrdinalNumberSuffix($loan_obj->current_inst); ?></strong></div>
        </div>

        <div class="group-rom">
          <div class="first-part odd">Remaining Installments</div>
          <div class="second-part"><strong><?php echo $loan_obj->remain_inst; ?></strong></div>
        </div>
        <div class="group-rom">
          <div class="first-part" style="font-weight: normal;">Date Issued: </div>
          <div class="second-part"><strong><?php echo $loan_obj->issue_date; ?></strong></div>
        </div>

        <div class="group-rom">
          <div class="first-part odd" style="font-weight: normal;">Date Approved: </div>
          <div class="second-part"><strong><?php echo $loan_obj->approved_date; ?></strong></div>
        </div>

        <div class="group-rom">
          <div class="first-part" style="font-weight: normal;">Date Disbursed: </div>
          <div class="second-part"><strong><?php echo $loan_obj->disbursed_date; ?></strong></div>
        </div>

        <div class="group-rom last-group">
          <div class="first-part odd" style="font-weight: normal;">Next Payment Due_date: </div>
          <div class="second-part"><strong><?php echo $loan_obj->next_payment_date; ?></strong></div>
        </div>

        <footer>
          <div class="chat-txt">
            <?php if ($loan_obj->status == 'DISBURSED' || $loan_obj->status == 'APPROVED') { ?>
            <a class="btn btn-theme" href="loan_schedule.php?loan_id=<?php echo $loan_obj->acc_id; ?>"><i class="fa fa-calendar"> Schedule</i> </a>
          <?php } ?>

            <?php if ($loan_obj->status == 'DISBURSED') { ?>
            <a class="btn btn-theme" href="contract.php?loan_id=<?php echo $loan_obj->acc_id; ?>" target="_blank"><i class="fa fa-file-text"> Contract</i> </a>
            <?php } ?>
          </div>

          <div class="btn-group hidden-sm hidden-xs">
            <button type="button" class="btn btn-white"><i class="fa fa-meh-o"></i></button>
            <button type="button" class="btn btn-white"><i class=" fa fa-paperclip"></i></button>
          </div>
          <button class="btn btn-theme" type="button" name="button"> <i class="fa fa-print"></i> Print</button>
        </footer>
      </aside>
      <aside class="right-side">
        <div class="user-head text-center">
          <?php if ($loan_obj->status == 'DISBURSED') { ?>
            <a href="record_repayment.php?client_id=<?php echo $borrower_obj->id; ?>&acc_id=<?php echo $acc_id; ?>" class="btn btn-theme03">Repayment &raquo; </a>
          <?php } else if ($loan_obj->status == 'APPROVED') {?>
            <a href="disburse_loan.php?b_id=<?php echo $borrower_obj->id; ?>&acc_id=<?php echo $acc_id; ?>" class="btn btn-theme03">Disbursement &raquo; </a>
          <?php } else if ($loan_obj->status == 'PENDING') {?>
            <a href="approve_loan.php?b_id=<?php echo $borrower_obj->id; ?>&acc_id=<?php echo $acc_id; ?>" class="btn btn-theme03">Approval &raquo; </a>
          <?php } ?>
        </div>
        <div class="invite-row">
          <h4 class="pull-left">Borrower</h4>
        </div>
        <ul class="chat-available-user">
          <li>
            <a href="#">ID Number: <?php echo $borrower_obj->id_num; ?></a>
          </li>
          <li>
            <a href="#">Name: <?php echo $borrower_obj->name; ?></a>
          </li>
          <li>
            <a href="#">Surname: <?php echo $borrower_obj->last_name; ?></a>
          </li>
          <li>
            <a href="#">Gender: <?php echo $borrower_obj->gender; ?></a>
          </li>
          <li>
            <a href="#">Email: <?php echo $borrower_obj->email; ?></a>
          </li>
          <li>
            <a href="#">Date of Birth: <?php echo $borrower_obj->dob; ?></a>
          </li>

          <li>
            <a href="#">Gross Salary: <?php echo $borrower_obj->gross_salary; ?></a>
          </li>

          <li>
            <a href="#">Net Salary: <?php echo $borrower_obj->net_salary; ?></a>
          </li>

          <li>
            <a href="#">Total Expenses: <?php echo $borrower_obj->total_expenses; ?></a>
          </li>
        </ul>
      </aside>

    <!-- page end-->
  </section>
  <!-- /wrapper -->
</section>
<!-- /MAIN CONTENT -->
<!--main content end-->

<?php include "includes/footer.php"; ?>
