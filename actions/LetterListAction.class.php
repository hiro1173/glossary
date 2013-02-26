<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH. '/glossary/class/AbstractListAction.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/include/functions.php';

class Glossary_LetterListAction extends Glossary_AbstractListAction
{
	var $mConfig           = array();
	var $categoryItem      = array();
	var $categoryItemArray = array();
	var $blockWord         = array();
	var $blockWordArray    = array();
	var $hitWord           = array();
	var $letterArray       = array();
	var $newWord           = array();
	var $newWordArray      = array();
	var $newWordsBlockUsed = false ;
	var $mPagenavi         = null;
	var $totalCount        = null;
	var $grossaryUrl       = null;
	var $firstletter       = null;


	function _getId()
	{
		return xoops_getrequest('init');
	}

	function _getWord()
	{
		return xoops_getrequest('word');
	}
	
	function _getStart()
	{
		return xoops_getrequest('start');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('word');
		return $handler;
	}

	function _getBaseUrl()
	{
		return 'index.php?action=LetterList';
	}

	function &_getPageNavi()
	{
		
		$navi =& parent::_getPageNavi();
		$navi->setPerpage('2');
//		$navi->setPerpage($this->mConfig['perpage']);                        // 1ページ表示数 (xoopsModuleConfig から呼び出し)
		$navi->setTotalItems($this->totalCount);                             // 合計数
		$navi->addExtra('init',  $this->_getId());
		return $navi;
	}

	function prepare(&$controller, &$xoopsUser, $moduleConfig)
	{
//		parent::prepare(&$controller, $xoopsUser, $moduleConfig);
		$this->mConfig = $moduleConfig;
	}

