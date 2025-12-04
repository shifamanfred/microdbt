<?php

/**
 * Class for the loan system settings
 */

class CompanySettings {
  var $company_name = '';
  var $company_logo = '';
  var $company_address = '';
  var $phone = '';
  var $email = '';
  var $currency = '';
  var $debit;
  var $contract_fee;
  var $default_product;
  var $by_user = '';
  var $date_created = '';
  var $date_modified = '';

  function __construct($connect) {

    // retrieve company_settings data
    $query = 'SELECT name, logo, address, phone, c.email, currency, created_at, last_modified, last_name, default_pro, db_fee, contract_fee ';
    $query .= 'FROM company_settings c JOIN super_users s ON (su_id = s.`id`) ';
    $query .= 'ORDER BY c.`id` ';
    $query .= 'LIMIT 1';

    $result = $connect->query($query);

    if (!$result) {
      echo '<span class="text-danger">!! DATA QUERY FAILED!!</span>';
      echo '<span class="text-danger">CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect) . '</span>';
      die ('!! DATABASE QUERY FAILED !!');
    } else if (mysqli_num_rows($result) <= 0) {

    } else {

      $row = mysqli_fetch_assoc($result);

      $this->company_name = $row['name'];
      $this->company_logo = $row['logo'];
      $this->company_address = $row['address'];
      $this->phone = $row['phone'];
      $this->email = $row['email'];
      $this->currency = $row['currency'];
      $this->default_product = $row['default_pro'];
      $this->debit = $row['db_fee'];
      $this->contract_fee = $row['contract_fee'];
      $this->by_user = $row['last_name'];
      $this->date_created = $row['created_at'];
      $this->date_modified = $row['last_modified'];

      $result->free_result();
    }
  }

  public function getCurrency() {
    // return currency sign
    $currency_obj = new Currency();

    return $currency_obj->getCurrency($this->currency);
  }
}

class Currency {
  var $nad = 'N$'; // namibian
  var $zar = 'R'; // south african rand
  var $zmw = 'K'; // zambian kwacha
  var $bwp = 'P'; // botswana pula
  var $ang = 'Kz'; // angolan kwanza
  var $zwd = 'Z$'; // zim dollars

  public function getCurrency($currency) {

    switch ($currency) {
      case 'NAD':
      return $this->nad;
      break;

      case 'ZAR':
      return $this->zar;
      break;

      case 'ZMW':
      return $this->zmw;
      break;

      case 'BWP':
      return $this->bwp;
      break;

      case 'ANG':
      return $this->ang;
      break;

      default:
      return $this->nad;
    }
  }
}

/**
 * Class for business branch
 */
 class Branch {
   var $id;
   var $name;
   var $loc;
   var $town;

   function __construct($connect, $id) {
     $query = 'SELECT * FROM branches ';
     $query .= 'WHERE id = ' . $id;

     $result = $connect->query($query);

     if (!$result) {
       echo 'Error Occured. Please contact the webmaster. <a href="index.php">Home</a>';
       echo '<br>CODE: ' . $connect->errno . ' ERROR: ' . $connect->error . '<br>';
       die ('-------------------------------------------------------------------------');
     } else {
       if ($row = $result->fetch_assoc()) {
         $this->id = $id;
         $this->name = $row['branch_name'];
         $this->loc = $row['location'];
         $this->town = $row['town'];
       }

       $result->free_result();
     }
   }

   public static function getBranchRecords($connect, $part_id) {
     $query = 'SELECT * FROM branches ';
     $query .= 'WHERE partner_id = ' . $part_id . ' ';
     $query .= 'ORDER BY branch_name;';

     $result = $connect->query($query);

     return $result;
   }
 }

/**
 * Class for business partner Profile
 */
class Partner {
  var $id = 0;
  var $business_name = '';
  var $trade_name = '';
  var $owner_name = '';
  var $owner_surname = '';
  var $email = '';
  var $reg_num = '';
  var $income_tax = '';
  var $ss_num = '';
  var $namfisa_reg = '';
  var $debit_order_fee;
  var $phone = '';
  var $cell = '';
  var $postal = '';
  var $physical = '';
  var $street = '';
  var $town = '';
  var $country = '';
  var $zip_code;
  var $status = '';
  var $recorded_at = '';

