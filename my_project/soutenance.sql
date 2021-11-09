-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 09 nov. 2021 à 11:43
-- Version du serveur : 10.4.21-MariaDB
-- Version de PHP : 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `soutenance`
--

-- --------------------------------------------------------

--
-- Structure de la table `actualite`
--

CREATE TABLE `actualite` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `actualite`
--

INSERT INTO `actualite` (`id`, `title`, `content`) VALUES
(1, 'Article 1', 'Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l\'imprimerie depuis les années 1500, quand un imprimeur anonyme assembla ensemble des morceaux de tex'),
(2, 'Article 2', 'Contrairement à une opinion répandue, le Lorem Ipsum n\'est pas simplement du texte aléatoire. Il trouve ses racines dans une oeuvre de la littérature latine classique datant de 45 av. J.-C., le rendant vieux de 2000 ans.');

-- --------------------------------------------------------

--
-- Structure de la table `conge`
--

CREATE TABLE `conge` (
  `id` int(11) NOT NULL,
  `datedebut` date NOT NULL,
  `statut` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `iduser` int(11) NOT NULL,
  `nombrejour` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `conge`
--

INSERT INTO `conge` (`id`, `datedebut`, `statut`, `iduser`, `nombrejour`) VALUES
(23, '2021-11-10', 'a:1:{i:0;s:8:\"en cours\";}', 1, 5),
(24, '2021-11-04', 'a:1:{i:0;s:8:\"validée\";}', 1, 2),
(25, '2021-11-19', 'a:1:{i:0;s:9:\"validée \";}', 3, 25),
(26, '2021-11-11', 'a:1:{i:0;s:8:\"en cours\";}', 1, 1),
(27, '2021-11-02', 'a:1:{i:0;s:9:\"validée \";}', 4, 10),
(28, '2021-12-02', 'a:1:{i:0;s:8:\"refusée\";}', 4, 5);

-- --------------------------------------------------------

--
-- Structure de la table `upload`
--

CREATE TABLE `upload` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `nom`, `prenom`, `email`, `password`, `roles`) VALUES
(3, 'Ameur', 'Wiem', 'wiem123@gmail.com', '$2y$13$RawpE64ea4v.CCOLQUH1uu9We0rqK.z321txj82smBSX.Me/6urVC', 'a:1:{i:0;s:9:\"ROLE_USER\";}'),
(4, 'Ben Ameur', 'Asma', 'asma@gmail.com', '$2y$13$egIv1d3ilEfiEMZYw7dDVulHLHvlKGNxGqBq2bGEh1laN1NN8veQi', 'a:1:{i:0;s:9:\"ROLE_USER\";}'),
(5, 'Ben Ameur', 'Wiem', 'wiem@gmail.com', '$2y$13$a6bj0HKbnyoEMV34KbnYEOtagpVbb7UnYGcZLKlCI9iMg7a911I0a', 'a:1:{i:1;s:10:\"ROLE_ADMIN\";}'),
(6, 'ben ameur', 'dorra', 'dorra@gmail.com', '$2y$13$DJopxqgFxgniaHTZVCFzmeCCSM/DYIBuzx3zmQpO/ZqSMLWR5cHwu', 'a:1:{i:0;s:9:\"ROLE_USER\";}'),
(7, 'ben ameur', 'haroun', 'haroun@gmail.com', '$2y$13$pRfiMfJFK/QCm9Byv8wYyubBb7IP6bki2A3fjEBvWqsWM2u5qnRrW', 'a:1:{i:0;s:9:\"ROLE_USER\";}');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `actualite`
--
ALTER TABLE `actualite`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `conge`
--
ALTER TABLE `conge`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `upload`
--
ALTER TABLE `upload`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `actualite`
--
ALTER TABLE `actualite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `conge`
--
ALTER TABLE `conge`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pour la table `upload`
--
ALTER TABLE `upload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
