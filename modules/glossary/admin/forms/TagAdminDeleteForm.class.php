<?php
if (!defined('XOOPS_ROOT_PATH')) exit();
require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";

class Glossary_TagAdminDeleteForm extends XCube_ActionForm

{
	function getTokenName()
	{
		return 'module.glossary.TagAdminDelete.Form.TOKEN';
	}

}

?>
