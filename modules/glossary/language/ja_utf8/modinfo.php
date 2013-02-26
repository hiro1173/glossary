<?php
/*=====================================================================
  (C)2007 BeaBo Japan by Hiroki Seike
  http://beabo.net/
=====================================================================*/
// モジュールの定数は、30文字までです。それ以上の場合は表示されません。


define('_MI_GLOSSARY_NAME', "Glossary");
define('_MI_GLOSSARY_DESC', "用語辞典ツール");
define('_MI_GLOSSARY_BLOCK', 'ブロック管理');
define('_MI_GLOSSARY_UPDATE', 'アップデート');
define('_MI_GLOSSARY_GOMODULES', 'モジュール画面へ ');

// --------------------------------------------------------
// Sub menus in main menu block
// --------------------------------------------------------
define('_MI_GLOSSARY_SUB_SMNAME0', "用語の登録");
define('_MI_GLOSSARY_SUB_SMNAME1', "検索");
define('_MI_GLOSSARY_SUB_SMNAME2', "英字・５０音で探す");
define('_MI_GLOSSARY_SUB_SMNAME', "で探す");

// --------------------------------------------------------
// Admin menu
// --------------------------------------------------------
define('_MI_GLOSSARY_ADMENU1', "メイン");
define('_MI_GLOSSARY_ADMENU2', "用語");
define('_MI_GLOSSARY_ADMENU3', "カテゴリ");
define('_MI_GLOSSARY_ADMENU4', "オプション");


define('_MI_GLOSSARY_MAIN', "メイン");
define('_MI_GLOSSARY_MAIN_DSC', "新しく登録された用語と非公開の用語の一覧です。");
define('_MI_GLOSSARY_WORD', "用語");
define('_MI_GLOSSARY_WORD_DSC', "用語の追加と管理を行います。新しい用語を追加するには、右側の「新しい用語を追加」ボタンから登録が出来ます。");
define('_MI_GLOSSARY_TAG', "タグ");
define('_MI_GLOSSARY_TAG_DSC', "現在利用されているタグの一覧です。登録されているタグの変更と削除が可能です。");
define('_MI_GLOSSARY_CATEGORY', "カテゴリ");
define('_MI_GLOSSARY_CATEGORY_DSC', "登録されているカテゴリの一覧です。カテゴリの並び順に表示しています。");
define('_MI_GLOSSARY_OPTION', "オプション");
define('_MI_GLOSSARY_OPTION_DSC', "オプションの設定を行います");

// --------------------------------------------------------
// Blocks and Block information
// --------------------------------------------------------
define('_MI_GLOSSARY_ENTRIESNEW', "新着ブロック");
define('_MI_GLOSSARY_ENTRIESTOP', "人気ブロック");
define('_MI_GLOSSARY_RANDOMTERM', "ランダムブロック");
define('_MI_GLOSSARY_TERMINITIAL', "英字・50音で探す");
define('_MI_GLOSSARY_TAGCLOUD', "タグクラウド");
//define('_MI_GLOSSARY_BREADCRUMBS', "モジュール内パンくずリスト");

// --------------------------------------------------------
//　Template Names
// --------------------------------------------------------
define('_MI_GLOSSARY_TPL_HEADER', "ヘッダー");
define('_MI_GLOSSARY_TPL_VIEW_SEARCH', "検索ブロック");
define('_MI_GLOSSARY_TPL_VIEW_LETTER', "英字・５０音ブロック");
define('_MI_GLOSSARY_TPL_WORD_ITEM', "一覧での用語の簡略表示");
define('_MI_GLOSSARY_TPL_INDEX', "トップページ");
define('_MI_GLOSSARY_TPL_CATEGORY', "カテゴリ表示");
define('_MI_GLOSSARY_TPL_LETTERS', "英字・５０音表示");
define('_MI_GLOSSARY_TPL_TAG_VIEW', "タグ表示");
define('_MI_GLOSSARY_TPL_TAG_CLOUD', "タグクラウド表示");
define('_MI_GLOSSARY_TPL_SEARCH', "検索");
define('_MI_GLOSSARY_TPL_SEARCHRESULTS', "検索結果の表示");
define('_MI_GLOSSARY_TPL_WORD_VIEW', "用語個別の内容を表示");
define('_MI_GLOSSARY_TPL_WORD_EDIT', "用語の編集");
define('_MI_GLOSSARY_TPL_WORD_DELETE', "用語の削除");
define('_MI_GLOSSARY_TPL_CSS', "モジュールのCSSファイル");

define('_MI_GLOSSARY_TPL_RSS20', "RSS表示");


