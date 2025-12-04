<?php
session_start();

if (! (isset($_SESSION['id']) && isset($_SESSION['cred_id']) && isset($_SESSION['role']))) {
  header('Location: login.php');
  exit;
} else if ($_SESSION['role'] != 'super_users') {

  $role = strval($_SESSION['role']);

  switch ($role) {
    case 'partners':
      // redirect page for partners...
      header('Location: partner/index.php');
      break;

    default:
      // redirect page for customers...
      header('Location: ../index.php');
      break;
  }

  exit;
}

?>
