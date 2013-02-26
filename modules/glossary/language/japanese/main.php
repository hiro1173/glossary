<?php
// --------------------------------------------------------
// 共通
// --------------------------------------------------------
define('_MD_GLOSSARY_NOSUBMITTED', '登録されていません');
define('_MD_GLOSSARY_SUBMITTED', '登録しました');
define('_MD_GLOSSARY_NOTSUBMITTED', '登録出来ません');
define('_MD_GLOSSARY_NOTUSED', '利用出来ません。');

// --------------------------------------------------------
// ナビゲーション
// --------------------------------------------------------
define('_MD_GLOSSARY_HOME','ホーム');
define('_MD_GLOSSARY_ID','ID');
define('_MD_GLOSSARY_EXPLANATION','解説');
define('_MD_GLOSSARY_RELATEDTERM','関連する用語');
define('_MD_GLOSSARY_LETTERSEARCH','&nbsp;英字・５０音で探す&nbsp;');
define('_MD_GLOSSARY_LETTERS','英字・５０音で探す');
define('_MD_GLOSSARY_BYRELATEDTERM','に関連する用語');
define('_MD_GLOSSARY_GOTOP', '↑&nbsp;このページの上へ&nbsp;↑');
define('_MD_GLOSSARY_READMORE','&nbsp;を詳しく見る');

define('_MD_GLOSSARY_SUBMIT','&nbsp;登&nbsp;録&nbsp;');

define('_MD_GLOSSARY_CANCEL','キャンセル');

// --------------------------------------------------------
// 検索フォーム
// --------------------------------------------------------
define('_MD_GLOSSARY_FREEWORDS','フリーワード検索');
define('_MD_GLOSSARY_SEARCHWORD','見出し語');
define('_MD_GLOSSARY_SEARCHALL','全文');
define("_MD_GLOSSARY_SEARCHENTRY", "&nbsp;検索する&nbsp;");
define('_MD_GLOSSARY_RESULTSWORD','検索した用語');
define('_MD_GLOSSARY_SEARCHDESC','検索する言葉を入力して検索ボタンをクリックして下さい。<br>検索する言葉の間にスペースを入れると OR検索になります。');
define('_MD_GLOSSARY_NEEDINPUTTWORD','キーワードを入力してください');
define('_MD_GLOSSARY_RESULTWORD','語が該当しました。');
define('_MD_GLOSSARY_NOTRESULT','該当するキーワードはありませんでした。');
// 検索結果
define('_MD_GLOSSARY_PAGE_HIT','件該当（全');
define('_MD_GLOSSARY_PAGE_TOTAL','ページ中');
define('_MD_GLOSSARY_PAGE_NUMBER','ページ目）');


// --------------------------------------------------------
// 新型ページ移動
// --------------------------------------------------------
define('_MD_GLOSSARY_PAGER_FIRST','<< 先頭');
define('_MD_GLOSSARY_PAGER_LAST','最終 >>');
define('_MD_GLOSSARY_PAGER_PREV','< 前');
define('_MD_GLOSSARY_PAGER_NEXT','次 >');


// --------------------------------------------------------
// カテゴリ
// --------------------------------------------------------
define('_MD_GLOSSARY_CATEGORY','カテゴリ');
define('_MD_GLOSSARY_CATEGORY_LIST','カテゴリ一覧');
define('_MD_GLOSSARY_CATEGORYID','カテゴリID');
define('_MD_GLOSSARY_NO_CATEGORIES', 'カテゴリがありません');

// --------------------------------------------------------
//　用語の表示
// --------------------------------------------------------
define('_MD_GLOSSARY_MODIFY','【編集】');
define('_MD_GLOSSARY_NEWWORD','新着用語');
define('_MD_GLOSSARY_URL','参考サイト');
define('_MD_GLOSSARY_SUBMITTER','投稿者');
define('_MD_GLOSSARY_SUBMITED','投稿日');

define('_MD_GLOSSARY_SEARCHLETTER','検索用語：%s行 （全&nbsp;%s件）');


// --------------------------------------------------------
// 用語の登録と編集
// --------------------------------------------------------
define('_MD_GLOSSARY_PREVIEW','【 プレビュー表示 】<font color="#E00000">※実際の表示と異なる場合があります。</font>');
define('_MD_GLOSSARY_WORD_ADD','新しい用語の追加&nbsp;<font color="#E00000">※</font>は入力必須です。');
define('_MD_GLOSSARY_FORM_TERM','<font color="#E00000">※</font>用語');
define('_MD_GLOSSARY_FORM_PROC','<font color="#E00000">※</font>よみ');
define('_MD_GLOSSARY_FORM_DESC','<font color="#E00000">※</font>説明文');
define('_MD_GLOSSARY_FORM_CATEGORY','<font color="#E00000">※</font>カテゴリ');
define('_MD_GLOSSARY_WORD_MOD','用語の編集');
define('_MD_GLOSSARY_TERM','用語');
define('_MD_GLOSSARY_PROC','よみ');
define('_MD_GLOSSARY_INIT','検索語');
define('_MD_GLOSSARY_ENGLISH','英語名');
define('_MD_GLOSSARY_DESCRIPTION','説明文');
define('_MD_GLOSSARY_SLUG','投稿スラッグ');
define('_MD_GLOSSARY_SLUG_DESC','投稿スラッグはURL名を英語にします。英語名を入力すると投稿スラッグを自動で作成します。');
define('_MD_GLOSSARY_NEWWORDS','新着用語');
define('_MD_GLOSSARY_HITWORDS','用語ランキング');
define('_MD_GLOSSARY_RELATION','関連記事');
define('_MD_GLOSSARY_REFERENCE','参考サイト名');
define('_MD_GLOSSARY_REFERENCE_URL','参考サイトURL');
define('_MD_GLOSSARY_HITS','ヒット数');
define('_MD_GLOSSARY_BLOCK','ブロック表示');
define('_MD_GLOSSARY_ADD_RELATION','関連記事を追加');
define('_MD_GLOSSARY_PUBLISHED','公開チェック');
define('_MD_GLOSSARY_PUBLISHED_YES','公開する');
define('_MD_GLOSSARY_PUBLISHED_NO','公開しない');
define('_MD_GLOSSARY_NO_WORDS', '用語は登録されていません');

// ====【 超 重 要 】======================================
// 文字コード依存対策(for Japanese)
// 文字の検索・置換に使用しているので絶対に変更不可
// ========================================================
define('_MD_GLOSSARY_WORDSPACEHAN', ' ');                // 全角スペースを半角に置換するのに利用
define('_MD_GLOSSARY_WORDSPACEZEN', '　');                // 全角スペースを半角に置換するのに利用
define('_MD_GLOSSARY_WORD_DELWORD', '/^【|】$/');      // 【】を取り除く        preg_replace ("/^【|】$/","",$q_arr[$i])
define('_MD_GLOSSARY_WORDLINKWORD', '/【(.+?)】/');    // 【】を含む文字を探す  preg_match_all("/【(.+?)】/",$search_desc,$q_arr)

// --------------------------------------------------------
// TO DO の為の予約語
// --------------------------------------------------------
//define('_MD_GLOSSARY_TAG_ID','タグID');
//define('_MD_GLOSSARY_TAG','タブ');

?>
