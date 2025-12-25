<?php
$sqlArray[_DBPREFIX_ . 'chat_data'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "chat_data` (
  `chat_id` int(11) NOT NULL auto_increment,
  `user_id_send` int(11) NOT NULL,
  `user_id_receive` int(11) NOT NULL,
  `message` text NOT NULL,
  `chat_time` datetime NOT NULL,
  `read_status` boolean NOT NULL,
  PRIMARY KEY  (`chat_id`),
  KEY `user_id` (`user_id_send`, `user_id_receive`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";

$sqlArray[_DBPREFIX_ . 'chat_data_group'] = "
CREATE TABLE IF NOT EXISTS `" . _DBPREFIX_ . "chat_data_group` (
  `chat_id` int(11) NOT NULL auto_increment,
  `user_id_send` int(11) NOT NULL,
  `message` text NOT NULL,
  `chat_time` datetime NOT NULL,
  `keysname` varchar(32) NULL,
  PRIMARY KEY  (`chat_id`),
  KEY `user_id` (`user_id_send`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
";
