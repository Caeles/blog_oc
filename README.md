# Blog de Céline PIPER

## Description
Ce projet est un site de présentation professionnel développé en PHP avec une architecture MVC. Il contient un blog qui permet de gérer des articles avec un système d'administration complet.

## Prérequis
- PHP 8.0 ou supérieur
- MySQL 5.7 ou supérieur
- Serveur web
- Composer 
- XAMPP 

## Installation


### 1. Cloner le dépôt
```bash
git clone https://github.com/Caeles/blog_oc.git

```

### 2. Configurer la base de données
1. Démarrez les services Apache et MySQL depuis le panneau de contrôle XAMPP
2. Accédez à phpMyAdmin à l'adresse http://localhost/phpmyadmin
3. Créez une nouvelle base de données nommée `blog`
4. Importez le fichier SQL `bdd.sql` présent à la racine du projet


### 3. Démarrer l'application
1. Accédez à l'application via http://localhost/
2. Pour accéder à l'administration, utilisez http://localhost/login

## Structure du projet
- `/public`: Point d'entrée de l'application et assets publics
- `/src`: Code source PHP 
- `/views`: Templates PHP
- `bdd.sql`: Fichier SQL pour l'initialisation de la base de données

## Fonctionnalités
- Gestion des articles 
- Système de commentaires avec modération
- Interface d'administration sécurisée

## Accès à l'administration
Utilisez les identifiants suivants pour accéder à l'administration:
- Email: admin@example.com
- Mot de passe: admin

## Licence
Ce projet est distribué sous licence privée et ne peut être utilisé sans autorisation expresse de l'auteur.