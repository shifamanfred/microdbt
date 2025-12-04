<?php

$title = "Admin | Welcome | Your loan gateway system";
$page = 'products';
$sub_page = 'manage_products';
include 'pages/header.php';
include 'pages/classes.php';
?>

<script>
$(document).ready(function() {
  jQuery('.load-animate').waypoint({
    triggerOnce: true,
    offset: '80%',
    handler: function() {
      jQuery(this).addClass('animated fadeInUp');
    }
  });
});
</script>

<?php include "pages/sidebar.php"; ?>

<?php
// set default product

if (isset($_GET['action']) && isset($_GET['code'])) {
  $action = $_GET['action'];
  $pro_code = $_GET['code'];

  // perform action according to the one passed to this code struct
  switch ($action) {
    case 'default':

      $sql = 'UPDATE company_settings ';
      $sql .= "SET default_pro = '$pro_code' ";

      $action_result = $connect->query($sql);

      if (!$action_result) {
        echo '<br>CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect);
        die ('<br> !! DATABASE QUERY FAILED !!');
      } else {
        $status_change = true;
      }

      break;

    default:
      // code...
      break;
  }
}

$set = new CompanySettings($connect);

?>


<section id="main-content">
  <section class="wrapper">
    <div class="col-lg-12 mt">
      <div class="row content-panel">
        <div class="col-lg-10 col-lg-offset-1">
          <div class="">
            <h1 class="page-header">Products <a href="add_product.php" class="btn btn-success pull-right"> <i class="fa fa-edit"> </i>Add New Product</a></h1>
            <table class="table table-hover">
              <hr>
              <?php

              $result = Product::getProductRecords($connect);

              if (!$result) {
                $error_msg = 'DATA Retrival Failed! Please contact the webmaster';
              }

              ?>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Product Name</th>
                  <th>Product Description</th>
                  <th>Price</th>
                </tr>
              </thead>
              <tbody>

                <?php if (isset($error_msg)) { ?>
                  <tr>
                    <td colspan="3" class="text text-danger"><?php echo $error_msg; ?></td>
                  </tr>
                <?php } else { ?>
                  <?php while ($row = $result->fetch_assoc()) {
                    $product_obj = new Product($connect, $row['code']);
                    ?>
                    <tr <?php echo ($set->default_product == $product_obj->code) ? 'style="background-color: #E0FFFF; "' : '' ?>>
                      <td><?php echo $product_obj->code; ?></td>
                      <td><?php echo $product_obj->pro_name; ?></td>
                      <td><?php echo $product_obj->pro_desc; ?></td>
                      <td><?php echo $product_obj->mrp; ?></td>

                      <td>
                        <a href="./manage_product.php?action=default&code=<?php echo $product_obj->code; ?>" data-toggle="tooltip" title="Assign As Default Product" class="btn btn-success btn-xs"><i class="fa fa-check"></i></a>
                        <a href="edit_product.php?code=<?php echo $product_obj->code; ?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                        <?php if ($set->default_product != $product_obj->code) { ?>
                        <a class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php }
                  $result->free_result();
                }
                ?>
              </tbody>
            </table>
            <div class="col-xs-10 col-sm-11 col-md-11 col-lg-11 col-xs-offset-2 col-sm-offset-1 col-md-offset-1 col-lg-offset-1 main">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:20px;">
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="text-center">
                    <div id="pager2" ></div>
                  </div>
                </div>
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
        </div>
      </div>
    </div>
  </section>
</section>

<?php include "pages/footer.php"; ?>
