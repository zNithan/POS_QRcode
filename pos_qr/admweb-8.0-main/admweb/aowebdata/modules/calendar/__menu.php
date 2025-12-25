<?php
$title = 'INTRO PAGE';
$_aMenuList = array();
$_aMenuList['title'] = $title;
$_aMenuList['name'] = $title;
$_aMenuList['node'] = 'head';

$module_name = 'calendar';
$link_module = 'index.php?module=' . $module_name;

################# MENU ####################
$subname = 'event';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'Intro Home Page',
	'link' => $link_module . '&mp=event',
	'target' => '',
	'openPermission' => array('admin'),
	'class' => 'fa fa-calendar',
	'menu' => array(),
);
