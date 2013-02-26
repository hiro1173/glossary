 <?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . '/glossary/class/AbstractListAction.class.php';
require_once XOOPS_MODULE_PATH . '/glossary/class/Glossary_PageNavigator.class.php';
require_once XOOPS_MODULE_PATH . '/glossary/include/functions.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/Glossary_SqlService.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/TagService.class.php';

class Glossary_CategoryViewAction extends Glossary_AbstractListAction
{

	var $mConfig = array();
	var $mPagenavi = null;
	var $totalCount = null;
	var $categoryItemArray = array();
	var $pageTitle = null;

	function _getId()
	{
		return xoops_getrequest('categoryid');
	}

	function _getStart()
	{
		return xoops_getrequest('start');
	}

	function _getWord()
	{
		return xoops_getrequest('word');
	}

	function _getPage()
	{
		return xoops_getrequest('page');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('category');
		return $handler;
	}

	function _getBaseUrl()
	{
		if ($this->mConfig['use_mod_rewrite']) {
			if (is_null($this->_getStart())) {
				$baseUrl = '' ;
			} else {
				$baseUrl = '../../' ;
			}
		} else {
			$baseUrl = 'index.php?action=CategoryView';
		}
		return $baseUrl;
	}


	function &_getPageNavi()
	{
		// chaneg page navi class
		if ($this->mConfig['use_mod_rewrite']) {
			// use extends XCube_PageNavigator
			$navi = new Glossary_PageNavigator($this->_getBaseUrl(), XCUBE_PAGENAVI_START);
			$navi->setStartKeyName('page');
			$navi->setfreezePerpage(false);  // TODO is this need ??
		} else {
			// use XCube_PageNavigator
			$navi =& parent::_getPageNavi();
		}
		$navi->setPerpage($this->mConfig['perpage']);
		$navi->setTotalItems($this->totalCount);
		if (!$this->mConfig['use_mod_rewrite']) {
			// add pagenavi parameter
			$navi->addExtra('categoryid', $this->mObject->get('categoryid'));
		}
		return $navi;
	}

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		// parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		$this->mConfig = $moduleConfig;
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		$handler =& $this->_getHandler();
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;
		$textFilter =& $root->getTextFilter();

		// moduleConfig
		$configUseModRewrite = $this->mConfig['use_mod_rewrite'];
		$configRndLength     = $this->mConfig['desrlength'];
		$configPerPage       = $this->mConfig['perpage'];


		$tagHandler =& xoops_getmodulehandler('tag');

		// parameter is not categoryid
		$categoryId  = $this->_getId();

		if ($categoryId > 0) {
			$this->mObject =& $handler->get($categoryId);
		} else {
			if ($configUseModRewrite) {
				$getCategoryWord = mb_convert_encoding(htmlspecialchars(urldecode($this->_getWord()), ENT_QUOTES) ,'UTF-8','auto');
				$categoryId = Glossary_SqlService::sqlGetId('glossary_category', 'categoryid', 'name', $getCategoryWord);
				// get category data
				$this->mObject =& $handler->get($categoryId);
			} else {
				$controller->executeRedirect('index.php', 1, _MD_GLOSSARY_ERORR_NOSUBMITTED);
			}
		}

		$this->breadcrumbs[] = array('name' => $root->mContext->mModule->mXoopsModule->getVar('name') , 'url' => XOOPS_MODULE_URL. '/glossary/' ) ;

		// set SQL start entry
		if ($configUseModRewrite) {
			if ($this->_getStart() > 1) {
				$startEntry = ($this->_getStart() -1) * $configPerPage ;
			} else {
				$startEntry = 0 ;
			}
		} else {
			$startEntry = $this->_getStart() ;
		}

		// get category item data
		$this->categoryItemArray = Glossary_SqlService::getCategoryWords($categoryId, $configPerPage, $startEntry, $configRndLength, $configUseModRewrite);
		
		if (!$this->categoryItemArray) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}
		
		
		$this->totalCount= Glossary_SqlService::getCategoryItemCount($categoryId);

		// Page navi
		if ($this->totalCount > $configPerPage ) {
			$this->mPagenavi =$this->_getPageNavi();
			$this->mPagenavi->fetch();
		}

		// Page Title
		$this->pageTitle = $root->mContext->mModule->mXoopsModule->getVar('name') .' &raquo; '. $this->mObject->get('name');

		return GLOSSARY_FRAME_VIEW_INDEX;
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
	
		$render->setTemplateName('glossary_category_view.html');
		$render->setAttribute('config'  , $this->mConfig);
		$render->setAttribute('object'    , $this->mObject);
		$render->setAttribute('word_items'  , $this->categoryItemArray);
		$render->setAttribute('total_count' , $this->totalCount);
		$render->setAttribute('pageNavi'   , $this->mPagenavi);

		$render->setAttribute('xoops_breadcrumbs' , $this->breadcrumbs) ;

		// mod rewrite設?E
		if ($this->mConfig['use_mod_rewrite'] > 1) {
			$GlossaryUrl = XOOPS_URL . '/glossary';
		} else {
			$GlossaryUrl = XOOPS_MODULE_URL. '/glossary';
		}
		$render->setAttribute('glossary_url', $GlossaryUrl);

		// for SEO , Metatag
		$metaDesc    = "";    // Description
		$metaKeyword = "";    // Keywords
		$render->setAttribute('xoops_pagetitle'  , $this->pageTitle ); 
		$render->setAttribute('xoops_meta_description', $metaDesc);
		$render->setAttribute('xoops_meta_keywords'   , $metaKeyword);

		$moduleHeader = '<link rel="stylesheet" type="text/css" href="' . XOOPS_MODULE_URL. '/glossary/module.css" />'."\n";
		$render->setAttribute('xoops_module_header', $moduleHeader);
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php';
		$categoryId  = $this->_getId();
		$GlossaryUrl = XOOPS_URL . '/glossary';
		$configUseModRewrite = $this->mConfig['use_mod_rewrite'];

		if ($this->_getWord()) {
			$getCategoryWord = mb_convert_encoding(htmlspecialchars(urldecode($this->_getWord()), ENT_QUOTES) ,'UTF-8','auto');
		}

		if ($categoryId > 0) {
			$GlossaryUrl = Glossary_functionGetWordUrl( $configUseModRewrite, $categoryId);
		} else {
			if ($configUseModRewrite > 1) {

				$categoryId = Glossary_SqlService::sqlGetId('glossary_category', 'categoryid', 'name', $getCategoryWord);
				$GlossaryUrl = Glossary_functionGetWordUrl( $configUseModRewrite, $categoryId );
			} else {
				$errorMassage = _MD_GLOSSARY_WORD_EDIT_ERROR;
			}
		}
		if ($configUseModRewrite > 1) {
			$GlossaryUrl = XOOPS_URL . '/glossary';
		} else {
			$GlossaryUrl = XOOPS_MODULE_URL. '/glossary';
		}

		$controller->executeRedirect($GlossaryUrl, 1, _MD_GLOSSARY_WORD_EDIT_ERROR);
	}



}
?>
