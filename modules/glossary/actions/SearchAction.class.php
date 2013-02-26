<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractIndexAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/forms/SearchForm.class.php';


require_once XOOPS_MODULE_PATH. '/glossary/include/functions.php';
//require_once XOOPS_MODULE_PATH. '/glossary/include/SqlUtilty.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/Glossary_SqlService.class.php';
//require_once XOOPS_MODULE_PATH. '/glossary/include/TagService.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/TagService.class.php';

require_once XOOPS_MODULE_PATH. '/glossary/include/searchtext.php';


class Glossary_SearchAction extends Glossary_AbstractIndexAction
{
	var $mConfig = array();
	var $mPagenavi = null;

	var $resultCount = 0;
	var $queryWords = null;


	var $categoryItem      = array();
	var $categoryItemArray = array();
	var $blockWord         = array();
	var $blockWordArray    = array();
	var $hitWord           = array();
	var $newWord           = array();
	var $newWordsBlockUsed = false ;
	var $resultWordsArray  = array();


	function _getQuery()
	{
		return xoops_getrequest('query');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('word');
		return $handler;
	}

	function &_getFilterForm()
	{
		$filter = new Glossary_DBFilterForm($this->_getPageNavi(), $this->_getHandler());
		return $filter;
	}

	function _getBaseUrl()
	{
		return 'index.php';
	}

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		$this->mConfig = $moduleConfig;
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;
		$textFilter =& $root->getTextFilter();    // チE??ストフィルター

		// moduleConfig
		$configUseModRewrite = $this->mConfig['use_mod_rewrite'];
		$configNewWordsUse   = $this->mConfig['newwordsuse'];
		$configDesrLength     = $this->mConfig['desrlength'];    // Number of the indication description

		// タグ用ハンドラ
		$tagHandler =& xoops_getmodulehandler('tag');
		// 検索用?E
		$this->queryWords = trim($this->_getQuery());

