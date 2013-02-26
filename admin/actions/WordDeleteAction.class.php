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
		// アクションフォームをセチE��アチE�E
		// /glossary/admin/forms/WordAdminDeleteForm.class.php のクラス名だ
		// [ モジュール吁E] + _ + [チE�Eタベ�Eス名] + [管琁E�EはAdminをつける] + [処琁E + Form
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

	// 処琁E��成功した
	// こ�E場合�E、フォームで削除処琁E��行われた = GLOSSARY_FRAME_VIEW_SUCCESS
	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect('index.php?action=WordList', 1, AD_GLOSSARY_WORD_DELETE_SUCCESS);
	}

	// エラーが発甁E= GLOSSARY_FRAME_VIEW_ERROR
	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect('index.php?action=WordList', 1, _AD_GLOSSARY_WORD_DELETE_ERROR);
	}
	// フォームでキャンセルを押されぁE	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward('index.php?action=WordList');
	}


	// チE�Eタの削除
	// 単一のチE�Eタを削除するだけ�E場合�E、_doExecute()は忁E��がなぁE	// 関連チE�Eタを削除する場合にはオーバ�Eライドで記述

	function _doExecute()
	{
		$handler =$this->_getHandler();
		$word =& $handler->get($this->mObject->get('wordid'));

		if (!$handler->delete($word)) {
			// 削除が実行�E来なかった場合�E、エラー処琁E			return GLOSSARY_FRAME_VIEW_ERROR;
		}

		// 処琁E��成功したフラグを返して、次の処琁E��
		return GLOSSARY_FRAME_VIEW_SUCCESS;
	}

}

?>
