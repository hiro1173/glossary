<?php
/*=====================================================================
  (C)2007 BeaBo Japan by Hiroki Seike
  http://beabo.net/
=====================================================================*/
if (!defined('XOOPS_ROOT_PATH')) exit();

// --------------------------------------------------------
// Sql Service Class
// --------------------------------------------------------
class SqlService {
		// --------------------------------------------------------
		// defukt view
		// --------------------------------------------------------
		
		function getFeaturedWords($sqlPram = '',$configUseModRewrite = false) 
		{
			$root =& XCube_Root::getSingleton();
			$textFilter =& $root->getTextFilter();
			$db =& $root->mController->mDB;
			$tagHandler =& xoops_getmodulehandler('tag');
		
			$retArray = array();
		
			$sql = "SELECT c.categoryid, c.name, w.wordid, term, w.english, proc, w.description ,w.published FROM ". $db -> prefix("glossary_category")." c ".
				"LEFT JOIN ". $db -> prefix("glossary_word")." w ON c.categoryid = w.categoryid WHERE block > 0". $sqlPram. " ORDER BY submited DESC";
			$result = $db -> query($sql);
			while (list($categoryId, $categoryName, $wordId, $term, $english, $proc, $wordDesc, $wordPublished) = $db -> fetchRow($result)) {
				$wordDesc = $textFilter->toShowTarea($wordDesc, $html=1, $smiley=1, $xcode=0, $image=1, $br=1,false);
				$wordDesc = preg_replace('!<script.*?>.*?</script.*?>!is', '', $wordDesc);
				$wordDesc = strip_tags($wordDesc);
				if ( !XOOPS_USE_MULTIBYTES ) {
					$wordDesc = substr ( $wordDesc, 0, $configDesrLength -1 ) . "...";
				} else {
					$wordDesc = xoops_substr( $wordDesc, 0, $configDesrLength +2 );
				}
				// タグクラウドの単語のリスト取り出し
				$wordTagArray = $tagHandler->getEntoryTagArray($wordId);
				// オブジェクトを分解して、タグのHTMLを作成する
				$tagLinks ='';
				foreach ($wordTagArray as $key => $val) {
					$tagLinkUrl = Glossary_functionGetTagUrl( $configUseModRewrite, $val );
					$tagLinks .= '<a href="'. $tagLinkUrl .'">'.$val. '</a>';
				}
				$blolckWord = array(
					'term'        => $term,
					'category'    => $categoryName,
					'english'     => $english,
					'proc'        => $proc,
					'word_desc'   => $wordDesc,
					'published'   => intval($wordPublished),
					'linkWordUrl' => Glossary_functionGetWordUrl( $configUseModRewrite, intval($wordId), addSlashes($term), addSlashes($categoryName) ),
					'tags'        => $tagLinks,
				);
				array_push($retArray , $blolckWord );
				unset ($blolckWord) ;
			}
			return $retArray;
		}
		
		
		// --------------------------------------------------------
		// Related Words
		// --------------------------------------------------------
		function getRelationWords($wordId=0, $wordTerm='', $configUseModRewrite = false) 
		{
		
			$root =& XCube_Root::getSingleton();
			$db =& $root->mController->mDB;
			$retArray = array();
			if ($wordId > 0) {
				$sql = "SELECT c.categoryid, c.name, w.wordid, w.term FROM ". $db -> prefix("glossary_category")." c ".
					"LEFT JOIN ". $db -> prefix("glossary_word").
					" w ON c.categoryid = w.categoryid WHERE wordid<>". $wordId. " AND w.`description` LIKE '%". $wordTerm ."%' AND published > 0 ORDER BY submited DESC";
				$result = $db -> query($sql, 10, 0) ;
				while (list($categoryId, $categoryName, $wordId, $wordTerm) = $db -> fetchRow($result)) {
					array_push($retArray, array(
						'term'         => htmlSpecialChars($wordTerm, ENT_QUOTES) ,
						'linkWordUrl' => Glossary_functionGetWordUrl( intval($configUseModRewrite), intval($wordId), htmlSpecialChars($wordTerm, ENT_QUOTES), htmlSpecialChars($categoryName, ENT_QUOTES)),
					));
				}
			}
			return $retArray;
		}
		
