<?php

try {
	$dbh = new PDO(
    	'mysql:host=localhost;dbname=agenda',
    	'root',
    	'root'
	);
} catch (PDOException $e) {
	die($e->getMessage());
}

session_start();
?>
