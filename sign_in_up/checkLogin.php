<?php

// checkLogin.php
session_start();

function checkLogin()
{
    // Redirect to login page if user is not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../sign_in_up/sign_in.php");
        exit();
    }
}
