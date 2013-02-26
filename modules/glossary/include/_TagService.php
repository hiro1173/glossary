<?php
/*=====================================================================
  (C)2007 BeaBo Japan by Hiroki Seike
  http://beabo.net/
=====================================================================*/

// --------------------------------------------------------
// Tag Cloud Service                                                 Class
// --------------------------------------------------------
if (!defined('XOOPS_ROOT_PATH')) exit();

class TagService {

	// --------------------------------------------------------
	// Popular Tags
	// --------------------------------------------------------
	function &getPopularTags($limit = 30, $days = NULL) {
	
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;
	
		if (is_null($days) || !is_int($days)) {
			$span = '';
		} else {
			$span = ' AND W.submited > "'. time() - (86400 * $days) .'"';
		}
		$sql = 'SELECT T.tag, COUNT(T.tagid) AS bCount FROM '.$db -> prefix("glossary_tag").' AS T, '. $db -> prefix("glossary_word") .' AS W WHERE ';
		$sql .= 'W.wordid = T.wordid AND W.published = 1';
		$sql .= $span .'  GROUP BY T.tag ORDER BY bCount DESC, tag';
		$tags =& $db -> query($sql, $limit) ;
		$tagArray = array();
		while (list($tag, $count) = $db -> fetchRow($tags)) {
			array_push($tagArray, array(
				'tag'  => addSlashes($tag),
				'count' => intval($count),
			));
		}
		return $tagArray ;
	}

	// --------------------------------------------------------
	// All Tags
	// --------------------------------------------------------
	function &getAllTags($days = NULL) {
	
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;

		if (is_null($days) || !is_int($days)) {
			$span = '';
		} else {
			$span = ' AND W.submited > "'. time() - (86400 * $days) .'"';
		}
		$sql = 'SELECT T.tag, COUNT(T.tagid) AS bCount FROM '.$db -> prefix("glossary_tag").' AS T, '. $db -> prefix("glossary_word") .' AS W WHERE ';
		$sql .= 'W.wordid = T.wordid AND W.published = 1';
		$sql .= $span .'  GROUP BY T.tag ORDER BY tag';
		$tags =& $db -> query($sql) ;
		$tagArray = array();
		while (list($tag, $count) = $db -> fetchRow($tags)) {
			array_push($tagArray, array(
				'tag'  => addSlashes($tag),
				'count' => intval($count),
			));
		}
		return $tagArray ;
	}

	// --------------------------------------------------------
	// TagCloud
	// --------------------------------------------------------
	function tagCloud($tags = NULL, $steps = 5, $sizemin = 1, $sizemax = 6, $sortOrder = NULL) {
	
		if (is_null($tags) || count($tags) < 1) {
			return false;
		} 
	
		// $tags is original sort array
		$sortCountTags = $tags;
	
		// sort count
		foreach($sortCountTags as $value){
			$uesdcount[] = $value['count'];
		}
		array_multisort($uesdcount,SORT_DESC,SORT_NUMERIC, $sortCountTags);
	
		// count min $ max
		$min = $sortCountTags[count($sortCountTags) - 1]['count'];
		$max = $sortCountTags[0]['count'];
	
	
		for ($i = 1; $i <= $steps; $i++) {
			$delta = ($max - $min) / (2 * $steps - $i);
			$limit[$i] = $i * $delta + $min;
		} 
		$sizestep = ($sizemax - $sizemin) / $steps;
	
		foreach ($tags as $row) {
			$next = false;
			for ($i = 1; $i <= $steps; $i++) {
				if (!$next && $row['count'] <= $limit[$i]) {
					$size = $sizestep * ($i - 1) + $sizemin;
					$next = true;
				} 
			} 
			$tempArray = array('size' => $size . '%');
			$row = array_merge($row, $tempArray);
			$output[] = $row;
		} 

		if ($sortOrder == 'alphabet_asc') {
			sort($output);
		}
		return $output ;
	}

}


// --------------------------------------------------------
// RSS 出力
// --------------------------------------------------------
	// /rss.php/all/eコマース+日本
	// 実際はURLをエンコードして出力させる
?>