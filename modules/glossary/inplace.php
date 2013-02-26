<?php
/*

HTML側
	<p class="editme1" id="term">
	<{$object->getShow('term')}>
	</p>
*/

require '../../mainfile.php';
$root =& XCube_Root::getSingleton();

// 編集可能フラグ
$editable = false;

// GET データ受け取り
$getId = isset($_GET['id']) ? intval($_GET['id']) : 0;    // キーID
$getDb = isset($_GET['db']) ? trim($_GET['db']) : '';     // データベース名

// POST データ受け取り
$updateValue   = isset($_POST['update_value'])  ? trim($_POST['update_value'])  : '';     // 更新するテキスト
$originalValue = isset($_POST['original_html']) ? $_POST['original_html'] : '';     // 以前のテキスト
$elementId     = isset($_POST['element_id'])    ? $_POST['element_id']    : '';     // DBのフィールド名
$ajax          = isset($_POST['ajax'])          ? $_POST['ajax']          : 'yes'; 

// キーID,データベース名,Bのフィールド名 がない場合は、編集しない
// 現状は空白のテキストはOKにしている
if (!$getDb or !$getId or !$elementId ) {
	echo $originalValue;
	exit;
}

// TODO
// DBのフィールドは、半角英数か、チェック
// テキストの入力チェック
//	$term = addSlashes(strip_tags($this->get('term')));
//	$term = trim(mb_convert_kana($term,"s"));

if ($elementId=='term') {
	$updateValue = addSlashes(strip_tags($updateValue));
	$updateValue = trim(mb_convert_kana($updateValue,"s"));
}



// 編集権限のチェック
// TODO 汎用性を持たせる
$hasPermission = $root->mContext->mUser->isInRole('Module.glossary.Admin') ;

// 編集条件
if ($hasPermission) $editable = true;
if ($updateValue <> $originalValue ) $editable = true;



// 編集処理
if ($editable){
	// 編集権限があり、データが変更された場合
	// データを更新
	$handler =& xoops_getmodulehandler($getDb);
	$update = $handler->updateValue($getId, $elementId, $updateValue);
	if ($update){
		// 出力データを新しい値にセット
		echo $updateValue;
	} else {
		// 編集出来ない場合は、元の値へ
		echo $originalValue;
	}
} else {
	// 編集出来ない場合は、元の値へ
	echo $originalValue;
}



?>

