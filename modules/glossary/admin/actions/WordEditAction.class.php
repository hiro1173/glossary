<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractEditAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/forms/WordAdminEditForm.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/include/functions.php';
require_once XOOPS_MODULE_PATH. '/glossary/admin/menu.php' ;


//require_once XOOPS_MODULE_PATH. '/glossary/include/functions.php';
//require_once XOOPS_MODULE_PATH. '/glossary/include/TagService.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/TagService.class.php';


class Glossary_WordEditAction extends Glossary_AbstractEditAction
{

//	var $use_fckeditor = false;
	var $catagoryOptions = array();
	var $tagCloudArray = array();

	// for menu
	var $breadCrumbs = array();
	var $confirmMssage = null;
	var $moduleHeader = null;
	var $menuDescription = null;

	// wordid 繧貞叙蠕・
	function _getId()
	{
		return xoops_getrequest('wordid');
	}

	// 繧ｿ繧ｰ縺ｮ繝・・繧ｿ・医ユ繧ｭ繧ｹ繝茨ｼ峨ｒ蜿門ｾ・
	function _getTags()
	{
		return xoops_getrequest('tags');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('word');
		return $handler;
	}

	function _setupActionForm()
	{
		$this->mActionForm = new Glossary_WordAdminEditForm();
		$this->mActionForm->prepare();
	}

