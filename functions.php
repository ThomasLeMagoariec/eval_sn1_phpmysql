<?php
require_once 'config.php';

function isLoggedIn(): bool {
    return isset($_SESSION["email"]);
}

function isAdmin(): bool {
    return isLoggedIn() && $_SESSION["role"] === 'admin';
}

function requireAdmin(): void {
    if (!isAdmin()) {
        header("Location: index.php");
        exit;
    }
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header("Location: connexion.php");
        exit;
    }
}

function getPendingEvents(PDO $dbh): array {
    $query = $dbh->prepare("
        SELECT id, title, date, category, places, information, image
        FROM event
        WHERE is_validated = 0
        ORDER BY date ASC
    ");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function validateEvent(PDO $dbh, int $eventId): bool {
    $stmt = $dbh->prepare("UPDATE event SET is_validated = 1 WHERE id = :id");
    return $stmt->execute(["id" => $eventId]);
}

function getValidatedEventsWithAttendees(PDO $dbh): array {
    $query = $dbh->prepare("
        SELECT e.id, e.title, e.date, e.category, e.places, e.information, e.image,
               u.email, r.created_at as reservation_date
        FROM event e
        LEFT JOIN reservation r ON r.event_id = e.id
        LEFT JOIN user u ON u.id = r.user_id
        WHERE e.is_validated = 1
        ORDER BY e.date ASC, r.created_at ASC
    ");
    $query->execute();
    $rows = $query->fetchAll(PDO::FETCH_ASSOC);

    $events = [];
    foreach ($rows as $row) {
        $id = $row['id'];
        if (!isset($events[$id])) {
            $events[$id] = [
                'id' => $row['id'],
                'title' => $row['title'],
                'date' => $row['date'],
                'category' => $row['category'],
                'places' => $row['places'],
                'information' => $row['information'],
                'image' => $row['image'],
                'attendees' => []
            ];
        }
        if ($row['email']) {
            $events[$id]['attendees'][] = [
                'email' => $row['email'],
                'reservation_date' => $row['reservation_date']
            ];
        }
    }
    return $events;
}

function getEventById(PDO $dbh, int $id): ?array {
    $query = $dbh->prepare("SELECT * FROM event WHERE id = :id");
    $query->execute(['id' => $id]);
    $event = $query->fetch(PDO::FETCH_ASSOC);
    return $event ?: null;
}

function countReservations(PDO $dbh, int $eventId): int {
    $query = $dbh->prepare("SELECT COUNT(*) FROM reservation WHERE event_id = :id");
    $query->execute(['id' => $eventId]);
    return (int)$query->fetchColumn();
}

function isUserRegistered(PDO $dbh, int $userId, int $eventId): bool {
    $query = $dbh->prepare("SELECT id FROM reservation WHERE user_id = :user_id AND event_id = :event_id");
    $query->execute(['user_id' => $userId, 'event_id' => $eventId]);
    return (bool)$query->fetch();
}

function getUserIdByEmail(PDO $dbh, string $email): ?int {
    $query = $dbh->prepare("SELECT id FROM user WHERE email = :email");
    $query->execute(['email' => $email]);
    $user = $query->fetch(PDO::FETCH_ASSOC);
    return $user ? (int)$user['id'] : null;
}

function registerUserToEvent(PDO $dbh, int $userId, int $eventId): bool {
    $query = $dbh->prepare("INSERT INTO reservation (user_id, event_id) VALUES (:user_id, :event_id)");
    return $query->execute(['user_id' => $userId, 'event_id' => $eventId]);
}

function unregisterUserFromEvent(PDO $dbh, int $userId, int $eventId): bool {
    $query = $dbh->prepare("DELETE FROM reservation WHERE user_id = :user_id AND event_id = :event_id");
    return $query->execute(['user_id' => $userId, 'event_id' => $eventId]);
}

function formatDateFr(string $date): string {
    return date('d/m/Y H\hi', strtotime($date));
}

function formatDateShortFr(string $date): string {
    return date('d/m/Y \· H\hi', strtotime($date));
}

function renderEventsWithAttendees(array $events): string {
    if (empty($events)) {
        return "<p class='empty'>Aucun événement validé pour le moment.</p>";
    }

    $html = "<div class='section-head'>
  <div>
    <h1>Réservations aux événements</h1>
    <p class='muted'>Liste des participants pour chaque événement validé.</p>
  </div>
</div>";

    foreach ($events as $event) {
        $attendeesCount = count($event['attendees']);
        $isFull = $attendeesCount >= $event['places'];

        $html .= "<section class='card attendees'>
  <div class='attendees-head'>
    <div>
      <h2><a href='evenement.php?id={$event['id']}'>" . htmlspecialchars($event['title']) . "</a></h2>
      <span class='badge cat-" . htmlspecialchars($event['category']) . "'>" . ucfirst(htmlspecialchars($event['category'])) . "</span>
      <span class='muted'>" . formatDateShortFr($event['date']) . "</span>
    </div>
    <p class='places'>";

        if ($isFull) {
            $html .= "      <span class='badge badge-full'>Complet</span> ";
        }
        $html .= "      <strong>$attendeesCount</strong> réservé" . ($attendeesCount > 1 ? 's' : '') . " sur {$event['places']} place" . ($event['places'] > 1 ? 's' : '') . "
    </p>
  </div>";

        if (empty($event['attendees'])) {
            $html .= "  <p class='empty'>Aucun inscrit pour le moment.</p>";
        } else {
            $html .= "  <div class='table-wrap'>
    <table class='table'>
      <thead>
        <tr>
          <th>Email</th>
          <th>Réservé le</th>
        </tr>
      </thead>
      <tbody>";
            foreach ($event['attendees'] as $attendee) {
                $html .= "        <tr>
          <td>" . htmlspecialchars($attendee['email']) . "</td>
          <td>" . formatDateFr($attendee['reservation_date']) . "</td>
        </tr>";
            }
            $html .= "      </tbody>
    </table>
  </div>";
        }
        $html .= "</section>";
    }

    return $html;
}
