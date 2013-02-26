<?php 
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

function glossary_b_entries_top_show($options ) {
	include_once XOOPS_ROOT_PATH. '/modules/glossary/include/functions.php';
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
	$configUseModRewrite = $config['use_mod_rewrite'];
	$block = array();
	$newentries = array();
	$sql = "SELECT c.categoryid, c.name, w.wordid, w.term FROM ". $xoopsDB -> prefix("glossary_category")." c ".
		"LEFT JOIN ". $xoopsDB -> prefix("glossary_word")." w ON c.categoryid = w.categoryid WHERE published > 0 ORDER BY hits DESC";
	$result = $xoopsDB->query ($sql, $options[1], 0);
	$totalwords = $xoopsDB -> getRowsNum( $result );
	if ( $totalwords > 0 ) {
		while (list($categoryId, $categoryName, $wordId, $wordTerm) = $xoopsDB -> fetchRow($result)) {
			$newentries['term'] = addSlashes($wordTerm);
			$newentries['linkWordUrl'] = Glossary_functionGetWordUrl( $configUseModRewrite, intval($wordId), addSlashes($wordTerm),$categoryName);
			$block['newstuff'][] = $newentries;
		}
	}

	return $block;
}




function glossary_b_entries_top_edit($options ) {
	$form = "<input type='hidden' name='options[0]' value='datesub' />";
	$form .= constant("_MB_GLOSSARY_DISP") . "&nbsp;<input type='text' name='options[]' value='" . $options[1] . "' />&nbsp;" . constant("_MB_GLOSSARY_WORD_TERMS") . "";
	return $form;
}

?>