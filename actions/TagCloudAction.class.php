<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractViewAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/include/functions.php';
//require_once XOOPS_MODULE_PATH. '/glossary/include/TagService.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/TagService.class.php';


class Glossary_TagCloudAction extends Glossary_AbstractViewAction
{
	var $mConfig = array();
	var $wordObject= array();
	var $getTagWordArray = array();
	var $tagWordArray = array();

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('tag');
		return $handler;
	}

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		//parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		$this->mConfig = $moduleConfig;
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		$root =& XCube_Root::getSingleton();
		$configUseModRewrite = $this->mConfig['use_mod_rewrite'];
		// Tag Cloud
		$popularTags =TagService::getAllTags() ;
		$this->tagCloudArray = TagService::tagCloud($popularTags, $steps = 10, $sizemin = 90, $sizemax = 250, $sortOrder = NULL);
		$this->breadcrumbs[] = array('name' => $root->mContext->mModule->mXoopsModule->getVar('name') , 'url' => XOOPS_MODULE_URL. '/glossary/' ) ;
		$this->breadcrumbs[] = array('name' => _MD_GLOSSARY_TAG_CLOUD ) ;
		$this->pageTitle = $root->mContext->mModule->mXoopsModule->getVar('name') .' &raquo; '. _MD_GLOSSARY_TAG_CLOUD;
		return GLOSSARY_FRAME_VIEW_INDEX;
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName('glossary_tag_cloud.html');
		$render->setAttribute('xoops_breadcrumbs' ,$this->breadcrumbs) ;
		$render->setAttribute('xoops_pagetitle'  , $this->pageTitle );
		$moduleHeader = '<link rel="stylesheet" type="text/css" href="' . XOOPS_MODULE_URL. '/glossary/module.css" />'."\n";
		$render->setAttribute('xoops_module_header',$moduleHeader);
		$render->setAttribute('config'      , $this->mConfig);
		$render->setAttribute('tag_cloud' , $this->tagCloudArray);

	}
}
?>

