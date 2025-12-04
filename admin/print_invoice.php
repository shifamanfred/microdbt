<?php


$real_path = '../plugins/tcpdf/';

require_once($real_path . 'tcpdf_include.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

  //Page header
	public function Header() {
		// Logo
    $headerData = $this->getHeaderData();
    $this->SetFont('helvetica', 'B', 10);
    $this->writeHTML($headerData['string']);
	}
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);



// set default header data


// company logo goes here

// TODO: insert company logo here
$header_html = '
    <div style="text-align: right; margin-top: 20px; border 1px solid green;">
      <h6>&nbsp;</h6>
      <img style="margin-top: 20px; height: 25px;" src="">
    </div>
    <hr> ';

$pdf->SetHeaderData($ln='', $lw=0, $ht='', $hs=$header_html, $tc=array(0, 0, 0), $lc=array(0, 0, 0));

// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);



 /*
  * write the necessary pdf content here
  */

// the includes
require_once '../config/db_connect.php';
include_once './pages/classes.php';

// the objects
$set = new CompanySettings($connect);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($set->company_name);
$pdf->SetTitle('Invoice File');
$pdf->SetSubject('Partner Invoice');
$pdf->SetKeywords('TCPDF, PDF, loan, contract, business, borrower');

// add a page
$pdf->AddPage();




// Please enter the php from the billing system here
$set = new CompanySettings($connect);

// invoice id
if (! (isset($_GET['inv_id']) && isset($_GET['part_id']))) {
  // http_redirect

  $html ='<h1 style="color: red">Invalid URL</h1>';

  $pdf->writeHTML($html, true, false, true, false, '');

  $html = <<<EOF

  EOF;

  $pdf->writeHTML($html, true, false, true, false, '');

  // reset pointer to the last page
  $pdf->lastPage();

  $pdf->Output($set->company_name .'_invoice.pdf', 'I');
  exit;
} else {
  $inv_id = intval($_GET['inv_id']);
  $part_id = intval($_GET['part_id']);
}

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

// obtain partner details to whom the invoice is going to
$partner = new Partner($connect, $part_id);


// head - contains the raw css styles
$html = '
<style>
 div.invoice-body {
   font-size: small
 }
</style>';

$html .= '<div class="invoice-body">
            <p>FROM:</p>
            <h1>'. $set->company_name .'</h1>
            <address>
              '. $set->company_address .'<br>
              <abbr title="Phone">P:</abbr> '. $set->phone .'<br>
              <abbr title="Email"><i class="fa fa-envelope"></i>:</abbr> '. $set->email .'
            </address>
            <p>TO:</p>
            <div class="row">
              <div class="col-md-9">
                <h4>'. $partner->owner_name . ' ' . $partner->owner_surname .'</h4>
                <address>
                  <strong>'. $partner->business_name .'</strong><br>
                  <abbr title="Residential Address">RA:</abbr> '. $partner->physical .'<br>
                  <abbr title="Postal Address">PA:</abbr>'. $partner->postal .',<br>
                  '. $partner->town .', '. $partner->country .' '. $partner->zip_code .'<br>
                  <abbr title="Phone">P:</abbr>'. $partner->phone .'
                </address>
              </div>

              <!-- /col-md-9 -->
              <div class="col-md-3">
                <br>
                <div>
                  <div class="pull-left"> '. ($type == 'quote' ? strtoupper($type) : 'INVOICE') .' NO : </div>
                  <div class="pull-right">'. $formatted_value = sprintf("%09d", $invoice_rec['order_id']) .' </div>
                  <div class="clearfix"></div>
                </div>
                <div>
                  <!-- /col-md-3 -->
                  <div class="pull-left"> '. ($type == 'quote' ? strtoupper($type) : 'INVOICE') .' DATE : </div>
                  <div class="pull-right"> '. date("d/m/Y", strtotime($invoice_rec['order_date'])) .'</div>
                  <div class="clearfix"></div>
                </div>
                <!-- /row -->
                <br>
                <div class="well well-small green">
                  <div class="pull-left"> Total Due : </div>
                  <div class="pull-right"> '. sprintf('%.2f', $invoice_rec['order_total_amount_due']) . ' ' . $set->currency .' </div>
                  <div class="clearfix"></div>
                </div>
              </div>
              <!-- /invoice-body -->
            </div>
            <!-- /col-lg-10 -->
            <table class="table">
              <thead>
                <tr>
                  <th style="" class="text-center">QTY</th>
                  <th class="text-left">DESCRIPTION</th>
                  <th style="" class="text-right">UNIT PRICE</th>
                  <th style="" class="text-right">TOTAL</th>
                </tr>
              </thead>
              <tbody>';

                // get invoice product items
                $data = $invoice->getInvoiceItems($inv_id);


                while($rec = $data->fetch_assoc()) {
                  $pro_obj = new Product($connect, $rec["item_code"]);

                $html .= '
                <tr>
                  <td class="text-center">'. intval($rec["order_item_quantity"]) .'</td>
                  <td>'. $pro_obj->pro_name .'</td>
                  <td class="text-right">'. $set->getCurrency() . $rec["order_item_price"] .'</td>
                  <td class="text-right">'. $set->getCurrency() . $rec["order_item_final_amount"] .'</td>
                </tr>';
                }

                $data->free_result();


                $html .= '
                <tr>
                  <td colspan="2" rowspan="6">
                    <h4>Terms and Conditions</h4>
                    <p>Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.</p>
                  </td>
                  <td class="text-right"><strong>Total (Excl. VAT)</strong></td>
                  <td class="text-right">'. $set->getCurrency() . $invoice_rec["order_total_before_tax"] .'</td>
                </tr>
                <tr>
                  <td class="text-right no-border"><strong>Tax</strong></td>
                  <td class="text-right">'. $set->getCurrency() . $invoice_rec["order_total_tax"] .'</td>
                </tr>
                <tr>
                  <td class="text-right no-border"><strong>Amount Paid</strong></td>
                  <td class="text-right">'. $set->getCurrency() . $invoice_rec["order_amount_paid"] .'</td>
                </tr>
                <tr>
                  <td class="text-right no-border"><strong>Total (Incl. VAT)</strong></td>
                  <td class="text-right">'. $set->getCurrency() . $invoice_rec["order_total_after_tax"] .'</td>
                </tr>
                <tr>
                  <td class="text-right no-border" colspan="2">
                    <div class="well well-small green row">
                      <div class="col-sm-6 text-left"><strong>Total Due </strong></div>
                      <div class=" col-sm-6 text-right"><strong>'. $set->getCurrency() . $invoice_rec["order_total_after_tax"] .'</strong></div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <br>
            <br>
          </div>';

$pdf->writeHTML($html, true, false, true, false, '');

$html = <<<EOF

EOF;

$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

$pdf->Output($set->company_name .'_invoice.pdf', 'I');

?>
