<?php
/*=====================================================================
    (C)2007 BeaBo Web Solutions Japan by Hiroki Seike
 ======================================================================
    URL       : http://beabo.net/
    Email     : info@beabo.net
    File      : /admin/MenuManager.php
    Date      : 2008-01-19
    Memo      : make admin Menu Manager
              : Based on GIJOE's mymenu.php
=====================================================================*/
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

// FormEdit
$subMenuFormEdit[1] = array(
    'title'       => _AD_GLOSSARY_FORMLIST ,
    'description' => _AD_GLOSSARY_FORMLIST_DSC ,
    'menuno'      => '1',
    'link'        => 'index.php?ItemList&form_id='
) ;

$subMenuFormEdit[2] = array(
    'title'       => _AD_GLOSSARY_ITEMEDIT ,
    'description' => _AD_GLOSSARY_ITEMEDIT_DSC ,
    'menuno'      => '2',
    'link'        => 'form_edit.php'
) ;

// Log
$subMenuLog[1] = array(
    'title'       => _AD_GLOSSARY_ADMENU_31 ,
    'description' => _AD_GLOSSARY_ADMENU_31_DSC ,
    'menuno'      => '1',
    'link'        => 'log_index.php'
) ;

$subMenuLog[2] = array(
    'title'       => _AD_GLOSSARY_ADMENU_32 ,
    'description' => _AD_GLOSSARY_ADMENU_32_DSC ,
    'menuno'      => '2',
    'link'        => 'log_index.php',
    'param'       => '?op=delAll'
) ;


// --------------------------------------------------------
// Sub Menu Settings
// --------------------------------------------------------
// Main Menu
$subMenuMain[1] = array(
    'title'       => _MI_GLOSSARY_MAIN ,
    'description' => _MI_GLOSSARY_MAIN_DSC ,
    'link'        => 'form_index.php'
) ;

$subMenuMain[2] = array(
    'title'       => _MI_GLOSSARY_ADMENU_12 ,
    'description' => _MI_GLOSSARY_ADMENU_12_DSC ,
    'link'        => 'form_index.php'
) ;

// --------------------------------------------------------
// Sub Menu
// --------------------------------------------------------
function adminSubMenu($subMenu='', $menuItemNo=1, $selectField='', $selectId='') {
	if (!$subMenu) {
		return false;
	}
	$count = count($subMenu);    // count menu item
	// add select field parameter
	if ($selectField <> '' and $selectId <> '') {
		$addParam = $selectField.'='. $selectId;
	} else {
		$addParam = '';
	}
	// make sumbmenu
	$_echo = '<div id="adminsubmenu"><ul>';
	for ($i = 1; $i < $count + 1; $i++) {
		// add parameter
		if (isset($subMenu[$i]['param']) and $addParam) {
			$param = $subMenu[$i]['param'].'&amp;'.$addParam ;
		} elseif (isset($subMenu[$i]['param'])) {
			$param = $subMenu[$i]['param'];
		} elseif ($addParam and $i > 1) {
			$param = '?'.$addParam ;
		} else {
			$param = '';
		}
		// menu tab
		if( $i == $menuItemNo  ) {
			$_echo.= '<li id="current"><a href="'.$subMenu[$i]['link']. $param.'">'.$subMenu[$i]['title'].'</a></li>'."\n" ;
		} else {
			$_echo.= '<li><a href="'.$subMenu[$i]['link']. $param.'">'.$subMenu[$i]['title'].'</a></li>'."\n" ;
		}
	}
	$_echo.= '</ul></div><div id="adminsubmenuline">&nbsp;</div>';
	$_echo.= '<div class="menumsg">'. $subMenu[$menuItemNo]['description']. '</div>'; 
	return $_echo;
}

?>