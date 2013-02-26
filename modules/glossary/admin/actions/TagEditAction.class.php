<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

// 繝・・繧ｿ縺ｮ繧ｪ繝悶ず繧ｧ繧ｯ繝医ｒ繝・・繝悶Ν縺九ｉ蜿門ｾ励＠縺ｪ縺・ｴ蜷医・蜃ｦ逅・
// 
// 

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractEditAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/forms/TagAdminEditForm.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/include/functions.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/menu.php' ;

class Glossary_TagEditAction extends Glossary_AbstractEditAction
{

	var $mObject = null;

	// for menu
	var $breadCrumbs = array();
	var $confirmMssage = null;
	var $moduleHeader = null;

	// 迴ｾ蝨ｨ縺ｮ繧ｿ繧ｰ
	function _getTag()
	{
		return xoops_getrequest('tag');
	}

	// 譁ｰ縺励＞繧ｿ繧ｰ
	function _getNewTag()
	{
		return xoops_getrequest('new_tag');
	}

	// 繝・・繧ｿ繝上Φ繝峨Λ縺ｮ險ｭ螳・
	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('tag');
		return $handler;
	}

	// 繧｢繧ｯ繧ｷ繝ｧ繝ｳ繝輔か繝ｼ繝繧呈ｺ門ｙ
	function _setupActionForm()
	{
		$this->mActionForm = new Grossary_TagAdminEditForm();
		$this->mActionForm->prepare();
	}


	// 貅門ｙ
	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		// /class/AbstractEditAction.class.php 縺ｮ prepare 繧貞ｮ溯｡・
		// parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		$this->mConfig = $moduleConfig;
		$this->_setupActionForm();
		$this->_setupObject();

		// 繝・・繧ｿ繝上Φ繝峨Λ繝ｼ縺檎┌縺・ｴ蜷医ｄ縲√ワ繝ｳ繝峨Λ繝ｼ縺ｫ霑ｽ蜉縺吶ｋ縺ｫ縺ｯ縺薙■繧・
		// GET繝・・繧ｿ繧偵が繝悶ず繧ｧ繧ｯ繝医↓繝・・繧ｿ繧剃ｻ｣蜈･
		$this->mObject->set('tag', $this->_getTag());
		$this->mObject->set('new_tag', $this->_getTag());

	}


	function getDefaultView(&$controller, &$xoopsUser)
	{
		$handler =& $this->_getHandler();
		$getTag = $this->_getTag() ;

		$mCriteria = new CriteriaCompo();
		$mCriteria->add(new Criteria('tag', $this->_getTag()));
		$this->mObjects =& $handler->getObjects($mCriteria);

		$this->mActionForm->load($this->mObject);

		return GLOSSARY_FRAME_VIEW_INPUT;
	}

	// 蜈･蜉帷判髱｢繧定｡ｨ遉ｺ縺吶ｋ
	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;
		// --------------------------------------------------------
		// 邂｡逅・判髱｢縺ｮ繝倥ャ繝繝ｼ縺ｨ繝｡繝九Η繝ｼ菴懈・
		// --------------------------------------------------------
		$this->breadCrumbs[] = array('name' => _AD_GLOSSARY_TAG_LIST ,'url'  => 'index.php?action=TagList' ) ;
		$this->breadCrumbs[] = array('name' => _AD_GLOSSARY_TAG_EDIT) ;

		$render->setTemplateName('glossary_tag_edit.html');

		$render->setAttribute('module_info'   , getModuleInfo());
		$render->setAttribute('module_header' , $this->moduleHeader);
		$render->setAttribute('bread_crumbs'  , $this->breadCrumbs);
		$render->setAttribute('set_menu'      , $adminmenu );
		$render->setAttribute('set_menu_no'   , 3);
		$render->setAttribute('set_mssage'    , $this->confirmMssage);

		// --------------------------------------------------------
		// 繝｢繧ｸ繝･繝ｼ繝ｫ縺ｮ諠・ｱ
		// --------------------------------------------------------
		$render->setAttribute('actionForm' , $this->mActionForm);
		$render->setAttribute('object'     , $this->mObject);

	}

	// 譖ｴ譁ｰ謌仙粥
	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=TagList';
		$controller->executeRedirect($url, 1, _AD_GLOSSARY_TAG_SUCCESS);
	}

	// 繧ｨ繝ｩ繝ｼ縺檎匱逕・
	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=TagList';
		$controller->executeRedirect($url, 1, _AD_GLOSSARY_TAG_EDIT_ERROR);
	}

	// 繝輔か繝ｼ繝縺ｧ繧ｭ繝｣繝ｳ繧ｻ繝ｫ繧呈款縺輔ｌ縺・
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=TagList';
		$controller->executeForward($url);
	}

	// 繝・・繧ｿ縺ｮ譖ｴ譁ｰ
	// AbstractEditAction.class.php -> _doExecute() 繧偵が繝ｼ繝舌・繝ｩ繧､繝・
	function _doExecute()
	{
		$handler =& xoops_getmodulehandler('tag');
		// 繧ｿ繧ｰ縺ｮ荳諡ｬ鄂ｮ謠・/class/handler/Tag.class.php
		$update = $handler->renameTag($this->mObject->get('tag'), $this->mObject->get('new_tag'));

		return $this->mObject;
	}

}

?>
