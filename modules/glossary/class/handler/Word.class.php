<?php

//echo 'Word.class.php<br />';

if (!defined('XOOPS_ROOT_PATH')) exit();

class GlossaryWordObject extends XoopsSimpleObject
{
	function GlossaryWordObject()
	{
		$this->initVar('wordid'     , XOBJ_DTYPE_INT    , '0', true );
		$this->initVar('categoryid' , XOBJ_DTYPE_INT    , '0', true );
		$this->initVar('term'       , XOBJ_DTYPE_STRING , '' , true ,255);
		$this->initVar('english'    , XOBJ_DTYPE_STRING , '' , true ,255);
		$this->initVar('proc'       , XOBJ_DTYPE_STRING , '' , true ,255);
		$this->initVar('init'       , XOBJ_DTYPE_STRING , '' , true ,10);
		$this->initVar('description', XOBJ_DTYPE_TEXT   , '' , true );
		$this->initVar('reference'  , XOBJ_DTYPE_STRING , '' , true ,255);
		$this->initVar('url'        , XOBJ_DTYPE_STRING , '' , true ,255);
		$this->initVar('submitter'  , XOBJ_DTYPE_INT    , '0', true );
		$this->initVar('submited'   , XOBJ_DTYPE_INT    , '0', true );
		$this->initVar('hits'       , XOBJ_DTYPE_INT    , '0', true );
		$this->initVar('block'      , XOBJ_DTYPE_INT    , '0', true );
		$this->initVar('published'  , XOBJ_DTYPE_BOOL   , '1', true );
	}

}

class GlossaryWordHandler extends XoopsObjectGenericHandler
{
	var $mTable   = 'glossary_word';
	var $mPrimary = 'wordid';
	var $mClass   = 'GlossaryWordObject';

	function GlossaryWordDataHandler(&$db) {
		parent::XoopsObjectGenericHandler($db);
	}

	// --------------------------------------------------------
	// hits counter 
	// $countUp = $handler->hitCountUp($this->_getId());
	// --------------------------------------------------------
	function hitCountUp($wordid=0)
	{
		$sql = sprintf("UPDATE `%s` SET `hits`=`hits`+1 WHERE `wordid`=%u", $this->mTable , $wordid ) ;
		return $this->db->queryF($sql);
	}

	// --------------------------------------------------------
	// String feiled Update
	// use for inline edit (Ajax)
	// inplace.php
	// --------------------------------------------------------
	function updateValue($wordid=0, $fieldName= NULL, $updateValue)
	{
		// $fieldName
		// TODO
		// Chack Field Name
		$sql = sprintf("UPDATE `%s` SET `%s` = '%s' WHERE `wordid`=%u LIMIT 1 ", $this->mTable , $fieldName, $updateValue, $wordid ) ;
		$result = $this->db->query($sql);
		if ($result) {
			return true;
		} else {
			return false;
		}
	}


	// --------------------------------------------------------
	// カテゴリ別の用語数合計
	// $count_total = GlossaryWord::cntTotal ($categoryid);
	// --------------------------------------------------------
	function cntTotal($categoryid=0)
	{
		if ($categoryid) {
			$where_sel = " WHERE categoryid =". $categoryid ;
		} else {
			$where_sel = "";
		}
		global $xoopsDB;
		$count = 0;
		$sql = "SELECT COUNT(*) FROM ". $this->mTable . $where_sel ;
		$result = $this->db->query($sql);
		list($thing) = $xoopsDB -> fetchRow($result);
		return $thing;
	}

	// --------------------------------------------------------
	// アルファベット呼び出しを追加
	// $alpha_Array = GlossaryWord::alphaArray($wordtype, $categoryid);
	// --------------------------------------------------------
	function alphaArray($wordtype=0,$categoryid=0) {

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

		$sql = sprintf("SELECT init, COUNT(*) FROM `%s` WHERE ".$whereCategory ." published > 0 GROUP BY BINARY init ORDER BY BINARY init ASC" , $this->mTable) ;
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

}

?>
