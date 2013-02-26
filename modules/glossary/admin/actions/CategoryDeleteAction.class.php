<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . '/glossary/class/AbstractDeleteAction.class.php';
require_once XOOPS_MODULE_PATH . '/glossary/admin/forms/CategoryAdminDeleteForm.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/include/functions.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/menu.php' ;


class Glossary_CategoryDeleteAction extends Glossary_AbstractDeleteAction
{
	// for menu
	var $breadCrumbsu = array();
	var $confirmMssage = null;
	var $moduleHeader = null;

	function _getId()
	{
		return xoops_getrequest('categoryid');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('category');
		return $handler;
	}

	function _setupActionForm()
	{
		$this->mActionForm = new Glossary_CategoryAdminDeleteForm();
		$this->mActionForm->prepare();
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;

		$categoryid =  $this->mObject->getShow('categoryid');

		$handler = $this->_getHandler();
		$this->categories = $handler->getChildTreeArray($categoryid);
		$childCount = count($this->categories);

		if ( $childCount > 0 ) {
			$this->confirmMssage = sprintf(_AD_GLOSSARY_CAT_DELETE_CONFIRM2,$childCount);
		} else {
			$this->confirmMssage = _AD_GLOSSARY_CAT_DELETE_CONFIRM;
		}


		$this->breadCrumbs[] = array('name' => _AD_GLOSSARY_CAT_MENU,'url'  => 'index.php?action=CategoryList' ) ;
		$this->breadCrumbs[] = array('name' => _AD_GLOSSARY_CAT_DELETE ) ;

		$render->setTemplateName( 'glossary_category_delete.html');

		$render->setAttribute('module_info'   , getModuleInfo());
		$render->setAttribute('moduleHeader'  , $this->moduleHeader);
		$render->setAttribute('bread_crumbs'  , $this->breadCrumbs);
		$render->setAttribute('set_menu'      , $adminmenu );
		$render->setAttribute('set_menu_no'   , 4);
		$render->setAttribute('confirm_mssage', $this->confirmMssage);

		$render->setAttribute('set_menu_desc' , _AD_GLOSSARY_CAT_DELETE_DSC);
		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect('index.php?action=CategoryList', 1, _MD_GLOSSARY_CATEGORY_DELETEED);
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect('index.php?action=CategoryList', 1, _MD_GLOSSARY_CATEGORY_DELETE_ERROR);
	}

	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward('index.php?action=CategoryList');
	}

	{
		$categoryid =  $this->mObject->getShow('categoryid');
		return $this->mObjectHandler->deleteChild($categoryid);
	}

}

?>
