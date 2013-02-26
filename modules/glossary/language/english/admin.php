<?php
/*=====================================================================
  (C)2007 BeaBo Japan by Hiroki Seike
  http://beabo.net/
=====================================================================*/
// --------------------------------------------------------
// 共通
// --------------------------------------------------------
define('_AD_GLOSSARY_ID', "ID");
define('_AD_GLOSSARY_ACTION', "Action");
define('_AD_GLOSSARY_EDIT', "Edit");
define('_AD_GLOSSARY_DELETE', "Delete");
define('_AD_GLOSSARY_GOMODULES', "Go module");

// --------------------------------------------------------
// エラーメッセージ
// --------------------------------------------------------
define('_AD_GLOSSARY_ERORR_NOSUBMITTED', "登録されていません");
define('_AD_GLOSSARY_ERROR_REQUIRED', "{0}は必ず入力して下さい");
define('_AD_GLOSSARY_ERROR_PERMISSION', "アクセス権限がありません。");
define('_AD_GLOSSARY_ERROR_EDIT_FOR_PERMISSION', "編集するアクセス権限がありません。");
define('_AD_GLOSSARY_ERROR_PARAMETER', "パラメータが正しくありません。");
define('_AD_GLOSSARY_ERROR_DELETE_FOR_PERMISSION', "削除するアクセス権限がありません。");

define('_AD_GLOSSARY_ERROR_SMARTYPLUGIN', "FKCエディタのSmartyプラグインが見つかりません。<br />%s/class/smarty/plugins/ へ <b>function.fck_htmlarea.php</b>をインストールして下さい。");

