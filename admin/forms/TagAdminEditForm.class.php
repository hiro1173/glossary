<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_ROOT_PATH.'/core/XCube_ActionForm.class.php';
//require_once XOOPS_MODULE_PATH.'/legacy/class/Legacy_Validator.class.php';

class Grossary_TagAdminEditForm extends XCube_ActionForm
{

	// --------------------------------------------------------
	// コンストラクタ
	// --------------------------------------------------------

	// --------------------------------------------------------
	// ト�Eクン名　�E��E力�EチケチE���E�E
	// --------------------------------------------------------
	function getTokenName()
	{
		return 'module.glossary.TagAdminEditForm.TOKEN.' ; //. $this->get('tag');
	}

	// --------------------------------------------------------
	// prepare　メソチE��
	// チE�Eタ型�E登録と入力チェチE��
	// --------------------------------------------------------
	function prepare()
	{
		//
		// フォームにプロパティを登録
		// Set form properties
		//
		// $this->mFormProperties['エレメント名'] = new 型に合わせたクラス吁E'エレメント名');
		$this->mFormProperties['tag']         = new XCube_StringProperty('tag');
		$this->mFormProperties['new_tag']     = new XCube_StringProperty('new_tag');

		// required   入力忁E��E
		$this->mFieldProperties['tag'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['tag']->setDependsByArray(array('required'));
		$this->mFieldProperties['tag']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _AD_GLOSSARY_TAG);

		$this->mFieldProperties['new_tag'] = new XCube_FieldProperty($this);
		$this->mFieldProperties['new_tag']->setDependsByArray(array('required'));
		$this->mFieldProperties['new_tag']->addMessage('required', _AD_GLOSSARY_ERROR_REQUIRED, _AD_GLOSSARY_TAG_NEW);

	}


	// チE�Eタオブジェクトをアクションフォームへ渡ぁE
	function load(&$obj)
	{
		// $this->mObject->getShow のチE�Eタを　$this->mActionForm　に代入する
		// $this->mObject->getShow のチE�Eタは、�E回�EDBから、�E表示はPOSTされたデータから取征E
		$this->set('tag'      , $obj->get('tag'));
		$this->set('new_tag'  , $obj->get('new_tag'));
		// 新規�E力�E場吁E
//'		$this->_mIsNew = $obj->isNew();
//		$this->mOldFileName = $obj->get('rank_image');
//echo  "=== TagAdminEditForm.class.php ===<br />";
//echo $obj->get('tag');
//echo '<br />';
	}


	// POSTされたデータめE$this->mObject に代入する
	function update(&$obj)
	{
		$obj->set('tag'         , $this->get('tag'));
		$obj->set('new_tag'     , $this->get('new_tag'));
	}
}
?>

