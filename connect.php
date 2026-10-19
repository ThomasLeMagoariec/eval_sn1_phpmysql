<?php

require_once 'config.php';

function login($dbh) {
	// TODO check password fiedl
	if (isset($_POST["email"]) && $_POST["email"] != "")
	{
		$query = $dbh->prepare("SELECT password FROM user WHERE email = :email");
		$query->execute(array("email" => $_POST["email"]));
		$user = $query->fetch(PDO::FETCH_ASSOC);
		if ($user) {
			if (password_verify($_POST["password"], $user["password"])) {
				$_SESSION["email"] = $_POST["email"];
				header("Location: ./index.php");
				exit;
			} else { return false; }
		} else { return false; }
	} else { return false; }
	return true;
}

if (isset($_POST["login"])) {
	$res = login($dbh);
	if (!$res) {
		echo "<div class='flash flash-error'>Identifiants invalides.</div>";
	}
}

?>
