<?php
$title = "Create Invoice";
$page = 'billing';
$sub_page = 'invoice_view';
include 'pages/header.php';
include 'pages/classes.php';
?>

<aside>
  <div id="sidebar" class="nav-collapse ">
    <!-- sidebar menu start-->
    <ul class="sidebar-menu" id="nav-accordion">
      <p class="centered"><a href="profile.php"><img src="img/ui-sam.jpg" class="img-circle" width="80"></a></p>
      <h5 class="centered"><?php echo $first_name . ' ' . $last_name?></h5>
      <li class="sub-menu">
        <a class="<?php echo isset($page) && $page == 'billing' ? 'active' : '' ?>" href="invoice.php">
          <span><i class="fa fa-chevron-left"></i> Invoices</span>
        </a>
      </li>
    </ul>
    <!-- sidebar menu end-->
  </div>
</aside>

<?php
// Please enter the php from the billing system here
$set = new CompanySettings($connect);

// invoice id
if (! (isset($_GET['inv_id']) && isset($_GET['part_id']))) {
  // http_redirect
  exit;
} else {
  $inv_id = intval($_GET['inv_id']);
  $part_id = intval($_GET['part_id']);
}
?>

<section id="main-content">
  <section class="wrapper">
    <div class="col-lg-12 mt">
      <div class="row content-panel">
        <div class="col-lg-10 col-lg-offset-1">
          <div class="invoice-body">
            <div class="pull-left">
              <h1><?php echo $set->company_name; ?></h1>
              <address>
                <?php echo $set->company_address; ?><br>
                <abbr title="Phone">P:</abbr> <?php echo $set->phone; ?><br>
                <abbr title="Email"><i class="fa fa-envelope"></i>:</abbr> <?php echo $set->email; ?>
              </address>
            </div>
            <?php
            // get invoice details here

            $invoice = new Invoice($connect);

            $invoice_rec = $invoice->getInvoice($inv_id, $part_id);

            $type = strtolower($invoice_rec['order_type']);

            switch ($type) {

              case 'proforma':
                $heading = 'Pro Forma Invoice';
                break;

              case 'quote':
                $heading = 'Quotation';
                break;

              default:
                $heading = 'Invoice';
                break;
            }

            ?>
            <!-- /pull-left -->
            <div class="pull-right">
              <h2><?php echo $heading; ?></h2>
            </div>
            <!-- /pull-right -->
            <div class="clearfix"></div>
            <br>
            <br>
            <br>
            <div class="row">
              <div class="col-md-9">
                <?php
                // obtain partner details to whom the invoice is going to
                $partner = new Partner($connect, $part_id);
                ?>
                <h4><?php echo $partner->owner_name . ' ' . $partner->owner_surname; ?></h4>
                <address>
                  <strong><?php echo $partner->business_name; ?></strong><br>
                  <abbr title="Residential Address">RA:</abbr> <?php echo $partner->physical; ?><br>
                  <abbr title="Postal Address">PA:</abbr> <?php echo $partner->postal; ?>,<br>
                  <?php echo $partner->town; ?>, <?php echo $partner->country; ?> <?php echo $partner->zip_code?><br>
                  <abbr title="Phone">P:</abbr> <?php echo $partner->phone; ?>
                </address>
              </div>

              <!-- /col-md-9 -->
              <div class="col-md-3">
                <br>
                <div>
                  <div class="pull-left"> <?php echo ($type == 'quote' ? strtoupper($type) : 'INVOICE'); ?> NO : </div>
                  <div class="pull-right"> <?php echo $formatted_value = sprintf("%09d", $invoice_rec['order_id']); ?> </div>
                  <div class="clearfix"></div>
                </div>
                <div>
                  <!-- /col-md-3 -->
                  <div class="pull-left"> <?php echo ($type == 'quote' ? strtoupper($type) : 'INVOICE'); ?> DATE : </div>
                  <div class="pull-right"> <?php echo date("d/m/Y", strtotime($invoice_rec['order_date']));?> </div>
                  <div class="clearfix"></div>
                </div>
                <!-- /row -->
                <br>
                <div class="well well-small green">
                  <div class="pull-left"> Total Due : </div>
                  <div class="pull-right"> <?php echo sprintf('%.2f', $invoice_rec['order_total_amount_due']) . ' ' . $set->currency;?> </div>
                  <div class="clearfix"></div>
                </div>
              </div>
              <!-- /invoice-body -->
            </div>
            <!-- /col-lg-10 -->
            <table class="table">
              <thead>
                <tr>
                  <th style="width:60px" class="text-center">QTY</th>
                  <th class="text-left">DESCRIPTION</th>
                  <th style="width:140px" class="text-right">UNIT PRICE</th>
                  <th style="width:90px" class="text-right">TOTAL</th>
                </tr>
              </thead>
              <tbody>

                <?php
                // get invoice product items
                $data = $invoice->getInvoiceItems($inv_id);

                while($rec = $data->fetch_assoc()) {
                  $pro_obj = new Product($connect, $rec['item_code']);
                ?>
                <tr>
                  <td class="text-center"><?php echo intval($rec['order_item_quantity']); ?></td>
                  <td><?php echo $pro_obj->pro_name; ?></td>
                  <td class="text-right"><?php echo $set->getCurrency() . $rec['order_item_price']; ?></td>
                  <td class="text-right"><?php echo $set->getCurrency() . $rec['order_item_final_amount']; ?></td>
                </tr>
                <?php
                }
                $data->free_result();
                ?>
                <tr>
                  <td colspan="2" rowspan="6">
                    <h4>Terms and Conditions</h4>
                    <p>Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.</p>
                  </td>
                  <td class="text-right"><strong>Total (Excl. VAT)</strong></td>
                  <td class="text-right"><?php echo $set->getCurrency() . $invoice_rec['order_total_before_tax']; ?></td>
                </tr>
                <tr>
                  <td class="text-right no-border"><strong>Tax</strong></td>
                  <td class="text-right"><?php echo $set->getCurrency() . $invoice_rec['order_total_tax']; ?></td>
                </tr>
                <tr>
                  <td class="text-right no-border"><strong>Amount Paid</strong></td>
                  <td class="text-right"><?php echo $set->getCurrency() . $invoice_rec['order_amount_paid']; ?></td>
                </tr>
                <tr>
                  <td class="text-right no-border"><strong>Total (Incl. VAT)</strong></td>
                  <td class="text-right"><?php echo $set->getCurrency() . $invoice_rec['order_total_after_tax']; ?></td>
                </tr>
                <tr>
                  <td class="text-right no-border" colspan="2">
                    <div class="well well-small green row">
                      <div class="col-sm-6 text-left"><strong>Total Due </strong></div>
                      <div class=" col-sm-6 text-right"><strong><?php echo $set->getCurrency() . $invoice_rec['order_total_after_tax']; ?></strong></div>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td class="text-right no-border" colspan="2">
                    <div class="well well-small row">
                      <div class="col-sm-6 text-left"><a class="btn btn-theme" href="print_invoice.php?inv_id=<?php echo $inv_id; ?>&part_id=<?php echo $part_id; ?>" target="_blank"><i class="fa fa-print"></i> Print</a></div>
                      <div class="col-sm-6 text-right"><a class="btn btn-theme02" href=""> <i class="fa fa-money"></i> Paid</a></div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <br>
            <br>
          </div>
        </div>
      </div>
    </div>
    <!--/col-lg-12 mt -->
  </section>
  <!-- /wrapper -->
</section>


<?php $page = $sub_page; ?>

<?php include "pages/footer.php"; ?>
