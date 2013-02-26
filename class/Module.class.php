<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

// --------------------------------------------------------
// モジュール継承クラス
// --------------------------------------------------------
class Glossary_Module extends Legacy_ModuleAdapter
{
	function Glossary_Module(&$xoopsModule)
	{
		parent::Legacy_ModuleAdapter($xoopsModule);
		$this->mGetAdminMenu = new XCube_Delegate();
		$this->mGetAdminMenu->register('glossary_Module.getAdminMenu');
	}

	function hasAdminIndex()
	{
		return true;
	}

	function getAdminIndex()
	{
		return XOOPS_MODULE_URL.'/'.$this->mXoopsModule->get('dirname').'/admin/index.php';
	}

	// 管理画面のメニューの項目
	function getAdminMenu()
	{
		$menu = parent::getAdminMenu();
		$this->mGetAdminMenu->call(new XCube_Ref($menu));
		
		ksort($menu);
		
		return $menu;
	}

/*
	// 管理画面での検索の設定
	function doLegacyGlobalSearch($queries, $andor, $max_hit, $start, $uid)
	{
		$ret = array();
		$modHand = xoops_getmodulehandler( 'data', $this->mXoopsModule->getVar('dirname') );
		$modObj =& $modHand->getSeachObject($queries, $andor, $max_hit, $start, $uid);
		foreach ($modObj as $key => $val) {
			$ret[$key]['image'] = XOOPS_URL.'/images/icons/posticon2.gif';
			$ret[$key]['link'] = XOOPS_MODULE_URL.'/'.basename(dirname(dirname(__FILE__))).'/index.php?action=single&lbid='.$val->getVar('id');
			$ret[$key]['title'] = $val->getVar('title');
			$ret[$key]['time'] = $val->getVar('date');
			$ret[$key]['uid'] = $val->getVar('uid');
		}
		return $ret;
	}
*/
}
?>
