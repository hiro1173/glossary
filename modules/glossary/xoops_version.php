<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;
$modversion['name'] = _MI_GLOSSARY_NAME;
$modversion['version'] = 0.85;
$modversion['description'] = _MI_GLOSSARY_DESC;
$modversion['author'] = "Hiroki Seike http://beabo.net/";
$modversion['credits'] = "Hiroki Seike<br />XOOPS Project";
$modversion['help'] = "help.html";
$modversion['license'] = "GPL see LICENSE";
$modversion['image'] = "images/glossary.png";
$modversion['dirname'] = "glossary";
$modversion['cube_style'] = true;

// SQL
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file (without prefix!)
$modversion['tables'][0] = "{prefix}_{dirname}_category";
$modversion['tables'][1] = "{prefix}_{dirname}_word";
$modversion['tables'][2] = "{prefix}_{dirname}_tag";

$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";
$modversion['use_smarty'] = 1;
$modversion['hasComments'] = 0;
$modversion['hasNotification'] = 0;
$modversion['hasMain'] = 1;
//$modversion['main']['name'] = '用語辞典';
//$modversion['read_any'] = true;
// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = "include/search.inc.php";
$modversion['search']['func'] = "glossary_search";

global $xoopsUser, $xoopsModuleConfig;

if (is_object($xoopsUser)) {
	$modversion['sub'][0]['name'] = _MI_GLOSSARY_SUB_SMNAME0;
	$modversion['sub'][0]['url'] = "index.php?action=WordEdit" ;
}

$configUseModRewrite = isset( $xoopsModuleConfig['use_mod_rewrite']) ? intval( $xoopsModuleConfig['use_mod_rewrite']) : 0;
$useCategoryMenu = isset( $xoopsModuleConfig['catsinmenu']) ? intval( $xoopsModuleConfig['catsinmenu']) : 0;

$modversion['sub'][1]['name'] =_MI_GLOSSARY_TAGCLOUD;
if ($configUseModRewrite) {
	$modversion['sub'][1]['url'] = "tagcloud/" ;
} else {
	$modversion['sub'][1]['url'] = "index.php?action=TagCloud" ;
}

$i = 2;

if ($useCategoryMenu) {
	$xoopsDB =& Database::getInstance();
	$cat_table = $xoopsDB->prefix( "glossary_category" );
	$sql = $xoopsDB->query("SELECT categoryid, name FROM $cat_table ORDER BY weight ASC");
	while ( list( $categoryid, $name ) = $xoopsDB->fetchRow( $sql ) ) {
		if ($configUseModRewrite) {
			// use mod_rewrite
			$linkCategoryUrl =  "category/". htmlSpecialChars($name, ENT_QUOTES ) . "/";
		} else {
			$linkCategoryUrl = "index.php?action=CategoryView&categoryid=". intval($categoryid);
		}
		$name =  htmlspecialchars($name, ENT_QUOTES);
		$categoryid = intval($categoryid);
		$modversion['sub'][$i]['name'] = $name;
		$modversion['sub'][$i]['url'] = $linkCategoryUrl;
		$i++;
	}
}

// Blocks
$modversion['blocks'][0]['file'] = "entries_new.php";
$modversion['blocks'][0]['name'] = _MI_GLOSSARY_ENTRIESNEW;
$modversion['blocks'][0]['description'] = "Shows new entries";
$modversion['blocks'][0]['show_func'] = "glossary_b_entries_new_show";
$modversion['blocks'][0]['edit_func'] = "glossary_b_entries_new_edit";
$modversion['blocks'][0]['options'] = "datesub|5";
$modversion['blocks'][0]['template'] = "glossary_new.html";

$modversion['blocks'][1]['file'] = "entries_top.php";
$modversion['blocks'][1]['name'] = _MI_GLOSSARY_ENTRIESTOP;
$modversion['blocks'][1]['description'] = "Shows popular entries";
$modversion['blocks'][1]['show_func'] = "glossary_b_entries_top_show";
$modversion['blocks'][1]['edit_func'] = "glossary_b_entries_top_edit";
$modversion['blocks'][1]['options'] = "counter|5";
$modversion['blocks'][1]['template'] = "glossary_top.html";

$modversion['blocks'][2]['file'] = "random_term.php";
$modversion['blocks'][2]['name'] = _MI_GLOSSARY_RANDOMTERM;
$modversion['blocks'][2]['description'] = "Shows a random term";
$modversion['blocks'][2]['show_func'] = "glossary_b_entries_random_show";
$modversion['blocks'][2]['edit_func'] = "glossary_b_entries_random_edit";
$modversion['blocks'][2]['options'] = "counter|5";
$modversion['blocks'][2]['template'] = "glossary_random.html";

