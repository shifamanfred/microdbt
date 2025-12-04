<?php

// retrieve borrower Details

if (isset($loan_condition)) {
  switch ($loan_condition) {
    case 'loans_not_approved':
      $result = LoanAccount::getUnapprovedLoanRecords($connect, $borrower_id, $part_id);
      break;
    case 'loans_approved_but_not_disbursed':
      $result = LoanAccount::getApprovedLoans($connect, $borrower_id);
      break;

    case 'loans_disbursed':
      $result = LoanAccount::getDisbursedLoans($connect, $borrower_id);
      break;

    default:
      $result = LoanAccount::getBorrowerLoanRecords($connect, $borrower_id, $part_id);
  }
} else {
  $result = LoanAccount::getCurrentPartnerBorrowerLoanRecords($connect, $borrower_id, $part_id);
}

if (isset($_GET['acc_id'])) {
  $acc_id = intval($_GET['acc_id']);
} else {
  $acc_id = 0;
}



if (!$result) {
  echo '<p class="text text-danger">Data Retrival Failed!! Please contact the webmaster</p>';
} else if ($result->num_rows > 0) {
  $zero_loans = false;
  ?>
  <div class="form-group row">
    <label class="col-sm-2 control-label">Select Loan</label>
    <div class="col-sm-10">
      <select class="form-control" name="<?php echo isset($loan_condition) && $loan_condition == 'loans_not_approved' ? 'acc_id' : 'account_id' ?>">
        <?php while($rec = $result->fetch_assoc()) { ?>
          <option value="<?php echo $rec['account_id']; ?>" <?php echo $acc_id == $rec['account_id'] ? 'selected' : ''; ?>><?php echo $rec['loan_alias'] . ' - ' . $rec['total_remain']; ?></option>
          <?php
        }
        ?>
      </select>
    </div>
  </div>
  <?php

  $result->free_result();
} else {

  $zero_loans = true;

  if (isset($loan_condition) && $loan_condition == 'loans_not_approved') { ?>

  <div class="alert alert-warning alert-dismissible mt" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    This client has no unapproved loans assigned to them
  </div>
  <?php } else {?>

  <div class="alert alert-warning alert-dismissible mt" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    This client has no approved loans assigned to them
  </div>

  <?php
  }

  $result->free_result();
}
?>
