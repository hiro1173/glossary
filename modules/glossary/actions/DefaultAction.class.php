<?php

//echo 'DefaultAction.class.php<br />';

if (!defined('XOOPS_ROOT_PATH')) exit();

class Glossary_DefaultAction extends Glossary_Action
{
	function getDefaultView(&$controller)
	{
		// URLを変更する
		$controller->executeForward('index.php?action=index');
	}
}

?>
