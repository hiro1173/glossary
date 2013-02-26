<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractViewAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/Glossary_SqlService.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/TagService.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/include/functions.php';

class Glossary_WordViewAction extends Glossary_AbstractViewAction
{

	var $mConfig  = array();
	var $mObject = null;
	var $mCategoryObject = null;

	var $tags = null;

	var $hitWords = array();
	var $newWords = array();
	var $newWordBlockUsed = false ;
	var $wordHits = null;

	var $relationWords = array();

	var $metaKeyword = null;

	var $breadcrumbs = array();
	var $wordDescription = null;
	var $metaDescription = null;
	var $keyWords = null;
	var $pageTitle = null;

	function _getId()
	{
		return xoops_getrequest('wordid');
	}

	function _getWord()
	{
		return xoops_getrequest('word');
	}

	function _getKeywords()
	{
		return xoops_getrequest('keywords');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('word');
		return $handler;
	}

	function _getBaseUrl()
	{
		return 'index.php?action=WordView';
	}

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
		// AbstractViewAction.class.php の prepare メゾットを実行
//		parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		$this->_setupObject();
		// モジュールの一般設定の値
		$this->mConfig = $moduleConfig;
	}

	// デフォルトの表示のためのデータを作成
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$handler =& $this->_getHandler();
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;

		$textFilter =& $root->getTextFilter();    // テキストフィルター

		// module Config
		$configUseModRewrite = $this->mConfig['use_mod_rewrite'];
		$newWordsCount = $this->mConfig['newwordsuse'];
		$configRelatedWords  = $this->mConfig['related_words'];
		$configDescriptionLength  = $this->mConfig['desrlength'];

		// get id
		$wordId = $this->_getId();
		$this->keyWords = $this->_getKeywords();

		if ($configUseModRewrite) {
			$getTags = mb_convert_encoding(htmlspecialchars(urldecode($this->_getWord()), ENT_QUOTES) ,'UTF-8','auto');
			$wordId = Glossary_SqlService::sqlGetId('glossary_word', 'wordid', 'term', $getTags);
			$this->mObject =& $handler->get($wordId, true);
		} else {
			$this->mObject =& $handler->get($wordId, true);
		}

//echo '%%%%%%%%%%%%%%%<br />';
//echo $this->keyWords ;

		// データオブジェクトが無ければエラー
		if ($this->mObject == null) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}

		// hit counter up
		if (!$controller->mRoot->mContext->mUser->isInRole('Module.glossary.Admin')) {
			$countUp = $handler->hitCountUp($wordId);
			if ($countUp) {
				$this->wordHits = $this->mObject->get('hits') + 1 ;
			}
		} else {
			$this->wordHits = $this->mObject->get('hits') ;
		}

		// --------------------------------------------------------
		// Get tag
		// --------------------------------------------------------
		// get word's tag
		$tagHandler =& xoops_getmodulehandler('tag');
		$this->entryTags = $tagHandler->getEntoryTagArray($wordId);
