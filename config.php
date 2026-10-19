<?php

try {
	$dbh = new PDO(
    	'pgsql:host=10.0.0.4;port=5432;dbname=jo',
    	'epsi',
    	'root'
	);
} catch (PDOException $e) {
	die($e->getMessage());
}
?>
