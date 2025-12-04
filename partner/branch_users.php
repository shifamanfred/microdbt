<?php

$title = "Welcome Home | Partner | Your loan gateway system";
$page = "branches";
$sub_page = "branch_users";
include 'includes/header.php';
include 'includes/classes.php';

?>

<?php require "includes/sidebar.php"; ?>
<!--sidebar end-->
<!-- **********************************************************************************************************************************************************
MAIN CONTENT
*********************************************************************************************************************************************************** -->

<?php

$result = Partner::getPartnerEmployeeResults($connect, $part_id);

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
              <h1 class="page-header">Employees <a href="add_branch.php" class="btn btn-success pull-right"> <i class="fa fa-plus-square"></i> Add New Branch</a></h1>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main">
                <div class="row">
                  <div class="col-md-12">
                    <div class="content-panel">
                      <table class="table table-striped table-advance table-hover">
                        <thead>
                          <tr>
                            <th><i class="fa fa-bullhorn"></i> Employee Name</th>
                            <th class="hidden-phone"><i class="fa fa-envelope"></i> Email</th>
                            <th><i class="fa fa-bookmark"></i> Branch</th>
                            <th>Assign</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php
                          if (isset($error_msg)) {?>
                            <td class="text text-danger" colspan="3"><?php echo $error_msg; ?></td>
                          <?php } else if ($result->num_rows <= 0) {?>
                            <td class="text text-info" colspan="3"><i class="fa fa-info-circle"></i> <?php echo 'No Employee Records Present. Please submit requests to add employees'; ?></td>
                          <?php } else {

                            while ($rec = $result->fetch_assoc()) {
                              if ($rec['branch_id'] == 0) {
                                $branch_name = 'MAIN BRANCH';
                              } else {
                                $branch_obj = new Branch($connect, $rec['branch_id']);

                                $branch_name = $branch_obj->name;
                              }

                              ?>
                              <tr>
                                <td>
                                  <?php echo $rec['first_name'] . ' ' . $rec['last_name']; ?>
                                </td>
                                <td class="hidden-phone"><?php echo $rec['email']; ?></td>
                                <td><?php echo $branch_name; ?></td>
                                <td>
                                  <button class="change-branch btn btn-primary btn-xs" data-toggle="modal" data-target="#branchModal" value="<?php echo $rec['id']; ?>"><i class="fa fa-retweet"></i></button>
                                </td>
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

                <!-- Modal -->
                <div aria-hidden="true" aria-labelledby="branchAssignModal" role="dialog" tabindex="-1" id="branchModal" class="modal fade">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Assign To Branch</h4>
                      </div>
                      <div class="modal-body">
                        <table class="table table-striped table-advance table-hover">
                          <thead>
                            <tr>
                              <th><i class="fa fa-bullhorn"></i> Branch</th>
                              <th class="hidden-phone"><i class="fa fa-question-circle"></i> Location</th>
                              <th><i class="fa fa-bookmark"></i> Town</th>
                              <th></th>
                            </tr>
                          </thead>
                          <tbody>

                            <?php

                            // retrieve partner profile
                            $partner_profile = new Partner($connect, $part_id);

                            // retrieve all branch records
                            $result = Branch::getBranchRecords($connect, $part_id);

                            if (!$result) {
                              $error_msg = 'Data retrieval failed!! Please contact the webmaster';
                            }

                            if (isset($error_msg)) {?>
                              <td class="text text-danger" colspan="2"><?php echo $error_msg; ?></td>
                            <?php } else {

                              // show main branch first
                              ?>
                              <tr class="text-info">
                                <td>
                                  <?php echo 'MAIN BRANCH'; ?>
                                </td>
                                <td class="hidden-phone"><?php echo $partner_profile->physical; ?></td>
                                <td><?php echo $partner_profile->town; ?></td>
                                <td>
                                  <form class="form branch-form" action="" method="post">
                                    <button class="btn btn-success btn-xs" type="submit" name="branch-btn" value="0"><i class="fa fa-check"></i></button>
                                  </form>
                                </td>
                              </tr>
                              <?php

                              while ($rec = $result->fetch_assoc()) {

                                ?>
                                <tr>
                                  <td>
                                    <?php echo $rec['branch_name']; ?>
                                  </td>
                                  <td class="hidden-phone"><?php echo $rec['location']; ?></td>
                                  <td><?php echo $rec['town']; ?></td>
                                  <td>
                                    <form class="form branch-form" action="" method="post">
                                      <button class="btn btn-success btn-xs" type="submit" name="branch-btn" value="<?php echo $rec['id']; ?>"><i class="fa fa-check"></i></button>
                                    </form>
                                  </td>
                                </tr>
                                <?php
                              }

                              $result->free_result();
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer centered">
                        <button data-dismiss="modal" class="btn btn-theme04" type="button">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal (ENDING) -->

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
