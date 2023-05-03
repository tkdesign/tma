SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `crm` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `request` text NOT NULL,
  `created_at` datetime NOT NULL,
  `replied_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `prices_sk` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `price` varchar(45) DEFAULT NULL,
  `duration` varchar(45) DEFAULT NULL,
  `desc` text,
  `ordering` int DEFAULT NULL,
  `published` tinyint DEFAULT NULL,
  `price_group_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `prices_sk` (`id`, `title`, `price`, `duration`, `desc`, `ordering`, `published`, `price_group_id`) VALUES
(1, 'Architektonická štúdia', '20€/m²', '8 týždňov', 'Pre začiatok projekčných prác je potrebné priestor zamerať', 0, 1, 1),
(2, 'Projekty pre územné rozhodnutie a stavebné povolenie', 'od 40€/m²', '8 týždňov', 'Cena platí pre priestory od 100m²', 1, 1, 1),
(3, 'Realizačný projekt', 'od 70€/m²', '16 týždňov', 'Cena platí pre priestory od 100m²', 2, 1, 1),
(4, 'Realizačné detaily', 'od 30€/m²', '4 týždne', 'Výkresy nábytku na mieru a podrobná špecifikácia použitých prvkov s cenovou ponukou realizácie na kľúč', 3, 1, 1),
(5, 'Autorský dozor', '40€/hod', '12 týždňov', 'Autorský dozor zahŕňa návštevy stavby počas realizácie jedenkrát za týždeň', 4, 1, 1),
(6, 'Zameranie priestoru', '10€/m²', '2 týždne', 'Pre začiatok projekčných prác je potrebné priestor zamerať', 0, 1, 2),
(7, 'Dispozičné riešenie', '20€/m²', '4 týždne', 'Cena platí pre priestory od 100m²', 1, 1, 2),
(8, 'Návrh interiéru', 'od 50€/m²', '12 týždňov', 'Cena platí pre priestory od 100m²', 2, 1, 2),
(9, 'Projekt pre cenovú ponuku', 'od 60€/m²', '12 týždňov', 'Výkresy nábytku na mieru a podrobná špecifikácia použitých prvkov s cenovou ponukou realizácie na kľúč', 3, 1, 2),
(10, 'Autorský dozor', '40€/hod', '12 týždňov', 'Autorský dozor zahŕňa návštevy stavby počas realizácie jedenkrát za týždeň', 4, 1, 2),
(11, 'Konzultačné služby', '40€/hod', '2 týždne', 'Pri projektoch s nepredvídateľnou časovou náročnosťou naše služby účtujeme na základe odpracovaných hodín', 0, 1, 3),
(12, 'Cestovné náklady', '40€/hod + 0,5€/km', '4 týždne', 'Cena za jeden výjazd obsahuje cestovné náklady vrátane času cesty na miesto stavby a nazad.', 1, 1, 3),
(13, 'Návrh interiéru', 'od 50€/m²', '12 týždňov', 'Cena platí pre priestory od 100m²', 2, 1, 3);

CREATE TABLE `price_groups_sk` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `desc` text,
  `ordering` int DEFAULT NULL,
  `published` tinyint DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `price_groups_sk` (`id`, `title`, `desc`, `ordering`, `published`) VALUES
(1, 'Architektúra', '<p>Ponúkame komplexný prístup k architektonickému návrhu budov a stavieb.</p><p>Môžete si u nás objednať architektonický koncept, architektonický návrh a pracovnú projektovú dokumentáciu pre rodinné domy, administratívne komplexy, spotové a relaxačné budovy, bytové domy a budovy služieb, obchodné centrá atď.</p>', 0, 1),
(2, 'Interiér', '<p>Robíme interiéry všetkých druhov, veľkostí a rozpočtov. Naše riešenia sú jednoduché a funkčné.</p><p>Môžete si u nás objednať koncept, plánovacie riešenie, projekt a pracovnú dokumentáciu pre stavebné práce.</p>', 1, 1),
(3, 'Ostatné služby', '<p>Doplnkové služby, ktoré nie sú zahrnuté v cene projektových prác, poskytujeme za', 2, 1);

