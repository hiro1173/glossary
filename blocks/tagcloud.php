<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

function glossary_b_tagcloud_show($options) {
//	require_once XOOPS_MODULE_PATH. '/glossary/include/TagService.php';
	require_once XOOPS_MODULE_PATH. '/glossary/class/TagService.class.php';

	$xoopsDB =& Database::getInstance();
	// read xoopsconfig
	if (empty($xoopsModule) || $xoopsModule -> getVar('dirname') != 'glossary') {
		$module_handler = &xoops_gethandler('module');
		$module = &$module_handler -> getByDirname('glossary');
		$config_handler = &xoops_gethandler('config');
		$config = &$config_handler -> getConfigsByCat(0, $module -> getVar('mid'));
	} else {
		$module = &$xoopsModule;
		$config = &$xoopsModuleConfig;
	}
	$block['use_mod_rewrite'] = intval( $config['use_mod_rewrite'] );

	$root =& XCube_Root::getSingleton();
	$popularTags = TagService::getAllTags() ;
	$tagCloudArray = TagService::tagCloud($popularTags, $steps = 2, $sizemin = 50, $sizemax = 225, $sortOrder = NULL);

	foreach ($tagCloudArray as $id => $tag) {
		$block['tagcloud'][] = $tag;
	}
	return $block;
}

function glossary_b_tagcloud_edit($options) {
}

?>
