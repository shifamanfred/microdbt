<?php

$title = "Welcome Home | Partner | Your loan gateway system";
$page = "customer_management";
$sub_page = "confirm_client_details";

if (isset($_GET['client_id'])) {
  $borrower_id = intval($_GET['client_id']);
} else {
  header('Location: manage_clients.php');
  exit;
}

include 'includes/header.php';
include 'includes/classes.php';

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
            <div class="container-fluid">
              <?php include 'includes/alert_dialog.php'; ?>
              <h1 class="page-header">Confirm Client Details: </h1>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main">

              <div class="row mt mb">
                <div class="col-lg-12">
                  <form id="confirm-client" class="form" action="proc_form.php?ops=navigate&client_id=<?php echo $borrower_id?>&part_id=<?php echo $part_id; ?>" method="post" role="form">
                    <div class="col-lg-4 col-md-4 col-sm-12 mt">
                      <div class="dmbox">
                        <button id="new-loan-btn" type="button" class="btn btn-primary-outline" style="background-color: transparent;" href="#">
                        <div class="service-icon">
                          <i class="dm-icon fa fa-money fa-3x"></i>
                        </div>
                        <h4>1. Issue New Loan</h4>
                        <p>Issue a new loan to this customer. </p>
                        </button>
                        <input id="new-loan" class="btn btn-default" type="radio" value="LOAN" name="navigate">
                      </div>
                    </div>
                    <!-- end dmbox -->
                    <div class="col-lg-4 col-md-4 col-sm-12 mt">
                      <div class="dmbox">
                        <button id="add-client-btn" type="button" class="btn btn-primary-outline" style="background-color: transparent;" href="#">
                        <div class="service-icon">
                          <i class="dm-icon fa fa-user-o fa-3x"></i>
                        </div>
                        <h4>2. Add Another Customer</h4>
                        <p>Adding more customers</p>
                        </button>
                        <input id="add-client" type="radio" value="CUSTOMER" name="navigate">
                      </div>
                    </div>
                    <!-- end dmbox -->
                    <div class="col-lg-4 col-md-4 col-sm-12 mt mb">
                      <div class="dmbox">
                        <button id="customer-btn" type="button" class="btn btn-primary-outline" style="background-color: transparent;" href="#">
                        <div class="service-icon">
                          <i class="dm-icon fa fa-user fa-3x"></i>
                        </div>
                        <h4>3. Customer Management</h4>
                        <p>Back to Customer Management</p>
                        </button>
                        <input id="customer" type="radio" value="CUSTOMER_MANAGEMENT" name="navigate">
                      </div>
                    </div>
                    <!-- end dmbox -->

                    <div class="form-group text-center mt">
                      <button type="submit" class="btn btn-theme col-sm-4 col-sm-offset-3" name="submit-btn">Continue &raquo;</button>
                    </div>

                  </form>
                </div>
                <!--  /col-lg-12 -->
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
