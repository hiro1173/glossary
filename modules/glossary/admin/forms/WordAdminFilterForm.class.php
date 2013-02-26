<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . '/glossary/class/AbstractFilterForm.class.php';

// 並び順の定義
define('GLOSSARY_SORT_KEY_WORD_ID', 1);
define('GLOSSARY_SORT_KEY_CATEGORY_ID', 2);
define('GLOSSARY_SORT_KEY_WORD_INIT', 3);
define('GLOSSARY_SORT_KEY_WORD_NAME', 4);
define('GLOSSARY_SORT_KEY_WORD_DESCRIPTION', 5);
define('GLOSSARY_SORT_KEY_WORD_HITS', 6);
define('GLOSSARY_SORT_KEY_WORD_SUBMITED', 7);

// デフォルトの並び順
// -を付けるとDESC（降順）になる。
define('GLOSSARY_SORT_KEY_DEFAULT', '-'.GLOSSARY_SORT_KEY_WORD_ID);

class Glossary_WordAdminFilterForm extends Glossary_AbstractFilterForm
{

	// 並び順のSQLで指定するフィールド名
	var $mSortKeys = array(
		GLOSSARY_SORT_KEY_WORD_ID          => 'w.wordid',
		GLOSSARY_SORT_KEY_CATEGORY_ID      => 'c.categoryid',
		GLOSSARY_SORT_KEY_WORD_INIT        => 'w.init',
		GLOSSARY_SORT_KEY_WORD_NAME        => 'w.term',
		GLOSSARY_SORT_KEY_WORD_DESCRIPTION => 'w.description',
		GLOSSARY_SORT_KEY_WORD_HITS        => 'w.hits',
		GLOSSARY_SORT_KEY_WORD_SUBMITED    => 'w.submited',
	);

	// デフォルトの並び順を取得する
	function getDefaultSortKey()
	{
		return GLOSSARY_SORT_KEY_DEFAULT;
	}
}

?>
