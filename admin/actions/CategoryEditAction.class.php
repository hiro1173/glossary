<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractEditAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/forms/CategoryAdminEditForm.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/include/functions.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/menu.php' ;

class Glossary_CategoryEditAction extends Glossary_AbstractEditAction
{
	var $mCatagory = array();
	// for menu
	var $breadCrumbs = array();
	var $confirmMssage = null;
	var $moduleHeader = null;
	var $menuDescription = null;

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
		$this->mActionForm = new Glossary_CategoryAdminEditForm();
		$this->mActionForm->prepare();
	}

	// Over ride

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		$this->mConfig = $moduleConfig;
		$this->_setupActionForm();
		$this->_setupObject();
	}

	// Over ride
	function getDefaultView(&$controller, &$xoopsUser)
	{

		// 親クラスの getDefaultView を実衁E
		$ret = parent::getDefaultView($controller, $xoopsUser);


		// オブジェクトが無ければ、エラーを返す
		if ($this->mObject == null) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}
		$this->mActionForm->load($this->mObject);

		if ($this->mObject->isNew()) {
			$this->menuDescription = _AD_GLOSSARY_CAT_ADD_DSC;
		} else {
			$this->menuDescription = _AD_GLOSSARY_CAT_EDIT_DSC;
		}

		return GLOSSARY_FRAME_VIEW_INPUT;
	}


	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;

		$handler = $this->_getHandler();
		// 親カチE��リの取征E
		$catagoryOptions = $handler->getSelectArray(true);


		$this->breadCrumbs[] = array('name' => _AD_GLOSSARY_WORD_LIST ,'url'  => 'index.php?action=WordList' ) ;
		$this->breadCrumbs[] = array('name' => _AD_GLOSSARY_CAT_EDIT ) ;

		$render->setTemplateName('glossary_category_edit.html');

		$render->setAttribute('module_info'   , getModuleInfo());
		$render->setAttribute('moduleHeader'  , $this->moduleHeader);
		$render->setAttribute('bread_crumbs'  , $this->breadCrumbs);
		$render->setAttribute('set_menu'      , $adminmenu );
		$render->setAttribute('set_menu_no'   , 4);
		$render->setAttribute('set_mssage'    , $this->confirmMssage);
		$render->setAttribute('set_menu_desc' , $this->menuDescription);

		$render->setAttribute('actionForm' , $this->mActionForm);
		$render->setAttribute('object'     , $this->mObject);
		$render->setAttribute('cat_options' , $catagoryOptions);
		$render->setAttribute('is_new'        , $this->mObject->isNew());



	}

	// Over ride
	// チE�Eタの保存�E琁E
	function execute(&$controller, &$xoopsUser)
	{
		// 親クラスの execute を実衁E
		$ret = parent::execute($controller, $xoopsUser);
		if ($ret == GLOSSARY_FRAME_VIEW_SUCCESS) {
			// 保存後に追加で処琁E��る場合�E、ここに書ぁE
			// 無かったら、execute 自体�E不要なので削除
		}

		return $ret;
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=CategoryList';
		$controller->executeRedirect($url, 1, _AD_GLOSSARY_CAT_SUCCESS);
		// Not Use Redirect
		// $controller->executeForward('index.php');
	}

	// エラーが発甁E
	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=CategoryList';
		$controller->executeRedirect($url, 1, _AD_GLOSSARY_CAT_EDIT_ERROR);
	}

	// フォームでキャンセルを押されぁE
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=CategoryList';
		$controller->executeForward($url);
	}
}

?>
