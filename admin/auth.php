<?php
session_start();

require_once('../config/db_connect.php');

// initialize the form's username and password

$user = mysqli_real_escape_string($connect, $_POST['username']);
$pass = mysqli_real_escape_string($connect, $_POST['password']);

// retrieve username and passwords from database and
// matches with the ones inputted from operator
$query = 'SELECT id FROM credentials ';
$query .= "WHERE username = '$user' AND password = '$pass';";

$result = mysqli_query($connect, $query);

if (mysqli_num_rows($result) == 1 && $row = mysqli_fetch_assoc($result)) {
  // this code executes if and only if they match...

  // init credentials id
  $cred_id = $row['id'];

  // free previous result if any
  mysqli_free_result($result);

  function generateSQL($table_name, $cred_id) {
    $query = 'SELECT * FROM ' . $table_name . ' ';
    $query .= 'WHERE cred_id = ' . $cred_id . ';';

    return $query;
  }

  $query = generateSQL('partner_employees', $cred_id);
  $result = mysqli_query($connect, $query);

  if (mysqli_num_rows($result) == 1 && $row = mysqli_fetch_assoc($result)) {
    // partner_employees user level access granted
    $_SESSION['id'] = $row['id'];
    $_SESSION['cred_id'] = $cred_id;
    $_SESSION['role'] = 'partner_employees';

    // housekeeping
    mysqli_free_result($result);

    // partner employee's page redirect
    header('Location: ../partner/index.php');
    exit();
  }

  $query = generateSQL('partners', $cred_id);
  $result = mysqli_query($connect, $query);

  if (mysqli_num_rows($result) == 1 && $row = mysqli_fetch_assoc($result)) {

    // partners' level access granted!!
    $_SESSION['id'] = $row['id'];
    $_SESSION['cred_id'] = $cred_id;
    $_SESSION['role'] = 'partners';

    // housekeeping
    mysqli_free_result($result);

    // partner's page redirect
    header('Location: ../partner/index.php');
    exit();
  }

  $query = generateSQL('super_users', $cred_id);
  $result = mysqli_query($connect, $query);

  if (mysqli_num_rows($result) == 1 && $row = mysqli_fetch_assoc($result)) {
    // super users' access granted
    $_SESSION['id'] = $row['id'];
    $_SESSION['cred_id'] = $cred_id;
    $_SESSION['role'] = 'super_users';

    // housekeeping
    mysqli_free_result($result);

    // super user case page redirect
    header('Location: index.php');
    exit();
  }


  // rare case senario: two or more users have the same username and password
  // despite the unique constraint placed on the username column
  header('Location: ../index.php');
} else {

  mysqli_free_result($result);
  // Authentication Error!!
  header('Location: ../index.php?err=1');
}

?>
