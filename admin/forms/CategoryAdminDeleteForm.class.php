<?php

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH . "/core/XCube_ActionForm.class.php";

// [ モジュール吁E] + _ + [チE�Eタベ�Eス名] + [管琁E�EはAdminをつける] + [処琁E + Form
class Glossary_CategoryAdminDeleteForm extends XCube_ActionForm

{
	// ト�Eクン名を取征E	function getTokenName()
	{
		// ト�Eクン吁E		// module. + [ モジュール吁E]+ . + [チE�Eタベ�Eス名] + [管琁E�EはAdminをつける] +  [処琁E + .Form.TOKEN
		return 'module.glossary.CategoryAdminDelete.Form.TOKEN.' . $this->get('categoryid');
	}

	function prepare()
	{

		//
		// Set form properties
		//
		// フォームのプロパティをセチE��
		$this->mFormProperties['categoryid'] = new XCube_IntProperty('categoryid');

		//
		// Set field properties
		// フィールド�EプロパティをセチE��
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
