<?php
/*=====================================================================
	(C)2007 BeaBo Japan by Hiroki Seike
	http://beabo.net/
=====================================================================*/

if (!defined('XOOPS_ROOT_PATH')) exit();

// template header module infomation
function getModuleInfo() {
	$moduleHader = array();
	$root =& XCube_Root::getSingleton();
	$moduleHader['module_id']   = $root->mContext->mXoopsModule->getvar('mid');
	$moduleHader['module_name'] = $root->mContext->mXoopsModule->get('name');
	$moduleHader['module_path'] = $root->mContext->mXoopsModule->get('dirname');
	return $moduleHader;
}


?>