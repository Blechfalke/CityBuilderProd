-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1:3306
-- Généré le :  Mer 05 Novembre 2014 à 15:01
-- Version du serveur :  5.6.21
-- Version de PHP :  5.5.9-1ubuntu4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  'groupe3'
--
CREATE DATABASE IF NOT EXISTS 'groupe3' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE 'groupe3';

-- --------------------------------------------------------

--
-- Structure de la table 'CurrentGameMode'
--

CREATE TABLE 'CurrentGameMode' (
'id' int(10) unsigned NOT NULL,
  'id_fk_CurrentGameMode' int(10) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table 'CurrentGameMode'
--

INSERT INTO 'CurrentGameMode' ('id', 'id_fk_CurrentGameMode') VALUES
(1, 3);

-- --------------------------------------------------------

--
-- Structure de la table 'Game'
--

CREATE TABLE 'Game' (
'id_game' int(11) NOT NULL,
  'id_gamemodes' int(10) unsigned NOT NULL,
  'Users_id_user' int(10) unsigned NOT NULL,
  'city_type' int(10) unsigned DEFAULT NULL,
  'date' date DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=474 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table 'Game_has_Turns'
--

CREATE TABLE 'Game_has_Turns' (
  'Game_id_game' int(11) NOT NULL,
  'Turns_id_historical' int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table 'Turns'
--

CREATE TABLE 'Turns' (
'id_turn' int(10) unsigned NOT NULL,
  'id_historical' int(10) unsigned NOT NULL,
  'nb_total_pop' int(11) unsigned NOT NULL,
  'nb_kings' int(10) unsigned DEFAULT NULL,
  'nb_priests' int(10) unsigned DEFAULT NULL,
  'nb_scribes' int(10) unsigned DEFAULT NULL,
  'nb_craftsmen' int(10) unsigned DEFAULT NULL,
  'nb_soldiers' int(10) unsigned DEFAULT NULL,
  'nb_peasants' int(10) unsigned DEFAULT NULL,
  'nb_slaves' int(10) unsigned DEFAULT NULL,
  'nb_turns' int(10) unsigned DEFAULT NULL,
  'technology_used' varchar(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1220 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table 'Users'
--

CREATE TABLE 'Users' (
'id_user' int(10) unsigned NOT NULL,
  'username' varchar(50) DEFAULT NULL,
  'password' char(40) DEFAULT NULL,
  'admin' tinyint(3) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Contenu de la table 'Users'
--

INSERT INTO 'Users' ('id_user', 'username', 'password', 'admin') VALUES
(7, 'adminpyramid', '46156a68c8decfe30d11e3282565de4162f7dfb8', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table 'CurrentGameMode'
--
ALTER TABLE 'CurrentGameMode'
 ADD PRIMARY KEY ('id'), ADD KEY 'CurrentGameMode_FKIndex1' ('id_fk_CurrentGameMode');

--
-- Index pour la table 'Game'
--
ALTER TABLE 'Game'
 ADD PRIMARY KEY ('id_game'), ADD KEY 'Users' ('Users_id_user'), ADD KEY 'Game_FKIndex2' ('id_gamemodes');

--
-- Index pour la table 'Game_has_Turns'
--
ALTER TABLE 'Game_has_Turns'
 ADD PRIMARY KEY ('Game_id_game','Turns_id_historical'), ADD KEY 'Game_has_Historical_FKIndex1' ('Game_id_game'), ADD KEY 'Game_has_Historical_FKIndex2' ('Turns_id_historical');

--
-- Index pour la table 'Turns'
--
ALTER TABLE 'Turns'
 ADD PRIMARY KEY ('id_turn');

--
-- Index pour la table 'Users'
--
ALTER TABLE 'Users'
 ADD PRIMARY KEY ('id_user');

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table 'CurrentGameMode'
--
ALTER TABLE 'CurrentGameMode'
MODIFY 'id' int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table 'Game'
--
ALTER TABLE 'Game'
MODIFY 'id_game' int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=474;
--
-- AUTO_INCREMENT pour la table 'Turns'
--
ALTER TABLE 'Turns'
MODIFY 'id_turn' int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1220;
--
-- AUTO_INCREMENT pour la table 'Users'
--
ALTER TABLE 'Users'
MODIFY 'id_user' int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table 'Game'
--
ALTER TABLE 'Game'
ADD CONSTRAINT 'Game_ibfk_1' FOREIGN KEY ('Users_id_user') REFERENCES 'Users' ('id_user');

--
-- Contraintes pour la table 'Game_has_Turns'
--
ALTER TABLE 'Game_has_Turns'
ADD CONSTRAINT 'Game_has_Turns_ibfk_1' FOREIGN KEY ('Game_id_game') REFERENCES 'Game' ('id_game') ON DELETE CASCADE,
ADD CONSTRAINT 'Game_has_Turns_ibfk_2' FOREIGN KEY ('Turns_id_historical') REFERENCES 'Turns' ('id_turn') ON DELETE CASCADE;