		// --------------------------------------------------------
		// New Words
		// --------------------------------------------------------
		function getNewWords($viewCount=10, $configUseModRewrite = false, $viewWordId=0, $viewCategoryId=0) 
		{
			$root =& XCube_Root::getSingleton();
			$db =& $root->mController->mDB;
			$retArray = array();
			$selectWordId = $selectCategory ='';
		
			if ($viewWordId > 0) $selectWordId = " AND wordid<>". intval($viewWordId) ;
			if ($viewCategoryId > 0) $selectCategory = " AND c.categoryid=". intval($viewCategoryId) ;
		
			$sql = "SELECT c.categoryid, c.name, w.wordid, w.term FROM ". $db -> prefix("glossary_category")." c ".
				"LEFT JOIN ". $db -> prefix("glossary_word")." w ON c.categoryid = w.categoryid WHERE published > 0". $selectWordId. $selectCategory." ORDER BY submited DESC";
			$result = $db -> query($sql, intval($viewCount), 0) ;
			while (list($categoryId, $categoryName, $wordId, $wordTerm) = $db -> fetchRow($result)) {
				array_push($retArray, array(
					'term'        => htmlSpecialChars($wordTerm, ENT_QUOTES),
					'linkWordUrl' => Glossary_functionGetWordUrl( intval($configUseModRewrite), intval($wordId), htmlSpecialChars($wordTerm, ENT_QUOTES), htmlSpecialChars($categoryName, ENT_QUOTES) ),
				));
			}
			return $retArray;
		}
		
		// --------------------------------------------------------
		// Hits Word
		// --------------------------------------------------------
		function getHitsWords($viewCount=10, $configUseModRewrite = false, $viewWordId=0, $viewCategoryId=0) 
			{
			$root =& XCube_Root::getSingleton();
			$db =& $root->mController->mDB;
			$retArray = array();
			$selectWordId = $selectCategory = $sqlParm ='';
			if ($viewWordId > 0 or $viewCategoryId > 0) {
				$sqlParm = "WHERE ";
				if ($viewWordId > 0) $selectWordId = "wordid<>". intval($viewWordId) ;
				if ($viewWordId > 0 and $viewCategoryId > 0){
					$selectCategory = " AND c.categoryid=". intval($viewCategoryId) ;
				} else {
					$selectCategory = "c.categoryid=". intval($viewCategoryId) ;
					}
			}
			$sql = "SELECT c.categoryid, c.name, w.wordid, w.term FROM ". $db -> prefix("glossary_category")." c LEFT JOIN ". $db -> prefix("glossary_word")." w ON c.categoryid = w.categoryid ". $sqlParm . $selectWordId. $selectCategory. " ORDER BY w.hits DESC";
			$result = $db -> query($sql, intval($viewCount), 0) ;
			while (list($categoryId, $categoryName, $wordId, $wordTerm) = $db -> fetchRow($result)) {
				array_push($retArray, array(
					'term'        =>htmlSpecialChars($wordTerm, ENT_QUOTES),
					'linkWordUrl' => Glossary_functionGetWordUrl( intval($configUseModRewrite), intval($wordId), htmlSpecialChars($wordTerm, ENT_QUOTES), htmlSpecialChars($categoryName, ENT_QUOTES) ),
				));
			}
			return $retArray;
		}
		
		// --------------------------------------------------------
		// Categiry Word
		// --------------------------------------------------------
		function getCategoryWords($categoryId=0, $viewCount=10, $configUseModRewrite = false ) 
		{
			$root =& XCube_Root::getSingleton();
			$textFilter =& $root->getTextFilter();
			$db =& $root->mController->mDB;
			$tagHandler =& xoops_getmodulehandler('tag');
		
			$retArray = array();
		
			$sql = "SELECT w.wordid, w.categoryid ,term, proc, init, w.description, c.name FROM ". $db -> prefix("glossary_word")." w ".
				"LEFT JOIN ". $db -> prefix("glossary_category")." c ON w.categoryid = c.categoryid ".
				" WHERE w.categoryid=" . $categoryId ." AND published > 0 ORDER BY init ASC";
			$result = $db -> query($sql);
			$this->totalCount = $db -> getRowsNum($result);
			if ($this->totalCount > 0) {
				$result = $db -> query($sql, $configPerPage, $startEntry );
				while (list($wordId, $categoryId, $term, $proc, $init, $wordDesc, $categoryName) = $db -> fetchRow($result)) {
					$wordUrl = Glossary_functionGetWordUrl( $configUseModRewrite, intval($wordId), addSlashes($term));
					// delete HTML tag script
					$wordDesc = $textFilter->toShowTarea($wordDesc, $html=1, $smiley=1, $xcode=0, $image=1, $br=1,false);
					$wordDesc = preg_replace('!<script.*?>.*?</script.*?>!is', '', $wordDesc);
					$wordDesc = strip_tags($wordDesc);
					if ( !XOOPS_USE_MULTIBYTES ) {
						$wordDesc = substr( $wordDesc, 0, $configDesrLength -1 ) . "...";
					} else {
					$wordDesc = xoops_substr( $wordDesc, 0, $configDesrLength +2 );
				}
				// タグクラウドの単語のリスト取り出し
				$wordTagArray = $tagHandler->getEntoryTagArray($wordId);
				// オブジェクトを分解して、タグのHTMLを作成する
				$tagLinks ='';
				foreach ($wordTagArray as $key => $val) {
					$tagLinkUrl = Glossary_functionGetTagUrl( $configUseModRewrite, $val );
					$tagLinks .= '<a href="'. $tagLinkUrl .'">'.$val. '</a>';
				}
				$wordItemArray = array(
					'term'          => addSlashes($term),
					'proc'          => addSlashes($proc),
					'word_desc'     => $wordDesc,
					'category'  => addSlashes($categoryName),
					'linkWordUrl'   => $wordUrl,
					'tags'         => $tagLinks,
				);
				array_push($retArray, $wordItemArray );
			}
		}
		return $retArray;
	}
	
