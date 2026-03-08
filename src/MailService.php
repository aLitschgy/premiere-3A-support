<?php
require_once __DIR__ . '/../config/config.php';

class MailService
{
    private $config;

    public function __construct()
    {
        $this->config = getConfig();
    }

    public function sendTicket($name, $software, $description, $attachments = [])
    {
        // Préparer le message
        $to = $this->config['SMTP_TO_EMAIL'];
        $subject = "[Ticket] {$software} - {$name}";
        
        $message = "Nouveau ticket de support\n\n";
        $message .= "Nom: {$name}\n";
        $message .= "Logiciel: {$software}\n\n";
        $message .= "Description du problème:\n";
        $message .= "{$description}\n";

        // Headers pour email SMTP
        $headers = [];
        $headers[] = "From: {$this->config['SMTP_FROM_NAME']} <{$this->config['SMTP_FROM_EMAIL']}>";
        $headers[] = "Reply-To: {$this->config['SMTP_FROM_EMAIL']}";
        $headers[] = "X-Mailer: PHP/" . phpversion();
        
        // Si des pièces jointes sont présentes
        if (!empty($attachments)) {
            $boundary = md5(time());
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-Type: multipart/mixed; boundary=\"{$boundary}\"";
            
            $body = "--{$boundary}\n";
            $body .= "Content-Type: text/plain; charset=UTF-8\n";
            $body .= "Content-Transfer-Encoding: 7bit\n\n";
            $body .= $message . "\n\n";
            
            // Ajouter les pièces jointes
            foreach ($attachments as $attachment) {
                $content = chunk_split(base64_encode(file_get_contents($attachment['tmp_name'])));
                $body .= "--{$boundary}\n";
                $body .= "Content-Type: {$attachment['type']}; name=\"{$attachment['name']}\"\n";
                $body .= "Content-Transfer-Encoding: base64\n";
                $body .= "Content-Disposition: attachment; filename=\"{$attachment['name']}\"\n\n";
                $body .= $content . "\n";
            }
            
            $body .= "--{$boundary}--";
            $message = $body;
        } else {
            $headers[] = "Content-Type: text/plain; charset=UTF-8";
        }

        // Configurer les paramètres SMTP via ini_set
        ini_set('SMTP', $this->config['SMTP_HOST']);
        ini_set('smtp_port', $this->config['SMTP_PORT']);
        
        // Envoi de l'email
        $result = mail($to, $subject, $message, implode("\r\n", $headers));
        
        if (!$result) {
            throw new Exception("Erreur lors de l'envoi de l'email. Veuillez réessayer plus tard.");
        }
        
        return true;
    }
}
