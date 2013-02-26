<?php
// ページナビのオーバーライド
class Glossary_PageNavigator extends XCube_PageNavigator
{
	var $startKeyName = "start";

	function setfreezePerpage($freezeperpage = true)
	{
		// beabo
		$this->mPerpageFreeze = $freezeperpage;
	}


	function fetchNaviControl(&$navi)
	{	
		$root =& XCube_Root::getSingleton();
		
		$startKey = $navi->getStartKey();
		$perpageKey = $navi->getPerpageKey();

		if ($navi->mFlags & XCUBE_PAGENAVI_START) {
			$t_start = $root->mContext->mRequest->getRequest($navi->getStartKey());
			// changed beabo
			$t_start = ($t_start -1) * $this->getPerpage() ;
			if ($t_start != null && intval($t_start) >= 1) {
				$navi->mStart = intval($t_start);
			}
		}

		if ($navi->mFlags & XCUBE_PAGENAVI_PERPAGE && !$navi->mPerpageFreeze) {
			$t_perpage = $root->mContext->mRequest->getRequest($navi->getPerpageKey());
			if ($t_perpage != null && intval($t_perpage) > 0) {
				$navi->mPerpage = intval($t_perpage);
			}
		}
	}

	function renderUrlForSort()
	{
		if(count($this->mExtra) > 0) {
			$tarr=array();
			
			foreach($this->mExtra as $key=>$value) {
				$tarr[]=$key."=".urlencode($value);
			}
//			$tarr[] = $this->getPerpageKey() . "=" . $this->mPerpage;
			if(strpos($this->mUrl,"?")!==false) {
				return $this->mUrl."&amp;".implode("&amp;",$tarr);
			}
			else {
				return $this->mUrl."?".implode("&amp;",$tarr);
			}
		}
		
		return $this->mUrl;
	}
	
	function renderUrlForPage($page = null)
	{
		$tarr=array();
			
		foreach($this->mExtra as $key=>$value) {
			$tarr[]=$key."=".urlencode($value);
		}
			
		foreach($this->mSort as $key=>$value) {
			$tarr[]=$key."=".urlencode($value);
		}
		// not use
		// $tarr[] = $this->getPerpageKey() . "=" . $this->getPerpage();
		
		if ($page !== null) {
			// beabo
			// ページ移動のリンクをページ数にする
			$tarr[] = $this->startKeyName . '/' . (intval($page) / $this->getPerpage() +1)  ;
		}
			
		if (strpos($this->mUrl,"?") !== false) {
			return $this->mUrl."&amp;".implode("&amp;",$tarr);
		}
		return $this->mUrl.implode("/",$tarr). "/";
//		return $this->mUrl."?".implode("&amp;",$tarr);
	}
	
	/**
	 * Return url string for sort. The return value is complete style.
	 * @deprecated
	 */


	// add beabo
	// startの名前を変更する
	function setStartKeyName($keynaame = "start")
	{
		$this->startKeyName = $keynaame;
//		return $this->mPrefix . $keynaame;
	}


}

?>