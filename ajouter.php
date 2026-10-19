<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ajouter un événement · Agenda</title>
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 128 128%22><text y=%221.2em%22 font-size=%2296%22>📅</text></svg>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
	<?php include 'header.php' ?>
    <div class="narrow">
        <a class="back-link" href="index.html">← Retour aux événements</a>

        <div class="card">
            <h1>Ajouter un événement</h1>
            <p class="muted">Votre événement sera visible après validation par un administrateur.</p>

            <!-- Exemple de message d'erreur :
            <div class="flash flash-error">Le titre est obligatoire.</div>
            -->

            <form class="form" method="post" enctype="multipart/form-data">
                <div>
                    <label for="title" class="required">Titre</label>
                    <input type="text" id="title" name="title" placeholder="Ex. : Soirée jazz au Kiosque" required>
                </div>

                <div>
                    <label for="date" class="required">Date</label>
                    <input type="datetime-local" id="date" name="date" required>
                </div>

                <div>
                    <label for="information" class="required">Informations</label>
                    <textarea id="information" name="information" placeholder="Lieu, programme, tarif..." required></textarea>
                </div>

                <div>
                    <label for="category">Catégorie</label>
                    <select id="category" name="category">
                        <option value="concert">Concert</option>
                        <option value="conference">Conférence</option>
                        <option value="atelier">Atelier</option>
                        <option value="sport">Sport</option>
                    </select>
                </div>

                <div>
                    <label for="places">Nombre de places</label>
                    <input type="number" id="places" name="places" min="1" value="20">
                </div>

                <div>
                    <label for="image">Image à la une</label>
                    <input type="file" id="image" name="image" accept="image/*">
                    <div class="help-text">JPG, PNG ou WebP.</div>
                </div>

                <button type="submit" name="create-event">Enregistrer l'événement</button>
            </form>
        </div>
    </div>

	<?php include 'footer.php' ?>
</body>
</html>
