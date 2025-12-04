<?php
$title = "Admin | Welcome | Your loan gateway system";
$page = 'billing';
$sub_page = 'quote';

include 'pages/header.php';

$query = 'SELECT order_id, user_id, order_date, order_receiver_name, order_receiver_address ';
$query .= ', order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax ';
$query .= ', order_amount_paid, order_total_amount_due, note ';
$query .= ', business_name, owner_last_name, owner_email, postal ';
$query .= 'FROM invoice_orders JOIN partners ON (user_id = `id`) ';
$query .= 'WHERE order_type = \'QUOTE\'; ';

?>

<?php include "pages/sidebar.php"; ?>

<section id="main-content">
  <section class="wrapper">
    <h3><i class="fa fa-angle-right"></i> Quotations</h3>
    <div class="row mt">
      <div class="col-md-12">
        <div class="content-panel">
          <table class="table table-striped table-advance table-hover">
            <h4><i class="fa fa-angle-right"></i> Quotes</h4>
            <hr>
            <thead>
              <tr>
                <th><i class="fa fa-bullhorn"></i> Company</th>
                <th class="hidden-phone"><i class="fa fa-question-circle"></i> Address</th>
                <th><i class="fa fa-bookmark"></i> Date Quoted</th>
                <th><i class="fa fa-bookmark"></i> Expiry Date</th>
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
                <td colspan="2" class="text-info">No quotation records present</td>
              <?php } else {
                while($row = mysqli_fetch_assoc($result)) {
                  $link = "invoice_view.php?inv_id={$row['order_id']}&part_id={$row['user_id']}";
              ?>
              <tr>
                <td>
                  <a href="<?php echo $link; ?>"><?php echo $row['business_name']; ?></a>
                </td>
                <td class="hidden-phone"><?php echo $row['postal']; ?></td>
                <td><?php echo $row['order_date']; ?></td>
                <td><span class="label label-info label-mini"><?php echo $row['note']; ?></span></td>
                <td>
                  <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                  <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                  <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
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
