<?php
$title      = 'EXAMPLE';
$des        = 'You can manage members and manage system administrators in this section. Can set access rights in each of the various modules.';
$_aMenuList = array();
$_aMenuList['title'] = $title;
$_aMenuList['name']  = $title;
$_aMenuList['node']  = 'head';

$module_name         = 'example';
$link_pages          = 'index.php?module=' . $module_name . '&mp=articles&inc=pages';
$link_banner         = 'index.php?module=' . $module_name . '&mp=banner';
$link_articles       = 'index.php?module=' . $module_name . '&mp=articles';
$link_articles_group = 'index.php?module=' . $module_name . '&mp=articles&inc=listgroup';
$link_articles_type  = 'index.php?module=' . $module_name . '&mp=articles&inc=listtype';
$link_articles_tags  = 'index.php?module=' . $module_name . '&mp=articles&inc=listtags';
$link_html 		        = 'index.php?module=' . $module_name . '&mp=html';
$link_config         = 'index.php?module=' . $module_name . '&mp=config';
$link_metas          = 'index.php?module=' . $module_name . '&mp=metas&metakey=';
$link_pagescontact   = 'index.php?module=' . $module_name . '&mp=contactus';
$link_seolist 		     = 'index.php?module=' . $module_name . '&mp=seolist';
$link_seogrouplist   = 'index.php?module=' . $module_name . '&mp=seogrouplist';
$link_demo_permission   = 'index.php?module=' . $module_name . '&mp=demo_permission';
$link_module 		= 'index.php?module=' . $module_name;

################# MENU ####################
$subname = 'exconfig';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'Configuration',
	'headertitle' => '',
	'link' => $link_config . '&keysname=config',
	'target' => '',
	'openPermission' => array('admin'),
	'class' => 'fa fa-file-text',
	'num' => 0,
	'menu' => array(),
);
################# MENU ####################
$subname = 'article';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'Articles & Group',
	'headertitle' => '',
	'link' => $link_articles . '&keysname=article',
	'target' => '',
	'openPermission' => array('admin'),
	'class' => 'fa fa-file-text',
	'num' => 0,
	'menu' => array(),
);
$_aMenuList['subhead'][$subname]['menu'][] = array(
	'name' => 'Article List',
	'link' => $link_articles . '&keysname=article',
	'help' => '',
	'target' => ''
);
$_aMenuList['subhead'][$subname]['menu'][] = array(
	'name' => 'Article Group List',
	'link' => $link_articles_group . '&keysname=article',
	'help' => '',
	'target' => ''
);
$_aMenuList['subhead'][$subname]['menu'][] = array(
	'name' => 'Article Type List',
	'link' => $link_articles_type . '&keysname=article',
	'help' => '',
	'target' => ''
);
$_aMenuList['subhead'][$subname]['menu'][] = array(
	'name' => 'Article tags List',
	'link' => $link_articles_tags . '&keysname=article',
	'help' => '',
	'target' => '',
);
$_aMenuList['subhead'][$subname]['menu'][] = array(
	'name' => 'Example SubMenu',
	'link' => 'index.php?module=' . $module_name . '&mp=submenu1',
	'help' => '',
	'target' => '',
	'menu' => array(),
);
//How to use submenu in submenu
$_aMenuList['subhead'][$subname]['menu'][4]['menu'][] = array(
	'name' => 'SubMenu 1',
	'link' => 'index.php?module=' . $module_name . '&mp=submenu1',
	'help' => '',
	'target' => '',
);
$_aMenuList['subhead'][$subname]['menu'][4]['menu'][] = array(
	'name' => 'SubMenu 2',
	'link' => 'index.php?module=' . $module_name . '&mp=submenu2',
	'help' => '',
	'target' => '',
);
################# MENU ####################
$subname = 'articlepage';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'Page Management',
	'headertitle' => '',
	'link' => $link_pages . '&keysname=webpage',
	'target' => '',
	'openPermission' => array('admin'),
	'class' => 'fa fa-file-text',
	'num' => 0,
	'menu' => array(),
);
################# MENU ####################
$subname = 'banner';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'Banner Management',
	'headertitle' => '',
	'link' => $link_banner . '&keysname=webpage',
	'target' => '',
	'openPermission' => array('admin'),
	'class' => 'fa fa-file-text',
	'num' => 0,
	'menu' => array(),
);

//SET Example Auther Permission
################# MENU ####################
$subname = 'pagescontact';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'Contact Us Mail',
	'headertitle' => '',
	'link' => $link_pagescontact,
	'target' => '',
	'openPermission' => array('admin'),
	'class' => 'fa fa-file-text',
	'num' => 0,
	'menu' => array(),
);

$subname = 'table';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'Table List',
	'headertitle' => '',
	'link' => $link_module . '&mp=table',
	'target' => '',
	'openPermission' => array('admin'),
	'class' => 'fa fa-file-text',
	'num' => 0,
	'menu' => array(),
);

################# MENU ####################
$subname = 'invoice';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'Invoice & Print',
	'headertitle' => '',
	'link' => $link_module . '&mp=invoice',
	'target' => '',
	'openPermission' => array('admin'),
	'class' => 'fa fa-file-text',
	'num' => 0,
	'menu' => array(),
);
################# MENU ####################
$subname = 'error';
$_aMenuList['subhead'][$subname] = array(
	'name' => '404 Error',
	'headertitle' => '',
	'link' => $link_module . '&mp=404error',
	'target' => '',
	'openPermission' => array('admin'),
	'class' => 'fa fa-file-text',
	'num' => 0,
	'menu' => array(),
);
################# MENU ####################
$subname = 'Template';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'Template Nifty',
	'headertitle' => '',
	'link' => 'https://www.themeon.net/nifty/v2.9.1/index.html',
	'target' => '_blank',
	'openPermission' => array('admin'),
	'class' => 'fa fa-file-text',
	'num' => 0,
	'menu' => array(),
);
