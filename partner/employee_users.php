<?php

$title = "Welcome Home | Partner | Your loan gateway system";
$page = "employees";
$sub_page = "employee_users";
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
              <h1 class="page-header">Employees <a href="" class="btn btn-success pull-right"> <i class="fa fa-plus-square"></i> New Employee Request</a></h1>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main">
                <div class="row">
                  <div class="col-md-12">
                    <div class="content-panel">
                      <table class="table table-striped table-advance table-hover">
                        <thead>
                          <tr>
                            <th><i class="fa fa-user"></i> Username</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th class="hidden-phone"><i class="fa fa-envelope"></i> Email</th>
                            <th><i class="fa fa-bookmark"></i> Branch</th>
                            <th></th>
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
                                <td><?php echo $rec['username']; ?></td>
                                <td>
                                  <?php echo $rec['last_name']; ?>
                                </td>
                                <td><?php echo $rec['first_name']; ?></td>
                                <td><?php echo $rec['email']; ?></td>
                                <td><?php echo $branch_name; ?></td>
                                <td>
                                  <button class="btn btn-primary btn-xs" value="<?php echo $rec['id']; ?>"><i class="fa fa-edit"></i></button>
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
