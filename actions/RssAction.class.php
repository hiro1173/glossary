<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractIndexAction.class.php';


class Glossary_RssAction extends Glossary_AbstractIndexAction
{




	function getDefaultView(&$controller, &$xoopsUser)
	{

		return GLOSSARY_FRAME_VIEW_INDEX;
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$root =& XCube_Root::getSingleton();
		// tテンプレートを直接使う
		// XoopsTplではアサインされていない。
		$xoopsTpl = new XoopsTpl();
		$xoopsTpl->assign('sitename', $root->mContext->mXoopsConfig['sitename']);
		$xoopsTpl->assign('slogan', $root->mContext->mXoopsConfig['slogan']);
		$xoopsTpl->assign('adminmail', $root->mContext->mXoopsConfig['adminmail']);
		$xoopsTpl->assign('title', $root->mContext->mModule->mXoopsModule->getVar('name'). '|'. $root->mContext->mXoopsConfig['sitename']);
		$xoopsTpl->assign('rss_url', XOOPS_MODULE_URL. '/glossary/rss.php');
		$xoopsTpl->assign('rss_updated', '');
//		$xoopsTpl->assign('rss_item', $this->rssArray);
		$xoopsTpl->display('db:glossary_feed_rss20.html') ;

	}
}
?>
