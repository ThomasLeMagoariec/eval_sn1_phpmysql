<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Événements à venir · Agenda</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>📅</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?php include "header.php" ?>
    <main class="container">
        <!-- Exemples de messages :
        <div class="flash flash-success">Votre événement a bien été ajouté.</div>
        <div class="flash flash-error">Une erreur est survenue.</div>
        -->
        <!-- ===== Fin de l'en-tête ===== -->

    <section class="hero" style="background-image: url('images/rock.jpg')">
        <div class="hero-content">
            <span class="hero-kicker">Agenda local</span>
            <h1>Les événements près de chez vous</h1>
            <p>Concerts, conférences, ateliers et sport : trouvez votre prochaine sortie ou proposez la vôtre.</p>
            <a class="btn" href="ajouter.html">+ Ajouter un événement</a>
        </div>
    </section>

    <div class="section-head">
        <h2>À venir</h2>
        <!-- La catégorie sélectionnée porte la classe « active » -->
        <ul class="legend">
            <li><a class="active" href="index.html">Toutes</a></li>
            <li class="cat-concert"><a href="index.html?categorie=concert">Concert</a></li>
            <li class="cat-conference"><a href="index.html?categorie=conference">Conférence</a></li>
            <li class="cat-atelier"><a href="index.html?categorie=atelier">Atelier</a></li>
            <li class="cat-sport"><a href="index.html?categorie=sport">Sport</a></li>
        </ul>
    </div>

    <ul class="event-list">
        <li class="event-card cat-concert">
            <div class="event-media">
                <img class="event-image" src="images/concert.jpg" alt="">
                <div class="event-date"><span class="day">07</span><span class="month">nov.</span></div>
                <span class="badge">Concert</span>
            </div>
            <h3 class="event-title"><a href="evenement.html?id=1">Soirée jazz au Kiosque</a></h3>
            <span class="muted">07/11/2026 · 20h30</span>
        </li>
        <li class="event-card cat-conference">
            <div class="event-media">
                <img class="event-image" src="images/conference.jpg" alt="">
                <div class="event-date"><span class="day">12</span><span class="month">nov.</span></div>
                <span class="badge">Conférence</span>
            </div>
            <h3 class="event-title"><a href="evenement.html?id=2">L'IA expliquée simplement</a></h3>
            <span class="muted">12/11/2026 · 18h00</span>
        </li>
        <li class="event-card cat-atelier">
            <div class="event-media">
                <img class="event-image" src="images/atelier.jpg" alt="">
                <div class="event-date"><span class="day">21</span><span class="month">nov.</span></div>
                <span class="badge">Atelier</span>
            </div>
            <h3 class="event-title"><a href="evenement.html?id=3">Initiation à la poterie</a></h3>
            <span class="muted">21/11/2026 · 14h00</span>
        </li>
        <li class="event-card cat-sport">
            <div class="event-media">
                <img class="event-image" src="images/sport.jpg" alt="">
                <div class="event-date"><span class="day">29</span><span class="month">nov.</span></div>
                <span class="badge">Sport</span>
            </div>
            <h3 class="event-title"><a href="evenement.html?id=4">Semi-marathon de la ville</a></h3>
            <span class="muted">29/11/2026 · 09h00</span>
        </li>
        <li class="event-card cat-concert">
            <div class="event-media">
                <img class="event-image" src="images/rock.jpg" alt="">
                <div class="event-date"><span class="day">05</span><span class="month">déc.</span></div>
                <span class="badge">Concert</span>
            </div>
            <h3 class="event-title"><a href="evenement.html?id=5">Rock indé au Sous-Sol</a></h3>
            <span class="muted">05/12/2026 · 21h00</span>
        </li>
        <li class="event-card cat-sport">
            <div class="event-media">
                <img class="event-image" src="images/escalade.jpg" alt="">
                <div class="event-date"><span class="day">13</span><span class="month">déc.</span></div>
                <span class="badge">Sport</span>
            </div>
            <h3 class="event-title"><a href="evenement.html?id=6">Escalade en famille</a></h3>
            <span class="muted">13/12/2026 · 10h00</span>
        </li>
    </ul>

    <!-- Si aucun événement :
    <p class="empty">Aucun événement à venir pour le moment.</p>
    -->

    <!-- ===== Début du pied de page (à mettre dans un fichier footer.php) ===== -->
    </main>

    <footer class="site-footer">
        Agenda · Projet de formation PHP / MySQL
    </footer>
</body>
</html>
