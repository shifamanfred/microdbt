<?php
$title = "Loan Repayments";
$page = "repayments";
$sub_page = 'view_repayments';
include 'includes/header.php';
?>

<?php include "includes/sidebar.php"; ?>

<?php
// query - pull all loan repayment records that belong to this partner

$query = 'SELECT * ';
$query .= 'FROM repayments JOIN loan_record_view ON (loan_account_id = account_id) ';
$query .= 'WHERE lookup_partner_id = ' . $part_id . ' ';
$query .= 'ORDER BY loan_record_view.pay_date DESC';

$result = $connect->query($query);

if (!$result) {
  $error_msg = 'DATA RETRIEVAL FAILED!!';
}

?>

<section id="main-content">
  <section class="wrapper">
    <div class="col-lg-12 mt">
      <div class="row content-panel">
        <div class="col-lg-10 col-lg-offset-1">
          <?php include "includes/top_panel.php"; ?>
          <div class="invoice-body">
            <div class="container-fluid">
              <?php
              if (isset($_GET['msg'])) {
                if (strpos(strtolower($_GET['msg']), 'success') !== false) {
                  ?>
                  <div class="alert alert-success alert-dismissible mt" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $_GET['msg']; ?>
                  </div>
                <?php } else {?>
                  <div class="alert alert-danger alert-dismissible mt" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $_GET['msg']; ?>
                  </div>
                <?php } ?>
              <?php } ?>
              <h1 class="page-header">Repayments <a href="record_repayment.php" class="btn btn-success pull-right"> <i class="fa fa-edit"> </i>Record Payment</a></h1>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  main">
                <div class="row">
                  <div class="col-md-12">
                    <div class="content-panel">
                      <table class="table table-striped table-advance table-hover">
                        <thead>
                          <tr>
                            <th>REF: </th>
                            <th><i class="fa fa-bullhorn"></i> Customer</th>
                            <th><i class="fa fa-bookmark"></i> Repayment</th>
                            <th><i class="fa fa-credit-card"></i> Total Due</th>
                            <th><i class="fa fa-calendar"></i> Date</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          if (isset($error_msg)) {?>
                            <td class="text text-danger" colspan="2"><?php echo $error_msg; ?></td>
                          <?php } else if (mysqli_num_rows($result) <= 0) {?>
                            <td class="text text-info" colspan="2"><i class="fa fa-info-circle"></i> <?php echo 'No Repayment Records Present'; ?></td>
                          <?php } else {
                            while ($rec = $result->fetch_assoc()) {
                              ?>
                              <tr>
                                <td>
                                  <a href="repayment_details.php?id=<?php echo $rec['id']; ?>&loan_alias=<?php echo $rec['loan_alias']; ?>"><?php echo $rec['repay_alias']; ?></a>
                                </td>
                                <td><?php echo $rec['first_name']. ' ' .$rec['last_name']; ?></td>
                                <td class="hidden-phone"><?php echo $rec['amount']; ?></td>
                                <td><?php echo $rec['total_remain']; ?></td>
                                <td><?php echo $rec['pay_date']; ?></td>
                              </tr>
                              <?php
                            }

                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <!-- /content-panel -->
                  </div>
                  <!-- /col-md-12 -->
                </div>
              </div>
            </div>
            <script src="js/jquery-ui-custom.min.js"></script>
            <script src='js/grid.locale-en.js'></script>
            <script src='js/jquery.jqGrid.min.js'></script>
            <script>
            jQuery("#list2").jqGrid({
              url:'ajax-client.php',
              datatype: "json",
              colNames:['ID','Customer Name', 'Phone Number', 'Country', 'Action'],
              colModel:[
                {name:'id',index:'id', align:"center"},
                {name:'customerName',index:'customerName', align:"center"},
                {name:'phone',index:'phone', align:"center"},
                {name:'country',index:'country', align:"center"},
                {name:'result',index:'result', align:"center"}
              ],
              rowNum:10,
              rowList:[10,20,30],
              pager: '#pager2',
              recordpos: 'left',
              viewrecords: true,
              sortorder: "asc",
              height: '100%'
            });
            </script>
            <div class="clearfix"></div>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/bootstrap-datepicker.js"></script>
          </div>
        </div>
      </div>
    </div>
  </section>
</section>

<?php include "includes/footer.php"; ?>
