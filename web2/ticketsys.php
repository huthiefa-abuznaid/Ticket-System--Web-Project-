<?php
session_start();

if (!isset($_SESSION["user_type"])) {
    header("Location: login.php");
    exit();
}

if ($_SESSION["user_type"] == "customer") {
    header("Location: customer.php");
    exit();
}

if ($_SESSION["user_type"] == "manager") {
    header("Location: manager.php");
    exit();
}


?>