  function __construct($connect, $id) {

    // execute query from here
    $query = 'SELECT * ';
    $query .= 'FROM partners ';
    $query .= 'WHERE id = ' . $id . ';';

    $result = mysqli_query($connect, $query);

    if (!$result) {
      echo 'Error Occured. Please contact the webmaster. <a href="index.php">Home</a>';
      echo '<br>CODE: ' . $connect->errno . ' ERROR: ' . $connect->error . '<br>';
      die ('-------------------------------------------------------------------------');
    } else {
      $row = $result->fetch_assoc();

      $this->id = $row['id'];
      $this->business_name = $row['business_name'];
      $this->trade_name = $row['trade_name'];
      $this->owner_name = $row['owner_name'];
      $this->owner_surname = $row['owner_last_name'];
      $this->email = $row['owner_email'];
      $this->reg_num = $row['reg_num'];
      $this->income_tax = $row['income_tax'];
      $this->ss_num = $row['ss_num'];
      $this->namfisa_reg = $row['namfisa_reg'];
      $this->phone = $row['phone'];
      $this->cell = $row['cell'];
      $this->postal = $row['postal'];
      $this->physical = $row['physical'];
      $this->street = $row['street'];
      $this->town = $row['town'];
      $this->country = $row['country'];
      $this->zip_code = $row['zip_code'];
      $this->debit_order_fee = $row['debit_order'];
      $this->status = $row['status'];
      $this->recorded_at = $row['recorded_at'];

      // Close connections
      $result->free_result();
    }
  }

  public static function getPartnerEmployeeResults($connect, $part_id) {
    // query for getting all employees belonging to this partner
    $query = 'SELECT * ';
    $query .= 'FROM partner_employees e ';
    $query .= 'JOIN credentials c ON (e.cred_id = c.id) ';
    $query .= 'WHERE bus_id = ' . $part_id . ' ';
    $query .= 'ORDER BY last_name, first_name';

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }
}

class PartnerEmployee {
  var $user;
  var $pass;
  var $email;
  var $roles; // array of roles

  function __construct($connect, $id) {
    // execute query from here
    $query = 'SELECT * ';
    $query .= 'FROM partner_employee ';
    $query .= 'WHERE id = ' . $id . ';';
  }
}

/**
 * Employee Role object
 */
class EmployeeRole {
  var $id = null;
  var $name = null;
  var $level = null;
  var $desc = null;

  function __construct($connect, $id) {
    $query = 'SELECT * FROM employee_roles ';
    $query .= 'WHERE id = '. $id;

    $result = $connect->query($query);

    if (!$result) {
      // log error message here
      die('<span class="text-danger">Database Error! Please contact the webmaster!</span>');
    } else {

      if ($result->num_rows == 1 && $rec = $result->fetch_assoc()) {
        $this->id = $rec['id'];
        $this->name = $rec['role_name'];
        $this->level = $rec['role_level'];
        $this->desc = $rec['role_desc'];
      }

      $result->free_result();
    }
  }

  public function roleLevels($connect) {
    if ($this->name == null) {

      return 0;
    } else {
      $query = 'SELECT IFNULL(MAX(role_level), 0) AS "levels" ';
      $query .= 'FROM employee_roles ';
      $query .= "WHERE role_name = '$this->name' ";

      $result = $connect->query($query);

      if (!$result) {
        // log error message here
        return 0;
      } else {
        if ($result->num_rows == 1 && $rec = $result->fetch_assoc()) {
          $levels = $rec['levels'];
        } else {
          $levels = 0;
        }

        $result->free_result();

        return $levels;
      }
    }
  }

  public static function getRoleByLevel($connect, $role_name, $level) {
    $query = 'SELECT * FROM employee_roles ';
    $query .= "WHERE role_name = '$role_name' ";
    $query .= "AND role_level = $level ";

    $result = $connect->query($query);

    if (!$result) {
      // log error message here
      return null;
    } else {
      if ($result->num_rows == 1 && $rec = $result->fetch_assoc()) {
        $obj = new EmployeeRole($connect, $rec['id']);
      } else {
        // multiple roles
        $obj = null;
      }

      $result->free_result();

      return $obj;
    }
  }
}


