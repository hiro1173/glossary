<?php
/*=====================================================================
  (C)2007 BeaBo Japan by Hiroki Seike
  http://beabo.net/
=====================================================================*/
// --------------------------------------------------------
// 共通
// --------------------------------------------------------
define('_AD_GLOSSARY_ID', "ID");
define('_AD_GLOSSARY_ACTION', "操作");
define('_AD_GLOSSARY_EDIT', "編集");
define('_AD_GLOSSARY_DELETE', "削除");
define('_AD_GLOSSARY_GOMODULES', "モジュール画面へ");

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
define('_AD_GLOSSARY_WORD', "用語");
define('_AD_GLOSSARY_WORD_ID', "用語ID");
define('_AD_GLOSSARY_WORD_ADD', "新しい用語を追加");
define('_AD_GLOSSARY_WORD_LIST', "用語の管理");
define('_AD_GLOSSARY_WORD_LIST_DSC', "現在登録されている用語は、%s&nbsp;語です。<br />用語の追加と管理を行います。新しい用語を追加するには、右側の「新しい用語を追加」ボタンから登録が出来ます。");
define('_AD_GLOSSARY_WORD_EDIT', "用語の編集");
define('_AD_GLOSSARY_WORD_EDIT_DSC', "指定された用語を編集します。用語と本文は入力必須です。");
define('_AD_GLOSSARY_WORD_EDIT_SUCCESS', "編集された用語を保存しました。");
define('_AD_GLOSSARY_WORD_EDIT_ERROR', "用語の編集でエラーが発生しました。編集された内容は、保存できません。");
define('_AD_GLOSSARY_WORD_DELETE', "用語の削除");
define('_AD_GLOSSARY_WORD_DELETE_DSC', "指定された用語を削除します。");
define('_AD_GLOSSARY_WORD_DELETE_CONFIRM', "この用語に関連付けされたタグのデータも同時に削除されます。");
define('_AD_GLOSSARY_WORD_DELETE_SUCCESS', "指定された用語を削除しました。");
define('_AD_GLOSSARY_WORD_DELETE_ERROR', "用語の削除でエラーが発生しました。");

// その他
define('_AD_GLOSSARY_WORD_TERMDESC', "用語と読み");
define('_AD_GLOSSARY_WORD_NOTPUBLISHED', "非公開の用語はありません。");
define('_AD_GLOSSARY_WORD_NOSUBMITTED', "用語は登録されていません。新しい用語を追加するには、右側の「新しい用語を追加」ボタンから登録が出来ます。");

// TODO select category
//define('_AD_GLOSSARY_WORD_LIST_DSC', "現在登録されている用語は、%s&nbsp;語です。<br />カテゴリを指定してカテゴリ別で閲覧出来ます。");
//define('_AD_GLOSSARY_SET_CATEGORY', "カテゴリを指定");

// --------------------------------------------------------
// タグ
// --------------------------------------------------------
define('_AD_GLOSSARY_TAG', "タグ");
define('_AD_GLOSSARY_TAG_LIST', "タグ一覧");
define('_AD_GLOSSARY_TAG_LIST_DSC', "現在利用されているタグの一覧です。登録されているタグの変更と削除が可能です。");
define('_AD_GLOSSARY_TAG_EDIT', "タグの編集");
define('_AD_GLOSSARY_TAG_EDIT_DSC', "指定されたタグの内容を変更します。");
define('_AD_GLOSSARY_TAG_EDIT_CONFIRM', "タグに関連付けされた用語のデータも同時にされ、タグがリネームされます。");
define('_AD_GLOSSARY_TAG_EDIT_ERROR', "タグの編集でエラーが発生しました。保存できません。");
define('_AD_GLOSSARY_TAG_SUCCESS', "タグを保存しました。");
define('_AD_GLOSSARY_TAG_DELETE', "タグの削除");
define('_AD_GLOSSARY_TAG_DELETE_DSC', "指定されたタグを削除します。タグに関連付けされた用語のデータは削除されず、タグのみが削除されます。");
define('_AD_GLOSSARY_TAG_DELETE_CONFIRM', "%s は、%s 件の用語で利用されています。本当にタグの削除を行ってもよいですか？<br />タグの削除を行っても、既存の用語は削除されません。");

define('_AD_GLOSSARY_TAG_DELETE_SUCCESS', "タグを削除しました。");
define('_AD_GLOSSARY_TAG_DELETE_ERROR', "タグの削除でエラーが発生しました。");

// その他
define('_AD_GLOSSARY_TAG_COUNT', "現在登録されているタグは、%s&nbsp;語です。<br />");
define('_AD_GLOSSARY_TAG_COUNTWORD', "登録用語数");
define('_AD_GLOSSARY_TAG_OLD', "現在のタグ");
define('_AD_GLOSSARY_TAG_NEW', "変更するタグ");
define('_AD_GLOSSARY_TAG_NOSUBMITTED', "タグは登録されていません。用語を登録する時にタグを登録する事ができます。");

// --------------------------------------------------------
// カテゴリ
// --------------------------------------------------------
define('_AD_GLOSSARY_CAT', "カテゴリ");
define('_AD_GLOSSARY_CAT_MENU', "カテゴリの管理");
define('_AD_GLOSSARY_CAT_ADD', "新しいカテゴリを追加");
define('_AD_GLOSSARY_CAT_ADD_DSC', "新しいカテゴリを追加します。");
define('_AD_GLOSSARY_CAT_LIST', "カテゴリ一覧");
define('_AD_GLOSSARY_CAT_LiST_DSC', "登録されているカテゴリの一覧です。カテゴリの並び順に表示しています。");
define('_AD_GLOSSARY_CAT_EDIT', "カテゴリの編集");
define('_AD_GLOSSARY_CAT_EDIT_DSC', "指定されたカテゴリを編集します。カテゴリ名は入力必須です。");
define('_AD_GLOSSARY_CAT_EDIT_ERROR', "カテゴリの編集でエラーが発生しました。保存できません。");
define('_AD_GLOSSARY_CAT_ERROR_SAMECAT', "親カテゴリに現在のカテゴリ自身は指定できません。");
define('_AD_GLOSSARY_CAT_SUCCESS', "カテゴリを保存しました。");
define('_AD_GLOSSARY_CAT_DELETE', "カテゴリの削除");
define('_AD_GLOSSARY_CAT_DELETE_DSC', "指定されたカテゴリを削除します。");

define('_AD_GLOSSARY_CAT_DELETE_CONFIRM', "カテゴリを削除してもカテゴリに登録されている用語は、削除されずに残ります。用語も削除したい場合は個別に削除して下さい。"); 
define('_AD_GLOSSARY_CAT_DELETE_CONFIRM2', "このカテゴリの下に<font color='#E00000'> %s のカテゴリ</font>があります。同時に子のカテゴリも削除されるので確認して下さい。<br />カテゴリに登録されている用語は、削除されずに残ります。"); 

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