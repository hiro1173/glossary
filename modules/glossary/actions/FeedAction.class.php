<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractViewAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/include/functions.php';
//require_once XOOPS_MODULE_PATH. '/glossary/include/SqlUtilty.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/Glossary_SqlService.class.php';

//require_once XOOPS_MODULE_PATH. '/glossary/include/TagService.php';
require_once XOOPS_MODULE_PATH. '/glossary/class/TagService.class.php';
class Glossary_FeedAction extends Glossary_AbstractViewAction
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
		// AbstractViewAction.class.php  prepare ]bgs
		parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		// W[????l
		$this->mConfig = $moduleConfig;
	}

	// ftHg?\???f[^?
	function getDefaultView(&$controller, &$xoopsUser)
	{
		$handler =& $this->_getHandler();
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;

		$textFilter =& $root->getTextFilter();    // eLXgtB^[

		// module Config
		$configUseModRewrite = $this->mConfig['use_mod_rewrite'];
		$newWordsCount = $this->mConfig['newwordsuse'];
		$configRelatedWords  = $this->mConfig['related_words'];
		$configDescriptionLength  = $this->mConfig['desrlength'];

		// get id
		$wordId = $this->_getId();
		$this->keyWords = $this->_getKeywords();

//echo '%%%%%%%%%%%%%%%<br />';
//echo $this->keyWords ;
		if (!isset($wordId)) {
			if ($configUseModRewrite) {
				$getTags = mb_convert_encoding(htmlspecialchars(urldecode($this->_getWord()), ENT_QUOTES) ,'UTF-8','auto');
				$wordId = sqlGetId('glossary_word', 'wordid', 'term', $getTags);
				$this->mObject =& $handler->get($wordId, true);
			} else {
				$this->mObject =& $handler->get($wordId, true);
			}
		}

		// f[^IuWFNg?G[
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

		// --------------------------------------------------------
		// Meta keyword & Meta Description
		// Meta Description ?ASp100?
		// p?A^CgEL[[hE?????
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
				$this->relationWords = getRelationWords($wordId, $this->mObject->get('term'), $configUseModRewrite) ;
			}
			if ( $configRelatedWords==2) {
				// Wrod Serach
				// W[g?TCg??
				// --------------------------------------------------------
				// Looking for term with description into Link word
				// ?W[??L[[hoT?\
				// search??p?
				// --------------------------------------------------------
			}
		}

		// --------------------------------------------------------
		// New & Hit Words
		// --------------------------------------------------------
		if ($newWordsCount > 0) {
			$this->newWordBlockUsed = true;
			$this->hitWords = getHitsWords($newWordsCount, $configUseModRewrite, $wordId, $this->mObject->get('categoryid')) ;
			$this->newWords = getNewWords ($newWordsCount, $configUseModRewrite, $wordId, $this->mObject->get('categoryid')) ;
		}

		// --------------------------------------------------------
		// Looking for term with description into Link word
		// p??L[[hAu
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
			// Glossary???
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
							$linkWordUrl ="<a href=\"". XOOPS_URL. "/modules/glossary/".$WordUrl. "\">".$searchWord ."</a>";
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

		// p??
		if (!is_null($this->keyWords)) {
			$this->wordDescription  = Glossary_replace_search_result($this->keyWords, $this->wordDescription);
		}

//$this->relationWords


		// --------------------------------------------------------
		// Page Component
		// --------------------------------------------------------
		// JeS?f[^擾
		$categoryId = $this->mObject->get('categoryid');
		$categoryHandler =& xoops_getmodulehandler('category');
		$this->mCategoryObject =& $categoryHandler->get($categoryId);

		// JeSo^??
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
		$render->setAttribute('xoops_module_header', $moduleHeader);
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		// G[??
		if ( $this->mConfig['use_mod_rewrite']) {
			$url = './../index.php';
		} else {
			$url = './../../index.php';
		}
//		$controller->executeRedirect($url, 1, _MD_GLOSSARY_ERORR_NOSUBMITTED);
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
