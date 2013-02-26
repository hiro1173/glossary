<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

class Glossary_AbstractEditAction extends Glossary_Action
{
	var $mObject = null;
	var $mObjectHandler = null;
	var $mActionForm = null;
	var $mConfig;

	/**
	 * @access protected
	 */
	function _getId()
	{
	}

	/**
	 * @access protected
	 */
	function &_getHandler()
	{
	}

	/**
	 * @access protected
	 */
	function _setupActionForm()
	{
	}

	/**
	 * @access protected
	 */

	function _setupObject()
	{
		$id = $this->_getId();
		$this->mObjectHandler = $this->_getHandler();
		$this->mObject =& $this->mObjectHandler->get($id);
		if ($this->mObject == null && $this->isEnableCreate()) {
			$this->mObject =& $this->mObjectHandler->create();
		}
	}

	/**
	 * @access protected
	 */
	function isEnableCreate()
	{
		return true;
	}

	// 
	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		$this->mConfig = $moduleConfig;
		$this->_setupActionForm();
		$this->_setupObject();
	}


	function getDefaultView(&$controller, &$xoopsUser)
	{
		// オブジェクトが無ければ、エラーを返す
		if ($this->mObject == null) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}
		$this->mActionForm->load($this->mObject);
		return GLOSSARY_FRAME_VIEW_INPUT;
	}

	// 編集の保存
	function execute(&$controller, &$xoopsUser)
	{

		// オブジェクトが無ければ、エラーを返す
		if ($this->mObject == null) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}

		// フォームでキャンセルされた
		if (xoops_getrequest('_form_control_cancel') != null) {
			return GLOSSARY_FRAME_VIEW_CANCEL;
		}

		// アクションフォームの load を実行
		$this->mActionForm->load($this->mObject);

		// アクションフォームの fetch を実行
		$this->mActionForm->fetch();

		// 入力チェック
		$this->mActionForm->validate();
		if ($this->mActionForm->hasError()) {
			// エラーが発生
			return GLOSSARY_FRAME_VIEW_INPUT;
		}
		// データの更新
		$this->mActionForm->update($this->mObject);
		return $this->_doExecute() ? GLOSSARY_FRAME_VIEW_SUCCESS : GLOSSARY_FRAME_VIEW_ERROR;
	}

	/**
	 * @access protected
	 */
	// データの更新
	function _doExecute()
	{
		return $this->mObjectHandler->insert($this->mObject);
	}
}

?>
