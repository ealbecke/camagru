<?php
include('config/database.php');
include('config/setup.php');
try {
	$bdd = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
	$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error connection: ' . $e->getMessage();
    return false;
}