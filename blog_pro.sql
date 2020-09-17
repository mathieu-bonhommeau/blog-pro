-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3308
-- Généré le :  jeu. 17 sep. 2020 à 16:33
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
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `nameVisitor`, `content`, `commentDate`, `emailVisitor`, `validComment`, `user_id`, `post_id`) VALUES
(1, 'xavier.techer', 'Emma, prise de dégoût, lui envoya, par-dessus l\'épaule, en lui tournant les talons.', '2020-07-16 07:07:17', 'jacques44@free.fr', 'TRUE', NULL, 4),
(3, 'maillot.honore', 'II Emma descendit quelques marches, et elle repassa par la rue Nationale, près de la.', '2020-07-14 12:07:57', 'qvincent@noos.fr', 'TRUE', NULL, 23),
(4, 'marchand.antoinette', 'D\'ailleurs, n\'était-ce pas une feuille de papier. -- De grâce, restez! je vous jure.', '2020-08-05 23:08:04', 'david.pottier@gmail.com', 'TRUE', NULL, 2),
(7, 'stephane93', 'Mais il n\'offrait pas grande prise à ces exaltations succédaient tout à coup. Des.', '2020-07-11 13:07:23', 'matanna@orange.fr', 'TRUE', NULL, 24),
(10, 'lucas70', 'Un vent lourd soufflait. Emma se mit à crier. -- Eh! laisse-moi donc! fit-elle en lui.', '2020-07-21 16:07:02', 'ydurand@gmail.com', 'TRUE', NULL, 19),
(14, 'tleclerc', 'Comment vais-je signer, maintenant? se dit-il. D\'ailleurs, Charles n\'était point de ces.', '2020-07-28 09:07:45', 'lucy79@gmail.com', 'TRUE', NULL, 16),
(17, 'daniel48', 'Honneur! trois fois honneur! N\'est-ce pas l\'agriculteur encore qui engraisse, pour nos.', '2020-07-28 20:07:59', 'dfouquet@live.com', 'TRUE', NULL, 25),
(18, 'louise.martinez', 'Le coup, vous comprenez, est encore trop récent! Alors Homais lui apportait le journal.', '2020-08-05 23:08:24', 'deoliveira.gregoire@yahoo.fr', 'TRUE', NULL, 11),
(25, 'frederique.pages', 'Et, plus prompt qu\'un escamoteur, il enveloppa la guipure de papier bleu, de la.', '2020-07-24 06:07:43', 'david97@yahoo.fr', 'TRUE', NULL, 9),
(27, 'ftraore', 'Madame Bovary se compromettait. Pour arriver à Yonville, madame veuve Lefrançois, sur la.', '2020-07-24 12:07:12', 'jean31@yahoo.fr', 'TRUE', NULL, 16),
(28, 'camille.baudry', 'Cependant, la perspective d\'une situation nouvelle l\'effrayait autant qu\'elle le.', '2020-07-18 10:07:00', 'lucas.cohen@hotmail.fr', 'TRUE', NULL, 21),
(29, 'duval.olivier', 'Oui, il se donnait de ne point éveiller Charles qui mordait à petits coups avec le bout.', '2020-07-28 18:07:57', 'fournier.nicolas@free.fr', 'TRUE', NULL, 21),
(32, 'jalbert', 'Il se mit à lui parler amicalement, comme si nous étions à la Barbe d\'or ou au jardin.', '2020-08-02 04:08:19', 'alexandre.lagarde@live.com', 'TRUE', NULL, 25),
(33, 'theophile90', 'Croix rouge, de sorte que c\'était un équin mêlé d\'un peu de poussière grise glissa de la.', '2020-07-24 12:07:59', 'nroyer@free.fr', 'TRUE', NULL, 24),
(34, 'fbrunel', 'Il reprit: «Et qu\'aurais-je à faire, messieurs, de vous démontrer ici l\'utilité de.', '2020-07-17 13:07:26', 'adele87@yahoo.fr', 'TRUE', NULL, 23),
(35, 'hdidier', 'Le marchand ne se moquait pas, quand un coup de sang; il entrevit des culs de.', '2020-07-12 02:07:29', 'slacombe@laposte.net', 'TRUE', NULL, 19),
(37, 'llenoir', 'Tu as vu une bouteille, que l\'on cachait à tous les hôtels de la chanteuse lui parut.', '2020-07-20 15:07:44', 'marc71@tele2.fr', 'TRUE', NULL, 25),
(46, 'morvan.victor', 'Puis elle remontait, fermait la porte, il entrait... Quelle étreinte! Puis les symptômes.', '2020-08-01 17:08:26', 'jlesage@voila.fr', 'TRUE', NULL, 4),
(48, 'anastasie88', 'L\'un portait des bas de la fenêtre, elle dit: «Ah! mon Dieu!» poussa un cri. Il ne faut.', '2020-07-22 00:07:52', 'marcel.letellier@orange.fr', 'TRUE', NULL, 23),
(49, 'noel.marin', 'À huit heures, Justin venait le baiser au front: -- Quelle réponse apporter à M. le.', '2020-07-30 17:07:10', 'hhumbert@bouygtel.fr', 'TRUE', NULL, 24),
(52, 'emaurice', 'Il répéta: -- D\'un autre! Et il la regardait, tout étonné par la côte d\'Argueil, à.', '2020-08-04 07:08:50', 'agodard@wanadoo.fr', 'TRUE', NULL, 19),
(55, 'pierre.pauline', 'Athalie qui la rendit presque intéressante. Naturellement, par nonchalance; il en.', '2020-07-14 01:07:25', 'sebastien.bodin@voila.fr', 'TRUE', NULL, 6),
(60, 'jcolas', 'Dodolphe..., je crois.» Elle frissonna. -- Tu reviendrais dimanche. Voyons, décide-toi!.', '2020-07-23 17:07:39', 'adele99@wanadoo.fr', 'TRUE', NULL, 6),
(61, 'laurence48', 'Ah! c\'est fini! il faudrait en faire l\'analyse. Car il allait d\'un groupe à l\'autre. On.', '2020-07-14 05:07:01', 'wgosselin@hotmail.fr', 'TRUE', NULL, 23),
(62, 'opires', 'Elle abandonna la musique. Elle se retrouvait dans les cours, où on le saurait? Mais.', '2020-07-26 13:07:52', 'jules84@gmail.com', 'TRUE', NULL, 10),
(63, 'francois28', 'Il la croyait heureuse; et elle entendit tout au fond de la pommade qui lustrait sa.', '2020-07-14 23:07:07', 'georges12@club-internet.fr', 'TRUE', NULL, 23),
(68, 'claude83', 'Charles, bouleversé, attendit patiemment le retour de sa bonne. Mais une rafale de vent.', '2020-07-31 08:07:23', 'hmarin@club-internet.fr', 'TRUE', NULL, 9),
(70, 'jean62', 'Comme il avait soigné les choses; et son existence affreuse! -- Est-ce possible! Ils ne.', '2020-07-11 02:07:58', 'alexandria26@tiscali.fr', 'TRUE', NULL, 23),
(71, 'wgarcia', 'Elle avait fait sonner si haut, rien, si ce geste hideux et doux des corbeaux, qui.', '2020-07-17 17:07:10', 'philippe.delattre@yahoo.fr', 'TRUE', NULL, 9),
(74, 'emilie67', 'À quoi songent nos édiles?» Puis Homais inventait des anecdotes: «Hier, dans la voiture.', '2020-08-04 05:08:21', 'nvincent@hotmail.fr', 'TRUE', NULL, 11),
(76, 'simon.suzanne', 'Les couteaux jamais n\'étaient affilés, ni les conseils du pharmacien, comme des souliers.', '2020-07-13 20:07:06', 'henri72@tiscali.fr', 'TRUE', NULL, 18),
(78, 'hugues82', 'Elle partirait d\'Yonville comme pour un tigre parmi ses souvenirs, il examinait les.', '2020-07-11 06:07:00', 'laine.agnes@tiscali.fr', 'TRUE', NULL, 19),
(194, 'Annabelle ', 'yuihje(rtsdhzrstdh', '2020-09-07 21:23:16', 'matanna@orange.fr', 'TRUE', 18, 147),
(195, 'Mathi', 'tfhnfxcnxdfc ', '2020-09-07 21:23:39', 'matanna@orange.fr', 'TRUE', 18, 147),
(196, 'administrator : Mat85', 'test', '2020-09-07 21:23:53', 'mathieu.bonhommeau@orange.fr', 'TRUE', 18, 147),
(197, 'Annabelle', 'ghjdfxgjsrtfgxc', '2020-09-07 21:36:21', 'matanna@orange.fr', 'TRUE', 18, 10),
(198, 'Annabelle ', 'test', '2020-09-07 21:36:54', 'matanna@orange.fr', 'TRUE', 18, 147),
(199, 'Annabelle Clemenceau', 'sdgfzesdw', '2020-09-07 21:37:45', 'matanna@orange.fr', 'TRUE', 18, 147),
(202, 'Annabelle Clemenceau', 'sgzsdgds', '2020-09-08 18:51:17', 'matanna@orange.fr', 'TRUE', 18, 146),
(204, 'Annabelle Clemenceau', 'fdsgsfdgbsdfxc', '2020-09-08 18:53:24', 'matanna@orange.fr', 'TRUE', 18, 146),
(205, 'Annabelle Clemenceau', 'fdsgsfdgbsdfxc', '2020-09-08 18:55:50', 'matanna@orange.fr', 'TRUE', 18, 146),
(206, 'Lilou445', 'un commentaire', '2020-09-08 18:56:21', 'matanna@orange.fr', 'TRUE', 18, 147),
(209, 'administrator : Mat85', 'un com de valid', '2020-09-08 19:39:31', 'mathieu.bonhommeau@orange.fr', 'TRUE', 18, 147),
(210, 'Mathieu Bonhommeau', 'fdhserdfhedf', '2020-09-09 23:42:32', 'mathieu.bonhommeau@orange.fr', 'TRUE', 18, 19),
(212, 'administrator : Mat85', 'Je le valide mais bon je suis pas content ', '2020-09-12 19:03:32', 'mathieu.bonhommeau@orange.fr', 'TRUE', 18, 130),
(216, 'Mat', '<p>balabla</p>', '2020-09-15 18:35:34', 'matanna@orange.fr', 'FALSE', 18, 130);

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
  `published` enum('TRUE','FALSE') NOT NULL DEFAULT 'FALSE',
  `user_id` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_post_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=154 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `post`
