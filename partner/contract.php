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
$html = "<style>

  * {
    font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
  }

  div.header-info {
    text-transform: uppercase;
    text-align: center;
  }

  div.header-info span.lowercase {
    text-transform: lowercase;
  }

  .echo {
    font-weight: bold;
  }

  p, ul, ol, li, table, tr, td {
    font-size: 10px;
  }

  table, td {
    border-collapse: collapse;
    padding: 5px;
  }

  table.loan-table tr.table-header {
    font-weight: bold;
  }

  table.loan-table {
    border: 1px solid black;
    border-collapse: collapse;
  }

  table.loan-table td {
    border-right: 1px solid black;
  }

  table.loan-table td.top-line {
    border-top: 1px solid black;
  }

  table.loan-table td.caption {
    border-top: 1px solid black;
  }

  ol.terms li {
    font-weight: bold;
  }

  ol.terms li ol li {
    font-weight: normal;
  }

</style>";

$html .= '<div class="header-info"><h2>'. trim($partner_obj->business_name) .'</h2><h4>'. $partner_obj->postal .' * '. $partner_obj->town .' * '. $partner_obj->phone .' * <span class="lowercase">'. $partner_obj->email .'</span></h4><h4>MEMORANDUM OF AGGREEMENT</h4></div>

    <p>This loan agreement only applies to loans not exceeding a period of <span class="echo">'. $loan_obj->inst .'</span> days.</p>
    <p>Entered into between: <span class="echo">'. $partner_obj->business_name .'</span> (“the Lender”) and <span class="echo">'. $borrower_obj->name . ' ' . $borrower_obj->last_name .'</span> (“the Borrower”)</p>
    <p>BORROWER’S PERSONAL INFORMATION:</p>
    <table>
      <tbody>
        <tr>
          <td>Postal address: <span class="echo">'. $borrower_obj->address .'</span></td>
          <td>Tel no: <span class="echo">'. $borrower_obj->phone .'</span></td>
        </tr>
        <tr>
          <td>Residential address: <span class="echo">'. $borrower_obj->address2 .'</span></td>
          <td>Marital Status: <span class="echo">'. $borrower_obj->marital .'</span></td>
        </tr>
        <tr>
          <td>I.D./Passport No: <span class="echo">'. $borrower_obj->id_num .'</span></td>
          <td>Occupation: <span class="echo">'. $borrower_obj->work_pos .'</span></td>
        </tr>
        <tr>
          <td>Employer Tel no: <span class="echo">'. $borrower_obj->contact_num .'</span></td>
          <td>Employer Name: <span class="echo">'. $borrower_obj->employer .'</span></td>
        </tr>

        <tr>
          <td>Employer Address: <span class="echo">'. $borrower_obj->work_addr .'</span></td>
          <td>Payslip/Employee No: <span class="echo">'. $borrower_obj->work_pos_code .'</span></td>
        </tr>

        <tr>
          <td>Bank: <span class="echo">'. $borrower_obj->bank .'</span></td>
          <td>Branch: <span class="echo">'. $borrower_obj->branch .'</span></td>
        </tr>

        <tr>
          <td>Bank Account No: <span class="echo">'. $borrower_obj->acc_num .'</span></td>
          <td>Type of Account: <span class="echo">'. $borrower_obj->acc_type .'</span></td>
        </tr>
      </tbody>
    </table>

    <table>
      <tbody>
        <h4>References: </h4>
        <tr>
          <td>1. &nbsp;&nbsp; Name: ________________________</td>
          <td>Tel No: _____________________________________</td>
        </tr>
        <tr>
          <td>2. &nbsp;&nbsp; Name: ________________________</td>
          <td>Tel No: _____________________________________</td>
        </tr>
      </tbody>
    </table>

    <table class="loan-table">
        <tr class="table-header">
          <td>LOAN AMOUNT</td>
          <td>TOTAL INTEREST CHARGED AT '. $loan_obj->percent .'% ONCE OFF</td>
          <td>TOTAL REPAYABLE</td>
          <td>INSTALMENT AMOUNT N$</td>
        </tr>
      <tbody>
        <tr>
          <td>Paid to Borrower:</td>
          <td></td>
          <td></td>
          <td></td>
        </tr>

        <tr>
          <td>N$ <span class="echo_output">'. $loan_obj->base_amount .'</span></td>
          <td>N$ '. $loan_obj->base_amount * $loan_obj->percent / 100 .'</td>
          <td>N$ '. $loan_obj->total_loan .'</td>
          <td>N$ '. $loan_obj->emi .'</td>
        </tr>

        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td class="top-line">First instalment due date:<br /><span class="echo">'. date_format(date_create($borrower_obj->pay_date) , "d M Y") .'</span></td>
        </tr>

        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td class="top-line">Last instalment due date:<br /><span class="echo">'. date_format(date_create($borrower_obj->pay_date. ' + '. ($loan_obj->inst - 1) . ' month') , "d M Y") .'</span></td>
        </tr>

        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td class="top-line">Number of instalments: ' . $loan_obj->inst .'</td>
        </tr>

        <tr>
          <td></td>
          <td></td>
          <td></td>
          <td class="top-line">Frequency (monthly): YES</td>
        </tr>

        <tr>
          <td class="caption" colspan="4">Default interest will be charged at 5% per month on the outstanding Amount.</td>
        </tr>
      </tbody>
    </table>