class PartnerBudget {
  var $id = 0;
  var $amount;
  var $desc;
  var $budget_type;
  var $trans_date;

  function __construct($connect, $id) {

    // execute query from here
    $query = 'SELECT * ';
    $query .= 'FROM partner_budget ';
    $query .= 'WHERE id = ' . $id . ';';

    if (!$result) {
      echo 'Error Occured. Please contact the webmaster. <a href="index.php">Home</a>';
      echo '<br>CODE: ' . $connect->errno . ' ERROR: ' . $connect->error . '<br>';
      die ('-------------------------------------------------------------------------');
    } else {
      $rec = $result->fetch_assoc();

      $this->id = $id;
      $this->amount = $rec['amount'];
      $this->desc = $rec['description'];
      $this->budget_type = $rec['budget_type'];
      $this->trans_date = $rec['transaction_date'];

      $result->free_result();
    }
  }

  public function getBudgetRecords($connect, $part_id) {
    // get all budget records belonging to this partner
    $query = 'SELECT * FROM partner_budget ';
    $query .= 'WHERE partner_id = ' . $part_id . ' ';
    $query .= 'ORDER BY transaction_date DESC;';

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  public function getBudgetDebited($connect, $part_id) {
    // retrieve total amount of all accounts debited
    $query = 'SELECT * FROM partner_budget ';
    $query .= 'WHERE budget_type = \'debit\' ';
    $query .= 'AND partner_id = ' . $part_id;

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      $total = 0;

      while ($rec = $result->fetch_assoc()) {
        $total += $rec['amount'];
      }

      $result->free_result();

      return $total;
    }
  }

  public function getBudgetCredited($connect, $part_id) {
    // retrieve total amount of all accounts credited
    $query = 'SELECT * FROM partner_budget ';
    $query .= 'WHERE budget_type = \'credit\' ';
    $query .= 'AND partner_id = ' . $part_id;

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      $total = 0;

      while ($rec = $result->fetch_assoc()) {
        $total += $rec['amount'];
      }

      $result->free_result();

      return $total;
    }
  }
}

class Borrower {

  var $id;
  var $id_num;
  var $name;
  var $last_name;
  var $gender;
  var $marital;
  var $email;
  var $dob;
  var $address;
  var $address2;
  var $phone;
  var $city;
  var $region;
  var $country;
  var $working_status;
  var $profile_pic;
  var $id_pic;
  var $partner_no;

  // employment Details
  var $emp_rec = false; // employent record flag

  var $employer = '';
  var $work_pos = '';
  var $work_pos_code = '';
  var $contract_type = '';
  var $work_addr = '';
  var $contact_num = '';
  var $work_loc = '';

  // financial details
  var $finance_rec = false; // finance record flag

  var $gross_salary = 0.00;
  var $net_salary = 0.00;
  var $pay_date;
  var $pay_slip_img;
  var $bank_statement_img;
  var $bank;
  var $branch;
  var $branch_code;
  var $acc_num;
  var $acc_type;

  var $expenses_arr = array();
  var $total_expenses = 0.00;

  var $total_loans = 0.00;

