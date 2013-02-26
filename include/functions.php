<?php
if( ! defined( 'XOOPS_ROOT_PATH' ) ) exit ;

// --------------------------------------------------------
// mod_rewrite - Word
//     /glossary/index.php?action=WordView&word=fork
//     /glossary/word/fork/
// --------------------------------------------------------
function Glossary_functionGetWordUrl( $configUseModRewrite, $wordid, $term ) {
	if ($configUseModRewrite) {
		$linkWordUrl = XOOPS_MODULE_URL. '/glossary/word/'. $term. '/';
	} else {
		// mod_rewrite?
		$linkWordUrl = XOOPS_MODULE_URL. '/glossary/index.php?action=WordView&amp;wordid='. $wordid;
	}
	return $linkWordUrl;
}

// --------------------------------------------------------
// mod_rewrite - Category
//     /glossary/index.php?action=CategoryView&word=XOOPS
//     /glossary/category/XOOPS/
// --------------------------------------------------------
function Glossary_functionGetCategoryUrl( $configUseModRewrite, $categoryid, $slug ) {
	if ($configUseModRewrite) {
		$linkCategoryUrl = XOOPS_MODULE_URL. '/glossary/category/'. $slug. '/';
	} else {
		$linkCategoryUrl = XOOPS_MODULE_URL. '/glossary/index.php?action=CategoryView&amp;categoryid='. $categoryid;
	}
	return $linkCategoryUrl;
}

// --------------------------------------------------------
// mod_rewrite - Tag
//     /glossary/index.php?action=TagView&tag=XOOPS
//     /glossary/tag/XOOPS/
// --------------------------------------------------------
function Glossary_functionGetTagUrl( $configUseModRewrite, $tag ) {
	$tag = urlencode($tag);
	if ($configUseModRewrite) {
		$linkTagUrl = XOOPS_MODULE_URL. '/glossary/tag/'. $tag. '/';
	} else {
		$linkTagUrl = XOOPS_MODULE_URL. '/glossary/index.php?action=TagView&amp;tag='. $tag;
	}
	return $linkTagUrl;
}

// --------------------------------------------------------
// mod_rewrite - Letter
//     /glossary/index.php?action=LetterList&init=x
//     /glossary/letter/X/
// --------------------------------------------------------
function Glossary_functionGetLetterUrl( $configUseModRewrite, $init, $letter ) {
	if ($configUseModRewrite) {
		$linkLetterUrl = XOOPS_MODULE_URL. '/glossary/letter/'. $letter. '/';
	} else {
		$linkLetterUrl = XOOPS_MODULE_URL. '/glossary/index.php?action=LetterList&init='. $init;
	}
	return $linkLetterUrl;
}

// --------------------------------------------------------
// highlight of a search word
// http://blog.zuzara.com/2006/05/01/66/
// --------------------------------------------------------
function Glossary_replace_search_result($query, $str)
{
	$qq = array();
	foreach ($query as $val) {
		$qq[] = "'(".preg_quote($val).")'i";
	}
	return preg_replace($qq, "<font style=\"background: #FFFF40;\">$1</font>", $str);
}



function Glossary_functionGetInitial($term = '',$proc = '') {

	$term = stripslashes($term);
	$proc = stripslashes($proc);
	$init_t = $init_p = '';
	// _CHARSET XCL
	$init_t = mb_substr($term, 0, 1, _CHARSET);
	$init_p = mb_substr($proc, 0, 1, _CHARSET);

	return addslashes($init_p.$init_t);
}


// Alpha Array
// TODO
// /class/handler/Wordclass.php へ移動
function Glossary_functionAlphaArray($wordtype=0,$categoryid=0) {

	$xoopsDB =& Database::getInstance();
	global $xoopsConfig,$xoopsUser;
	// include the default language file for the module interface
	if ($wordtype == 1) {
		include (XOOPS_MODULE_PATH. '/glossary/language/'. $xoopsConfig['language'] .'/letter_japanese.php');
	} elseif ($wordtype == 2) {
		include (XOOPS_MODULE_PATH. '/glossary/language/'. $xoopsConfig['language'] .'/letter_number.php');
	} else {
		include (XOOPS_MODULE_PATH. '/glossary/language/'. $xoopsConfig['language'] .'/letter.php');
	}
	$alpha       = array();
	$letterlinks = array();
	$data        = array();

	$whereCategory = $categoryid ? "categoryid = '$categoryid' AND" : '';

	for ($n=0; $n < count($mb_id); $n++) {
		$data[$mb_linktext[$n]] = 0;
	}

	$sql = "SELECT init, COUNT(*) FROM ". $xoopsDB -> prefix("glossary_word"). " WHERE ".$whereCategory ." published > 0 GROUP BY BINARY init ORDER BY BINARY init ASC";
	$result = $xoopsDB->query($sql);

	while($temp = $xoopsDB->fetchArray($result)) {
		$data[$temp['init']] = $temp['COUNT(*)'];
		for ($n=0; $n < count($mb_id); $n++) {
			if (preg_match('/'.$mb_init[$n].'/',$temp['init'])) {
				$data[$mb_linktext[$n]] = $temp['COUNT(*)'] + $data[$mb_linktext[$n]];
			}
		}
	}
	for ($n=0; $n < count($mb_init); $n++) {
		if (isset($data[$mb_linktext[$n]])) {
			$letterlinks['total'] = $data[$mb_linktext[$n]];
		} else {
			$letterlinks['total'] = 0;
		}
		$letterlinks['id']        = $mb_id[$n];
		$letterlinks['linktext']  = $mb_linktext[$n];
		$letterlinks['separator'] = $mb_separator[$n];
		$alpha['initial'][]       = $letterlinks;
	}
	return $alpha;
}


?>