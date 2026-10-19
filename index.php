<?php
require_once 'config.php';
require_once 'event.php';
?>
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
<?php include 'header.php' ?>

<section class="hero" style="background-image: url('images/rock.jpg')">
    <div class="hero-content">
        <span class="hero-kicker">Agenda local</span>
        <h1>Les événements près de chez vous</h1>
        <p>Concerts, conférences, ateliers et sport : trouvez votre prochaine sortie ou proposez la vôtre.</p>
        <a class="btn" href="ajouter.php">+ Ajouter un événement</a>
    </div>
</section>

<div class="section-head">
    <h2>À venir</h2>
    <ul class="legend">
        <?php build_filter() ?>
    </ul>
</div>

<?php build_events($dbh) ?>

<?php include 'footer.php' ?>
</body>
</html>