	function getDefaultView(&$controller, &$xoopsUser)
	{
		$root =& XCube_Root::getSingleton();
		$db =& $root->mController->mDB;
		$textFilter =& $root->getTextFilter();    // テキストフィルター
		// タグ用ハンドラ
		$tagHandler =& xoops_getmodulehandler('tag');

		// POST data
		$initStr    = $this->_getId();
		$startEntry = $this->_getStart() ;

		// moduleConfig
		$configUseModRewrite = $this->mConfig['use_mod_rewrite'];
		$configNewWordsUse = $this->mConfig['newwordsuse'];
		$configDesrLength     = $this->mConfig['desrlength'];    // Number of the indication description
		$configPerPage       = $this->mConfig['perpage'];

		// XoopsConfig
		$language = $root->mContext->getXoopsConfig('language');

		if (!isset($initStr)) {
			$initStr    =  mb_convert_encoding(htmlspecialchars(urldecode($this->_getWord()), ENT_QUOTES) ,'UTF-8','auto');
		}
		// binary word list
		if (preg_match('/^[a-z]+$/', $initStr)){
			include (XOOPS_MODULE_PATH . '/glossary/language/'. $language .'/letter_japanese.php');
		} elseif (preg_match ('/^[0-9]+$/', $initStr)) {
			include (XOOPS_MODULE_PATH . '/glossary/language/'. $language .'/letter_number.php');
		} else {
			include (XOOPS_MODULE_PATH . '/glossary/language/'. $language .'/letter.php');
		}
		// binary chraccter
		for ($i=0; $i < count($mb_init); $i++) {
			if ($initStr == $mb_id[$i]) {
				$initStr = $mb_init[$i];
				$this->firstletter = $mb_linktext[$i];
				break;
			}
		}

		// --------------------------------------------------------
		// Bread Crubs 
		// --------------------------------------------------------
		if (isset($this->firstletter) ) {
			$breadName = $this->firstletter;
		} else {
			$breadName = _MD_GLOSSARY_LETTERS ;
		}
		$this->breadcrumbs[] = array('name' => $root->mContext->mModule->mXoopsModule->getVar('name') , 'url' => XOOPS_MODULE_URL. '/glossary/' ) ;
		$this->breadcrumbs[] = array('name' => $breadName )  ;

		// $mObjects->get('note') は生の値

		// --------------------------------------------------------
		// Serch Letter's Word
		// $initStr is serach binary
		// --------------------------------------------------------
		if ($initStr) {
			
			$sql = "SELECT w.wordid, w.categoryid ,term, proc, w.description, c.name  FROM ". $db -> prefix("glossary_word")." w ".
				"LEFT JOIN ". $db -> prefix("glossary_category")." c ON w.categoryid = c.categoryid ".
				" WHERE init REGEXP BINARY '". $initStr. "' AND published > 0 ORDER BY proc ASC ,c.weight ASC";
			$result = $db -> query($sql);
			$this->totalCount = $db -> getRowsNum($result);
			$itemArray = $wordItemArray = array();
			if ($this->totalCount > 0) {
				$result = $db -> query($sql, $configPerPage, $startEntry );
				while (list($wordId, $categoryId, $term, $proc, $wordDesc, $categoryName) = $db -> fetchRow($result)) {
					$categoryUrl = Glossary_functionGetCategoryUrl( $configUseModRewrite, $categoryId, $categoryName ) ;
					
					$wordUrl     = Glossary_functionGetWordUrl( $configUseModRewrite, intval($wordId), addSlashes($term), addSlashes($categoryName) );
					$wordDesc    = $textFilter->toShowTarea($wordDesc, $html=1, $smiley=1, $xcode=0, $image=1, $br=1,false);
					//$wordDesc    =  htmlspecialchars($wordDesc,ENT_QUOTES);
					// javascript 除去
					$wordDesc    =  preg_replace('!<script.*?>.*?</script.*?>!is', '', $wordDesc);
					// HTML tag 除去
					$wordDesc    = strip_tags($wordDesc);
					// $wordDesc    = strip_tags($wordDesc, 'script');
					if ( !XOOPS_USE_MULTIBYTES ) {
						$wordDesc = substr ( $wordDesc, 0, $configDesrLength -1 ) . "...";
					} else {
						$wordDesc = xoops_substr( $wordDesc, 0, $configDesrLength +2 );
					}
					// タグクラウドの単語のリスト取り出し
					$wordTagArray = $tagHandler->getEntoryTagArray($wordId);
					// オブジェクトを分解して、タグのHTMLを作成する
					$tagLinks ='';
					foreach ($wordTagArray as $key => $val) {
						$tagLinkUrl = Glossary_functionGetTagUrl( $configUseModRewrite, $val );
						$tagLinks .= '<a href="'. $tagLinkUrl .'">'.$val. '</a>';
					}
					$wordItemArray = array(
						'term'          => addSlashes($term),
						'proc'          => addSlashes($proc),
						'word_desc'     => $wordDesc,
						'category'      => addSlashes($categoryName),
						'linkWordUrl'   => $wordUrl,
						'category_link' => $categoryUrl,
						'tags'          => $tagLinks,
					);
					array_push($this->letterArray, $wordItemArray );
				}
			}
		}

		if ($this->totalCount > $configPerPage ) {
		// Page Navi
		$this->mPagenavi =$this->_getPageNavi();
		$this->mPagenavi->fetch();
		}

		return GLOSSARY_FRAME_VIEW_INDEX;
	}



	function executeViewIndex(&$controller, &$xoopsUser, &$render)
	{
		$render->setTemplateName('glossary_letters.html');

		// mod rewrite設定

		// --------------------------------------------------------
		// breadcrumbs
		// --------------------------------------------------------
		$render->setAttribute('xoops_breadcrumbs' , $this->breadcrumbs) ;
		$render->setAttribute('config'  , $this->mConfig);
		// --------------------------------------------------------
		// Letter block
		// --------------------------------------------------------
		$render->setAttribute('alpha'    , Glossary_functionAlphaArray(0) );    // Alphabet
		$render->setAttribute('japanese' , Glossary_functionAlphaArray(1) );    // Japanese
		$render->setAttribute('number'   , Glossary_functionAlphaArray(2) );    // Number

		// --------------------------------------------------------
		// words block
		// --------------------------------------------------------
		$render->setAttribute('first_letter'  , $this->firstletter);
		$render->setAttribute('blolck_word'  , $this->blockWordArray);
		$render->setAttribute('categories'   , $this->categoryItemArray);
		$render->setAttribute('category_word', $this->letterArray);

		$render->setAttribute('pageNavi', $this->mPagenavi);

		// --------------------------------------------------------
		// Module Header
		// --------------------------------------------------------
		$moduleHeader = '<link rel="stylesheet" type="text/css" href="' . XOOPS_MODULE_URL. '/glossary/module.css" />'."\n";
		$render->setAttribute('xoops_module_header',$moduleHeader);
	}

}
?>