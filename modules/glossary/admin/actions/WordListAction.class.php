<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractListAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/forms/WordAdminFilterForm.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/include/functions.php';


class Glossary_WordListAction extends Glossary_AbstractListAction
{
	var $mConfig = array();
	var $wordArray = array();

	var $mPagenavi = null;
	var $totalCount = null;

	// for menu
	var $breadCrumbs = array();
	var $confirmMssage = null;
	var $moduleHeader = null;

	function _getStart()
	{
		return xoops_getrequest('start');
	}

	function _getSort()
	{
		return xoops_getrequest('sort');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('word');
		return $handler;
	}

	function &_getFilterForm()
	{
		$filter = new Glossary_WordAdminFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return 'index.php?action=WordList';
	}

	function &_getPageNavi()
	{
		$navi =& parent::_getPageNavi();
		$navi->setStart($this->_getStart());
		$navi->setPerpage($this->mConfig['perpage']);
		$navi->setTotalItems($this->totalCount);
		return $navi;
	}

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
//		parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		$this->mConfig = $moduleConfig;
	}

	// Override getDefaultView()
	function getDefaultView(&$controller, &$xoopsUser)
	{

		// オブジェクトが無ければ、エラーを返す
		// List は?E??形
//		if ($this->mObjects == null) {
//			$this->confirmMssage = _AD_GLOSSARY_WORD_NOSUBMITTED ;
//		}

		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;
		$textFilter =& $root->getTextFilter();

		$configPerPage    = $this->mConfig['perpage'];
		$configDesrLength  = $this->mConfig['desrlength'];
		$startEntry = $this->_getStart() ;

		$this->mFilter =& $this->_getFilterForm();
		$this->mFilter->fetch();

		$sql = 'SELECT c.categoryid, c.name, w.wordid, w.term, w.proc, w.init, w.description, w.hits, w.submited FROM '. $db->prefix('glossary_word').' w '.
			'LEFT JOIN '. $db->prefix('glossary_category').' c ON c.categoryid = w.categoryid  AND w.wordid >0 ORDER BY '. $this->mFilter->getSort().' '. $this->mFilter->getOrder();
		$result = $db->query($sql);

		$this->totalCount = $db->getRowsNum($result) ;
		if ($this->totalCount < 1) {
			$this->alertMssage = _AD_GLOSSARY_WORD_NOSUBMITTED;
		}

		$result = $db -> query($sql, $configPerPage, $startEntry );
		if ( $db->getRowsNum($result) >0 ) {
			while (list($categoryId, $name, $wordId, $term, $proc,  $init, $wordDesc, $hits, $submited) = $db->fetchRow($result)) {
				$wordDesc = $textFilter->toShowTarea($wordDesc, $html=1, $smiley=1, $xcode=1, $image=1, $br=1);
				$wordDesc = strip_tags($wordDesc);
				if ( XOOPS_USE_MULTIBYTES ) {
					$wordDesc = xoops_substr( $wordDesc, 0, $configDesrLength +2 );
				} else {
					$wordDesc = substr ( $wordDesc, 0, $configDesrLength -1 ) . '...';
				}
				$this->wordArray[] = array(
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

		$this->mPagenavi = $this->_getPageNavi();
		if ( abs($this->_getSort()) > 0) {
			$this->mPagenavi->addExtra('sort', $this->_getSort());
		}
		return GLOSSARY_FRAME_VIEW_INDEX;
	}



	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;
		$this->breadCrumbs[] = array('name' => _AD_GLOSSARY_WORD_LIST ,'url'  => 'index.php?action=WordList' ) ;

		$render->setTemplateName('glossary_word_list.html');

		$render->setAttribute('module_info'   , getModuleInfo());
		$render->setAttribute('moduleHeader'  , $this->moduleHeader);
		$render->setAttribute('bread_crumbs'  , $this->breadCrumbs);
		$render->setAttribute('set_menu'      , $adminmenu );
		$render->setAttribute('set_menu_no'   , 2);
		$render->setAttribute('set_mssage'    , $this->confirmMssage);

		$render->setAttribute("sortNavi"      , $this->_getPageNavi());
		$render->setAttribute('pageNavi'      , $this->mPagenavi);
		$render->setAttribute('wordArray'     , $this->wordArray);
	}

}
?>
