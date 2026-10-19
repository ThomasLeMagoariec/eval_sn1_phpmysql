<?php 
require_once 'config.php';
include 'connect.php';

$alreadyLoggedIn = isset($_SESSION["email"]);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion · Agenda</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>📅</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?php include 'header.php' ?>
    <div class="narrow">
        <div class="card">
            <h1>Connexion</h1>

            <?php if ($alreadyLoggedIn): ?>
                <div class="flash flash-success">Vous êtes déjà connecté en tant que <strong><?= htmlspecialchars($_SESSION["email"]) ?></strong>.</div>
            <?php endif; ?>

            <form class="form<?= $alreadyLoggedIn ? ' form-disabled' : '' ?>" method="post" <?= $alreadyLoggedIn ? 'aria-disabled="true"' : '' ?>>
                <div>
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" autocomplete="email" required autofocus value="<?= $alreadyLoggedIn ? htmlspecialchars($_SESSION["email"]) : '' ?>" <?= $alreadyLoggedIn ? 'disabled' : '' ?>>
                </div>

                <div>
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" name="password" autocomplete="current-password" required <?= $alreadyLoggedIn ? 'disabled' : '' ?>>
                </div>

                <button type="submit" name="login" <?= $alreadyLoggedIn ? 'disabled' : '' ?>>Se connecter</button>
            </form>

            <p class="form-footer">Pas encore de compte ? <a href="inscription.php">Créer un compte</a></p>
        </div>
    </div>
	<?php include 'footer.php' ?>
</body>
</html>
