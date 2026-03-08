<?php
require_once __DIR__ . '/src/MailService.php';
require_once __DIR__ . '/src/FileValidator.php';

session_start();

// Redirection si accès direct sans POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /');
    exit;
}

try {
    // Validation des champs obligatoires
    if (empty($_POST['name']) || empty($_POST['software']) || empty($_POST['description'])) {
        throw new Exception('Tous les champs obligatoires doivent être remplis.');
    }

    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $software = htmlspecialchars($_POST['software'], ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES, 'UTF-8');

    // Validation du logiciel
    $allowedSoftware = ['Premiere', 'After Effect', 'Media Encoder', 'other'];
    if (!in_array($software, $allowedSoftware)) {
        throw new Exception('Logiciel non valide.');
    }

    // Validation des fichiers attachés
    $attachments = [];
    if (isset($_FILES['attachments']) && !empty($_FILES['attachments']['name'][0])) {
        $fileValidator = new FileValidator();
        $attachments = $fileValidator->validateFiles($_FILES['attachments']);
    }

    // Envoi de l'email
    $mailService = new MailService();
    $mailService->sendTicket($name, $software, $description, $attachments);

    // Redirection avec succès
    $_SESSION['success'] = 'Votre ticket a été envoyé avec succès.';
    header('Location: /?success=1');
    exit;
} catch (Exception $e) {
    // Redirection avec erreur
    $_SESSION['error'] = $e->getMessage();
    header('Location: /?error=1');
    exit;
}
