-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  mar. 18 août 2020 à 17:05
-- Version du serveur :  8.0.18
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog_pro`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nameVisitor` varchar(45) NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `commentDate` datetime NOT NULL,
  `emailVisitor` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `validComment` enum('TRUE','FALSE') NOT NULL DEFAULT 'FALSE',
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `post_id` int(11) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_id` (`post_id`),
  KEY `fk_comment_user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=163 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `nameVisitor`, `content`, `commentDate`, `emailVisitor`, `validComment`, `user_id`, `post_id`) VALUES
(1, 'xavier.techer', 'Emma, prise de dégoût, lui envoya, par-dessus l\'épaule, en lui tournant les talons.', '2020-07-16 07:07:17', 'jacques44@free.fr', 'TRUE', NULL, 4),
(2, 'pbrunel', 'Le monsieur, ramenant l\'éventail, l\'offrit à la ville, depuis le cimetière des Bertaux.', '2020-07-18 14:07:38', 'olivier.marthe@free.fr', 'TRUE', NULL, 20),
(3, 'maillot.honore', 'II Emma descendit quelques marches, et elle repassa par la rue Nationale, près de la.', '2020-07-14 12:07:57', 'qvincent@noos.fr', 'TRUE', NULL, 23),
(4, 'marchand.antoinette', 'D\'ailleurs, n\'était-ce pas une feuille de papier. -- De grâce, restez! je vous jure.', '2020-08-05 23:08:04', 'david.pottier@gmail.com', 'TRUE', NULL, 2),
(5, 'berger.theodore', 'Parle! qu\'as-tu mangé? Réponds, au nom du pharmacien, et en écoutant ce discours, et il.', '2020-07-15 15:07:34', 'udaniel@wanadoo.fr', 'TRUE', NULL, 5),
(6, 'martins.ines', 'Et son regard, et alors la foule bigarrée des gens attablés dans son menton: -- Quelle.', '2020-07-13 21:07:17', 'lorraine.jean@orange.fr', 'TRUE', NULL, 7),
(7, 'stephane93', 'Mais il n\'offrait pas grande prise à ces exaltations succédaient tout à coup. Des.', '2020-07-11 13:07:23', 'simone77@dbmail.com', 'TRUE', NULL, 24),
(8, 'virginie.mendes', 'Une fois le pansement fait, le médecin comme dans les cendres. Emma restait seule dans.', '2020-08-04 04:08:56', 'blevy@club-internet.fr', 'TRUE', NULL, 7),
(9, 'mdias', 'Mais une femme élégante! et, sans regarder derrière elle. Le jour commençait à venir.', '2020-07-18 12:07:40', 'dominique.petit@dbmail.com', 'TRUE', NULL, 17),
(10, 'lucas70', 'Un vent lourd soufflait. Emma se mit à crier. -- Eh! laisse-moi donc! fit-elle en lui.', '2020-07-21 16:07:02', 'ydurand@gmail.com', 'TRUE', NULL, 19),
(11, 'yves48', 'La maison que le moteur mécanique où était enfermée sa jambe frappait contre la tenture.', '2020-07-14 03:07:03', 'monique50@voila.fr', 'TRUE', NULL, 1),
(12, 'adelaide.bruneau', 'Cependant, au haut du clocher de l\'église. Les femmes suivaient, couvertes de mantes.', '2020-07-29 02:07:24', 'allain.madeleine@tiscali.fr', 'TRUE', NULL, 8),
(13, 'blenoir', 'Bray, tandis que, sans s\'inquiéter des conséquences. Nous ne sommes pas près, à ce nom.', '2020-07-31 18:07:15', 'genevieve78@sfr.fr', 'TRUE', NULL, 13),
(14, 'tleclerc', 'Comment vais-je signer, maintenant? se dit-il. D\'ailleurs, Charles n\'était point de ces.', '2020-07-28 09:07:45', 'lucy79@gmail.com', 'TRUE', NULL, 16),
(15, 'dasilva.theodore', 'Tostes lui plaisait beaucoup, et même lui parut prétentieuse et son visage des.', '2020-08-07 03:08:07', 'egermain@bouygtel.fr', 'TRUE', NULL, 11),
(16, 'martin12', 'Rhin, des potages à la file montèrent s\'asseoir sur le prêtre retira du saint ciboire la.', '2020-07-20 00:07:26', 'andree.legrand@ifrance.com', 'TRUE', NULL, 14),
(17, 'daniel48', 'Honneur! trois fois honneur! N\'est-ce pas l\'agriculteur encore qui engraisse, pour nos.', '2020-07-28 20:07:59', 'dfouquet@live.com', 'TRUE', NULL, 25),
(18, 'louise.martinez', 'Le coup, vous comprenez, est encore trop récent! Alors Homais lui apportait le journal.', '2020-08-05 23:08:24', 'deoliveira.gregoire@yahoo.fr', 'TRUE', NULL, 11),
(19, 'philippine.delahaye', 'M. Léon chanta une barcarolle, et madame Bovary changea d\'allures. Ses regards devinrent.', '2020-07-18 00:07:31', 'benjamin.descamps@voila.fr', 'TRUE', NULL, 4),
(20, 'nicolas.julien', 'Je t\'ai bien aimé! Ce fut un grand dîner. Où irait-il exercer son art? À Tostes. Il n\'y.', '2020-07-23 04:07:18', 'gilles.colas@tele2.fr', 'TRUE', NULL, 15),
(21, 'suzanne77', 'Bovary tourna la tête renversée contre le mur, les garçons qui venaient tremper là, dans.', '2020-07-22 07:07:15', 'francois.remy@free.fr', 'TRUE', NULL, 6),
(22, 'stephanie61', 'Laisse-moi seule. Elle avait cette indéfinissable beauté qui résulte de la façade. Elle.', '2020-08-01 11:08:23', 'hardy.nath@tele2.fr', 'TRUE', NULL, 4),
(23, 'benjamin.boutin', 'Ils en rirent bien des fois; mais, quand il ne tarda pas à trois heures, M. et madame.', '2020-07-14 05:07:43', 'constance85@ifrance.com', 'TRUE', NULL, 3),
(24, 'ocharrier', 'Elle est même au bras de Léon; et elle égarait ses yeux lui paraissaient agrandis.', '2020-07-20 20:07:56', 'omendes@voila.fr', 'TRUE', NULL, 15),
(25, 'frederique.pages', 'Et, plus prompt qu\'un escamoteur, il enveloppa la guipure de papier bleu, de la.', '2020-07-24 06:07:43', 'david97@yahoo.fr', 'TRUE', NULL, 9),
(26, 'dtecher', 'Seulement, vous l\'embrasserez bien! Adieu!... vous êtes fou! disait-elle avec de grands.', '2020-07-17 06:07:19', 'marcelle.barbier@orange.fr', 'TRUE', NULL, 24),
(27, 'ftraore', 'Madame Bovary se compromettait. Pour arriver à Yonville, madame veuve Lefrançois, sur la.', '2020-07-24 12:07:12', 'jean31@yahoo.fr', 'TRUE', NULL, 16),
(28, 'camille.baudry', 'Cependant, la perspective d\'une situation nouvelle l\'effrayait autant qu\'elle le.', '2020-07-18 10:07:00', 'lucas.cohen@hotmail.fr', 'TRUE', NULL, 21),
(29, 'duval.olivier', 'Oui, il se donnait de ne point éveiller Charles qui mordait à petits coups avec le bout.', '2020-07-28 18:07:57', 'fournier.nicolas@free.fr', 'TRUE', NULL, 21),
(30, 'thibault.monnier', 'On le vit pendant une semaine entrer le soir au bal masqué. Puis elle dit vivement.', '2020-07-09 08:07:55', 'daniel.bouvet@tiscali.fr', 'TRUE', NULL, 8),
(31, 'martine83', 'Emma le laissait parler. Elle s\'ennuyait si prodigieusement depuis deux jours! -- Et.', '2020-07-18 07:07:21', 'simon.tristan@ifrance.com', 'TRUE', NULL, 23),
(32, 'jalbert', 'Il se mit à lui parler amicalement, comme si nous étions à la Barbe d\'or ou au jardin.', '2020-08-02 04:08:19', 'alexandre.lagarde@live.com', 'TRUE', NULL, 25),
(33, 'theophile90', 'Croix rouge, de sorte que c\'était un équin mêlé d\'un peu de poussière grise glissa de la.', '2020-07-24 12:07:59', 'nroyer@free.fr', 'TRUE', NULL, 24),
(34, 'fbrunel', 'Il reprit: «Et qu\'aurais-je à faire, messieurs, de vous démontrer ici l\'utilité de.', '2020-07-17 13:07:26', 'adele87@yahoo.fr', 'TRUE', NULL, 23),
(35, 'hdidier', 'Le marchand ne se moquait pas, quand un coup de sang; il entrevit des culs de.', '2020-07-12 02:07:29', 'slacombe@laposte.net', 'TRUE', NULL, 19),
(36, 'eric.cousin', 'Bovary d\'écrire à sa toilette. Elle commençait par trois boudins circulaires; puis.', '2020-07-30 21:07:08', 'guillaume90@hotmail.fr', 'TRUE', NULL, 8),
(37, 'llenoir', 'Tu as vu une bouteille, que l\'on cachait à tous les hôtels de la chanteuse lui parut.', '2020-07-20 15:07:44', 'marc71@tele2.fr', 'TRUE', NULL, 25),
(38, 'dthomas', 'Hippolyte commençait à trembler aux mains de la salle, longue pièce à côté. Emma, le.', '2020-07-28 23:07:04', 'gilles91@yahoo.fr', 'TRUE', NULL, 5),
(39, 'edouard.gros', 'Le thermomètre (j\'en ai fait les observations) descend en hiver jusqu\'à quatre degrés.', '2020-07-21 22:07:01', 'xavier.parent@ifrance.com', 'TRUE', NULL, 14),
(40, 'theodore79', 'Emma avait pleuré, s\'était emportée; elle avait manqué mourir; quel dommage! elle qui.', '2020-07-18 04:07:52', 'martin04@sfr.fr', 'TRUE', NULL, 8),
(41, 'bernadette.colin', 'Monsieur, j\'attends! -- Quoi donc? fit le notaire, Dieu seul le savait, et la.', '2020-07-14 02:07:14', 'tremy@orange.fr', 'TRUE', NULL, 25),
(42, 'bhernandez', 'Parfois même, se levant à demi, le dos appuyé contre une chaise, elle aperçut au loin.', '2020-08-07 10:08:40', 'leger.jules@bouygtel.fr', 'TRUE', NULL, 22),
(43, 'bbriand', 'Ma foi, non, reprit-il, je n\'irai pas; votre compagnie vaut bien la sienne. Mais le.', '2020-08-01 06:08:09', 'perrot.daniel@orange.fr', 'TRUE', NULL, 3),
(44, 'ydiallo', 'Elle le charmait autrefois l\'effrayait un peu dans cette rue, Emma parut elle-même à.', '2020-08-07 14:08:04', 'agnes.ferrand@dbmail.com', 'TRUE', NULL, 15),
(45, 'michelle26', 'Les murs des jardins, qui avaient comparu lors du choléra, pour l\'agrandir, on a comme.', '2020-07-30 00:07:57', 'danielle.leleu@hotmail.fr', 'TRUE', NULL, 6),
(46, 'morvan.victor', 'Puis elle remontait, fermait la porte, il entrait... Quelle étreinte! Puis les symptômes.', '2020-08-01 17:08:26', 'jlesage@voila.fr', 'TRUE', NULL, 4),
(47, 'tanguy.victoire', 'On distinguait, aux dernières vibrations de ses ennuis, et chaque après-midi, si le.', '2020-07-22 22:07:46', 'jules48@club-internet.fr', 'TRUE', NULL, 17),
(48, 'anastasie88', 'L\'un portait des bas de la fenêtre, elle dit: «Ah! mon Dieu!» poussa un cri. Il ne faut.', '2020-07-22 00:07:52', 'marcel.letellier@orange.fr', 'TRUE', NULL, 23),
(49, 'noel.marin', 'À huit heures, Justin venait le baiser au front: -- Quelle réponse apporter à M. le.', '2020-07-30 17:07:10', 'hhumbert@bouygtel.fr', 'TRUE', NULL, 24),
(50, 'znoel', 'Elle avait la tête et s\'évanouit, Presque aussitôt, madame Homais accourut et.', '2020-08-03 03:08:51', 'alexandrie.menard@tele2.fr', 'TRUE', NULL, 5),
(51, 'maryse24', 'Sa maison, du haut d\'une meule. Sa bonne la retenait par la porte avec de belles.', '2020-07-28 21:07:07', 'victor32@dbmail.com', 'TRUE', NULL, 3),
(52, 'emaurice', 'Il répéta: -- D\'un autre! Et il la regardait, tout étonné par la côte d\'Argueil, à.', '2020-08-04 07:08:50', 'agodard@wanadoo.fr', 'TRUE', NULL, 19),
(53, 'marie70', 'Au fond de l\'horizon, la vieille ferraille; et elle se rappela les héroïnes des livres.', '2020-07-30 20:07:43', 'brigitte.marchand@orange.fr', 'TRUE', NULL, 5),
(54, 'chauveau.guy', 'M. Homais, quant à lui, se dilatèrent; il apprit par coeur des couplets qu\'il chantait.', '2020-07-22 08:07:25', 'etienne.bouvet@dbmail.com', 'TRUE', NULL, 14),
(55, 'pierre.pauline', 'Athalie qui la rendit presque intéressante. Naturellement, par nonchalance; il en.', '2020-07-14 01:07:25', 'sebastien.bodin@voila.fr', 'TRUE', NULL, 6),
(56, 'ferreira.gilbert', 'Cependant, secouant la sienne: -- T\'es-tu bien amusée hier? demanda-t-il. -- Oui. Alors.', '2020-07-18 19:07:55', 'gillet.suzanne@voila.fr', 'TRUE', NULL, 20),
(57, 'francoise.blanc', 'Elle se leva d\'un bond jusqu\'à l\'hôtel. Emma n\'y était plus. Elle fut stoïque, le.', '2020-07-28 07:07:31', 'julien03@hotmail.fr', 'TRUE', NULL, 25),
(58, 'caubert', 'Bournisien résigné à tout entendre. -- Parbleu! ils en eurent fini avec les rubans de.', '2020-08-06 15:08:22', 'ebourdon@laposte.net', 'TRUE', NULL, 21),
(59, 'llegoff', 'Lefrançois, en le voyant, fit de grandes raies minces, qui se brisaient à l\'angle des.', '2020-08-05 20:08:48', 'raymond72@hotmail.fr', 'TRUE', NULL, 9),
(60, 'jcolas', 'Dodolphe..., je crois.» Elle frissonna. -- Tu reviendrais dimanche. Voyons, décide-toi!.', '2020-07-23 17:07:39', 'adele99@wanadoo.fr', 'TRUE', NULL, 6),
(61, 'laurence48', 'Ah! c\'est fini! il faudrait en faire l\'analyse. Car il allait d\'un groupe à l\'autre. On.', '2020-07-14 05:07:01', 'wgosselin@hotmail.fr', 'TRUE', NULL, 23),
(62, 'opires', 'Elle abandonna la musique. Elle se retrouvait dans les cours, où on le saurait? Mais.', '2020-07-26 13:07:52', 'jules84@gmail.com', 'TRUE', NULL, 10),
(63, 'francois28', 'Il la croyait heureuse; et elle entendit tout au fond de la pommade qui lustrait sa.', '2020-07-14 23:07:07', 'georges12@club-internet.fr', 'TRUE', NULL, 23),
(64, 'mathilde04', 'Cependant les quatre colonnes de la loi. Sa volonté, comme le père Rouault allait être.', '2020-07-25 12:07:44', 'isaac22@orange.fr', 'TRUE', NULL, 24),
(65, 'aroche', 'Elle choisit le Vicomte, et le soleil, l\'avaient par gradations développée, et elle.', '2020-07-15 11:07:32', 'mpoulain@ifrance.com', 'TRUE', NULL, 15),
(66, 'marianne72', 'Emma était accoudée à sa place, auprès du berceau. -- Puisque celui-là ne tient plus.', '2020-07-24 17:07:43', 'camus.francois@hotmail.fr', 'TRUE', NULL, 14),
(67, 'cgeorges', 'Tu en es sûr? -- Certainement. -- C\'est possible! Puis, vivement: -- J\'ai été malade.', '2020-07-11 07:07:50', 'maurice.zacharie@tele2.fr', 'TRUE', NULL, 13),
(68, 'claude83', 'Charles, bouleversé, attendit patiemment le retour de sa bonne. Mais une rafale de vent.', '2020-07-31 08:07:23', 'hmarin@club-internet.fr', 'TRUE', NULL, 9),
(69, 'lemoine.adele', 'Rodolphe y trempa son doigt sur la rivière dans la chevelure. -- Est-ce de ton salut.', '2020-07-23 05:07:02', 'marc07@club-internet.fr', 'TRUE', NULL, 15),
(70, 'jean62', 'Comme il avait soigné les choses; et son existence affreuse! -- Est-ce possible! Ils ne.', '2020-07-11 02:07:58', 'alexandria26@tiscali.fr', 'TRUE', NULL, 23),
(71, 'wgarcia', 'Elle avait fait sonner si haut, rien, si ce geste hideux et doux des corbeaux, qui.', '2020-07-17 17:07:10', 'philippe.delattre@yahoo.fr', 'TRUE', NULL, 9),
(72, 'claire08', 'Oh! la musique de la charreterie que la satisfaction de vengeance. N\'avait-elle pas.', '2020-07-26 18:07:23', 'hardy.margot@ifrance.com', 'TRUE', NULL, 17),
(73, 'ribeiro.jeannine', 'C\'était une existence dévergondée qui excite un peu penchée sur l\'épaule de leur.', '2020-07-27 10:07:27', 'thibaut06@free.fr', 'TRUE', NULL, 7),
(74, 'emilie67', 'À quoi songent nos édiles?» Puis Homais inventait des anecdotes: «Hier, dans la voiture.', '2020-08-04 05:08:21', 'nvincent@hotmail.fr', 'TRUE', NULL, 11),
(75, 'dmarques', 'Puis, en y touchant à peine, le nouveau resta vide, et comme sous la chaleur du foyer.', '2020-07-19 03:07:21', 'alexandria.dupont@live.com', 'TRUE', NULL, 7),
(76, 'simon.suzanne', 'Les couteaux jamais n\'étaient affilés, ni les conseils du pharmacien, comme des souliers.', '2020-07-13 20:07:06', 'henri72@tiscali.fr', 'TRUE', NULL, 18),
(77, 'elodie79', 'Excusez-moi, dit-il, je suis rond comme une Babylone où elle l\'avait laissé, le.', '2020-08-05 05:08:28', 'fclerc@voila.fr', 'TRUE', NULL, 5),
(78, 'hugues82', 'Elle partirait d\'Yonville comme pour un tigre parmi ses souvenirs, il examinait les.', '2020-07-11 06:07:00', 'laine.agnes@tiscali.fr', 'TRUE', NULL, 19),
(79, 'ilegendre', 'Jeanne d\'Arc, Héloïse, Agnès Sorel, la belle cloche d\'Amboise. Elle pesait quarante.', '2020-07-23 15:07:49', 'victoire.poirier@voila.fr', 'TRUE', NULL, 5),
(80, 'elisabeth.launay', 'Mais, ma chère amie... Et il se recommandait par un effort de volonté, ce spasme.', '2020-07-17 14:07:43', 'emmanuel70@hotmail.fr', 'TRUE', NULL, 13),
(85, 'mat85', 'bon ca marche cool\r\n', '2020-08-09 18:11:26', 'matanna@orange.fr', 'FALSE', NULL, 3),
(160, 'Mathieu Bonhommeau', 'c\'est l\'heure d\'aller se coucher', '2020-08-11 00:11:53', 'matanna@orange.fr', 'FALSE', NULL, 25),
(161, 'mat85', 'xfhsdwfhbsdw', '2020-08-11 00:20:34', 'matanna@orange.fr', 'FALSE', NULL, 25),
(162, 'anna56', 'on va a hautacam', '2020-08-11 08:48:27', 'matanna@orange.fr', 'FALSE', NULL, 25);

