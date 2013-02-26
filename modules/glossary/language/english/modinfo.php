<?php
/*=====================================================================
  (C)2007 BeaBo Japan by Hiroki Seike
  http://beabo.net/
=====================================================================*/
define('_MI_GLOSSARY_NAME', "Glossary");
define('_MI_GLOSSARY_DESC', "Glossary");
define('_MI_GLOSSARY_BLOCK', 'block');
define('_MI_GLOSSARY_UPDATE', 'update');
define('_MI_GLOSSARY_GOMODULES', 'go module');

// --------------------------------------------------------
// Sub menus in main menu block
// --------------------------------------------------------
define('_MI_GLOSSARY_SUB_SMNAME0', "wordの登録");
define('_MI_GLOSSARY_SUB_SMNAME2', "英字・５０音で探す");
define('_MI_GLOSSARY_SUB_SMNAME', "で探す");

// --------------------------------------------------------
// Names of admin menu items
// --------------------------------------------------------
define('_MI_GLOSSARY_ADMENU1', "Main");
define('_MI_GLOSSARY_ADMENU2', "Words");
define('_MI_GLOSSARY_ADMENU3', "Categories");
define('_MI_GLOSSARY_ADMENU4', "Option");


define('_MI_GLOSSARY_MAIN', "Main");
define('_MI_GLOSSARY_MAIN_DSC', "New word and resnt word list");
define('_MI_GLOSSARY_WORD', "word");
define('_MI_GLOSSARY_WORD_DSC', "I manage it with addition of word.新しいwordを追加するには、右側の「新しいwordを追加」ボタンから登録が出来ます。");
define('_MI_GLOSSARY_TAG', "tags");
define('_MI_GLOSSARY_TAG_DSC', "It is the list of a used tag now. A change and the deletion of a registered tag are possible.");
define('_MI_GLOSSARY_CATEGORY', "category");
define('_MI_GLOSSARY_CATEGORY_DSC', "It is a list of registered category. I display an equal thing of category sequentially.<br /> I can make category only to a child");
define('_MI_GLOSSARY_OPTION', "optino");
define('_MI_GLOSSARY_OPTION_DSC', "Set optino");

// --------------------------------------------------------
//Names of Blocks and Block information
// --------------------------------------------------------
define('_MI_GLOSSARY_ENTRIESNEW', "New Wrods");
define('_MI_GLOSSARY_ENTRIESTOP', "Recent Words");
define('_MI_GLOSSARY_RANDOMTERM', "Random Words");
define('_MI_GLOSSARY_TERMINITIAL', "英字・50音で探す");
define('_MI_GLOSSARY_TAGCLOUD', "tag cloud");
define('_MI_GLOSSARY_BREADCRUMBS', "bread crumbs");

define('_MI_GLOSSARY_TPL_HEADER', "ヘッダー");
define('_MI_GLOSSARY_TPL_VIEW_SEARCH', "検索ブロック");
define('_MI_GLOSSARY_TPL_VIEW_LETTER', "英字・５０音ブロック");
define('_MI_GLOSSARY_TPL_WORD_ITEM', "一覧でのwordの簡略表示");
define('_MI_GLOSSARY_TPL_INDEX', "トップページ");
define('_MI_GLOSSARY_TPL_CATEGORY', "category表示");
define('_MI_GLOSSARY_TPL_LETTERS', "英字・５０音表示");
define('_MI_GLOSSARY_TPL_TAG_VIEW', "Tag list");
define('_MI_GLOSSARY_TPL_TAG_CLOUD', "タグクラウド表示");
define('_MI_GLOSSARY_TPL_SEARCH', "検索結果の表示");
define('_MI_GLOSSARY_TPL_WORD_VIEW', "word個別の内容を表示");
define('_MI_GLOSSARY_TPL_WORD_EDIT', "Edit word");
define('_MI_GLOSSARY_TPL_WORD_DELETE', "Delete word");
define('_MI_GLOSSARY_TPL_CSS', "モジュールのCSSファイル");


