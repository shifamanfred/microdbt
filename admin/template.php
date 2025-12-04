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

?>

<!--main content start-->
<section id="main-content">
  <section class="wrapper site-min-height">
    <div class="col-lg-12 mt">


    <div class="row content-panel">

    </div>
    </div>
  </section>
</section>

<?php include "includes/footer.php"; ?>
