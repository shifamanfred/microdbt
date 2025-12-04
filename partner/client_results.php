<?php

include '../config/db_connect.php';
include './includes/classes.php';

$search_text = $_POST['searchText'];

$result = Borrower::getBorrowerRecordsWithSearch($connect, $search_text);

if (!$result) {
  echo '<tr class="text text-danger" colspan="4"><td><i class="fa fa-warning"></i> DATABASE ERROR. Please contact the webmaster.</td></tr>';
  echo '<tr><td>CODE: '. $connect->errno . ' ERROR: '. $connect->error .'</td></tr>';
} else if ($result->num_rows <= 0) {
  echo '<tr class="text text-info" colspan="4"><td><i class="fa fa-info-circle"></i> No record with '. $search_text .' exists.</td></tr>';
} else {
  while ($rec = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>'. $rec['id_number'] .'</td>';
    echo '<td>'. $rec['first_name'] .' '. $rec['last_name'] .'</td>';
    echo '<td>'. $rec['email'] .'</td>';
    echo '<td>'. $rec['phone'] .'</td>';
    echo '<td>'. $rec['status'] .'</td>';
    echo '</tr>';
  }
}

?>
