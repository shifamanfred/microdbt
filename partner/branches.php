<?php

$title = "Welcome Home | Partner | Your loan gateway system";
$page = "branches";
$sub_page = "view_branches";
include 'includes/header.php';

include 'includes/classes.php';

?>

<?php require "includes/sidebar.php"; ?>
<!--sidebar end-->
<!-- **********************************************************************************************************************************************************
MAIN CONTENT
*********************************************************************************************************************************************************** -->

<?php

// retrieve partner profile
$partner_profile = new Partner($connect, $part_id);

// retrieve all branch records
$result = Branch::getBranchRecords($connect, $part_id);

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
              <h1 class="page-header">Branches <a href="add_branch.php" class="btn btn-success pull-right"> <i class="fa fa-plus-square"></i> Add New Branch</a></h1>
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main">
                <div class="row">
                  <div class="col-md-12">
                    <div class="content-panel">
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
                                  <button class="btn btn-success btn-xs"><i class="fa fa-check"></i></button>
                                  <a href="edit_branch.php?branch_id=<?php echo $rec['id']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                  <button class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></button>
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

<?php require "includes/footer.php"; ?>
