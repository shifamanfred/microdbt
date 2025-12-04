<?php
// file for processing form information

include_once("./includes/security.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['ops']) && isset($_GET['part_id'])) {

  // get operation type that determines which operation to carry out
  $operation = strval($_GET['ops']);

	// get partner id of the loan business
	$part_id = intval($_GET['part_id']);

  // include custom functions
  include_once('./includes/functions.php');

  // connect to the Database
  require_once('../config/db_connect.php');

  // file upload folder name
  $upload_folder = 'uploaded_docs';


	// might need to declare classes for partners and partner_employees
  // include_once('./pages/classes.php');

  switch ($operation) {
		case 'add branch':
    case 'edit branch':
			$name = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['branch_name']));
			$loc = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['location']));
			$town = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['town']));

      if ($operation == 'edit branch') {
        $query = 'UPDATE branches ';
        $query .= "SET branch_name = $name, location = $loc, town = $town ";
        $query .= "WHERE id = $branch_id";
      } else {
			  $query = 'INSERT INTO branches (`branch_name`, `location`, `town`, `partner_id`) VALUES ';
			  $query .= "($name, $loc, $town, $part_id)";
      }

			$result = $connect->query($query);

			if (!$result) {
        // error handling here
				$msg = 'Database operation failed!! Please contact the webmaster!';
			} else {
        if ($operation == 'edit branch') {
          $msg = 'Branch edited Successfully!!';
        } else {
				  $msg = 'Branch added Successfully!!';
        }
			}

			header('Location: branches.php?&msg=' . $msg);

			break;

    case 'assign user':

      // get form values
      $branch_id = mysqli_real_escape_string($connect, $_POST['branch-btn']);
      $employee_id = $_GET['emp_id'];

      $query = 'UPDATE partner_employees ';
      $query .= 'SET branch_id = '. $branch_id .' ';
      $query .= 'WHERE id = ' . $employee_id;

      $result = $connect->query($query);

      if (!$result) {
        // error handling here
				$msg = 'Database operation failed!! Please contact the webmaster!';
			} else {
				$msg = 'User assigned to branch Successfully!!';
			}

			header('Location: branch_users.php?&msg=' . $msg);

      break;

    case 'record budget':
      $amount = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['budget_amount']));
      $desc = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['budget_desc']));
      $budget_type = mysqli_real_escape_string($connect, $_POST['budget_type']);
      $transfer_to = mysqli_real_escape_string($connect, $_POST['transfer_to']);

      if (strtolower($budget_type) != 'transfer') {
        $budget_type = emptyStringToNull($budget_type);

        $query = 'INSERT INTO partner_budget(amount, description, budget_type, transaction_date, partner_id) VALUES';
        $query .= "($amount, $desc, $budget_type, NOW(), $part_id); ";

        $result = $connect->query($query);

        if (!$result) {
          $msg = 'Failed to Record Budget Information!! Please contact the webmaster!';
          header('Location: budget.php?msg=' . $msg);
        } else {
          $msg = 'Budget Information Recorded Successfully!';
          header('Location: budget.php?msg=' . $msg);
        }
      } else {
        $budget_type = emptyStringToNull($budget_type);

        $query = 'INSERT INTO partner_budget(amount, description, budget_type, transaction_date, partner_id) VALUES';
        $query .= "($amount, $desc, $budget_type, NOW(), $part_id); ";

        $result = $connect->query($query);

        if (!$result) {
          $msg = 'Failed to Record Budget Information!! Please contact the webmaster!';
          header('Location: budget.php?msg=' . $msg);
        } else {
          $msg = 'Budget Information Recorded Successfully!';
          header('Location: budget.php?msg=' . $msg);
        }

        // TODO: Have to record payroll information if it is a case of transfering funds to the employee
      }


      break;

		case 'add client':
			// retrieve form details
			$id_num = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['customer_id']));
			$names = mysqli_real_escape_string($connect, $_POST['customer_name']);
      $gender = emptyStringToNull(strtoupper(mysqli_real_escape_string($connect, $_POST['borrower_gender'])));
      $marital = emptyStringToNull(strtoupper(mysqli_real_escape_string($connect, $_POST['marital'])));
      $dob = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['borrower_dob']));
			$phone = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['phone']));
			$addr1 = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['address_line1']));
			$addr2 = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['address_line2']));
      $email = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['customer_email']));
			$city = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['city']));
			$region = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['state']));
			$country = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['country']));
      $employment_status = emptyStringToNull(strtoupper(mysqli_real_escape_string($connect, $_POST['borrower_working_status'])));

      $first_name = getFirstName($names);
      $last_name = getSurname($names);

      if (isset($_GET['submit'])) {
        if ($_GET['submit'] == 'edit') {
          $borrower_id = emptyNumberToNull($_POST['id']);

          $query = 'UPDATE borrowers ';
          $query .= "SET id_number = $id_num, first_name = $first_name, last_name = $last_name, gender = $gender, marital_status = $marital, email = $email";
          $query .= ", dob = STR_TO_DATE($dob, '%Y-%m-%d'), phone = $phone, address = $addr1, address2 = $addr2, city = $city";
          $query .= ", region = $region, country = $country, working_status = $employment_status ";
          $query .= 'WHERE id = ' . $borrower_id;
        }
      } else {
        // $photo or avatar to be processed here as well

  			$query = 'INSERT INTO borrowers (`id_number`, `first_name`, `last_name`, `gender`, `marital_status`, `email`, `dob`, `phone`, `address`, `address2`, `city`, `region`, `country`, `working_status`, `partner_id`) '; /*`image string, `*/
        $query .= "VALUES($id_num, $first_name, $last_name, $gender, $marital, $email, STR_TO_DATE($dob, '%Y-%m-%d'), $phone, $addr1, $addr2, $city, $region, $country, $employment_status, $part_id); ";
      }

      $result = $connect->query($query);

      if (!$result) {

        // error handling here
				$msg = 'Database operation failed!! Please contact the webmaster!'. '<br>CODE: '. $connect->errno .' ERROR: '. $connect->error;
        $msg = 'Database operation failed!! Please contact the webmaster!';
        if (isset($_GET['submit'])) {
          if ($_GET['submit'] == 'edit') {
            header('Location: client_profile.php?id= '. $borrower_id . '&msg=' . $msg . '&mode=edit');
          }
        } else {
          header('Location: add_client.php?msg=' . $msg);
          exit;
        }
			} else {
        if (isset($_GET['submit'])) {
          if ($_GET['submit'] == 'edit') {
            $msg = 'Customer Records Modified Successfully!!';
            header('Location: client_profile.php?id=' . $borrower_id . '&msg=' . $msg);
          }
        } else {
          $msg = 'Customer added Successfully!!';
          $last_id = $connect->insert_id;
          header('Location: work_details.php?client_id=' . $last_id . '&msg=' . $msg);
        }
			}

			break;

    case 'work details':
      // initialize work form details
      $client_details = $_POST['client_details'];
      $borrower_id = mysqli_real_escape_string($connect, $_POST['borrower_id']);
      $work_pos = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['work_position']));
      $employer = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['employer_name']));
      $code = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['work_position_code']));
      $contract = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['contract']));
      $work_addr = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['work_address']));
      $contact = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['contact_number']));
      $work_loc = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['work_location']));

      // creation query

      switch ($client_details) {
        case 'UPDATE':
          // update query
          $query = 'UPDATE borrower_employment ';
          $query .= "SET employer = $employer, work_position = $work_pos, work_position_code = $code ";
          $query .= ", contract_type = $contract, work_address = $work_addr, contact_number = $contact ";
          $query .= ", work_location = $work_loc ";
          $query .= 'WHERE borrower_id = ' . $borrower_id;
          break;

        case 'CREATE':
          // create query
          $query = 'INSERT INTO borrower_employment (`borrower_id`, `employer`, `work_position`, `work_position_code`, `contract_type`, `work_address`, `contact_number`, `work_location`) ';
          $query .= "VALUES ($borrower_id, $employer, $work_pos, $code, $contract, $work_addr, $contact, $work_loc)";
          break;

        default:
          // code...
          $query = null;
          break;
      }

      $result = $connect->query($query);

      if (!$result) {
        // error handling here
				$msg = 'Failed to Update Borrower\'s Work Details !! Please contact the webmaster!';
        header('Location: work_details.php?client_id='. $borrower_id . '&msg=' . $msg);
        exit;
			} else {
				$msg = 'Customer Work Details Updated Successfully!!';
			}

      header('Location: financial_details.php?client_id='. $borrower_id . '&msg=' . $msg);

      break;

    case 'financial details':

      $client_details = $_POST['client_details'];
      $borrower_id = mysqli_real_escape_string($connect, $_POST['borrower_id']);
      $gross_salary = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['gross_salary']));
      $net_salary = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['net_salary']));
      $paydate = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['pay_date']));
      $bank = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['bank']));
      $branch = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['branch']));
      $branch_code = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['branch_code']));
      $acc_num = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['account_number']));
      $acc_type = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['account_type']));

      $expense_amounts = $_POST['expenses'];

      // will process this info as soon as I figure out this plugin to load images
      $pay_slip = uploadDocument('pay_slip', $upload_folder);
      // if (strpos(strtolower($pay_slip), 'error') !== false) {
      //   $pay_slip_error = $pay_slip;
      //   $pay_slip = 'NULL';
      // }
      //
      // $bank_statements = uploadDocument('bank_statements', $upload_folder);
      // if (strpos(strtolower($bank_statements), 'error') !== false) {
      //   $bank_statements_error = $bank_statements;
      //   $bank_statements = 'NULL';
      // }

      switch ($client_details) {
        case 'UPDATE':
          // update query: modify borrower's financial records
          $query = 'UPDATE borrower_finances ';
          $query .= "SET gross_salary = $gross_salary, net_salary = $net_salary ";
          $query .= ", pay_date = STR_TO_DATE($paydate, '%m-%d-%Y') ";
          $query .= ", bank = $bank, branch = $branch, branch_code = $branch_code ";
          $query .= ", account_number = $acc_num, account_type = $acc_type ";
          // if ($pay_slip !== 'NULL') {
          //   $query .= ", pay_slip = $pay_slip ";
          // }
          // if ($bank_statements !== 'NULL') {
          //   $query .= ", bank_statement = $bank_statements ";
          // }
          $query .= 'WHERE borrower_id = ' . $borrower_id;
          break;

        case 'CREATE':
          // create query: insert into borrower's financial records
          $query = 'INSERT INTO borrower_finances (`borrower_id`, `gross_salary`, `net_salary`, `pay_date`, `bank`, `branch`, `branch_code`, `account_type`, `account_number`) ';
          $query .= "VALUES ($borrower_id, $gross_salary, $net_salary, STR_TO_DATE($paydate, '%m-%d-%Y'), $bank, $branch, $branch_code, $acc_type, $acc_num)";
          break;

        default:
          // unexpected error occured
          $msg = 'Failed to Update Borrower\'s Financial Details!! Unexpected Error Occurred - Please contact the webmaster!';
          header('Location: financial_details.php?msg=' . $msg);
          exit;
      }

      // insert or update financial records
      $result = $connect->query($query);

      if (!$result) {

        $msg = 'Failed to Update Borrower\'s Financial Details!! Please contact the webmaster!';
        header('Location: financial_details.php?client_id='. $borrower_id . '&msg=' . $msg . '&error=' . $connect->errno);
        exit;

      } else {

        switch ($client_details) {
          case 'UPDATE':
            // update query: edit existings expenses

            // get expense records first
            $sql = 'SELECT * FROM borrower_expenses ';
            $sql .= 'WHERE borrower_id = ' . $borrower_id;

            $result = $connect->query($sql);

            if (!$result) {
              $msg = 'Failed to Update Borrower\'s Financial Details!! Please contact the webmaster!';
              header('Location: financial_details.php?client_id=' . $borrower_id . '&msg=' . $msg . '&error=' . $connect->errno);
              break;
            }

            // initialize the expense count of current expenses
            $curr_exp_count = $result->num_rows;
            $new_exp_count = count($expense_amounts);

            $exp_ids = array();

            while ($rec = $result->fetch_assoc()) {
              // loading the expense ids into the array
              array_push($exp_ids, $rec['id']);
            }

            $result->free_result();

            foreach ($exp_ids as $key => $exp_id) {

              // precaution: if the new expenses entries are smaller than the
              // current expense entries in the db delete the rest
              if ($key == $new_exp_count) {
                for (;$key < count($exp_ids); $key++) {
                  $del = 'DELETE FROM borrower_expenses ';
                  $del .= 'WHERE id = ' . $exp_ids[$key];

                  $result = $connect->query($del);
                }
                break;
              }

              $query = 'UPDATE borrower_expenses ';
              $query .= 'SET amount = ' . $expense_amounts[$key] . ' ';
              $query .= 'WHERE id = ' . $exp_id;

              $result = $connect->query($query);
            }

            // if the new expense entries are smaller than or equal to the
            // current expense entries break out of the switch
            // no new expense entries have to be created
            if ($new_exp_count <= $curr_exp_count) {
              break;
            }

            // otherwise create new expense entries in the next case statement

          case 'CREATE':


            // create query: create new borrower expenses records
            $query = 'INSERT INTO borrower_expenses (`borrower_id`, `amount`) VALUES';
            $query_2nd_line = ''; // second line of query for column names

            if (isset($key)) {
              $index = $key + 1;
            } else {
              $index = 0;
            }

            for (; $index < count($expense_amounts); $index++) {
              if ($expense_amounts[$index] == null || $expense_amounts[$index] == '') {
                continue;
              } else {
                if ($query_2nd_line != '') {
                  $query_2nd_line .= ',';
                }
                $query_2nd_line .= "($borrower_id, $expense_amounts[$index])";
              }
            }
            break;

          default:
            // code...
            break;
        }

        if ($query_2nd_line != '') {
          $query_2nd_line .= ';';

          $result = $connect->query($query . $query_2nd_line);

          if (!$result) {
            $msg = 'Failed to Update Borrower\'s Financial Details!! Please contact the webmaster!';
            header('Location: financial_details.php?client_id=' . $borrower_id . '&msg=' . $msg);
            exit;
          } else {
            $msg = 'Customer\'s Financial Details Updated Successfully!!';
          }
        } else {
          $msg = 'Customer\'s Financial Details Updated Successfully!!';
        }
      }

      if (isset($pay_slip_error)) {
        $msg = 'Customer\'s Financial Details Partially Updated Successfully!!';
        $msg .= '<br>' . $pay_slip_error;
        if (isset($bank_statements_error)) {
          $msg .= '<br>' . $bank_statements_error;
        }
      } else if (isset($bank_statements_error)) {
        $msg = 'Customer\'s Financial Details Partially Updated Successfully!!';
        $msg .= '<br>' . $bank_statements_error;
      }

      // from financial_details -> confirm_client_details
      header('Location: confirm_client_details.php?client_id='. $borrower_id . '&msg=' . $msg);
      break;


    case 'navigate':
      $borrower_id = $_GET['client_id'];
      $navigate_dest = strtolower(mysqli_real_escape_string($connect, $_POST['navigate']));

      switch ($navigate_dest) {
        case 'loan':
          header('Location: add_loan.php?client_id=' . $borrower_id);
          break;

        case 'customer':
          header('Location: add_client.php');
          break;

        case 'customer_management':
          header('Location: manage_clients.php?client_id=' . $borrower_id);
          break;

        default:
          header('Location: manage_clients.php?dest=null');
          break;
      }

      break;

    case 'add loan':

      // initialize add loan form data
      $borrower_id = mysqli_real_escape_string($connect, $_POST['borrower_id']);
      $loan_alias = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['loan_alias']));
      $base_amount = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['loan_amount']));
      $percent = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['loan_percent']));
      $inst = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['installments']));
      $debit_order = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['debit_order_fee']));
      $namfisa = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['namfisa_fee']));
      $total_amount = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['total_amount']));
      $emi = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['borrower_emi']));

      $ancient_loan = mysqli_real_escape_string($connect, $_POST['ancient']);

      if ($ancient_loan == 'TRUE') {
        // if this loan is ancient get the approval and disbursement dates
        $approved_date = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['approve_date']));

        $disbursed_date = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['disburse_date']));

        if ($approved_date == 'NULL' || $disbursed_date == 'NULL') {
          $msg = 'Error: Failed to Create Loan Account to Borrower!! <strong>Invalid</strong> or <strong>Missing Dates</strong>!!';
          header('Location: add_loan.php?client_id='. $borrower_id .'&msg=' . $msg);
          exit;
        }
      }

      // create record into loan_account
      $query = 'INSERT INTO loan_accounts (`loan_alias`, `base_amount`, `percentage`, `total_loan`, `total_remain`, `installments`, `emi`, `remain_inst`';
      if ($ancient_loan == 'TRUE') {
        $query .= ', approved_at, disbursed_at )';
      } else {
        $query .= ')';
      }
      $query .= "VALUES ($loan_alias, $base_amount, $percent, $total_amount, $total_amount, $inst, $emi, $inst";
      if ($ancient_loan == 'TRUE') {
        $query .= ", STR_TO_DATE($approved_date, '%Y-%m-%d'), STR_TO_DATE($disbursed_date, '%Y-%m-%d') );";
      } else {
        $query .= ');';
      }

      $result = $connect->query($query);

      if (!$result) {

        echo 'code = ' . $connect->errno . 'error = ' . $connect->error;
        die('<br>(((((((((((())))))))))))');

        $msg = 'Error 1: Failed to Create Loan Account to Borrower!! Please contact the webmaster!';
        header('Location: add_loan.php?client_id='. $borrower_id .'&msg=' . $msg);
      } else {
        $last_account_id = $connect->insert_id;

        // update the loan account lookup table
        $query = 'INSERT INTO loan_account_lookup (`account_id`, `partner_id`, `borrower_id`) VALUES';
        $query .= "($last_account_id, $part_id, $borrower_id)";

        $result = $connect->query($query);

        if (!$result) {
          $msg = 'Error 2: Failed to Create Loan Account to Borrower!! Please contact the webmaster!';
          header('Location: add_loan.php?client_id='. $borrower_id .'&msg=' . $msg);
        } else {

          if ($ancient_loan == 'TRUE') {
            $msg = 'Customer\'s Ancient Loan Record Created Successfully!! Please records <strong>payments</strong> if there are any ';
            header('Location: manage_loans.php?acc_id=' . $last_account_id . '&b_id=' . $borrower_id . '&msg=' . $msg);
          } else {
            $msg = 'Customer\'s Loan Record Created Successfully for Approval!! ';
            header('Location: approve_loan.php?acc_id=' . $last_account_id . '&b_id=' . $borrower_id . '&msg=' . $msg);
          }
        }
      }

      break;

    case 'loan approval':
      // handling loan approvals

      $account_id = $_GET['acc_id'];
      $borrower_id = $_GET['b_id'];

      if (isset($_POST['approve'])) {
        $query = 'UPDATE loan_accounts ';
        $query .= 'SET status = \'APPROVED\', approved_at = NOW(), loan_alias = \'MF'. sprintf("%08d", $account_id) .'\' ';
        $query .= 'WHERE id = ' . $account_id;

        $result = $connect->query($query);

        if (!$result) {
          $msg = 'Failed to Approve Borrower\'s Loan!! Please contact the webmaster!';
          header('Location: approve_loan.php?acc_id=' . $account_id . '&b_id=' . $borrower_id . '&msg=' . $msg);
          exit;
        } else {
          $msg = 'Loan Has Been Approved. Please select method of disbursement. ';
          header('Location: disburse_loan.php?acc_id=' . $account_id . '&b_id=' . $borrower_id . '&msg=' . $msg);
        }
      } else {
        $query = 'UPDATE loan_accounts ';
        $query .= 'SET status = \'DECLINED\' ';
        $query .= 'WHERE id = ' . $account_id;

        $result = $connect->query($query);

        if (!$result) {
          $msg = 'Failed to Approve Borrower\'s Loan!! Please contact the webmaster!';
          header('Location: approve_loan.php?acc_id=' . $account_id . '&b_id=' . $borrower_id . '&msg=' . $msg);
          exit;
        } else {
          $msg = 'Loan Has Been Declined.';
          header('Location: manage_loans.php?msg=' . $msg);
        }
      }

      break;

    case 'loan disbursement':
      $disbursement_method = emptyStringToNull($_POST['disburse_method']);

      $account_id = $_GET['acc_id'];
      $borrower_id = $_GET['b_id'];

      $query = 'UPDATE loan_accounts ';
      $query .= "SET status = 'DISBURSED', disbursed_at = NOW(), disburse_method = $disbursement_method ";
      $query .= 'WHERE id = ' . $account_id;

      $result = $connect->query($query);

      if (!$result) {
        $msg = 'Failed to Disburse Borrower\'s Loan!! Please contact the webmaster!';

        echo 'code: ' . $connect->errno . ' error: ' . $connect->error;
        die('<br>((((((((((((()))))))))))))');
        header('Location: disburse_loan.php?b_id=' . $borrower_id . '&acc_id=' . $account_id . '&msg=' . $msg);
        exit;
      } else {
        $msg = 'Loan Has Been Disbursed Successfully! Please make sure that the client has received the funds. ';
        header('Location: manage_loans.php?acc_id=' . $account_id . '&b_id=' . $borrower_id . '&msg=' . $msg);
        exit;
      }

      break;

    case 'record repay':
      // initialize repayment Details

      $query = 'SELECT auto_increment ';
      $query .= 'FROM information_schema.tables ';
      $query .= "WHERE table_schema = '$db_name' ";
      $query .= "AND table_name = 'repayments'";

      $result = $connect->query($query);

      if (!$result) {
        // error message
        $msg = 'Database Error! Failed to Record Borrower\'s Payment!! Please contact the webmaster!';
        header('Location: repayments.php?acc_id=' . $account_id . '&b_id=' . $borrower_id . '&msg=' . $msg);
        exit;
      } else {
        if ($rec = $result->fetch_assoc()) {
          $formatted_id = $rec['auto_increment'];
        }
        $result->free_result();
      }

      $borrower_id = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['borrower_id']));
      $account_id = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['account_id']));
      $repay_amount = emptyNumberToNull(mysqli_real_escape_string($connect, $_POST['repayment']));
      $repay_date = emptyStringToNull(mysqli_real_escape_string($connect, $_POST['repay_date']));


      // record payment
      $query = 'INSERT INTO repayments (repay_alias, amount, pay_date, loan_account_id) VALUES ';
      $formatted_id = sprintf('%010d', $formatted_id);
      $query .= "('RECEIPT-$formatted_id', $repay_amount, STR_TO_DATE($repay_date, '%Y-%m-%d'), $account_id);";

      $result = $connect->query($query);

      if (!$result) {
        // error message
        $msg = 'Database Error! Failed to Record Borrower\'s Payment!! Please contact the webmaster!';
        header('Location: repayments.php?acc_id=' . $account_id . '&b_id=' . $borrower_id . '&msg=' . $msg);
        exit;
      } else {
        // success message
        $msg = 'Borrower\'s Payment Recorded Successfully!!';
        header('Location: repayments.php?msg=' . $msg);
      }

      break;

    default:
      break;
  }
} else {
  header('Location: ../index.php');
  exit;
}

?>
