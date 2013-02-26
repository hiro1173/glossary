<?php

/*=====================================================================
  (C)2007 BeaBo Japan by Hiroki Seike
  http://beabo.net/
=====================================================================*/
// --------------------------------------------------------
// ナビゲーション
// --------------------------------------------------------
define('_MD_GLOSSARY_HOME', "ホーム");
define('_MD_GLOSSARY_ID', "ID");
define('_MD_GLOSSARY_LETTERS', "英字・５０音で探す");
define('_MD_GLOSSARY_LETTERSEARCH', "&nbsp;英字・５０音で探す&nbsp;");
define('_MD_GLOSSARY_GOTOP', "↑&nbsp;このページの上へ&nbsp;↑");
define('_MD_GLOSSARY_READMORE', "詳しく見る");
define('_MD_GLOSSARY_EDITK', "編集");
define('_MD_GLOSSARY_DELETE', "削除");

// --------------------------------------------------------
// エラーメッセージ
// --------------------------------------------------------
define('_MD_GLOSSARY_ERORR_NOSUBMITTED', "登録されていません");
define('_MD_GLOSSARY_ERROR_REQUIRED', "{0}は必ず入力して下さい");
define('_MD_GLOSSARY_ERROR_PERMISSION', "アクセス権限がありません。<br />トップページへ戻ります。");
define('_MD_GLOSSARY_ERROR_EDIT_FOR_PERMISSION', "編集するアクセス権限がありません。<br />トップページへ戻ります。");
define('_MD_GLOSSARY_ERROR_DELETE_FOR_PERMISSION', "削除するアクセス権限がありません。<br />トップページへ戻ります。");
define('_MD_GLOSSARY_ERROR_PARAMETER', "パラメータが正しくありません。<br />トップページへ戻ります。");

// --------------------------------------------------------
// テーブル別設定
// --------------------------------------------------------

// --------------------------------------------------------
// テーブル：カテゴリ
// --------------------------------------------------------
define('_MD_GLOSSARY_CATEGORY', "カテゴリ");
define('_MD_GLOSSARY_CATEGORY_ADD', "カテゴリ追加");
define('_MD_GLOSSARY_CATEGORY_LIST', "カテゴリ一覧");
define('_MD_GLOSSARY_CATEGORY_EDIT', "カテゴリの編集");
define('_MD_GLOSSARY_CATEGORY_EDIT_ERROR', "カテゴリの編集でエラーが発生しました。保存できません。");
define('_MD_GLOSSARY_CATEGORY_SUCCESS', "カテゴリを保存しました。");
define('_MD_GLOSSARY_CATEGORY_DELETE', "カテゴリの削除");
define('_MD_GLOSSARY_CATEGORY_DELETEED', "カテゴリを削除しました。");
define('_MD_GLOSSARY_CATEGORY_DELETE_ERROR', "カテゴリの削除でエラーが発生しました。");




// フィールド名
define('_MD_GLOSSARY_CATEGORYID', "カテゴリID");
define('_MD_GLOSSARY_CATEGORY_PARENTID', "親カテゴリ");
define('_MD_GLOSSARY_CATEGORY_NAME', "カテゴリ名");
define('_MD_GLOSSARY_CATEGORY_DESCRIPTION', "説明文");
define('_MD_GLOSSARY_CATEGORY_WEIGHT', "並び順");
define('_MD_GLOSSARY_CATEGORY_ISNOTSET', "カテゴリが作成されていません。登録するには、カテゴリを作成して下さい。");


// --------------------------------------------------------
// テーブル：タグ
// --------------------------------------------------------
// フィールド名
define('_MD_GLOSSARY_TAG', "タグ");
// その他
define('_MD_GLOSSARY_TAGS', "タグ");
define('_MD_GLOSSARY_TAG_CLOUD', "タグクラウド");
define('_MD_GLOSSARY_TAG_POPULAR', "人気のタグ");
define('_MD_GLOSSARY_TAG_DSC', "&larr; カンマ区切り");
define('_MD_GLOSSARY_TAG_USEDSC', "タグをクリックすると、タグ入力欄に追加され選択色に変わります。選択色のタグをクリックするとタグ入力欄から削除されます。");
define('_MD_GLOSSARY_TAG_RESULT', "最近使用したタグ");


// --------------------------------------------------------
// テーブル：用語
// --------------------------------------------------------
define('_MD_GLOSSARY_WORD', "用語");
define('_MD_GLOSSARY_WORD_LIST', "用語一覧");
define('_MD_GLOSSARY_WORD_EDIT', "用語の編集");
define('_MD_GLOSSARY_WORD_EDIT_ERROR', "用語の編集でエラーが発生しました。保存できません。");
define('_MD_GLOSSARY_EDIT_SUCCESS', "用語を保存しました。");
define('_MD_GLOSSARY_WORD_DELETE', "用語の削除");
define('_MD_GLOSSARY_WORD_DELETEED', "用語を削除しました。");
define('_MD_GLOSSARY_WORD_DELETE_ERROR', "用語の削除でエラーが発生しました。");
define('_MD_GLOSSARY_WORD_ADD', "用語の追加");

