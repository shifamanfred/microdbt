<?php
$title = "Payment Schedule";
$page = "loans";
$sub_page = 'loan_schedule';

// get loan id first
if (!isset($_GET['loan_id'])) {
  header('Location: manage_loans.php?status=null');
  exit;
} else {
  $acc_id = $_GET['loan_id'];
}

include 'includes/header.php';
include "includes/sidebar.php";
include "includes/classes.php";
include "includes/functions.php";


$loan_obj = new LoanAccount($connect, $acc_id);

$borrower_obj = $loan_obj->getBorrowerObject($connect);

$set = new CompanySettings($connect);

$p = new Partner($connect, $part_id);

?>

<!--main content start-->
<section id="main-content">
  <section class="wrapper site-min-height">
    <div class="col-lg-12 mt">

      <div class="content-panel">
        <h4><i class="fa fa-angle-right"></i> Loan Account: <?php echo $loan_obj->loan_alias; ?> <div style="margin-right: 15px;" class="pull-right mr">Borrower: <?php echo $borrower_obj->name . ' ' .$borrower_obj->last_name; ?></div></h4>
        <table class="table">
          <thead>
            <tr>
              <th>Principle</th>
              <th> + Interest @ <?php echo $loan_obj->percent . '%'; ?></th>
              <th> + Fees</th>
              <th>Loan Repayable</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><?php echo $loan_obj->base_amount; ?></td>
              <td><?php echo $loan_obj->base_amount * $loan_obj->percent / 100; ?></td>
              <?php // TODO: namfisa charges must apply when loan is long term ?>
              <td><?php echo $charges = 0 ; ?></td>
              <td><?php echo $loan_obj->total_loan; ?></td>
            </tr>
          </tbody>
        </table>
      </div>


      <div class="content-panel">
        <h4><i class="fa fa-angle-right"></i> Payment Schedule</h4><hr>
        <table class="table table-hover">
          <thead>
            <tr>
              <th>Due Date</th>
              <th>EMI</th>
              <th>Principle Amount</th>
              <th>Interest</th>
              <th>Balance</th>
            </tr>
          </thead>
          <tbody>
            <h5> <i>&nbsp;</i> Borrower's Pay Date: <?php echo date_format(date_create($borrower_obj->pay_date), 'd-m-Y');  ?></h5>
            <?php for ($index = 0; $index < $loan_obj->inst;) {?>
            <tr>
              <td><?php echo date_format(date_create($borrower_obj->pay_date . ' + '. $index++ . ' month') , "d-m-Y"); ?></td>
              <td><?php echo $loan_obj->emi; ?></td>
              <td><?php echo $loan_obj->base_amount; ?></td>
              <td><?php echo $loan_obj->base_amount * $loan_obj->percent / 100; ?></td>
              <td><?php echo $loan_obj->total_loan - $loan_obj->emi * $index; ?></td>
            </tr>
            <?php } ?>

          </tbody>
        </table>

        <div class="row text-center">
          <a class="btn btn-theme" href="loan_schedule_pdf.php?loan_id=<?php echo $loan_obj->acc_id; ?>"><i class="fa fa-print"> Print</i> </a>
        </div>
      </div>
    </div>
  </section>
</section>

<?php include "includes/footer.php"; ?>
