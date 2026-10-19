<?php
require_once 'config.php';
require_once 'functions.php';

function renderPendingEventsTable(array $events): string {
    if (empty($events)) {
        return "<p class='empty'>Aucun événement en attente 🎉</p>";
    }

    $html = "<div class='card table-wrap'>
  <table class='table'>
    <thead>
      <tr>
        <th>Événement</th>
        <th>Date</th>
        <th>Catégorie</th>
        <th>Places</th>
        <th>Statut</th>
        <th></th>
      </tr>
    </thead>
    <tbody>";

    foreach ($events as $event) {
        $html .= "      <tr>
        <td><a href='evenement.php?id={$event['id']}'>" . htmlspecialchars($event['title']) . "</a></td>
        <td>" . formatDateFr($event['date']) . "</td>
        <td><span class='badge cat-" . htmlspecialchars($event['category']) . "'>" . ucfirst(htmlspecialchars($event['category'])) . "</span></td>
        <td>{$event['places']}</td>
        <td><span class='badge badge-pending'>Non validé</span></td>
        <td>
          <form method='post'>
            <input type='hidden' name='validate_id' value='{$event['id']}'>
            <button type='submit' class='btn btn-small btn-success'>Valider</button>
          </form>
        </td>
      </tr>";
    }

    $html .= "    </tbody>
  </table>
</div>";

    return $html;
}

function handleValidateEvent(PDO $dbh): void {
    if (isset($_POST["validate_id"])) {
        validateEvent($dbh, (int)$_POST["validate_id"]);
        header("Location: validation.php");
        exit;
    }
}