// フィールド名
define('_MD_GLOSSARY_WORD_ID', "用語");
define('_MD_GLOSSARY_WORD_TERM', "用語");
define('_MD_GLOSSARY_WORD_PROC', "よみ");
define('_MD_GLOSSARY_WORD_ENGLISH', "英語名");
define('_MD_GLOSSARY_WORD_INIT', "検索語");
define('_MD_GLOSSARY_WORD_DESCRIPTION', "説明文");
define('_MD_GLOSSARY_WORD_REFERENCE', "参考サイト名");
define('_MD_GLOSSARY_WORD_REFERENCE_URL', "参考サイトURL");
define('_MD_GLOSSARY_WORD_URL', "参考サイトURL");
define('_MD_GLOSSARY_WORD_HITS', "ヒット数");
define('_MD_GLOSSARY_WORD_BLOCK', "ブロック表示");
define('_MD_GLOSSARY_WORD_PUBLISHED', "公開チェック");
define('_MD_GLOSSARY_WORD_PUBLISHED_YES', "公開する");
define('_MD_GLOSSARY_WORD_PUBLISHED_NO', "公開しない");
define('_MD_GLOSSARY_WORD_TAG', "タグ");

// アクションフォーム　エラー文
define('_MD_GLOSSARY_WORD_ERROR_ENGLISH', "入力した英語名が正しくありません。半角英数字を入力してください。");
define('_MD_GLOSSARY_WORD_ERROR_REPEATED', "入力した用語は既に登録されています。");


// その他
define('_MD_GLOSSARY_WORD_NEWWORDS', "新着用語");
define('_MD_GLOSSARY_WORD_HITWORDS', "用語ランキング");
define('_MD_GLOSSARY_WORD_RELATION', "関連記事");
define('_MD_GLOSSARY_EXPLANATION', "解説");
define('_MD_GLOSSARY_WORD_RELATED', "%sに関連する用語");
// Meta Description の先頭文
define('_MD_GLOSSARY_WORD_METADESCRIPTION', "用語：%sについて ");


// --------------------------------------------------------
// 検索フォーム
// --------------------------------------------------------
define('_MD_GLOSSARY_FREEWORDS', "フリーワード検索");
define("_MD_GLOSSARY_SEARCHENTRY", "&nbsp;検索する&nbsp;");
define('_MD_GLOSSARY_NEEDINPUTTWORD', "キーワードを入力してください");

// --------------------------------------------------------
// 検索結果
// --------------------------------------------------------
define('_MD_GLOSSARY_SEARCHRESULTS', "検索結果");
define('_MD_GLOSSARY_RESULTSWORD', "検索した用語");
define('_MD_GLOSSARY_SEARCHWORD', "見出し語");
define('_MD_GLOSSARY_PAGE_HIT', "件該当");
define('_MD_GLOSSARY_RESULTWORD', "語が該当しました。");
define('_MD_GLOSSARY_NOTRESULT', "該当するキーワードはありませんでした。");


// --------------------------------------------------------
// 新型ページ移動
// --------------------------------------------------------
define('_MD_GLOSSARY_PAGER_FIRST', "<< 先頭");
define('_MD_GLOSSARY_PAGER_LAST', "最終 >>");
define('_MD_GLOSSARY_PAGER_PREV', "< 前");
define('_MD_GLOSSARY_PAGER_NEXT', "次 >");

// --------------------------------------------------------
//　用語の表示
// --------------------------------------------------------
define('_MD_GLOSSARY_NEWWORD', "新着用語");
define('_MD_GLOSSARY_URL', "参考サイト");
define('_MD_GLOSSARY_SUBMITTER', "投稿者");
define('_MD_GLOSSARY_SUBMITED', "投稿日");
define('_MD_GLOSSARY_SEARCHLETTER', "検索用語：%s行 （全&nbsp;%s件）");

// ====【 超 重 要 】======================================
// 文字コード依存対策(for Japanese)
// 文字の検索・置換に使用しているので絶対に変更不可
// ========================================================
define('_MD_GLOSSARY_WORDSPACEHAN', " ");                // 全角スペースを半角に置換するのに利用
define('_MD_GLOSSARY_WORDSPACEZEN', "　");                // 全角スペースを半角に置換するのに利用

//define('_MD_GLOSSARY_WORD_DELWORD', "/^【|】$/");      // 【】を取り除く        preg_replace ("/^【|】$/","",$q_arr[$i])
//define('_MD_GLOSSARY_WORDLINKWORD', "/【(.+?)】/");    // 【】を含む文字を探す  preg_match_all("/【(.+?)】/",$search_desc,$q_arr)


define('_MD_GLOSSARY_WORD_DELWORD', "/^&lt;&lt;|&gt;&gt;/");
define('_MD_GLOSSARY_WORDLINKWORD', "/&lt;&lt;(.+?)&gt;&gt;/");


?>
