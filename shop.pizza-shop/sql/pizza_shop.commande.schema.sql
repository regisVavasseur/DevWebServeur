-- Adminer 4.8.1 MySQL 5.5.5-10.3.11-MariaDB-1:10.3.11+maria~bionic dump

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
  `etat` int(11) NOT NULL DEFAULT 1,
  `montant_total` decimal(10,2) NOT NULL DEFAULT 0.00,
  `mail_client` varchar(128) NOT NULL,
  KEY `id_client` (`mail_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- 2023-09-06 14:47:17