// --------------------------------------------------------
// Preference
// --------------------------------------------------------
define('_MI_GLOSSARY_USECATEGORY', "【利用方法】カテゴリを有効にする");
define('_MI_GLOSSARY_USECATEGORY_DSC', "用語をカテゴリで区別します。。");
define('_MI_GLOSSARY_CATSINMENU',"【メニュー表示】メインメニューに分類（カテゴリー）を表示");
define('_MI_GLOSSARY_CATSINMENU_DSC',"「はい」を選ぶとメインメニューの中に表示します。");
define('_MI_GLOSSARY_DESCLENGTH', "【表示方法】説明文の一部を表示するときの長さ");
define('_MI_GLOSSARY_DESCLENGTH_DSC', "単語の詳細表示ページ以外では説明文を省略できます。省略時の文字（バイト）数を指定してください。（初期値：100）");
define('_MI_GLOSSARY_RELATED_WORDS', "【表示方法】自動参照リンク機能を使用");
define('_MI_GLOSSARY_RELATED_WORDS_DSC', "説明文の中に「他の見出し語」があったとき、その見出し語のページへ自動的にリンクを張ります。英数はシングルクオート、ダブルクオートでくくってください。日本語は 14. で設定できます。※<a href='".XOOPS_URL."/modules/glossary/admin/pluginlist.php' target='_blank'>プラグイン対応状況</a>");
define('_MI_GLOSSARY_RELATED_WORDS0_DSC', "使用しない");
define('_MI_GLOSSARY_RELATED_WORDS1_DSC', "Glossary内を対象にする");
define('_MI_GLOSSARY_RELATED_WORDS2_DSC', "検索モジュールを使ってサイト内を対象する");
define('_MI_GLOSSARY_LINKTERMSPOSI', "【表示方法】作成されたリンクを本文の中に表示");
define('_MI_GLOSSARY_LINKTERMSPOSI_DSC', "「いいえ」を選ぶと本文の下に羅列し、「はい」を選ぶと本文の中、該当語の前にアイコンを表示します。");
define('_MI_GLOSSARY_LINKTERMSTITLE', "【表示方法】自動参照リンクタイトル");
define('_MI_GLOSSARY_LINKTERMSTITLE_DSC', "自動的に作成されたリンクにタイトルをつけます。");
define('_MI_GLOSSARY_LINKTERMSDEFAULT', "関連記事：");
define('_MI_GLOSSARY_BREADCRUMBS', "【表示方法】モジュールにパンくずリストを使用する");
define('_MI_GLOSSARY_BREADCRUMBS_DSC', "「はい」モジュール内にパンくずリストを表示します。「いいえ」にするとパンくずリストを表示しません。");
define('_MI_GLOSSARY_MODREWRITE', '【表示方法】mod_rewrite を使う');
define('_MI_GLOSSARY_MODREWRITE_DSC', 'mod_rewrite を使ってURLの変換を行います。<br />
※利用する場合は、.htaccess の設置が必要です<br />
※設置するサーバでmod_rewriteが利用可能かを確認下さい。<br />
モジュール内: /modules/glossary/.htaccess の設置が必要です<br />
modulesなし: modulesを出力しません。<br />
設置URLのルートへ.htaccess と/modules/glossary/.htaccessの設置が必要です

');
define('_MI_GLOSSARY_MODREWRITE_0', '使用しない');
define('_MI_GLOSSARY_MODREWRITE_1', '使用する');

define('_MI_GLOSSARY_READMEUSED', "【トップページ】紹介文を表示する");
define('_MI_GLOSSARY_READMEUSED_DSC', "「はい」を選ぶとトップページに紹介文を表示します。");
define('_MI_GLOSSARY_README', "【トップページ】トップページに表示する紹介文");
define('_MI_GLOSSARY_README_DSC', "どんな言葉を収録しているとか。空欄でも結構です。");
define('_MI_GLOSSARY_README_DEF', "当サイトで使用している言葉、関連のある言葉を解説します。");
define('_MI_GLOSSARY_CATEGORYDISP', "【トップページ】カテゴリの一覧を表示");
define('_MI_GLOSSARY_CATEGORYDISP_DSC', "「はい」トップページにカテゴリの一覧表示します「いいえ」にすると、カテゴリを表示しません。。");
define('_MI_GLOSSARY_SEARCHBLOCK', "【トップページ】フリーワード検索を表示");
define('_MI_GLOSSARY_SEARCHBLOCK_DSC', "「はい」トップページにフリーワード検索を表示します「いいえ」にすると、フリーワード検索を表示しません。。");
define('_MI_GLOSSARY_LETTERDISP', "【トップページ】英字・５０音で探すを表示");
define('_MI_GLOSSARY_LETTERDISP_DSC', "「はい」トップページに英字・５０音で探すを表示します「いいえ」にすると、英字・５０音で探すを表示しません。。");
define('_MI_GLOSSARY_PERPAGEINDEX', "【ページ】１ページあたりの表示行数");
define('_MI_GLOSSARY_PERPAGEINDEX_DSC', "指定した語数ごとに改ページします。");
define('_MI_GLOSSARY_BLOCKSPERPAGE', "【ページ】表示する新着用語・用語ランキングの数");
define('_MI_GLOSSARY_BLOCKSPERPAGE_DSC', "ゼロにすると表示しません。初期値：5");
define('_MI_GLOSSARY_USE_FCKEDITOR', '【入力方法】FCKエディタを使う');
define('_MI_GLOSSARY_USE_FCKEDITOR_DSC', '入力にFCKエディタを使う');
define('_MI_GLOSSARY_MULTIBYTES', '【入力方法】マルチバイトで使用する');
define('_MI_GLOSSARY_MULTIBYTES_DSC', '頭文字のリストに日本語を使う場合は、マルチバイトを使うを「はい」にして下さい。');
define('_MI_GLOSSARY_TAG_TOLOWER', '【表示方法】タグを小文字で使用する');
define('_MI_GLOSSARY_TAG_TOLOWER_DSC', 'タグのアルファベット部分を すべて小文字にする場合は、マルチバイトを使うを「はい」にして下さい。');

?>