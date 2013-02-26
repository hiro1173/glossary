<?php
/*=====================================================================
  (C)2007 BeaBo Japan by Hiroki Seike
  http://beabo.net/
=====================================================================*/
if (!defined('XOOPS_ROOT_PATH')) exit();

//require_once XOOPS_MODULE_PATH . '/contact/forms/DeleteForm.class.php';
require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";


// [ 繝｢繧ｸ繝･繝ｼ繝ｫ蜷・] + _ + [繝・・繧ｿ繝吶・繧ｹ蜷江 + [邂｡逅・・縺ｯAdmin繧偵▽縺代ｋ] + [蜃ｦ逅・ + Form
class Glossary_WordAdminDeleteForm extends XCube_ActionForm
{
	// 繝医・繧ｯ繝ｳ蜷阪ｒ蜿門ｾ・	function getTokenName()
	{
		// 繝医・繧ｯ繝ｳ蜷・		// module. + [ 繝｢繧ｸ繝･繝ｼ繝ｫ蜷・]+ . + [繝・・繧ｿ繝吶・繧ｹ蜷江 + [邂｡逅・・縺ｯAdmin繧偵▽縺代ｋ] +  [蜃ｦ逅・ + .Form.TOKEN
		return 'module.glossary.WordAdminDelete.Form.TOKEN.' . $this->get('wordid');
	}

	function prepare()
	{
		// Set form properties
		// 繝輔か繝ｼ繝縺ｮ繝励Ο繝代ユ繧｣繧偵そ繝・ヨ
		$this->mFormProperties['wordid'] = new XCube_IntProperty('wordid');

		// Set field properties
		// 繝輔ぅ繝ｼ繝ｫ繝峨・繝励Ο繝代ユ繧｣繧偵そ繝・ヨ
		$this->mFieldProperties['wordid'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['wordid']->setDependsByArray(array('required'));
		$this->mFieldProperties['wordid']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _AD_GLOSSARY_WORD_ID);
	}

	function load(&$obj)
	{
		$this->set('wordid', $obj->get('wordid'));
	}

	function update(&$obj)
	{
		$obj->setVar('wordid', $this->get('wordid'));
	}
}

?>
