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

INSERT INTO `crm` (`id`, `name`, `email`, `request`, `created_at`, `replied_at`) VALUES
(4, 'Lucius Larsen', 'mirixicof@mailinator.com', 'Et et explicabo Pos', '2023-05-03 11:27:18', '2023-05-16 01:10:21'),
(6, 'Hedy Stafford', 'sosydetogu@mailinator.com', 'Eiusmod sunt vero en', '2023-05-03 11:27:39', '2023-05-03 15:01:22'),
(10, 'Shay Chaney', 'wyzi@mailinator.com', 'Maiores pariatur Nu', '2023-05-03 11:28:10', '2023-05-03 17:45:44'),
(14, 'Mohammad Hayden', 'cugelaqyso@mailinator.com', 'Mollitia perferendis', '2023-05-03 14:53:27', '2023-05-03 15:00:26'),
(19, 'Patrick Hickman', 'zyvezygyko@mailinator.com', 'Laboris magnam omnis', '2023-05-07 13:45:04', '2023-05-11 19:24:54'),
(22, 'Ori Chase', 'wypafyj@mailinator.com', 'Voluptate ut aliquid', '2023-05-11 19:03:45', '2023-05-11 19:25:40'),
(23, 'Kenneth Mathis', 'rycerepaqi@mailinator.com', 'Quasi ipsum laboris ', '2023-05-11 19:03:53', '2023-05-11 19:04:46'),
(29, 'Christine Kent', 'linaqelor@mailinator.com', 'Ut ducimus in adipi', '2023-05-11 23:02:43', '2023-05-11 23:19:30'),
(38, 'Lara Livingston', 'daqelipo@mailinator.com', 'Ab sint officia dolo', '2023-05-13 11:55:34', NULL),
(39, 'Jorden Guzman', 'benekiz@mailinator.com', 'Quis consequat Aut ', '2023-05-13 11:55:43', NULL),
(41, 'Quemby Griffin', 'vydana@mailinator.com', 'Voluptatum tenetur i', '2023-05-13 11:56:00', NULL),
(42, 'Iliana Watts', 'hybikipase@mailinator.com', 'Iusto quo enim dolor', '2023-05-13 23:09:27', '2023-05-16 13:42:34'),
(43, 'Iliana Watts', 'hybikipase@mailinator.com', 'Iusto quo enim dolor', '2023-05-13 23:10:44', NULL),
(44, 'Reece Davis', 'bifoxuhe@mailinator.com', 'Vitae ut sapiente au', '2023-05-13 23:10:54', NULL);

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
(2, 2),
(11, 2),
(3, 3),
(4, 3),
(8, 3),
(2, 4),
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
  `ordering` int DEFAULT '0',
  `published` tinyint DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `project_categories_sk` (`id`, `title`, `alias`, `description`, `ordering`, `published`) VALUES
(1, 'Byty', 'flats', NULL, 0, 1),
(2, 'Doma', 'houses', NULL, 0, 1),
(3, 'Kancelárie', 'offices', NULL, 0, 1),
(4, 'Výstavy', 'exhibitions', NULL, 0, 1);

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

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_idx` (`username`);


ALTER TABLE `crm`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `prices_sk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `price_groups_sk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `projects_sk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `project_categories_sk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


ALTER TABLE `prices_sk`
  ADD CONSTRAINT `fk_prices_sk_price_groups_sk1` FOREIGN KEY (`price_group_id`) REFERENCES `price_groups_sk` (`id`) ON DELETE CASCADE;

ALTER TABLE `projects_has_categories_sk`
  ADD CONSTRAINT `projects_has_categories_sk_project_categories_sk_fkey` FOREIGN KEY (`project_category_id`) REFERENCES `project_categories_sk` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `projects_has_categories_sk_projects_sk_fkey` FOREIGN KEY (`project_id`) REFERENCES `projects_sk` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