  function __construct($connect, $id) {
    $query  = 'SELECT `id`, id_number, first_name, last_name, gender, marital_status, email, dob, phone, address, address2, city, region, country, working_status, image, id_picture, partner_id ';
    $query .= 'FROM borrowers ';
    $query .= 'WHERE `id` = ' . $id . ' ';
    $query .= 'OR id_number = ' . $id;

    $result = $connect->query($query);

    if (!$result) {
      echo 'Error Occured. Please contact the webmaster. <a href="index.php">Home</a>';
      echo '<br>CODE: ' . $connect->errno . ' ERROR: ' . $connect->error . '<br>';
      die ('-------------------------------------------------------------------------');
    } else {

      if ($result->num_rows == 1 ) {
        $row = $result->fetch_assoc();

        // borrower details
        // more details will be added here
        $this->id = $row['id'];
        $this->id_num = $row['id_number'];
        $this->name = $row['first_name'];
        $this->last_name = $row['last_name'];
        $this->gender = $row['gender'];
        $this->marital = $row['marital_status'];
        $this->email = $row['email'];
        $this->dob = $row['dob'];
        $this->address = $row['address'];
        $this->address2 = $row['address2'];
        $this->phone = $row['phone'];
        $this->city = $row['city'];
        $this->region = $row['region'];
        $this->country = $row['country'];
        $this->working_status = $row['working_status'];
        $this->profile_pic = $row['image'];
        $this->id_pic = $row['id_picture'];
        $this->partner_no = $row['partner_id'];

        $result->free_result();

        // update work details
        $query = 'SELECT e.employer, e.work_position, e.work_position_code, e.contract_type, e.work_address, e.contact_number, e.work_location ';
        $query .= 'FROM borrower_employment e JOIN borrowers b ON (b.id = e.borrower_id) ';
        $query .= 'WHERE b.id = ' . $id;

        $result = $connect->query($query);

        if (!$result) {
          echo 'Error Occured. Please contact the webmaster. <a href="index.php">Home</a>';
          echo '<br>CODE: ' . $connect->errno . ' ERROR: ' . $connect->error . '<br>';
          die ('-------------------------------------------------------------------------');
        } else {
          if ($result->num_rows == 1 ) {

            $row = $result->fetch_assoc();

            // update flag
            $this->emp_rec = true;

            // initialize employment Details
            $this->employer = $row['employer'];
            $this->work_pos = $row['work_position'];
            $this->work_pos_code = $row['work_position_code'];
            $this->contract_type = $row['contract_type'];
            $this->work_addr = $row['work_address'];
            $this->contact_num = $row['contact_number'];
            $this->work_loc = $row['work_location'];
          } else {
            $this->emp_rec = false;
          }

          $result->free_result();
        }


        // getFinancialDetails

        // let start with the expenses first
        $query = 'SELECT expense, amount ';
        $query .= 'FROM borrower_expenses e JOIN borrowers b ON (b.id = e.borrower_id) ';
        $query .= 'WHERE b.id = ' . $id;

        $result = $connect->query($query);

        if (!$result) {
          echo 'Error Occured. Please contact the webmaster. <a href="index.php">Home</a>';
          echo '<br>CODE: ' . $connect->errno . ' ERROR: ' . $connect->error . '<br>';
          die ('-------------------------------------------------------------------------');
        } else {
          if ($result->num_rows >= 1) {
            $this->expenses_arr = array();

            while($row = $result->fetch_assoc()) {

              // initialize expenses
              array_push($this->expenses_arr, $row['amount']);
            }
          }

          $result->free_result();
        }

        // then the financial status details
        $query = 'SELECT f.gross_salary, f.net_salary, f.pay_date, f.pay_slip, f.bank_statement, f.bank, f.branch, f.branch_code, f.account_number, f.account_type ';
        $query .= ', (SELECT IFNULL(SUM(amount), 0.00) FROM borrower_expenses WHERE borrower_id = '. $id . ') AS "total_expenses" ';
        $query .= ', (SELECT SUM(total_loan) FROM loan_accounts JOIN loan_account_lookup ON (id = account_id) WHERE borrower_id = ' . $id . ' AND status = \'DISBURSED\') AS "total_loans" ';
        $query .= 'FROM borrower_finances f JOIN borrowers b ON(b.id = f.borrower_id) ';
        $query .= 'WHERE b.id = ' . $id;

        $result = $connect->query($query);

        if (!$result) {
          echo 'Error Occured. Please contact the webmaster. <a href="index.php">Home</a>';
          echo '<br>CODE: ' . $connect->errno . ' ERROR: ' . $connect->error . '<br>';
          die ('-------------------------------------------------------------------------');
        } else {

          if ($result->num_rows == 1 ) {

            $row = $result->fetch_assoc();

            $this->finance_rec = true;

            $this->gross_salary = $row['gross_salary'];
            $this->net_salary = $row['net_salary'];
            $this->pay_date = $row['pay_date'];
            $this->pay_slip_img = $row['pay_slip'];
            $this->bank_statement_img = $row['bank_statement'];
            $this->bank = $row['bank'];
            $this->branch = $row['branch'];
            $this->branch_code = $row['branch_code'];
            $this->acc_num = $row['account_number'];
            $this->acc_type = $row['account_type'];

            $this->total_expenses = $row['total_expenses'];

            if ($row['total_loans'] == '') {
              $this->total_loans = 0;
            } else {
              $this->total_loans = $row['total_loans'];
            }
          } else {
            $this->finance_rec = false;
          }
        }
      } else {
        // will think of something else
        $this->id = -1;
      }

      // housekeeping
      $result->free_result();
    }
  }



