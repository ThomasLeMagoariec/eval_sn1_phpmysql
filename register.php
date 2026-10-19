<?php

require_once 'config.php';

function register(PDO $dbh) {
    if (!isset($_POST["email"]) || trim($_POST["email"]) === "") {
        return false;
    }

    if (!isset($_POST["password"]) || strlen($_POST["password"]) < 6) {
        return false;
    }

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Check if email already exists
    $query = $dbh->prepare("SELECT id FROM user WHERE email = :email");
    $query->execute(["email" => $email]);
    if ($query->fetch()) {
        return false; // Email already registered
    }

    // Hash password and insert user
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $query = $dbh->prepare("INSERT INTO user (email, password) VALUES (:email, :password)");
    return $query->execute([
        "email" => $email,
        "password" => $hashedPassword
    ]);
}

if (isset($_POST["register"])) {
    $res = register($dbh);
    if (!$res) {
        echo "<div class='flash flash-error'>Erreur: email invalide, déjà utilisé, ou mot de passe trop court (6 caractères minimum).</div>";
    } else {
        echo "<div class='flash flash-success'>Compte créé avec succès. <a href='connexion.php'>Se connecter</a>.</div>";
    }
}

?>
