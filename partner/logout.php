<?php

session_start();

session_destroy();

// redirecting from partners portal
header('Location: ../index.php');
?>