-- --------------------------------------------------------

--
-- Structure de la table `membertype`
--

DROP TABLE IF EXISTS `membertype`;
CREATE TABLE IF NOT EXISTS `membertype` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membertype`
--

INSERT INTO `membertype` (`id`, `type`) VALUES
(1, 'member'),
(2, 'moderator'),
(3, 'administrator');

-- --------------------------------------------------------

--
-- Structure de la table `post`
--

DROP TABLE IF EXISTS `post`;
CREATE TABLE IF NOT EXISTS `post` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `chapo` tinytext NOT NULL,
  `content` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lastDateModif` datetime NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `chapo`, `content`, `lastDateModif`, `picture`, `user_id`) VALUES
(1, 'Le pouvoir d\'atteindre vos buts en toute sécurité', 'J\'ai tout quitté à cause de sa vie, la bouleverse, arrache les volontés comme des.', 'Autem hic vitae aperiam cumque molestiae ut numquam temporibus. Odit nam similique voluptatum natus. Ut repellat eos quia reiciendis dolorum quisquam. Nobis quae iste iusto. Modi molestias commodi eum minima rerum. Placeat neque iure est et odit eum. Perferendis animi ut ut perferendis et ut. Quidem ipsam voluptates inventore eos iste ipsa totam. Modi qui et magni quidem qui quaerat repellat. Quo eos beatae quod. Natus dolores aut dolores sit hic. Incidunt eum culpa molestias impedit voluptates repudiandae. Tempore dolores occaecati aspernatur quia fugit facere. Autem adipisci natus minima magnam. Alias ab nam impedit ex neque.', '2020-04-07 09:11:12', '', 4),
(2, 'La sécurité d\'innover sans soucis', 'Je voulais vous exprimer seulement, madame Lefrançois, à l\'hôtelière de la robe d\'Emma.', 'Aut numquam suscipit id et ea mollitia consequatur. Ipsa expedita culpa vitae est minus quia et explicabo. Reiciendis non nobis velit officia voluptatem corporis. Eum distinctio est tenetur velit quia vitae sed. Ab voluptate consectetur culpa alias. Quia nihil ipsa modi. Rem expedita aliquam praesentium modi. Animi consectetur ut sed ullam. Esse expedita expedita reprehenderit aut occaecati aut perferendis. Corporis qui reprehenderit rerum aspernatur unde. Sit laborum in quia dolor consequatur libero nisi veritatis. Incidunt aliquam autem sint ut error. Et repellat soluta maxime iure atque. Aliquid nihil maxime alias officia neque illo. Fugiat reprehenderit iusto earum ad officia nam numquam. Sit sequi eos quia molestiae vel.', '2020-05-12 06:31:21', '', 5),
(3, 'L\'assurance de rouler à l\'état pur', 'Emma se retenait pour ne pas les civilités qui lui tapait dans la salle basse d\'un air.', 'Sequi et qui velit est fugit quidem suscipit. Eos enim fugiat aut provident. Placeat maiores voluptas beatae ipsa quas quia. Alias doloribus exercitationem ut quibusdam magnam. Dolor animi quo repudiandae animi quam qui. Impedit aliquam fugiat animi aspernatur optio delectus. Voluptatibus reprehenderit voluptate architecto praesentium neque nihil maxime. Pariatur quia sed minima mollitia repellat est. Et ut officiis quo aut ipsum. Quibusdam est iusto molestiae omnis. Illum totam ex est voluptatibus saepe aut. Quasi omnis amet et aut accusantium est nam. Quam rerum inventore sed laboriosam unde. Accusamus a non inventore nisi. Eligendi rerum et iusto repudiandae enim.', '2020-05-28 17:29:26', '', 4),
(4, 'La possibilité d\'atteindre vos buts de manière sûre', 'Barneville, près d\'Aumale, qui ne s\'effacerait pas. Ce fut dans sa chambre, on.', 'Inventore sint ad sed voluptas repellendus aspernatur delectus. Harum dolores omnis qui qui. Voluptatum ut autem ex nam voluptate assumenda. Quia labore nihil ut id maxime. Corrupti est alias sed. Est qui totam mollitia occaecati aliquid et quia. Vel laudantium consequatur saepe voluptas voluptas dignissimos odit molestiae. Architecto ad aut fugiat enim excepturi. Temporibus occaecati aut soluta rem non. Odit sed voluptatem sed rerum ex. Deleniti voluptates praesentium consequuntur quaerat voluptatem maiores facere. Est ea ab et odit. Doloremque quisquam voluptas expedita accusamus aut. In id rerum ad maiores architecto. Fugiat aut autem voluptatum quam amet qui. Incidunt quis fugit dolores sint. Soluta est quos et. Dolorum consectetur ipsum omnis sint.', '0000-00-00 00:00:00', '', 4),
(5, 'Le plaisir de rouler plus facilement', 'Oh! ne bouge pas! ne parle pas à la Marquise, et repartirent pour Tostes. Emma.', 'Ipsam animi porro ea provident asperiores. Laborum asperiores cum atque quisquam. Corrupti dolorum tempora quia esse quos deserunt. Et officiis et rem qui consectetur natus. Doloribus velit in quod natus veniam ullam. Ipsum in cumque eum aut neque dolorum. Error at consequatur corrupti ea neque ex. Quia itaque rem officiis beatae. Ad aut assumenda explicabo sed impedit et. Quidem eaque molestias culpa ipsa in. Sint quod ad sed libero consequuntur qui. Eum minus rerum deleniti et sapiente rerum. Pariatur repudiandae quo consequatur omnis sunt iste. Eius doloribus odio molestiae quia ipsum vel soluta odit. Non doloremque nostrum cupiditate nam.', '0000-00-00 00:00:00', '', 5),
(6, 'Le confort de concrétiser vos projets sans soucis', 'Nous tiendrons nos lecteurs au courant des découvertes. Il suivait le grand poêle de.', 'Occaecati quis eum qui fugiat aut aspernatur ipsa. Porro dolores et similique assumenda. Ad qui architecto ut dolorem quae. Ut autem et a enim adipisci consequatur recusandae. Dolor incidunt incidunt quisquam doloremque. Repudiandae impedit suscipit ad ipsam. Rerum sunt minus ut. Tenetur voluptatem accusantium nostrum modi. Facilis quod ab sint ipsum assumenda est deserunt. Officiis sint earum autem voluptatem molestiae et ut expedita. Nulla assumenda ipsam temporibus rerum eum sint non. Veritatis provident voluptates quaerat est animi non ut. Aut veritatis in doloribus cumque suscipit nemo nesciunt. Perferendis voluptatem harum magni atque.', '0000-00-00 00:00:00', '', 5),
(7, 'La liberté d\'évoluer plus rapidement', 'Charles était là. Il avait peur qu\'elle ne connaissait pas; aussi fut-elle stupéfaite de.', 'Maxime est vel eum eligendi mollitia consectetur eius. Quidem ut accusantium unde et. Consequatur odio eligendi sed velit est nobis temporibus. Qui sed qui at ut enim. Omnis facilis quaerat ab doloremque. Voluptatem laborum numquam ab dolor. Reiciendis beatae molestiae facilis delectus illum labore tenetur. Asperiores nihil provident exercitationem exercitationem consequatur accusamus perferendis. Temporibus repellendus et deleniti quis aut quos. Doloremque quia quibusdam est sequi aut. Unde cupiditate nihil vel aut suscipit. Occaecati facilis incidunt sit corporis esse. In quia optio sit architecto. Aut voluptatem consequatur nihil. Et similique qui odio ut iusto quidem ipsum quia.', '0000-00-00 00:00:00', '', 5),
(8, 'La liberté de rouler naturellement', 'Et nos pauvres cactus, où sont-ils? -- Le mal ne serait pas grand, répondit M. Homais y.', 'Adipisci unde cumque blanditiis et. Ipsam sit quia culpa voluptatem neque assumenda et assumenda. Non vitae alias et dolorem. Voluptatum molestias commodi aperiam non voluptatum nihil voluptas libero. Explicabo unde aliquam quia quia dolor. Laudantium perferendis officiis a sunt ullam eum quae. Et sit dignissimos quos omnis aut voluptatem. Eos voluptatem et voluptates. In numquam rerum autem distinctio modi nihil. Ullam in error ut incidunt quam aut. Fugiat ad dicta asperiores voluptates dolorem quibusdam. Id et atque minima velit quo. Et natus sed quia quis. Natus veritatis nostrum et aspernatur neque qui dolor. Recusandae aperiam rerum perspiciatis et officiis hic. Voluptas sed reprehenderit enim dolorem et sit. Est quasi fuga nihil explicabo itaque et qui.', '0000-00-00 00:00:00', '', 5),
(9, 'L\'assurance d\'avancer avant-tout', 'Allons! allons! Le rayon lumineux qui montait d\'en bas directement tirait vers les.', 'Beatae nemo vel voluptatem ea tenetur. Cumque quidem necessitatibus soluta rem sint. Quam et et expedita qui vel ut error molestiae. Vitae voluptas id qui culpa quia non. Neque nihil placeat ipsa vitae neque doloribus occaecati. Dolorum unde corporis ex inventore odit earum. Soluta ducimus aliquam veniam reiciendis aliquam minima. Soluta explicabo placeat rerum quidem. Temporibus voluptatem laborum omnis accusantium fugit occaecati. Eos tempora voluptas deserunt reiciendis odio est. Quo suscipit nihil labore qui voluptatum labore nihil. Consequatur quisquam asperiores totam ut minima id. Natus fuga quos eum debitis quas quam. Nihil esse sunt provident tenetur dolor corrupti totam. Rerum accusamus voluptatem repudiandae officia ex.', '0000-00-00 00:00:00', '', 5),
(10, 'La sécurité de changer autrement', 'Elle entendait le battement de coeur et se tourna vite en lui tournant les talons. Dès.', 'Velit fuga dolorum fuga. Quia illo occaecati at vel. Dolor quasi qui modi sapiente magni in accusamus ut. Cum ut nostrum vitae voluptas est. Molestiae excepturi voluptas qui minus et velit sunt nulla. Non est nam recusandae velit suscipit modi quaerat. Corrupti veniam aut atque quasi. Id sit id ipsum est omnis. Sit incidunt eveniet quisquam. Voluptatem corporis sint consequatur est iure. Et laboriosam quidem soluta libero veritatis aut facere. Eius porro maxime nisi soluta. Ut illo tempore quis eum. Neque praesentium vero blanditiis nesciunt commodi. Ad nulla pariatur incidunt placeat et quod commodi. Ab est et amet autem. Itaque consequatur quibusdam ut velit numquam et non. Laudantium et nihil necessitatibus iure repellat sint eligendi. Ut architecto aperiam quis explicabo cum.', '0000-00-00 00:00:00', '', 5),
(11, 'L\'art d\'évoluer plus simplement', 'Quelle réponse apporter à M. Lheureux. Donc, il se sentait elle-même vibrer de tout à.', 'Eos vel illo ipsam aspernatur est tempore culpa magnam. Aspernatur earum minima voluptatem ea ut. A molestiae occaecati vel voluptas sit. Inventore ullam nesciunt sed atque exercitationem ducimus quia. Earum assumenda qui dolore deserunt deserunt ut ipsa aliquam. Dolorum quis fugit deserunt qui voluptatem ut. Mollitia inventore aut nihil nisi laboriosam error officiis. Officia officiis consequuntur quo quis sapiente nemo nobis. Doloremque aut quae est est corrupti voluptatum dolorum. Aut natus quisquam molestiae dolorum aut commodi. Debitis molestiae nostrum rem ducimus a. Occaecati quaerat rerum nostrum ullam. Odio rerum maiores voluptatem velit similique provident animi. Veritatis officia voluptas qui enim iure error. Provident labore excepturi nemo veniam ea dolorem iste sed.', '0000-00-00 00:00:00', '', 4),
(12, 'La simplicité de concrétiser vos projets naturellement', 'La rivière livide frissonnait au vent; il n\'y resta que deux ou trois cabaretiers, le.', 'Et rerum corporis magnam enim omnis ea dolores. Nemo officiis quae magnam consequatur. Voluptatem reiciendis inventore quibusdam. Sit et dolor fuga itaque molestiae. Repellat sed rerum aut. Vel id voluptatem beatae odit. Reiciendis enim tempora quaerat eius et veritatis ducimus. Expedita unde expedita dignissimos perferendis vel. Quae saepe voluptatum officia et. Fugiat sapiente consequatur officiis laborum earum possimus. Qui delectus porro voluptatem sunt aut. Inventore quibusdam ex voluptatibus eum. Iure facilis incidunt consectetur recusandae saepe. Aut non tempore reiciendis animi. Fugiat officia et hic. Laborum ut unde repellat veritatis sint libero. Saepe libero placeat unde non vel quisquam. Dolores esse amet quia ea. Qui cupiditate quis aut porro.', '0000-00-00 00:00:00', '', 5),
(13, 'Le confort d\'évoluer plus rapidement', 'Et l\'occasion était perdue, car elle ne te connaît pas. Ce fut moins par le dessous de.', 'Aut ipsam voluptatibus sed voluptatem. Quia dolor assumenda illo saepe et. Est quo ea fugiat quia quae. Consequatur consequatur et et enim et dolores. Illum repellat architecto numquam fugit ducimus. Dolore rerum vitae corrupti dolor beatae nemo consequuntur. Explicabo repellat eius voluptatum quae sequi rerum debitis. Nemo rerum provident qui ea ad. Corporis quas nemo earum nulla amet autem. Quibusdam eligendi a cumque est. Praesentium quia blanditiis veniam illo sunt quos. Sunt dolor qui est quasi molestiae voluptatum. Aut nam vel mollitia perspiciatis ullam. Autem reprehenderit eveniet omnis est corrupti.', '0000-00-00 00:00:00', '', 5),
(14, 'Le droit d\'évoluer en toute tranquilité', 'Homais se délectait. Quoiqu\'il se grisât de luxe encore plus redoutables vraiment que.', 'Officia magni labore hic itaque sunt eligendi delectus. Iste corrupti voluptas in architecto quia et. Aliquid optio delectus fugit et nesciunt. Ut et sed fugiat ducimus sed possimus. Perferendis nam voluptas ea itaque illum. Et magnam possimus neque nam quasi. Tempora enim aut fugiat velit cum sunt. Voluptatem qui error in corporis. Facere culpa quo sed aspernatur ducimus. Enim repellat consequatur facilis optio ea ut quo. Quia eligendi corporis minus consequatur cupiditate tempora. Iste odit ut autem dolorum. Et ducimus veniam est nobis exercitationem ad. Dicta deleniti suscipit expedita occaecati quaerat debitis aut. Animi dolore error dignissimos aut.', '0000-00-00 00:00:00', '', 4),
(15, 'Le droit d\'évoluer plus simplement', 'Comme elle était entrée sous cette chemise de batiste à manchettes plissées bouffait au.', 'Sit consequuntur recusandae rerum perspiciatis natus. Quia libero reprehenderit fuga voluptas vitae eum. Quos voluptatem impedit omnis ea ad iste voluptas. Laboriosam qui repudiandae impedit aut qui. Corrupti dolores porro dicta quas. Ea incidunt provident sed quod. Sed quas accusantium recusandae deleniti aspernatur est minima. Quidem neque quis ab nisi necessitatibus. Fugit vitae officiis voluptas quidem rerum dolorem. Sunt accusantium dolorem tempore corporis fugiat. Qui omnis laudantium eius quam ut ratione debitis. Aut quia quae assumenda molestias ducimus numquam vero. Repellendus explicabo blanditiis nesciunt qui alias. Dolores rerum alias et nisi voluptatem numquam consectetur. Nemo enim aliquam sequi et hic. Iste fugit quos ratione laboriosam dignissimos a.', '0000-00-00 00:00:00', '', 4),
(16, 'L\'assurance de changer plus simplement', 'Pologne ou les Conférences de l\'abbé Frayssinous, et, le soir, malgré leur indépendance.', 'Aut aut aut iste provident sunt ut laboriosam. Ipsum et perspiciatis quibusdam odio. Delectus optio doloremque dolore magnam nihil. Sapiente mollitia cum laudantium. Eum corrupti nobis expedita aut. Sunt velit soluta sequi fugit tenetur laudantium. Eos ut non id. Commodi id eum adipisci aut. Non fuga incidunt quas ut provident fuga. Aperiam totam perspiciatis ea dolor placeat quae iusto. Omnis dolorem eligendi voluptatem. Voluptatem sunt odit reprehenderit vero error. Commodi expedita sed placeat voluptates alias occaecati sunt. Voluptates provident exercitationem neque ut. Harum ea autem dicta voluptas aut. Autem quod dolorem est est necessitatibus blanditiis sunt. Rem eum ipsam aspernatur alias cumque.', '0000-00-00 00:00:00', '', 4),
(17, 'Le confort de rouler plus rapidement', 'Un amour comme un linge humide, le froid du matin. La plate campagne s\'étalait à ses.', 'Et voluptatem id qui illum voluptatem. Enim debitis consequatur labore quis voluptas aut. Et fuga tempora nulla et eum. Possimus voluptatem eius soluta eaque nostrum vitae. Quo porro sint adipisci qui asperiores nisi. Sit suscipit hic et inventore. Ab velit eligendi sed sit inventore est quisquam. Temporibus et adipisci consequatur eius rerum nostrum. Ipsam laborum magnam molestiae veniam. Velit ut et sapiente doloribus suscipit ut. Recusandae nihil repellat corrupti mollitia eaque. Tenetur consectetur hic ut aut facilis praesentium. Dolore consequatur qui repellat modi. Voluptas qui voluptate sapiente quaerat asperiores quas qui. Adipisci optio quis aut corrupti tempora harum sed.', '0000-00-00 00:00:00', '', 5),
(18, 'L\'avantage d\'atteindre vos buts de manière sûre', 'Girard, que j\'ai promenée l\'autre jour. Ils sont venus un tas de farceurs qui se tourne.', 'Quo eveniet vel cumque excepturi consequatur. Dignissimos culpa officia praesentium non eos. Dolorum veritatis voluptate et similique nulla. Ex in ipsa voluptatum aut. Quasi qui consequatur et et suscipit aperiam. Autem nulla quis doloribus corporis. Possimus iure aperiam corporis optio numquam. Recusandae non quo tempore ut ducimus qui doloremque. Praesentium nobis blanditiis mollitia nemo omnis aut veritatis. Aut consequatur officia adipisci cupiditate. Odio placeat qui eveniet. Consequatur quaerat similique consectetur at deserunt porro ut. Esse explicabo tenetur id omnis et. Accusantium ratione nostrum et et. Excepturi aut quis esse iste.', '0000-00-00 00:00:00', '', 4),
(19, 'L\'assurance de rouler naturellement', 'Il n\'y a rien! -- Rassurez-vous, dit l\'apothicaire, la vue de ce qui passait pour gagner.', 'Quia rem eos voluptates est perspiciatis. Non perferendis deleniti quia ut et impedit. Quia esse eveniet facilis iste molestiae consequatur quo. Non ex fugit voluptas. Iste similique quo quia fugit. Laborum aspernatur corrupti vitae doloremque quas. Rem ut est atque. Nesciunt dolore delectus qui natus quae nihil tempore. Et aliquid officiis voluptas exercitationem pariatur. Eum et placeat soluta error aut. Veniam hic ratione ipsam saepe quia voluptatem ut. Itaque expedita facilis minima quasi veritatis quod consequatur. Consectetur ut aliquam facere ut fugiat quod ut qui. Eum reiciendis consequatur voluptas est quam. Quis et hic et. Et illum aspernatur sed. Beatae laborum et magni molestiae.', '0000-00-00 00:00:00', '', 5),
(20, 'La simplicité de rouler de manière efficace', 'Les halles, c\'est-à-dire un peu colorée par le charme de la Fresnaye, tué à la pointe.', 'Nulla reiciendis quisquam voluptas enim excepturi ipsam. Sit deserunt delectus modi placeat numquam. Nihil dolore ex sit qui amet. Officiis eos et nisi et tempora magnam asperiores. Ipsa esse eum aut natus ipsam. Quod sit esse illum voluptas. Aut assumenda et quam reiciendis natus velit occaecati architecto. Perferendis excepturi neque aperiam ut tenetur. Dolores fuga deserunt deserunt qui quis ea. Reprehenderit eligendi dolor ea hic ea harum. Incidunt numquam dolorem itaque et voluptatem recusandae. Rerum id ea laborum. Tempore quam aut numquam. Voluptas odio iusto eius consequatur et atque. In omnis expedita dolor blanditiis magni. Maiores consequuntur ut sint fuga ex recusandae pariatur voluptatem. Occaecati expedita eos vitae.', '0000-00-00 00:00:00', '', 4),
(21, 'Le pouvoir de changer avant-tout', 'Beauvoisine. C\'était une femme battue, dont aussitôt il s\'ouvrait dans son cabinet, prit.', 'Eos dolorem deserunt deleniti. Veniam ut at consequatur quia consequatur voluptas dolorem culpa. Provident odit eos atque quaerat tempora enim non. In accusamus et voluptas accusantium deserunt. Molestiae quidem enim animi quis eum rerum. Quibusdam quaerat vero et at. Accusamus perspiciatis quia officia ex veritatis qui quis. Et natus quis quibusdam minus. Consequatur ut voluptatum est reprehenderit laudantium tempore quasi. Illo dolores impedit iusto. Adipisci omnis et est consequuntur consequuntur. Animi dolorum consequatur unde necessitatibus aut et autem. Voluptas illo voluptatem enim voluptas eveniet. Dolorum voluptates magni distinctio unde ut perspiciatis consequatur. Quis autem dignissimos autem explicabo mollitia. Ea velit illo et totam dignissimos nobis velit.', '0000-00-00 00:00:00', '', 5),
(22, 'Le confort d\'atteindre vos buts en toute sécurité', 'Eh bien, fit Rodolphe en offrit un; elle refusa ses offres; il n\'insista pas; puis, au.', 'Eius repellat aut tempore qui animi nesciunt qui. Exercitationem eum eligendi recusandae sed officia mollitia. Beatae labore delectus iste illo. Quaerat consequatur fuga laboriosam est reprehenderit. Architecto debitis sed officia doloribus expedita nobis nulla provident. Non ratione consequatur dolorem molestias quia. Eligendi voluptates qui autem quo distinctio eius tempora. Animi ut suscipit nam optio est neque. Sapiente facilis et nihil rerum et est reiciendis. Non laborum harum ut ipsam earum repellat qui. Amet aliquid non dolorem eum asperiores aut. Quisquam labore quia quia minima tempora nesciunt quibusdam. Ut amet voluptatem neque. Ut omnis numquam unde fugiat voluptatum nulla.', '0000-00-00 00:00:00', '', 5),
(23, 'La simplicité de changer avant-tout', 'C\'est ainsi que, mardi, notre petite cité d\'Yonville s\'est vue le théâtre d\'une.', 'Ut quam accusamus qui tempora accusantium. Voluptatem omnis autem ea perspiciatis sint. Est et optio doloremque placeat non dolor excepturi. Est voluptatum sapiente sit maiores cupiditate doloremque. Ab autem distinctio aut vero. Nesciunt maiores consequuntur est iusto qui. Amet amet possimus quia est id. Quisquam rerum quia velit ipsa. Et nobis dignissimos enim id. Perferendis tenetur qui itaque minus. Ipsum nostrum assumenda minima consequatur. Possimus accusamus sequi sint aspernatur necessitatibus. Quibusdam eos at vitae dolorem est. Minima ut officia et nobis nulla aut sint. Ut eos laudantium dicta at aliquid. Ea nulla non aut reprehenderit. Facere nemo sunt rem sed eveniet aspernatur. Minus dolorem cupiditate quis dolorum.', '2020-07-05 16:33:16', 'online-942410_640.jpg', 4),
(24, 'Le plaisir de changer à sa source', 'M. Rouault était bien fatigué, s\'étendre de ses amis, à son goulot; un Mathieu Laensberg.', 'Eius voluptatum exercitationem ut perspiciatis fuga fuga. Qui nemo molestiae dolorum omnis. Voluptate inventore veniam est rerum deserunt et sit. Aut aperiam qui voluptatibus eaque excepturi. Eum aut quo ad asperiores quo. Magnam velit ex voluptatibus perspiciatis ut. Possimus aut laudantium officiis et quia molestiae incidunt. Est omnis quidem velit in consequatur consequatur omnis eos. Mollitia soluta natus ea illo qui et praesentium. Commodi velit sed aliquam aliquid commodi facilis tenetur. Molestiae dolor reiciendis voluptas itaque est corporis nihil. Esse ut iusto cupiditate dolorum dicta. Iure quisquam doloribus qui et. Qui optio quaerat quia optio omnis. Nisi facilis est ducimus qui exercitationem laborum. Error aut blanditiis qui ipsa.', '2020-07-16 17:26:40', 'hacker-1944688_640.jpg', 5),
(25, 'La liberté d\'atteindre vos buts en toute tranquilité', 'Allons, ne vous l\'a pas volée! Tout reprit son calme. Les têtes se courbèrent sur les.', 'Facilis modi doloribus quia rerum quidem magnam. Veniam quod maiores molestiae autem quae. Nisi modi animi nisi omnis a est minus. Quas fugiat soluta consectetur quia. Incidunt ut at non laudantium cupiditate ullam. Sequi sequi rem repellat odit quisquam. Et mollitia quo autem quia nulla error. Earum labore tempora ipsum maxime suscipit. Nisi delectus iusto rerum molestiae reiciendis harum. Quia suscipit culpa sed magni commodi dolores illo. Ut tempora nostrum nemo et non. Repellendus ipsum voluptate reiciendis. Et sed animi aut optio id et. Eveniet molestiae non illum beatae est. Laudantium est eveniet recusandae labore autem quia exercitationem. Ut quo rerum sed voluptas est voluptatem. Dolores et ullam non possimus veritatis. Id voluptas vel ullam cum veniam dolorem deserunt.', '2020-07-29 20:31:49', 'computer-768608_640.jpg', 5),
(36, 'bla bla', 'fbbnvb g', 'dbyfjvncbbf', '2020-08-18 17:40:21', '', 13),
(37, 'dgcsf', 'qcsxgcsvgx', 'qcsxgcsgxsdv', '2020-08-18 18:56:33', '', 13);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Hash in php',
  `profilPicture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `authorName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `userType_id` int(45) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userName_unique` (`userName`),
  KEY `fk_memberType_id` (`userType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `userName`, `password`, `profilPicture`, `authorName`, `userType_id`) VALUES
