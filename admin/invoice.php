<?php
$page = 'billing';
$sub_page = 'invoice';
$title = "Admin | Welcome | Your loan gateway system";
include 'pages/header.php';
?>

<?php include "pages/sidebar.php"; ?>

<?php
$query = 'SELECT order_id, user_id, order_date, order_receiver_name, order_receiver_address ';
$query .= ', order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax ';
$query .= ', order_amount_paid, order_total_amount_due, order_type, note ';
$query .= ', business_name, owner_last_name, owner_email, postal ';
$query .= 'FROM invoice_orders JOIN partners ON (user_id = `id`) ';
$query .= 'WHERE order_type <> \'QUOTE\' ';
$query .= 'ORDER BY order_date DESC;'
?>

<section id="main-content">
  <section class="wrapper">
    <h3><i class="fa fa-angle-right"></i> Invoices</h3>
    <div class="row mt">
      <div class="col-md-12">
        <div class="content-panel">
          <?php include "./pages/alert_dialog.php" ?>
          <table class="table table-striped table-advance table-hover">
            <h4><i class="fa fa-angle-right"></i> Transactions</h4>
            <hr>
            <thead>
              <tr>
                <th>#</th>
                <th><i class="fa fa-bullhorn"></i> To: </th>
                <th class="hidden-phone"><i class="fa fa-question-circle"></i> Type</th>
                <th><i class="fa fa-bookmark"></i> Date Invoiced</th>
                <th><i class="fa fa-bookmark"></i> Amount Due</th>
                <th><i class=" fa fa-edit"></i> Manage</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php
              $result = mysqli_query($connect, $query);

              if (!$result) {
                echo '<td class="text-danger">!! DATA QUERY FAILED!!</td>';
                echo '<td class="text-danger">CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect) . '</td>';
              } else if (mysqli_num_rows($result) <= 0) {?>
                <td colspan="2" class="text-info">No invoice records present</td>
              <?php } else {
                while($row = mysqli_fetch_assoc($result)) {
              ?>
              <tr>
                <td>
                  <?php
                  $link = "invoice_view.php?inv_id={$row['order_id']}&part_id={$row['user_id']}";
                  ?>
                  <a href="<?php echo $link; ?>">
                    <?php echo $row['order_id'] ?>
                  </a>
                </td>
                <td><a href="<?php echo $link; ?>"><?php echo $row['business_name']; ?></a></td>
                <td class="hidden-phone"><?php echo $row['order_type']; ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td><?php echo $row['order_total_amount_due']; ?></td>
                <td>
                  <form class="form" action="proc_form.php?ops=invoice+operation&inv_id=<?php echo $row['order_id'] ?>" method="post">
                    <button class="btn btn-success btn-xs" name="inv" value="check"><i class="fa fa-check"></i></button>
                    <button class="btn btn-primary btn-xs" name="inv" value="edit"><i class="fa fa-pencil"></i></button>
                    <button class="btn btn-danger btn-xs" type="submit" name="inv" value="del"><i class="fa fa-trash-o "></i></button>
                  </form>
                </td>
              </tr>
              <?php }
                mysqli_free_result($result);

              }
              ?>
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


<?php include "pages/footer.php"; ?>
