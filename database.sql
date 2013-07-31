# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.1.36-community-log
# Server OS:                    Win32
# HeidiSQL version:             5.1.0.3545
# Date/time:                    2010-09-24 12:31:27
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for dgrid
DROP DATABASE IF EXISTS `dgrid`;
CREATE DATABASE IF NOT EXISTS `dgrid` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `dgrid`;


# Dumping structure for table dgrid.g_accounts
DROP TABLE IF EXISTS `g_accounts`;
CREATE TABLE IF NOT EXISTS `g_accounts` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `currency_id` int(25) unsigned NOT NULL,
  `user_id` int(25) unsigned NOT NULL,
  `amount` float unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

# Dumping data for table dgrid.g_accounts: 3 rows
/*!40000 ALTER TABLE `g_accounts` DISABLE KEYS */;
INSERT INTO `g_accounts` (`id`, `currency_id`, `user_id`, `amount`) VALUES
	(1, 1, 1, 841.13),
	(2, 1, 2, 25),
	(3, 1, 3, 25);
/*!40000 ALTER TABLE `g_accounts` ENABLE KEYS */;


# Dumping structure for table dgrid.g_alerts
DROP TABLE IF EXISTS `g_alerts`;
CREATE TABLE IF NOT EXISTS `g_alerts` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(25) unsigned NOT NULL,
  `read` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

# Dumping data for table dgrid.g_alerts: 0 rows
/*!40000 ALTER TABLE `g_alerts` DISABLE KEYS */;
/*!40000 ALTER TABLE `g_alerts` ENABLE KEYS */;


