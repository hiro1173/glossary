<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractDeleteAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/forms/TagAdminDeleteForm.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/include/functions.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/menu.php' ;



class Glossary_TagDeleteAction extends Glossary_AbstractDeleteAction
{


	var $mObject = null;
	var $tag = null;
	var $totalCount = 0;

	// for menu
	var $breadCrumbs = array();
	var $confirmMssage = null;
	var $moduleHeader = null;

	function _getTag()
	{
		return xoops_getrequest('tag');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('tag');
		return $handler;
	}

	// アクションフォームを準備
	function _setupActionForm()
	{
		$this->mActionForm = new Glossary_TagAdminDeleteForm();
		$this->mActionForm->prepare();
	}


	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		$this->_setupActionForm();

		$handler =$this->_getHandler();
		$getTag = $this->_getTag();
		$mCriteria = new CriteriaCompo();
		$mCriteria->add(new Criteria('tag', $getTag));
		$this->totalCount = $handler->getCount($mCriteria);
	}

	function _doExecute()
	{
		$handler =$this->_getHandler();

		if (!$handler->deleteTag($this->_getTag())) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}

		return GLOSSARY_FRAME_VIEW_SUCCESS;
	}


	function getDefaultView(&$controller, &$xoopsUser)
	{
		if ($this->totalCount == 0 ) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}

		$this->breadCrumbs[] = array('name' => _AD_GLOSSARY_TAG_LIST ,'url'  => 'index.php?action=TagList' ) ;
		$this->breadCrumbs[] = array('name' => _AD_GLOSSARY_TAG_DELETE) ;
		$this->confirmMssage   = sprintf(_AD_GLOSSARY_TAG_DELETE_CONFIRM,$this->_getTag(),$this->totalCount) ;

		return GLOSSARY_FRAME_VIEW_INPUT;
	}

	function execute(&$controller, &$xoopsUser)
	{
		if ($this->totalCount == 0 ) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}

		if (xoops_getrequest('_form_control_cancel') != null) {
			return GLOSSARY_FRAME_VIEW_CANCEL;
		}

		return $this->_doExecute() ? GLOSSARY_FRAME_VIEW_SUCCESS : GLOSSARY_FRAME_VIEW_ERROR;
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;
		$root =& XCube_Root::getSingleton();
		$moduleHeader = '';

		$render->setTemplateName( 'glossary_tag_delete.html');

		$render->setAttribute('module_info'   , getModuleInfo());
		$render->setAttribute('moduleHeader'  , $this->moduleHeader);
		$render->setAttribute('bread_crumbs'  , $this->breadCrumbs);
		$render->setAttribute('set_menu'      , $adminmenu );
		$render->setAttribute('set_menu_no'   , 3);

		$render->setAttribute('confirm_mssage', $this->confirmMssage);
		$render->setAttribute('actionForm', $this->mActionForm);


		$render->setAttribute('tag', $this->_getTag());
		$render->setAttribute('total_count', $this->totalCount);
	}


	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect('index.php?action=TagList', 1, _AD_GLOSSARY_TAG_DELETE_SUCCESS);
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect('index.php?action=TagList', 1, _AD_GLOSSARY_TAG_DELETE_ERROR);
	}

	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward('index.php?action=TagList');
	}

}

?>
