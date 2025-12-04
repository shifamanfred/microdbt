<?php
$title = "Manage Clients";
$page = 'client_search';
$sub_page = 'search_client_page';

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
        <div class="col-lg-12">
          <?php include 'includes/top_panel.php'; ?>

          <div class="container-fluid">
            <h1 class="page-header text-center">Customer Search</h1>
            <p class="text-center">Search customer by ID number, name, surname, phone number, etc.</p>

            <form class="form-inline" action="index.html" method="post" role="form">
              <div class="text-center">
                <div class="form-group">
                  <label class="sr-only" for="search-input">Search Customer</label>
                  <input type="search" class="form-control" id="search-input" placeholder="Search Customer">
                </div>

                <button id="search-btn" class="btn btn-theme" type="button" name="submit_search"> <i class="fa fa-search"></i> Search</button>
              </div>
            </form>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  main">
              <div class="row">
                <div class="col-md-12">
                  <div class="content-panel table-panel">
                    <table id="table-results" class="table table-striped table-advance table-hover">
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
                      <tbody id="results-body">

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
  </section>
</section>

<?php $page = $sub_page; ?>

<?php include "includes/footer.php"; ?>
