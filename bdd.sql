-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 30 mai 2025 à 16:04
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `blog`
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;
USE `blog`;

-- --------------------------------------------------------
-- Table `role`
-- --------------------------------------------------------
CREATE TABLE role (
    id    INT AUTO_INCREMENT PRIMARY KEY,
    value VARCHAR(50)    NOT NULL UNIQUE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

INSERT INTO role (id, value) VALUES
    (1, 'Admin'),
    (2, 'Visiteur');

ALTER TABLE role AUTO_INCREMENT = 3;

-- --------------------------------------------------------
-- Table `status`
-- --------------------------------------------------------
CREATE TABLE status (
    id    INT AUTO_INCREMENT PRIMARY KEY,
    value VARCHAR(50)    NOT NULL UNIQUE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

INSERT INTO status (id, value) VALUES
    (1, 'Actif'),
    (2, 'Inactif');

ALTER TABLE status AUTO_INCREMENT = 3;

-- --------------------------------------------------------
-- Table `comment_status`
-- --------------------------------------------------------
CREATE TABLE comment_status (
    id    INT AUTO_INCREMENT PRIMARY KEY,
    value VARCHAR(50)    NOT NULL UNIQUE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

INSERT INTO comment_status (id, value) VALUES
    (1, 'published'),
    (2, 'Pending review'),
    (3, 'rejected'),
    (5, 'approved');

ALTER TABLE comment_status AUTO_INCREMENT = 6;

-- --------------------------------------------------------
-- Table `user`
-- --------------------------------------------------------
CREATE TABLE user (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    nom           VARCHAR(100) NOT NULL,
    prenom        VARCHAR(100) NOT NULL,
    email         VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe  VARCHAR(255) NOT NULL,
    telephone     VARCHAR(30),
    role_id       INT NOT NULL,
    status_id     INT NOT NULL,
    CONSTRAINT fk_user_role
        FOREIGN KEY (role_id)  REFERENCES role(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_user_status
        FOREIGN KEY (status_id) REFERENCES status(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

INSERT INTO user (id, nom, prenom, email, mot_de_passe, telephone, role_id, status_id) VALUES
    (2, 'Martin',  'Claire', 'claire.martin@example.com', '$2y$12$TsVOvAh4MZbhNoUGYBqe9.Dp0Kr60AXucJzqmDQw1fOXo2j7S6BmG', '0623456789', 2, 1),
    (3, 'Bernard', 'Lucas',  'lucas.bernard@example.com', '$2y$12$wdGr4lmmJ.pGIumvku.gxeQRaddwYxTwc0.VSDBWsJ/xBLHeVj/ou', '0634567890', 2, 1),
    (4, 'Petit',   'Sophie', 'sophie.petit@example.com', '$2y$12$.wBwKa.Ewuu8NIFPCeNniuZiP0STHdS.KRug9AEWI22hox7a2vpye', '0645678901', 2, 2),
    (5, 'Moreau',  'Julien', 'julien.moreau@example.com', '$2y$12$kSMR9t526IRTjxNpZjPS7.7SK.wxHFchbWeC8T6I8gOa3OFP12HYe', '0656789012', 1, 1),
    (6, 'Roux',    'Emma',   'emma.roux@example.com',   '$2y$12$tsQYo.bOMrOYx9DZ309khOsYajzTTREngFikHwaIqzNPnJzwi8daW', '0667890123', 2, 1),
    (7, 'David',   'Thomas', 'thomas.david@example.com', '$2y$12$Yp0EWbDgzKaOcE4TRpVTIOxKJg.57Ecfo93xGgTcz2G5OJ5HujbP2', '0678901234', 1, 1),
    (8, 'Leroy',   'Laura',  'laura.leroy@example.com', '$2y$12$yNjp/8HwD0NpOlrbTL1tEeMXMxj2Iw0hZQDSmCvejYOoXmJDSG/xW', '0689012345', 2, 2),
    (9, 'Simon',   'Nicolas','nicolas.simon@example.com','$2y$12$MAgQ6POgq7tWJFkCQ1tOhuv.WfRlS7wvUacQrDv5h/Voa.M1iP1Z6', '0690123456', 1, 1),
    (10,'Michel',  'Julie',  'julie.michel@example.com', '$2y$12$w5Ee/PGwHWl6qwTqqzin8e9fA4xf/dZsc5/xWe.GeIqZzxKVMceKq', '0601234567', 2, 1),
    (11,'Admin',   'User',   'admin@example.com',        '$2y$12$VtwZvhOy34vkx/CJaGQdHOdoivN9ubA09TrEf/ztAKUZeb87nu3DC', NULL,         1, 1);

ALTER TABLE user AUTO_INCREMENT = 12;

-- --------------------------------------------------------
-- Table `category`
-- --------------------------------------------------------
CREATE TABLE category (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    name        VARCHAR(100) NOT NULL UNIQUE,
    slug        VARCHAR(120) NOT NULL UNIQUE,
    description VARCHAR(255),
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

INSERT INTO category (id, name, slug, description, created_at) VALUES
    (1, 'Intelligence Artificielle', 'intelligence-artificielle', 'Articles sur l\'IA, apprentissage automatique et deep learning', '2025-05-11 10:04:09'),
    (2, 'Blockchain',               'blockchain',               'Sujets autour de la blockchain, des cryptomonnaies et de la décentralisation.', '2025-05-11 10:04:09'),
    (3, 'Développement Web',        'developpement-web',        'Articles sur HTML, CSS, JS.', '2025-05-11 10:04:09'),
    (4, 'Développement Mobile',     'developpement-mobile',     'Articles sur les applications mobiles et leurs optimisations.', '2025-05-11 10:04:09');

ALTER TABLE category AUTO_INCREMENT = 11;

-- --------------------------------------------------------
-- Table `article`
-- --------------------------------------------------------
CREATE TABLE article (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    author_id   INT NOT NULL,
    title       VARCHAR(255) NOT NULL,
    chapo       VARCHAR(512),
    image       VARCHAR(255),
    description TEXT,
    created_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_article_author
        FOREIGN KEY (author_id) REFERENCES user(id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

INSERT INTO article (id, author_id, title, chapo, image, description, created_at, updated_at) VALUES
    (2, 2, 'Les enjeux moraux de l’intelligence artificielle : un défi pour notre époque', 'IA et éthique', 'ia2.jpg', 'L’intelligence artificielle (IA) s’impose dans tous les domaines…', '2025-05-02 09:30:00', '2025-05-29 22:13:40'),
    (3, 3, 'Blockchain et finance : un rempart contre la fraude ?', 'Sécuriser et décentraliser les paiements', 'blockchain1.jpg', 'La fraude financière représente un enjeu majeur…', '2025-05-03 10:00:00', '2025-05-29 22:14:33'),
    (4, 4, 'Automatisation par la blockchain : quand les smart contracts réinventent les workflows', 'Automatisation via blockchain', 'blockchain2.jpg', 'Avec l’émergence de la blockchain…', '2025-05-04 11:15:00', '2025-05-30 00:04:51'),
    (5, 5, 'React, Vue, Angular : quel framework choisir en 2025 ?', 'Tour d’horizon des frameworks', 'web1.jpg', 'Le développement web moderne repose largement…', '2025-05-05 14:20:00', '2025-05-30 00:09:17'),
    (6, 6, 'REST ou GraphQL : quelle API pour quel besoin ?', 'Choisir le bon style d’API', 'web2.jpg', 'Les API sont au cœur des applications modernes…', '2025-05-06 15:45:00', '2025-05-30 00:09:03'),
    (7, 7, 'Flutter, React Native, Tamarin : quel outil pour le développement cross-platform ?', 'Flutter, React Native, Xamarin', 'mobile1.jpg', 'Développer une application mobile…', '2025-05-07 16:30:00', '2025-05-30 00:08:01'),
    (8, 8, 'Optimisation mobile', 'Performance et économie de batterie', 'mobile2.jpg', 'Techniques de profilage, mise en cache et bonnes pratiques…', '2025-05-08 17:50:00', '2025-05-08 17:50:00'),
    (11,2, 'Prompt Engineering avancé pour les LLM : l\'art de parler aux modèles', 'Techniques pour faire parler ChatGPT…', 'ai-prompt-engineering.svg', 'Les grands modèles de langage (LLM) comme ChatGPT…', '2025-05-14 10:25:35','2025-05-30 00:13:49'),
    (12,3, 'React Server Components : tutoriel pas à pas', 'Réduisez le JavaScript envoyé au client…', 'web-react-server-components.png','React Server Components change la donne…','2025-05-14 10:25:35','2025-05-30 00:15:46'),
    (13,3, 'Bun vs Node.js : le match des runtimes JavaScript', 'Le nouveau runtime JavaScript vaut-il le détour ?', 'web-bun-node-benchmarks.jpg', 'Bun est un nouveau venu…','2025-05-14 10:25:35','2025-05-30 00:14:24'),
    (14,4, 'CSS Subgrid : la révolution du layout est enfin là', 'Organisez vos mises en page complexes sans hacks.', 'web-css-subgrid-demo.gif','Après des années d’attente…','2025-05-14 10:25:35','2025-05-30 00:14:59'),
    (15,5, 'Jetpack Compose : 10 patterns pour un UI réactif', 'Exploitez StateFlow, remember et snapshotFlow comme un pro.', 'mobile-jetpack-compose-ui.png','Jetpack Compose révolutionne l’UI Android…','2025-05-14 10:25:35','2025-05-30 00:16:02'),
    (16,5, 'SwiftData 1.2 : remplacer Core Data en douceur', 'Apple simplifie enfin la persistance locale sur iOS 18.', 'mobile-swiftdata-coredata.jpg','SwiftData, successeur promu de Core Data…','2025-05-14 10:25:35','2025-05-15 12:23:52'),
    (17,6, 'Flutter 3.22 et le moteur Impeller : un bond de performance graphique', 'Performances rendues 30 % plus rapides sur iOS et Android.', 'mobile-flutter-impeller.png','Avec la version 3.22…','2025-05-14 10:25:35','2025-05-30 00:12:54'),
    (18,7, 'Ethereum Pectra Upgrade : ce qui change pour les développeurs', 'Le prochain hard fork apporte de nouvelles pré-compiles et réduit les frais.', 'blockchain-ethereum-pectra.jpg','Le hard fork Pectra d’Ethereum…','2025-05-14 10:25:35','2025-05-30 00:12:17'),
    (19,7, 'ERC-4337 : vers des wallets Web3 avec l’UX du Web2', 'Vers des wallets sans seed phrase et des UX dignes du web2.', 'blockchain-erc4337.png','L’ERC-4337, ou account abstraction…','2025-05-14 10:25:35','2025-05-30 00:11:32'),
    (20,8, 'Solana Firedancer : l’ère du client haute performance', 'Un client, en Rust et C, capable de 1 M transactions/s.', 'blockchain-solana-firedancer.gif','Firedancer marque une nouvelle étape…','2025-05-14 10:25:35','2025-05-30 00:10:42');

ALTER TABLE article AUTOINCREMENT = 21;
CREATE INDEX idx_article_created ON article(created_at);

-- --------------------------------------------------------
-- Table `comment`
-- --------------------------------------------------------
CREATE TABLE comment (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    nom        VARCHAR(100) NOT NULL DEFAULT 'Anonyme',
    article_id INT NOT NULL,
    status_id  INT NOT NULL,
    contenu    TEXT    NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_comment_user
        FOREIGN KEY (user_id)    REFERENCES user(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_comment_article
        FOREIGN KEY (article_id) REFERENCES article(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_comment_status
        FOREIGN KEY (status_id)  REFERENCES comment_status(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

INSERT INTO comment (id, user_id, nom, article_id, status_id, contenu, created_at) VALUES
    (3, 4, 'Marc',    2, 1, 'Super article sur l’éthique.',          '2025-05-02 10:00:00'),
    (4, 5, 'Laurie',  2, 1, 'Je ne suis pas d’accord',                 '2025-05-02 10:30:00'),
    (5, 6, 'Laurence',3, 1, 'Intéressant pour la finance',             '2025-05-03 11:00:00'),
    (6, 7, 'Maxime',  4, 1, 'Les smart contracts, top !',              '2025-05-04 12:00:00'),
    (7, 8, 'Anthony', 5, 1, 'Merci pour le comparatif Web',            '2025-05-05 15:00:00'),
    (8, 9, 'Vulcain', 6, 1, 'Pending review please',                   '2025-05-06 16:00:00'),
    (9,10, 'Ryann',   7, 1, 'J’adore Flutter !',                       '2025-05-07 17:00:00'),
    (11,2, 'Liana',   8, 1, 'Utile pour optimiser ma PWA',            '2025-05-08 18:00:00'),
    (15,11,'Karl',   12, 1, 'Je valide fort!',                        '2025-05-29 10:55:21'),
    (16,11,'Rosalie',12, 1, 'C''est une très bonne nouvelle!',         '2025-05-29 11:04:26');

ALTER TABLE comment AUTO_INCREMENT = 17;
CREATE INDEX idx_comment_created ON comment(created_at);

-- --------------------------------------------------------
-- Table `article_category`
-- --------------------------------------------------------
CREATE TABLE article_category (
    article_id  INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (article_id, category_id),
    CONSTRAINT fk_ac_article
        FOREIGN KEY (article_id)  REFERENCES article(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_ac_category
        FOREIGN KEY (category_id) REFERENCES category(id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB
  DEFAULT CHARSET=utf8mb4
  COLLATE=utf8mb4_general_ci;

INSERT INTO article_category (article_id, category_id) VALUES
    (2, 1),
    (3, 2),
    (4, 2),
    (5, 3),
    (6, 3),
    (7, 4),
    (8, 4),
    (18,2);

COMMIT;
