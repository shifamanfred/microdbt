<?php

include_once("./pages/security.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['ops'])) {

  // get operation type that determines which operation to carry out
  $operation = strval($_GET['ops']);

  // connect to the Database
  require_once('../config/db_connect.php');

  include_once('./pages/classes.php');

  switch ($operation) {
    case 'add partner':
      // adding a partner comes here

      // initializing business details data
      $business_name = mysqli_real_escape_string($connect, $_POST['business']);
      $trade_name = mysqli_real_escape_string($connect, $_POST['trade_name']);
      $reg_num = mysqli_real_escape_string($connect, $_POST['registration_number']);
      $income_tax = mysqli_real_escape_string($connect, $_POST['income_tax_number']);
      $ss_num = mysqli_real_escape_string($connect, $_POST['social_security_number']);
      $namfisa_reg = mysqli_real_escape_string($connect, $_POST['namfisa_registration']);
      $postal = mysqli_real_escape_string($connect, $_POST['postal_address']);
      $physical = mysqli_real_escape_string($connect, $_POST['physical_address']);
      $street = mysqli_real_escape_string($connect, $_POST['street_name']);
      $town = mysqli_real_escape_string($connect, $_POST['town']);
      $country = mysqli_real_escape_string($connect, $_POST['country']);
      $zip_code = mysqli_real_escape_string($connect, $_POST['zip_code']);
      $owner_names = mysqli_real_escape_string($connect, $_POST['owners_name']);
      $debit_order = mysqli_real_escape_string($connect, $_POST['debit_order']);
      $phone = mysqli_real_escape_string($connect, $_POST['telephone']);
      $cell = mysqli_real_escape_string($connect, $_POST['cellphone']);
      $email = mysqli_real_escape_string($connect, $_POST['email']);

      // credentials
      $username = mysqli_real_escape_string($connect, $_POST['username']);
      $password = mysqli_real_escape_string($connect, $_POST['password']);
      $confirm = mysqli_real_escape_string($connect, $_POST['confirm']);

      // get owner's name and surname if provided
      $owner_names = trim($owner_names);
      $owner_names = explode(' ', $owner_names);

      // confirm passwords to avoid mistakes
      if ($password === $confirm) {

        // if passwords are the same create partner credentials record
        $query = 'INSERT INTO credentials (username, password) VALUES ';

        $query .= "('$username', '$password');";

        $result = mysqli_query($connect, $query);

        if(!$result) {
          echo '<br>$query = ' . $query . '<br>';
          die('-- DATABASE QUERY FAILED! -- <br>CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect));
        } else {

          $owners_name = $owner_names[0];
          $owners_surname = end($owner_names);
          if ($owners_name === $owners_surname) {
            $owners_name = 'NULL';
          }

          $query = "INSERT INTO partners (business_name, owner_name, owner_last_name, owner_email, trade_name, reg_num, income_tax,";
          $query .= "ss_num, namfisa_reg, phone, cell, postal, physical, street, town, country, zip_code, debit_order, cred_id) VALUES ";
          $query .= "('$business_name', '$owners_name', '$owners_surname', '$email', '$trade_name', '$reg_num', '$income_tax', '$ss_num', '$namfisa_reg', '$phone', ";
          $query .= "'$cell', '$postal', '$physical', '$street', '$town', '$country', $zip_code, '$debit_order', (SELECT id FROM credentials WHERE username = '$username'));";

          $result = mysqli_query($connect, $query);

          if (!$result) {
            // creation of business record fails
            echo '<br>$query = ' . $query . '<br>';
            die('-- DATABASE QUERY II FAILED! -- <br>CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect));
          } else {
            // redirect to add_partner page with success message
            header('Location: add_partner.php?partner_add=success');
            exit;
          }
        }
      }

      // -- send email with credentials right here --
      break;

      case 'add user':
        // TODO: have to get partner id from somewhere
        if (isset($_GET['partner_no'])) {
          $part_id = intval($_GET['partner_no']);
        } else {
          $part_id = $connect->insert_id;
        }

        // initialize employee details and other user credentials if provided
        $emp_emails = $_POST['emp_email'];
        $emp_users = $_POST['emp_username'];
        $emp_passes = $_POST['emp_password'];
        $emp_confirms = $_POST['emp_confirm'];

        // if passwords are the same create partner credentials record
        $query = 'INSERT INTO credentials (username, password) VALUES ';

        // add employee credentials if provided
        for ($index = 0; $index < count($emp_passes);) {
          // get individual employee details first
          $emp_user = mysqli_real_escape_string($connect, $emp_users[$index]);
          $emp_pass = mysqli_real_escape_string($connect, $emp_passes[$index]);
          $emp_confirm = mysqli_real_escape_string($connect, $emp_confirms[$index]);

          // then verify whether passwords match
          if ($emp_pass === $emp_confirm) {
            $query .= "('$emp_user', '$emp_pass'),";
          } else {
            // if not skip to the next employee
            // log the failed employee
            $index++;
            continue;
          }

          // loop has come to an end append ";" else append ","
          if (++$index < count($emp_emails)) {
            $query .= ',';
          } else {
            $query .= ';';
          }
        }

        $query = 'INSERT INTO partner_employees (email, bus_id, cred_id) VALUES';

        // append employee data; might be one two three or more
        for ($index = 0; $index < count($emp_emails);) {
          // get individual employee details first
          $emp_email = mysqli_real_escape_string($connect, $emp_emails[$index]);
          $emp_user = mysqli_real_escape_string($connect, $emp_users[$index]);

          $query .= "('$emp_email', $part_id, (SELECT id FROM credentials WHERE username = '$emp_user'))";

          // loop has come to an end append ";" else append ","
          if (++$index < count($emp_emails)) {
            $query .= ',';
          } else {
            $query .= ';';
          }
        }

        $result = $connect->query($query);

        if (!$result) {
          // creation of employee record failed
          echo '<br>$query = '. $query .'<br>';
          die('-- DATABASE QUERY II FAILED! -- <br>CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect));
        } else {
          // redirect to add_user page with success message
          header('Location: add_user.php?user_add=success');
          exit;
        }

        break;

      case 'partner activate':
        if (isset($_POST['partner_state'])) {

          if (!isset($_GET['part_id'])) {
            header('Location: view_partners.php?part_id=null');
            break;
          } else {
            $part_id = $_GET['part_id'];
          }

          $part_obj = new Partner($connect, $part_id);

          // run activation process according to current partner status
          switch (strtolower($part_obj->status)) {
            case 'active':
              // code...
              break;

            case 'contract':
              $msg = '<!-- // WARNING: -->Partner\'s Subscription already billed! Payment of current invoice must be indicated for another billing.';
              header('Location: invoice.php?save_invoice=error&msg='. $msg);

              break;

            case 'inactive':
              // when partner status is inactive generate an invoice and a contract for this partner

              header('Location: create_invoice.php?partner_no='. $part_obj->id);

              // $set = new CompanySettings($connect);
              //
              // // get default product
              // $pro_obj = new Product($connect, $set->default_product);
              //
              // unset($set);
              //
              // $inv_assoc = array("userId" => $part_obj->id, "companyName" => $part_obj->business_name, "address" => $part_obj->address, "subTotal" => $pro_obj->mrp , "taxAmount" => $pro_obj->mrp * (0.15), "taxRate" => 15
              //     , "totalAftertax" => $pro_obj->mrp*(1.15), "amountPaid" => 0, "amountDue" => $pro_obj->mrp*(1.15), "invoiceType" => "Invoice", "notes" => $pro_desc
              //     , "productCode" => array($pro_obj->code), "productName" => array($pro_obj->name), "quantity" => array(1), "price" => array($pro_obj->mrp), "total" => array($pro_obj->mrp));
              //
              // $invoice_obj = new Invoice($connect);
              // if ($invoice_obj->saveInvoice($inv_assoc)) {
              //   $query = 'UPDATE partners ';
              //   $query .= 'SET status = \'CONTRACT\' ';
              //   $query .= 'WHERE id = '. $part_id;
              //
              //   $result = $connect->query($query);
              //
              //   if (!$result) {
              //     $msg = 'Database Error! Failed to update partner status.<br>Code: ' . $connect->errno . ' Error: '. $connect->error;
              //     header('Location: invoice.php?save_invoice=error&msg='. $msg);
              //   } else {
              //     $msg = 'Invoice record has been created successfully!<br>Payment must be indicated for partner\'s account to be active.';
              //     header('Location: invoice.php?save_invoice=success&msg='. $msg);
              //   }
              // } else {
              //   $msg = 'Database Error! Failed to create invoice record.<br>Code: ' . $connect->errno . ' Error: '. $connect->error;
              //   header('Location: invoice.php?save_invoice=error&msg='. $msg);
              // }
              break;

            default:
              // code...
              break;
          }

        }
        break;

      case 'add product':
      case 'edit product':
        // processing product form data
        $code = mysqli_real_escape_string($connect, $_POST['productCode']);
        $name = mysqli_real_escape_string($connect, $_POST['productName']);
        $desc = mysqli_real_escape_string($connect, $_POST['productDescription']);
        $quantity = intval(mysqli_real_escape_string($connect, $_POST['quantityInStock']));
        $mrp = sprintf("%.2f", mysqli_real_escape_string($connect, $_POST['mrp']));

        if ($operation == 'edit product') {
          $old_code = $_GET['code'];

          $query = 'UPDATE products ';
          $query .= "SET code = '$code', pro_name = '$name', pro_desc = '$pro_desc', quantity = $quantity, mrp = $mrp ";
          $query .= "WHERE code = '$old_code'; ";
        } else {
          $query = 'INSERT INTO products VALUES ';
          $query .= "('$code', '$name', '$desc', $quantity, $mrp);";
        }

        if (!($result = mysqli_query($connect, $query))) {
          die('-- DATABASE QUERY FAILED! -- <br>CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect));
        } else {
          // redirect to add_product page with success message
          if ($operation == 'edit product') {
            $msg = 'Product Updated Successfully!';
            header('Location: manage_product.php?product_edit=success&msg='. $msg);
          } else {
            $msg = 'Product Added Successfully!';
            header('Location: add_product.php?product_add=success&msg='. $msg);
          }
          exit;
        }

        break;

      case 'create invoice':

        // process invoice data

        $invoice_obj = new Invoice($connect);
        if ($invoice_obj->saveInvoice($_POST)) {
          header('Location: invoice.php?save_invoice=success');
        } else {
          header('Location: invoice.php?save_invoice=error');
        }

        exit;

        break;

      case 'invoice operation';
        $inv_id = intval($_GET['inv_id']);
        $inv_ops = mysqli_real_escape_string($connect, $_POST['inv']);

        if ($inv_ops == 'del') {
          $inv = new Invoice($connect);

          $inv->deleteInvoice($inv_id);

          header('Location: invoice.php?status=delete');
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
