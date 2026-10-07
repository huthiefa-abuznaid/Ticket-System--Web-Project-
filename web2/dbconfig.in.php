<?php
define('DBHOST', 'localhost');
define('DBNAME', 'ticketSystem');
define('DBUSER', 'root');
define('DBPASS', '0569678316');

try {
   $pdo = new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME, DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());

    }
?> 
