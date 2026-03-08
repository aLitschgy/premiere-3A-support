<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Technique - Ticket</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" type='text/css' href="https://cdn.jsdelivr.net/gh/devicons/devicon@latest/devicon.min.css" />
</head>

<body>
    <div class="container">
        <header>
            <div>
                <h1>Support 3A</h1>
                <p>Créer un nouveau ticket</p>
            </div>
            <img src="assets/images/logoTVn7.png" alt="Logo TVn7" class="logo">
        </header>

        <main>
            <form id="ticketForm" action="submit.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Votre nom *</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="software">Logiciel *</label>
                    <select id="software" name="software" required>
                        <option value="">Sélectionnez un logiciel</option>
                        <option value="Premiere">
                            Premiere
                        </option>
                        <option value="After Effect">
                            After Effect
                        </option>
                        <option value="Media Encoder">
                            Media Encoder
                        </option>
                        <option value="other">
                            Autre (préciser en description)
                        </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description du problème *</label>
                    <textarea id="description" name="description" rows="6" required></textarea>
                </div>

                <div class="form-group">
                    <label for="attachments">Pièces jointes</label>
                    <input type="file" id="attachments" name="attachments[]" multiple>
                    <small>Taille maximale totale : 20 MB</small>
                </div>

                <button type="submit" class="btn-submit">Envoyer le ticket</button>
            </form>
        </main>
    </div>
    <footer>
        <p>&copy; 2026 - 3A+ TVn7 - Tous droits réservés.</p>
    </footer>

    <div id="notification" class="notification"></div>

    <script src="assets/js/app.js"></script>
</body>

</html>