		// チE?Eタオブジェクトが無ければエラー
		if (!$this->queryWords) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}

		// --------------------------------------------------------
		// Change space ZENKAKU to HANKAKU
		// --------------------------------------------------------
		if (function_exists('mb_convert_kana')){
			$this->queryWords = trim( mb_convert_kana( $this->queryWords, "s", _CHARSET));
		}

		// Array to Search words with space
		$queryArray = preg_split ("/[\s,]+/", $this->queryWords); 

		// TODO 次のバ?Eジョンで?E??込み
		foreach ($queryArray as $qword) {
			// $q = strip_tags($q);
			$qword = trim($qword);
//			$queries[] = htmlSpecialChars($qword, ENT_QUOTES ) ;   // クエリのサニタイズはここで

			// --------------------------------------------------------
			// mb_convert_kana と mb_detect_encodingが利用できるかを確?E
			// --------------------------------------------------------
			if(function_exists('mb_convert_kana') && function_exists('mb_detect_encoding')){
				// --------------------------------------------------------
				// 全角英数があれ?E、検索語を半角英数に変換する
				// --------------------------------------------------------
				if (preg_match("/\xA3[\xC1-\xFA]/", $qword)){
					$queries[] = mb_convert_kana(addSlashes($qword), 'a');
				}
			}
		}


		// --------------------------------------------------------
		// Search Action
		// --------------------------------------------------------
		$sql = "SELECT c.categoryid, c.name, w.wordid, w.term, w.proc, w.description FROM "
			. $db->prefix("glossary_category")." c LEFT JOIN "
			. $db->prefix("glossary_word")." w ON c.categoryid = w.categoryid WHERE published > 0 ";
		if (is_array($queryArray) && $count = count($queryArray)) {
			// Full text search
			$sql .= " AND ((  w.term        LIKE '%$queryArray[0]%' OR 
					w.proc        LIKE '%$queryArray[0]%' OR 
					w.english     LIKE '%$queryArray[0]%' OR 
					w.description LIKE '%$queryArray[0]%')";
					for($i = 1;$i < $count;$i++) {
						$sql .= " AND ";
						$sql .= "(  w.term        LIKE '%$queryArray[$i]%' OR 
								w.proc        LIKE '%$queryArray[$i]%' OR 
								w.english     LIKE '%$queryArray[$i]%' OR 
								w.description LIKE '%$queryArray[$i]%')";
					}
			$sql .= ") ";
		} 
		$sql .= " ORDER BY w.hits DESC";
		$result = $db->query($sql);
		// result count
		$this->resultCount = $db->getRowsNum($result); 
		if ($this->resultCount > 0) {
			while (list($categoryId, $categoryName, $wordId, $wordTerm, $wordProc, $wordDesc) = $db->fetchRow($result)) {
				$wordTerm = addSlashes($wordTerm);
				$viewWordTerm = Glossary_replace_search_result($this->queryWords, $wordTerm);
				$wordProc = addSlashes($wordProc);
				$wordProc = Glossary_replace_search_result($this->queryWords, $wordProc);
				// HTML tag script 除去
				$wordDesc = $textFilter->toShowTarea($wordDesc, $html=1, $smiley=1, $xcode=0, $image=1, $br=1,false);
				$wordDesc = preg_replace('!<script.*?>.*?</script.*?>!is', '', $wordDesc);
				$wordDesc = strip_tags($wordDesc);
				// $wordDesc = htmlSpecialChars($wordDesc, ENT_QUOTES );

				// 検索用語?E取り出ぁE
				$wordDesc  = replace_search_text($this->queryWords, $wordDesc, 250);
				
				// タグクラウド?E単語?Eリスト取り?EぁE
				$wordTagArray = $tagHandler->getEntoryTagArray($wordId);
				$this->resultWordsArray[] = array(
					'view_term'     => $viewWordTerm,
					'term'          => $wordTerm,
					'proc'          => $wordProc,
					'word_desc'     => $wordDesc ,
					'category'  => addSlashes($categoryName),
					'linkWordUrl'   => Glossary_functionGetWordUrl( $configUseModRewrite, intval($wordId), addSlashes($wordTerm) ),
					'category_link' => Glossary_functionGetCategoryUrl( $configUseModRewrite, $categoryId, $categoryName ) ,
					'tags'          => $wordTagArray,
				);
			}
		} else {
			// no result
			$resultCount = 0;
		}

		// --------------------------------------------------------
		// Page Component
		// --------------------------------------------------------
		// Bread Crubs
		$this->breadcrumbs[] = array('name' => $root->mContext->mModule->mXoopsModule->getVar('name') , 'url' => XOOPS_MODULE_URL. '/glossary/' ) ;
		$this->breadcrumbs[] = array('name' => _MD_GLOSSARY_SEARCHRESULTS )  ;
		// Page Title
		$this->pageTitle = $root->mContext->mModule->mXoopsModule->getVar('name') .' &raquo; '. _MD_GLOSSARY_SEARCHRESULTS;


		return GLOSSARY_FRAME_VIEW_INDEX;
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName('glossary_searchresults.html');

		$render->setAttribute('config'  , $this->mConfig);    // xoops module config

		// mod rewrite

		// --------------------------------------------------------
		// Page Component ( HTML Header, Bread Crubs )
		// --------------------------------------------------------
		$render->setAttribute('xoops_pagetitle'  , $this->pageTitle );
		$render->setAttribute('xoops_breadcrumbs' ,$this->breadcrumbs) ;

		$moduleHeader = '<link rel="stylesheet" type="text/css" href="' . XOOPS_MODULE_URL. '/glossary/module.css" />'."\n";
		$render->setAttribute('xoops_module_header',$moduleHeader);


		// --------------------------------------------------------
		// Top Page Readme
		// --------------------------------------------------------
		$render->setAttribute('querywords' ,$this->queryWords);
		$render->setAttribute('resultCount' ,$this->resultCount);
		$render->setAttribute('endResult' ,true);
		$render->setAttribute('resultWords' ,$this->resultWordsArray);

	}


	// エラーが発甁E
	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$url = 'index.php';
		$controller->executeRedirect($url, 1, _MD_GLOSSARY_ERORR_NOSUBMITTED);
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