	// --------------------------------------------------------
	// SQL Function get field value
	// --------------------------------------------------------
	function sqlGetId($dbName='', $selFieldName='', $orderFiled='', $orderValue='') {
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;
		if ($dbName =='' and $selFieldName=='' and $orderFiled=='' and $orderValue=='') {
			return false;
		}
		$sql = "SELECT `".$selFieldName."` FROM ". $db->prefix( $dbName )." WHERE `". $orderFiled. "`='". $orderValue. "' LIMIT 1" ;
		if ($result = $db->query($sql)) {
			list($thing) = $db->fetchRow($result);
				$ret = $thing ;
			return $ret;
		} else {
			return false;
		}
	}
	
	
	// --------------------------------------------------------
	// SQL Function get field value
	// --------------------------------------------------------
	function sqlGetFieldValue($dbName='', $selFieldName='', $orderFiled='', $orderValue='',$optionSelect='') {
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;
		if ($dbName =='' and $selFieldName=='' and $orderFiled=='' and $orderValue=='') {
			return false;
		}
		if ($optionSelect <>'') $optionSelect = " AND ".$optionSelect ;
		$sql = "SELECT `".$selFieldName."` FROM ". $db->prefix( $dbName )." WHERE `". $orderFiled. "`=". $orderValue. $optionSelect. " LIMIT 1" ;
		if ($result = $db->query($sql)) {
			list($thing) = $db->fetchRow($result);
			$ret = $thing ;
			return $ret;
		} else {
			return false;
		}
	}
	
	// --------------------------------------------------------
	// SQL Function get field count
	// --------------------------------------------------------
	function sqlCountField($dbName='', $selFieldName='', $orderFiled='', $optionSelect='') {
	
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;
	
		if ($dbName =='') {
			return false;
		}
		if ( $selFieldName<>'' and $orderFiled<>'' ) {
			$whereSelect = " WHERE ".$selFieldName."=". $orderFiled ;
		} else {
			$whereSelect = '';
		}
		if ($optionSelect <>'') {
			if ($whereSelect <>'') {
				$optionSelect = " AND ".$optionSelect ;
			} else {
				$optionSelect = " WHERE ".$optionSelect ;
			}
		}
		$count = 0;
		$sql = "SELECT COUNT(*) FROM ". $db -> prefix( $dbName ). $whereSelect .$optionSelect ;
		$result = $db -> query($sql);
		list($thing) = $db -> fetchRow($result);
		$count = $thing;
		return $count;
	}
	
	
	// --------------------------------------------------------
	// $next_order = sqlGetNextFieldValue($dbName, $selFieldName, $orderFiled, $orderValue) ;
	// --------------------------------------------------------
	function sqlGetNextFieldValue($dbName='', $selFieldName='', $orderFiled='', $orderValue='') {
	{
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;
	
		if ($dbName=='' && $selFieldName=='' ) {
			return false;
		}
		if ($orderFiled=='' && $orderValue =='') {
			$whereSelect = '';
		} else {
			$whereSelect = " WHERE ". $orderFiled. "=". $orderValue ;
		}
		global $db;
		$sql = "SELECT MAX(". $selFieldName. ") FROM ". $db -> prefix( $dbName ). $whereSelect ;
		$result = $db -> query($sql);
		list($thing) = $db -> fetchRow($result);
		$count = $thing + 1;
		return $count;
		}
	}
	
	
	// --------------------------------------------------------
	// Read Module Config
	// --------------------------------------------------------
	function sqlModuleConfigValue($moduleDirName='', $configName='') {
	
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;
	
		if ($moduleDirName =='' or $configName=='') {
			return false;
		}
		$sql = "SELECT conf_value FROM "
		. $db -> prefix( 'modules' ). " m LEFT JOIN "
		. $db -> prefix( 'config' ). " c ON m.mid=c.conf_modid WHERE isactive =1 AND dirname='". $moduleDirName. "' LIMIT 1" ;
		if ($result = $db -> query($sql)) {
			list($configValue) = $db -> fetchRow($result);
			return $configValue;
		} else {
			return false;
		}
	}
}

?>
