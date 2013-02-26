<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

// チE�EタのオブジェクトをチE�Eブルから取得しなぁE��合�E処琁E
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

	// 現在のタグ
	function _getTag()
	{
		return xoops_getrequest('tag');
	}

	// 新しいタグ
	function _getNewTag()
	{
		return xoops_getrequest('new_tag');
	}

	// チE�Eタハンドラの設宁E
	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('tag');
		return $handler;
	}

	// アクションフォームを準備
	function _setupActionForm()
	{
		$this->mActionForm = new Grossary_TagAdminEditForm();
		$this->mActionForm->prepare();
	}


	// 準備
	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		// /class/AbstractEditAction.class.php の prepare を実衁E
		// parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		$this->mConfig = $moduleConfig;
		$this->_setupActionForm();
		$this->_setupObject();

		// チE�Eタハンドラーが無ぁE��合や、ハンドラーに追加するにはこちめE
		// GETチE�EタをオブジェクトにチE�Eタを代入
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

	// 入力画面を表示する
	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;
		// --------------------------------------------------------
		// 管琁E��面のヘッダーとメニュー作�E
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
		// モジュールの惁E��
		// --------------------------------------------------------
		$render->setAttribute('actionForm' , $this->mActionForm);
		$render->setAttribute('object'     , $this->mObject);

	}

	// 更新成功
	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=TagList';
		$controller->executeRedirect($url, 1, _AD_GLOSSARY_TAG_SUCCESS);
	}

	// エラーが発甁E
	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=TagList';
		$controller->executeRedirect($url, 1, _AD_GLOSSARY_TAG_EDIT_ERROR);
	}

	// フォームでキャンセルを押されぁE
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=TagList';
		$controller->executeForward($url);
	}

	// チE�Eタの更新
	// AbstractEditAction.class.php -> _doExecute() をオーバ�EライチE
	function _doExecute()
	{
		$handler =& xoops_getmodulehandler('tag');
		// タグの一括置揁E/class/handler/Tag.class.php
		$update = $handler->renameTag($this->mObject->get('tag'), $this->mObject->get('new_tag'));

		return $this->mObject;
	}

}

?>
