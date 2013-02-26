<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH.'/core/XCube_ActionForm.class.php';
//require_once XOOPS_MODULE_PATH.'/legacy/class/Legacy_Validator.class.php';

class Glossary_CategoryAdminEditForm extends XCube_ActionForm
{
	function Glossary_CategoryEditForm()
	{
		parent::XCube_ActionForm();
	}

	function getTokenName()
	{
		return 'module.glossary.CategoryAdminEditForm.TOKEN.' . $this->get('categoryid');
	}

	function prepare()
	{
		$this->mFormProperties['categoryid'] = new XCube_IntProperty('categoryid');
		$this->mFormProperties['parentid']   = new XCube_IntProperty('parentid');
		$this->mFormProperties['name']       = new XCube_StringProperty('name');
		$this->mFormProperties['description']= new XCube_TextProperty('description');
		$this->mFormProperties['weight']     = new XCube_IntProperty('weight');

	}

	function validateParentid()
	{
//		if (!$this->get->isNew()) {
			if ($this->get('parentid') == $this->get('categoryid')) {
//				$this->addErrorMessage(_AD_GLOSSARY_CAT_ERROR_SAMECAT);
			}
//		}
	}


	function load(&$obj)
	{
		$this->set('parentid'   , $obj->get('parentid'));
		$this->set('name'       , $obj->get('name'));
		$this->set('description', $obj->get('description'));
		$this->set('weight'     , $obj->get('weight'));

	}

	function update(&$obj)
	{
		$obj->set('categoryid' , $this->get('categoryid'));
		$obj->set('parentid'   , $this->get('parentid'));
		$obj->set('name'       , $this->get('name'));
		$obj->set('description', $this->get('description'));
		$obj->set('weight'     , $this->get('weight'));
	}
}
?>
