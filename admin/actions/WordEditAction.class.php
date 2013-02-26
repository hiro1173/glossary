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

	// wordid を取征E
	function _getId()
	{
		return xoops_getrequest('wordid');
	}

	// タグのチE�Eタ�E�テキスト）を取征E
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

	// prepare メゾチE���E�オーバ�Eライド！E
	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		// 親クラスの prepare メゾチE��を実衁E
		parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		// モジュールの一般設定�E値
		$this->mConfig = $moduleConfig;
	}

	// チE�Eタの保孁E
	function execute(&$controller, &$xoopsUser)
	{
		$ret = parent::execute($controller, $xoopsUser);
		if ($ret == GLOSSARY_FRAME_VIEW_SUCCESS) {
			// 保存後に追加で処琁E��る場合�E、ここに書ぁE
			// 無かったら、execute 自体�E不要なので削除
		}

		return $ret;
	}

	// 処琁E�E開姁E
	function getDefaultView(&$controller, &$xoopsUser)
	{
		// オブジェクトが無ければ、エラーを返す
		if ($this->mObject == null) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}
		$this->mActionForm->load($this->mObject);

		// --------------------------------------------------------
		// 用語につけられたタグリスチE
		// --------------------------------------------------------
		$tagHandler =& xoops_getmodulehandler('tag');
		// 検索条件を設宁E
		$this->entryTags = $tagHandler->getTagList($this->mObject->getShow('wordid'));
		// executeViewInput の実衁E
		return GLOSSARY_FRAME_VIEW_INPUT;
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		global $adminmenu;

		// --------------------------------------------------------
		// カチE��リ
		// --------------------------------------------------------
		$categoryHandler =& xoops_getmodulehandler('category');
		$this->catagoryOptions = $categoryHandler->getSelectArray(true);
		// --------------------------------------------------------
		// Popular Tag Cloud
		// タグのリスト作�E
		// --------------------------------------------------------
		// sqlは調整の忁E��がある
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


	// チE�Eタを保存しぁE
	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{

		// executeViewSuccessを呼び出す前にチE�Eタは保存されてぁE��

		// --------------------------------------------------------
		// タグの保孁E
		// --------------------------------------------------------
		// 一般設定からタグの斁E��設定を呼び出ぁE
		$tagToLower = $this->mConfig['tagtolower'];

		$wordId = $this->mObject->getShow('wordid');

		// タグの保孁E
		$getTags = htmlSpecialChars($this->_getTags(), ENT_QUOTES ) ;
		$tagHandler = xoops_getmodulehandler('tag');
		$tagHandler->saveTags($wordId, $getTags, $tagToLower);




		// 基本の戻り�E
		$url = 'index.php';
		// チE�EタオブジェクトがあるかチェチE��
		if ($this->mObject != null) {
			// チE�Eタオブジェクトがある場合�E戻り�E
			$url = 'index.php?action=WordList';
		}
		// リダイレクチE
		$controller->executeRedirect($url, 1, _AD_GLOSSARY_WORD_EDIT_SUCCESS);
		// Not Use Redirect
		// $controller->executeForward('index.php');
	}

	// エラーが発甁E
	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		// エラーが発生した場合�E戻り�E
		$url = 'index.php';
		$controller->executeRedirect($url, 1, _AD_GLOSSARY_WORD_EDIT_ERROR);
	}

	// フォームでキャンセルを押されぁE
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php?action=WordList';
		// ペ�Eジの移勁E
		$controller->executeForward($url);
	}
}

?>