$modversion['blocks'][3]['file'] = "term_initial.php";
$modversion['blocks'][3]['name'] = _MI_GLOSSARY_TERMINITIAL;
$modversion['blocks'][3]['description'] = "Shows a letter";
$modversion['blocks'][3]['show_func'] = "glossary_b_entries_initial_show";
$modversion['blocks'][3]['template'] = "glossary_initial.html";

$modversion['blocks'][4]['file'] = "tagcloud.php";
$modversion['blocks'][4]['name'] = _MI_GLOSSARY_TAGCLOUD;
$modversion['blocks'][4]['description'] = "Shows tag cloud";
$modversion['blocks'][4]['show_func'] = "glossary_b_tagcloud_show";
$modversion['blocks'][4]['edit_func'] = "glossary_b_tagcloud_edit";
$modversion['blocks'][4]['options'] = "new|10|25";
$modversion['blocks'][4]['template'] = "glossary_tagcloud.html";

// Templates
$modversion['templates'][1]  = array('file' => "glossary_header.html" ,'description' => _MI_GLOSSARY_TPL_HEADER) ;
$modversion['templates'][2]  = array('file' => "glossary_view_search.html" ,'description' => _MI_GLOSSARY_TPL_VIEW_SEARCH) ;
$modversion['templates'][3]  = array('file' => "glossary_view_letter.html" ,'description' => _MI_GLOSSARY_TPL_VIEW_LETTER) ;
$modversion['templates'][4]  = array('file' => "glossary_word_item.html" ,'description' => _MI_GLOSSARY_TPL_WORD_ITEM) ;
$modversion['templates'][5]  = array('file' => "glossary_index.html" ,'description' => _MI_GLOSSARY_TPL_INDEX) ;
$modversion['templates'][6]  = array('file' => "glossary_category_view.html" ,'description' => _MI_GLOSSARY_TPL_CATEGORY) ;
$modversion['templates'][7]  = array('file' => "glossary_letters.html" ,'description' => _MI_GLOSSARY_TPL_LETTERS) ;
$modversion['templates'][8]  = array('file' => "glossary_tag_view.html" ,'description' => _MI_GLOSSARY_TPL_TAG_VIEW) ;
$modversion['templates'][9]  = array('file' => "glossary_tag_cloud.html" ,'description' => _MI_GLOSSARY_TPL_TAG_CLOUD) ;
$modversion['templates'][10] = array('file' => "glossary_search.html" ,'description' => _MI_GLOSSARY_TPL_SEARCH) ;
$modversion['templates'][11] = array('file' => "glossary_word_view.html",'description' => _MI_GLOSSARY_TPL_WORD_VIEW) ;
$modversion['templates'][12] = array('file' => "glossary_word_edit.html" ,'description' => _MI_GLOSSARY_TPL_WORD_EDIT) ;
$modversion['templates'][13] = array('file' => "glossary_word_delete.html" ,'description' => _MI_GLOSSARY_TPL_WORD_DELETE) ;
$modversion['templates'][14] = array('file' => "glossary_resent.html" ,'description' => _MI_GLOSSARY_TPL_CSS) ;
$modversion['templates'][15] = array('file' => "glossary_searchresults.html" ,'description' => _MI_GLOSSARY_TPL_SEARCHRESULTS) ;


$modversion['templates'][16] = array('file' => "glossary_feed_rss20.html" ,'description' => _MI_GLOSSARY_TPL_RSS20) ;

// Config Settings (only for modules that need config settings generated automatically)

$modversion['config'][] = array(
    'name'        => 'use_category' ,
    'title'       => '_MI_GLOSSARY_USECATEGORY' ,
    'description' => '_MI_GLOSSARY_USECATEGORY_DSC' ,
    'formtype'    => 'yesno' ,
    'valuetype'   => 'int' ,
    'default'     => 1
) ;


$modversion['config'][] = array(
    'name'        => 'catsinmenu' ,
    'title'       => '_MI_GLOSSARY_CATSINMENU' ,
    'description' => '_MI_GLOSSARY_CATSINMENU_DSC' ,
    'formtype'    => 'yesno' ,
    'valuetype'   => 'int' ,
    'default'     => 1
) ;


$modversion['config'][] = array(
    'name'        => 'desrlength' ,
    'title'       => '_MI_GLOSSARY_DESCLENGTH' ,
    'description' => '_MI_GLOSSARY_DESCLENGTH_DSC' ,
    'formtype'    => 'textbox' ,
    'valuetype'   => 'int' ,
    'default'     => 100
) ;

$modversion['config'][] = array(
    'name'        => 'related_words' ,
    'title'       => '_MI_GLOSSARY_RELATED_WORDS' ,
    'description' => '_MI_GLOSSARY_RELATED_WORDS_DSC' ,
    'formtype'    => 'yesno' ,
    'valuetype'   => 'int' ,
    'default'     => 0
) ;


