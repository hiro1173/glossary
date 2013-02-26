<?php
/*=====================================================================
  (C)2007 BeaBo Japan by Hiroki Seike
  http://beabo.net/
=====================================================================*/
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

function tag_glossary() {

	$mytag = array();

	// call $config['use_mod_rewrite'] 
	$config_handler = &xoops_gethandler('config');
	$moduleConfig =& $config_handler->getConfigsByDirname('glossary');
	$use_mod_rewrite = isset( $moduleConfig['use_mod_rewrite']) ? intval( $moduleConfig['use_mod_rewrite']) : 0;

	$handler =& xoops_getmodulehandler('category', 'glossary');
	$mCriteria = new CriteriaCompo();
	$mCriteria->add(new Criteria('parentid', 0));
	$mCriteria->setSort('weight');
	$maps =& $handler->getObjects($mCriteria);

	foreach ($map34s as $key => $map) {
		$sitemap['parent'][$key]['id'] = $map->getVar('categoryid');
		$sitemap['parent'][$key]['title'] = $map->getVar('name');
		// if useing mod_rewrite to change URL
		if ($use_mod_rewrite) {
			$linkCategoryUrl = "category/".addSlashes( $map->getVar('name')). "/";
		} else {
			$linkCategoryUrl = "index.php?action=CategoryView&categoryid=".$map->getVar('categoryid');
		}
		$sitemap['parent'][$key]['url']  = $linkCategoryUrl;
	}

	return $mytag;
}
?>