CREATE TABLE `projects_has_categories_sk` (
  `project_id` int NOT NULL,
  `project_category_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `projects_has_categories_sk` (`project_id`, `project_category_id`) VALUES
(1, 1),
(6, 1),
(7, 1),
(9, 1),
(10, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(11, 2),
(2, 3),
(3, 3),
(4, 3),
(8, 3),
(5, 4);

CREATE TABLE `projects_sk` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `intro_text` mediumtext,
  `full_text` text,
  `customer` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `image_ImageWidth` smallint DEFAULT '0',
  `image_ImageHeight` smallint DEFAULT '0',
  `ordering` int DEFAULT '0',
  `published` tinyint DEFAULT '0',
  `meta_key` text,
  `meta_description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `projects_sk` (`id`, `title`, `alias`, `intro_text`, `full_text`, `customer`, `image`, `image_ImageWidth`, `image_ImageHeight`, `ordering`, `published`, `meta_key`, `meta_description`) VALUES
(1, 'Byt', 'flat', 'Dizajn interiéru bytu', '', '', 'flat.jpg', 0, 0, 0, 1, '', ''),
(2, 'Kancelária', 'office', 'Dizajn interiéru kancelárie', '', '', 'office.jpg', 0, 0, 1, 1, '', ''),
(3, 'Autosalón', 'autosalon', 'Dizajn interiéru autosalóna', '', '', 'salon.jpg', 0, 0, 2, 1, '', ''),
(4, 'Kancelária', 'office_2', 'Dizajn interiéru kancelárie', '', '', 'office2.jpg', 0, 0, 3, 1, '', ''),
(5, 'Výstava', 'exhibition', 'Projekt interiéru výstavy', '', '', 'museum2.jpg', 0, 0, 4, 1, '', ''),
(6, 'Byt', 'flat_2', 'Dizajn interiéru bytu', '', '', 'flat13a.jpg', 0, 0, 5, 1, '', ''),
(7, 'Byt', 'flat_3', 'Dizajn interiéru bytu', '', '', 'flat12b.jpg', 0, 0, 6, 1, '', ''),
(8, 'Nahrávacie štúdio', 'recording_studio', 'Projekt interiéru nahrávacieho štúdia', '', '', 'sstudio.jpg', 0, 0, 7, 1, '', ''),
(9, 'Byt', 'flat_4', 'Dizajn interiéru bytu', '', '', 'flat11b.jpg', 0, 0, 8, 1, '', ''),
(10, 'Byt', 'flat_5', 'Dizajn interiéru bytu', '', '', 'flat9a.jpg', 0, 0, 9, 1, '', ''),
(11, 'Rodinný dom', 'house', 'Dizajn interiéru rodinného domu', '', '', 'townhouse.jpg', 0, 0, 10, 1, '', ''),
(12, 'Byt', 'flat_5', 'Dizajn interiéru bytu', '', '', 'flat4.jpg', 0, 0, 11, 1, '', ''),
(13, 'Byt', 'flat_6', 'Dizajn interiéru bytu', '', '', 'flat3.jpg', 0, 0, 12, 1, '', ''),
(14, 'Byt', 'flat_7', 'Dizajn interiéru bytu', '', '', 'flat2.jpg', 0, 0, 13, 1, '', ''),
(15, 'Byt', 'flat_8', 'Dizajn interiéru bytu', '', '', 'flat5.jpg', 0, 0, 14, 1, '', ''),
(16, 'Byt', 'flat_9', 'Dizajn interiéru bytu', '', '', 'flat6.jpg', 0, 0, 15, 1, '', ''),
(17, 'Byt', 'flat_10', 'Dizajn interiéru bytu', '', '', 'flat7.jpg', 0, 0, 16, 1, '', ''),
(18, 'Byt', 'flat_11', 'Dizajn interiéru bytu', '', '', 'flat8.jpg', 0, 0, 17, 1, '', '');

CREATE TABLE `project_categories_sk` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `alias` varchar(255) NOT NULL DEFAULT '',
  `description` text,
  `enabled` tinyint DEFAULT '0',
  `ordering` int DEFAULT '0',
  `published` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `project_categories_sk` (`id`, `title`, `alias`, `description`, `enabled`, `ordering`, `published`) VALUES
(1, 'Byty', 'flats', NULL, 1, 0, 1),
(2, 'Doma', 'houses', NULL, 1, 0, 1),
(3, 'Kancelárie', 'offices', NULL, 1, 0, 1),
(4, 'Výstavy', 'exhibitions', NULL, 1, 0, 1);

CREATE TABLE `project_files_sk` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `intro_text` mediumtext,
  `file_name` varchar(255) NOT NULL,
  `file_ImageWidth` smallint DEFAULT '0',
  `file_ImageHeight` smallint DEFAULT '0',
  `large_file_name` varchar(255) NOT NULL,
  `large_file_ImageWidth` smallint DEFAULT '0',
  `large_file_ImageHeight` smallint DEFAULT '0',
  `ordering` int DEFAULT '0',
  `published` tinyint DEFAULT '0',
  `project_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(100) NOT NULL,
  `usertype` tinyint DEFAULT '0',
  `block` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `users` (`id`, `name`, `username`, `password`, `usertype`, `block`) VALUES
(1, 'Petr', 'admin', '$2y$10$y8o9.eEMHVnrqcOP/oCNqujEERlJhm7X4At3NiLo4MiVvmCwhVMC2', 1, 0);


ALTER TABLE `crm`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email_idx` (`email`) INVISIBLE,
  ADD KEY `created_at_idx` (`created_at`),
  ADD KEY `replied_at_idx` (`replied_at`),
  ADD KEY `name_idx` (`name`) USING BTREE;

ALTER TABLE `prices_sk`
  ADD PRIMARY KEY (`id`,`price_group_id`),
  ADD KEY `title_idx` (`title`),
  ADD KEY `fk_prices_sk_price_groups_sk1_idx` (`price_group_id`),
  ADD KEY `ordering_idx` (`ordering`),
  ADD KEY `published_idx` (`published`);

ALTER TABLE `price_groups_sk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `title_idx` (`title`),
  ADD KEY `ordering_idx` (`ordering`) INVISIBLE,
  ADD KEY `published_idx` (`published`);

ALTER TABLE `projects_has_categories_sk`
  ADD PRIMARY KEY (`project_id`,`project_category_id`),
  ADD KEY `project_category_id_idx` (`project_category_id`),
  ADD KEY `project_id_idx` (`project_id`) INVISIBLE;

ALTER TABLE `projects_sk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `published_idx` (`published`),
  ADD KEY `ordering_idx` (`ordering`);

ALTER TABLE `project_categories_sk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `published_idx` (`published`),
  ADD KEY `ordering_idx` (`ordering`);

ALTER TABLE `project_files_sk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `published_idx` (`published`),
  ADD KEY `ordering_idx` (`ordering`),
  ADD KEY `project_id_idx` (`project_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_idx` (`username`);


ALTER TABLE `crm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `prices_sk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

ALTER TABLE `price_groups_sk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `projects_sk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `project_categories_sk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `project_files_sk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=684;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


ALTER TABLE `prices_sk`
  ADD CONSTRAINT `fk_prices_sk_price_groups_sk1` FOREIGN KEY (`price_group_id`) REFERENCES `price_groups_sk` (`id`);

ALTER TABLE `projects_has_categories_sk`
  ADD CONSTRAINT `projects_has_categories_sk_project_categories_sk_fkey` FOREIGN KEY (`project_category_id`) REFERENCES `project_categories_sk` (`id`),
  ADD CONSTRAINT `projects_has_categories_sk_projects_sk_fkey` FOREIGN KEY (`project_id`) REFERENCES `projects_sk` (`id`);

ALTER TABLE `project_files_sk`
  ADD CONSTRAINT `project_files_sk_projects_sk_fkey` FOREIGN KEY (`project_id`) REFERENCES `projects_sk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
