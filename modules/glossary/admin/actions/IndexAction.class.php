<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractIndexAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/include/functions.php';

class Glossary_indexAction extends Glossary_AbstractIndexAction
{
	var $mConfig      = array();
	var $categoryItem = array();
	var $newWord      = array();
	var $notPublished = array();
	var $wordeCount   = 0;

	// for menu
	var $breadCrumbs = array();
	var $confirmMssage = null;
	var $moduleHeader = null;

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('word');
		return $handler;
	}

	function _getBaseUrl()
	{
		return './index.php';
	}

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
//		parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		$this->mConfig = $moduleConfig;
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		// オブジェクトが無ければ、エラーを返す
		if ($this->mObject == null) {
			$this->confirmMssage = _AD_GLOSSARY_MAIN_NOTENTORY_CONFIRM;
		}

		// --------------------------------------------------------
		// Initial setting
		// 初期化
		// --------------------------------------------------------
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;
		$textFilter =& $root->getTextFilter();    // テキストフィルター
		// moduleConfig
		// モジュール設定
		$configDesrLength      = $this->mConfig['desrlength'];    // Number of the indication description
		$activeCategory = $this->mConfig['use_category'] ;

		$readfile = XOOPS_ROOT_PATH."/common/fckeditor/" ;
		if (!file_exists($readfile)) {
			if ($this->confirmMssage == null) {
				$this->confirmMssage = sprintf(_AD_GLOSSARY_ERROR_SMARTYPLUGIN, XOOPS_URL);
			} else {
				$this->confirmMssage .= '<br />'. sprintf(_AD_GLOSSARY_ERROR_SMARTYPLUGIN, XOOPS_URL);
			}
		}


		$readfile = XOOPS_ROOT_PATH."/class/smarty/plugins/function.fck_htmlarea.php" ;
		if (!file_exists($readfile)) {
			if ($this->confirmMssage == null) {
				$this->confirmMssage = sprintf(_AD_GLOSSARY_ERROR_SMARTYPLUGIN, XOOPS_URL);
			} else {
				$this->confirmMssage .= '<br />'. sprintf(_AD_GLOSSARY_ERROR_SMARTYPLUGIN, XOOPS_URL);
			}
		}

		// Count Words
		// 用語のカウント
		$handler =& xoops_getmodulehandler('word');
		$mCriteria = new CriteriaCompo();
		$this->wordeCount = $handler->getCount($mCriteria);

		// --------------------------------------------------------
		// 新着用語　最新10件
		// --------------------------------------------------------
		$sql = 'SELECT c.categoryid, name, w.wordid, term, proc, w.init,w.description, hits, submited FROM '. $db->prefix('glossary_word').' w '.
			'LEFT JOIN '. $db->prefix('glossary_category').' c ON c.categoryid = w.categoryid  AND w.wordid >0 ORDER BY submited DESC';
		$resultNew = $db->query($sql, 10, 0);
		if ( $db->getRowsNum($resultNew) >0 ) {
			while (list($categoryId, $name, $wordId, $term, $proc, $init, $wordDesc, $hits, $submited) = $db->fetchRow($resultNew)) {
				$wordDesc = $textFilter->toShowTarea($wordDesc, $html=1, $smiley=1, $xcode=1, $image=1, $br=1);
				$wordDesc = strip_tags($wordDesc);
				if ( XOOPS_USE_MULTIBYTES ) {
					$wordDesc = xoops_substr( $wordDesc, 0, $configDesrLength +2 );
				} else {
					$wordDesc = substr( $wordDesc, 0, $configDesrLength -1 ) . '...';
				}
				$this->newWord[] = array(
					'wordid'      => intval($wordId),
					'categoryId'  => intval($categoryId),
					'category'    => addSlashes($name),
					'term'        => addSlashes($term),
					'proc'        => addSlashes($proc),
					'init'        => addSlashes($init),
					'hits'        => addSlashes($hits),
					'submited'    => $submited,
					'description' => $wordDesc,
				);
			}
		}

		// --------------------------------------------------------
		// 非公開データ
		// --------------------------------------------------------
		$sql = 'SELECT c.categoryid, name, w.wordid, term, proc, w.init,w.description, hits, submited FROM '. $db->prefix('glossary_category').' c '.
			'LEFT JOIN '. $db->prefix('glossary_word').' w ON c.categoryid = w.categoryid WHERE w.published = 0 ORDER BY submited DESC';
		$resultNotPublished = $db->query($sql);
		if ( $db->getRowsNum($resultNotPublished) > 0 ) {
			while (list($categoryId, $name, $wordId, $term, $proc, $init, $wordDesc, $hits, $submited) = $db->fetchRow($resultNotPublished)) {
				$wordDesc = $textFilter->toShowTarea($wordDesc, $html=1, $smiley=1, $xcode=1, $image=1, $br=1);
				$wordDesc = strip_tags($wordDesc);
				if ( !XOOPS_USE_MULTIBYTES ) {
					$wordDesc = substr ( $wordDesc, 0, $configDesrLength -1 ) . '...';
				} else {
					$wordDesc = substr( $wordDesc, 0, $configDesrLength +2 );
				}
				$this->notPublished[] = array(
					'wordid'      => intval($wordId),
					'category'    =>addSlashes($name),
					'term'        => addSlashes($term),
					'proc'        => addSlashes($proc),
					'init'        => addSlashes($init),
					'hits'        => addSlashes($hits),
					'submited'    => $submited ,
					'description' => $wordDesc,
				);
			}
		}
		return GLOSSARY_FRAME_VIEW_INDEX;
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;
		$render->setTemplateName('glossary_index.html');
		$render->setAttribute('module_info'   , getModuleInfo());
		$render->setAttribute('moduleHeader'  , $this->moduleHeader);
//		$render->setAttribute('bread_crumbs'  , $this->breadCrumbs);
		$render->setAttribute('set_menu'      , $adminmenu );
		$render->setAttribute('set_menu_no'   , 1);
		$render->setAttribute('set_mssage'    , $this->confirmMssage);
		$render->setAttribute('newWord'      , $this->newWord);
		$render->setAttribute('notPublished' , $this->notPublished);
	}

}
?>