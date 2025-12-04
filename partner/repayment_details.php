<?php

$title = "Welcome Home | Partner | Your loan gateway system";
$page = "repayments";
$sub_page = "repayment_details";
include 'includes/header.php';
include 'includes/classes.php';

$set = new CompanySettings($connect);

if (isset($_GET['id'])) {
  $repay_id = intval($_GET['id']);
} else {
  $repay_id = 0;
}

$repayment_obj = new Repayment($connect, $repay_id);

$loan_account = new LoanAccount($connect, $repayment_obj->account_id);

$borrower_obj = $loan_account->getBorrowerObject($connect);

$partner_obj = $loan_account->getPartnerObject($connect);

?>

<?php require "includes/sidebar.php"; ?>

<section id="main-content">
	<section class="wrapper">
		<div class="invoice-body">
			<div class="row">
        <div class="pull-left col-xs-9">
        <small><strong>From:</strong></small>
				<h3><?php echo $borrower_obj->name .' '. $borrower_obj->last_name; ?></h3>
				<address>
					<?php echo $borrower_obj->address == '' ? $borrower_obj->address2 : $borrower_obj->address; ?><br>
					<?php echo $borrower_obj->country; ?><br>
					<abbr title="Phone">P:</abbr> <?php echo $borrower_obj->phone ?>
				</address>
			</div>
			<!-- /pull-left -->
			<div class="pull-right col-xs-3">
        <small><strong>To:</strong></small>
        <h4><?php echo $partner_obj->business_name; ?></h4>
        <address>
          <?php echo $partner_obj->physical . ' ' . $partner_obj->street; ?><br>
          <?php echo $partner_obj->town; ?>, <?php echo $partner_obj->country; ?><br>
          <?php echo $partner_obj->postal; ?><br>
          <abbr title="Phone">P:</abbr> <?php echo $partner_obj->phone; ?>
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
						<div class="pull-left"> <?php echo sprintf('%010d', $repay_id) ?> </div>
						<div class="clearfix"></div>
					</div>
					<div>
						<!-- /col-md-3 -->
						<div class="pull-left"> RECEIPT DATE : </div>
						<div class="pull-left"> <?php echo date_format(date_create($repayment_obj->pay_date), 'd/m/Y'); ?></div>
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
						<div class="pull-right"> <?php echo $loan_account->base_amount; ?> </div>
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
						<td><?php echo 'LOAN ACC: ' . $loan_account->loan_alias; ?></td>
						<td class="text-right"><?php echo date_format(date_create($loan_account->approved_date), 'd/m/Y'); ?></td>
						<td class="text-right"><?php echo $loan_account->total_loan; ?></td>
					</tr>

          <?php
          // display all repayment records assigned to this loan account
          $result = Repayment::getRepaymentRecords($connect, $loan_account->acc_id);

          if ($result != null) {
            $count = 1;
            $total_payment = 0;
            while($rec = $result->fetch_assoc()) {
          ?>
					<tr>
						<td class="text-center"><?php echo ++$count; ?></td>
						<td><?php echo $rec['repay_alias']; ?></td>
						<td class="text-right"><?php echo date_format(date_create($rec['pay_date']), 'd/m/Y'); ?></td>
						<td class="text-right"><?php echo $rec['amount']; ?></td>
					</tr>
          <?php
            $total_payment += $rec['amount'];
            }
          } ?>

					<tr>
						<td colspan="2" rowspan="4">
							<h4>Terms and Conditions</h4>
							<p>Thank you for your business. We do expect payment within 21 days, so please process this invoice within that time. There will be a 1.5% interest charge per month on late invoices.</p>
						<td class="text-right"><strong>Total Payments</strong></td>
						<td class="text-right"><?php echo sprintf("%.2f", $total_payment) ?></td>
					</tr>
					<tr>
						<td class="text-right no-border"><strong>Total Loan</strong></td>
						<td class="text-right"><?php echo $loan_account->total_loan; ?></td>
					</tr>
          <tr>
            <td class="text-right no-border" colspan="2">
              <div class="well well-small green row"><div class="col-sm-6 text-left"><strong>Total Due </strong></div> <div class=" col-sm-6 text-right"><strong><?php echo $loan_account->total_loan - $total_payment ?></strong></div></div>
            </td>
          </tr>
				</tbody>
			</table>
		</div>

    <div class="row text-center">
      <a class="btn btn-theme" href="receipt.php?id=<?php echo $rec['id']; ?>&loan_alias=<?php echo $rec['loan_alias']; ?>"><i class="fa fa-print"> Print</i> </a>
    </div>
		<!--/col-lg-12 mt -->
	</section>
	<!-- /wrapper -->
</section>
<!-- /MAIN CONTENT -->
<!--main content end-->

<?php $page = $sub_page; ?>

<?php require "includes/footer.php"; ?>
