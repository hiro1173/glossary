<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

// サービスの呼び出ぁE
require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractEditAction.class.php';

// アクションフォームのクラスを呼び出ぁE
require_once XOOPS_MODULE_PATH. '/glossary/forms/WordEditForm.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/include/functions.php';
//require_once XOOPS_MODULE_PATH. '/glossary/include/TagService.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/TagService.class.php';


class Glossary_WordEditAction extends Glossary_AbstractEditAction
{

	// クラス?E??使用する変数の宣言
	var $tagCloudArray = array();
	var $categories  = array();
	var $entryTags = null;

	// 入力された値を受け取めE
	function _getId()
	{
		return xoops_getrequest('wordid');
	}

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
		$this->mActionForm = new Glossary_WordEditForm();
		$this->mActionForm->prepare();
	}

	// --------------------------------------------------------
	// アクセス権のチェチE??
	// --------------------------------------------------------
	function hasPermission(&$controller, &$xoopsUser, &$moduleConfig)
	{
		// 管理権限がある
		if ($controller->mRoot->mContext->mUser->isInRole('Module.glossary.Admin')) {
			return true;
		}
		if (is_object($xoopsUser)) {
			$uid = $this->mObject->getShow('uid');
			// 登録したユーザー以
			if ($uid != $xoopsUser->uid()) {
				$controller->executeRedirect('index.php', 1, _MD_GLOSSARY_ERROR_EDIT_FOR_PERMISSION);
			}
		} else {
			// 登録ユーザーでない
			$controller->executeRedirect('index.php', 1, _MD_GLOSSARY_ERROR_EDIT_FOR_PERMISSION);
		}
		return true;
	}



	function execute(&$controller, &$xoopsUser)
	{
		$ret = parent::execute($controller, $xoopsUser);
		if ($ret == GLOSSARY_FRAME_VIEW_SUCCESS) {

			$tagToLower = $this->mConfig['tagtolower'];
			$wordId = $this->mObject->getShow('wordid');

			// タグの保存
			$getTags = htmlSpecialChars($this->_getTags(), ENT_QUOTES ) ;
			$tagHandler = xoops_getmodulehandler('tag');
			$tagHandler->saveTags($wordId, $getTags, $tagToLower);

		}
		return $ret;
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		// オブジェクトが無ければ、エラーを返す
		if ($this->mObject == null) {
//			return GLOSSARY_FRAME_VIEW_ERROR;
		}
		$this->mActionForm->load($this->mObject);

                     
		// --------------------------------------------------------
		// 用語につけられたタグリスト
		// --------------------------------------------------------
		if (!$this->mObject->isNew()) {
			$tagHandler =& xoops_getmodulehandler('tag');
			$this->entryTags = $tagHandler->getTagList($this->mObject->getShow('wordid'));
		}
		return GLOSSARY_FRAME_VIEW_INPUT;
	}

	// 編雁E??面の描画
	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$root =& XCube_Root::getSingleton();

		// --------------------------------------------------------
		// カチE??リ
		// --------------------------------------------------------
		if ($this->mConfig['use_category'] > 0 ) {
			$categoryHandler =& xoops_getmodulehandler('category');
			// make SQL filter & order
			$mCriteria = new CriteriaCompo();
			$mCriteria->addSort('weight', 'ASC');  // sort order
			// module Objects
			$this->categories =& $categoryHandler->getObjects($mCriteria);
			if ($this->categories == null) {
				// return GLOSSARY_FRAME_VIEW_ERROR;
				$url = 'index.php';
				$controller->executeRedirect($url, 1, _MD_GLOSSARY_CATEGORY_ISNOTSET);
			}
		}

		// --------------------------------------------------------
		// Popular Tag Cloud
		// タグのリスト作?E
		// --------------------------------------------------------
		// sqlは調整の?E??がある
		$popularTags = TagService::getPopularTags($limit = 50, $days = NULL) ;
		if (count($popularTags) > 0){
			$this->tagCloudArray = TagService::tagCloud($popularTags, $steps = 5, $sizemin = 100, $sizemax = 225, $sortOrder = 'alphabet_asc');
		}

		$getTags = $this->_getTags();
		if ( !is_null($getTags) ) {
			$this->entryTags = $getTags;
		}
//echo '++++++++<br />';
//echo $this->entryTags;

		$render->setTemplateName('glossary_word_edit.html');
		$render->setAttribute('actionForm' , $this->mActionForm);
		$render->setAttribute('categories', $this->categories);
		$render->setAttribute('entry_tags' , $this->entryTags);
		$render->setAttribute('tag_cloud' , $this->tagCloudArray);

		$this->breadcrumbs[] = array('name' => $root->mContext->mModule->mXoopsModule->getVar('name') , 'url' => XOOPS_MODULE_URL . '/glossary/' ) ;
		$this->breadcrumbs[] = array('name' => _MD_GLOSSARY_WORD_EDIT) ;

		$render->setAttribute('xoops_breadcrumbs' ,$this->breadcrumbs) ;
		$render->setAttribute('config'  , $this->mConfig);
		$render->setAttribute('use_fckeditor' , $root->mContext->mModuleConfig['use_fckeditor']);

		// --------------------------------------------------------
		// Set Module Header
		// --------------------------------------------------------
		$moduleHeader = '<link rel="stylesheet" type="text/css" href="' . XOOPS_MODULE_URL. '/glossary/module.css" />'."\n";
//		$moduleHeader.= "<script type=\"text/javascript\" src=\"jsScuttle.php\"></script>\n";
		$moduleHeader.= "<script type=\"text/javascript\" src=\"jsScuttle.js\"></script>\n";
		$render->setAttribute('xoops_module_header',$moduleHeader);
	}

	// フォームが正しく処?E??れた場合?E処?E
	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect('index.php', 1, _MD_GLOSSARY_EDIT_SUCCESS);
		// Not Use Redirect
		// $controller->executeForward('index.php');
	}

	// エラーが発甁E
	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php';
		if ($this->mObject != null) {
			$id = $this->mObject->getShow('wordid') ? $this->mObject->getShow('wordid') : 0;
			$url = 'index.php?action=WordView&wordid='. $id;
		}
		$controller->executeRedirect($url, 1, _MD_GLOSSARY_WORD_EDIT_ERROR);
	}

	// フォームでキャンセルを押されぁE
	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php';
		if ($this->mObject != null) {
			if ($this->mObject->isNew()) {
				$id = xoops_getrequest('wordid');
			} else {
				$id = $this->mObject->getShow('wordid');
				$url = 'index.php?action=Wordview&wordid=' . $id;
			}
		}
		$controller->executeForward($url);
	}
}

?>
