<?php
$sqlArray[_DBPREFIX_ . 'site_configs'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_configs` (
	`conf_id` int( 11 ) NOT NULL AUTO_INCREMENT ,
	`keywords` varchar( 64 ) NOT NULL ,
	`val` text NOT NULL,
	PRIMARY KEY ( `conf_id` ) ,
	KEY `keywords` ( `keywords` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT =1;
";

/*
 * repassword is the case where the password is changed because it is forgotten.
 * The system will need to create a new password to store it in this field. And send the code via email.
 * When a new login with this code will have to change the old code to this new code, but if there is a login with the old code.
 * The new code will be canceled by deleting the value.
 */

$sqlArray[_DBPREFIX_ . 'member_user'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "member_user` (
  `user_id` int(11) NOT NULL auto_increment,
  `username` varchar(50) NOT NULL default '',
  `password` varchar(255) NOT NULL default '',
  `repassword` varchar(50) NULL default '',
  `twofa_status` enum('on','pending','off') NOT NULL DEFAULT 'off',
  `twofa_secret` varchar(64) DEFAULT NULL,
  `status` varchar(32) NULL default '',
  `node_member` int(11) NULL default '0',
  `ipaddress` varchar(20) NULL default '',
  `register_date` int(11) NULL,
  `modules` text NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";

$sqlArray[_DBPREFIX_ . 'member_member'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "member_member` (
  `mem_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `salutation` varchar(125) NULL,
  `firstname` varchar(50) NULL default '',
  `lastname` varchar(50) NULL default '',
  `picture` varchar(255) NULL default '',
  `email` varchar(50) NULL default '',
  `phone` varchar(20) NULL default '',
  `mem_code` varchar(20) NULL default '',
  `mem_namecard` varchar(20) NULL default '',
  `position_id` int(11) NULL,
  `birthday` int(11) NULL,
  PRIMARY KEY  (`mem_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

/**
 * Table to store information on people online
 * The calculated number may be calculated as 15 minutes. If the page has not refreshed for more than 15 minutes, it will be out of online
 * user_id = Member system
 * onlineTime = Time stored into the system
 * onlineEndTime =  Time to Expiration online
 * actionView = Where are viewing or doing recently
 * ipaddress = Store IPs online
 */

$sqlArray[_DBPREFIX_ . 'member_online'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "member_online` (
  `online_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL default '0',
  `onlineTime` int(11) NULL default '0',
  `onlineEndTime` int(11) NULL default '0',
  `actionView` varchar(255) NULL default '',
  `ipaddress` varchar(20) NULL default '',
  `viewurl` varchar(255) NULL default '',
  PRIMARY KEY  (`online_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";

$sqlArray[_DBPREFIX_ . 'admin_group'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "admin_group` (
		`group_admin_id` int(11) NOT NULL auto_increment,
		`group_admin_name` varchar(120) NULL,
    `region_id` int(11) NULL default '0',
  PRIMARY KEY  (`group_admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'member_admin_login_logs'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "member_admin_login_logs` (
  `logs_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `admin_ip` varchar(20) NULL,
  `logs_time` int(11) NULL,
  PRIMARY KEY  (`logs_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'member_member_login_logs'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "member_member_login_logs` (
  `logs_id` int(11) NOT NULL auto_increment,
  `user_id` int(11) NOT NULL,
  `member_ip` int(11) NULL,
  `logs_time` int(11) NULL,
  PRIMARY KEY  (`logs_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";

$sqlArray[_DBPREFIX_ . 'logs_login'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "logs_login` (
  `logs_id` int(11) NOT NULL auto_increment,
  `loginBan` int(1) NULL default '0',
  `loginFail` int(11) NULL,
  `loginIp` varchar(20) NULL,
  `loginDes` varchar(255) NULL,
  `logs_time` int(11) NULL,
  PRIMARY KEY  (`logs_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'logs_mail'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "logs_mail` (
  `logs_id` int(11) NOT NULL auto_increment,
  `subject` varchar(255) NULL default '',
  `sendto` varchar(255) NULL default '',
  `header` text NULL default '',
  `content` text NULL,
  `logs_time` int(11) NULL,
  PRIMARY KEY  (`logs_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'site_metatags'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_metatags` (
	`meta_id` int( 11 ) NOT NULL AUTO_INCREMENT ,
	`meta_key` varchar( 64 ) NULL ,
	`title` varchar( 255 ) NULL ,
	`description` varchar( 255 ) NULL ,
	`keywords` varchar( 255 ) NULL ,
	`robots` varchar( 64 ) NULL ,
	`googlebot` varchar( 64 ) NULL ,
	`contact_addr` varchar( 64 ) NULL ,
	`copyright` varchar( 64 ) NULL ,
	`author` varchar( 64 ) NULL ,
	`revisit-after` varchar( 16 ) NULL ,
	`lang` varchar( 16 ) NULL ,
  `icon` varchar( 255 ) NULL ,
	PRIMARY KEY ( `meta_id` ) ,
	KEY `lang` ( `lang` ) ,
	KEY `meta_key` ( `meta_key` )
) ENGINE = MYISAM DEFAULT CHARSET = utf8 AUTO_INCREMENT =1;
";

$sqlAlter[_DBPREFIX_ . 'site_metatags']['icon'] = "
ALTER TABLE `" . _DBPREFIX_ . "site_metatags` 
ADD COLUMN `icon` varchar(255) NULL AFTER `lang`;";

$sqlAlter[_DBPREFIX_ . 'site_metatags']['schema_json'] = "
ALTER TABLE `" . _DBPREFIX_ . "site_metatags` 
ADD COLUMN `schema_json` TEXT NULL COMMENT 'ข้อมูล Schema ในรูปแบบ JSON-LD' AFTER `icon`;";

$sqlArray[_DBPREFIX_ . 'site_seo_redir'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "site_seo_redir` (
  `redir_id` int(11) NOT NULL auto_increment COMMENT 'Primary Key ของตาราง Redirect',
  `source` varchar(255) NOT NULL COMMENT 'URL ต้นทาง เช่น /old-page',
  `target` varchar(255) NOT NULL COMMENT 'URL ปลายทาง เช่น /new-page',
  `hit_count` int(11) NOT NULL default '0' COMMENT 'จำนวนการเรียกใช้ Redirect',
  PRIMARY KEY  (`redir_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'banner'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "banner` (
  `banner_id` int(11) NOT NULL auto_increment,
  `title` varchar(125) NULL,
  `detail` varchar(255) NULL,
  `link` varchar(255) NULL,
  `target` varchar(64) NULL,
  `adddate` int(11) NULL,
  `sort` int(5) NULL,
  `bannertype` varchar(64) NULL,
  `keysname` varchar(32) NULL,
  `filename` varchar(255) NULL,
  `status` int(1) NULL default 0,
  `extra1` varchar(255) NULL,
  `extra2` varchar(255) NULL,
  PRIMARY KEY  (`banner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'contact'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "contact` (
  `id` int(11) NOT NULL auto_increment,
  `first_last` varchar(125) NULL,
  `email` varchar(255) NULL,
  `subject` varchar(255) NULL,
  `message` text NULL,
  `add_date` date NULL,
  `url` varchar(255) NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";

$sqlArray[_DBPREFIX_ . 'hash_log'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "hash_log` (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NULL COMMENT 'ผลการตรวจสอบหรือ error message',
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);
";

include('mysql_projects.sql.php');
include('mysql_articles.sql.php');
