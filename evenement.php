<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Soirée jazz au Kiosque · Agenda</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>📅</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?php include 'header.php' ?>

    <a class="back-link" href="index.html">← Retour aux événements</a>

    <article class="cat-concert">
        <header class="detail-hero" style="background-image: url('images/concert.jpg')">
            <div class="detail-hero-content">
                <span class="badge">Concert</span>
                <h1>Soirée jazz au Kiosque</h1>
                <p>Samedi 07/11/2026 · 20h30</p>
            </div>
        </header>

        <div class="detail-grid">
            <section class="card">
                <h2>Informations</h2>
                <p>Le quartet CuRuba vous propose une soirée de jazz antillais au Kiosque du parc municipal.</p>
                <p>Programme : 20h30 première partie, 21h30 concert principal. Buvette sur place, entrée libre sur inscription.</p>
            </section>

            <aside class="card booking">
                <p class="places"><strong>12</strong> places restantes sur 80</p>
                <!-- La largeur de la barre = pourcentage de places prises -->
                <div class="progress"><span style="width: 85%"></span></div>

                <form method="post">
                    <button type="submit" class="btn btn-block">S'inscrire</button>
                </form>

                <!-- Variante quand l'utilisateur est déjà inscrit :
                <p class="muted">Vous êtes inscrit à cet événement.</p>
                <form method="post">
                    <button type="submit" class="btn btn-secondary btn-block">Se désinscrire</button>
                </form>
                -->

                <!-- Variante quand l'événement est complet :
                <p class="places"><span class="badge badge-full">Complet</span></p>
                <button class="btn btn-block" disabled>Complet</button>
                -->

                <!-- Variante quand l'utilisateur n'est pas connecté :
                <a class="btn btn-block" href="connexion.html">Connectez-vous pour vous inscrire</a>
                -->
            </aside>
        </div>
    </article>

	<?php include 'footer.php' ?>
</body>
</html>
