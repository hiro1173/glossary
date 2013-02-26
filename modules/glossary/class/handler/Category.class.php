<?php

//echo 'Category.class.php<br />';

if (!defined('XOOPS_ROOT_PATH')) exit();
//XoopsSimpleObjectを継承するクラス名
class GlossaryCategoryObject extends XoopsSimpleObject
{

	// 子のインデックスがある場合に使用 なければ削除
	var $children = array();
	var $childNumbers = 0;

	//XoopsSimpleObjectを継承するクラス名
	function GlossaryCategoryObject()
	{
		$this->initVar('categoryid' , XOBJ_DTYPE_INT    , '0', true );
		$this->initVar('parentid'   , XOBJ_DTYPE_INT    , '0', true );
		$this->initVar('name'       , XOBJ_DTYPE_STRING , '' , true ,100);
		$this->initVar('description', XOBJ_DTYPE_TEXT   , '' , true );
		$this->initVar('weight'     , XOBJ_DTYPE_INT    , '0', true );

	}

	// 子のインデックスがある場合に使用 なければ削除
	function setChildren($children = array())
	{
		$this->children =& $children;  // 子のデータ
		$this->childNumbers = count($children);  // その親に何個子がいるか？
	}
	// 子のインデックスがある場合に使用 なければ削除
	function getChildren()
	{
		return $this->children;
	}

}

// XoopsObjectGenericHandlerを継承するクラス名
class GlossaryCategoryHandler extends XoopsObjectGenericHandler
{
	//XoopsSimpleObjectを継承するクラス名
	var $mClass   = 'GlossaryCategoryObject';
	//テーブル名（プレフィックス除く）
	var $mTable   = 'glossary_category';
	//テーブルのプライマリキー
	var $mPrimary = 'categoryid';
	// 親のフィールド名
	var $mParent  = 'parentid';
	// デフォルトの並び順
	var $mOrder   = 'weight';
	//取り出すフィールド名
	var $mName = 'name';

	// --------------------------------------------------------
	// XooopsTree->getChildTreeArray 互換 パラメータの並びが違うので注意
	// ツリー上に配列にして返す
	// $mHandler->getChildTreeArray() ; のみでOK
	// --------------------------------------------------------
	function getChildTreeArray($sel_id=0, $order='', $parray = array(), $r_prefix="")
	{
		$sel_id = intval($sel_id);
		$sql = "SELECT * FROM ".$this->mTable." WHERE ". $this->mParent. " =". $sel_id. "";;
		if ( $order != "" ) {
			$sql .= " ORDER BY ". $order;
		} else {
			$sql .= " ORDER BY ". $this->mOrder ;    // デフォルトの並び順
		}
		$result = $this->db->query($sql);
		$count = $this->db->getRowsNum($result);
		if ( $count == 0 ) {
			return $parray;
		}
		while ( $row = $this->db->fetchArray($result) ) {
			$row['prefix'] = $r_prefix;
			array_push($parray, $row);
			$row['prefix'] = $r_prefix."..";
			$parray = $this->getChildTreeArray($row[$this->mPrimary], $order, $parray, $row['prefix']);
		}
		return $parray;
	}

	// --------------------------------------------------------
	// html_options を使ったセレクトボックス用の配列を作る
	// makeSelectbox の代用に使う
	// categoryArrayの項目はテーブル別に変更する必要がある
	// --------------------------------------------------------
	function getSelectArray( $usenull=false )
	{
		if ($usenull) {
			$categoryArray[0] = '------';
		}
		$parray = $this->getChildTreeArray();
		foreach( $parray as $cat_node ) {
			extract( $cat_node ) ;
			$prefix = str_replace( '.' , '-' , $prefix  ) ;
			$categoryArray[ intval($categoryid) ] = $prefix . addSlashes($name);
		}
		return $categoryArray;
	}

	function getChildArray( $sel_id=0, $order='', $parray = array())
	{
		$sel_id = intval($sel_id);
		$sql = "SELECT * FROM ".$this->mTable." WHERE ". $this->mParent. " =". $sel_id. "";;
		if ( $order != "" ) {
			$sql .= " ORDER BY ". $order;
		} else {
			$sql .= " ORDER BY ". $this->mOrder;
		}
		$result = $this->db->query($sql);
		$count = $this->db->getRowsNum($result);
		if ( $count == 0 ) {
			return $parray;
		}
		while ( $row = $this->db->fetchArray($result) ) {
			array_push($parray, $row);
			$parray = $this->getChildTreeArray($row[$this->mPrimary], $order, $parray);
		}
		return $parray;
	}

	// --------------------------------------------------------
	// 記事削除
	// 子のカテゴリを削除する。
	// $forceは、queryF を使うかのフラグ
	// $handler->deleteChild(1)
	// --------------------------------------------------------
	function deleteChild($sel_id, $force = false)
	{
		$sel_id = intval($sel_id);
		$childArray = $this->getChildTreeArray($sel_id);
		$delId = array($sel_id);
		if (count($childArray)) {
			foreach ($childArray as $delTable) {
				$delId[] = $delTable[$this->mPrimary];
			}
		}
		$sql = 'DELETE FROM `'. $this->mTable. '` WHERE '. $this->mPrimary. ' IN ('. implode(', ', $delId). ')';
		return $force ? $this->db->queryF($sql) : $this->db->query($sql);
	}


}
?>