// 修正が必要
// SELECT * FROM `bee22a_glossary_word` WHERE wordid = 1099 が２回実行される
// SELECT * FROM `bee22a_glossary_tag` WHERE (wordid = 1099) ORDER BY `tag` ASC が２回実行される
		// --------------------------------------------------------
		// Meta keyword & Meta Description
		// Meta Description は、全角100文字が目安
		// 用語は、タイトル・キーワード・説明にすべて含ませる
		// --------------------------------------------------------
		if (!is_null($this->mObject->get('term'))) $this->metaKeyword .=  $this->mObject->get('term');
		$this->metaKeyword .= ','. $tagHandler->getTagList($wordId, true);

		if (!is_null($this->mObject->get('english'))) $this->metaKeyword .= ','. $this->mObject->get('english');

		$metaDescription = $textFilter->toShowTarea($this->mObject->get('description'), $html=1, $smiley=1, $xcode=0, $image=1, $br=1,false);
		$metaDescription = preg_replace('!<script.*?>.*?</script.*?>!is', '', $metaDescription);    // del java script
		$metaDescription = strip_tags($metaDescription);    // del HTML tag
		$metaDescription = sprintf(_MD_GLOSSARY_WORD_METADESCRIPTION, $this->mObject->get('term')). $metaDescription ; // set first word term
		// trim meta description length
		if ( !XOOPS_USE_MULTIBYTES ) {
			$this->metaDescription = substr ( $metaDescription, 0, 160 -1 ) . "...";
		} else {
			$this->metaDescription = xoops_substr( $metaDescription, 0, 160 +2 );
		}

		// --------------------------------------------------------
		// Related Words
		// --------------------------------------------------------
		if ($configRelatedWords > 0) {
			if ( $configRelatedWords==1) {
				$this->relationWords = Glossary_SqlService::getRelationWords($wordId, $this->mObject->get('term'), $configUseModRewrite) ;
			}
			if ( $configRelatedWords==2) {
				// Wrod Serach
				// 検索モジュールを使ってサイト内を対象する
				// --------------------------------------------------------
				// Looking for term with description into Link word
				// 他のモジュールでのキーワード出現を探して表示する
				// searchを流用したものに
				// --------------------------------------------------------
			}
		}

		// --------------------------------------------------------
		// New & Hit Words
		// --------------------------------------------------------
		if ($newWordsCount > 0) {
			$this->newWordBlockUsed = true;
			$this->hitWords = Glossary_SqlService::getHitsWords($newWordsCount, $configUseModRewrite, $wordId, $this->mObject->get('categoryid')) ;
			$this->newWords = Glossary_SqlService::getNewWords ($newWordsCount, $configUseModRewrite, $wordId, $this->mObject->get('categoryid')) ;
		}

		// --------------------------------------------------------
		// Looking for term with description into Link word
		// 用語の説明文中のキーワードを検索し、説明文を置換する
		// --------------------------------------------------------
		$this->wordDescription = $this->mObject->get('description');

		// Get Link Word  ... It's Character code dependence , Set language in main.php.
		preg_match_all(_MD_GLOSSARY_WORDLINKWORD, $this->mObject->get('description'), $q_arr);
		$q_arr = array_unique($q_arr[0]);    // take out repetition
		sort($q_arr);                        // Sort word
		reset($q_arr);                       // With a pointer in the lead(The list of the word to rearrange is completed)
		$word_array = array();               // Search Word
		$link_array = array();               // Wrod URL
		if ( count($q_arr) > 0 ) {
			// Wrod Serach
			// Glossary内を対象にする
			$count = 0;
			if ( is_array($q_arr) && $count = count($q_arr) ) {
				for ( $i = 0; $i < $count; $i++ ) {
					// Search Word is $q_arr[$i]
					$searchWord = preg_replace (_MD_GLOSSARY_WORD_DELWORD ,"",$q_arr[$i]);    // Delete Link wrod
					$sql = "SELECT c.categoryid, c.name, w.wordid, w.term FROM " . $db -> prefix("glossary_category")." c LEFT JOIN "
						. $db -> prefix("glossary_word")." w ON c.categoryid = w.categoryid WHERE wordid<>"
						. $wordId. " AND `term` ='". $searchWord ."' AND published > 0 LIMIT 1";
					if ( $resultNew = $db -> query($sql) ) {
						while (list($categoryId, $categoryName, $linkWordId, $linkWordTerm ) = $db -> fetchRow($resultNew)) {
							$WordUrl = Glossary_functionGetWordUrl( $configUseModRewrite, intval($linkWordId), addSlashes($linkWordTerm), addSlashes($categoryName) );
							// Word Link
							$linkWordUrl ="<a href=\"". $WordUrl. "\">".$searchWord ."</a>";
							array_push ($link_array,  $linkWordUrl);  // Set Array to Word & URL
							array_push ($word_array,  $q_arr[$i]);    // Set Array Word & Link to Display HTML
						}
					}
				}
				// If there are data to replace with a link, I rearrange the uniform resource locator which linked a word
				if (count($link_array)>0) {
					$this->wordDescription = $this->replace_wordlinks($word_array, $link_array, $this->mObject->get('description'));
				}
			}
		}

		// 検索用語の変換
		if (!is_null($this->keyWords)) {
			$this->wordDescription  = Glossary_replace_search_result($this->keyWords, $this->wordDescription);
		}

