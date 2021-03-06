<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

// ãEEã¿ã®ãªãã¸ã§ã¯ãããEEãã«ããåå¾ããªãE ´åãEå¦çE
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

	// ç¾å¨ã®ã¿ã°
	function _getTag()
	{
		return xoops_getrequest('tag');
	}

	// æ°ããã¿ã°
	function _getNewTag()
	{
		return xoops_getrequest('new_tag');
	}

	// ãEEã¿ãã³ãã©ã®è¨­å®E
	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('tag');
		return $handler;
	}

	// ã¢ã¯ã·ã§ã³ãã©ã¼ã ãæºå
	function _setupActionForm()
	{
		$this->mActionForm = new Grossary_TagAdminEditForm();
		$this->mActionForm->prepare();
	}


	// æºå
	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		// /class/AbstractEditAction.class.php ã® prepare ãå®è¡E
		// parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		$this->mConfig = $moduleConfig;
		$this->_setupActionForm();
		$this->_setupObject();

		// ãEEã¿ãã³ãã©ã¼ãç¡ãE ´åãããã³ãã©ã¼ã«è¿½å ããã«ã¯ãã¡ãE
		// GETãEEã¿ããªãã¸ã§ã¯ãã«ãEEã¿ãä»£å¥
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

	// å¥åç»é¢ãè¡¨ç¤ºãã
	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;
		// --------------------------------------------------------
		// ç®¡çE»é¢ã®ãããã¼ã¨ã¡ãã¥ã¼ä½æE
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
		// ã¢ã¸ã¥ã¼ã«ã®æE ±
		// --------------------------------------------------------
		$render->setAttribute('actionForm' , $this->mActionForm);
		$render->setAttribute('object'     , $this->mObject);

	}

	// æ´æ°æå
	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=TagList';
		$controller->executeRedirect($url, 1, _AD_GLOSSARY_TAG_SUCCESS);
	}

	// ã¨ã©ã¼ãçºçE
	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=TagList';
		$controller->executeRedirect($url, 1, _AD_GLOSSARY_TAG_EDIT_ERROR);
	}

	// ãã©ã¼ã ã§ã­ã£ã³ã»ã«ãæ¼ãããE
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=TagList';
		$controller->executeForward($url);
	}

	// ãEEã¿ã®æ´æ°
	// AbstractEditAction.class.php -> _doExecute() ããªã¼ããEã©ã¤ãE
	function _doExecute()
	{
		$handler =& xoops_getmodulehandler('tag');
		// ã¿ã°ã®ä¸æ¬ç½®æE/class/handler/Tag.class.php
		$update = $handler->renameTag($this->mObject->get('tag'), $this->mObject->get('new_tag'));

		return $this->mObject;
	}

}

?>
