# MasterFinora

MasterFinora - Plateforme de Gestion de Budget
MasterFinora est une application web développée en PHP pour gérer les budgets personnels, permettant aux utilisateurs d'ajouter des moyens de paiement, de suivre leurs dépenses, et de recevoir des alertes de faible solde. L'architecture est inspirée des principes de Clean Architecture et Domain-Driven Design (DDD), adaptée de C# à PHP, avec une base de données PostgreSQL et un déploiement via Docker.
Table des Matières

Architecture du Projet
Prérequis
Installation
Configuration
Lancement de l'Application
Structure du Code
Fonctionnalités Principales
Tests
Déploiement
Contribuer

Architecture du Projet
L'application suit une architecture modulaire pour assurer la maintenabilité et la testabilité :

public/ : Contient les fichiers statiques (CSS, JS compilé depuis TypeScript) et index.php comme point d'entrée pour le routage.
App/ :
Api/Controllers/ : Gère les requêtes HTTP (RESTful) via des contrôleurs (ex. : AuthController.php).
Core/ :
Entities/ : Objets métier (ex. : User.php, PaymentMethod.php).
Interfaces/ : Contrats pour les services (ex. : UserServiceInterface.php).
DTOs/ : Objets de transfert de données pour les entrées/sorties.
Mappings/ : Conversion entre entités et DTOs.
Validators/ : Validation des données (ex. : UserValidator.php).
Services/ : Logique métier (ex. : gestion des utilisateurs, dépenses).


Infrastructure/ :
Persistence/ : Accès à la base de données via PDO et repositories.
Services/ : Services externes comme l'envoi d'emails (EmailService.php) et le chiffrement.




Views/ : Pages PHP pour le rendu côté serveur (ex. : dashboard.php).
docker/ : Fichiers Docker pour PHP, PostgreSQL, et Nginx.

Prérequis

PHP 8.2+ : Assurez-vous que PHP est installé (php -v).
Composer : Gestionnaire de dépendances PHP.curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer


Docker Desktop : Pour exécuter l'application dans des conteneurs.
Node.js : Pour compiler TypeScript (npm install -g typescript).
PostgreSQL Client (optionnel) : pgAdmin ou l'extension VS Code PostgreSQL pour interagir avec la base de données.

Installation

Clonez le dépôt :
git clone [<url-du-dépôt>](https://github.com/Amadou-Mendouga/MasterFinora.git)
cd MasterFinora


Installez les dépendances PHP :
composer install


Compilez TypeScript :
npx tsc public/assets/js/app.ts --outDir public/assets/js


Configurez le fichier .env :

Copiez .env.example vers .env :cp .env.example .env


Mettez à jour .env avec :
Les informations de connexion à la base de données (DB_*).
Une clé de chiffrement AES-256 générée avec :openssl rand -base64 32


Les paramètres SMTP pour Gmail (voir ci-dessous).
Une clé JWT générée avec :openssl rand -base64 32






Configurez SMTP pour Gmail :

Activez la vérification en deux étapes dans votre compte Google : https://myaccount.google.com/security.
Générez un mot de passe d'application :
Allez dans Sécurité > Mots de passe d'application.
Sélectionnez Courrier et Autre (nom personnalisé), par exemple SMTP Budget App.
Copiez le mot de passe de 16 caractères et mettez à jour SMTP_PASSWORD dans .env.





Configuration

Base de données : Le script docker/postgres/init.sql crée les tables Users, PaymentMethods, Expenses, et Alerts, avec des triggers pour le chiffrement et la gestion des soldes.
Docker :
docker/php/Dockerfile : Configure PHP 8.2 avec pdo_pgsql et Composer.
docker/postgres/Dockerfile : Configure PostgreSQL 15 avec pgcrypto.
docker/nginx/default.conf : Configure Nginx pour servir l'application.
docker-compose.yml : Orchestre les services PHP, PostgreSQL, et Nginx.



Lancement de l'Application

Lancez Docker :
docker-compose up -d


Vérifiez la base de données :
docker exec -it masterfinora-postgres-1 psql -U emyr -d budget_app -c "SELECT * FROM pg_extension WHERE extname = 'pgcrypto';"


Accédez à l'application :

URL : http://localhost
Testez les endpoints API avec Postman (ex. : POST http://localhost/api/auth/login).



Structure du Code

Routage : public/index.php parse les requêtes HTTP et appelle les contrôleurs.
Authentification :
Utilise JWT pour les sessions sécurisées (firebase/php-jwt).
MFA via email avec PHPMailer.


Base de données :
PostgreSQL avec pgcrypto pour chiffrer les numéros de carte.
Triggers pour mettre à jour les soldes et générer des alertes de faible solde.


Frontend :
Pages PHP dans Views/ pour le rendu côté serveur.
TypeScript dans public/assets/js/app.ts pour les interactions dynamiques (ex. : jauges de solde).



Fonctionnalités Principales

Authentification : Connexion avec MFA (code envoyé par email).
Gestion des moyens de paiement : Ajout, suppression, et suivi des soldes.
Dépenses : Enregistrement des dépenses avec mise à jour automatique des soldes.
Alertes : Notifications par email lorsque le solde est inférieur à 10% de la limite.
Tableau de bord : Affichage des jauges de solde en CSS/JS.

Tests

API : Utilisez Postman pour tester les endpoints (/api/auth/login, /api/payment-methods).
Base de données : Vérifiez les tables et triggers avec pgAdmin.
Emails : Testez l'envoi des codes MFA et des alertes de faible solde.
Frontend : Vérifiez les jauges dans le navigateur.

Déploiement

Hébergement : Utilisez un cloud comme AWS, Heroku, ou DigitalOcean.
Sécurité :
Configurez HTTPS avec Let's Encrypt.
Excluez .env du contrôle de version (echo ".env" >> .gitignore).


CI/CD : Configurez GitHub Actions pour automatiser les déploiements.

Contribuer

Conventions de code : Suivez PSR-12 pour PHP et utilisez Prettier pour TypeScript/CSS.
Tests unitaires : Ajoutez des tests avec PHPUnit dans tests/.
Issues : Signalez les bugs ou proposez des améliorations via Git.

Pour toute question, contactez [votre nom] à [votre email].
