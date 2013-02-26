<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH.'/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH.'/legacy/class/Legacy_Validator.class.php';

class Glossary_WordEditForm extends XCube_ActionForm
{

	function getTokenName()
	{
		return 'module.glossary.WordEditForm.TOKEN.' . $this->get('wordid');
	}

	function prepare()
	{
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

		$this->mFormProperties['tags']        = new XCube_StringProperty('tags');


		$this->mFieldProperties['term'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['term']->setDependsByArray(array('required'));
		$this->mFieldProperties['term']->addMessage('required', _MD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_WORD_TERM);

		$this->mFieldProperties['description'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['description']->setDependsByArray(array('required'));
		$this->mFieldProperties['description']->addMessage('required', _MD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_WORD_DESCRIPTION);
	}



/*
	function validateEnglish()
	{
		if ($this->get('english') != null) {
			$english = trim($this->get('english')) ;
			// 半角英数以外はエラー表示
			if (!preg_match("/^[a-zA-Z0-9_$ ]+$/", $english)) {
				$this->addErrorMessage(_MD_GLOSSARY_WORD_ERROR_ENGLISH);
			}
		}
	}
*/

	function validateTerm()
	{
		if ($this->get('term') != null) {
			// 用語の二重登録のチェック
			$term = trim($this->get('term')) ;
			$mHandler =& xoops_getmodulehandler('word');
			$mCriteria = new CriteriaCompo();
			$mCriteria->add(new Criteria('term', $this->get('term')));
			if ($this->get('wordid') >0) {
				$mCriteria->add(new Criteria('wordid', $this->get('wordid'),'<>'));
			}
			$tableName =& $mHandler->getObjects($mCriteria, true);
			if ($tableName != null) {
				$this->addErrorMessage(_MD_GLOSSARY_WORD_ERROR_REPEATED);
			}
		}
	}


	function load(&$obj)
	{
		$this->set('wordid'     , $obj->get('wordid'));
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

//		$this->set('tags'  , $obj->get('tags'));

	}

	// POSTされたデータめE$this->mObject に代入する
	function update(&$obj)
	{
		$english = addSlashes(strip_tags($this->get('english')));
		$english = trim(mb_convert_kana($this->get('english'),"rns"));

		$term = addSlashes(strip_tags($this->get('term')));
		$term = trim(mb_convert_kana($term,"s"));

		$proc = addSlashes(strip_tags($this->get('proc')));
		$proc = trim(mb_convert_kana($proc,"s"));
		// index term
		$init = Glossary_functionGetInitial($term, $proc);

		$root =& XCube_Root::getSingleton();

		$obj->set('wordid'     , $this->get('wordid'));
		$obj->set('categoryid' , $this->get('categoryid'));
		$obj->set('term'       , $term);
		$obj->set('english'    , $english);
		$obj->set('proc'       , $proc);
		$obj->set('init'       , $init);
		$obj->set('description', $this->get('description'));
		$obj->set('reference'  , $this->get('reference'));
		$obj->set('url'        , $this->get('url'));
		$obj->set('submitter'  , $root->mContext->mXoopsUser->get('uid'));
		$obj->set('submited'   , time());
		$obj->set('hits'       , $this->get('hits'));
		$obj->set('block'      , $this->get('block'));
		$obj->set('published'  , $this->get('published'));

//		$obj->set('tags'  , $this->get('tags'));

	}
}
?>
