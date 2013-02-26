<?php 
/*=====================================================================
    (C)2007 BeaBo Web Solutions Japan by Hiroki Seike
 ======================================================================
    URL       : http://beabo.net/
    Email     : info@beabo.net
    File      : /include/search.inc.php
    Date      : 2007-09-25
    Memo      : XOOPS Global search
              : You need display context need hacked your search.php or
              : Legacy_Module.class.php and any templates.
=====================================================================*/
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

function glossary_search($queryarray, $andor, $limit, $offset, $userid)
{
	global $xoopsDB;
	$myts = &MyTextSanitizer :: getInstance();
	// XOOPS Search module
//	$showContext = empty( $_GET['showcontext'] ) ? 0 : 1 ;
	$showContext = true ;
	// Count search words
	$count = count( $queryarray );

	// Highlight words
	if ($queryarray == '' || count($queryarray) == 0){
		$keywords= '';
		$hightlight_key = '';
	} else {
		$keywords=implode('+', $queryarray);
		$hightlight_key = "&amp;keywords=" . $keywords;
	}

	// --------------------------------------------------------
	// Search Action
	// --------------------------------------------------------
	$sql = "SELECT c.categoryid, c.name, w.wordid, w.term, w.proc, w.description, w.submited, w.submitter FROM "
	. $xoopsDB -> prefix("glossary_category")." c LEFT JOIN ". $xoopsDB -> prefix("glossary_word")." w ON c.categoryid = w.categoryid WHERE published > 0 ";
	if ($userid != 0) {
		$sql .= " AND w.submitter=" . $userid . " ";
	} 
	if (is_array($queryarray) && count( $queryarray )) {
		$sql .= " AND ((  c.name        LIKE '%$queryarray[0]%' OR 
					c.description LIKE '%$queryarray[0]%' OR 
					w.term        LIKE '%$queryarray[0]%' OR 
					w.english     LIKE '%$queryarray[0]%' OR 
					w.description LIKE '%$queryarray[0]%'
					)";
		for($i = 1;$i < $count;$i++) {
			$sql .= " $andor ";
			$sql .= "(  c.name        LIKE '%$queryarray[$i]%' OR 
					c.description LIKE '%$queryarray[$i]%' OR 
					w.term        LIKE '%$queryarray[$i]%' OR 
					w.english     LIKE '%$queryarray[$i]%' OR 
					w.description LIKE '%$queryarray[$i]%'
					)";
		} 
		$sql .= ") ";
	} 
	$sql .= " ORDER BY init ASC";
	$result = $xoopsDB -> query($sql, $limit, $offset);
	$ret = array();
	$i = 0;
	$root =& XCube_Root::getSingleton();
	$textFilter =& $root->getTextFilter();
	// call $config['use_mod_rewrite'] 
	$config_handler = &xoops_gethandler('config');
	$moduleConfig =& $config_handler->getConfigsByDirname('glossary');
//	$use_mod_rewrite = isset( $moduleConfig['use_mod_rewrite']) ? intval( $moduleConfig['use_mod_rewrite']) : 0;
	$configDesrLength     = $moduleConfig['desrlength'];

	while ($myrow = $xoopsDB -> fetchArray($result)) {
		$ret[$i]['image'] = "images/glossary.gif";
		$ret[$i]['link']  = "index.php?action=WordView&wordid=" . $myrow['wordid']. $hightlight_key;
		$ret[$i]['title'] = $myrow['term'];
		$ret[$i]['time']  = $myrow['submited'];
		$ret[$i]['uid']   = $myrow['submitter'];
		// omitted a description
		$wordDesc = $myrow['description'];
		$wordDesc = $textFilter->toShowTarea($wordDesc, $html=1, $smiley=1, $xcode=0, $image=1, $br=1,false);
		$wordDesc = preg_replace('!<script.*?>.*?</script.*?>!is', '', $wordDesc);
		$wordDesc = strip_tags($wordDesc);

		if (isset($queryarray)) {
			// Serch Reslut
			$context = glossary_make_context($wordDesc, $queryarray);
		} else {
			// User Info
			$context = $wordDesc;
		}
		$ret[$i]['context'] =$context;

//print_r($ret[$i]);
		echo '<br />';


		$i++;
	} 
	return $ret;
} 

// --------------------------------------------------------
// highlight of a search word
// Thanks nao-pon
// --------------------------------------------------------
function glossary_make_context($text, $words, $l=255) {
	static $strcut = "";
	if (!$strcut)
		$strcut = create_function('$a,$b,$c', (function_exists('mb_strcut'))? 'return mb_strcut($a,$b,$c);': 'return strcut($a,$b,$c);');
	if (!is_array($words)) $words = array();
	$ret = "";
	$q_word = str_replace(" ","|",preg_quote(join(' ',$words),"/"));
	if (preg_match("/$q_word/i",$text,$match)) {
		$ret = ltrim(preg_replace('/\s+/', ' ', $text));
		list($pre, $aft)=preg_split("/$q_word/i", $ret, 2);
		$m = intval($l/2);
		$ret = (strlen($pre) > $m)? "... " : "";
		$ret .= $strcut($pre, max(strlen($pre)-$m+1,0),$m).$match[0];
		$m = $l-strlen($ret);
		$ret .= $strcut($aft, 0, min(strlen($aft),$m));
		// highlight of a search word
		$replacements = '<span class="search_highright"> '.$match[0].' </span>';
		$ret = preg_replace("/$q_word/i", $replacements, $ret);
		if (strlen($aft) > $m) $ret .= " ...";
	}
	if (!$ret) $ret = $strcut($text, 0, $l);
	return $ret;
}

?>
