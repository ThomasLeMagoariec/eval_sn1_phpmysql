<?php
require_once 'functions.php';
requireLogin();

if (!isset($_POST['register'], $_POST['event_id'])) {
    header('Location: index.php');
    exit;
}

$eventId = (int)$_POST['event_id'];
$userEmail = $_SESSION['email'];

$userId = getUserIdByEmail($dbh, $userEmail);
if (!$userId) {
    header('Location: connexion.php');
    exit;
}

$event = getEventById($dbh, $eventId);
if (!$event || !$event['is_validated']) {
    header('Location: evenement.php?id=' . $eventId);
    exit;
}

if (isUserRegistered($dbh, $userId, $eventId)) {
    header('Location: evenement.php?id=' . $eventId);
    exit;
}

$reservationsCount = countReservations($dbh, $eventId);
if ($reservationsCount >= $event['places']) {
    header('Location: evenement.php?id=' . $eventId);
    exit;
}

registerUserToEvent($dbh, $userId, $eventId);
header('Location: evenement.php?id=' . $eventId);
exit;