<?php
require_once 'functions.php';

$isLoggedIn = isLoggedIn();
$isAdmin = isAdmin();
?>
<header class="site-header">
    <div class="container">
        <a class="logo" href="index.php">Agenda<span>.</span></a>
        <nav class="nav">
            <a href="index.php">Événements</a>

            <?php if ($isAdmin): ?>
            <a href="validation.php">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                Validation
            </a>

            <a href="inscrits.php">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8" r="4"/><path d="M2 21v-1a6 6 0 0 1 6-6h2a6 6 0 0 1 6 6v1"/><path d="M16 4a4 4 0 0 1 0 8"/><path d="M19 14a5 5 0 0 1 3 5v2"/></svg>
                Inscrits
            </a>
            <?php endif; ?>

            <?php if (!$isLoggedIn): ?>
            <a href="connexion.php">Connexion</a>
            <a class="btn btn-small" href="inscription.php">Créer un compte</a>
            <?php else: ?>
            <a class="btn btn-small" href="deconnexion.php">Se déconnecter</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main class="container">