<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH.'/core/XCube_ActionForm.class.php';
//require_once XOOPS_MODULE_PATH.'/legacy/class/Legacy_Validator.class.php';

class Grossary_TagAdminEditForm extends XCube_ActionForm
{

	// --------------------------------------------------------
	// 繧ｳ繝ｳ繧ｹ繝医Λ繧ｯ繧ｿ
	// --------------------------------------------------------

	// --------------------------------------------------------
	// 繝医・繧ｯ繝ｳ蜷阪・亥・蜉帙・繝√こ繝・ヨ・・
	// --------------------------------------------------------
	function getTokenName()
	{
		return 'module.glossary.TagAdminEditForm.TOKEN.' ; //. $this->get('tag');
	}

	// --------------------------------------------------------
	// prepare縲繝｡繧ｽ繝・ラ
	// 繝・・繧ｿ蝙九・逋ｻ骭ｲ縺ｨ蜈･蜉帙メ繧ｧ繝・け
	// --------------------------------------------------------
	function prepare()
	{
		//
		// 繝輔か繝ｼ繝縺ｫ繝励Ο繝代ユ繧｣繧堤匳骭ｲ
		// Set form properties
		//
		// $this->mFormProperties['繧ｨ繝ｬ繝｡繝ｳ繝亥錐'] = new 蝙九↓蜷医ｏ縺帙◆繧ｯ繝ｩ繧ｹ蜷・'繧ｨ繝ｬ繝｡繝ｳ繝亥錐');
		$this->mFormProperties['tag']         = new XCube_StringProperty('tag');
		$this->mFormProperties['new_tag']     = new XCube_StringProperty('new_tag');

		// required   蜈･蜉帛ｿ・・
		$this->mFieldProperties['tag'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['tag']->setDependsByArray(array('required'));
		$this->mFieldProperties['tag']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _AD_GLOSSARY_TAG);

		$this->mFieldProperties['new_tag'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['new_tag']->setDependsByArray(array('required'));
		$this->mFieldProperties['new_tag']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _AD_GLOSSARY_TAG_NEW);

	}


	// 繝・・繧ｿ繧ｪ繝悶ず繧ｧ繧ｯ繝医ｒ繧｢繧ｯ繧ｷ繝ｧ繝ｳ繝輔か繝ｼ繝縺ｸ貂｡縺・
	function load(&$obj)
	{
		// $this->mObject->getShow 縺ｮ繝・・繧ｿ繧偵$this->mActionForm縲縺ｫ莉｣蜈･縺吶ｋ
		// $this->mObject->getShow 縺ｮ繝・・繧ｿ縺ｯ縲∝・蝗槭・DB縺九ｉ縲∝・陦ｨ遉ｺ縺ｯPOST縺輔ｌ縺溘ョ繝ｼ繧ｿ縺九ｉ蜿門ｾ・
		$this->set('tag'      , $obj->get('tag'));
		$this->set('new_tag'  , $obj->get('new_tag'));
		// 譁ｰ隕丞・蜉帙・蝣ｴ蜷・
//'		$this->_mIsNew = $obj->isNew();
//		$this->mOldFileName = $obj->get('rank_image');
//echo  "=== TagAdminEditForm.class.php ===<br />";
//echo $obj->get('tag');
//echo '<br />';
	}


	// POST縺輔ｌ縺溘ョ繝ｼ繧ｿ繧・$this->mObject 縺ｫ莉｣蜈･縺吶ｋ
	function update(&$obj)
	{
		$obj->set('tag'         , $this->get('tag'));
		$obj->set('new_tag'     , $this->get('new_tag'));
	}
}
?>