$modversion['config'][] = array(
    'name'        => 'topagereadmeused' ,
    'title'       => '_MI_GLOSSARY_READMEUSED' ,
    'description' => '_MI_GLOSSARY_READMEUSED_DSC' ,
    'formtype'    => 'yesno' ,
    'valuetype'   => 'int' ,
    'default'     => 1
) ;


$modversion['config'][] = array(
    'name'        => 'topagereadme' ,
    'title'       => '_MI_GLOSSARY_README' ,
    'description' => '_MI_GLOSSARY_README_DSC' ,
    'formtype'    => 'textarea' ,
    'valuetype'   => 'text' ,
    'default'     => _MI_GLOSSARY_README_DEF
) ;


$modversion['config'][] = array(
    'name'        => 'categoryblockused' ,
    'title'       => '_MI_GLOSSARY_CATEGORYDISP' ,
    'description' => '_MI_GLOSSARY_CATEGORYDISP_DSC' ,
    'formtype'    => 'yesno' ,
    'valuetype'   => 'int' ,
    'default'     => 1
) ;


$modversion['config'][] = array(
    'name'        => 'letterblockused' ,
    'title'       => '_MI_GLOSSARY_LETTERDISP' ,
    'description' => '_MI_GLOSSARY_LETTERDISP_DSC' ,
    'formtype'    => 'yesno' ,
    'valuetype'   => 'int' ,
    'default'     => 1
) ;


$modversion['config'][] = array(
    'name'        => 'perpage' ,
    'title'       => '_MI_GLOSSARY_PERPAGEINDEX' ,
    'description' => '_MI_GLOSSARY_PERPAGEINDEX_DSC' ,
    'formtype'    => 'select' ,
    'valuetype'   => 'int' ,
    'default'     => '20' ,
    'options'     => array('10' => 10, '20' => 20, '30' => 30, '50' => 50, '100' => 100)
) ;


$modversion['config'][] = array(
    'name'        => 'newwordsuse' ,
    'title'       => '_MI_GLOSSARY_BLOCKSPERPAGE' ,
    'description' => '_MI_GLOSSARY_BLOCKSPERPAGE_DSC' ,
    'formtype'    => 'select' ,
    'valuetype'   => 'int' ,
    'default'     => '5' ,
    'options'     => array('5' => 5, '10' => 10, '15' => 15, '20' => 20, '25' => 25, '30' => 30, '50' => 50 )
) ;

$modversion['config'][] = array(
        'name'        => 'use_fckeditor' ,
        'title'       => '_MI_GLOSSARY_USE_FCKEDITOR' ,
        'description' => '_MI_GLOSSARY_USE_FCKEDITOR_DSC' ,
        'formtype'    => 'yesno' ,
        'valuetype'   => 'int' ,
        'default'     => '0',
        'options'     => array()
) ;

$modversion['config'][] = array(
    'name'        => 'use_mod_rewrite' ,
    'title'       => '_MI_GLOSSARY_MODREWRITE' ,
    'description' => '_MI_GLOSSARY_MODREWRITE_DSC' ,
    'formtype'    => 'select' ,
    'valuetype'   => 'int' ,
    'default'     => '0',
    'options'     => array('_MI_GLOSSARY_MODREWRITE_0' => 0, '_MI_GLOSSARY_MODREWRITE_1' => 1)
) ;

$modversion['config'][] = array(
    'name'        => 'usebreadcrumbs' ,
    'title'       => '_MI_GLOSSARY_BREADCRUMBS' ,
    'description' => '_MI_GLOSSARY_BREADCRUMBS_DSC' ,
    'formtype'    => 'yesno' ,
    'valuetype'   => 'int' ,
    'default'     => '1'
) ;

$modversion['config'][] = array(
    'name'        => 'use_multibytes' ,
    'title'       => '_MI_GLOSSARY_MULTIBYTES' ,
    'description' => '_MI_GLOSSARY_MULTIBYTES_DSC' ,
    'formtype'    => 'yesno' ,
    'valuetype'   => 'int' ,
    'default'     => '0'
) ;

$modversion['config'][] = array(
    'name'        => 'tagtolower' ,
    'title'       => '_MI_GLOSSARY_TAG_TOLOWER' ,
    'description' => '_MI_GLOSSARY_TAG_TOLOWER_DSC' ,
    'formtype'    => 'yesno' ,
    'valuetype'   => 'int' ,
    'default'     => 1
) ;


// On install & Update , Uninstall
$modversion['onInstall']   = '/include/oninstall.php' ;
$modversion['onUpdate']    = '/include/onupdate.php' ;
$modversion['onUninstall'] = '/include/onuninstall.php' ;


?>