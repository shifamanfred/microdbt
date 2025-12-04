<?php

$title = "Admin | Welcome | Your loan gateway system";
$page = 'partner';
$sub_page = 'add_partner';

include 'pages/header.php';
?>

<?php include "pages/sidebar.php"; ?>

<!--main content start-->
<section id="main-content">
  <section class="wrapper">
    <h3><i class="fa fa-angle-right"></i> Add A Partner</h3>
    <!-- BASIC FORM ELELEMNTS -->
    <div class="row mt">
      <div class="col-lg-12">
        <div class="form-panel">
          <h4 class="mb"><i class="fa fa-angle-right"></i> Partner Details</h4>
          <form class="form-horizontal style-form" action="proc_form.php?ops=add+partner" method="post">
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <small class="form-text text-muted">Business Name:</small>
                <input type="text" class="form-control" placeholder="Enter Full Name of The business" name="business">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <small class="form-text text-muted">Business Trade Name:</small>
                <input type="text" class="form-control" placeholder="Business Trading As" name="trade_name">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <small class="form-text text-muted">Owner's Name &amp; Surname:</small>
                <input type="text" class="form-control" placeholder="Owner's Name &amp; Surname" name="owners_name">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <small class="form-text text-muted">Registration Number:</small>
                <input type="text" class="form-control" placeholder="Registration Number" name="registration_number">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <small class="form-text text-muted">Income Tax:</small>
                <input type="text" class="form-control" placeholder="Income Tax Number" name="income_tax_number">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <small class="form-text text-muted">Social Security Number:</small>
                <input type="text" class="form-control" placeholder="Social Security Number" name="social_security_number">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <small class="form-text text-muted">Namfisa Registration Number:</small>
                <input type="text" class="form-control" placeholder="Namfisa Registration" name="namfisa_registration">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <small class="form-text text-muted">Postal Address:</small>
                <input type="text" class="form-control" placeholder="Postal Address" name="postal_address">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <small class="form-text text-muted">Physical Address:</small>
                <input type="text" class="form-control" placeholder="Physical Address" name="physical_address">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <small class="form-text text-muted">Street Name:</small>
                <input type="text" class="form-control" placeholder="Street" name="street_name">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <small class="form-text text-muted">Town / City:</small>
                <input type="text" class="form-control" placeholder="Town / City" name="town">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <small class="form-text text-muted">Country:</small>
                <input type="text" class="form-control" placeholder="Country" name="country">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <input type="number" class="form-control" placeholder="Zip Code" name="zip_code">
              </div>
            </div>
            <div class="form-group col-sm-6">

              <small class="form-text text-muted"></small>
              <div class="col-sm-5 col-xs-12">Own Debit Order?</div>
              <div class="col-sm-3 col-xs-6">

                <label for="db_fee_yes" class="control-label col-sm-6">Yes</label>
                <input type="radio" style="width: 10px" class="checkbox form-control col-xs-6" id="db_fee_yes" name="debit_order" value="TRUE">
              </div>
              <div class="col-sm-3 col-xs-6">
                <label for="db_fee_no" class="control-label col-sm-6">No</label>
                <input type="radio" style="width: 10px" class="checkbox form-control col-xs-6" id="db_fee_no" name="debit_order" value="FALSE">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <input type="text" class="form-control" placeholder="Telephone Number" name="telephone">
              </div>
            </div>
            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <input type="text" class="form-control" placeholder="Cell Number" name="cellphone">
              </div>
            </div>

            <h4 class="mb col-sm-12"><i class="fa fa-angle-right"></i> Partner User Credentials</h4>

            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <input type="email" class="form-control" placeholder="Email Address" name="email">
              </div>
            </div>

            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <input id="user" type="text" class="form-control" placeholder="Username" name="username">
              </div>
            </div>

            <div class="form-group col-sm-6">
              <div class="col-sm-12">
                <input id="pass" type="password" class="form-control" placeholder="Password" name="password">
              </div>
            </div>

            <div id="conf-container" class="form-group col-sm-6">
              <div class="col-sm-12">
                <input id="conf" type="password" class="form-control" placeholder="Confirm Password" name="confirm">
                <p id="conf-message" class="help-block"></p>
              </div>
            </div>

            <div class="text-center">
              <button id="submit" style="width: 200px;" type="submit" class="btn btn-theme">Save</button>
            </div>
          </form>
        </div>
      </div>
      <!-- col-lg-12-->
    </div>
    <!-- /row -->
  </section>
  <!-- /wrapper -->
</section>
<!-- /MAIN CONTENT -->
<!--main content end-->


<?php $page = 'add_partner'; ?>

<?php require "pages/footer.php"; ?>
