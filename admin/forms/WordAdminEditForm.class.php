<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH.'/core/XCube_ActionForm.class.php';
require_once XOOPS_MODULE_PATH.'/legacy/class/Legacy_Validator.class.php';
require_once XOOPS_MODULE_PATH. '/glossary/include/functions.php';

class Glossary_WordAdminEditForm extends XCube_ActionForm
{

	// --------------------------------------------------------
	// 繝医・繧ｯ繝ｳ蜷阪・亥・蜉帙・繝√こ繝・ヨ・・	// --------------------------------------------------------
	function getTokenName()
	{

		// 繝医・繧ｯ繝ｳ蜷・		// module. + [ 繝｢繧ｸ繝･繝ｼ繝ｫ蜷・]+ . + [繝・・繧ｿ繝吶・繧ｹ蜷江 + [邂｡逅・・縺ｯAdmin繧偵▽縺代ｋ] +  [蜃ｦ逅・ + .Form.TOKEN
		return 'module.glossary.WordAdminEdit.Form.TOKEN.' . $this->get('wordid');
	}

	// --------------------------------------------------------
	// prepare縲繝｡繧ｽ繝・ラ
	// 繝・・繧ｿ蝙九・逋ｻ骭ｲ縺ｨ蜈･蜉帙メ繧ｧ繝・け
	// --------------------------------------------------------
	function prepare()
	{

		// Set form properties
		// 繝輔か繝ｼ繝縺ｮ繝励Ο繝代ユ繧｣・医ョ繝ｼ繧ｿ蝙句ｼ擾ｼ峨ｒ繧ｻ繝・ヨ
		
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
		// 繝輔ぅ繝ｼ繝ｫ繝峨・繝励Ο繝代ユ繧｣繧偵そ繝・ヨ・亥・蜉帛ｿ・医・蜈･蜉帶擅莉ｶ縺ｪ縺ｩ・・

		// required   蜈･蜉帛ｿ・・		$this->mFieldProperties['term'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['term']->setDependsByArray(array('required'));
		// 譛ｪ蜈･蜉帙・譎ゅ・繧ｨ繝ｩ繝ｼ繝｡繝・そ繝ｼ繧ｸ
		$this->mFieldProperties['term']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_WORD_TERM);


		$this->mFieldProperties['categoryid'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['categoryid']->setDependsByArray(array('required'));
		// 譛ｪ蜈･蜉帙・譎ゅ・繧ｨ繝ｩ繝ｼ繝｡繝・そ繝ｼ繧ｸ
		$this->mFieldProperties['categoryid']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_WORD_TERM);

		$this->mFieldProperties['description'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['description']->setDependsByArray(array('required'));
		$this->mFieldProperties['description']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_WORD_DESCRIPTION);

	}

	// 繝・・繝悶Ν蜷阪・繝√ぉ繝・け
	function validateTerm()
	{
		if ($this->get('term') != null) {
			$term = trim($this->get('term')) ;
			// 逕ｨ隱槭・莠碁㍾逋ｻ骭ｲ縺ｮ繝√ぉ繝・け
			// Criteria 縺ｧ讀懃ｴ｢縺励◆邨先棡縺後≠繧後・繧ｨ繝ｩ繝ｼ
			$mHandler =& xoops_getmodulehandler('word');
			$mCriteria = new CriteriaCompo();
			$mCriteria->add(new Criteria('term', $this->get('term')));
			if ($this->get('wordid') >0) {
				// wordid縺後≠繧後・縲，riteria縺ｮ譚｡莉ｶ縺ｫwordid繧定ｿｽ蜉・育ｷｨ髮・凾・・				$mCriteria->add(new Criteria('wordid', $this->get('wordid'),'<>'));
			}
			// 險ｭ螳壹＆繧後◆譚｡莉ｶ縺ｧSQL繧定｡後≧
			$tableName =& $mHandler->getObjects($mCriteria, true);
			if ($tableName != null) {
				$this->addErrorMessage(_MD_GLOSSARY_WORD_ERROR_REPEATED);
			}
		}
	}


	// 繝・・繧ｿ繧ｪ繝悶ず繧ｧ繧ｯ繝医ｒ繧｢繧ｯ繧ｷ繝ｧ繝ｳ繝輔か繝ｼ繝縺ｸ貂｡縺・	function load(&$obj)
	{
		//$this->mObject->getShow 縺ｮ繝・・繧ｿ繧偵$this->mActionForm縲縺ｫ莉｣蜈･縺吶ｋ
		// $this->mObject->getShow 縺ｮ繝・・繧ｿ縺ｯ縲∝・蝗槭・DB縺九ｉ縲∝・陦ｨ遉ｺ縺ｯPOST縺輔ｌ縺溘ョ繝ｼ繧ｿ縺九ｉ蜿門ｾ・		$this->set('wordid'     , $obj->get('wordid'));
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

	// POST縺輔ｌ縺溘ョ繝ｼ繧ｿ繧・$this->mObject 縺ｫ莉｣蜈･縺吶ｋ
	function update(&$obj)
	{
		// 蜈･蜉帙＠縺溷､繧貞刈蟾･縺吶ｋ蠢・ｦ√・縺ゅｋ蝣ｴ蜷医・縲√％縺薙〒蜃ｦ逅・☆繧・		if ($this->get('english')=="") {
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

		// POST縺輔ｌ縺溘ョ繝ｼ繧ｿ繧・$this->mObject 縺ｫ莉｣蜈･縺吶ｋ

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
