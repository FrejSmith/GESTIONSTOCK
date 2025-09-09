
# GestionStock

Application web de gestion de stock développée avec le framework **Symfony** et **MySQL**.

## Fonctionnalités principales

- Gestion du catalogue produits
- Suivi des mouvements de stock (entrées, sorties)
- Gestion des utilisateurs et des droits d’accès
- Tableaux de bord et statistiques
- Authentification sécurisée

## Installation

1. **Cloner le projet :**
   ```bash
   git clone https://github.com/ton-utilisateur/gestionstock.git
   cd gestionstock
   ```

2. **Installer les dépendances PHP :**
   ```bash
   composer install
   ```

3. **Configurer la base de données :**
   - Modifier la variable `DATABASE_URL` dans le fichier `.env`
     ```
     DATABASE_URL="mysql://root:root@127.0.0.1:3306/gestionstock?serverVersion=8.0&charset=utf8mb4"
     ```

4. **Créer la base de données :**
   ```bash
   php bin/console doctrine:database:create
   ```

5. **Lancer les migrations (création des tables) :**
   ```bash
   php bin/console doctrine:migrations:migrate
   ```

6. **(Facultatif) Charger les données de démo (si disponibles) :**
   ```bash
   php bin/console doctrine:fixtures:load
   ```

7. **Démarrer le serveur de développement :**
   ```bash
   symfony server:start
   ```
   ou
   ```bash
   php -S 127.0.0.1:8000 -t public
   ```

## Utilisation

Accède à l’application via :  
`http://127.0.0.1:8000`

- Connecte-toi avec un compte existant ou enregistre-toi.
- Ajoute/modifie des produits.
- Suis le stock en temps réel.

## Technologies utilisées

- PHP / Symfony
- MySQL
- Doctrine ORM
- Twig (templates)
- HTML, CSS, JS (frontend)
- [Optionnel] Bootstrap ou TailwindCSS

## Sécurité

- Protection CSRF sur tous les formulaires
- Authentification et gestion des rôles utilisateurs
- Validation des données en backend

## Auteur

Développé par [GBOTOUNOU FREJUS SMITH].  
Projet individuel réalisé de A à Z.