// --------------------------------------------------------
// メイン
// --------------------------------------------------------
define('_AD_GLOSSARY_MAIN', "メイン");
define('_AD_GLOSSARY_MAIN_DSC', "新しく登録された用語と非公開の用語の一覧です。");
define('_AD_GLOSSARY_MAIN_NEWWORDS', "新着用語（最新の１０件）");
define('_AD_GLOSSARY_MAIN_NOTPUBLISHED', "非公開中の用語");
define('_AD_GLOSSARY_MAIN_NOTPUBLISHED_CONFIRM', "<font color='#E00000'>非公開の用語が、%s&nbsp;語あります。</font>");
define('_AD_GLOSSARY_MAIN_NO_NOTPUBLISHED', "非公開中の用語はありません。");
define('_AD_GLOSSARY_MAIN_NOTENTORY_CONFIRM', "Glossaryへようこそ　新しい用語を追加するには、右側の「新しい用語を追加」ボタンから登録が出来ます。<p>一般設定を行ってから、お使いください。</p>
<p>初めて利用される方は、<a href='./../../legacy/admin/index.php?action=Help&amp;dirname=glossary'><img src='../images/icon/help.png'>こちら</a>をお読みください。</p>");


// --------------------------------------------------------
// 用語
// --------------------------------------------------------
define('_AD_GLOSSARY_WORD', "Word");
define('_AD_GLOSSARY_WORD_ID', "Word ID");
define('_AD_GLOSSARY_WORD_ADD', "Add Word");
define('_AD_GLOSSARY_WORD_LIST', "用語の管理");
define('_AD_GLOSSARY_WORD_LIST_DSC', "現在登録されている用語は、%s&nbsp;語です。<br />用語の追加と管理を行います。新しい用語を追加するには、右側の「新しい用語を追加」ボタンから登録が出来ます。");
define('_AD_GLOSSARY_WORD_EDIT', "用語の編集");
define('_AD_GLOSSARY_WORD_EDIT_DSC', "指定された用語を編集します。用語名と本文は入力必須です。");
define('_AD_GLOSSARY_WORD_EDIT_SUCCESS', "用語を保存しました。");
define('_AD_GLOSSARY_WORD_EDIT_ERROR', "用語の編集でエラーが発生しました。保存できません。");
define('_AD_GLOSSARY_WORD_DELETE', "用語の削除");
define('_AD_GLOSSARY_WORD_DELETE_DSC', "指定された用語を削除します。");
define('_AD_GLOSSARY_WORD_DELETE_CONFIRM', "この用語に関連付けされたタグのデータも同時に削除されます。");
define('_AD_GLOSSARY_WORD_DELETE_SUCCESS', "指定された用語を削除しました。");
define('_AD_GLOSSARY_WORD_DELETE_ERROR', "用語の削除でエラーが発生しました。");

// その他
define('_AD_GLOSSARY_WORD_TERMDESC', "Read terms");
define('_AD_GLOSSARY_WORD_NOTPUBLISHED', "There is not the closed term.");
define('_AD_GLOSSARY_WORD_NOSUBMITTED', "The term is not registered. To add a new term; of the right side 'add a new term', and registration is possible from a button.");

// TODO select category
//define('_AD_GLOSSARY_WORD_LIST_DSC', "現在登録されている用語は、%s&nbsp;語です。<br />カテゴリを指定してカテゴリ別で閲覧出来ます。");
//define('_AD_GLOSSARY_SET_CATEGORY', "カテゴリを指定");

// --------------------------------------------------------
// タグ
// --------------------------------------------------------
define('_AD_GLOSSARY_TAG', "Tag");
define('_AD_GLOSSARY_TAG_LIST', "Tag list");
define('_AD_GLOSSARY_TAG_LIST_DSC', "It is the list of a used tag now. A change and the deletion of a registered tag are possible.");
define('_AD_GLOSSARY_TAG_EDIT', "Edit tag");
define('_AD_GLOSSARY_TAG_EDIT_DSC', "I change the contents of an appointed tag.");
define('_AD_GLOSSARY_TAG_EDIT_CONFIRM', "Leave the data of a term connected with a tag at the same time, and a tag is renamed.");
define('_AD_GLOSSARY_TAG_EDIT_ERROR', "An error occurred by the editing of the tag. I cannot save it。");
define('_AD_GLOSSARY_TAG_SUCCESS', "I stored a tag.");
define('_AD_GLOSSARY_TAG_DELETE', "The deletion of the tag");
define('_AD_GLOSSARY_TAG_DELETE_DSC', "I delete an appointed tag. The data of a term connected with a tag are not deleted, and only a tag is deleted.");
define('_AD_GLOSSARY_TAG_DELETE_CONFIRM', "May I delete the tag which I appointed? 　When I delete it, please click a transmission of a message button.");
define('_AD_GLOSSARY_TAG_DELETE_SUCCESS', "Deleted tag");
define('_AD_GLOSSARY_TAG_DELETE_ERROR', "An error occurred by the deletion of the tag.");

// その他
define('_AD_GLOSSARY_TAG_COUNT', "現在登録されているタグは、%s&nbsp;語です。<br />");
define('_AD_GLOSSARY_TAG_COUNTWORD', "登録用語数");
define('_AD_GLOSSARY_TAG_OLD', "現在のタグ");
define('_AD_GLOSSARY_TAG_NEW', "変更するタグ");
define('_AD_GLOSSARY_TAG_NOSUBMITTED', "タグは登録されていません。用語を登録する時にタグを登録する事ができます。");

// --------------------------------------------------------
// カテゴリ
// --------------------------------------------------------
define('_AD_GLOSSARY_CAT', "Categories");
define('_AD_GLOSSARY_CAT_MENU', "Categories");
define('_AD_GLOSSARY_CAT_ADD', "Add category");
define('_AD_GLOSSARY_CAT_LIST', "カテゴリ一覧");
define('_AD_GLOSSARY_CAT_LiST_DSC', "登録されているカテゴリの一覧です。カテゴリの並び順に表示しています。<br />カテゴリは子までしか作成出来ません。");
define('_AD_GLOSSARY_CAT_EDIT', "カテゴリの編集");
define('_AD_GLOSSARY_CAT_EDIT_DSC', "カテゴリを編集します。");
define('_AD_GLOSSARY_CAT_EDIT_ERROR', "カテゴリの編集でエラーが発生しました。保存できません。");
define('_AD_GLOSSARY_CAT_SUCCESS', "カテゴリを保存しました。");
define('_AD_GLOSSARY_CAT_DELETE', "カテゴリの削除");
define('_AD_GLOSSARY_CAT_DELETE_DSC', "指定されたカテゴリを削除します。");
define('_AD_GLOSSARY_CAT_DELETE_CONFIRM', "指定したカテゴリを削除します。カテゴリに子のカテゴリがある場合は、子のカテゴリも削除されます。<br />カテゴリに登録されている用語は、削除されずに残ります。"); 
define('_AD_GLOSSARY_CAT_DELETE_SUCCESS', "カテゴリを削除しました。");
define('_AD_GLOSSARY_CAT_DELETE_ERROR', "カテゴリの削除でエラーが発生しました。");

define('_AD_GLOSSARY_ISPRYMARY', "--------------");
define('_AD_GLOSSARY_CAT_NOSUBMITTED', "カテゴリがありません。新しいカテゴリを追加するには、右側の「新しいカテゴリを追加」ボタンから登録が出来ます。<br />カテゴリを使用しない場合は、一般設定からカテゴリを使用しない設定が可能です。");

// TODO
//define('_AD_GLOSSARY_CAT_DELETE_CONFIRM', "<font color="#E00000"><strong>※注意</strong><br />現在このカテゴリには&nbsp;%s&nbsp;語が登録されています。<br />カテゴリを削除すると同時に削除されます。</font>");






// /admin/admin_option.php
define('_AD_GLOSSARY_OPTION_MSG', "用語の一括置換とCSVファイルを使ったインポート・エクスポートを行います。");
define('_AD_GLOSSARY_DELTED_FILE', "ファイルを削除しました。。");

// インポート　//admin/option_import.php
define('_AD_GLOSSARY_IMPORTED', "データのインポートを完了しました。");

?>