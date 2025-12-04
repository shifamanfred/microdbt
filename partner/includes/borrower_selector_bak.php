<?php

// retrieve borrower Details

$result = Borrower::getBorrowerRecords($connect);

if (isset($_GET['client_id'])) {
  $client_id = $_GET['client_id'];
} else {
  $client_id = 0;
}

if (!$result) {
  echo '<p class="text text-danger">Data Retrival Failed!! Please contact the webmaster</p>';
} else {
  ?>
  <label>Select Customer</label>
  <select class="form-control" name="borrower_id">
    <?php while($rec = $result->fetch_assoc()) { ?>
      <option <?php echo $client_id == $rec['id'] ? 'selected style="background-color: #0F0;"' : ''; ?> value="<?php echo $rec['id']; ?>"><?php echo $rec['id_number'] . ' - ' . $rec['last_name']; ?></option>
      <?php
    }
    ?>
  </select>
  <?php
}
?>
