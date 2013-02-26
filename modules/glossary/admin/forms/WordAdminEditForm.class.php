<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH.'/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH.'/legacy/class/Legacy_Validator.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/include/functions.php';

class Glossary_WordAdminEditForm extends XCube_ActionForm
{

	// --------------------------------------------------------
	// ト�Eクン名　�E��E力�EチケチE���E�E	// --------------------------------------------------------
	function getTokenName()
	{

		// ト�Eクン吁E		// module. + [ モジュール吁E]+ . + [チE�Eタベ�Eス名] + [管琁E�EはAdminをつける] +  [処琁E + .Form.TOKEN
		return 'module.glossary.WordAdminEdit.Form.TOKEN.' . $this->get('wordid');
	}

	// --------------------------------------------------------
	// prepare　メソチE��
	// チE�Eタ型�E登録と入力チェチE��
	// --------------------------------------------------------
	function prepare()
	{

		// Set form properties
		// フォームのプロパティ�E�データ型式）をセチE��
		
		$this->mFormProperties['wordid']     = new XCube_IntProperty('wordid');
		$this->mFormProperties['categoryid'] = new XCube_IntProperty('categoryid');
		$this->mFormProperties['term']       = new XCube_StringProperty('term');
		$this->mFormProperties['english']    = new XCube_StringProperty('english');
		$this->mFormProperties['proc']       = new XCube_StringProperty('proc');
		$this->mFormProperties['init']       = new XCube_StringProperty('init');
		$this->mFormProperties['description']= new XCube_TextProperty('description');
		$this->mFormProperties['reference']  = new XCube_StringProperty('reference');
		$this->mFormProperties['url']        = new XCube_StringProperty('url');
		$this->mFormProperties['submitter']  = new XCube_IntProperty('submitter');
		$this->mFormProperties['submited']   = new XCube_IntProperty('submited');
		$this->mFormProperties['hits']       = new XCube_IntProperty('hits');
		$this->mFormProperties['block']      = new XCube_IntProperty('block');
		$this->mFormProperties['published']  = new XCube_BoolProperty('published');

		// Set field properties
		// フィールド�EプロパティをセチE���E��E力忁E���E入力条件など�E�E

		// required   入力忁E��E		$this->mFieldProperties['term'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['term']->setDependsByArray(array('required'));
		// 未入力�E時�EエラーメチE��ージ
		$this->mFieldProperties['term']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_WORD_TERM);


		$this->mFieldProperties['categoryid'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['categoryid']->setDependsByArray(array('required'));
		// 未入力�E時�EエラーメチE��ージ
		$this->mFieldProperties['categoryid']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_WORD_TERM);

		$this->mFieldProperties['description'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['description']->setDependsByArray(array('required'));
		$this->mFieldProperties['description']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_WORD_DESCRIPTION);

	}

	// チE�Eブル名�EチェチE��
	function validateTerm()
	{
		if ($this->get('term') != null) {
			$term = trim($this->get('term')) ;
			// 用語�E二重登録のチェチE��
			// Criteria で検索した結果があれ�Eエラー
			$mHandler =& xoops_getmodulehandler('word');
			$mCriteria = new CriteriaCompo();
			$mCriteria->add(new Criteria('term', $this->get('term')));
			if ($this->get('wordid') >0) {
				// wordidがあれ�E、Criteriaの条件にwordidを追加�E�編雁E���E�E				$mCriteria->add(new Criteria('wordid', $this->get('wordid'),'<>'));
			}
			// 設定された条件でSQLを行う
			$tableName =& $mHandler->getObjects($mCriteria, true);
			if ($tableName != null) {
				$this->addErrorMessage(_MD_GLOSSARY_WORD_ERROR_REPEATED);
			}
		}
	}


	// チE�Eタオブジェクトをアクションフォームへ渡ぁE	function load(&$obj)
	{
		//$this->mObject->getShow のチE�Eタを　$this->mActionForm　に代入する
		// $this->mObject->getShow のチE�Eタは、�E回�EDBから、�E表示はPOSTされたデータから取征E		$this->set('wordid'     , $obj->get('wordid'));
		$this->set('categoryid' , $obj->get('categoryid'));
		$this->set('term'       , $obj->get('term'));
		$this->set('english'    , $obj->get('english'));
		$this->set('proc'       , $obj->get('proc'));
		$this->set('init'       , $obj->get('init'));
		$this->set('description', $obj->get('description'));
		$this->set('reference'  , $obj->get('reference'));
		$this->set('url'        , $obj->get('url'));
		$this->set('submitter'  , $obj->get('submitter'));
		$this->set('submited'   , $obj->get('submited'));
		$this->set('hits'       , $obj->get('hits'));
		$this->set('block'      , $obj->get('block'));
		$this->set('published'  , $obj->get('published'));

	}

	// POSTされたデータめE$this->mObject に代入する
	function update(&$obj)
	{
		// 入力した値を加工する忁E���Eある場合�E、ここで処琁E��めE		if ($this->get('english')=="") {
			$english = "";
		} else {
			$english = addSlashes(strip_tags($this->get('english')));
			$english = trim(mb_convert_kana($this->get('english'),"rns"));
		}

		$term = addSlashes(strip_tags($this->get('term')));
		$term = trim(mb_convert_kana($term,"s"));

		$proc = addSlashes(strip_tags($this->get('proc')));
		$proc = trim(mb_convert_kana($proc,"s"));
		// index term
		$init = Glossary_functionGetInitial($term, $proc);

		global $xoopsUser;

		// POSTされたデータめE$this->mObject に代入する

		$obj->set('wordid'     , $this->get('wordid'));
		$obj->set('categoryid' , $this->get('categoryid'));
		$obj->set('term'       , $term);
		$obj->set('english'    , $english);
		$obj->set('proc'       , $proc);
		$obj->set('init'       , $init);
		$obj->set('description', $this->get('description'));
		$obj->set('reference'  , $this->get('reference'));
		$obj->set('url'        , $this->get('url'));
		$obj->set('submitter'  , $xoopsUser->uid());
		$obj->set('submited'   , time());
		$obj->set('hits'       , $this->get('hits'));
		$obj->set('block'      , $this->get('block'));
		$obj->set('published'  , $this->get('published'));

	}
}
?>
