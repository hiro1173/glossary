<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

function glossary_b_entries_initial_show( $mydirname ){
	include_once XOOPS_ROOT_PATH. '/modules/glossary/include/functions.php';
	$xoopsDB =& Database::getInstance();
	$myts = & MyTextSanitizer :: getInstance();
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
	$configUseModRewrite = $config['use_mod_rewrite'];
	$block['alpha']    = Glossary_functionAlphaArray(0);
	$block['japanese'] = Glossary_functionAlphaArray(1);
	$block['number']   = Glossary_functionAlphaArray(2);
	$block['use_mod_rewrite'][] = $configUseModRewrite;
	return $block;
}

?>