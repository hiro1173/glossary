<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractIndexAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/Glossary_SqlService.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/TagService.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/include/functions.php';

class Glossary_indexAction extends Glossary_AbstractIndexAction
{

	// my setting
	var $mConfig = array();
	var $mPagenavi = null;
	var $isAdmin = null;

	// for template
	var $moduleHeader = null;
	var $breadcrumbs = array();

	// view itme
	var $categoryItem       = array();
	var $categoryItemArray  = array();
	var $blockWord          = array();
	var $featuredWordsArray = array();
	var $hitWord            = array();
	var $newWord            = array();
	var $newWordsBlockUsed  = false ;
	var $tagCloudArray      = array();
	var $letterAlphaArray = array();
	var $letterJapaneseArray= array();
	var $letternNmberArray  = array();

	function _getId()
	{
		return xoops_getrequest('categoryid');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('word');
		return $handler;
	}

	function &_getFilterForm()
	{
		$filter = new Glossary_DBFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		$this->mConfig = $moduleConfig;
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		// setting
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;
		$textFilter =& $root->getTextFilter();

		// moduleConfig
		$configUseModRewrite = $this->mConfig['use_mod_rewrite'];
		$configNewWordsUse   = $this->mConfig['newwordsuse'];
		$configDesrLength     = $this->mConfig['desrlength'];

                // add config parameter
		$sqlPram = ' AND published > 0';

		// access
		if ($root->mContext->mUser->isInRole('Module.glossary.Admin')) {
			$this->isAdmin = true;
			$sqlPram = '';
		}

		// get SQL data
		$handler =& $this->_getHandler();

		if ($this->mConfig['letterblockused']) {
			$this->letterAlphaArray    = $handler->alphaArray(0);    // Alphabet
			$this->letterJapaneseArray = $handler->alphaArray(1);    // Japanese
			$this->letterNumberArray   = $handler->alphaArray(2);    // Number
		}

		// Featured Terms
		$this->featuredWordsArray = Glossary_SqlService::getFeaturedWords($sqlPram, $configUseModRewrite, $configDesrLength) ;

		// Category Block
		if ($this->mConfig['categoryblockused']) {
			$handler =& xoops_getmodulehandler('category');
			$mCriteria = new CriteriaCompo();
			$mCriteria->add(new Criteria('parentid', 0));
			$mCriteria->setSort('weight','DESC');
			$this->mObjects =& $handler->getObjects($mCriteria);
			foreach ($this->mObjects as $key => $val) {
				foreach ( array_keys($val->gets()) as $var_name ) {
					$item_ary[$var_name] = $val->getShow($var_name);
				}
				$item_ary['linkCategoryUrl'] = Glossary_functionGetCategoryUrl( $configUseModRewrite, $item_ary['categoryid'],$item_ary['name']);
				$this->categoryItemArray[] =& $item_ary;
				unset($item_ary);
			}
		}

		// tag cloud
		$popularTags = TagService::getPopularTags($limit = 50, $days = NULL) ;
		if (count($popularTags) > 0){
			$this->tagCloudArray = TagService::tagCloud($popularTags, $steps = 8, $sizemin = 80, $sizemax = 200, $sortOrder = 'alphabet_asc');
		}

		// New & Related Words
		if ($configNewWordsUse > 0) {
			$this->newWordsBlockUsed = true;
			$this->hitWords = Glossary_SqlService::getHitsWords($configNewWordsUse, $configUseModRewrite) ;
			$this->newWords = Glossary_SqlService::getNewWords($configNewWordsUse, $configUseModRewrite ) ;
		}

		// header setting and menu
		$this->breadcrumbs[] = array('name' => $root->mContext->mModule->mXoopsModule->getVar('name')) ;
		$this->moduleHeader.= '<link rel="alternate" type="application/rss+xml" title="'.$root->mContext->mModule->mXoopsModule->getVar('name').'" href="' . XOOPS_MODULE_URL. '/glossary/rss.php?action=Rss" />'."\n";
		$this->moduleHeader.= '<link rel="stylesheet" type="text/css" href="' . XOOPS_MODULE_URL. '/glossary/module.css" />'."\n";
		return GLOSSARY_FRAME_VIEW_INDEX;
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName('glossary_index.html');
		// base data
		$render->setAttribute('config'  , $this->mConfig);
		$render->setAttribute('xoops_breadcrumbs' ,$this->breadcrumbs) ;
		$render->setAttribute('xoops_module_header',$this->moduleHeader);
		$render->setAttribute('xoops_meta_description', 'TEST');
                // block data
		$root =& XCube_Root::getSingleton();
		$render->setAttribute('is_admin', $root->mContext->mUser->isInRole('Module.glossary.Admin'));

		// Letter block
		$postCategoryId = $this->_getId();
		if ($this->mConfig['letterblockused']) {
			$render->setAttribute('alpha'    , $this->letterAlphaArray);       // Alphabet
			$render->setAttribute('japanese' , $this->letterJapaneseArray);    // Japanese
			$render->setAttribute('number'   , $this->letterNumberArray);      // Number
		}

		// New and Hits words block
		$render->setAttribute('new_words_block_used' ,$this->newWordsBlockUsed);
		if ($this->newWordsBlockUsed > 0) {
			$render->setAttribute('new_words', $this->newWords);
			$render->setAttribute('hit_words', $this->hitWords);
		}

		// words block
		$render->setAttribute('blolck_word', $this->featuredWordsArray);
		$render->setAttribute('categories' , $this->categoryItemArray);
		$render->setAttribute('tag_cloud'  , $this->tagCloudArray);
	}
}
?>