	// prepare 繝｡繧ｾ繝・ヨ・医が繝ｼ繝舌・繝ｩ繧､繝会ｼ・
	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		// 隕ｪ繧ｯ繝ｩ繧ｹ縺ｮ prepare 繝｡繧ｾ繝・ヨ繧貞ｮ溯｡・
		parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		// 繝｢繧ｸ繝･繝ｼ繝ｫ縺ｮ荳闊ｬ險ｭ螳壹・蛟､
		$this->mConfig = $moduleConfig;
	}

	// 繝・・繧ｿ縺ｮ菫晏ｭ・
	function execute(&$controller, &$xoopsUser)
	{
		$ret = parent::execute($controller, $xoopsUser);
		if ($ret == GLOSSARY_FRAME_VIEW_SUCCESS) {
			// 菫晏ｭ伜ｾ後↓霑ｽ蜉縺ｧ蜃ｦ逅・☆繧句ｴ蜷医・縲√％縺薙↓譖ｸ縺・
			// 辟｡縺九▲縺溘ｉ縲‘xecute 閾ｪ菴薙・荳崎ｦ√↑縺ｮ縺ｧ蜑企勁
		}

		return $ret;
	}

	// 蜃ｦ逅・・髢句ｧ・
	function getDefaultView(&$controller, &$xoopsUser)
	{
		// 繧ｪ繝悶ず繧ｧ繧ｯ繝医′辟｡縺代ｌ縺ｰ縲√お繝ｩ繝ｼ繧定ｿ斐☆
		if ($this->mObject == null) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}
		$this->mActionForm->load($this->mObject);

		// --------------------------------------------------------
		// 逕ｨ隱槭↓縺､縺代ｉ繧後◆繧ｿ繧ｰ繝ｪ繧ｹ繝・
		// --------------------------------------------------------
		$tagHandler =& xoops_getmodulehandler('tag');
		// 讀懃ｴ｢譚｡莉ｶ繧定ｨｭ螳・
		$this->entryTags = $tagHandler->getTagList($this->mObject->getShow('wordid'));
		// executeViewInput 縺ｮ螳溯｡・
		return GLOSSARY_FRAME_VIEW_INPUT;
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;

		// --------------------------------------------------------
		// 繧ｫ繝・ざ繝ｪ
		// --------------------------------------------------------
		$categoryHandler =& xoops_getmodulehandler('category');
		$this->catagoryOptions = $categoryHandler->getSelectArray(true);
		// --------------------------------------------------------
		// Popular Tag Cloud
		// 繧ｿ繧ｰ縺ｮ繝ｪ繧ｹ繝井ｽ懈・
		// --------------------------------------------------------
		// sql縺ｯ隱ｿ謨ｴ縺ｮ蠢・ｦ√′縺ゅｋ
		$popularTags =TagService::getPopularTags($limit = 50, $days = NULL) ;
		if (count($popularTags) > 0) {
			$this->tagCloudArray = TagService::tagCloud($popularTags, $steps = 5, $sizemin = 100, $sizemax = 225, $sortOrder = 'alphabet_asc');
		}
		$this->breadCrumbs[]   = array('name' => _AD_GLOSSARY_WORD_LIST ,'url'  => 'index.php?action=WordList' ) ;
		$this->breadCrumbs[]   = array('name' => _AD_GLOSSARY_WORD_EDIT) ;

		$this->moduleHeader   .= '<script type="text/javascript" src="./../jsScuttle.js"></script>';
		$this->menuDescription = _AD_GLOSSARY_WORD_EDIT_DSC ;

		$render->setTemplateName('glossary_word_edit.html');

		$render->setAttribute('module_info'   , getModuleInfo());
		$render->setAttribute('module_header' , $this->moduleHeader);
		$render->setAttribute('bread_crumbs'  , $this->breadCrumbs);
		$render->setAttribute('set_menu'      , $adminmenu );
		$render->setAttribute('set_menu_no'   , 2);
		$render->setAttribute('set_menu_desc' , $this->menuDescription);
		$render->setAttribute('set_mssage'    , $this->confirmMssage);

		$render->setAttribute('actionForm'    , $this->mActionForm);
		$render->setAttribute('object'        , $this->mObject);
		$render->setAttribute('config'        , $this->mConfig);

		$render->setAttribute('cat_options'    , $this->catagoryOptions);
		$render->setAttribute('entry_tags'   , $this->entryTags);
		$render->setAttribute('tag_cloud'     , $this->tagCloudArray);

	}


	// 繝・・繧ｿ繧剃ｿ晏ｭ倥＠縺・
	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{

		// executeViewSuccess繧貞他縺ｳ蜃ｺ縺吝燕縺ｫ繝・・繧ｿ縺ｯ菫晏ｭ倥＆繧後※縺・ｋ

		// --------------------------------------------------------
		// 繧ｿ繧ｰ縺ｮ菫晏ｭ・
		// --------------------------------------------------------
		// 荳闊ｬ險ｭ螳壹°繧峨ち繧ｰ縺ｮ譁・ｭ苓ｨｭ螳壹ｒ蜻ｼ縺ｳ蜃ｺ縺・
		$tagToLower = $this->mConfig['tagtolower'];

		$wordId = $this->mObject->getShow('wordid');

		// 繧ｿ繧ｰ縺ｮ菫晏ｭ・
		$getTags = htmlSpecialChars($this->_getTags(), ENT_QUOTES ) ;
		$tagHandler = xoops_getmodulehandler('tag');
		$tagHandler->saveTags($wordId, $getTags, $tagToLower);




		// 蝓ｺ譛ｬ縺ｮ謌ｻ繧雁・
		$url = 'index.php';
		// 繝・・繧ｿ繧ｪ繝悶ず繧ｧ繧ｯ繝医′縺ゅｋ縺九メ繧ｧ繝・け
		if ($this->mObject != null) {
			// 繝・・繧ｿ繧ｪ繝悶ず繧ｧ繧ｯ繝医′縺ゅｋ蝣ｴ蜷医・謌ｻ繧雁・
			$url = 'index.php?action=WordList';
		}
		// 繝ｪ繝繧､繝ｬ繧ｯ繝・
		$controller->executeRedirect($url, 1, _AD_GLOSSARY_WORD_EDIT_SUCCESS);
		// Not Use Redirect
		// $controller->executeForward('index.php');
	}

	// 繧ｨ繝ｩ繝ｼ縺檎匱逕・
	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		// 繧ｨ繝ｩ繝ｼ縺檎匱逕溘＠縺溷ｴ蜷医・謌ｻ繧雁・
		$url = 'index.php';
		$controller->executeRedirect($url, 1, _AD_GLOSSARY_WORD_EDIT_ERROR);
	}

	// 繝輔か繝ｼ繝縺ｧ繧ｭ繝｣繝ｳ繧ｻ繝ｫ繧呈款縺輔ｌ縺・
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=WordList';
		// 繝壹・繧ｸ縺ｮ遘ｻ蜍・
		$controller->executeForward($url);
	}
}

?>
