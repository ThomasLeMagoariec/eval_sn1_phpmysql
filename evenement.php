<?php
require_once 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    http_response_code(404);
    include '404.php';
    exit;
}

$event = getEventById($dbh, $id);

if (!$event) {
    http_response_code(404);
    include '404.php';
    exit;
}

// Only show validated events
if (!$event['is_validated']) {
    http_response_code(404);
    include '404.php';
    exit;
}

$cat = $event['category'];
$catColors = [
    'concert' => 'var(--concert)',
    'conference' => 'var(--conference)',
    'atelier' => 'var(--atelier)',
    'sport' => 'var(--sport)',
];
$catColor = $catColors[$cat] ?? 'var(--muted)';

$eventDate = new DateTime($event['date']);
$formattedDate = $eventDate->format('d/m/Y');
$formattedDay = $eventDate->format('d');
$formattedMonth = $eventDate->format('M');
$eventTime = $eventDate->format('H\hi');

$reservationsCount = countReservations($dbh, $id);
$placesTotal = (int)$event['places'];
$placesRestantes = max(0, $placesTotal - $reservationsCount);
$percent = $placesTotal > 0 ? min(100, round((($placesTotal - $placesRestantes) / $placesTotal) * 100)) : 0;

$userRegistered = false;
$userId = null;
if (isLoggedIn()) {
    $userId = getUserIdByEmail($dbh, $_SESSION['email']);
    if ($userId) {
        $userRegistered = isUserRegistered($dbh, $userId, $id);
    }
}

$imagePath = $event['image'] ? htmlspecialchars($event['image']) : 'images/concert.jpg';
$information = nl2br(htmlspecialchars($event['information']));
$title = htmlspecialchars($event['title']);
$badge = htmlspecialchars($event['category']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?> · Agenda</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>📅</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .detail-hero { background-image: url('<?= $imagePath ?>'); }
        .badge { background: <?= $catColor ?>; }
        .event-date .month { color: <?= $catColor ?>; }
        .cat-concert { --cat: var(--concert); }
        .cat-conference { --cat: var(--conference); }
        .cat-atelier { --cat: var(--atelier); }
        .cat-sport { --cat: var(--sport); }
        .progress span { background: <?= $catColor ?>; }
    </style>
</head>
<body>
<?php include 'header.php' ?>
<?php
$bookingHtml = "";
if (isLoggedIn()) {
    if ($userRegistered) {
        $bookingHtml =
        "      <form method='post' action='annuler_reservation.php'>" .
        "        <input type='hidden' name='event_id' value='{$event['id']}'>" .
        "        <button type='submit' name='unregister' class='btn btn-secondary btn-block'>Annuler ma réservation</button>" .
        "      </form>" .
        "      <p class='muted' style='margin-top: 8px; text-align: center;'>Vous êtes inscrit à cet événement.</p>";
    } elseif ($placesRestantes > 0) {
        $bookingHtml =
        "      <form method='post' action='inscription_evenement.php'>" .
        "        <input type='hidden' name='event_id' value='{$event['id']}'>" .
        "        <button type='submit' name='register' class='btn btn-block'>Réserver</button>" .
        "      </form>";
    } else {
        $bookingHtml = "      <button class='btn btn-block' disabled>Complet</button>";
    }
} else {
    $bookingHtml = "      <a class='btn btn-block' href='connexion.php'>Connectez-vous pour réserver</a>";
}

echo
"<a class='back-link' href='index.php'>← Retour aux événements</a>" .

"<article class='cat-$cat'>" .
"  <header class='detail-hero'>" .
"    <div class='detail-hero-content'>" .
"      <span class='badge'>$badge</span>" .
"      <h1>$title</h1>" .
"      <p>$formattedDate · $eventTime</p>" .
"    </div>" .
"  </header>" .

"  <div class='detail-grid'>" .
"    <section class='card'>" .
"      <h2>Informations</h2>" .
"      <p>$information</p>" .
"    </section>" .

"    <aside class='card booking'>" .
"      <p class='places'><strong>$placesRestantes</strong> places restantes sur $placesTotal</p>" .
"      <div class='progress'><span style='width: $percent%'></span></div>" .

$bookingHtml .

"    </aside>" .
"  </div>" .
"</article>";
?>
<?php include 'footer.php' ?>
</body>
</html>
