<?php

define("_MI_GLOSSARY_NAME", "Glossary Plus");
define("_MI_GLOSSARY_DESC", "用語辞典ツール");
define('_MI_GLOSSARY_BLOCK', 'ブロック管理');
define('_MI_GLOSSARY_UPDATE', 'アップデート');
define('_MI_GLOSSARY_GOMODULES', 'モジュール画面へ ');

// Sub menus in main menu block
define("_MI_GLOSSARY_SUB_SMNAME0", "用語の登録");
define("_MI_GLOSSARY_SUB_SMNAME1", "フリーワード検索");
define("_MI_GLOSSARY_SUB_SMNAME2", "英字・５０音で探す");
define("_MI_GLOSSARY_SUB_SMNAME", "で探す");



define("_MI_GLOSSARY_COMMENTARY", "解説");
define("_MI_GLOSSARY_COMMENTARYEDSC", "トップページに表示する用語集の解説");


// Names of admin menu items
define("_MI_GLOSSARY_ADMENU1", "メイン");
define("_MI_GLOSSARY_ADMENU2", "用語");
define("_MI_GLOSSARY_ADMENU3", "カテゴリ");
define("_MI_GLOSSARY_ADMENU4", "オプション");
define("_MI_GLOSSARY_ADMENU5", "テスト");


//Names of Blocks and Block information
define("_MI_GLOSSARY_ENTRIESNEW", "新着ブロック");
define("_MI_GLOSSARY_ENTRIESTOP", "人気ブロック");
define("_MI_GLOSSARY_RANDOMTERM", "ランダムブロック");
define("_MI_GLOSSARY_TERMINITIAL", "英字・50音で探す");


// A brief description of this module
define("_MI_GLOSSARY_PERPAGE", "【管理画面】管理画面１ページあたりの語数");
define("_MI_GLOSSARY_PERPAGEDSC", "指定した語数ごとに改ページします。");

define("_MI_GLOSSARY_PERPAGEINDEX", "【ページ】閲覧画面１ページあたりの語数");
define("_MI_GLOSSARY_PERPAGEINDEXDSC", "指定した語数ごとに改ページします。");

define("_MI_GLOSSARY_CATSINMENU","【メニュー表示】メインメニューに分類（カテゴリー）を表示");
define("_MI_GLOSSARY_CATSINMENUDSC","「はい」を選ぶとメインメニューの中に表示します。");

define("_MI_GLOSSARY_DESCLENGTH", "【表示方法】説明文の一部を表示するときの長さ");
define("_MI_GLOSSARY_DESCLENGTHDSC", "単語の詳細表示ページ以外では説明文を省略できます。省略時の文字（バイト）数を指定してください。（初期値：100）");

define("_MI_GLOSSARY_LINKTERMS", "【表示方法】自動参照リンク機能を使用");
define("_MI_GLOSSARY_LINKTERMSDSC", "説明文の中に「他の見出し語」があったとき、その見出し語のページへ自動的にリンクを張ります。英数はシングルクオート、ダブルクオートでくくってください。日本語は 14. で設定できます。<a href='".XOOPS_URL."/modules/glossary/admin/pluginlist.php' target='_blank'>プラグイン対応状況</a>");
define("_MI_GLOSSARY_LINKTERMSOP0DSC", "使用しない");
define("_MI_GLOSSARY_LINKTERMSOP1DSC", "Xwords だけを対象に使用する（複製も含む）");
define("_MI_GLOSSARY_LINKTERMSOP2DSC", "Xwords とプラグインのあるモジュールを対象に使用する");
define("_MI_GLOSSARY_LINKTERMSOP3DSC", "検索できるモジュールすべてを対象に使用する");

define("_MI_GLOSSARY_LINKTERMSPOSI", "【表示方法】作成されたリンクを本文の中に表示");
define("_MI_GLOSSARY_LINKTERMSPOSIDSC", "「いいえ」を選ぶと本文の下に羅列し、「はい」を選ぶと本文の中、該当語の前にアイコンを表示します。");

define("_MI_GLOSSARY_LINKTERMSTITLE", "【表示方法】自動参照リンクタイトル");
define("_MI_GLOSSARY_LINKTERMSTITLEDSC", "自動的に作成されたリンクにタイトルをつけます。");
define("_MI_GLOSSARY_LINKTERMSDEFAULT", "関連記事：");

define("_MI_GLOSSARY_READMEUSED", "【トップページ】紹介文を表示する");
define("_MI_GLOSSARY_READMEUSEDSC", "「はい」を選ぶとトップページに紹介文を表示します。");

define("_MI_GLOSSARY_README", "【トップページ】トップページに表示する紹介文");
define("_MI_GLOSSARY_READMEDSC", "どんな言葉を収録しているとか。空欄でも結構です。");
define("_MI_GLOSSARY_READMEDEF", "当サイトで使用している言葉、関連のある言葉を解説します。");


define("_MI_GLOSSARY_CATEGORYDISP", "【トップページ】カテゴリの一覧を表示");
define("_MI_GLOSSARY_CATEGORYDISPDSC", "「はい」トップページにカテゴリの一覧表示します「いいえ」にすると、カテゴリの表示を行いません。");

define("_MI_GLOSSARY_SEARCHBLOCK", "【トップページ】フリーワード検索を表示");
define("_MI_GLOSSARY_SEARCHBLOCKDSC", "「はい」トップページにフリーワード検索を表示します「いいえ」にすると、フリーワード検索の表示を行いません。");

define("_MI_GLOSSARY_LETTERDISP", "【トップページ】英字・５０音で探すを表示");
define("_MI_GLOSSARY_LETTERDISPDSC", "「はい」トップページに英字・５０音で探すを表示します「いいえ」にすると、英字・５０音で探すの表示を行いません。");

define("_MI_GLOSSARY_BLOCKSPERPAGE", "【ページ】トップとカテゴリーページに表示す新着用語・用語ランキングの数");
define("_MI_GLOSSARY_BLOCKSPERPAGEDSC", "ゼロにすると表示しません。初期値：5");

define('_MI_GLOSSARY_MODREWRITE', '【表示方法】mod_rewrite を使う');
define('_MI_GLOSSARY_MODREWRITE_DSC', 'mod_rewrite を使ってURLの変換を行います。.htaccess の設置が必要です');

?>