  public static function getBorrowerID($connect, $id) {
    // Borrowers identity number
    $query  = 'SELECT id_number ';
    $query .= 'FROM borrowers ';
    $query .= 'WHERE id = ' . $id;

    $result = $connect->query($query);

    if (!$result) {
      echo 'Error Occured. Please contact the webmaster. <a href="index.php">Home</a>';
      echo '<br>CODE: ' . $connect->errno . ' ERROR: ' . $connect->error . '<br>';
      die ('-------------------------------------------------------------------------');
    } else {
      if ($rec = $result->fetch_assoc()) {
        return $rec['id_number'];
      } else {
        return -1;
      }
    }
  }

  // all borrower records
  public static function getBorrowerRecords($connect) {

    // retrieve all borrower data and/or the loan accounts they have etc.
    $query = 'SELECT * FROM borrowers b ';
    $query .= 'ORDER BY last_name;';

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  // all borrower records that match specified search parameter
  public static function getBorrowerRecordsWithSearch($connect, $search_text) {

    // retrieve all borrower data and/or the loan accounts they have etc.
    // TODO: search according to {id_number, first_name, last_name, gender, marital_status, email, dob, phone, address, address2, city, region, country, working_status}
    $query = 'SELECT * FROM borrowers b ';
    $query .= "WHERE id_number LIKE '%$search_text%' ";
    $query .= "OR first_name LIKE '%$search_text%' ";
    $query .= "OR last_name LIKE '%$search_text%' ";
    $query .= "OR gender LIKE '%$search_text%' ";
    $query .= "OR marital_status LIKE '%$search_text%' ";
    $query .= "OR email LIKE '%$search_text%' ";
    $query .= "OR dob LIKE '%$search_text%' ";
    $query .= "OR phone LIKE '%$search_text%' ";
    $query .= "OR address LIKE '%$search_text%' ";
    $query .= "OR address2 LIKE '%$search_text%' ";
    $query .= "OR city LIKE '%$search_text%' ";
    $query .= "OR country LIKE '%$search_text%' ";
    $query .= "OR working_status LIKE '%$search_text%' ";
    $query .= 'ORDER BY last_name;';

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  // all active borrower records that belong to the given partner
  public static function getActiveBorrowerRecords($connect, $part_id) {

    // retrieve all borrower data and/or the loan accounts they have etc.
    $query = 'SELECT DISTINCT(id_number) FROM loan_record_view ';
    $query .= "WHERE lookup_partner_id = $part_id ";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }


  // borrowers regardless of loan accounts or not
  public static function getBorrowerRecordsForPartnerRaw($connect, $part_id) {

    // retrieve all borrower data and/or the loan accounts they have etc.
    $query = 'SELECT * FROM borrowers b ';
    $query .= 'WHERE partner_id = ' . $part_id . ' ';
    $query .= 'ORDER BY last_name;';

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  // loan borrowers with loan accounnts which belong to partner
  // or
  // borrowers added by current partner
  public static function getBorrowersForPartner($connect, $part_id) {

    // retrieve all borrower data and/or the loan accounts they have etc.
    $query = 'SELECT * FROM borrowers b ';
    $query .= 'WHERE b.partner_id = ' . $part_id . ' ';
    $query .= 'OR id IN (SELECT borrower_id FROM loan_record_view WHERE lookup_partner_id = '. $part_id . ') ';
    $query .= 'ORDER BY last_name;';

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }
}

class LoanAccount {
  var $acc_id;
  var $loan_alias;
  var $base_amount;
  var $percent;
  var $inst;
  var $total_loan;
  var $total_remain;
  var $total_repay;
  var $emi;
  var $next_payment_date;
  var $remain_inst;
  var $current_inst;
  var $issue_date;
  var $approved_date;
  var $disbured_date;


  function __construct($connect, $acc_id) {
    $query = 'SELECT * FROM loan_record_view ';
    $query .= 'WHERE account_id = ' . $acc_id;

    $result = $connect->query($query);

    if (!$result) {
      echo 'Error Occured. Please contact the webmaster. <a href="index.php">Home</a>';
      echo '<br>CODE: ' . $connect->errno . ' ERROR: ' . $connect->error . '<br>';
      die ('-------------------------------------------------------------------------');
    } else {
      if ($rec = $result->fetch_assoc()) {

        $this->acc_id = $acc_id;
        $this->loan_alias = $rec['loan_alias'];
        $this->base_amount = $rec['base_amount'];
        $this->percent = $rec['percentage'];
        $this->inst = $rec['installments'];
        $this->total_loan = $rec['total_loan'];
        $this->total_remain = $rec['total_remain'];
        $this->total_repay = $rec['total_paid'];
        $this->emi = $rec['emi'];
        $this->current_inst = $rec['current_inst'];
        $this->remain_inst = $rec['remain_inst'];
        $this->status = $rec['status'];
        $this->disburse_method = $rec['disburse_method'];
        $this->next_payment_date = $rec['next_date'];
        $this->issue_date = $rec['created_at'];
        $this->approved_date = $rec['approved_at'];
        $this->disbursed_date = $rec['disbursed_at'];

      // TODO: adding more if necessary

      }

      $result->free_result();
    }
  }

  public function getBorrowerObject($connect) {
    $query = 'SELECT borrower_id ';
    $query .= 'FROM loan_account_lookup ';
    $query .= 'WHERE account_id = ' . $this->acc_id;

    $result = $connect->query($query);

    if (!$result) {
      echo 'Error Occured. Please contact the webmaster. <a href="index.php">Home</a>';
      echo '<br>CODE: ' . $connect->errno . ' ERROR: ' . $connect->error . '<br>';
      die ('-------------------------------------------------------------------------');
    } else {
      $rec = $result->fetch_assoc();

      $borrower_id = $rec['borrower_id'];

      $result->free_result();

      $borrower_obj = new Borrower($connect, $borrower_id);

      return $borrower_obj;
    }
  }

  public function getPartnerObject($connect) {
    $query = 'SELECT partner_id ';
    $query .= 'FROM loan_account_lookup ';
    $query .= 'WHERE account_id = ' . $this->acc_id;

    $result = $connect->query($query);

    if (!$result) {
      echo 'Error Occured. Please contact the webmaster. <a href="index.php">Home</a>';
      echo '<br>CODE: ' . $connect->errno . ' ERROR: ' . $connect->error . '<br>';
      die ('-------------------------------------------------------------------------');
    } else {
      $rec = $result->fetch_assoc();

      $partner_id = $rec['partner_id'];

      $result->free_result();

      $partner_obj = new Partner($connect, $partner_id);

      return $partner_obj;
    }
  }

  // according to borrower
  public static function getBorrowerLoanRecords($connect, $borrower_id) {
    $query = 'SELECT * FROM loan_record_view ';
    $query .= 'WHERE bid = ' . $borrower_id .' ';
    $query .= 'ORDER BY disbursed_at DESC';

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  // according to borrower and partner
  public static function getUnapprovedLoanRecords($connect, $borrower_id, $part_id) {
    $query = 'SELECT * FROM loan_record_view ';
    $query .= 'WHERE bid = ' . $borrower_id . ' ';
    $query .= "AND status <> 'APPROVED' AND status <> 'SETTLED' AND status <> 'DISBURSED';";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  // according to borrower
  public static function getApprovedLoans($connect, $borrower_id) {
    $query = 'SELECT * FROM loan_record_view ';
    $query .= 'WHERE bid = ' . $borrower_id . ' ';
    $query .= "AND (status = 'APPROVED' AND status <> 'SETTLED' AND status <> 'DISBURSED')";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  // according to borrower
  public static function getDisbursedLoans($connect, $borrower_id) {
    $query = 'SELECT * FROM loan_record_view ';
    $query .= 'WHERE bid = ' . $borrower_id . ' ';
    $query .= "AND (status = 'DISBURSED')";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  public static function getAllLoans($connect, $part_id) {
    $query = 'SELECT * FROM loan_record_view ';
    $query .= "WHERE lookup_partner_id = $part_id ";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  public static function getAllDisbursedLoans($connect, $part_id) {
    $query = 'SELECT * FROM loan_record_view ';
    $query .= "WHERE lookup_partner_id = $part_id ";
    $query .= "AND (status = 'DISBURSED')";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  public static function getAllApprovedLoans($connect, $part_id) {
    $query = 'SELECT * FROM loan_record_view ';
    $query .= "WHERE lookup_partner_id = $part_id ";
    $query .= "AND (status = 'APPROVED' ";
    $query .= "OR status = 'DISBURSED')";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  public static function getAllPendingLoans($connect, $part_id) {
    $query = 'SELECT * FROM loan_record_view ';
    $query .= "WHERE lookup_partner_id = $part_id ";
    $query .= "AND (status = 'PENDING')";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }

  public static function getTotalDisbursedLoanAmount($connect, $part_id) {
    $query = 'SELECT IFNULL(SUM(base_amount), 0.00) AS "total" FROM loan_record_view ';
    $query .= "WHERE lookup_partner_id = $part_id ";
    $query .= "AND (status = 'DISBURSED')";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
        if ($result->num_rows >= 0) {
        $val = $result->fetch_assoc()['total'];

        $result->free_result();
        return $val;
      } else {
        return 0.00;
      }
    }
  }

  public static function getTotalApprovedLoanAmount($connect, $part_id) {
    $query = 'SELECT IFNULL(SUM(base_amount), 0.00) AS "total" FROM loan_record_view ';
    $query .= "WHERE lookup_partner_id = $part_id ";
    $query .= "AND (status = 'APPROVED' ";
    $query .= "OR status = 'DISBURSED')";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
        if ($result->num_rows >= 0) {
        $val = $result->fetch_assoc()['total'];

        $result->free_result();
        return $val;
      } else {
        return 0.00;
      }
    }
  }

  public static function getTotalPendingLoanAmount($connect, $part_id) {
    $query = 'SELECT IFNULL(SUM(base_amount), 0.00) AS "total" FROM loan_record_view ';
    $query .= "WHERE lookup_partner_id = $part_id ";
    $query .= "AND (status = 'PENDING')";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
        if ($result->num_rows >= 0) {
        $val = $result->fetch_assoc()['total'];

        $result->free_result();
        return $val;
      } else {
        return 0.00;
      }
    }
  }

  public static function getTotalRepayableLoanAmount($connect, $part_id) {
    $query = 'SELECT IFNULL(SUM(total_loan), 0.00) AS "total" FROM loan_record_view ';
    $query .= "WHERE lookup_partner_id = $part_id ";
    $query .= "AND (status = 'DISBURSED')";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
        if ($result->num_rows >= 0) {
        $val = $result->fetch_assoc()['total'];

        $result->free_result();
        return $val;
      } else {
        $result->free_result();
        return 0.00;
      }
    }
  }

  public static function getCurrentPartnerBorrowerLoanRecords($connect, $borrower_id, $part_id) {
    $query = 'SELECT * FROM loan_record_view ';
    $query .= 'WHERE bid = ' . $borrower_id . ' ';
    $query .= 'AND partner_id = ' . $part_id . ' ';
    $query .= "AND status = 'APPROVED'";

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }
}

class Repayment {
  var $id;
  var $repay_alias;
  var $amount;
  var $pay_date;

  function __construct($connect, $id) {
    $query = 'SELECT * ';
    $query .= 'FROM repayments ';
    $query .= 'WHERE id = ' . $id;

    $result = $connect->query($query);

    if (!$result) {
      echo 'Error Occured. Please contact the webmaster. <a href="index.php">Home</a>';
      echo '<br>CODE: ' . $connect->errno . ' ERROR: ' . $connect->error . '<br>';
      die ('-------------------------------------------------------------------------');
    } else {
      if ($rec = $result->fetch_assoc()) {
        $this->id = $id;
        $this->repay_alias = $rec['repay_alias'];
        $this->amount = $rec['amount'];
        $this->pay_date = $rec['pay_date'];
        $this->account_id = $rec['loan_account_id'];
      }

      $result->free_result();
    }
  }

  public static function getRepaymentRecords($connect, $acc_id) {
    // get all repayment records that is assigned to a loan account
    $query = 'SELECT * FROM repayments ';
    $query .= 'WHERE loan_account_id = ' . $acc_id;

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }
}
