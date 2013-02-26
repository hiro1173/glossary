<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractDeleteAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/forms/WordAdminDeleteForm.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/include/functions.php';

class Glossary_WordDeleteAction extends Glossary_AbstractDeleteAction
{
	// for menu
	var $breadCrumbs = array();
	var $confirmMssage = null;
	var $moduleHeader = null;
	var $menuDescription = null;

	function _getId()
	{
		return xoops_getrequest('wordid');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('word');
		return $handler;
	}

	function _setupActionForm()
	{
		// 繧｢繧ｯ繧ｷ繝ｧ繝ｳ繝輔か繝ｼ繝繧偵そ繝・ヨ繧｢繝・・
		// /glossary/admin/forms/WordAdminDeleteForm.class.php 縺ｮ繧ｯ繝ｩ繧ｹ蜷阪□
		// [ 繝｢繧ｸ繝･繝ｼ繝ｫ蜷・] + _ + [繝・・繧ｿ繝吶・繧ｹ蜷江 + [邂｡逅・・縺ｯAdmin繧偵▽縺代ｋ] + [蜃ｦ逅・ + Form
		$this->mActionForm = new Glossary_WordAdminDeleteForm();
		$this->mActionForm->prepare();
	}


	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;
		$this->breadCrumbs[]   = array('name' => _AD_GLOSSARY_WORD_LIST ,'url'  => 'index.php?action=WordList' ) ;
		$this->breadCrumbs[]   = array('name' => _AD_GLOSSARY_WORD_DELETE) ;
		$this->menuDescription = _AD_GLOSSARY_WORD_DELETE_DSC ;
		$this->confirmMssage   = _AD_GLOSSARY_WORD_DELETE_CONFIRM ;

		$render->setTemplateName( 'glossary_word_delete.html');
		$render->setAttribute('module_info'   , getModuleInfo());
		$render->setAttribute('module_header'  , $this->moduleHeader);
		$render->setAttribute('bread_crumbs'  , $this->breadCrumbs);
		$render->setAttribute('set_menu'      , $adminmenu );
		$render->setAttribute('set_menu_no'   , 2);
		$render->setAttribute('set_menu_desc' , $this->menuDescription);
		$render->setAttribute('confirm_mssage', $this->confirmMssage);

		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);
	}

	// 蜃ｦ逅・ｒ謌仙粥縺励◆
	// 縺薙・蝣ｴ蜷医・縲√ヵ繧ｩ繝ｼ繝縺ｧ蜑企勁蜃ｦ逅・′陦後ｏ繧後◆ = GLOSSARY_FRAME_VIEW_SUCCESS
	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect('index.php?action=WordList', 1, AD_GLOSSARY_WORD_DELETE_SUCCESS);
	}

	// 繧ｨ繝ｩ繝ｼ縺檎匱逕・= GLOSSARY_FRAME_VIEW_ERROR
	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect('index.php?action=WordList', 1, _AD_GLOSSARY_WORD_DELETE_ERROR);
	}
	// 繝輔か繝ｼ繝縺ｧ繧ｭ繝｣繝ｳ繧ｻ繝ｫ繧呈款縺輔ｌ縺・	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward('index.php?action=WordList');
	}


	// 繝・・繧ｿ縺ｮ蜑企勁
	// 蜊倅ｸ縺ｮ繝・・繧ｿ繧貞炎髯､縺吶ｋ縺縺代・蝣ｴ蜷医・縲＼doExecute()縺ｯ蠢・ｦ√′縺ｪ縺・	// 髢｢騾｣繝・・繧ｿ繧貞炎髯､縺吶ｋ蝣ｴ蜷医↓縺ｯ繧ｪ繝ｼ繝舌・繝ｩ繧､繝峨〒險倩ｿｰ

	function _doExecute()
	{
		$handler =$this->_getHandler();
		$word =& $handler->get($this->mObject->get('wordid'));

		if (!$handler->delete($word)) {
			// 蜑企勁縺悟ｮ溯｡悟・譚･縺ｪ縺九▲縺溷ｴ蜷医・縲√お繝ｩ繝ｼ蜃ｦ逅・			return GLOSSARY_FRAME_VIEW_ERROR;
		}

		// 蜃ｦ逅・′謌仙粥縺励◆繝輔Λ繧ｰ繧定ｿ斐＠縺ｦ縲∵ｬ｡縺ｮ蜃ｦ逅・∈
		return GLOSSARY_FRAME_VIEW_SUCCESS;
	}

}

?>
