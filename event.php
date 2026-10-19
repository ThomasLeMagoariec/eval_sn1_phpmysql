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

?>
