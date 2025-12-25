<?php



$sqlArray[_DBPREFIX_ . 'site_articles'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_articles` (
  `articles_id` int(11) NOT NULL auto_increment,
  `group_id` int(4) NOT NULL default '0',
  `user_id` int(11) NOT NULL,
  `keysname` varchar(32) NOT NULL,
  `status` int(1) NOT NULL default '0',
  `add_time` int(11) NOT NULL,
  `end_time` int(11) NOT NULL default '0',
  `sorttime` int(11) NOT NULL,
  `preview` int(11) NOT NULL default '0',
  `displaytime` int(11) NOT NULL,
  `icon` varchar(125) NOT NULL,
  `icon2` varchar(125) NOT NULL,
  `file_attach` varchar(125) NOT NULL,
  `checkOption` int(2) NOT NULL,
  `extra1` varchar(255) NOT NULL,
  `extra2` varchar(255) NOT NULL,
  `extra3` varchar(255) NOT NULL,
  `extra4` varchar(255) NOT NULL,
  `extra5` varchar(255) NOT NULL,
  `extra6` varchar(255) NOT NULL,
  `extra7` varchar(255) NOT NULL,
  `extra8` varchar(255) NOT NULL,
  `extra9` varchar(255) NOT NULL,
  `extra10` varchar(255) NOT NULL,
  PRIMARY KEY  (`articles_id`),
  KEY `group_id` (`group_id`,`status`,`keysname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'site_articles_content'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_articles_content` (
  `content_id` int(11) NOT NULL auto_increment,
  `articles_id` int(11) NOT NULL,
  `langkeys` varchar(25) NOT NULL default 'th',
  `title` varchar(255) NOT NULL,
  `shortMessage` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `content`  MEDIUMTEXT NOT NULL,
  `author` varchar(255) NOT NULL,
  `content2`  MEDIUMTEXT NOT NULL,
  `content3` text NOT NULL,
  `content4` text NOT NULL,
  `contentAttach` varchar(255) NOT NULL,
  `content_icon` varchar(255) NOT NULL,
  `content_extra1` varchar(255) NOT NULL,
  `content_extra2` varchar(255) NOT NULL,
  `content_extra3` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY  (`content_id`),
  KEY `articles_id` (`articles_id`,`langkeys`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'site_articles_keys'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_articles_keys` (
  `kid` int(5) NOT NULL auto_increment,
  `kname` varchar(255) NOT NULL,
  `kicon` varchar(255) NOT NULL,
  `ksort` int(5) NOT NULL,
  `keysname` varchar(32) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY  (`kid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'site_articles_keysuse'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_articles_keysuse` (
  `kuid` int(4) NOT NULL auto_increment,
  `kid` int(5) NOT NULL,
  `articles_id` int(11) NOT NULL,
  PRIMARY KEY  (`kuid`),
  KEY `kid` (`kid`,`articles_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'site_articles_group'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_articles_group` (
  `group_id` int(4) NOT NULL auto_increment,
  `group_parent_id` int(4) NOT NULL,
  `keysname` varchar(32) NOT NULL,
  `img` varchar(50) NOT NULL,
  `icon` varchar(50) NULL,
  `sort` int(3) NOT NULL default '0',
  `updatetime` int(11) NOT NULL default '0',
  `extraOption` varchar(70) NOT NULL,
  `status` int(2) NOT NULL,
  `extra_group1` varchar(255) NOT NULL,
  `extra_group2` varchar(255) NOT NULL,
  `extra_group3` varchar(255) NOT NULL,
  `extra_group4` varchar(255) NOT NULL,
  `extra_group5` varchar(255) NOT NULL,
  PRIMARY KEY  (`group_id`),
  KEY `keysname` (`keysname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'site_articles_group_content'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_articles_group_content` (
  `group_content_id` int(4) NOT NULL auto_increment,
  `group_id` int(4) NOT NULL,
  `langkeys` varchar(25) NOT NULL default 'th',
  `group_name` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `detailExtra1` text NOT NULL,
  `detailExtra2` text NOT NULL,
  `group_slug` varchar(255) NOT NULL,
  PRIMARY KEY  (`group_content_id`),
  KEY `langkeys` (`langkeys`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'site_articles_img'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_articles_img` (
  `file_id` int(11) NOT NULL auto_increment,
  `articles_id` int(11) NOT NULL,
  `imgPathMini` varchar(255) NOT NULL,
  `imgPathBig` varchar(255) NOT NULL,
  `ctime` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `detail2` text NOT NULL,
  `keysname` varchar(32) NOT NULL,
  `ismark` int(1) NOT NULL default '0',
  PRIMARY KEY  (`file_id`),
  KEY `articles_id` (`articles_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'site_articles_file'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_articles_file` (
  `file_id` int(11) NOT NULL auto_increment,
  `articles_id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `ctime` int(11) NOT NULL,
  `detail` text NOT NULL,
  `detail_en` text NOT NULL,
  `keysname` varchar(32) NOT NULL,
  PRIMARY KEY  (`file_id`),
  KEY `articles_id` (`articles_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'site_tags'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_tags` (
  `tags_id` int(11) NOT NULL auto_increment,
  `tags_name` varchar(62) NOT NULL,
  `articles_tags_num` int(11) NOT NULL,
  `keysname` varchar(32) NOT NULL,
  PRIMARY KEY  (`tags_id`),
  KEY `tags_id` (`tags_name`, `articles_tags_num`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'site_articles_group_file'] = "
CREATE TABLE `" . _DBPREFIX_ . "site_articles_group_file` (
    `file_id` int(11) NOT NULL,
    `group_id` int(11) NOT NULL,
    `filename` varchar(255) NOT NULL,
    `ctime` int(11) NOT NULL,
    `detail` text NOT NULL,
    `keysname` varchar(32) NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
$sqlArray[_DBPREFIX_ . 'site_articles_group_img'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_articles_group_img` (
  `file_id` int(11) NOT NULL auto_increment,
  `group_id` int(11) NOT NULL,
  `imgPathMini` varchar(255) NOT NULL,
  `imgPathBig` varchar(255) NOT NULL,
  `ctime` int(11) NOT NULL,
  `title` varchar(255) NULL,
   `detail` text NOT NULL,
   `detail2` text NULL,
  `keysname` varchar(32) NOT NULL,
  `ismark` int(1) NOT NULL default '0',
  PRIMARY KEY  (`file_id`),
  KEY `articles_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";


$sqlArray[_DBPREFIX_ . 'site_articles_subpost'] = "
CREATE TABLE `" . _DBPREFIX_ . "site_articles_subpost` (
  `subpost_id` int(11) NOT NULL AUTO_INCREMENT,
  `articles_id` int(11) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `subMessage` varchar(255) DEFAULT NULL,
  `subText` text DEFAULT NULL,
  `subAddDate` datetime DEFAULT CURRENT_TIMESTAMP,
  `subModifyDate` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`subpost_id`),
  INDEX idx_articles_id (articles_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
