<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";

// [ 繝｢繧ｸ繝･繝ｼ繝ｫ蜷・] + _ + [繝・・繧ｿ繝吶・繧ｹ蜷江 + [邂｡逅・・縺ｯAdmin繧偵▽縺代ｋ] + [蜃ｦ逅・ + Form
class Glossary_CategoryAdminDeleteForm extends XCube_ActionForm

{
	// 繝医・繧ｯ繝ｳ蜷阪ｒ蜿門ｾ・	function getTokenName()
	{
		// 繝医・繧ｯ繝ｳ蜷・		// module. + [ 繝｢繧ｸ繝･繝ｼ繝ｫ蜷・]+ . + [繝・・繧ｿ繝吶・繧ｹ蜷江 + [邂｡逅・・縺ｯAdmin繧偵▽縺代ｋ] +  [蜃ｦ逅・ + .Form.TOKEN
		return 'module.glossary.CategoryAdminDelete.Form.TOKEN.' . $this->get('categoryid');
	}

	function prepare()
	{

		//
		// Set form properties
		//
		// 繝輔か繝ｼ繝縺ｮ繝励Ο繝代ユ繧｣繧偵そ繝・ヨ
		$this->mFormProperties['categoryid'] = new XCube_IntProperty('categoryid');

		//
		// Set field properties
		// 繝輔ぅ繝ｼ繝ｫ繝峨・繝励Ο繝代ユ繧｣繧偵そ繝・ヨ
		$this->mFieldProperties['categoryid'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['categoryid']->setDependsByArray(array('required'));

		$this->mFieldProperties['categoryid']->addMessage('required', _MD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_CATEGORYID);
	}

	function load(&$obj)
	{
		$this->set('categoryid', $obj->get('categoryid'));
	}

	function update(&$obj)
	{
		$obj->set('categoryid', $this->get('categoryid'));
	}

}

?>