// --------------------------------------------------------
// PreferenceEdit
// --------------------------------------------------------
define('_MI_GLOSSARY_USECATEGORY', "Use category");
define('_MI_GLOSSARY_USECATEGORY_DSC', "wordをcategoryで区別します。。");
define('_MI_GLOSSARY_CATSINMENU',"メインメニューに分類（categoryー）を表示");
define('_MI_GLOSSARY_CATSINMENU_DSC',"「はい」を選ぶとメインメニューの中に表示します。");
define('_MI_GLOSSARY_DESCLENGTH', "説明文の一部を表示するときの長さ");
define('_MI_GLOSSARY_DESCLENGTH_DSC', "単語の詳細表示ページ以外では説明文を省略できます。省略時の文字（バイト）数を指定してください。（初期値：100）");
define('_MI_GLOSSARY_RELATED_WORDS', "自動参照リンク機能を使用");
define('_MI_GLOSSARY_RELATED_WORDS_DSC', "説明文の中に「他の見出し語」があったとき、その見出し語のページへ自動的にリンクを張ります。英数はシングルクオート、ダブルクオートでくくってください。日本語は 14. で設定できます。<a href='".XOOPS_URL."/modules/glossary/admin/pluginlist.php' target='_blank'>プラグイン対応状況</a>");
define('_MI_GLOSSARY_RELATED_WORDS0_DSC', "使用しない");
define('_MI_GLOSSARY_RELATED_WORDS1_DSC', "Glossary内を対象にする");
define('_MI_GLOSSARY_RELATED_WORDS2_DSC', "検索モジュールを使ってサイト内を対象する");
define('_MI_GLOSSARY_LINKTERMSPOSI', "作成されたリンクを本文の中に表示");
define('_MI_GLOSSARY_LINKTERMSPOSI_DSC', "「いいえ」を選ぶと本文の下に羅列し、「はい」を選ぶと本文の中、該当語の前にアイコンを表示します。");
define('_MI_GLOSSARY_LINKTERMSTITLE', "自動参照リンクタイトル");
define('_MI_GLOSSARY_LINKTERMSTITLE_DSC', "自動的に作成されたリンクにタイトルをつけます。");
define('_MI_GLOSSARY_LINKTERMSDEFAULT', "関連記事：");
define('_MI_GLOSSARY_BREADCRUMBS', "モジュールにパンくずリストを使用する");
define('_MI_GLOSSARY_BREADCRUMBS_DSC', "「はい」モジュール内にパンくずリストを表示します。「いいえ」にするとパンくずリストを表示しません。");
define('_MI_GLOSSARY_MODREWRITE', 'Use mod_rewrite');
define('_MI_GLOSSARY_MODREWRITE_DSC', 'mod_rewrite を使ってURLの変換を行います。.htaccess の設置が必要です');
define('_MI_GLOSSARY_READMEUSED', "<Top Page>紹介文を表示する");
define('_MI_GLOSSARY_READMEUSED_DSC', "「はい」を選ぶとトップページに紹介文を表示します。");
define('_MI_GLOSSARY_README', "<Top Page>トップページに表示する紹介文");
define('_MI_GLOSSARY_README_DSC', "どんな言葉を収録しているとか。空欄でも結構です。");
define('_MI_GLOSSARY_README_DEF', "当サイトで使用している言葉、関連のある言葉を解説します。");
define('_MI_GLOSSARY_CATEGORYDISP', "<Top Page>categoryの一覧を表示");
define('_MI_GLOSSARY_CATEGORYDISP_DSC', "「はい」トップページにcategoryの一覧表示します「いいえ」にすると、categoryを表示しません。。");
define('_MI_GLOSSARY_SEARCHBLOCK', "<Top Page>フリーワード検索を表示");
define('_MI_GLOSSARY_SEARCHBLOCK_DSC', "「はい」トップページにフリーワード検索を表示します「いいえ」にすると、フリーワード検索を表示しません。。");
define('_MI_GLOSSARY_LETTERDISP', "<Top Page>英字・５０音で探すを表示");
define('_MI_GLOSSARY_LETTERDISP_DSC', "「はい」トップページに英字・５０音で探すを表示します「いいえ」にすると、英字・５０音で探すを表示しません。。");
define('_MI_GLOSSARY_PERPAGEINDEX', "<Page>１ページあたりの表示行数");
define('_MI_GLOSSARY_PERPAGEINDEX_DSC', "指定した語数ごとに改ページします。");
define('_MI_GLOSSARY_BLOCKSPERPAGE', "<Page>表示する新着word・wordランキングの数");
define('_MI_GLOSSARY_BLOCKSPERPAGE_DSC', "ゼロにすると表示しません。初期値：5");
define('_MI_GLOSSARY_USE_FCKEDITOR', 'Use FCK editoe');
define('_MI_GLOSSARY_USE_FCKEDITOR_DSC', '入力にFCKエディタを使う');
define('_MI_GLOSSARY_MULTIBYTES', 'Use multi-byte');
define('_MI_GLOSSARY_MULTIBYTES_DSC', '頭文字のリストに日本語を使う場合は、マルチバイトを使うを「はい」にして下さい。');
define('_MI_GLOSSARY_TAG_TOLOWER', 'タグを小文字で使用する');
define('_MI_GLOSSARY_TAG_TOLOWER_DSC', 'タグのアルファベット部分を すべて小文字にする場合は、マルチバイトを使うを「はい」にして下さい。');


?>