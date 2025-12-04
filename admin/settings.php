<?php
$title = "Create Invoice";
$page = 'settings';
include 'pages/header.php';
include 'pages/classes.php';

?>

<?php include "pages/sidebar.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['edit']) && $_GET['edit'] == true) {
  $name = mysqli_real_escape_string($connect, $_POST['companyName']);
  // Logo also to be inserted

  $addr = mysqli_real_escape_string($connect, $_POST['address']);
  $phone = mysqli_real_escape_string($connect, $_POST['phone']);
  $email = mysqli_real_escape_string($connect, $_POST['contactEmail']);
  $currency = mysqli_real_escape_string($connect, $_POST['currency']);
  $debit = mysqli_real_escape_string($connect, $_POST['debit_order']);
  $contract = mysqli_real_escape_string($connect, $_POST['contract_fee']);
  $default_product = mysqli_real_escape_string($connect, $_POST['default_product']);

  $query = 'UPDATE company_settings ';
  $query .= "SET name = '$name', address = '$addr', phone = '$phone' ";
  $query .= ", db_fee = $debit, contract_fee = $contract, default_pro = '$default_product' ";
  $query .= ", email = '$email', currency = '$currency', su_id = $user_id; ";

  $resutl = $connect->query($query);

  if (!$result) {
    echo '<span class="text-danger">!! DATA QUERY FAILED!!</span>';
    echo '<span class="text-danger">CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect) . '</span>';
    die ('!! DATABASE QUERY FAILED !!');
  } else {
    $edit = true;
  }
}
?>


<section id="main-content">
  <section class="wrapper">
    <div class="col-lg-12 mt">
      <div class="row content-panel">
        <div class="col-lg-10 col-lg-offset-1">
          <div class="invoice-body">
            <div class="pull-left">
              <h1 class="page-header">Settings</h1>
              <?php if (isset($edit)) { ?>
                <div class="alert alert-success alert-dismissable fade in" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <p>Settings Saved!</p>
                </div>
              <?php } ?>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main">


                <?php

                $set = new CompanySettings($connect);

                ?>

                <p><strong>Date Modified:</strong> <?php echo $set->date_modified; ?></p>
                <p><strong>Last Edited By:</strong> <?php echo $set->by_user; ?></p>

                <br><br>

                <form action="settings.php?edit=true" id="settings-form" method="post" class="form-horizontal myaccount" role="form" enctype="multipart/form-data">
                  <div class="load-animate">
                    <div class="form-group">
                      <span for="companyName" class="col-sm-4 control-span">Company Name</span>
                      <div class="col-sm-8">
                        <input value="<?php echo $set->company_name; ?>" name="companyName" id="companyName" type="text" class="form-control">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <span for="companyLogo" class="col-sm-4 control-span"> Company Logo </span>
                      <div class="col-sm-8">
                        <input  type="file" name="companyLogo" id="companyLogo">
                        <img src="<?php echo $set->company_logo; ?>" />
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <span for="address" class="col-sm-4 control-span"> Address</span>
                      <div class="col-sm-8">
                        <textarea name="address" id="address" class="form-control" rows="3"><?php echo $set->company_address; ?></textarea>
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <span for="phone" class="col-sm-4 control-span"> Phone</span>
                      <div class="col-sm-8">
                        <input value="<?php echo $set->phone; ?>" name="phone" id="phone" type="text" class="form-control">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <span for="contactEmail" class="col-sm-4 control-span"> Contact Email </span>
                      <div class="col-sm-8">
                        <input value="<?php echo $set->email; ?>" name="contactEmail" id="contactEmail" type="text" class="form-control">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <input value="$" id="currency_hidden" type="hidden" class="form-control">
                    <div class="form-group">
                      <span for="contactEmail" class="col-sm-4 control-span"> Currency </span>
                      <div class="col-sm-8">
                        <?php
                        // instatiate currency object and load properties where required
                        $currency_obj = new Currency();
                        ?>
                        <select name="currency" id="currency" class="form-control">
                          <option value="?" label="">Choose Currency</option>
                          <option value="ANG" label="ANG (<?php echo $currency_obj->ang; ?>)" <?php echo $set->currency == 'ANG' ? 'selected' : '' ?>>ANG (<?php echo $currency_obj->ang; ?>)</option>
                          <option value="BWD" label="BWP (<?php echo $currency_obj->bwp; ?>)"<?php echo $set->currency == 'BWP' ? 'selected' : '' ?>>BWP (<?php echo $currency_obj->bwp; ?>)</option>
                          <option value="NAD" label="NAD (<?php echo $currency_obj->nad; ?>)"<?php echo $set->currency == 'NAD' ? 'selected' : '' ?>>NAD (<?php echo $currency_obj->nad; ?>)</option>
                          <option value="ZAR" label="ZAR (<?php echo $currency_obj->zar; ?>)"<?php echo $set->currency == 'ZAR' ? 'selected' : '' ?>>ZAR (<?php echo $currency_obj->zar; ?>)</option>
                          <option value="ZWD" label="ZWD (<?php echo $currency_obj->zwd; ?>)"<?php echo $set->currency == 'ZWD' ? 'selected' : '' ?>>ZWD (<?php echo $currency_obj->zwd; ?>)</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <span for="contactEmail" class="col-sm-4 control-span"> Default Product </span>
                      <div class="col-sm-8">
                        <?php
                        // instatiate currency object and load properties where required

                        $result = Product::getProductRecords($connect);

                        if ($result) {
                        ?>
                        <select name="default_product" id="product" class="form-control">
                          <?php
                          while($row = $result->fetch_assoc()) {
                          $pro_obj = new Product($connect, $row['code']);
                          ?>
                          <option value="<?php echo $pro_obj->code; ?>" <?php echo ($pro_obj->code == $set->default_product) ? 'selected' : '' ?> ><?php echo $pro_obj->code . ' - '. $pro_obj->pro_name?></option>
                          <?php } ?>
                        </select>
                        <?php } ?>
                      </div>
                    </div>

                    <div class="form-group">
                      <span for="companyName" class="col-sm-4 control-span">Debit Order Fee</span>
                      <div class="col-sm-8">
                        <input value="<?php echo $set->debit; ?>" name="debit_order" type="number" step="0.01" class="form-control">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="form-group">
                      <span for="companyName" class="col-sm-4 control-span">Contract Fee</span>
                      <div class="col-sm-8">
                        <input value="<?php echo $set->contract_fee; ?>" name="contract_fee" type="number" step="0.01" class="form-control">
                        <span class="help-block"></span>
                      </div>
                    </div>
                    <div class="form-group last">
                      <div class="col-sm-offset-4 col-sm-8">
                        <button id="submit_btn" type="submit" class="btn btn-primary">Save Settings</button>
                      </div>
                    </div>
                  </div>
                </form>
                <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:20px;">
                    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                    <ins class="adsbygoogle" style="display:inline-block;width:728px;height:90px" data-ad-client="ca-pub-4997600402648823" data-ad-slot="1675608998"></ins>
                    <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                    </script>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</section>

<?php include "pages/footer.php"; ?>
