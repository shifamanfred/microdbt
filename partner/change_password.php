<?php
$title = "Change User Password";
$page = "profile";
$sub_page = 'change_password';

$change_password = true;

include 'includes/header.php';
include "includes/sidebar.php";
include "includes/functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['username']));
  $old_pass = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['old_pass']));
  $new_pass = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['new_pass']));
  $conf = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['conf']));

  $password = emptyStringToNull($password);

  // 1. check if the old password matches
  if ($old_pass === $password) {
    // TODO: check if the new passwords match
    if ($new_pass === $conf) {

      $query = 'UPDATE credentials ';
      $query .= "SET username = $user, password = $new_pass ";
      $query .= 'WHERE id = '. $cred_id;

      $result = $connect->query($query);

      if (!$result) {
        $msg = 'SERVER ERROR! Please contact the webmaster.';
      } else {
        $msg = 'Passowrd Change Successfully! You may click <a href="./index.php"><strong>HERE</strong></a> to begin.';
      }
    } else {
      $msg = 'ERROR! Password missmatch.';
    }
  } else {
    $msg = 'Error! Wrong password';
  }

  $_GET['msg'] = $msg;
}

?>

<!--main content start-->
<section id="main-content">
  <section class="wrapper site-min-height">
    <h3><i class="fa fa-angle-right"></i> Change Password</h3>
    <div class="row mt">
      <div class="col-lg-12">
        <div class="form-panel">
          <?php include "includes/alert_dialog.php"; ?>
          <h4 class="mb"><i class="fa fa-angle-right"></i> Please fill in the necessary credentials</h4>
          <form id="change-password-form" class="form-horizontal style-form" action="change_password.php" method="post">
            <div class="form-group">
              <label class="col-sm-3 control-label">Username</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="username" value="<?php echo $username ?>" placeholder="Username">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">Old Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" name="old_pass" placeholder="Old Password">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-3 control-label">New Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" name="new_pass" placeholder="New Password">
              </div>
            </div>

            <div id="conf-container" class="form-group">
              <label class="col-sm-3 control-label">Confirm New Password <small>(Please enter new Password Again)</small> </label>
              <div class="col-sm-9">
                <input type="password" class="form-control" name="conf" placeholder="Confirm New Password">
                <p id="conf-container-msg" class="help-block"></p>
              </div>
            </div>

            <div class="form-group text-center last-group">
              <button type="submit" name="change_password_btn" class="btn btn-theme">Change Password</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</section>


<?php $page = $sub_page; ?>

<?php include "includes/footer.php"; ?>
