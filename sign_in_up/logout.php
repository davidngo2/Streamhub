<?php

session_start(); // Start the session

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: ../sign_in_up/sign_in.php");
exit();
?>
