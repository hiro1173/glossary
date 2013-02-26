<?php
/**
 * @package User
 * @version $Id: AbstractViewAction.class.php,v 1.1 2007/05/15 02:34:49 minahito Exp $
 */

//echo 'AbstractViewAction.class.php<br />';


if (!defined('XOOPS_ROOT_PATH')) exit();

class Glossary_AbstractViewAction extends Glossary_Action
{
	var $mObject = null;
	var $mObjectHandler = null;

	function _getId()
	{
	}

	function &_getHandler()
	{
	}

	// オブジェクトの呼び出し
	// データベースから呼び出す
	function _setupObject()
	{
		$id = $this->_getId();
		$this->mObjectHandler =& $this->_getHandler();
		$this->mObject =& $this->mObjectHandler->get($id);
	}

	function prepare(&$controller, &$xoopsUser, &$moduleConfig)
	{
		$this->_setupObject();
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		if ($this->mObject == null) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}
		return GLOSSARY_FRAME_VIEW_SUCCESS;
	}

	function execute(&$controller, &$xoopsUser)
	{
		return $this->getDefaultView($controller, $xoopsUser);
	}
}

?>
