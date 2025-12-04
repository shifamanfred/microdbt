<?php
$title = "Create Invoice";
$page = "loans";
$sub_page = 'view_loans';
include 'includes/header.php';
?>

<?php include "includes/sidebar.php"; ?>

<?php
// query - pull all loan records that belong to this partner
$query = 'SELECT * ';
$query .= 'FROM loan_record_view ';
$query .= 'WHERE lookup_partner_id = ' . $part_id . ' ';
$query .= 'ORDER BY disbursed_at DESC, approved_at DESC, created_at DESC';

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
              <h1 class="page-header">Manage Loans <a href="add_loan.php" class="btn btn-success pull-right"> <i class="fa fa-edit"> </i>Add Loan</a></h1>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  main">
                <!--  BUTTONS GROUP -->
                <div class="showback">
                  <h4><i class="fa fa-angle-right"></i> Loan Category</h4>
                  <div class="btn-group">
                    <button id="disburse-btn" type="button" class="btn btn-default">Disbursed</button>
                    <button id="approve-btn" type="button" class="btn btn-default">Approved</button>
                    <button id="decline-btn" type="button" class="btn btn-default">Declined</button>
                    <button id="settle-btn" type="button" class="btn btn-default">Settled</button>
                    <button id="pending-btn" type="button" class="btn btn-default">Pending</button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="content-panel">
                      <table class="table table-striped table-advance table-hover loan-table">
                        <thead>
                          <tr>
                            <th>ACCOUNT: </th>
                            <th><i class="fa fa-bullhorn"></i> Customer</th>
                            <th class="hidden-phone"><i class="fa fa-question-circle"></i>Installments</th>
                            <th><i class="fa fa-percent"></i></th>
                            <th><i class="fa fa-bookmark"></i> Total Loan</th>
                            <th><i class=" fa fa-edit"></i> Status</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          if (isset($error_msg)) {?>
                            <td class="text text-danger" colspan="2"><?php echo $error_msg; ?></td>
                          <?php } else if (mysqli_num_rows($result) <= 0) {?>
                            <td class="text text-info" colspan="2"><i class="fa fa-info-circle"></i> <?php echo 'No Loan Records Present'; ?></td>
                          <?php } else {
                            while ($rec = $result->fetch_assoc()) {

                              // change styles according to loan status
                              switch ($rec['status']) {
                                case 'APPROVED':
                                  $label_attr = 'primary';
                                  break;

                                case 'DISBURSED':
                                  $label_attr = 'success';
                                  break;

                                case 'SETTLED':
                                  $label_attr = 'info';
                                  break;

                                case 'DECLINED':
                                  $label_attr = 'warning';
                                  break;

                                default:
                                  $label_attr = 'default';
                                  break;
                              }

                              ?>
                              <tr class="loan-record <?php echo strtolower($rec['status']); ?>">
                                <td>
                                  <a href="loan_details.php?id=<?php echo $rec['account_id']; ?>&loan_alias=<?php echo $rec['loan_alias']; ?>"><?php echo $rec['loan_alias']; ?></a>
                                </td>
                                <td><?php echo $rec['first_name']. ' ' .$rec['last_name']; ?></td>
                                <td class="hidden-phone"><?php echo $rec['installments']; ?></td>
                                <td><?php echo $rec['percentage']; ?>%</td>
                                <td><?php echo $rec['total_loan']; ?></td>
                                <td class="text-center loan_status"><span class="label label-<?php echo $label_attr; ?> label-mini"><?php echo $rec['status']; ?></span></td>
                                <td>
                                  <?php if ($rec['status'] == 'PENDING') { ?>
                                  <button class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></button>
                                  <?php } ?>

                                  <?php if ($rec['status'] != 'DISBURSED' && $rec['status'] != 'SETTLED') { ?>
                                  <button class="btn btn-danger btn-xs" data-toggle="tooltip" title="Cancel Loan"><i class="fa fa-times-circle"></i></button>
                                  <?php } ?>
                                </td>
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

<?php $page = $sub_page; ?>

<?php include "includes/footer.php"; ?>