';

// $pdf->writeHTML($html, true, false, true, false, '');
//
// $pdf->lastPage();
//
//
// $pdf->AddPage();

$html .= "<style>

    * {
      font-family:'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }

    p, ul, ol, li, table, tr, td {
      font-size: 10px;
    }

    .echo {
      font-weight: bold;
    }

    table, td {
      padding: 5px;
    }

    table.sign td.align-right {
      text-align: right;
    }

    ul.terms {
      padding-left: 0;
      margin-left: 0;
      list-style: none;
    }

    ul.terms li {
      font-weight: bold;
    }

    ul.terms li ul li {
      font-weight: normal;
    }

    </style>";

$date = date_create();

$html .= '

    <h4>PERIOD OF LOAN </h4>
    <p>The Borrower shall repay the capital amount including interest (as stated above) on or before <span class="echo">'. date_format(date_create($borrower_obj->pay_date. ' + '. ($loan_obj->inst - 1) . ' month') , "d F Y") .'</span>.
    I acknowledge that this agreement has been completed in full prior to my signature.</p>

    <table class="sign">
      <tbody>
        <tr>
          <td colspan="3">Signed at <span class="echo">'. $partner_obj->town .'</span> on the <span class="echo">'. date_format($date, 'jS') . '</span> day of <span class="echo">'. date_format($date, 'F') .'</span> <span class="echo">'. date_format($date, 'Y') .'</span></td>
        </tr>
        <tr>
          <td>Witnesses: _____________________</td>
          <td class="align-right">__________________</td>
          <td>(Signature of Lender)</td>
        </tr>
      </tbody>
    </table>

    <table class="sign">
      <tbody>
        <tr>
          <td colspan="3">Signed at <span class="echo">'. $borrower_obj->city .'</span> on the <span class="echo">'. date_format($date, 'jS') . '</span> day of <span class="echo">'. date_format($date, 'F') .'</span> <span class="echo">'. date_format($date, 'Y') .'</span></td>
        </tr>
        <tr>
          <td>Witnesses: _____________________</td>
          <td class="align-right">__________________</td>
          <td>(Signature of Borrower)</td>
        </tr>
      </tbody>
    </table>


      <h5>'. ($index = 7) .'. LEGAL COSTS</h5>
        <p>Both parties expressly agree that the legal costs that may be recovered by either party in the event of breach of any provision of this agreement, shall be on a party-and-party basis.</p>

      <h5>'. ++$index .'. CONSENT TO JUDGMENT AND EMOLUMENT ATTACHMENT ORDERS</h5>
        <p>The Lender agrees that any consent to judgment forms or emolument attachment orders obtained prior to the Borrower defaulting, is considered void and not enforceable.</p>
        <p>Circular No. II/ML/8/2003 dated 8 August 2003 is considered part of this Loan Agreement.</p>

      <h5>'. ++$index .'. RULES FOR THE PURPOSES OF EXEMPTION UNDER SECTION 15A OF THE USURY ACT</h5>
        <p>The rules of confidentiality, disclosure, consideration, cooling off period, and collection methods contained in Exemption Notice No. 189 of the 25 August 2004 forms part of the agreement and is attached as Annexure “A”</p>
      <h5>'. ++$index .'. DISPUTE RESOLUTION</h5>
          <p>Complaints which cannot be resolved between the Lender and the Borrower should be referred to NAMFISA for mediation in accordance with the Complaints Procedures endorsed by the Micro Lending Industry.  Attached is the complaints procedure which forms part of the agreement indicated as Annexure “B”.</p>


      <h5>'. ++$index .'. COOLING OFF</h5>
        <p>The Borrower may cancel this agreement within 3 business days after signing, provided the money paid to such Borrower, has been repaid, together with only the interest owed for the time the Borrower had the money.</p>


      <h5>'. ++$index .'. PREPAYMENT OF INSTALMENTS AND PRINCIPAL DEBT</h5>
        <p>The Borrower shall be entitled to pay any portion of the principal debt before due date without derogating from his rights in terms of this agreement.</p>


      <h5>'. ++$index .'. THE WHOLE CONTRACT</h5>
        <p>The parties confirm that this contract and its annexures contains the full terms of their agreement and that no addition to or variation of the contract shall be of any force and effect unless done in writing and signed by both parties.</p>

      <h5>'. ++$index .'. JURISDICTION</h5>
        <p>The Borrower hereby consents to the jurisdiction of the Magistrate’s Court having jurisdiction over the person in respect of all legal proceedings connected with this agreement.</p>
      <h5>'. ++$index .'. GOVERNING LAW</h5>
        <p>This agreement shall be governed in all respects by the laws of the Republic of Namibia.</p>

    <p>I acknowledge that this agreement has been completed in full prior to my signature.</p>

    <table class="sign">
      <tbody>
        <tr>
          <td colspan="3">Signed at <span class="echo">'. $partner_obj->town .'</span> on the <span class="echo">'. date_format($date, 'jS') . '</span> day of <span class="echo">'. date_format($date, 'F') .'</span> <span class="echo">'. date_format($date, 'Y') .'</span></td>
        </tr>
        <tr>
          <td>Witnesses: 1. _____________________</td>
          <td class="align-right">__________________</td>
          <td>(Signature of Lenter)</td>
        </tr>
      </tbody>
    </table>

    <table class="sign">
      <tbody>
        <tr>
          <td colspan="3">Signed at <span class="echo">'. $borrower_obj->city .'</span> on the <span class="echo">'. date_format($date, 'jS') . '</span> day of <span class="echo">'. date_format($date, 'F') .'</span> <span class="echo">'. date_format($date, 'Y') .'</span></td>
        </tr>
        <tr>
          <td>Witnesses: 1. _____________________</td>
          <td class="align-right">__________________</td>
          <td>(Signature of Borrower)</td>
        </tr>
      </tbody>
    </table>
    <!-- end of second page -->

    <!-- page 3 begins -->
    <h4>RULES FOR THE PURPOSES OF EXEMPTION UNDER SECTION 15A OF THE ACT</h4>
    <h5>'. ($index = 1) .'. Confidentiality</h5>
    <p>'. $index . '.' . ($sub_index = 1) .'. The Lender may not, without the express consent of the Borrower, disclose any confidential information obtained in the course of a micro loan transaction.</p>
    <p>'. $index . '.' . ++$sub_index .'. If the Lender wishes to obtain from or to disclose to a third party the Borrower’s credit record and payment history, the Lender must obtain the Borrower’s consent through specific and prominent clauses contained in the application for the relevant micro loan transaction or other documentation signed by the Borrower.</p>


    <h5>'. ++$index .'. Disclosure</h5>
    <p>'. $index . '.' . ($sub_index = 1) .'. The Lender must, at every premise where the Lender conducts business in respect of micro loan transactions keep available a copy of the Rules set by the Minister in Annexure “A”, which must be made available to the Borrower for perusal prior to entering into a micro loan transaction; and display prominently a copy of the Lender’s registration certificate issued by the Registrar.</p>
    <p>'. $index . '.' . ++$sub_index .'. The Lender must use standard written agreements, as approved by the Registrar, containing all the terms and conditions of a micro loan transaction and clearly reflecting the rights and obligations of the Borrower and the Lender.</p>
    <p>'. $index . '.' . ++$sub_index .'. The Lender must, before the conclusion of a micro loan transaction and at the conclusion of the agreement, provide the Borrower with a schedule setting out-</p>

      <p class="indent-text">'. $index . '.' . $sub_index .'.'. ($sub_index2 = 1) .'. The loan amount in Namibia Dollars and cents;</p>
      <p class="indent-text">'. $index . '.' . $sub_index .'.'. ++$sub_index2 .'. The total amount repayable in Namibia Dollars and cents, at the then current interest rate, over the repayment period;</p>
      <p class="indent-text">'. $index . '.' . $sub_index .'.'. ++$sub_index2 .'. The amount of finance charges in Namibia Dollars and cents, at the then current interest rate, over the repayment period and the elements comprising the finance charges;</p>
      <p class="indent-text">'. $index . '.' . $sub_index .'.'. ++$sub_index2 .'. The annual finance charge rate, whether this is fixed or variable, and, if variable, how it may vary;</p>
      <p class="indent-text">'. $index . '.' . $sub_index .'.'. ++$sub_index2 .'. The nature and amount of any insurance, including the name of the insurer and the amount of the premiums payable;</p>
      <p class="indent-text">'. $index . '.' . $sub_index .'.'. ++$sub_index2 .'. The penalty interest and any additional costs that would become payable in the case of default by the Borrower or how that would be calculated;</p>
      <p class="indent-text">'. $index . '.' . $sub_index .'.'. ++$sub_index2 .'. The instalment amount in Namibia Dollars and cents, at the then current interest rate, and the number of instalments; and</p>
      <p class="indent-text">'. $index . '.' . $sub_index .'.'. ++$sub_index2 .'. The repayment period in respect of the micro loan transaction.</p>

    <p>'. $index . '.' . ++$sub_index .'. The Lender must before the conclusion of a micro loan agreement –</p>
    <p>'. $index . '.' . $sub_index .'.'. ($sub_index2 = 1) .'. explain to the borrower in a language which the borrower understands (if necessary with the assistance of an interpreter) the essential terms of the micro loan agreement so as to ensure that the meaning and consequences of the agreement are understood; and</p>
    <p>'. $index . '.' . $sub_index .'.'. ++$sub_index2 .'. allow the borrower an opportunity to read the agreement, or have it read to the borrower in the case where the borrower is illiterate; and</p>
    <p>'. $index . '.' . $sub_index .'.'. ++$sub_index2 .'. Provide the borrower with a copy of the signed micro loan agreement before or at the time of advancing the loan amount and, if applicable, a copy of the insurance contract pertaining to the micro loan transaction.</p>

    <p>'. $index . '.' . ++$sub_index .'. The Lender must, at the request of the Borrower, provide the Borrower with a statement setting out all the charges levied, all the payments made and the balance outstanding, and may levy a charge for the provision of a duplicate copy of the statement but in no case may the charge exceed N$2.00 per page of the statement.</p></li>
    <p>'. $index . '.' . ++$sub_index .'. The Lender must maintain a proper set of accounting records reflecting full details of all money advanced, interest and other charges raised, repayments received and the amounts outstanding.</p></li>
    <p>'. $index . '.' . ++$sub_index .'. If the Lender refuses to grant an application for a micro loan application, the Lender must, at the request of the borrower, provide the reasons for the refusal.  If the reasons include an adverse credit record recorded with a credit bureau, provide the name and details of that credit bureau to the Borrower so as to enable the Borrower to check the accuracy of the credit information held by the credit bureau, or to obtain advice from the credit bureau on how to improve the record.</p>
    <p>'. $index . '.' . ++$sub_index .'. The Lender must, at least 28 calendar days before the Lender forwards any adverse information on the Borrower to a credit bureau which will be capable of being accessed by subscribers to the credit bureau, inform the Borrower, by way of a notice addressed to the chosen domicile of the Borrower of the Lender’s intention to do so.  If any amount owing by the Borrower is disputed by the Borrower, that fact must be communicated by the Lender to the credit bureau when providing information to it.</p>

    <h5>'. ++$index .'. Consideration</h5>
    <p>'. $index . '.' . ($sub_index = 1) .'. Subject to sub clause (3.2), a Lender may not charge any fee to be paid by the Borrower in circumstances where a micro loan transaction is not granted or money is not paid out to the Borrower in respect of the micro loan transaction.</p>
    <p>'. $index . '.' . ++$sub_index .'. This provision does not apply to fees reasonably charged for evaluating or preparing business plans.</p>
    <p>'. $index . '.' . ++$sub_index .'. If the repayment period provided in a micro loan agreement does not exceed twelve months, the Borrower may make additional payments or settle the outstanding amount in one payment.   If the repayment period exceeds 12 months, and if the Borrower wishes to settle the outstanding amount in one payment, the Lender may, if written notice is required in terms of the agreement, require up to 60 days written notice of the Borrower’s intention to settle the outstanding amount in one payment.</p>
    <p>'. $index . '.' . ++$sub_index .'. The Lender may not stipulate, demand or receive finance charges which are in excess of the annual finance charge rate determined by the Registrar in terms of section 2 of the Act.</p>
    <h5>'. ++$index .'. Cooling-off period</h5>
    <p>'. $index . '.' . ($sub_index = 1) .'. The Lender must, in terms of the provisions of the agreement with the Borrower, allow the Borrower to terminate the micro loan agreement within a period of three business days after the date of signing the agreement, and, if the loan amount has been advanced, simultaneously to repay the loan amount advanced, to the Lender.</p>
    <p>'. $index . '.' . ++$sub_index .'. If the Borrower terminates the micro loan agreement within the period referred to in sub clause (1) after having received the money in respect of the loan amount, the Lender is entitled, upon the Borrower offering simultaneously to repay the total amount advanced to the borrower, only to stipulate for demand or receive from the Borrower, pro rata charges at the annual finance charge rate applicable to the agreement.</p>
    <h5>'. ++$index .'. Collection methods</h5>
    <p>'. $index . '.' . ($sub_index = 1) .'. The Lender may not, as security or for collection arrangement purposes, keep in possession, or make use of any bank cards or personal information such as pin codes of the Borrower.</p>
    <p>'. $index . '.' . ++$sub_index .'. The Lender may not use any process documents signed in blank by the Borrower.</p>
    <p>'. $index . '.' . ++$sub_index .'. The Lender may not collect or attempt to collect any amount in respect of costs exceeding costs allowed in terms of the Magistrate’s Court Act, 1944 (Act No. 32 of 1944) or make use of any collection methods not authorized by law.</p>
';

$pdf->writeHTML($html, true, false, true, false, '');

$html = <<<EOF

EOF;

$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

$pdf->Output('moneyflux_contract.pdf', 'I');

?>
