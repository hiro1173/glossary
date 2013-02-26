<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

class GlossaryTagObject extends XoopsSimpleObject
{
	function GlossaryTagObject()
	{
		$this->initVar('tagid'      , XOBJ_DTYPE_INT    , '0', true );
		$this->initVar('wordid'     , XOBJ_DTYPE_INT    , '0', true );
		$this->initVar('tag'        , XOBJ_DTYPE_STRING , '' , true ,100);
		
		// タグ編集用
		// テーブルにない項目をアクションフォームで使えるように
		// 入力は、false に設定
		$this->initVar('new_tag'    , XOBJ_DTYPE_STRING , '' , false ,100);
	}
}

class GlossaryTagHandler extends XoopsObjectGenericHandler
{
	var $mClass    = 'GlossaryTagObject';    // 必須
	var $mTable    = 'glossary_tag';         // タグのテーブル名
	var $mTag      = 'tag';                  // タグのフィールド名
	var $mIndexkey = 'tagid';                // インデックスキー
	var $mPrimary  = 'wordid';               // 関連づけしているキー
	var $mHandleDb = 'tag';                  // xoops_getmodulehandlerのデータベース名

	// --------------------------------------------------------
	// タグ別の使用数一覧を求める
	// --------------------------------------------------------
	function adminTagList($sqlLimit=5, $sqlStart=0, $getSort='bCount', $getOrder='DESC') {
		$retArray = array();
		$sql = sprintf('SELECT `%s`, COUNT(`%s`) AS bCount FROM `%s` GROUP BY `%s` ORDER BY `%s` %s', $this->mTag, $this->mIndexkey, $this->mTable, $this->mTag, $getSort ,$getOrder );
		$result = $this->db->query($sql, $sqlLimit, $sqlStart) ;
		while (list($tagWord, $tagCount) = $this->db->fetchRow($result)) {
			array_push($retArray, array(
				'tag_word'  => $tagWord,
				'tag_count' => $tagCount,
			));
		}
		return $retArray;
	}

	// --------------------------------------------------------
	// タグの用語別の合計数を求める
	// --------------------------------------------------------
	function adminCountTagWords() {
		$sql = sprintf('SELECT COUNT(`%s`) AS bCount FROM `%s` GROUP BY `%s`', $this->mIndexkey, $this->mTable, $this->mTag);
		$result = $this->db->query($sql);
		return $this->db->getRowsNum($result) ;
	}

	// --------------------------------------------------------
	// 使用しているタグをテキストで取り出す
	// --------------------------------------------------------
	function getTagList( $setid = NULL, $delComma = false) {
		$entryTags = ''; 
		$tagHandler = xoops_getmodulehandler($this->mHandleDb);
		$mCriteria = new CriteriaCompo();
		$mCriteria->add(new Criteria($this->mPrimary, $setid));
		$mCriteria->setSort($this->mTag);
		$mObject = $tagHandler->getObjects($mCriteria);
		foreach ($mObject as $key => $val) {
			$entryTags .= $val->getShow($this->mTag). ', ';
		}
		// delete last copmma
		if ($delComma) {
			$entryTags = substr($entryTags, 0, -2);
		}
		return $entryTags ;
	}

	// --------------------------------------------------------
	// 使用しているタグを配列で取り出す
	// --------------------------------------------------------
	function getEntoryTagArray( $setid = NULL) {
		$entryTags = array(); 
		$tagHandler = xoops_getmodulehandler($this->mHandleDb);
		$mCriteria = new CriteriaCompo();
		$mCriteria->add(new Criteria($this->mPrimary, $setid));
		$mCriteria->setSort($this->mTag);
		$mObject = $tagHandler->getObjects($mCriteria);
		foreach ($mObject as $key => $val) {
			$entryTags[] = $val->getShow($this->mTag);
		}
		return $entryTags ;
	}

	// --------------------------------------------------------
	// タグの置換
	// タグの用語を置換させる
	// --------------------------------------------------------
	function renameTag($oldTag='', $newTag='') {
		if (is_null($oldTag) || is_null($newTag)) {
			return false;
		}
		$sql = sprintf("UPDATE `%s` SET `%s` = '%s' WHERE `%s`='%s' ", $this->mTable, $this->mTag, $newTag, $this->mTag, $oldTag );
		return $this->db->query($sql);
	}

