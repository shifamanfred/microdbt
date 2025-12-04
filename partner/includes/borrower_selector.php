<?php

// retrieve borrower Details

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['client_id'])) {

  // get client id form data
  if (isset($_POST['client_id'])) {
    $client_id = $_POST['client_id'];
  } else {
    $client_id = Borrower::getBorrowerID($connect, $_GET['client_id']);
  }

  if ($client_id != NULL && $client_id != '') {
    // if client_id form data is not null search for the id
    $result = Borrower::getBorrowerRecords($connect);

    if ($result) {
      $borrower_id = -1;

      while ($rec = $result->fetch_assoc()) {

        // if client id number has been found set the system client id
        if ($rec['id_number'] == $client_id) {
          $borrower_id = $rec['id'];
          break;
        }
      }

      $result->free_result();

      if (isset($borrower_condition)) {

        if ($borrower_condition == 'borrowers_added_by_this partner_only') {
          // if this borrower does not have any loan: DECLARE AS NOT FOUND
          $borrower_obj = new Borrower($connect, $borrower_id);

          if ($borrower_obj->partner_no != $part_id) {
            $borrower_id = -2;
          }

          unset($borrower_obj);
        }

        if ($borrower_condition == 'borrowers_with_loans_only') {
          // if this borrower does not have any loan: DECLARE AS NOT FOUND
          $result = LoanAccount::getBorrowerLoanRecords($connect, $borrower_id);

          if (!$result) {
            $borrower_id = -1;
          } else {
            if ($result->num_rows <= 0) {
              $borrower_id = -1;
            }

            $result->free_result();
          }
        }
      }

      if ($borrower_id == -2) {
        // if client record has not been found
        $helptext = 'Sorry: Client of id <strong>'. $client_id .'</strong> has been found but details cannot be updated.';
        $helptexttype = 'danger';
        $client_id = 0;
      } else if ($borrower_id == -1) {
        // if client record has not been found
        $helptext = 'Sorry: Client of id <strong>'. $client_id .'</strong> has not been found! Please fill in the <a href="add_client.php?id_num='. $client_id .'"><strong>add client</strong></a> form if it\'s a new client.';
        $helptexttype = 'danger';
        $client_id = 0;
      } else {
        // client record has been found


        if (isset($_POST['client_id'])) {
          $borrower_obj = new Borrower($connect, $borrower_id);
          $helptext = 'Client has been found! Name is: ' . $borrower_obj->name .' '. $borrower_obj->last_name;
        } else {
          if (isset($page) && $page = 'loans') {
            $borrower_obj = new Borrower($connect, $borrower_id);
            $helptext = 'Name is: ' . $borrower_obj->name .' '. $borrower_obj->last_name;
          } else {
            $helptext = 'Please Update the client\' Details!';
          }
        }
        $helptexttype = 'success';
      }

    } else {
      // client record has not been found
      $helptext = 'DATABASE ERROR: Please contact the webmaster';
      $helptexttype = 'danger';
      $client_id = 0;
    }

  } else {
    // otherwise set it to zero
    $helptext = 'ERROR: Field is empty!';
    $helptexttype = 'danger';
    $client_id = 0;
  }
} else {
  // no post request: set the id to zero
  $helptext = 'Please search with ID / Passport number';
  $helptexttype = 'muted';
  $client_id = -1;
}

// construct the search form
?>
<form class="form-horizontal myaccount" role="form" action="" method="post">
  <div class="form-group has-<?php echo $helptexttype == 'success' ? $helptexttype : ($helptexttype == 'muted' ? '': 'error'); ?>">
    <button class="col-sm-2 btn btn-theme03" type="submit">Search</button>
    <div class="col-sm-10">

      <div class="col-sm-<?php echo isset($borrower_obj) ? '8' : '12' ?>">
        <input class="form-control col-sm-8" placeholder="Please search with ID / Passport number" type="text" name="client_id" value="<?php echo ($client_id > 0) ? $client_id : '' ?>" required>
        <small id="emailHelp" class="form-text text-<?php echo $helptexttype; ?>"><?php echo $helptext; ?></small>
      </div>

      <?php
      if (isset($borrower_obj)) {
      ?>
      <div class="col-sm-4">
        <p>Client Name:<br> <?php echo $borrower_obj->name .' '. $borrower_obj->last_name; ?></p>
      </div>
      <?php } ?>
    </div>
  </div>
</form>

<?php
if (isset($borrower_obj)) {
  unset($borrower_obj);
}
?>
