<?php

//echo '/glossary/admin/forms/CategoryFilterForm.class.php<br />';

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . '/glossary/class/AbstractFilterForm.class.php';

define('GLOSSARY_SORT_KEY_CATEGORYID', 1);
define('GLOSSARY_SORT_KEY_PARENTID', 2);
define('GLOSSARY_SORT_KEY_NAME', 3);
define('GLOSSARY_SORT_KEY_DESCRIPTION', 4);
define('GLOSSARY_SORT_KEY_WEIGHT', 5);

// デフォルトのソート順を指定
define('GLOSSARY_SORT_KEY_DEFAULT', GLOSSARY_SORT_KEY_WEIGHT);

class Glossary_CategoryFilterForm extends Glossary_AbstractFilterForm
{
	var $mSortKeys = array(
		GLOSSARY_SORT_KEY_CATEGORYID => 'categoryid',
		GLOSSARY_SORT_KEY_PARENTID => 'parentid',
		GLOSSARY_SORT_KEY_NAME => 'name',
		GLOSSARY_SORT_KEY_DESCRIPTION => 'description',
		GLOSSARY_SORT_KEY_WEIGHT => 'weight',
	);

	// デフォルトのソート順
	function getDefaultSortKey()
	{
		return GLOSSARY_SORT_KEY_DEFAULT;
	}

	function fetch()
	{
		parent::fetch();

/*
		// 検索条件の追加
		if (isset($_REQUEST['categoryid'])) {
			$this->mNavi->addExtra('categoryid', xoops_getrequest('categoryid'));
			$this->_mCriteria->add(new Criteria('categoryid', xoops_getrequest('categoryid')));
		}

		if (isset($_REQUEST['parentid'])) {
			$this->mNavi->addExtra('parentid', xoops_getrequest('parentid'));
			$this->_mCriteria->add(new Criteria('parentid', xoops_getrequest('parentid')));
		}

		if (isset($_REQUEST['name'])) {
			$this->mNavi->addExtra('name', xoops_getrequest('name'));
			$this->_mCriteria->add(new Criteria('name', xoops_getrequest('name')));

		}

		if (isset($_REQUEST['description'])) {
			$this->mNavi->addExtra('description', xoops_getrequest('description'));
			$this->_mCriteria->add(new Criteria('description', xoops_getrequest('description')));
		}

		if (isset($_REQUEST['weight'])) {
			$this->mNavi->addExtra('weight', xoops_getrequest('weight'));
			$this->_mCriteria->add(new Criteria('weight', xoops_getrequest('weight')));
		}
*/
		$this->_mCriteria->addSort($this->getSort(), $this->getOrder());


	}
}

?>
