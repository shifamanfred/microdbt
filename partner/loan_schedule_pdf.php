<?php

include 'includes/security.php';

// GET valid loan_id account
if (isset($_GET['loan_id'])) {
  $loan_id = $_GET['loan_id'];
} else {
  header('Location: manage_loans.php?contract=null&msg=Error Displaying Contract Information');
  exit;
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

$loan_obj = new LoanAccount($connect, $loan_id);

$borrower_obj = $loan_obj->getBorrowerObject($connect);

$partner_obj = $loan_obj->getPartnerObject($connect);

// head - contains the raw css styles
$html = '
<div class="content-panel">
  <h4><i class="fa fa-angle-right"></i> Loan Account: '. $loan_obj->loan_alias .'<div style="margin-right: 15px;" class="pull-right mr">Borrower: '. $borrower_obj->name .' '. $borrower_obj->last_name .' </div></h4>
  <table class="table">
    <thead>
      <tr>
        <th>Principle</th>
        <th> + Interest @ <?php echo '. $loan_obj->percent .' %; ?></th>
        <th> + Fees</th>
        <th>Loan Repayable</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>'. $loan_obj->base_amount .'</td>
        <td>'. ($loan_obj->base_amount * $loan_obj->percent / 100) .'</td>

        <td>'. ($charges = ($loan_obj->inst > 1 ? 0 : 350)) .'</td>
        <td>'. $loan_obj->total_loan .'</td>
      </tr>
    </tbody>
  </table>
</div>


<div class="content-panel">
  <h4><i class="fa fa-angle-right"></i> Payment Schedule</h4><hr>
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Due Date</th>
        <th>EMI</th>
        <th>Principle Amount</th>
        <th>Interest</th>
        <th>Balance</th>
      </tr>
    </thead>
    <tbody>
      <h5> <i>&nbsp;</i> Borrower\'s Pay Date: '. date_format(date_create($borrower_obj->pay_date), 'd-m-Y') .'</h5>';


      for ($index = 0; $index < $loan_obj->inst;) {
      $html .= '<tr>
        <td>'. date_format(date_create($borrower_obj->pay_date . ' + '. $index++ . ' month') , "d-m-Y") .'</td>
        <td>'. $loan_obj->emi .'</td>
        <td>'. $loan_obj->base_amount .'</td>
        <td>'. ($loan_obj->base_amount * $loan_obj->percent / 100) .'</td>
        <td>'. ($loan_obj->total_loan - $loan_obj->emi * $index) .'</td>
      </tr>';
      }
$html .= '
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
