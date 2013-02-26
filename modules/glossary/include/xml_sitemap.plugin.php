<?php
/*=====================================================================
    (C)2007 BeaBo Japan by Hiroki Seike
 ======================================================================
    URL       : http://beabo.net/
    Email     : info@beabo.net
    File      : xml_sitemap.plugin.php
=====================================================================*/
if (!defined('XOOPS_ROOT_PATH')) exit();
// --------------------------------------------------------
// Sitemap for PC
// --------------------------------------------------------
function xml_sitemap_glossary(){
//	global $module_handler;

	$sitemap = array();

	// call $config['use_mod_rewrite'] 
	$config_handler = &xoops_gethandler('config');
	$moduleConfig =& $config_handler->getConfigsByDirname('glossary');
	$configUseModRewrite = isset( $moduleConfig['use_mod_rewrite']) ? intval( $moduleConfig['use_mod_rewrite']) : 0;

	// --------------------------------------------------------
	// Top page
	// --------------------------------------------------------
	$priority = 0.8;
	$now = time();
	$changefreq =  'monthly';
	$sitemap[] = array(
		'loc'        => XOOPS_URL. '/modules/glossary/',
		'lastmod'    => gmdate('Y-m-d\TH:i:s\Z', $now ),
		'changefreq' => $changefreq,
		'priority'   => $priority,
	);

	// --------------------------------------------------------
	// Category
	// --------------------------------------------------------
	$priority = 0.6;
	$handler =& xoops_getmodulehandler('category', 'glossary');
	$mCriteria = new CriteriaCompo();
	$mCriteria->add(new Criteria('parentid', 0));
	$mCriteria->setSort('weight');
	$pages =& $handler->getObjects($mCriteria);
	foreach ($pages as $key => $page) {
		// if useing mod_rewrite to change URL
		if ($configUseModRewrite) {
			$categoryUrl = "category/".urlencode($page->getVar('name')). "/";
		} else {
			$categoryUrl = "index.php?action=CategoryView&categoryid=".$page->getVar('categoryid');
		}
		if ($configUseModRewrite > 1) {
			$GlossaryUrl = XOOPS_URL . '/glossary/';
		} else {
			$GlossaryUrl = XOOPS_MODULE_PATH. '/glossary/';
		}
		$sitemap[] = array(
			
			'loc'        => $GlossaryUrl. $categoryUrl,
			'lastmod'    => gmdate('Y-m-d\TH:i:s\Z',  $now ),
			'changefreq' => $changefreq,
			'priority'   => $priority,
		);
	}

	// --------------------------------------------------------
	// Words
	// --------------------------------------------------------
	$priority = 0.5;
	$changefreq =  'monthly';
	$handler =& xoops_getmodulehandler('word', 'glossary');
	$mCriteria = new CriteriaCompo();
	$mCriteria->add(new Criteria('published', 0, '>'));
	$mCriteria->setSort('wordid');
	$pages =& $handler->getObjects($mCriteria);
	foreach ($pages as $key => $page) {
		// if useing mod_rewrite to change URL
		if ($configUseModRewrite) {
			// url encoding
			$wordUrl = "word/". urlencode( $page->getVar('term')). "/";
		} else {
			$wordUrl = "index.php?action=WordView&wordid=".$page->getVar('wordid');
		}
		$sitemap[] = array(
			'loc'        => XOOPS_URL. '/modules/glossary/'. $wordUrl,
			'lastmod'    => gmdate('Y-m-d\TH:i:s\Z',  $page->getVar('submited')),
			'changefreq' => $changefreq,
			'priority'   => $priority,
		);
	}

	// TOODO tag & alfabet page

/*
	// --------------------------------------------------------
	// Tag
	// --------------------------------------------------------
	$priority = 0.3;
	$changefreq =  'monthly';    // week ??

	$handler =& xoops_getmodulehandler('tag', 'glossary');
	$mCriteria = new CriteriaCompo();
	$mCriteria->add(new Criteria('published', 0, '>')); 
	$mCriteria->setSort('wordid');
	$pages =& $handler->getObjects($mCriteria);
	foreach ($pages as $key => $page) {
		// if useing mod_rewrite to change URL
		if ($configUseModRewrite) {
			$wordUrl = "word/".addSlashes( $page->getVar('term')). "/";
		} else {
			$wordUrl = "index.php?action=WordView&wordid=".$page->getVar('wordid');
		}
		$sitemap[] = array(
			'loc'        => XOOPS_URL. '/modules/glossary/'. $wordUrl,
			'lastmod'    => gmdate('Y-m-d\TH:i:s\Z',  $page->getVar('submited')),
			'changefreq' => $changefreq,
			'priority'   => $priority,
		);
	}
*/

	return $sitemap;
}

// --------------------------------------------------------
// Page Count
// --------------------------------------------------------
function xml_pagecount_glossary(){

	// count category pages
	$handler =& xoops_getmodulehandler('category', 'glossary');
	$mCriteria = new CriteriaCompo();
	$mCriteria->add(new Criteria('parentid', 0));
	$pageCount =& $handler->getCount($mCriteria);

	// count word pages
	$handler =& xoops_getmodulehandler('word', 'glossary');
	$mCriteria = new CriteriaCompo();
	$mCriteria->add(new Criteria('published', 0, '>'));
	$word_count =& $handler->getCount($mCriteria);

	return $pageCount + $word_count;
}

?>