<?php
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// XOOPS2 - Xwords 0.42
// WEBMASTER @ KANPYO.NET, 2005.


if (!defined('_MD_GLOSSARY_ALL_INIT'))
	{
	define('_MD_GLOSSARY_ALL_LINKTEXT', "すべて");
	define('_MD_GLOSSARY_ALL_ID', "");
	define('_MD_GLOSSARY_ALL_INIT', "^.*");
	}

// **************************************************************************
// アルファベット、五十音など、頭文字によるインデックスを作成するためのデータ
// $mb_init = 検索用、$mb_id = POST用、$mb_linktext = 表示用
// $mb_separator = インデックス間の区切り文字。
// 変更するときは、４つの配列の数を合わせること。（「,」を同数にする）
// **************************************************************************

$mb_init = array(
	"(A|a)",
	"(B|b)",
	"(C|c)",
	"(D|d)",
	"(E|e)",
	"(F|f)",
	"(G|g)",
	"(H|h)",
	"(I|i)",
	"(J|j)",
	"(K|k)",
	"(L|l)",
	"(M|m)",
	"(N|n)",
	"(O|o)",
	"(P|p)",
	"(Q|q)",
	"(R|r)",
	"(S|s)",
	"(T|t)",
	"(U|u)",
	"(V|v)",
	"(W|w)",
	"(X|x)",
	"(Y|y)",
	"(Z|z)",
	"(｡|｢|｣|､|･|ﾞ|ﾟ)",
);

$mb_id = array(
	"A","B","C","D","E","F","G","H","I","J","K","L","M",
	"N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
	"ETC",
);

// 単語のリンク用テキスト
$mb_linktext = array(
	"Ａ","Ｂ","Ｃ","Ｄ","Ｅ","Ｆ","Ｇ","Ｈ","Ｉ","Ｊ","Ｋ","Ｌ","Ｍ",
	"Ｎ","Ｏ","Ｐ","Ｑ","Ｒ","Ｓ","Ｔ","Ｕ","Ｖ","Ｗ","Ｘ","Ｙ","Ｚ",
	"記号",
);

// 単語の区切りの文字
$mb_separator = array(
	"","|","|","|","|","|","|","|","|","|","|","|","|",
	"|","|","|","|","|","|","|","|","|","|","|","|","|","|",
);

?>