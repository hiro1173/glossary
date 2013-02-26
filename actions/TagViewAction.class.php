<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractViewAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/include/functions.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/Glossary_SqlService.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/TagService.class.php';

class Glossary_TagViewAction extends Glossary_AbstractViewAction
{
	var $mConfig = array();
	var $wordObject= array();
	var $getTagWordArray = array();
	var $tagWordArray = array();
	var $getTagWord = null;

	function _getTag()
	{
		return xoops_getrequest('tag');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('tag');
		return $handler;
	}

	function _getStart()
	{
		return xoops_getrequest('start');
	}

	function _getBaseUrl()
	{
		return 'index.php?action=TagView';
	}

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		$this->mConfig = $moduleConfig;
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		$root =& XCube_Root::getSingleton();
		$configUseModRewrite = $this->mConfig['use_mod_rewrite'];
		$configDesrLength     = $this->mConfig['desrlength'];
		$configPerPage       = $this->mConfig['perpage'];
		$this->getTagWord = $this->_getTag() ;

		if (XOOPS_USE_MULTIBYTES) {
			$this->getTagWord = htmlspecialchars(urldecode($this->getTagWord), ENT_QUOTES) ;
			$wordEncoding = mb_detect_encoding($this->getTagWord);
			$this->getTagWord = mb_convert_encoding($this->getTagWord ,_CHARSET, $wordEncoding);
		}

		// get data
		$this->tagWordArray = Glossary_SqlService::getTagItems($this->getTagWord, $this->_getStart(), $configPerPage, $configDesrLength, $configUseModRewrite) ;
		$this->totalCount   = Glossary_SqlService::countTagItems($this->getTagWord);

		// Page navi
		if ($this->totalCount > $configPerPage ) {
			$this->mPagenavi =$this->_getPageNavi();
			$this->mPagenavi->fetch();
		}

		$this->breadcrumbs[] = array('name' => $root->mContext->mModule->mXoopsModule->getVar('name') , 'url' => XOOPS_MODULE_URL. '/glossary/' ) ;
		if ($configUseModRewrite) {
			$this->breadcrumbs[] = array('name' => _MD_GLOSSARY_TAG , 'url' => XOOPS_MODULE_URL. '/glossary/tagcloud/' ) ;
		} else {
			$this->breadcrumbs[] = array('name' => _MD_GLOSSARY_TAG , 'url' => XOOPS_MODULE_URL. '/glossary/index.php?action=TagCloud' ) ;
		}
		$this->breadcrumbs[] = array('name' => $this->getTagWord )  ;
		$this->pageTitle = $root->mContext->mModule->mXoopsModule->getVar('name') .' &raquo; '. _MD_GLOSSARY_TAG.' &raquo; '. $this->getTagWord;

		return GLOSSARY_FRAME_VIEW_INDEX;
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName('glossary_tag_view.html');
		$render->setAttribute('config'      , $this->mConfig);
		$render->setAttribute('tag'         , $this->getTagWord);
		$render->setAttribute('word_array'  , $this->tagWordArray);
		$render->setAttribute('total_count' , $this->totalCount);
		$render->setAttribute('xoops_breadcrumbs' ,$this->breadcrumbs) ;
		$render->setAttribute('xoops_pagetitle'  , $this->pageTitle );
		$moduleHeader = '<link rel="stylesheet" type="text/css" href="' . XOOPS_MODULE_URL. '/glossary/module.css" />'."\n";
		$render->setAttribute('xoops_module_header',$moduleHeader);

	}
}
?>

