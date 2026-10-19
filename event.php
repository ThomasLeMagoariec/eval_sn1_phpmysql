<?php
require_once 'functions.php';

function build_filter() {
    $filters = ["toutes", "concert", "conference", "atelier", "sport"];

    foreach ($filters as $filter) {
        $active = isset($_GET["categorie"]) && $_GET["categorie"] == $filter ? " class='active'" : "";
        $class = "cat-$filter";
        if ($active) $class .= " active";
        echo "<li><a class='$class' href='index.php?categorie=" . $filter . "'>" . $filter . "</a></li>";
    }
}

function get_events(PDO $dbh, string $filter): array {
    if ($filter === "toutes") {
        $query = $dbh->prepare("SELECT * FROM event WHERE is_validated = 1 AND date >= NOW() ORDER BY date ASC");
        $query->execute();
    } else {
        $query = $dbh->prepare("SELECT * FROM event WHERE category = :filter AND is_validated = 1 AND date >= NOW() ORDER BY date ASC");
        $query->execute(["filter" => $filter]);
    }
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function build_events(PDO $dbh) {
    $filter = "toutes";
    if (isset($_GET["categorie"]))
        $filter = $_GET["categorie"];

    $events = get_events($dbh, $filter);

    if (count($events) == 0) {
        echo "<p class='empty'>Aucun événement à venir pour le moment.</p>";
        return;
    }

    echo "<ul class='event-list'>";
    foreach ($events as $event) {
        $cat = $event["category"];
        $eventDate = new DateTime($event['date']);
        $formattedDay = $eventDate->format('d');
        $formattedMonth = $eventDate->format('M');
        $formattedTime = $eventDate->format('H\hi');
        $image = $event['image'] ? htmlspecialchars($event['image']) : 'images/concert.jpg';
        $title = htmlspecialchars($event['title']);

        echo "
            <li class='event-card cat-$cat'>
                <div class='event-media'>
                    <div class='event-date'><span class='day'>$formattedDay</span><span class='month'>$formattedMonth</span></div>
                    <img class='event-image' src='$image' alt=''>
                    <span class='badge'>$cat</span>
                </div>
                <h3 class='event-title'><a href='evenement.php?id=" . $event['id'] . "'>$title</a></h3>
                <span class='muted'>$formattedDay/$formattedMonth · $formattedTime</span>
            </li>
        ";
    }
    echo "</ul>";
}

function create_event(PDO $dbh): bool {
    if (!isset($_POST["title"]) || trim($_POST["title"]) == "") {
        return false;
    }

    if (!isset($_POST["date"]) || $_POST["date"] == "") {
        return false;
    }

    $eventDate = strtotime($_POST["date"]);
    if ($eventDate === false || $eventDate < strtotime("today")) {
        return false;
    }

    if (!isset($_POST["information"]) || trim($_POST["information"]) == "") {
        return false;
    }

    if (!isset($_POST["places"]) || !is_numeric($_POST["places"]) || (int)$_POST["places"] <= 0) {
        return false;
    }

    $title = trim($_POST["title"]);
    $date = $_POST["date"];
    $category = isset($_POST["category"]) ? $_POST["category"] : "concert";
    $information = trim($_POST["information"]);
    $places = (int)$_POST["places"];
    $image = isset($_POST["image"]) && $_POST["image"] != "" ? $_POST["image"] : null;
    $is_validated = 0;

    $query = $dbh->prepare("INSERT INTO event (title, date, category, information, places, image, is_validated) VALUES (:title, :date, :category, :information, :places, :image, :is_validated)");
    return $query->execute([
        "title" => $title,
        "date" => $date,
        "category" => $category,
        "information" => $information,
        "places" => $places,
        "image" => $image,
        "is_validated" => $is_validated
    ]);
}

if (isset($_POST["create-event"])) {
    $res = create_event($dbh);
    if (!$res) {
        echo "<div class='flash flash-error'>Erreur: titre, date, information obligatoires ; date non passée ; places > 0.</div>";
    } else {
        echo "<div class='flash flash-success'>Événement créé avec succès.</div>";
    }
}