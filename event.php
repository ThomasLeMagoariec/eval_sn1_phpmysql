<?php

function build_filter() {
	$filters = ["toutes", "concert", "conference", "atelier", "sport"];

	foreach($filters as $filter) {
		if (isset($_GET["categorie"]) && $_GET["categorie"] == $filter) {
			echo "<li><a class='active' href='index.php'>" . $filter . "</a></li>";
		} else {	
            echo "<li class='cat-" . $filter ."'><a href='index.php?categorie=" . $filter . "'>" . $filter . "</a></li>";
		}
	}

}

function get_events($dbh, $filter)  {
	if ($filter == "toutes") {
		$query = $dbh->prepare("SELECT * FROM event");
		$query->execute();
	} else {
		$query = $dbh->prepare("SELECT * FROM event WHERE category = :filter");
		$query->execute(array("filter" => $filter));
	}
	return $query->fetchAll(PDO::FETCH_ASSOC);
}


function build_events($dbh) {
	$filter = "toutes";
	if (isset($_GET["categorie"]))
		$filter = $_GET["categorie"];

	$events = get_events($dbh, $filter);

	if (count($events) == 0) {
		echo "<p class='empty'>Aucun événement à venir pour le moment.</p>";
		return ;
	}

    echo "<ul class='event-list'>";
	foreach ($events as $event)
		echo "
			<li class='event-card cat-concert'>
				<div class='event-media'>
					<div class='event-date'><span class='day'>07</span><span class='month'>nov.</span></div>
					<img class='event-image' src='". $event["image"] . "' alt=''>
					<span class='badge'>" . $event["category"] .  "</span>
				</div>
				<h3 class='event-title'><a href='evenement.php?id=" . $event["id"] ."'>" . $event["title"] . "</a></h3>
				<span class='muted'>07/11/2026 · 20h30</span>
			</li>
		";
	echo "</ul>";
}


function create_event($dbh) 
{
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
	$is_validated = 0; // "non validé" par défaut, seul un admin peut valider


	$query = $dbh->prepare("INSERT INTO event (title, date, category, information, places, image, is_validated) VALUES (:title, :date, :category, :information, :places, :image, :is_validated)");
	file_put_contents(
		"/tmp/php-dbg.log",
		date('Y-m-d H:i:s') . " REQUEST: " . print_r($query, true) . PHP_EOL,
		FILE_APPEND
	);
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
	file_put_contents(
		"/tmp/php-dbg.log",
		date('Y-m-d H:i:s') . " CREATE EVENT: " . PHP_EOL,
		FILE_APPEND
	);
	if (!$res) {
		echo "<div class='flash flash-error'>Erreur: titre, date, information obligatoires ; date non passée ; places > 0.</div>";
	} else {
		echo "<div class='flash flash-success'>Événement créé avec succès.</div>";
	}
}

?>