# Dumping structure for table dgrid.g_companies
DROP TABLE IF EXISTS `g_companies`;
CREATE TABLE IF NOT EXISTS `g_companies` (
  `id` int(50) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL,
  `industry` varchar(25) NOT NULL,
  `region_id` int(50) unsigned NOT NULL,
  `owner_id` int(50) unsigned NOT NULL,
  `level` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `stock` float NOT NULL DEFAULT '0',
  `rm_stock` float NOT NULL DEFAULT '0' COMMENT 'Producer skill only: Used to store available RM.',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table dgrid.g_companies: 1 rows
/*!40000 ALTER TABLE `g_companies` DISABLE KEYS */;
INSERT INTO `g_companies` (`id`, `name`, `industry`, `region_id`, `owner_id`, `level`, `stock`, `rm_stock`) VALUES
	(1, 'Awesome Bread', 'food', 1, 1, 1, 385.892, 2339.32);
/*!40000 ALTER TABLE `g_companies` ENABLE KEYS */;


# Dumping structure for table dgrid.g_company_accounts
DROP TABLE IF EXISTS `g_company_accounts`;
CREATE TABLE IF NOT EXISTS `g_company_accounts` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(25) unsigned NOT NULL DEFAULT '0',
  `currency_id` int(25) unsigned NOT NULL DEFAULT '0',
  `amount` float unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table dgrid.g_company_accounts: 1 rows
/*!40000 ALTER TABLE `g_company_accounts` DISABLE KEYS */;
INSERT INTO `g_company_accounts` (`id`, `company_id`, `currency_id`, `amount`) VALUES
	(1, 1, 1, 51304.5);
/*!40000 ALTER TABLE `g_company_accounts` ENABLE KEYS */;


# Dumping structure for table dgrid.g_congresses
DROP TABLE IF EXISTS `g_congresses`;
CREATE TABLE IF NOT EXISTS `g_congresses` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(25) unsigned NOT NULL,
  `created_on` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

# Dumping data for table dgrid.g_congresses: 2 rows
/*!40000 ALTER TABLE `g_congresses` DISABLE KEYS */;
INSERT INTO `g_congresses` (`id`, `country_id`, `created_on`) VALUES
	(1, 1, '2010-08-08'),
	(2, 2, '2010-08-28');
/*!40000 ALTER TABLE `g_congresses` ENABLE KEYS */;


# Dumping structure for table dgrid.g_countries
DROP TABLE IF EXISTS `g_countries`;
CREATE TABLE IF NOT EXISTS `g_countries` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `short_name` varchar(5) NOT NULL COMMENT 'two-letter country code',
  `long_name` varchar(55) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'english country name.',
  `president_id` int(25) unsigned NOT NULL COMMENT 'country hasOne president (user) alias',
  `congress_id` int(25) unsigned NOT NULL COMMENT 'country hasOne congress (set)',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

# Dumping data for table dgrid.g_countries: 2 rows
/*!40000 ALTER TABLE `g_countries` DISABLE KEYS */;
INSERT INTO `g_countries` (`id`, `short_name`, `long_name`, `president_id`, `congress_id`) VALUES
	(1, 'us', 'USA', 1, 1),
	(2, 'ca', 'Canada', 0, 2);
/*!40000 ALTER TABLE `g_countries` ENABLE KEYS */;


# Dumping structure for table dgrid.g_currencies
DROP TABLE IF EXISTS `g_currencies`;
CREATE TABLE IF NOT EXISTS `g_currencies` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(25) unsigned NOT NULL,
  `name` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

# Dumping data for table dgrid.g_currencies: 2 rows
/*!40000 ALTER TABLE `g_currencies` DISABLE KEYS */;
INSERT INTO `g_currencies` (`id`, `country_id`, `name`) VALUES
	(1, 1, 'USD'),
	(2, 2, 'CAD');
/*!40000 ALTER TABLE `g_currencies` ENABLE KEYS */;


# Dumping structure for table dgrid.g_elections
DROP TABLE IF EXISTS `g_elections`;
CREATE TABLE IF NOT EXISTS `g_elections` (
  `id` int(50) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(50) unsigned DEFAULT NULL,
  `type` varchar(35) DEFAULT NULL,
  `extra_data` int(50) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

# Dumping data for table dgrid.g_elections: 3 rows
/*!40000 ALTER TABLE `g_elections` DISABLE KEYS */;
INSERT INTO `g_elections` (`id`, `country_id`, `type`, `extra_data`) VALUES
	(1, 1, 'party_president', 1),
	(2, 1, 'president', NULL),
	(3, 1, 'congress', 1);
/*!40000 ALTER TABLE `g_elections` ENABLE KEYS */;


# Dumping structure for table dgrid.g_employee_sets
DROP TABLE IF EXISTS `g_employee_sets`;
CREATE TABLE IF NOT EXISTS `g_employee_sets` (
  `id` int(50) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(50) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table dgrid.g_employee_sets: 1 rows
/*!40000 ALTER TABLE `g_employee_sets` DISABLE KEYS */;
INSERT INTO `g_employee_sets` (`id`, `company_id`) VALUES
	(1, 1);
/*!40000 ALTER TABLE `g_employee_sets` ENABLE KEYS */;


# Dumping structure for table dgrid.g_events
DROP TABLE IF EXISTS `g_events`;
CREATE TABLE IF NOT EXISTS `g_events` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `country_id` int(25) unsigned NOT NULL,
  `icon` varchar(128) NOT NULL DEFAULT 'fugue/information.png',
  `message` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

# Dumping data for table dgrid.g_events: 4 rows
/*!40000 ALTER TABLE `g_events` DISABLE KEYS */;
INSERT INTO `g_events` (`id`, `country_id`, `icon`, `message`, `date`) VALUES
	(1, 1, 'fugue/cake.png', 'The country <b>USA</b> has been created in the Grid.', '2010-09-08 19:44:01'),
	(2, 2, 'fugue/cake.png', 'The country <b>Canada</b> has been created in the Grid.', '2010-09-08 20:09:43'),
	(3, 0, 'fugue/information.png', 'The Grid has reached <b>Milestone 9</b>.', '2010-09-08 20:10:10'),
	(4, 0, 'fugue/information.png', 'The Grid has reached <b>Milestone 10!</b>', '2010-09-10 16:50:22');
/*!40000 ALTER TABLE `g_events` ENABLE KEYS */;


# Dumping structure for table dgrid.g_inventories
DROP TABLE IF EXISTS `g_inventories`;
CREATE TABLE IF NOT EXISTS `g_inventories` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(25) unsigned NOT NULL,
  `inventory_data` mediumtext NOT NULL COMMENT 'serialized array of the contained contents',
  `inventory_max_size` int(15) NOT NULL DEFAULT '25',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

# Dumping data for table dgrid.g_inventories: 3 rows
/*!40000 ALTER TABLE `g_inventories` DISABLE KEYS */;
INSERT INTO `g_inventories` (`id`, `user_id`, `inventory_data`, `inventory_max_size`) VALUES
	(1, 1, 'a:4:{i:5;s:7:"q2_food";i:6;s:7:"q3_food";i:7;s:7:"q4_food";i:11;s:8:"q5_house";}', 25),
	(2, 2, 'a:0:{}', 25),
	(3, 3, 'a:0:{}', 25);
/*!40000 ALTER TABLE `g_inventories` ENABLE KEYS */;


# Dumping structure for table dgrid.g_newspapers
DROP TABLE IF EXISTS `g_newspapers`;
CREATE TABLE IF NOT EXISTS `g_newspapers` (
  `id` int(50) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(50) unsigned NOT NULL,
  `country_id` int(50) unsigned NOT NULL,
  `name` varchar(128) NOT NULL,
  `trustseal` tinyint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

# Dumping data for table dgrid.g_newspapers: 1 rows
/*!40000 ALTER TABLE `g_newspapers` DISABLE KEYS */;
INSERT INTO `g_newspapers` (`id`, `user_id`, `country_id`, `name`, `trustseal`) VALUES
	(1, 1, 1, 'Grid Updates and Rants', 1);
/*!40000 ALTER TABLE `g_newspapers` ENABLE KEYS */;


# Dumping structure for table dgrid.g_newspaper_articles
DROP TABLE IF EXISTS `g_newspaper_articles`;
CREATE TABLE IF NOT EXISTS `g_newspaper_articles` (
  `id` int(50) unsigned NOT NULL AUTO_INCREMENT,
  `newspaper_id` int(50) unsigned NOT NULL,
  `title` varchar(128) NOT NULL,
  `content` longtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `votes` int(35) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

# Dumping data for table dgrid.g_newspaper_articles: 1 rows
/*!40000 ALTER TABLE `g_newspaper_articles` DISABLE KEYS */;
INSERT INTO `g_newspaper_articles` (`id`, `newspaper_id`, `title`, `content`, `date`, `votes`) VALUES
	(3, 1, 'The Road to Milestone 9', 'Hello to anyone who\'s reading this article! :)\r\n\r\nIf you have noticed, the Grid has reached Milestone 9, which is a significant step forward from the previous version.\r\n\r\n[b]1. Newspaper System[/b] The newspaper system allows each user to express his/her own opinion and show it to the public. To start a newspaper, it will cost you 2 PLT (Short for Platinum). Since 25 is provided to the user from the start, this is a very fair price.\r\n\r\nThe newspaper system also includes Commenting, Voting (Rating) and other little features you should check out. Try it out! (but finish reading this article first).\r\n\r\n[b]2. Time Management[/b] The Working system is almost complete and you will see a lot of updates which will put the economic system together. Note that the Marketplace will only be completed sometime around Milestone 10 and 11, therefore it will still take a while.\r\n\r\nThe Company view brings you a very interesting feature, which is the boosters system. This probably is familiar to users that already play games like this, but nevertheless, it\'s still very interesting and useful - specially, for example, you want a sudden skill or experience boost.\r\n\r\n\r\nI\'d like to point out that the Public Beta will start on September 31st. Note that the registrations will be open to the public anyway, but it\'s pretty internal as the site hasn\'t been spread yet. Before September 31st, a lot of features might be broken, so please remember to tell me if you find any problems.\r\n\r\nNote that to thank the people who have participated in the Grid before September 31st, on that day, these people will receive a 200 platinum bonus, and a special award in the user profile.\r\n\r\nAlso, this is my want-to-be bird\'s eye view for when we hit Milestone 10:\r\n[b]Community Forums.[/b] I have been delaying the forum system for a long time already. I just don\'t feel it\'s very urgent, but it\'s pretty essential for bug reporting, suggestions, etc. Therefore, I plan to implement this before M10 comes up.\r\n\r\n[b]Elections.[/b] This is pretty urgent too, but since due to the lack of test users, I delayed it. Since we have to have working congress sets/president seats for each country, we will need lots of people to assign the first month manually and then the elections system will work. So, contact me to grab a presidential seat/congress seat so that we can get the first month working.\r\n\r\nI think that\'s all, but expect more things to come before 31st. Happy playing!\r\n\r\nJimmie Lin, Dimension.Grid Lead Developer', '2010-08-28 21:08:38', 4);
/*!40000 ALTER TABLE `g_newspaper_articles` ENABLE KEYS */;


# Dumping structure for table dgrid.g_newspaper_comments
DROP TABLE IF EXISTS `g_newspaper_comments`;
CREATE TABLE IF NOT EXISTS `g_newspaper_comments` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `newspaper_article_id` int(25) unsigned NOT NULL,
  `user_id` int(25) unsigned NOT NULL,
  `content` mediumtext NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table dgrid.g_newspaper_comments: 1 rows
/*!40000 ALTER TABLE `g_newspaper_comments` DISABLE KEYS */;
INSERT INTO `g_newspaper_comments` (`id`, `newspaper_article_id`, `user_id`, `content`, `date`) VALUES
	(1, 3, 1, 'A test message... For this.\r\n\r\nSo, this is a really good [b]comment[/b] just for a test.\r\n<b>proof that html does not work here (otherwise this should be bold)</b>\r\n\r\n<i>this is also html [i]but this is bbcode[/i] test </i>\r\n\r\n<script>alert(\'xss test\');</script>', '2010-09-07 20:21:00');
/*!40000 ALTER TABLE `g_newspaper_comments` ENABLE KEYS */;


# Dumping structure for table dgrid.g_parties
DROP TABLE IF EXISTS `g_parties`;
CREATE TABLE IF NOT EXISTS `g_parties` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `founder_id` int(25) unsigned NOT NULL,
  `leader_id` int(25) unsigned NOT NULL,
  `last_leader_change` date NOT NULL,
  `found_date` date NOT NULL,
  `country_id` int(25) unsigned NOT NULL,
  `party_desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

# Dumping data for table dgrid.g_parties: 1 rows
/*!40000 ALTER TABLE `g_parties` DISABLE KEYS */;
INSERT INTO `g_parties` (`id`, `name`, `founder_id`, `leader_id`, `last_leader_change`, `found_date`, `country_id`, `party_desc`) VALUES
	(1, 'United Independents Party', 1, 1, '2010-08-09', '2010-08-08', 1, '[b]Welcome to the UIP![/b]\r\nThis party was temporarily taken over by the administrators in order to become a test party.');
/*!40000 ALTER TABLE `g_parties` ENABLE KEYS */;


# Dumping structure for table dgrid.g_regions
DROP TABLE IF EXISTS `g_regions`;
CREATE TABLE IF NOT EXISTS `g_regions` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(55) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'english name',
  `original_id` int(25) unsigned NOT NULL COMMENT 'original owner country',
  `owner_id` int(25) unsigned NOT NULL COMMENT 'current owner / occupier country id',
  `zone_id` int(25) unsigned NOT NULL COMMENT 'zone (location) ID',
  `defense_level` int(5) unsigned NOT NULL DEFAULT '0',
  `hospital_level` int(5) unsigned NOT NULL DEFAULT '0',
  `titanium_level` int(2) unsigned NOT NULL DEFAULT '0' COMMENT '0=none, 1=low, 2=medium, 3=high, 4=very high',
  `wood_level` int(2) unsigned NOT NULL DEFAULT '0',
  `grain_level` int(2) unsigned NOT NULL DEFAULT '0',
  `oil_level` int(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

# Dumping data for table dgrid.g_regions: 17 rows
/*!40000 ALTER TABLE `g_regions` DISABLE KEYS */;
INSERT INTO `g_regions` (`id`, `name`, `original_id`, `owner_id`, `zone_id`, `defense_level`, `hospital_level`, `titanium_level`, `wood_level`, `grain_level`, `oil_level`) VALUES
	(1, 'Florida', 1, 1, 1, 5, 5, 0, 2, 2, 0),
	(2, 'Maryland', 1, 1, 1, 2, 0, 0, 3, 1, 0),
	(3, 'California', 1, 1, 1, 0, 0, 0, 4, 2, 3),
	(4, 'Nebraska', 1, 1, 1, 0, 0, 0, 2, 4, 0),
	(5, 'Newfoundland', 2, 2, 1, 0, 0, 1, 2, 1, 4),
	(6, 'Prince Edward Island', 2, 2, 1, 0, 0, 1, 2, 2, 1),
	(7, 'New Brunswick', 2, 2, 1, 0, 0, 1, 1, 1, 1),
	(8, 'Nova Scotia', 2, 2, 1, 0, 0, 1, 1, 1, 1),
	(9, 'Quebec', 2, 2, 1, 0, 0, 2, 1, 2, 0),
	(10, 'Ontario', 2, 2, 1, 0, 0, 1, 1, 2, 1),
	(11, 'Manitoba', 2, 2, 1, 0, 0, 0, 2, 3, 0),
	(12, 'Saskatchewan', 2, 2, 1, 0, 0, 0, 2, 2, 0),
	(13, 'Alberta', 2, 2, 1, 0, 0, 0, 2, 4, 0),
	(14, 'British Columbia', 2, 2, 1, 0, 0, 0, 4, 2, 0),
	(15, 'Northwest Territories', 2, 2, 1, 0, 0, 3, 0, 1, 3),
	(16, 'Yukon', 2, 2, 1, 0, 0, 3, 0, 2, 4),
	(17, 'Nunavut', 2, 2, 1, 0, 0, 2, 0, 2, 4);
/*!40000 ALTER TABLE `g_regions` ENABLE KEYS */;


# Dumping structure for table dgrid.g_sell_offers
DROP TABLE IF EXISTS `g_sell_offers`;
CREATE TABLE IF NOT EXISTS `g_sell_offers` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(25) unsigned NOT NULL,
  `industry` varchar(50) NOT NULL,
  `amount` int(25) unsigned NOT NULL,
  `country_id` int(25) unsigned NOT NULL,
  `price_per_unit` float unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table dgrid.g_sell_offers: 1 rows
/*!40000 ALTER TABLE `g_sell_offers` DISABLE KEYS */;
INSERT INTO `g_sell_offers` (`id`, `company_id`, `industry`, `amount`, `country_id`, `price_per_unit`) VALUES
	(1, 1, 'food', 255, 1, 0.48);
/*!40000 ALTER TABLE `g_sell_offers` ENABLE KEYS */;


# Dumping structure for table dgrid.g_shouts
DROP TABLE IF EXISTS `g_shouts`;
CREATE TABLE IF NOT EXISTS `g_shouts` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(25) unsigned NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` varchar(140) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table dgrid.g_shouts: 1 rows
/*!40000 ALTER TABLE `g_shouts` DISABLE KEYS */;
INSERT INTO `g_shouts` (`id`, `user_id`, `date`, `content`) VALUES
	(1, 1, '2010-09-02 18:17:13', 'This is the first shout ever in the Grid!');
/*!40000 ALTER TABLE `g_shouts` ENABLE KEYS */;


# Dumping structure for table dgrid.g_users
DROP TABLE IF EXISTS `g_users`;
CREATE TABLE IF NOT EXISTS `g_users` (
  `id` int(25) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(150) NOT NULL COMMENT 'sha1 hash',
  `joined` datetime NOT NULL,
  `platinum` float unsigned NOT NULL DEFAULT '0',
  `citizenship` int(25) unsigned NOT NULL,
  `region_id` int(25) unsigned NOT NULL,
  `party_id` int(25) unsigned NOT NULL DEFAULT '0',
  `harvester_skill` int(7) unsigned NOT NULL DEFAULT '0',
  `producer_skill` int(7) unsigned NOT NULL DEFAULT '0',
  `architect_skill` int(7) unsigned NOT NULL DEFAULT '0',
  `military_skill` int(7) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) NOT NULL,
  `health` int(5) unsigned NOT NULL DEFAULT '50',
  `congress_id` int(25) unsigned NOT NULL DEFAULT '0',
  `role` varchar(5) NOT NULL DEFAULT 'user',
  `ip` varchar(15) NOT NULL,
  `time_spent` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `employee_set_id` int(50) unsigned NOT NULL DEFAULT '0',
  `hourly_wage` float unsigned NOT NULL DEFAULT '0',
  `task_worked` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `work_result_data` varchar(3000) NOT NULL DEFAULT 'a:0:{}',
  `task_trained` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `train_result_data` varchar(3000) NOT NULL DEFAULT 'a:0:{}',
  `task_studied` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `study_result_data` varchar(3000) NOT NULL DEFAULT 'a:0:{}',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

# Dumping data for table dgrid.g_users: 3 rows
/*!40000 ALTER TABLE `g_users` DISABLE KEYS */;
INSERT INTO `g_users` (`id`, `username`, `password`, `joined`, `platinum`, `citizenship`, `region_id`, `party_id`, `harvester_skill`, `producer_skill`, `architect_skill`, `military_skill`, `email`, `health`, `congress_id`, `role`, `ip`, `time_spent`, `employee_set_id`, `hourly_wage`, `task_worked`, `work_result_data`, `task_trained`, `train_result_data`, `task_studied`, `study_result_data`) VALUES
	(1, 'Jimmie Lin', 'snip', '2010-08-06 00:00:00', 81.4, 1, 1, 1, 1506, 1199, 2133, 2638, 'jimmie.lin@gmail.com', 92, 0, 'admin', '127.0.0.1', 0, 1, 0.85, 0, 'a:4:{s:12:"productivity";d:11.2640000000000011226575225009582936763763427734375;s:5:"hours";i:8;s:7:"booster";s:13:"morningcoffee";s:9:"skillGain";d:2.02751999999999998891553332214243710041046142578125;}', 0, 'a:3:{s:12:"productivity";d:512;s:5:"hours";i:8;s:7:"booster";s:10:"finalparty";}', 0, 'a:3:{s:12:"productivity";d:96;s:5:"hours";i:4;s:7:"booster";s:12:"doityourself";}');
  
/*!40000 ALTER TABLE `g_users` ENABLE KEYS */;


# Dumping structure for table dgrid.g_votes
DROP TABLE IF EXISTS `g_votes`;
CREATE TABLE IF NOT EXISTS `g_votes` (
  `id` int(50) unsigned NOT NULL AUTO_INCREMENT,
  `election_id` int(50) unsigned DEFAULT NULL,
  `user_id` int(50) unsigned DEFAULT NULL,
  `votes` int(50) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

# Dumping data for table dgrid.g_votes: 1 rows
/*!40000 ALTER TABLE `g_votes` DISABLE KEYS */;
INSERT INTO `g_votes` (`id`, `election_id`, `user_id`, `votes`) VALUES
	(1, 1, 1, 25);
/*!40000 ALTER TABLE `g_votes` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
