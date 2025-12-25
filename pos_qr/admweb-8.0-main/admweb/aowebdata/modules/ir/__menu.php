<?php
$title      = 'Investor Relations (IR)';
$des        = 'You can manage members and manage system administrators in this section. Can set access rights in each of the various modules.';
$_aMenuList = array();
$_aMenuList['title'] = $title;
$_aMenuList['name']  = $title;
$_aMenuList['node']  = 'head';

$module_name         = 'ir';
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

################# MENU ####################
$subname = 'documents ao';
$_aMenuList['subhead'][$subname] = array(
	'name' => 'IR Tools',
	'link' => 'index.php?module=' . $module_name . '&mp=ir',
	'openPermission' => array('admin'),
	'class' => 'fa fa-file-text',
	'menu' => array(),
);
################# MENU ####################