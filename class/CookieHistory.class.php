<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

// --------------------------------------------------------
// Sql Service Class
// --------------------------------------------------------
class CookieService {

// --------------------------------------------------------
// histry cookie
// Cookie data is shopid | url
// 1057|shop1057.html,1069|shop1069.html
// --------------------------------------------------------

	var $mConfig = array();

	function getFeaturedWords($sqlPram = '',$configUseModRewrite = false) 
	{
		$root =& XCube_Root::getSingleton();
		$textFilter =& $root->getTextFilter();
		$db =& $root->mController->mDB;
		return $retArray;
	}


	$itemArray = $shopItemArray = array();  // Shop data aray
	$cookie = "COOKIE_SHOP"; // cookie name
	// Check cookie
	if (isset($_COOKIE[$cookie])) {
		$getCookieValue = $_COOKIE[$cookie];
		// Array to Search words with space
		$cookieArray = explode(",",$getCookieValue);
		// Cookie Count
		$cookieArrayCount = count($cookieArray);
		if ($cookieArrayCount>9) $cookieArrayCount =9;
		$newCookieValue = $getShopId.'|'.$shopViewUrl; 
		for ($i =0; $i<$cookieArrayCount; $i++) {
			$shopArray = explode("|",$cookieArray[$i]);
			if ($shopArray[0]<>$getShopId) {
				$newCookieValue.= ','.$cookieArray[$i];
			}
		}
		//$render->setAttribute('history', $itemArray );
	} else {
		$newCookieValue = $getShopId.'|'.$shopViewUrl; // new cookie
	}
	// set cookie to browser
	setcookie($cookie, $newCookieValue, time() + 365*24*36000,'/');

	//$cookieName = "COOKIE_SHOP"; // cookie name
	//$getCookieValue = $_COOKIE[$cookieName];
	//echo  "**** ".$getCookieValue."<br />";

}
?>