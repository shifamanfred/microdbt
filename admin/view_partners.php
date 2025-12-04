<?php
$page = 'partner';
$sub_page = 'view_partners';
$title = "Admin | Welcome | Your loan gateway system";

include 'pages/header.php';
?>

<?php include "pages/sidebar.php"; ?>

<?php
// query to retrieve all records from partner table
$query = 'SELECT `id`, business_name AS "Business", owner_email AS "Email", trade_name AS "Trading AS", reg_num AS "Registration Number", income_tax AS "Income Tax", ';
$query .= 'ss_num AS "Social Security", namfisa_reg AS "Namfisa Registration", phone AS "Telephone", cell AS "Cellphone", postal AS "Postal Address", physical AS "Physical Address", street AS "Street", town AS "Town", country AS "Country", zip_code AS "Zip Code", status ';
$query .= 'FROM partners;';

if (isset($_GET['action']) && isset($_GET['id']) && isset($_GET['value'])) {
  $action = $_GET['action'];
  $partner_id = $_GET['id'];
  $value = $_GET['value'] == 'true' ? true : false;

  switch ($action) {
    case 'status':
      // toggle status account for partner
      $value = strtoupper($value ? 'active' : 'inactive');


      $sql = 'UPDATE partners ';
      $sql .= "SET status = '$value' ";
      $sql .= 'WHERE id = ' . $partner_id;

      $status_result = $connect->query($sql);

      if (!$status_result) {
        echo '<br>CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect);
        die ('<br> !! DATABASE QUERY FAILED !!');
      } else {
        $status_change = true;
      }

      break;

    default:
      // code...
      break;
  }
}

?>



<section id="main-content">
  <section class="wrapper">
    <h3><i class="fa fa-angle-right"></i> Registered Partners</h3>
    <div class="row mt">
      <div class="col-md-12">
        <div class="content-panel">
          <?php include "./pages/alert_dialog.php"; ?>
          <table class="table table-striped table-advance table-hover">
            <h4><i class="fa fa-angle-right"></i> Trusted Businesses</h4>
            <hr>
            <thead>
              <tr>
                <th><i class="fa fa-bullhorn"></i> Partner</th>
                <th class="hidden-phone"><i class="fa fa-envelope"></i> Email</th>
                <th><i class="fa fa-bookmark"></i> Trade Name</th>
                <th><i class=" fa fa-edit"></i> Status</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = $connect->query($query);

              if (!$result) {
                echo '<td colspan="2" class="text-danger">!! DATA QUERY FAILED!!</td>';
                echo '<td colspan="3" class="text-danger">CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect) . '</td>';
              } else if (mysqli_num_rows($result) <= 0) {
                echo '<td class="text-info">No partner records present</td>';
              } else {
                while($row = mysqli_fetch_assoc($result)) {
                  $value = (strtolower($row['status']) != 'active' ? true : false);
              ?>
              <tr <?php echo $value ? '': 'style="background-color: #E0FFFF; "'; ?>>
                <td>
                  <a href="partner_profile.php?id=<?php echo $row['id']; ?>"><?php echo $row['Business']; ?></a>
                </td>
                <td class="hidden-phone"><?php echo $row['Email']; ?></td>
                <td><?php echo $row['Trading AS']; ?></td>
                <td><span class="label label-<?php echo !$value ? 'success' : (strtolower($row['status']) == 'contract' ? 'default' : 'warning'); ?> label-mini"><?php echo ucfirst(strtolower($row['status'])); ?></span></td>
                <td>
                  <form class="form" action="proc_form.php?ops=partner+activate&part_id=<?php echo $row['id']; ?>&value=<?php echo $value ? 'true' : 'false' ?>" method="post">
                    <button type="submit" data-toggle="tooltip" title="Activate Partner's Subscription" name="partner_state" value="status change" class="btn btn-<?php echo $value ? 'success' : 'default' ?> btn-xs"><i class="fa fa-<?php echo $value ? 'check' : 'close' ?>"></i></button>
                    <a href="partner_profile.php?mode=edit&id=<?php echo $row['id']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                  </form>
                </td>
              </tr>
              <?php }

              mysqli_free_result($result);
              }?>
            </tbody>
          </table>
        </div>
        <!-- /content-panel -->
      </div>
      <!-- /col-md-12 -->
    </div>
    <!-- /row -->
  </section>
</section>
<!-- /MAIN CONTENT -->
<!--main content end-->
<?php require "pages/footer.php"; ?>