--

INSERT INTO `post` (`id`, `title`, `chapo`, `content`, `lastDateModif`, `picture`, `published`, `user_id`) VALUES
(2, 'La sécurité d\'innover sans soucis', 'Je voulais vous exprimer seulement, madame Lefrançois, à l\'hôtelière de la robe d\'Emma.', 'Aut numquam suscipit id et ea mollitia consequatur. Ipsa expedita culpa vitae est minus quia et explicabo. Reiciendis non nobis velit officia voluptatem corporis. Eum distinctio est tenetur velit quia vitae sed. Ab voluptate consectetur culpa alias. Quia nihil ipsa modi. Rem expedita aliquam praesentium modi. Animi consectetur ut sed ullam. Esse expedita expedita reprehenderit aut occaecati aut perferendis. Corporis qui reprehenderit rerum aspernatur unde. Sit laborum in quia dolor consequatur libero nisi veritatis. Incidunt aliquam autem sint ut error. Et repellat soluta maxime iure atque. Aliquid nihil maxime alias officia neque illo. Fugiat reprehenderit iusto earum ad officia nam numquam. Sit sequi eos quia molestiae vel.', '2020-05-12 06:31:21', '', 'TRUE', 5),
(4, 'La possibilité d\'atteindre vos buts de manière sûre', 'Barneville, près d\'Aumale, qui ne s\'effacerait pas. Ce fut dans sa chambre, on.', 'Inventore sint ad sed voluptas repellendus aspernatur delectus. Harum dolores omnis qui qui. Voluptatum ut autem ex nam voluptate assumenda. Quia labore nihil ut id maxime. Corrupti est alias sed. Est qui totam mollitia occaecati aliquid et quia. Vel laudantium consequatur saepe voluptas voluptas dignissimos odit molestiae. Architecto ad aut fugiat enim excepturi. Temporibus occaecati aut soluta rem non. Odit sed voluptatem sed rerum ex. Deleniti voluptates praesentium consequuntur quaerat voluptatem maiores facere. Est ea ab et odit. Doloremque quisquam voluptas expedita accusamus aut. In id rerum ad maiores architecto. Fugiat aut autem voluptatum quam amet qui. Incidunt quis fugit dolores sint. Soluta est quos et. Dolorum consectetur ipsum omnis sint.', '0000-00-00 00:00:00', '', 'TRUE', 4),
(6, 'Le confort de concrétiser vos projets sans soucis', 'Nous tiendrons nos lecteurs au courant des découvertes. Il suivait le grand poêle de quoi ???', 'Occaecati quis eum qui fugiat aut aspernatur ipsa. Porro dolores et similique assumenda. Ad qui architecto ut dolorem quae. Ut autem et a enim adipisci consequatur recusandae. Dolor incidunt incidunt quisquam doloremque. Repudiandae impedit suscipit ad ipsam. Rerum sunt minus ut. Tenetur voluptatem accusantium nostrum modi. Facilis quod ab sint ipsum assumenda est deserunt. Officiis sint earum autem voluptatem molestiae et ut expedita. Nulla assumenda ipsam temporibus rerum eum sint non. Veritatis provident voluptates quaerat est animi non ut. Aut veritatis in doloribus cumque suscipit nemo nesciunt. Perferendis voluptatem harum magni atque.', '2020-09-14 21:08:41', '', 'FALSE', 5),
(9, 'Le plaisir de changer à sa source', 'M. Rouault était bien fatigué, s\'étendre de ses amis, à son goulot; un Mathieu Laensberg.', 'Eius voluptatum exercitationem ut perspiciatis fuga fuga. Qui nemo molestiae dolorum omnis. Voluptate inventore veniam est rerum deserunt et sit. Aut aperiam qui voluptatibus eaque excepturi. Eum aut quo ad asperiores quo. Magnam velit ex voluptatibus perspiciatis ut. Possimus aut laudantium officiis et quia molestiae incidunt. Est omnis quidem velit in consequatur consequatur omnis eos. Mollitia soluta natus ea illo qui et praesentium. Commodi velit sed aliquam aliquid commodi facilis tenetur. Molestiae dolor reiciendis voluptas itaque est corporis nihil. Esse ut iusto cupiditate dolorum dicta. Iure quisquam doloribus qui et. Qui optio quaerat quia optio omnis. Nisi facilis est ducimus qui exercitationem laborum. Error aut blanditiis qui ipsa.', '2020-09-05 19:59:08', '', 'TRUE', 5),
(10, 'La sécurité de changer autrement', 'Elle entendait le battement de coeur et se tourna vite en lui tournant les talons. Dès.', 'Velit fuga dolorum fuga. Quia illo occaecati at vel. Dolor quasi qui modi sapiente magni in accusamus ut. Cum ut nostrum vitae voluptas est. Molestiae excepturi voluptas qui minus et velit sunt nulla. Non est nam recusandae velit suscipit modi quaerat. Corrupti veniam aut atque quasi. Id sit id ipsum est omnis. Sit incidunt eveniet quisquam. Voluptatem corporis sint consequatur est iure. Et laboriosam quidem soluta libero veritatis aut facere. Eius porro maxime nisi soluta. Ut illo tempore quis eum. Neque praesentium vero blanditiis nesciunt commodi. Ad nulla pariatur incidunt placeat et quod commodi. Ab est et amet autem. Itaque consequatur quibusdam ut velit numquam et non. Laudantium et nihil necessitatibus iure repellat sint eligendi. Ut architecto aperiam quis explicabo cum.', '2020-09-10 23:28:10', '1599597864.jpg', 'TRUE', 15),
(11, 'PHP 8 : Quoi de neuf ?', 'Que va nous apporter la nouvelle version de PHP 8 ? On en parle tout de suite :', 'Eos vel illo ipsam aspernatur est tempore culpa magnam. Aspernatur earum minima voluptatem ea ut. A molestiae occaecati vel voluptas sit. Inventore ullam nesciunt sed atque exercitationem ducimus quia. Earum assumenda qui dolore deserunt deserunt ut ipsa aliquam. Dolorum quis fugit deserunt qui voluptatem ut. Mollitia inventore aut nihil nisi laboriosam error officiis. Officia officiis consequuntur quo quis sapiente nemo nobis. Doloremque aut quae est est corrupti voluptatum dolorum. Aut natus quisquam molestiae dolorum aut commodi. Debitis molestiae nostrum rem ducimus a. Occaecati quaerat rerum nostrum ullam. Odio rerum maiores voluptatem velit similique provident animi. Veritatis officia voluptas qui enim iure error. Provident labore excepturi nemo veniam ea dolorem iste sed.\r\n\r\nEos vel illo ipsam aspernatur est tempore culpa magnam. Aspernatur earum minima voluptatem ea ut. A molestiae occaecati vel voluptas sit. Inventore ullam nesciunt sed atque exercitationem ducimus quia. Earum assumenda qui dolore deserunt deserunt ut ipsa aliquam. Dolorum quis fugit deserunt qui voluptatem ut. Mollitia inventore aut nihil nisi laboriosam error officiis. Officia officiis consequuntur quo quis sapiente nemo nobis. Doloremque aut quae est est corrupti voluptatum dolorum. Aut natus quisquam molestiae dolorum aut commodi. Debitis molestiae nostrum rem ducimus a. Occaecati quaerat rerum nostrum ullam. Odio rerum maiores voluptatem velit similique provident animi. Veritatis officia voluptas qui enim iure error. Provident labore excepturi nemo veniam ea dolorem iste sed.\r\n Mollitia inventore aut nihil nisi laboriosam error officiis. Officia officiis consequuntur quo quis sapiente nemo nobis. Doloremque aut quae est est corrupti voluptatum dolorum. Aut natus quisquam molestiae dolorum aut commodi. Debitis molestiae nostrum rem ducimus a. Occaecati quaerat rerum nostrum ullam. Odio rerum maiores voluptatem velit similique provident animi. Veritatis officia voluptas qui enim iure error. Provident labore excepturi nemo veniam ea dolorem iste sed.', '2020-09-11 06:45:45', '1599799545.jpg', 'TRUE', 18),
(12, 'La simplicité de concrétiser vos projets naturellement', 'La rivière livide frissonnait au vent; il n\'y resta que deux ou trois cabaretiers, le.', 'Et rerum corporis magnam enim omnis ea dolores. Nemo officiis quae magnam consequatur. Voluptatem reiciendis inventore quibusdam. Sit et dolor fuga itaque molestiae. Repellat sed rerum aut. Vel id voluptatem beatae odit. Reiciendis enim tempora quaerat eius et veritatis ducimus. Expedita unde expedita dignissimos perferendis vel. Quae saepe voluptatum officia et. Fugiat sapiente consequatur officiis laborum earum possimus. Qui delectus porro voluptatem sunt aut. Inventore quibusdam ex voluptatibus eum. Iure facilis incidunt consectetur recusandae saepe. Aut non tempore reiciendis animi. Fugiat officia et hic. Laborum ut unde repellat veritatis sint libero. Saepe libero placeat unde non vel quisquam. Dolores esse amet quia ea. Qui cupiditate quis aut porro.', '2020-09-05 20:52:28', '', 'TRUE', 5),
(16, 'L\'assurance de changer plus simplement', 'Pologne ou les Conférences de l\'abbé Frayssinous, et, le soir, malgré leur indépendance.', 'Aut aut aut iste provident sunt ut laboriosam. Ipsum et perspiciatis quibusdam odio. Delectus optio doloremque dolore magnam nihil. Sapiente mollitia cum laudantium. Eum corrupti nobis expedita aut. Sunt velit soluta sequi fugit tenetur laudantium. Eos ut non id. Commodi id eum adipisci aut. Non fuga incidunt quas ut provident fuga. Aperiam totam perspiciatis ea dolor placeat quae iusto. Omnis dolorem eligendi voluptatem. Voluptatem sunt odit reprehenderit vero error. Commodi expedita sed placeat voluptates alias occaecati sunt. Voluptates provident exercitationem neque ut. Harum ea autem dicta voluptas aut. Autem quod dolorem est est necessitatibus blanditiis sunt. Rem eum ipsam aspernatur alias cumque.', '2020-08-23 16:55:45', '', 'TRUE', 4),
(18, 'L\'avantage d\'atteindre vos buts de manière sûre', 'Girard, que j\'ai promenée l\'autre jour. Ils sont venus un tas de farceurs qui se tourne.', 'Quo eveniet vel cumque excepturi consequatur. Dignissimos culpa officia praesentium non eos. Dolorum veritatis voluptate et similique nulla. Ex in ipsa voluptatum aut. Quasi qui consequatur et et suscipit aperiam. Autem nulla quis doloribus corporis. Possimus iure aperiam corporis optio numquam. Recusandae non quo tempore ut ducimus qui doloremque. Praesentium nobis blanditiis mollitia nemo omnis aut veritatis. Aut consequatur officia adipisci cupiditate. Odio placeat qui eveniet. Consequatur quaerat similique consectetur at deserunt porro ut. Esse explicabo tenetur id omnis et. Accusantium ratione nostrum et et. Excepturi aut quis esse iste.', '2020-08-26 19:49:01', '', 'TRUE', 4),
(19, 'L\'assurance de rouler naturellement', 'Il n\'y a rien! -- Rassurez-vous, dit l\'apothicaire, la vue de ce qui passait pour gagner.', 'Quia rem eos voluptates est perspiciatis. Non perferendis deleniti quia ut et impedit. Quia esse eveniet facilis iste molestiae consequatur quo. Non ex fugit voluptas. Iste similique quo quia fugit. Laborum aspernatur corrupti vitae doloremque quas. Rem ut est atque. Nesciunt dolore delectus qui natus quae nihil tempore. Et aliquid officiis voluptas exercitationem pariatur. Eum et placeat soluta error aut. Veniam hic ratione ipsam saepe quia voluptatem ut. Itaque expedita facilis minima quasi veritatis quod consequatur. Consectetur ut aliquam facere ut fugiat quod ut qui. Eum reiciendis consequatur voluptas est quam. Quis et hic et. Et illum aspernatur sed. Beatae laborum et magni molestiae.', '2020-09-14 21:11:27', '1600110666.jpg', 'TRUE', 15),
(21, 'Le pouvoir de changer avant-tout', 'Beauvoisine. C\'était une femme battue, dont aussitôt il s\'ouvrait dans son cabinet, prit.', 'Eos dolorem deserunt deleniti. Veniam ut at consequatur quia consequatur voluptas dolorem culpa. Provident odit eos atque quaerat tempora enim non. In accusamus et voluptas accusantium deserunt. Molestiae quidem enim animi quis eum rerum. Quibusdam quaerat vero et at. Accusamus perspiciatis quia officia ex veritatis qui quis. Et natus quis quibusdam minus. Consequatur ut voluptatum est reprehenderit laudantium tempore quasi. Illo dolores impedit iusto. Adipisci omnis et est consequuntur consequuntur. Animi dolorum consequatur unde necessitatibus aut et autem. Voluptas illo voluptatem enim voluptas eveniet. Dolorum voluptates magni distinctio unde ut perspiciatis consequatur. Quis autem dignissimos autem explicabo mollitia. Ea velit illo et totam dignissimos nobis velit.', '2020-08-23 16:57:00', '', 'TRUE', 5),
(22, 'Le confort d\'atteindre vos buts en toute sécurité', 'Eh bien, fit Rodolphe en offrit un; elle refusa ses offres; il n\'insista pas; puis, au.', 'Eius repellat aut tempore qui animi nesciunt qui. Exercitationem eum eligendi recusandae sed officia mollitia. Beatae labore delectus iste illo. Quaerat consequatur fuga laboriosam est reprehenderit. Architecto debitis sed officia doloribus expedita nobis nulla provident. Non ratione consequatur dolorem molestias quia. Eligendi voluptates qui autem quo distinctio eius tempora. Animi ut suscipit nam optio est neque. Sapiente facilis et nihil rerum et est reiciendis. Non laborum harum ut ipsam earum repellat qui. Amet aliquid non dolorem eum asperiores aut. Quisquam labore quia quia minima tempora nesciunt quibusdam. Ut amet voluptatem neque. Ut omnis numquam unde fugiat voluptatum nulla.', '2020-09-05 18:11:28', '', 'TRUE', 5),
(23, 'La simplicité de changer avant-tout', 'C\'est ainsi que, mardi, notre petite cité d\'Yonville s\'est vue le théâtre d\'une.', 'Ut quam accusamus qui tempora accusantium. Voluptatem omnis autem ea perspiciatis sint. Est et optio doloremque placeat non dolor excepturi. Est voluptatum sapiente sit maiores cupiditate doloremque. Ab autem distinctio aut vero. Nesciunt maiores consequuntur est iusto qui. Amet amet possimus quia est id. Quisquam rerum quia velit ipsa. Et nobis dignissimos enim id. Perferendis tenetur qui itaque minus. Ipsum nostrum assumenda minima consequatur. Possimus accusamus sequi sint aspernatur necessitatibus. Quibusdam eos at vitae dolorem est. Minima ut officia et nobis nulla aut sint. Ut eos laudantium dicta at aliquid. Ea nulla non aut reprehenderit. Facere nemo sunt rem sed eveniet aspernatur. Minus dolorem cupiditate quis dolorum.', '2020-09-05 21:35:01', '1599334501.jpg', 'TRUE', 4),
(24, 'Le confort d\'atteindre vos buts en toute sécurité', 'Eh bien, fit Rodolphe en offrit un; elle refusa ses offres; il n\'insista pas; puis, au.', 'Eius repellat aut tempore qui animi nesciunt qui. Exercitationem eum eligendi recusandae sed officia mollitia. Beatae labore delectus iste illo. Quaerat consequatur fuga laboriosam est reprehenderit. Architecto debitis sed officia doloribus expedita nobis nulla provident. Non ratione consequatur dolorem molestias quia. Eligendi voluptates qui autem quo distinctio eius tempora. Animi ut suscipit nam optio est neque. Sapiente facilis et nihil rerum et est reiciendis. Non laborum harum ut ipsam earum repellat qui. Amet aliquid non dolorem eum asperiores aut. Quisquam labore quia quia minima tempora nesciunt quibusdam. Ut amet voluptatem neque. Ut omnis numquam unde fugiat voluptatum nulla.', '2020-09-05 20:15:54', '1599329754.jpg', 'TRUE', 5),
(25, 'La liberté d\'atteindre vos buts en toute tranquilité', 'Allons, ne vous l\'a pas volée! Tout reprit son calme. Les têtes se courbèrent sur les.', 'Facilis modi doloribus quia rerum quidem magnam. Veniam quod maiores molestiae autem quae. Nisi modi animi nisi omnis a est minus. Quas fugiat soluta consectetur quia. Incidunt ut at non laudantium cupiditate ullam. Sequi sequi rem repellat odit quisquam. Et mollitia quo autem quia nulla error. Earum labore tempora ipsum maxime suscipit. Nisi delectus iusto rerum molestiae reiciendis harum. Quia suscipit culpa sed magni commodi dolores illo. Ut tempora nostrum nemo et non. Repellendus ipsum voluptate reiciendis. Et sed animi aut optio id et. Eveniet molestiae non illum beatae est. Laudantium est eveniet recusandae labore autem quia exercitationem. Ut quo rerum sed voluptas est voluptatem. Dolores et ullam non possimus veritatis. Id voluptas vel ullam cum veniam dolorem deserunt.', '2020-09-07 22:32:38', '1599337256.jpg', 'TRUE', 15),
(117, 'Je pense que ca marche vraiment', 'C\'EST COOL', 'Après 2 jours de labeur avec ces putains d\'images .....', '2020-08-29 16:11:06', '1598710266.jpg', 'TRUE', 18),
(124, 'Premier ajout de post', 'ezg-ryf\'z(rths', '\'rh(ègtu\"\'zrhst ca marche', '2020-09-07 22:33:07', '', 'TRUE', 11),
(130, 'Le plaisir de changer à sa source', 'M. Rouault était bien fatigué, s\'étendre de ses amis, à son goulot; un Mathieu Laensberg.', 'Eius voluptatum exercitationem ut perspiciatis fuga fuga. Qui nemo molestiae dolorum omnis. Voluptate inventore veniam est rerum deserunt et sit. Aut aperiam qui voluptatibus eaque excepturi. Eum aut quo ad asperiores quo. Magnam velit ex voluptatibus perspiciatis ut. Possimus aut laudantium officiis et quia molestiae incidunt. Est omnis quidem velit in consequatur consequatur omnis eos. Mollitia soluta natus ea illo qui et praesentium. Commodi velit sed aliquam aliquid commodi facilis tenetur. Molestiae dolor reiciendis voluptas itaque est corporis nihil. Esse ut iusto cupiditate dolorum dicta. Iure quisquam doloribus qui et. Qui optio quaerat quia optio omnis. Nisi facilis est ducimus qui exercitationem laborum. Error aut blanditiis qui ipsa.', '2020-09-11 06:45:24', '1599799524.jpg', 'TRUE', 11),
(131, 'La liberté d\'atteindre vos buts en toute tranquilité ppppppppp', 'Allons, ne vous l\'a pas volée! Tout reprit son calme. Les têtes se courbèrent sur les.', 'Facilis modi doloribus quia rerum quidem magnam. Veniam quod maiores molestiae autem quae. Nisi modi animi nisi omnis a est minus. Quas fugiat soluta consectetur quia. Incidunt ut at non laudantium cupiditate ullam. Sequi sequi rem repellat odit quisquam. Et mollitia quo autem quia nulla error. Earum labore tempora ipsum maxime suscipit. Nisi delectus iusto rerum molestiae reiciendis harum. Quia suscipit culpa sed magni commodi dolores illo. Ut tempora nostrum nemo et non. Repellendus ipsum voluptate reiciendis. Et sed animi aut optio id et. Eveniet molestiae non illum beatae est. Laudantium est eveniet recusandae labore autem quia exercitationem. Ut quo rerum sed voluptas est voluptatem. Dolores et ullam non possimus veritatis. Id voluptas vel ullam cum veniam dolorem deserunt.', '2020-08-29 15:53:22', '', 'TRUE', 11),
(132, 'Le plaisir de changer à sa source', 'M. Rouault était bien fatigué, s\'étendre de ses amis, à son goulot; un Mathieu Laensberg.', 'Eius voluptatum exercitationem ut perspiciatis fuga fuga. Qui nemo molestiae dolorum omnis. Voluptate inventore veniam est rerum deserunt et sit. Aut aperiam qui voluptatibus eaque excepturi. Eum aut quo ad asperiores quo. Magnam velit ex voluptatibus perspiciatis ut. Possimus aut laudantium officiis et quia molestiae incidunt. Est omnis quidem velit in consequatur consequatur omnis eos. Mollitia soluta natus ea illo qui et praesentium. Commodi velit sed aliquam aliquid commodi facilis tenetur. Molestiae dolor reiciendis voluptas itaque est corporis nihil. Esse ut iusto cupiditate dolorum dicta. Iure quisquam doloribus qui et. Qui optio quaerat quia optio omnis. Nisi facilis est ducimus qui exercitationem laborum. Error aut blanditiis qui ipsa.', '2020-08-29 15:46:11', '', 'TRUE', 11),
(133, 'L\'assurance de changer plus simplement', 'Pologne ou les Conférences de l\'abbé Frayssinous, et, le soir, malgré leur indépendance.', 'Aut aut aut iste provident sunt ut laboriosam. Ipsum et perspiciatis quibusdam odio. Delectus optio doloremque dolore magnam nihil. Sapiente mollitia cum laudantium. Eum corrupti nobis expedita aut. Sunt velit soluta sequi fugit tenetur laudantium. Eos ut non id. Commodi id eum adipisci aut. Non fuga incidunt quas ut provident fuga. Aperiam totam perspiciatis ea dolor placeat quae iusto. Omnis dolorem eligendi voluptatem. Voluptatem sunt odit reprehenderit vero error. Commodi expedita sed placeat voluptates alias occaecati sunt. Voluptates provident exercitationem neque ut. Harum ea autem dicta voluptas aut. Autem quod dolorem est est necessitatibus blanditiis sunt. Rem eum ipsam aspernatur alias cumque.', '2020-09-09 21:31:13', '1599679873.jpg', 'TRUE', 11),
(145, 'test ajout de post', 'rqgerqsgv', 'qerdfxgberqdfb', '2020-09-06 17:26:19', '', 'TRUE', 15),
(146, 'L\'assurance de rouler naturellement', 'Il n\'y a rien! -- Rassurez-vous, dit l\'apothicaire, la vue de ce qui passait pour gagner.', 'Quia rem eos voluptates est perspiciatis. Non perferendis deleniti quia ut et impedit. Quia esse eveniet facilis iste molestiae consequatur quo. Non ex fugit voluptas. Iste similique quo quia fugit. Laborum aspernatur corrupti vitae doloremque quas. Rem ut est atque. Nesciunt dolore delectus qui natus quae nihil tempore. Et aliquid officiis voluptas exercitationem pariatur. Eum et placeat soluta error aut. Veniam hic ratione ipsam saepe quia voluptatem ut. Itaque expedita facilis minima quasi veritatis quod consequatur. Consectetur ut aliquam facere ut fugiat quod ut qui. Eum reiciendis consequatur voluptas est quam. Quis et hic et. Et illum aspernatur sed. Beatae laborum et magni molestiae.', '2020-09-07 22:59:29', '1599506906.jpg', 'TRUE', 15),
(147, 'L\'assurance de rouler naturellement', 'Il n\'y a rien! -- Rassurez-vous, dit l\'apothicaire, la vue de ce qui passait pour gagner.', 'Quia rem eos voluptates est perspiciatis. Non perferendis deleniti quia ut et impedit. Quia esse eveniet facilis iste molestiae consequatur quo. Non ex fugit voluptas. Iste similique quo quia fugit. Laborum aspernatur corrupti vitae doloremque quas. Rem ut est atque. Nesciunt dolore delectus qui natus quae nihil tempore. Et aliquid officiis voluptas exercitationem pariatur. Eum et placeat soluta error aut. Veniam hic ratione ipsam saepe quia voluptatem ut. Itaque expedita facilis minima quasi veritatis quod consequatur. Consectetur ut aliquam facere ut fugiat quod ut qui. Eum reiciendis consequatur voluptas est quam. Quis et hic et. Et illum aspernatur sed. Beatae laborum et magni molestiae.', '2020-09-07 21:29:57', '1599506984.jpg', 'TRUE', 15),
(149, 'On fait un test', 'blabla', 'hhhhhhhhhhtttttttttttrrrrrrrrrrrrrrr', '2020-09-08 21:52:50', '1599594770.jpg', 'FALSE', 15);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'Hash in php',
  `userEmail` varchar(255) DEFAULT NULL,
  `profilPicture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `authorName` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `registerDate` timestamp NOT NULL,
  `userType_id` int(45) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `userName_unique` (`userName`),
  KEY `fk_memberType_id` (`userType_id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `userName`, `password`, `userEmail`, `profilPicture`, `authorName`, `registerDate`, `userType_id`) VALUES
