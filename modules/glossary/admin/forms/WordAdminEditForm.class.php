<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH.'/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH.'/legacy/class/Legacy_Validator.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/include/functions.php';

class Glossary_WordAdminEditForm extends XCube_ActionForm
{

	// --------------------------------------------------------
	// ããEã¯ã³åãEåEåãEãã±ãEEE	// --------------------------------------------------------
	function getTokenName()
	{

		// ããEã¯ã³åE		// module. + [ ã¢ã¸ã¥ã¼ã«åE]+ . + [ãEEã¿ããEã¹å] + [ç®¡çEEã¯Adminãã¤ãã] +  [å¦çE + .Form.TOKEN
		return 'module.glossary.WordAdminEdit.Form.TOKEN.' . $this->get('wordid');
	}

	// --------------------------------------------------------
	// prepareãã¡ã½ãE
	// ãEEã¿åãEç»é²ã¨å¥åãã§ãE¯
	// --------------------------------------------------------
	function prepare()
	{

		// Set form properties
		// ãã©ã¼ã ã®ãã­ããã£Eãã¼ã¿åå¼ï¼ãã»ãE
		
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
		// ãã£ã¼ã«ããEãã­ããã£ãã»ãEEåEåå¿E ãEå¥åæ¡ä»¶ãªã©EE

		// required   å¥åå¿E E		$this->mFieldProperties['term'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['term']->setDependsByArray(array('required'));
		// æªå¥åãEæãEã¨ã©ã¼ã¡ãE»ã¼ã¸
		$this->mFieldProperties['term']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_WORD_TERM);


		$this->mFieldProperties['categoryid'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['categoryid']->setDependsByArray(array('required'));
		// æªå¥åãEæãEã¨ã©ã¼ã¡ãE»ã¼ã¸
		$this->mFieldProperties['categoryid']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_WORD_TERM);

		$this->mFieldProperties['description'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['description']->setDependsByArray(array('required'));
		$this->mFieldProperties['description']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_WORD_DESCRIPTION);

	}

	// ãEEãã«åãEãã§ãE¯
	function validateTerm()
	{
		if ($this->get('term') != null) {
			$term = trim($this->get('term')) ;
			// ç¨èªãEäºéç»é²ã®ãã§ãE¯
			// Criteria ã§æ¤ç´¢ããçµæããããEã¨ã©ã¼
			$mHandler =& xoops_getmodulehandler('word');
			$mCriteria = new CriteriaCompo();
			$mCriteria->add(new Criteria('term', $this->get('term')));
			if ($this->get('wordid') >0) {
				// wordidããããEãCriteriaã®æ¡ä»¶ã«wordidãè¿½å Eç·¨éEEE				$mCriteria->add(new Criteria('wordid', $this->get('wordid'),'<>'));
			}
			// è¨­å®ãããæ¡ä»¶ã§SQLãè¡ã
			$tableName =& $mHandler->getObjects($mCriteria, true);
			if ($tableName != null) {
				$this->addErrorMessage(_MD_GLOSSARY_WORD_ERROR_REPEATED);
			}
		}
	}


	// ãEEã¿ãªãã¸ã§ã¯ããã¢ã¯ã·ã§ã³ãã©ã¼ã ã¸æ¸¡ãE	function load(&$obj)
	{
		//$this->mObject->getShow ã®ãEEã¿ãã$this->mActionFormãã«ä»£å¥ãã
		// $this->mObject->getShow ã®ãEEã¿ã¯ãåEåãEDBãããåEè¡¨ç¤ºã¯POSTããããã¼ã¿ããåå¾E		$this->set('wordid'     , $obj->get('wordid'));
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

	// POSTããããã¼ã¿ãE$this->mObject ã«ä»£å¥ãã
	function update(&$obj)
	{
		// å¥åããå¤ãå å·¥ããå¿E¦ãEããå ´åãEãããã§å¦çEãE		if ($this->get('english')=="") {
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

		// POSTããããã¼ã¿ãE$this->mObject ã«ä»£å¥ãã

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
