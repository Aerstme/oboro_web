DROP TABLE IF EXISTS `mvpcards_count`;
CREATE TABLE `mvpcards_count` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nameid` int(11) NOT NULL DEFAULT '0',
  `card_name` varchar(30) NOT NULL DEFAULT 'null',
  `total` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `cp_nameslog`;
CREATE TABLE `cp_nameslog` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `old_name` varchar(30) NOT NULL DEFAULT '',
  `new_name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


DROP TABLE IF EXISTS `item_db`;
CREATE TABLE `item_db` (
  `id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `name_english` varchar(50) NOT NULL DEFAULT '',
  `name_japanese` varchar(50) NOT NULL DEFAULT '',
  `type` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `price_buy` mediumint(10) unsigned DEFAULT NULL,
  `price_sell` mediumint(10) unsigned DEFAULT NULL,
  `weight` smallint(5) unsigned NOT NULL DEFAULT '0',
  `attack` smallint(3) unsigned DEFAULT NULL,
  `defence` tinyint(3) unsigned DEFAULT NULL,
  `range` tinyint(2) unsigned DEFAULT NULL,
  `slots` tinyint(2) unsigned DEFAULT NULL,
  `equip_jobs` int(12) unsigned DEFAULT NULL,
  `equip_upper` tinyint(8) unsigned DEFAULT NULL,
  `equip_genders` tinyint(2) unsigned DEFAULT NULL,
  `equip_locations` smallint(4) unsigned DEFAULT NULL,
  `weapon_level` tinyint(2) unsigned DEFAULT NULL,
  `equip_level` tinyint(3) unsigned DEFAULT NULL,
  `refineable` tinyint(1) unsigned DEFAULT NULL,
  `view` smallint(3) unsigned DEFAULT NULL,
  `script` text,
  `equip_script` text,
  `unequip_script` text,
  `dona` int(11) NOT NULL DEFAULT '0',
  `description` varchar(1024) DEFAULT NULL,
  `dona_pack_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


-- Oboro just provide Harmony structure to make easier the work of the client installing harmony
ALTER TABLE `login` ADD COLUMN `last_mac` varchar(18) NOT NULL DEFAULT '';
ALTER TABLE `login` ADD COLUMN `BG_DLALLOW` varchar(1) NOT NULL DEFAULT '0';
ALTER TABLE `login` ADD COLUMN `pais` varchar(2) NOT NULL DEFAULT 'cr';
ALTER TABLE `login` ADD COLUMN `geo_localization` varchar(100) NULL;
ALTER TABLE `login` ADD COLUMN `question` INT(11) NULL;
ALTER TABLE `login` ADD COLUMN `question_response` VARCHAR(23) NULL;

ALTER TABLE `loginlog` ADD COLUMN `mac` varchar(18) NOT NULL DEFAULT '';


-- ----------------------------
-- Table structure for oboro_vote_points
-- ----------------------------
DROP TABLE IF EXISTS `oboro_vote_points`;
CREATE TABLE `oboro_vote_points` (
  `vote_id` int(11) NOT NULL,
  `date` datetime DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `panel_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`vote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `oboro_pvp` (
	`char_id` int(11) NOT NULL,
	`kill` int(11) NOT NULL DEFAULT 0,
	`dead` int(11) NOT NULL DEFAULT 0,
	PRIMARY KEY(`char_id`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `oboro_geo_localization_fail_log`;
CREATE TABLE `oboro_geo_localization_fail_log` (
	`id_log` int(11) AUTO_INCREMENT,
	`ip` varchar(20) NOT NULL,
	`userid` varchar(15) NOT NULL,
	`date` DATETIME,
	`zone` varchar(30),
	PRIMARY KEY (`id_log`)
)ENGINE=MyISAM;

CREATE TABLE `oboro_contable`(
	`transaction_id` int(11) NOT NULL AUTO_INCREMENT,
	`account_id` int(11) unsigned NOT NULL DEFAULT '0',
  `email` varchar(39) NOT NULL DEFAULT '',
	`usd`	int(11) NOT NULL DEFAULT 0,
	`points` int(11) NOT NULL DEFAULT 0,
	PRIMARY KEY(`transaction_id`)
);

CREATE TABLE `oboro_paypal_on_failure_ip`
(
	`consecutivo` INT AUTO_INCREMENT,
	`ipn_paypal_ip` VARCHAR(16) NULL DEFAULT '...',
	`account_id` INT(11),
	`transaction_id` INT(16),
	`email_player` VARCHAR(22),
	`money` INT(11),
	`date`	VARCHAR(25),
	PRIMARY KEY(`consecutivo`)
) ENGINE=MyISAM;

-- ----------------------------
-- Table structure for oboro_blog
-- ----------------------------
DROP TABLE IF EXISTS `oboro_blog`;
CREATE TABLE `oboro_blog` (
  `blog_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_create` date NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT 'Untitled',
  `text_html` longtext,
  `blog_class` tinyint(1) DEFAULT '0',
  `owner_id` int(11) NOT NULL,
  `owner_name` varchar(23) NOT NULL DEFAULT 'Server',
  `date_modify` date DEFAULT NULL,
  `href` varchar(255) DEFAULT NULL,
  `pinned` int(2) NOT NULL,
  PRIMARY KEY (`blog_id`,`owner_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
