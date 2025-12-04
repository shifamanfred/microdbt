<?php
$title = "Create Invoice";
$page = 'billing';
$sub_page = 'create_invoice';
include 'pages/header.php';
include 'pages/classes.php';
?>

<?php include "pages/sidebar.php"; ?>

<?php
  // Please enter the php frm the billing system here
  $set = new CompanySettings($connect);

  if ($_GET['partner_no']) {
    $part_obj = new Partner($connect, $_GET['partner_no']);
  } else {
    $part_obj = null;
  }

?>

<section id="main-content">
  <section class="wrapper">
    <div class="col-lg-12 mt">
      <div class="row content-panel">
        <div class="col-lg-10 col-lg-offset-1">
          <form action="proc_form.php?ops=create+invoice" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
            <div class="load-animate animated fadeInUp">
              <div class="invoice-body">
                <div class="pull-left">
                  <div class="row">
                    <div class="col-sm-12 text-center">
                      Mode:
                      <select id="invoiceType" class="select" name="invoiceType">
                        <option value="INVOICE">Invoice</option>
                        <option value="PROFORMA">Pro Forma</option>
                        <option value="QUOTE">Quote</option>
                      </select>
                    </div>
                    <div class="pull-left">
                      <h1 id="invoiceHeading">Issue Invoice</h1>
                    </div>
                    <div class="pull-right">
                      <h1></h1>
                      <?php
                      // obtain next invoice no:
                      $next_id_sql = 'SELECT `auto_increment` AS "num" ';
                      $next_id_sql .= 'FROM information_schema.TABLES ';
                      $next_id_sql .= "WHERE TABLE_SCHEMA = '$db_name' ";
                      $next_id_sql .= "AND TABLE_NAME = 'invoice_orders'; ";

                      $rec = mysqli_fetch_assoc(mysqli_query($connect, $next_id_sql));
                      ?>
                      <p>INV #: <?php echo $formatted_value = sprintf("%09d", $rec['num'] + 1); ?></p>
                      <p>Date: <?php echo date("d M Y");?></p>
                    </div>

                    <div class="clearfix"></div>

                    <input id="currency" type="hidden" value="<?php echo $set->currency; ?>">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <h3>From</h3>

                        <address>
                          <strong><?php echo $set->company_name; ?></strong><br>
                          <?php echo $set->company_address; ?><br>
                          <abbr title="Phone">P:</abbr> <?php echo $set->phone; ?><br>
                          <abbr title="Email"><i class="fa fa-envelope"></i>:</abbr> <?php echo $set->email; ?>
                        </address>

                      </div>
                      <div class="col-xs-12 col-md-4 col-lg-4 pull-right">
                        <h3>To:</h3>

                        <?php

                        // if partner no has been set display the partner name
                        if ($part_obj) {?>
                        <p><i class="fa fa-building-o"></i> <?php echo $part_obj->business_name; ?></p>
                        <p><i class="fa fa-envelope"></i> <?php echo $part_obj->postal; ?></p>
                        <input id="company-name" type="hidden" class="form-control" name="companyName" placeholder="Company Name" value="<?php echo $part_obj->trade_name; ?>" autocomplete="off">
                        <input class="form-control" type="hidden" rows="3" name="address" id="address" placeholder="Your Address" value="<?php echo $part_obj->postal; ?>">
                      <?php } else {

                        // retrieve company records
                        $sql = 'SELECT `id`, business_name ';
                        $sql .= 'FROM partners ';

                        $result = mysqli_query($connect, $sql);

                        if (!$result) {
                          echo '<span class="text-danger">!! DATA QUERY FAILED!!</span>';
                          echo '<span class="text-danger">CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect) . '</span>';
                          die ('!! DATABASE QUERY FAILED !!');
                        } else {
                          $partners = array();
                        ?>

                        <select id="partner-select" class="" name="partner">
                          <?php while ($rec = mysqli_fetch_assoc($result)) {?>
                          <option value="<?php echo $id = $rec['id']; ?>"><?php echo $rec['business_name']; ?></option>
                          <?php
                            $partners[] = (object) new Partner($connect, $id);
                          }

                          $result->free_result();

                          ?>

                        </select>

                        <div class="form-group">
                          <input id="company-name" type="text" class="form-control" name="companyName" placeholder="Company Name" value="<?php echo $partners[0]->trade_name; ?>" autocomplete="off">
                        </div>
                        <div class="form-group">
                          <textarea class="form-control" rows="3" name="address" id="address" placeholder="Your Address"><?php echo $partners[0]->postal; ?></textarea>
                        </div>
                        <?php } ?>
                      <?php } ?>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <table class="table table-bordered table-hover" id="invoiceItem">
                          <tr>
                            <th width="15%">Item No</th>
                            <th width="40%">Item Name</th>
                            <th width="15%">Quantity</th>
                            <th width="15%">Price</th>
                            <th width="15%">Total</th>
                          </tr>
                          <tr>
                            <!-- <td><input type="text" name="productCode[]" id="productCode_1" class="form-control" autocomplete="off"></td> -->
                            <?php

                            $result = Product::getProductRecords($connect);
                            if (!$result) {
                              echo '<span class="text-danger">!! DATA QUERY FAILED!!</span>';
                              echo '<span class="text-danger">CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect) . '</span>';
                              die ('!! DATABASE QUERY FAILED !!');
                            } else {

                            $products = array();
                            ?>
                            <td>
                              <input id="code_input" list="codelist" name="productCode[]" class="form-control">
                              <datalist id="codelist">
                                <?php while ($row = $result->fetch_assoc()) {
                                  $products[] = (object) new Product($connect, $row['code']);

                                ?>
                                <option value="<?php echo $products[count($products) - 1]->code ?>">
                                <?php } ?>
                              </datalist>

                            <?php $result->free_result();
                            } ?>
                          </td>
                            <td><input type="text" name="productName[]" id="productName_1" class="form-control" autocomplete="off"></td>
                            <td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off" min="1"></td>
                            <td><input type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
                            <td><input type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off" readonly></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <button class="btn btn-sm btn-danger delete" id="removeRows" type="button">- Remove</button>
                        <button class="btn btn-sm btn-success" id="addRows" type="button">+ Add More</button>
                        <button class="btn btn-sm btn-theme" id="clear" type="reset">Clear</button>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <h3>Notes: </h3>
                        <div class="form-group">
                          <textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="your Notes"></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                          <input id="partnerId" type="hidden" value="<?php echo isset($part_obj) ? $part_obj->id : $partners[0]->id; ?>" class="form-control" name="userId">
                          <input id="saveInvoiceBtn" data-loading-type="Saving Invoice" type="submit" name="invoice_btn" value="Save Invoice" class="btn btn-success submit_btn invoice-save-btn">
                        </div>
                      </div>
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <span class="form-inline">
                          <div class="form-group">
                            <label>Subtotal: </label>
                            <?php
                            $currency = $set->getCurrency();
                            ?>
                            <div class="input-group">
                              <div class="input-group-addon currency"><?php echo $currency; ?></div>
                              <input value="" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal" readonly>
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Tax Rate: </label>
                            <div class="input-group">
                              <input value="" type="number" class="form-control" name="taxRate" id="taxRate" placeholder="Tax Rate">
                              <div class="input-group-addon">%</div>
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Tax Amount:  </label>
                            <div class="input-group">
                              <div class="input-group-addon currency"><?php echo $currency; ?></div>
                              <input value="" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount" readonly>
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Total:  </label>
                            <div class="input-group">
                              <div class="input-group-addon currency"><?php echo $currency; ?></div>
                              <input value="" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total" readonly>
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Amount Paid:  </label>
                            <div class="input-group">
                              <div class="input-group-addon currency"><?php echo $currency; ?></div>
                              <input value="" type="number" class="form-control" name="amountPaid" id="amountPaid" placeholder="Amount Paid">
                            </div>
                          </div>
                          <div class="form-group">
                            <label>Amount Due:  </label>
                            <div class="input-group">
                              <div class="input-group-addon currency"><?php echo $currency; ?></div>
                              <input value="" type="number" class="form-control" name="amountDue" id="amountDue" placeholder="Amount Due" readonly>
                            </div>
                          </div>
                        </span>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</section>

<?php $page = $sub_page; ?>

<?php include "pages/footer.php"; ?>