//$this->relationWords


		// --------------------------------------------------------
		// Page Component
		// --------------------------------------------------------
		// カテゴリのデータ取得
		$categoryId = $this->mObject->get('categoryid');
		$categoryHandler =& xoops_getmodulehandler('category');
		$this->mCategoryObject =& $categoryHandler->get($categoryId);

		// カテゴリが登録されていない
		if ($this->mCategoryObject == null) {
			return GLOSSARY_FRAME_VIEW_ERROR;
		}

		// Bread Crubs
		$this->breadcrumbs[] = array('name' => $root->mContext->mModule->mXoopsModule->getVar('name') , 'url' => XOOPS_MODULE_URL . '/glossary/' ) ;
		if ($this->mConfig['use_category']) {
			if ($this->mCategoryObject <> null) {
				$this->breadcrumbs[] = array('name' => $this->mCategoryObject->get('name') ,'url'  => Glossary_functionGetCategoryUrl( $configUseModRewrite, $categoryId,  $this->mCategoryObject->get('name')) ) ;
			}
		}
		$this->breadcrumbs[] = array('name' => $this->mObject->get('term')) ;
		// Page Title
		$this->pageTitle = $root->mContext->mModule->mXoopsModule->getVar('name') .' &raquo; '. $this->mCategoryObject->get('name').' &raquo; '.$this->mObject->get('term');

		return GLOSSARY_FRAME_VIEW_INDEX;
	}

	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName('glossary_word_view.html');
		// configs
		$render->setAttribute('config'  , $this->mConfig);      // xoops module config
		// mod rewrite

		$render->setAttribute('isUser'  , is_object($xoopsUser));

		// main data
		$render->setAttribute('object'  , $this->mObject);
		$render->setAttribute('categoryObject'   , $this->mCategoryObject);

		$render->setAttribute('word_hits'        , $this->wordHits);
		$render->setAttribute('querywords'       , $this->keyWords);
		$render->setAttribute('tags'             , $this->entryTags) ;
		$render->setAttribute('relation_words'   , $this->relationWords );
		$render->setAttribute('word_description' , $this->wordDescription );

		// New and Hits words block
		$render->setAttribute('new_words_block_used' ,$this->newWordBlockUsed);
		if ($this->newWordBlockUsed) {
			$render->setAttribute('new_words'   , $this->newWords);
			$render->setAttribute('hit_words'   , $this->hitWords);
		}

		// Page Component ( HTML Header, Bread Crubs )
		$render->setAttribute('xoops_breadcrumbs' ,$this->breadcrumbs) ;
		$render->setAttribute('xoops_pagetitle'       , $this->pageTitle ); 
		$render->setAttribute('xoops_meta_description', $this->metaDescription);
		$render->setAttribute('xoops_meta_keywords'   , $this->metaKeyword);
		$moduleHeader = '<link rel="stylesheet" type="text/css" href="' . XOOPS_MODULE_URL. '/glossary/module.css" />'."\n";
		$render->setAttribute('xoops_module_header', $moduleHeader);
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		if ( $this->mConfig['use_mod_rewrite']) {
			$url = './../../index.php';
		} else {
			$url = 'index.php';
		}
		$controller->executeRedirect($url, 1, _MD_GLOSSARY_ERORR_NOSUBMITTED);
	}

	// --------------------------------------------------------
	// Replace Word Link
	// --------------------------------------------------------
	function replace_wordlinks($query, $link, $str)
	{
		foreach ($query as $val) {
			$qq[] = "'(".preg_quote($val).")'i";
		}
		return preg_replace($qq, $link, $str);
	}


}


?>
