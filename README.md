# Support Technique - Système de Tickets

Application web simple pour soumettre des tickets de support technique par email.

## 📋 Fonctionnalités

- Formulaire de soumission de tickets avec les champs :
  - Nom (obligatoire)
  - Logiciel : Premiere, After Effect, Media Encoder (obligatoire)
  - Description du problème (obligatoire)
  - Pièces jointes multiples (optionnel)
- Envoi automatique par email via SMTP
- Validation de la taille des fichiers (max 20 MB au total)
- Interface sombre et responsive (mobile + bureau)
- Notifications d'erreur/succès (disparaissent après 10s)

## 🗂️ Structure du projet

```
premiere-3A-support/
├── public/              # Fichiers accessibles publiquement
│   ├── index.php        # Page du formulaire
│   ├── submit.php       # Traitement du formulaire
│   └── get_message.php  # API pour récupérer les messages de session
├── src/                 # Code source PHP
│   ├── MailService.php  # Service d'envoi d'emails
│   └── FileValidator.php # Validation des fichiers
├── config/              # Configuration
│   └── config.php       # Chargement de la configuration
├── assets/              # Ressources statiques
│   ├── css/
│   │   └── style.css    # Styles (thème sombre)
│   └── js/
│       └── app.js       # JavaScript (notifications, validation)
├── .env.example         # Exemple de configuration
└── .gitignore
```

## ⚙️ Installation

### 1. Copier le fichier de configuration

```bash
cp .env.example .env
```

### 2. Configurer les paramètres SMTP

Éditez le fichier `.env` avec vos paramètres SMTP :

```env
SMTP_HOST=smtp.votredomaine.com
SMTP_PORT=587
SMTP_FROM_EMAIL=support@votredomaine.com
SMTP_FROM_NAME=Support Technique
SMTP_TO_EMAIL=admin@votredomaine.com
```

### 3. Configurer PHP (optionnel)

Assurez-vous que votre `php.ini` permet l'upload de fichiers :

```ini
file_uploads = On
upload_max_filesize = 25M
post_max_size = 25M
```

### 4. Démarrer le serveur

Pour tester en local avec PHP 7.3 :

```bash
cd public
php -S localhost:8000
```

Puis accédez à `http://localhost:8000`

## 🌐 Déploiement en production

1. Configurez votre serveur web (Apache/Nginx) pour pointer vers le dossier `public/`
2. Assurez-vous que le fichier `.env` n'est pas accessible publiquement
3. Configurez les permissions appropriées sur les dossiers

### Exemple de configuration Apache

```apache
<VirtualHost *:80>
    ServerName support.votredomaine.com
    DocumentRoot /var/www/premiere-3A-support/public

    <Directory /var/www/premiere-3A-support/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## 📝 Utilisation

1. Accédez à la page d'accueil
2. Remplissez le formulaire :
   - Entrez votre nom
   - Sélectionnez le logiciel concerné
   - Décrivez votre problème
   - (Optionnel) Ajoutez des pièces jointes
3. Cliquez sur "Envoyer le ticket"
4. Une notification confirmera l'envoi ou affichera les erreurs

## 🔒 Sécurité

- Tous les champs sont validés côté serveur
- Protection XSS avec `htmlspecialchars()`
- Validation de la taille des fichiers
- Fichier `.env` exclu du contrôle de version
- Sessions PHP pour les messages flash

## 📱 Responsive Design

L'interface s'adapte automatiquement aux différentes tailles d'écran :

- Desktop : formulaire centré, largeur maximale 700px
- Mobile : adaptation complète de la mise en page
- Notifications adaptées à la taille de l'écran

## 🐛 Dépannage

### Les emails ne sont pas envoyés

1. Vérifiez les paramètres SMTP dans `.env`
2. Vérifiez les logs PHP pour les erreurs
3. Testez votre configuration SMTP avec un autre outil
4. Envisagez d'utiliser PHPMailer pour une meilleure compatibilité

### Les fichiers ne s'uploadent pas

1. Vérifiez les paramètres `upload_max_filesize` et `post_max_size` dans `php.ini`
2. Assurez-vous que le dossier temporaire PHP est accessible
3. Vérifiez les permissions du dossier

## 📄 Licence

Ce projet est fourni tel quel sans garantie.

## 👤 Auteur

Antonin Litschgy (+ Claude Sonnet à 99%)
