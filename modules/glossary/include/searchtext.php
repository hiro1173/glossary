<?php
/**
 * highlight of a search word
 * @param string $query   検索クエリ。スペースを挟んで複数でもOK。
 * @param string $text    検索結果文字列
 * @param int    $textrnd 文字列の$textrnd文字を抜き出す
 * @param int    $textpos 単語の前$textpos文字を抜き出す
 * @return string ハイライト済みHTML
 */

define('_BACKGROUND_COLOR', "#FFFF40");

function replace_search_text($query, $text, $textrnd=100, $textpos=30)
{

	$patternWrod = $textPos = array();
	$addText = '';
	$textPosison =0;

	// Change space ZENKAKU to HANKAKU
	if ( XOOPS_USE_MULTIBYTES ) {
		$query  = str_replace(_MD_GLOSSARY_WORDSPACEZEN, _MD_GLOSSARY_WORDSPACEHAN, $query);
	}

	$queryWordArray = preg_split("'[\\s,]+'", $query, -1, PREG_SPLIT_NO_EMPTY);

	foreach ($queryWordArray as $val) {
		$queryWord = preg_quote($val);
		$patternWrod[] = "'(". $queryWord. ")'i";
		// start text position
		$startTextPos = strpos($text, $queryWord);
		if ($startTextPos >0 ) {
			$textPos[] = strpos($text, $queryWord);
		}
	}

	// Get start text position
	if (count($textPos) > 0 ) {
		sort($textPos);
		$textPosison = $textPos[0];
		if ($textPosison > 30) {
			$addText = '...';
			$startPosison = $textPosison -30;
		} else {
			$startPosison = 0;
		}
	}

	$text = $addText .xoops_substr( $text, $startPosison, $textrnd );
	$text = preg_replace($patternWrod, "<font style=\"background: ". _BACKGROUND_COLOR. ";\">$1</font>", $text);

	return $text;
}

function contents_make_context($text, $words, $roundLength = 255) {
	static $strcut = "";
	if (!$strcut) {
		// 文字分割に使うコマンドをmb_strcutの有無で変更
		$strcut = create_function('$a,$b,$c', (function_exists('mb_strcut'))? 'return mb_strcut($a,$b,$c);': 'return strcut($a,$b,$c);');
	}
	if (!is_array($words)) $words = array();
	$ret = "";
	$queryWrod = str_replace(" ","|",preg_quote(join(' ',$words),"/"));
	if (preg_match("/$queryWrod/i",$text,$match)) {
		$ret = ltrim(preg_replace('/\s+/', ' ', $text));
		list($pre, $aft)=preg_split("/$queryWrod/i", $ret, 2);
		$m = intval($roundLength/2);
		$ret = (strlen($pre) > $m)? "... " : "";
		$ret .= $strcut($pre, max(strlen($pre)-$m+1,0),$m).$match[0];
		$m = $roundLength-strlen($ret);
		$ret .= $strcut($aft, 0, min(strlen($aft),$m));
		// highlight of a search word
		$replacements = '<font style="background: #FFFF40;"> '.$match[0].' </font>';
		$ret = preg_replace("/$queryWrod/i", $replacements, $ret);
		if (strlen($aft) > $m) $ret .= " ...";
	}
	if (!$ret) $ret = $strcut($text, 0, $roundLength);
	return $ret;
}


?>