	// --------------------------------------------------------
	// タグを削除する（タグ）
	// --------------------------------------------------------
	function deleteTag($delTag = NULL) {
		$sql = sprintf("DELETE FROM `%s` WHERE `%s`='%s'", $this->mTable, $this->mTag, $delTag );
		return $this->db->query($sql);
	}

	// --------------------------------------------------------
	// タグを削除する（タグ）
	// 配列で渡されたタグを削除する
	// --------------------------------------------------------
	function deleteTagArray($tagArray = NULL, $tags = NULL) {
		$tags_count = count($tags);
		$delPram = '';
		for ($i = 0; $i < $tags_count; $i++) {
			$delPram .= ' AND `'.$this->mTag. '` != "'. $tags[$i].'"' ;
		}
		$sql = sprintf("DELETE FROM `%s` WHERE `%s`='%s' '%s'", $this->mTable, $this->mPrimary, $tagArray, $delPram );
		return $this->db->query($sql);
	}

	// --------------------------------------------------------
	// タグを保存する
	// --------------------------------------------------------
	function saveTags($setid =0 , $tagText='',$tagToLower = true)
	{
		$tagText = trim($tagText);
		// パラメータのチェック
		if (is_null($tagText)) {
			return false;
		}
		if (!$setid > 0) {
			return false;
		}

		$tagHandler = xoops_getmodulehandler($this->mHandleDb);
		
		$tempArray = array();    // 一時処理用配列
		$deleteTagArray = array();
		$addTagArray = array();

		// --------------------------------------------------------
		// タグのテキストをクリーンにして、配列に変換
		// --------------------------------------------------------
		// タグのテキストを配列に保存
		$tagArray = explode(',', $tagText);
		// タグの文字をテキストだけ取り出す
		// タグの各文字の空白を取り除く
		$tags_count = count($tagArray);
		for ($i = 0; $i < $tags_count; $i++) {
			// $tags[$i] = trim($tags[$i]);
			// 前後の空白取り除く
			$tag = trim($tagArray[$i]);
			// タグの小文字指定の場合は、小文字に変換する
			if ($tagToLower) {
				$tag = strtolower($tag);
			}
			// タグを配列へ代入
			if ($tag<>"") {
				$tempArray[] = $tag ;
			}
		}
		
		$tagArray = $tempArray;
		// 一時処理用配列を初期化
		unset($tempArray);

		// --------------------------------------------------------
		// タグの配列から重複した単語を取り除いてユニークにする
		// --------------------------------------------------------
		// タグの数を再カウント
		$tags_count = count($tagArray);
		// タグ配列から重複した値を削除する
		if ($tags_count > 0) {
			// Eliminate any duplicate tag
			$tempArray = array_unique($tagArray);
			$tagArray = array_values($tempArray);
		}
		// 一時処理用配列を初期化
		unset($tempArray);

		// 現状のタグを求める
		$mCriteria = new CriteriaCompo();
		$mCriteria->add(new Criteria($this->mPrimary, $setid));
		$mCriteria->setSort($this->mTag);
		$mObjects = $tagHandler->getObjects($mCriteria);

		if ($mObjects == null) {
			$addTagArray = $tagArray;
		} else {
			foreach ($mObjects as $key => $val) {
				$tempArray[] = $val->getShow($this->mTag);
			}
			// --------------------------------------------------------
			// 新旧のタグを比較
			// --------------------------------------------------------
			// 削除が必要なタグ
			$deleteTagArray = array_diff($tempArray, $tagArray); 
			// 追加されたタグ
			$addTagArray = array_diff($tagArray, $tempArray); 
		}

		// --------------------------------------------------------
		// 使われていない以前のタグを削除する（タグ）
		// --------------------------------------------------------
		if (count($deleteTagArray) > 0) {
			foreach ($deleteTagArray as $key => $val) {
				$sql = sprintf("DELETE FROM `%s` WHERE `%s`=%u AND `%s` LIKE '%s'", $this->mTable, $this->mPrimary, $setid, $this->mTag, $val );
				$this->db->query($sql);
			}
		}

		// --------------------------------------------------------
		// 追加されたタグを保存
		// --------------------------------------------------------
		if (count($addTagArray) > 0) {
			foreach ($addTagArray as $key => $val) {
				$sql = sprintf("INSERT INTO `%s` (%s, %s, %s) VALUES (%u, %u, '%s')", $this->mTable, $this->mIndexkey, $this->mPrimary, $this->mTag, NULL, $setid, $val );
				$result = $this->db->query($sql);
			}
		}
		return;
	}


}

?>
