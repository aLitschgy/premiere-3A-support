<?php

class FileValidator
{
    // Taille maximale en octets (20 MB pour rester en dessous de la limite de 25 MB de la plupart des serveurs mail)
    private $maxTotalSize = 20971520; // 20 MB
    private $maxFileSize = 10485760;  // 10 MB par fichier

    public function validateFiles($files)
    {
        $attachments = [];
        $totalSize = 0;

        // Vérifier si des fichiers ont été uploadés
        if (!isset($files['name']) || empty($files['name'][0])) {
            return $attachments;
        }

        // Parcourir tous les fichiers
        $fileCount = count($files['name']);
        
        for ($i = 0; $i < $fileCount; $i++) {
            // Ignorer les fichiers vides
            if ($files['error'][$i] === UPLOAD_ERR_NO_FILE) {
                continue;
            }

            // Vérifier les erreurs d'upload
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                throw new Exception($this->getUploadErrorMessage($files['error'][$i]));
            }

            $fileSize = $files['size'][$i];
            
            // Vérifier la taille individuelle
            if ($fileSize > $this->maxFileSize) {
                throw new Exception("Le fichier '{$files['name'][$i]}' est trop volumineux (max: 10 MB par fichier).");
            }

            // Vérifier la taille totale
            $totalSize += $fileSize;
            if ($totalSize > $this->maxTotalSize) {
                throw new Exception("La taille totale des fichiers dépasse la limite autorisée de 20 MB.");
            }

            // Ajouter le fichier à la liste
            $attachments[] = [
                'name' => $files['name'][$i],
                'type' => $files['type'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'size' => $fileSize
            ];
        }

        return $attachments;
    }

    private function getUploadErrorMessage($errorCode)
    {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return "Le fichier uploadé est trop volumineux.";
            case UPLOAD_ERR_PARTIAL:
                return "Le fichier n'a été que partiellement uploadé.";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Erreur serveur: dossier temporaire manquant.";
            case UPLOAD_ERR_CANT_WRITE:
                return "Erreur serveur: impossible d'écrire le fichier sur le disque.";
            case UPLOAD_ERR_EXTENSION:
                return "Une extension PHP a bloqué l'upload du fichier.";
            default:
                return "Erreur inconnue lors de l'upload du fichier.";
        }
    }
}
