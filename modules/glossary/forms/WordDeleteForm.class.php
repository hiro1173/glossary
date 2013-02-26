<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";

// [ モジュール吁E] + _ + [チE�Eタベ�Eス名] + [管琁E�EはAdminをつける] + [処琁E + Form
//class Glossary_WordAdminDeleteForm extends XCube_ActionForm
class Glossary_WordDeleteForm extends XCube_ActionForm
{
	// ト�Eクン名を取征E	function getTokenName()
	{
		// ト�Eクン吁E		// module. + [ モジュール吁E]+ . + [チE�Eタベ�Eス名] + [管琁E�EはAdminをつける] +  [処琁E + .Form.TOKEN
		//return 'module.glossary.WordAdminDelete.Form.TOKEN.' . $this->get('wordid');
		return 'module.glossary.WordDelete.Form.TOKEN.' . $this->get('wordid');
	}

	function prepare()
	{

		//
		// Set form properties
		//
		// フォームのプロパティをセチE��
		$this->mFormProperties['wordid'] = new XCube_IntProperty('wordid');

		//
		// Set field properties
		// フィールド�EプロパティをセチE��
		$this->mFieldProperties['wordid'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['wordid']->setDependsByArray(array('required'));

		$this->mFieldProperties['wordid']->addMessage('required', _MD_GLOSSARY_ERROR_REQUIRED, _MD_GLOSSARY_WORD_ID);
	}

	function load(&$obj)
	{
		$this->set('wordid', $obj->get('wordid'));
	}

	function update(&$obj)
	{
		$obj->set('wordid', $this->get('wordid'));
	}

}

?>
