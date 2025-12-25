<?php
$title = 'CHAT';
$_aMenuList = array();
$_aMenuList['title'] = $title;
$_aMenuList['name'] = $title;
$_aMenuList['node'] = 'head';

$module_name = 'chat';
$link_module = 'index.php?module=' . $module_name;

################# MENU ####################
$subname = 'Chat board';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'Chat Board',
	'link' => $link_module . '&mp=chat_board',
	'target' => '',
	'openPermission' => array('admin', 'member'),
	'class' => 'fa fa-comments',
	'menu' => array(),
);
$subname = 'Member Chat';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'Member Chat',
	'link' => $link_module . '&mp=member_chat',
	'target' => '',
	'openPermission' => array('admin', 'member'),
	'class' => 'fa fa-user-circle',
	'menu' => array(),
);
$subname = 'Config Chat';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'Config Chat',
	'link' => $link_module . '&mp=config&keysname=setting',
	'target' => '',
	'openPermission' => array('admin'),
	'class' => 'fa fa-cogs',
	'menu' => array(),
);
