<?php

//echo 'AbstractIndexAction.class.php<br />';

if (!defined('XOOPS_ROOT_PATH')) exit;

class Glossary_AbstractIndexAction extends Glossary_Action
{
	var $mObject = null;
	var $mObjectHandler = null;

	function _getId()
	{
	}

	function &_getHandler()
	{
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		if ($this->mObject == null) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}

		return GLOSSARY_VIEW_SUCCESS;
	}

	function execute(&$controller, &$xoopsUser)
	{
		return $this->getDefaultView($controller, $xoopsUser);
	}
}

?>
