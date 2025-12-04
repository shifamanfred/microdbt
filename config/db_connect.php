<?php

// connect to database
$host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'loan';

$connect = mysqli_connect($host, $db_user, $db_pass, $db_name);
if (!$connect) {
  echo '<a href="index.php" style="background-color: #555753; color: white; text-decoration: none;">Back</a>';
  die ('<br>Database connection failed...!!<br>');
}
?>