<?php if (isset($page) && $page == 'branches') { ?>
<div class="pull-right">
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'view_branches' ? 'btn-theme' : '' ; ?>" href="branches.php">View Branches</a>
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'add_branch' ? 'btn-theme' : '' ; ?>" href="add_branch.php">Add Branch</a>
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'branch_users' ? 'btn-theme' : '' ; ?>" href="branch_users.php">Assign User to Branch</a>
</div>
<?php } ?>

<?php if (isset($page) && $page == 'customer_management') { ?>
  <div class="pull-right">
    <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'manage_clients' ? 'btn-theme' : '' ; ?>" href="manage_clients.php">View Customers</a>
    <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'add_client' ? 'btn-theme' : '' ; ?>" href="add_client.php">Add Customer</a>
    <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'work_details' ? 'btn-theme' : '' ; ?>" href="work_details.php">Work Details</a>
    <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'financial_details' ? 'btn-theme' : '' ; ?>" href="financial_details.php">Financial Details</a>
  </div>
<?php } ?>

<?php if (isset($page) && $page == 'loans') { ?>
<div class="pull-right">
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'view_loans' ? 'btn-theme' : '' ; ?>" href="manage_loans.php">View Loans</a>
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'add_loan' ? 'btn-theme' : '' ; ?>" href="add_loan.php">Add a Loan</a>
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'approve_loan' ? 'btn-theme' : '' ; ?>" href="approve_loan.php">Approve Loan</a>
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'disburse_loan' ? 'btn-theme' : '' ; ?>" href="disburse_loan.php">Disburse Loan</a>
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'add_loan_product' ? 'btn-theme' : '' ; ?>" href="#">Add Loan Products</a>
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'transfer_loan' ? 'btn-theme' : '' ; ?>" href="#">Tranfer Loan</a>
  <!-- <a class="btn btn-default" href="#">Accept a Transfer</a> -->
</div>
<?php } ?>

<?php if (isset($page) && $page == 'repayments') { ?>
<div class="pull-right">
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'view_repayments' ? 'btn-theme' : '' ; ?>" href="repayments.php">Repayments</a>
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'record_repayment' ? 'btn-theme' : '' ; ?>" href="record_repayment.php">Record Payment</a>
</div>
<?php } ?>

<?php if (isset($page) && $page == 'employees') { ?>
<div class="pull-right">
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'employee_users' ? 'btn-theme' : '' ; ?>" href="employee_users.php">Employees</a>
  <a class="btn btn-default <?php echo isset($sub_page) && $sub_page == 'employee_roles' ? 'btn-theme' : '' ; ?>" href="employee_roles.php">Roles</a>
</div>
<?php } ?>
