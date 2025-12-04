<?php

$title = "Welcome Home | Partner | Your loan gateway system";
$page = "budget";
$sub_page = "view_budget";
include 'includes/header.php';

include 'includes/classes.php';

?>

<?php require "includes/sidebar.php"; ?>
<!--sidebar end-->
<!-- **********************************************************************************************************************************************************
MAIN CONTENT
*********************************************************************************************************************************************************** -->

<?php

// retrieve all budget records
$result = PartnerBudget::getBudgetRecords($connect, $part_id);

if (!$result) {
  $error_msg = 'Data retrieval failed!! Please contact the webmaster';
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

              <?php
              $balance = PartnerBudget::getBudgetCredited($connect, $part_id);
              $balance -= PartnerBudget::getBudgetDebited($connect, $part_id);

              $set = new CompanySettings($connect);
              ?>
              <h1 class="page-header">My Budget <small>[<?php echo $set->getCurrency() . $balance; ?>]</small> <a style="margin-left: 10px;" href="#" class="btn btn-success pull-right"><i class="fa fa-print"></i> Print</a> <a href="#" data-toggle="modal" data-target="#budget_modal" class="btn btn-success pull-right mr"> <i class="fa fa-plus-square"></i> Add Amount</a></h1>
              <?php unset($set); ?>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main">
                <div class="row">
                  <div class="col-md-12">
                    <div class="content-panel">
                      <table class="table table-striped table-advance table-hover">
                        <thead>
                          <tr>
                            <th><i class="fa fa-info-circle"></i> Status</th>
                            <th><i class="fa fa-dollar"></i> Amount</th>
                            <th class="hidden-phone"><i class="fa fa-question-circle"></i> Description</th>
                            <th><i class="fa fa-bookmark"></i> Budget Type</th>
                            <th><i class="fa fa-calendar"></i> Transaction Date</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          if (isset($error_msg)) {?>
                            <td class="text text-danger" colspan="2"><?php echo $error_msg; ?></td>
                          <?php } else if ($result->num_rows <= 0) {?>
                            <td class="text text-info" colspan="2"><i class="fa fa-info-circle"></i> Budget Records can be entered <a href="#" data-toggle="modal" data-target="#budget_modal"><strong>here &raquo;</strong></a></td>
                          <?php } else {
                            while ($rec = $result->fetch_assoc()) {

                              ?>
                              <tr>
                                <td>
                                  <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
                                </td>
                                <td>
                                  <?php echo $rec['amount']; ?>
                                </td>
                                <td class="hidden-phone"><?php echo $rec['description']; ?></td>
                                <td><?php echo $rec['budget_type']; ?></td>
                                <td><?php echo date_format(date_create($rec['transaction_date']), 'd-m-Y'); ?></td>

                              </tr>
                              <?php
                            }

                            $result->free_result();
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                    <!-- /content-panel -->
                  </div>
                  <!-- /col-md-12 -->
                </div>
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

            <!-- Modal -->
            <div aria-hidden="true" aria-labelledby="branchAssignModal" role="dialog" tabindex="-1" id="budget_modal" class="modal fade">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form class="form" action="proc_form.php?ops=record+budget&part_id=<?php echo $part_id ?>" method="post" role="form">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">Record Amount</h4>
                    </div>
                    <div class="modal-body">


                      <div class="form-group">
                        <label for="budget-amount" class="control-label col-sm-2">Amount</label>
                        <div class="col-sm-10">
                          <input id="budget-amount" value="" name="budget_amount" type="number" step="0.01" class="form-control" placeholder="Amount">
                          <span class="help-block"></span>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="budget-desc" class="control-label col-sm-2">Description</label>
                        <div class="col-sm-10">
                          <input id="budget-desc" value="" name="budget_desc" type="text" class="form-control" placeholder="Description">
                          <span class="help-block"></span>
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="budget-type" class="control-label col-sm-2">Budget&nbsp;Type:</label>
                        <div class="col-sm-10">
                          <select name="budget_type" id="budget-type" class="form-control" aria-invalid="false">
                            <option value="debit">Debit</option>
                            <option value="credit">Credit</option>
                            <option value="transfer">Transfer</option>
                          </select>
                          <span class="help-block"></span>
                        </div>
                      </div>

                      <div id="div-transfer-to" class="form-group">
                        <?php $result = Partner::getPartnerEmployeeResults($connect, $part_id);

                        if (!$result) {?>
                          <label class="text text-danger">Database Error! Please contact the webmaster</label>
                        <?php } else {
                          ?>


                          <label for="budget-type" class="control-label col-sm-2">Transfer&nbsp;To:</label>
                          <div class="col-sm-10">
                            <select name="transfer_to" id="transfer-to" class="form-control" aria-invalid="false">
                              <?php

                              while ($rec = $result->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $rec['id']; ?>"><?php echo $rec['first_name'] . ' ' . $rec['last_name']; ?></option>
                              <?php  } ?>
                              <option value="0">Other</option>
                            <?php  } ?>
                          </select>
                          <span class="help-block"></span>
                        </div>
                      </div>

                      <div id="div-transfer-to-other">

                      </div>

                      <div class="clearfix"></div>

                    </div>
                    <div class="modal-footer centered">
                      <button data-dismiss="modal" class="btn btn-theme04" type="button">Cancel</button>
                      <button class="btn btn-theme03" type="submit">Record</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- Modal (ENDING) -->
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

<?php require "includes/footer.php"; ?>
