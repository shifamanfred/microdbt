<?php

include 'includes/security.php';

$set = new CompanySettings($connect);

if (isset($_GET['id'])) {
  $repay_id = intval($_GET['id']);
} else {
  header('Location: repayments.php?repayment=null&msg=Failed to show repayment details');
}

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

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Business');
$pdf->SetTitle('Contract File');
$pdf->SetSubject('Loan Contract');
$pdf->SetKeywords('TCPDF, PDF, loan, contract, business, borrower');

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

// add a page
$pdf->AddPage();

// write the necessary html here

// TODO: TIME TO ECHO OUT DATA!!!

// TODO: fill in installment Due dates

// my includes
require_once('../config/db_connect.php');
include_once('./includes/classes.php');

$repayment_obj = new Repayment($connect, $repay_id);

$loan_account = new LoanAccount($connect, $repayment_obj->account_id);

$borrower_obj = $loan_account->getBorrowerObject($connect);

$partner_obj = $loan_account->getPartnerObject($connect);


// head - contains the raw css styles
$html = '
<div class="invoice-body">
			<div class="row">
        <div class="pull-left col-xs-9">
        <small><strong>From:</strong></small>
				<h3>'. $borrower_obj->name .' '. $borrower_obj->last_name .'</h3>
				<address>
					'. $borrower_obj->address == '' ? $borrower_obj->address2 : $borrower_obj->address .'<br>
					'. $borrower_obj->country .'<br>
					<abbr title="Phone">P:</abbr> '. $borrower_obj->phone .'
				</address>
			</div>
			<!-- /pull-left -->
			<div class="pull-right col-xs-3">
        <small><strong>To:</strong></small>
        <h4>'. $partner_obj->business_name .'</h4>
        <address>
          '. $partner_obj->physical . ' ' . $partner_obj->street .'<br>
          '. $partner_obj->town .', '. $partner_obj->country .'<br>
          '. $partner_obj->postal .' <br>
          <abbr title="Phone">P:</abbr> '. $partner_obj->phone .'
        </address>
			</div>
    </div>
			<!-- /pull-right -->
			<div class="clearfix"></div>
			<br>
      <br>
			<div class="row">
				<div class="col-md-9">
          <div>
						<div class="pull-left"> Receipt NO : </div>
						<div class="pull-left">'. sprintf('%010d', $repay_id) .' </div>
						<div class="clearfix"></div>
					</div>
					<div>
						<!-- /col-md-3 -->
						<div class="pull-left"> RECEIPT DATE : </div>
						<div class="pull-left"> '. date_format(date_create($repayment_obj->pay_date), 'd/m/Y') .'</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<!-- /col-md-9 -->
				<div class="col-md-3">
					<br>

					<!-- /row -->
					<br>
					<div class="well well-small green">
						<div class="pull-left"> Disbursement Amount : </div>
						<div class="pull-right"> '. $loan_account->base_amount .' </div>
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
						<th style="width:140px" class="text-right">DATE</th>
						<th style="width:90px" class="text-right">TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td class="text-center">1</td>
						<td>LOAN ACC: ' . $loan_account->loan_alias .'</td>
						<td class="text-right">'. date_format(date_create($loan_account->approved_date), 'd/m/Y') .'</td>
						<td class="text-right">'. $loan_account->total_loan .'</td>
					</tr>';

          // display all repayment records assigned to this loan account
          $result = Repayment::getRepaymentRecords($connect, $loan_account->acc_id);

          if ($result != null) {
            $count = 1;
            $total_payment = 0;
            while($rec = $result->fetch_assoc()) {
          $html .= '
					<tr>
						<td class="text-center"><?php echo ++$count; ?></td>
						<td><?php echo $rec['repay_alias']; ?></td>
						<td class="text-right"><?php echo date_format(date_create($rec['pay_date']), 'd/m/Y'); ?></td>
						<td class="text-right"><?php echo $rec['amount']; ?></td>
					</tr>
          ';
            $total_payment += $rec['amount'];
            }
          }

          $html .='
					<tr>
						<td colspan="2" rowspan="4">
							<h4>Terms and Conditions</h4>
							<p>Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.</p>
						<td class="text-right"><strong>Total Payments</strong></td>
						<td class="text-right">'. sprintf("%.2f", $total_payment) .'</td>
					</tr>
					<tr>
						<td class="text-right no-border"><strong>Total Loan</strong></td>
						<td class="text-right">'. $loan_account->total_loan .'</td>
					</tr>
          <tr>
            <td class="text-right no-border" colspan="2">
              <div class="well well-small green row"><div class="col-sm-6 text-left"><strong>Total Due </strong></div> <div class=" col-sm-6 text-right"><strong>'. $loan_account->total_loan - $total_payment .'</strong></div></div>
            </td>
          </tr>
				</tbody>
			</table>
		</div>
';

$pdf->writeHTML($html, true, false, true, false, '');

$html = <<<EOF

EOF;

$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

$pdf->Output('moneyflux_contract.pdf', 'I');

?>
