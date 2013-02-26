<?php
/*=====================================================================
  (C)2007 BeaBo Japan by Hiroki Seike
  http://beabo.net/
=====================================================================*/
//echo 'TagListAction.class.php<br />';

// チE?Eタベ?Eスの取得にチE?Eタハンドラを使わずにSQLで取得した時の
// ペ?Eジ移動?Eサンプルになります、E

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractListAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/forms/TagAdminFilterForm.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/include/functions.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/menu.php' ;

class Glossary_TagListAction extends Glossary_AbstractListAction
{
	var $mConfig = array();        // module config
	var $tagArray = array();
	var $mPagenavi = null;      // ペ?Eジ移勁E
	var $totalCount = null;     // 合計数

	// for menu
	var $breadCrumbs = array();
	var $confirmMssage = null;


	// 表示開始?E?E
	function _getStart()
	{
		return xoops_getrequest('start');
	}

	// *** ペ?Eジ移勁E***
	// 表示の並び替ぁE
	function _getSort()
	{
		return xoops_getrequest('sort');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('tag');
		return $handler;
	}

	// *** ペ?Eジ移勁E***
	// オーバ?EライチE
	// /class/AbstractListAction.class.php の getDefaultView() 
	function &_getFilterForm()
	{
		// /glossary/admin/forms/CategoryFilterForm.class.php';
		// Glossary_CategoryFilterFormクラスを定義
		$filter = new Glossary_TagAdminFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return 'index.php?action=TagList';
	}

	// *** ペ?Eジ移勁E***
	//  /class/AbstractFilterForm.class.php 
	// _getPageNavi オーバ?EライチE
	function &_getPageNavi()
	{
		$navi =& parent::_getPageNavi();

		$navi->setStart($this->_getStart());          // 開始?E
		$navi->setPerpage($this->mConfig['perpage']);
		$navi->setTotalItems($this->totalCount);                // 合計数
		return $navi;
	}

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
//		parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		// モジュールの一般設定?E値
		$this->mConfig = $moduleConfig;
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		// echo によるチE??チE??可能

		$configPerPage    = $this->mConfig['perpage'];    // ペ?Eジあたり?E表示件数
		$startEntry = $this->_getStart() ;          // SQL開始?E

		// *** ペ?Eジ移勁E***
		// /admin/forms/TagFilterForm.class.php からパラメータを得る
		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();

		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;

		// TODO SQLが?E
		$sql = 'SELECT T.tag, COUNT(T.tagid) AS bCount FROM '.$db -> prefix("glossary_tag").' AS T, '. $db -> prefix("glossary_word") 
		.' AS W WHERE W.wordid = T.wordid GROUP BY T.tag ORDER BY '. $this->mFilter->getSort().' '. $this->mFilter->getOrder();
		$result = $db->query($sql);

		$this->totalCount = $db->getRowsNum($result) ;
		if (!$this->totalCount > 0) {
			$this->confirmMssage = _AD_GLOSSARY_TAG_NOSUBMITTED ;
		} else {
			$result = $db->query($sql, $configPerPage, $startEntry );
			while (list($tag, $count) = $db -> fetchRow($result)) {
				array_push($this->tagArray, array(
					'tag'   => htmlSpecialChars($tag, ENT_QUOTES) ,
//					'tag'   => addSlashes($tag),
					'count' => intval($count),
					));
			}

			// *** ペ?Eジ移勁E***
			$this->mPagenavi = $this->_getPageNavi();
			// sort を指定してぁE??ら、並び替え?Eパラメータを渡ぁE
			if ( abs($this->_getSort()) > 0) {
				$this->mPagenavi->addExtra('sort', $this->_getSort());
			}
		}
		
		return GLOSSARY_FRAME_VIEW_INDEX;
	}



	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;

		$this->breadCrumbs[] = array('name' => _AD_GLOSSARY_TAG_LIST) ;

		$render->setTemplateName('glossary_tag_list.html');

		$render->setAttribute('module_info'   , getModuleInfo());
		$render->setAttribute('bread_crumbs'  , $this->breadCrumbs);
		$render->setAttribute('set_menu'      , $adminmenu );
		$render->setAttribute('set_menu_no'   , 3);
		$render->setAttribute('set_mssage'    , $this->confirmMssage);


		// *** ペ?Eジ移勁E***
		$render->setAttribute("sortNavi"   , $this->_getPageNavi());    // タイトルの並び頁E??更
		$render->setAttribute('pageNavi'   , $this->mPagenavi);         // ペ?Eジ移勁E
		$render->setAttribute('tag_array'  , $this->tagArray);          // 表示チE?Eタ
	}



}
?>
