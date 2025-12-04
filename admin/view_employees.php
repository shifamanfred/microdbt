<?php
$page = 'partner';
$sub_page = 'view_employees';
$title = "Admin | Welcome | Your loan gateway system";

include 'pages/header.php';
?>

<?php include "pages/sidebar.php"; ?>

<?php
// query to retrieve all records from partner table
$query = 'SELECT e.`id`, e.first_name, e.last_name, e.email, bus_id, p.business_name, p.status, c.last_login ';
$query .= 'FROM partner_employees e JOIN partners p ON (bus_id = p.`id`) ';
$query .= 'JOIN credentials c ON (e.cred_id = c.`id`);';

?>



<section id="main-content">
  <section class="wrapper">
    <h3><i class="fa fa-angle-right"></i> Partner Employees</h3>
    <div class="row mt">
      <div class="col-md-12">
        <div class="content-panel">
          <table class="table table-striped table-advance table-hover">
            <h4><i class="fa fa-angle-right"></i> Trusted Employee Users</h4>
            <hr>
            <thead>
              <tr>
                <th><i class="fa fa-bullhorn"></i> Business</th>
                <th class="hidden-phone"><i class="fa fa-envelope"></i> Name</th>
                <th><i class="fa fa-envelope"></i> Email</th>
                <th><i class=" fa fa-edit"></i> Last Login</th>
                <th>Business Status</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = $connect->query($query);


              if (!$result) {
                echo '<td class="text-danger">!! DATA QUERY FAILED!!</td>';
                echo '<td class="text-danger">CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect) . '</td>';
              } else if (mysqli_num_rows($result) <= 0) {
                echo '<td class="text-info">No employee records present</td>';
              } else {
                while($row = mysqli_fetch_assoc($result)) {
                  $value = (strtolower($row['status']) != 'active' ? true : false);
              ?>
              <tr>
                <td>
                  <a href="partner_profile.php?id=<?php echo $row['bus_id']; ?>"><?php echo $row['business_name']; ?></a>
                </td>
                <td class="hidden-phone"><?php echo $row['last_name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['last_login']; ?></td>
                <td><span class="label label-<?php echo !$value ? 'success' : 'warning'; ?> label-mini"><?php echo ucfirst(strtolower($row['status'])); ?></span></td>
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
