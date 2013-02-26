<?php

// SQL文へ直接パラメータを渡す為のフィルターフォームクラス

if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . '/glossary/class/AbstractFilterForm.class.php';

define('GLOSSARY_SORT_KEY_TAG', 1);
define('GLOSSARY_SORT_KEY_COUNT', 2);

// デフォルトのソート順を指定
define('GLOSSARY_SORT_KEY_DEFAULT', GLOSSARY_SORT_KEY_TAG);

class Glossary_TagAdminFilterForm extends Glossary_AbstractFilterForm
{
	// SQL へ渡すパラメータ
	var $mSortKeys = array(
		GLOSSARY_SORT_KEY_TAG => 'T.tag',
		GLOSSARY_SORT_KEY_COUNT => 'bCount',
	);

	// デフォルトのソート順
	function getDefaultSortKey()
	{
		return GLOSSARY_SORT_KEY_DEFAULT;
	}
}

?>
