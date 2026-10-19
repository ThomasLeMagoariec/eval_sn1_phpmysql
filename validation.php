<?php
require_once 'validate.php';
requireAdmin();
handleValidateEvent($dbh);

$events = getPendingEvents($dbh);
$eventsCount = count($events);
$pendingEventsTable = renderPendingEventsTable($events);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Validation des événements · Agenda</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>📅</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'header.php' ?>
    <?php
    echo
    '<div class="section-head">' .
    '  <div>' .
    '    <h1>Événements à valider</h1>' .
    '    <p class="muted">' . $eventsCount . ' événement(s) en attente de validation.</p>' .
    '  </div>' .
    '</div>' .

    $pendingEventsTable;
    ?>
    <?php include 'footer.php' ?>
</body>
</html>