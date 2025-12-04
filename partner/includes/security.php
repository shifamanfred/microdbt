<?php
session_start();

if (! (isset($_SESSION['id']) && isset($_SESSION['cred_id']) && isset($_SESSION['role']))) {

	// administrative login page
  header('Location: ../login.php');
  exit;
} else if ($_SESSION['role'] != 'partners' && $_SESSION['role'] != 'partner_employees') {

  $role = strval($_SESSION['role']);

  switch ($role) {
    case 'super_users':
      // redirect page for partners...
      header('Location: ../index.php');
      break;

    default:
      // redirect page for customers...
      header('Location: ../../index.php');
      break;
  }
  
  exit;
}

?>
