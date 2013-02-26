<?php
// http://plugins.jquery.com/project/modaldialog
// http://tautologistics.com/projects/jquery.modaldialog/doc/1.0.0/


function modalDialogJs($pram=0, $title='', $time=2 ) {

	// $status = 0;    // not use dialog(default)
	// $status = 1;    // success
	// $status = 2;    // error
	// $status = 3;    // warning

	// 初期値
	$ret = '' ;
	
	$chechStatus = intval($pram);
	$dialogTimeout = intval($time);
	$dialogMassage = addSlashes($title);


	// 入力のチェック

	if ($chechStatus==0) {
		return false;
	} else {
		$ret = '<script type="text/javascript"charset="utf-8">' ;
		switch ($chechStatus) {
			case 1:
				$ret.= '$.modaldialog.success("' ;
				break;
			case 2:
				$ret.= '$.modaldialog.error("' ;
				break;
			case 3:
				$ret.= '$.modaldialog.warning("' ;
				break;
		}
		$ret.= $dialogMassage ;
		$ret.= '", {timeout:2 , showClose:false, width: 400});</script>' ;
	}
	return $ret;

?>