(1, 'Bertrand', 'bphmIf7M', '', 'Benoît Payet-Leclerc', 5),
(2, 'Capucine', 'O^X,k-_EdZ~i>f`GZ1t', '', 'Tristan Roy', 5),
(3, 'Joséphine', 'M:q7Y=5', '', 'Hugues-Claude Hoareau', 5),
(4, 'Lucie', ';OQ>C%{<p-5ls;q[171=', '', 'Dorothée Lacombe', 5),
(5, 'Yves', '5#s3p]qN;L', '', 'Alex Ribeiro', 4),
(6, 'Claude', '._%O2;:;\"uH9R%l', '', 'Denis-Thibaut Renault', 6),
(7, 'Juliette', 'Q0VF|+H$!=}P3]@-', '', 'Gérard Mathieu', 6),
(8, 'Martine', 'YKyKB~S{<,1cR{KUH`', '', 'Jacques-André Legendre', 5),
(9, 'Gilbert', 'CnRx1w?GG\\J&', '', 'Astrid Marie-Pichon', 5),
(10, 'Jérôme', 'BM1@e]?c=*P<q}`B', '', 'Frédérique Daniel-Couturier', 6),
(11, 'Sylvie', 'RBP#7Q0', '', 'Véronique de la Costa', 4),
(13, 'Mat85', 'myalilou', NULL, 'Mathieu Bonhommeau', 4),
(14, 'Mya26', 'dexter', NULL, 'Mya Bonhommeau', 5);

-- --------------------------------------------------------

--
-- Structure de la table `usertype`
--

DROP TABLE IF EXISTS `usertype`;
CREATE TABLE IF NOT EXISTS `usertype` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `usertype`
--

INSERT INTO `usertype` (`id`, `type`) VALUES
(4, 'Administrateur'),
(5, 'Auteur'),
(6, 'Moderateur');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk_comment_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_post_id` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `fk_post_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `fk_userType_id` FOREIGN KEY (`userType_id`) REFERENCES `usertype` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
