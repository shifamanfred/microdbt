<?php
$title = "Manage Clients";
$page = 'customer_management';
$sub_page = 'manage_clients';

include 'includes/header.php';
?>

<?php include "includes/sidebar.php"; ?>

<?php

include_once('includes/classes.php');

$result = Borrower::getBorrowersForPartner($connect, $part_id);

if ($result == null) {
  $error_msg = 'DATA RETRIVAL FAILED!! Please contact the webmaster';
}

?>

<section id="main-content">
  <section class="wrapper">
    <div class="col-lg-12 mt">
      <div class="row content-panel">
        <div class="col-lg-10 col-lg-offset-1">
          <?php include 'includes/top_panel.php'; ?>
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
              <h1 class="page-header"><div class="pull-left">Clients</div> <input style="width: 150px; margin-left: 20px;" type="text" class="form-control pull-left" id="search-input" placeholder="Search Client"><a href="add_client.php" class="btn btn-success pull-right"> <i class="fa fa-edit"> </i>Add Customer</a></h1>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  main">
                <div class="row">
                  <div class="col-md-12">
                    <div class="content-panel">
                      <table class="table table-striped table-advance table-hover">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th><i class="fa fa-bullhorn"></i> Client</th>
                            <th class="hidden-phone"><i class="fa fa-question-circle"></i> Email</th>
                            <th><i class="fa fa-telephone"></i> Phone</th>
                            <th><i class=" fa fa-edit"></i> Status</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          if (isset($error_msg)) { ?>
                            <td class="text text-danger" colspan="2"><?php echo $error_msg; ?></td>
                          <?php } else if (mysqli_num_rows($result) <= 0) {?>
                            <td class="text text-info" colspan="2"><i class="fa fa-info-circle"></i> <?php echo 'No Client Records Present'; ?></td>
                          <?php } else {
                            while ($rec = $result->fetch_assoc()) {

                              ?>
                              <tr class="search-records">
                                <td>
                                  <a href="client_profile.php?id=<?php echo $rec['id']; ?>" class="search-data"><?php echo $rec['id_number']; ?></a>
                                </td>
                                <td class="names search-data"><?php echo $rec['first_name'] . ' ' .  $rec['last_name']; ?></td>
                                <td class="hidden-phone email search-data"><?php echo $rec['email']; ?></td>
                                <td class="phone search-data"><?php echo $rec['phone']; ?></td>
                                <td><span class="label label-<?php echo ($status = $rec['cred_id'] != NULL) ? 'info' : 'warning'; ?> label-mini search-data"><?php echo $status ? 'Online' : 'Offline' ?></span></td>
                                <td>
                                  <a href="add_loan.php?client_id=<?php echo $rec['id']; ?>" class="btn btn-success btn-xs"><i class="fa fa-money"></i> Issue Loan: </a>
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

<?php // include search filter; ?>
<?php $filter = true; ?>

<?php $page = $sub_page; ?>

<?php include "includes/footer.php"; ?>
