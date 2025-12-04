<?php

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
      echo 'Error Occured. Please contact the webmaster. <a href="../index.php">Home</a>';
      echo '<br>CODE: ' . $connect->errno() . ' ERROR: ' . $connect->error() . '<br>';
      die ('!! DATABASE QUERY FAILED !!');
    } else {
      $row = $result->fetch_assoc();

      // this was my mistake here The '$' eish
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
      $this->status = $row['status'];
      $this->recorded_at = $row['recorded_at'];

      // Close connections
      $result->free_result();
    }
  }
}

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

class Invoice {
  var $invoiceOrderTable = 'invoice_orders';
  var $invoiceOrderItemTable = 'invoice_order_items';
  var $dbConnect;

  function __construct($connect) {
    $this->dbConnect = $connect;
  }

  public function getData($sql) {
    $result = $this->dbConnect->query($sql);

    if (!$result) {
      // error in retrieving data
      return null;
    } else {
      return $result;
    }
  }

  public function saveInvoice($POST) {
    $sqlInsert = "
    INSERT INTO ".$this->invoiceOrderTable."(user_id, order_receiver_name, order_receiver_address, order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax, order_amount_paid, order_total_amount_due, order_type, note)
    VALUES ('".$POST['userId']."', '".$POST['companyName']."', '".$POST['address']."', '".$POST['subTotal']."', '".$POST['taxAmount']."', '".$POST['taxRate']."'
    , '".$POST['totalAftertax']."', '".$POST['amountPaid']."', '".$POST['amountDue']."', '".$POST['invoiceType']."', '".$POST['notes']."')";
    $sql_result = mysqli_query($this->dbConnect, $sqlInsert);

    if (!$sql_result) {
      echo '<br>SQL: ' . $sqlInsert . '<br>';
      die('-- DATABASE QUERY FAILED ON TABLE ' . $this->invoiceOrderTable . '! -- <br>CODE: ' . mysqli_errno($this->dbConnect) . ' ERROR: ' . mysqli_error($this->dbConnect));
    }

    $lastInsertId = mysqli_insert_id($this->dbConnect);
    for ($i = 0; $i < count($POST['productCode']); $i++) { $sqlInsertItem = " INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount)
      VALUES ('".$lastInsertId."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";
      $sql_result2 = mysqli_query($this->dbConnect, $sqlInsertItem);

      if (!$sql_result2) {
        echo '<br>SQL: ' . $sqlInsert . '<br>';
        die('-- DATABASE QUERY FAILED ON TABLE "' . $this->invoiceOrderItemTable . '"! -- <br>CODE: ' . mysqli_errno($this->dbConnect) . ' ERROR: ' . mysqli_error($this->dbConnect));
      }
    }

    return true;
  }

  public function updateInvoice($POST) {
    if($POST['invoiceId']) {
      $sqlInsert = "
      UPDATE ".$this->invoiceOrderTable."
      SET order_receiver_name = '".$POST['companyName']."', order_receiver_address= '".$POST['address']."'
      , order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['taxAmount']."'
      , order_tax_per = '".$POST['taxRate']."', order_total_after_tax = '".$POST['totalAftertax']."'
      , order_amount_paid = '".$POST['amountPaid']."'
      , order_total_amount_due = '".$POST['amountDue']."'
      , note = '".$POST['notes']."'
      WHERE user_id = '".$POST['userId']."' AND order_id = '".$POST['invoiceId']."'";
      mysqli_query($this->dbConnect, $sqlInsert);
    }
    $this->deleteInvoiceItems($POST['invoiceId']);
    for ($i = 0; $i < count($POST['productCode']); $i++) { $sqlInsertItem = " INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount)
      VALUES ('".$POST['invoiceId']."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";
      mysqli_query($this->dbConnect, $sqlInsertItem);
    }
  }

  public function getInvoiceList(){
    $sqlQuery = "
    SELECT * FROM ".$this->invoiceOrderTable."
    WHERE user_id = '".$_SESSION['userid']."'";
    return $this->getData($sqlQuery);
  }

  public function getInvoice($invoiceId, $part_id){
    $sqlQuery = "
    SELECT * FROM ".$this->invoiceOrderTable."
    WHERE user_id = '".$part_id."' AND order_id = '$invoiceId'";
    $result = mysqli_query($this->dbConnect, $sqlQuery);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    return $row;
  }

  public function getInvoiceItems($invoiceId) {
    $sqlQuery = "
    SELECT * FROM ".$this->invoiceOrderItemTable."
    WHERE order_id = '$invoiceId'";
    return $this->getData($sqlQuery);
  }

  public function deleteInvoiceItems($invoiceId){
    $sqlQuery = "
    DELETE FROM ".$this->invoiceOrderItemTable."
    WHERE order_id = '".$invoiceId."'";
    mysqli_query($this->dbConnect, $sqlQuery);
  }

  public function deleteInvoice($invoiceId){
    $sqlQuery = "
    DELETE FROM ".$this->invoiceOrderTable."
    WHERE order_id = '".$invoiceId."'";
    mysqli_query($this->dbConnect, $sqlQuery);
    $this->deleteInvoiceItems($invoiceId);
    return 1;
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

class Product {
  var $code;
  var $pro_name;
  var $pro_desc;
  var $quantity;
  var $mrp;

  function __construct($connect, $code) {

    // generate product object according to the code passed in

    $query = 'SELECT * FROM products ';
    $query .= 'WHERE code = \''. $code . '\';';

    $result = $connect->query($query);

    if (!$result) {
      echo '<span class="text-danger">!! DATA QUERY FAILED!!</span>';
      echo '<span class="text-danger">CODE: ' . mysqli_errno($connect) . ' ERROR: ' . mysqli_error($connect) . '</span>';
      die ('!! DATABASE QUERY FAILED !! Please contact the webmaster!');
    } else if ($result->num_rows == 1 && $rec = $result->fetch_assoc()) {
      $this->code = $rec['code'];
      $this->pro_name = $rec['pro_name'];
      $this->pro_desc = $rec['pro_desc'];
      $this->quantity = $rec['quantity'];
      $this->mrp = $rec['mrp'];
    } else {
      $this->code = 0;
      $this->pro_name = '';
      $this->pro_desc = '';
      $this->quantity = 0;
      $this->mrp = 0.00;
    }

    $result->free_result();
  }

  public static function getProductRecords($connect) {
    // get all products
    $query = 'SELECT code, pro_name, pro_desc, quantity, mrp ';
    $query .= 'FROM products';

    $result = $connect->query($query);

    if (!$result) {
      return null;
    } else {
      return $result;
    }
  }
}
