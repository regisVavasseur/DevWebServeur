-- Adminer 4.8.1 MySQL 11.2.2-MariaDB-1:11.2.2+maria~ubu2204 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `commande`;
CREATE TABLE `commande` (
  `delai` tinyint(4) DEFAULT 0,
  `id` varchar(64) NOT NULL,
  `date_commande` datetime NOT NULL,
  `type_livraison` int(11) NOT NULL DEFAULT 1,
  `etape` int(11) NOT NULL DEFAULT 1,
  `montant_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `mail_client` varchar(128) NOT NULL,
  KEY `id_client` (`mail_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;


DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `numero` int(11) NOT NULL,
  `libelle` varchar(32) NOT NULL,
  `taille` int(11) NOT NULL,
  `libelle_taille` varchar(32) NOT NULL,
  `tarif` decimal(6,2) NOT NULL,
  `quantite` int(11) NOT NULL,
  `commande_id` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;


-- 2024-01-09 08:31:13
