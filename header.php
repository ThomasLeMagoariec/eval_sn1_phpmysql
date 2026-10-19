<?php

echo "<header class='site-header'>
        <div class='container'>
            <a class='logo' href='index.html'>Agenda<span>.</span></a>
            <nav class='nav'>
                <a href='index.html'>Événements</a>

                <!-- Lien visible UNIQUEMENT par les administrateurs -->
                <a href='validation.html'>
                    <svg class='icon' viewBox='0 0 24 24' aria-hidden='true'><rect x='4' y='11' width='16' height='10' rx='2'/><path d='M8 11V7a4 4 0 0 1 8 0v4'/></svg>
                    Validation
                </a>

                <!-- Lien visible UNIQUEMENT par les administrateurs -->
                <a href='inscrits.html'>
                    <svg class='icon' viewBox='0 0 24 24' aria-hidden='true'><circle cx='9' cy='8' r='4'/><path d='M2 21v-1a6 6 0 0 1 6-6h2a6 6 0 0 1 6 6v1'/><path d='M16 4a4 4 0 0 1 0 8'/><path d='M19 14a5 5 0 0 1 3 5v2'/></svg>
                    Inscrits
                </a>

                <!-- Utilisateur NON connecté -->
                <a href='connexion.html'>Connexion</a>
                <a class='btn btn-small' href='inscription.html'>Créer un compte</a>

                <!-- Variante quand l'utilisateur est connecté (remplace « Connexion » et « Créer un compte ») :
                <a class='btn btn-small' href='deconnexion.php'>Se déconnecter</a>
                -->
            </nav>
        </div>
    </header>
	<main class='container'>
        <!-- Exemples de messages :
        <div class='flash flash-success'>Votre événement a bien été ajouté.</div>
        <div class='flash flash-error'>Une erreur est survenue.</div>
        -->
		<!-- ===== Fin de l'en-tête ===== -->
";
?>
