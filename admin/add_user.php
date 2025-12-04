<?php

$title = "Admin | Welcome | Your loan gateway system";
$page = 'partner';
$sub_page = 'add_user';

include 'pages/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = mysqli_real_escape_string($connect, $_POST['search_data']);

  $query = 'SELECT * FROM partners ';
  $query .= "WHERE reg_num = '$data' ";
  $query .= "OR owner_email = '$data' ";
  $query .= "OR trade_name = '$data' ";
  $query .= "OR business_name = '$data' ";

  $result = $connect->query($query);

  if (!$result) {
    $status_msg = 'DATABASE Query Failed! Please contact the webmaster';
    $status_msg = 'CODE: '. $connect->errno .' ERROR: '. $connect->error;
  } else if ($result->num_rows <= 0) {
    $status_msg = 'No business present by the name of: '. $data;

    $result->free_result();
  } else if ($row = $result->fetch_assoc()) {

    $id = $row['id'];
    $name = $row['business_name'];

    $status_msg = 'Business Found! Name: '. $name;

    $result->free_result();
  }
} else {
  $status_msg = null;
}
?>

<?php include "pages/sidebar.php"; ?>

<!--main content start-->
<section id="main-content">
  <section class="wrapper">
    <!-- BASIC FORM ELELEMNTS -->
    <div class="row mt">
      <div class="col-lg-12">
        <div class="form-panel">
          <h4 class="mb"><i class="fa fa-angle-right"></i> Search Partner</h4>
          <form class="form style-form col-sm-12 mb" action="" method="post">
            <div class="form-group col-sm-6 col-xs-12">
              <label class="sr-only" for="email">Search Partner Text</label>
              <input type="text" class="form-control" id="search_partner" placeholder="Enter Registration, Email, Trade Name or Business Name" name="search_data">
              <small><?php echo $status_msg; ?></small>
            </div>
            <button type="submit" class="btn btn-theme col-sm-2 col-xs-12">Search</button>
          </form>

          <h4 class="mb col-xs-12"><i class="fa fa-angle-right"></i> Partner Employee Details</h4>
          <form class="form-horizontal style-form" action="proc_form.php?ops=add+user<?php echo (isset($id)) ? '&partner_no='. $id : ''; ?>" method="post">

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

            <div id="emp-cred-container">

            </div>

            <div class="form-group text-center">
              <button id="add-emp-user" style="width: 150px;" class="btn btn-theme03" type="button" name="emp_user"><i class="fa fa-plus-square"></i> Employee User</button>
              <button id="remove-emp-user" style="width: 150px;" class="btn btn-theme04" type="button" name="emp_user"><i class="fa fa-minus-square"></i> Employee User</button>
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


<?php $page = $sub_page; ?>

<?php require "pages/footer.php"; ?>