(1, 'Bertrand', 'bphmIf7M', NULL, '', 'Benoît Payet-Leclerc', '2020-08-02 04:36:16', 5),
(2, 'Capucine', 'O^X,k-_EdZ~i>f`GZ1t', NULL, '', 'Tristan Roy', '2020-08-12 09:26:12', 6),
(3, '@Joseph458', 'M:q7Y=5', NULL, '', 'Hugues-Claude Hoareau', '2020-08-04 06:11:30', 5),
(4, 'Lucie', ';OQ>C%{<p-5ls;q[171=', NULL, '', 'Dorothée Lacombe', '2020-08-11 04:31:15', 5),
(5, 'Yves', '5#s3p]qN;L', NULL, '', 'Alex Ribeiro', '2020-08-17 05:40:55', 4),
(6, 'Claude', '._%O2;:;\"uH9R%l', NULL, '', 'Denis-Thibaut Renault', '2020-08-07 17:14:12', 6),
(7, 'Juliette', 'Q0VF|+H$!=}P3]@-', NULL, '', 'Gérard Mathieu', '2020-08-14 02:20:12', 6),
(10, 'Jérôme', 'BM1@e]?c=*P<q}`B', NULL, '', 'Frédérique Daniel-Couturier', '2020-08-10 22:00:00', 6),
(11, 'Sylvie', 'RBP#7Q0', NULL, '', 'Véronique de la Costa', '2020-08-20 02:30:44', 4),
(15, 'anna27', '$2y$10$pyIiVSnPmiZ.ZElubBObYOQ.UEesNjumbV2NiwOAoSqYsAby7ZcFu', 'matanna@orange.fr', '1599592669.jpg', 'Annabelle Cl', '2020-08-31 18:15:01', 5),
(18, 'Mat85', '$2y$10$weJh5l9NlnSC6yoxfXvTXug0IXkHuonDq.qDNGhz4EapYsJVGiH8O', 'mathieu.bonhommeau@orange.fr', '1599023519.jpg', 'Mathieu Bonhommeau', '2020-08-31 19:00:23', 4),
(21, 'Lilou85', '$2y$10$VaagR0mRGa6/kzBvNJu2vuZpyGYQoNzkzFPRcprMt8sCN871IAA9i', 'lilou85@free.fr', '1599339652.jpg', 'Lilou Dupont', '2020-08-31 19:03:24', 6),
(22, 'mya45team', '$2y$10$TesIxz/Gklre7huEYnzb0e5B5tNe0MdukKQE4hlSeDNAs8nayRdFC', 'mya45698@free.fr', '1599077681.png', 'Mya Dupuis', '2020-08-31 21:41:40', 6),
(26, 'dester85', '$2y$10$kS5d9.ZVKyxrhG7adzaUAeCkpJXBjnNWyih3HM70DSTOIfqpqTbfK', NULL, NULL, NULL, '2020-09-07 21:46:25', 6);

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
(4, 'administrator'),
(5, 'author'),
(6, 'moderator');

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
