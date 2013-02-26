<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractIndexAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/include/functions.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/menu.php' ;

class Glossary_CategoryListAction extends Glossary_AbstractIndexAction
{
	// for menu
	var $breadCrumbs = array();
	var $confirmMssage = null;
	var $moduleHeader = null;

	var $categories = null;

	// オーバーライド
	// /class/AbstractListAction.class.php の getDefaultView() 
	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('category');
		return $handler;
	}


	// オーバーライド
	// >> /class/AbstractListAction.class.php の getDefaultView() 
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$handler = $this->_getHandler();
		$this->categories = $handler->getChildTreeArray();

		return GLOSSARY_FRAME_VIEW_INDEX;
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;
		$root =& XCube_Root::getSingleton();

		$this->breadCrumbs[] = array('name' => _AD_GLOSSARY_CAT_MENU) ;

		$render->setTemplateName('glossary_category_list.html');

		$render->setAttribute('module_info'   , getModuleInfo());
		$render->setAttribute('moduleHeader'  , $this->moduleHeader);
		$render->setAttribute('bread_crumbs'  , $this->breadCrumbs);
		$render->setAttribute('set_menu'      , $adminmenu );
		$render->setAttribute('set_menu_no'   , 4);
		$render->setAttribute('set_mssage'    , $this->confirmMssage);


		$render->setAttribute('categories' , $this->categories);

//		$render->setAttribute('objects' , $this->mObjects);
//		$render->setAttribute("pageNavi", $this->mFilter->mNavi);
	}

}
?>
