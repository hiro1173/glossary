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


if (!defined("_MD_GLOSSARY_ALL_INIT"))
	{
	define("_MD_GLOSSARY_ALL_LINKTEXT", "���٤�");
	define("_MD_GLOSSARY_ALL_ID", "");
	define("_MD_GLOSSARY_ALL_INIT", "^.*");
	}

// **************************************************************************
// ����ե��٥åȡ��޽����ʤɡ�Ƭʸ���ˤ�륤��ǥå�����������뤿��Υǡ���
// $mb_init = �����ѡ�$mb_id = POST�ѡ�$mb_linktext = ɽ����
// $mb_separator = ����ǥå����֤ζ��ڤ�ʸ����
// �ѹ�����Ȥ��ϡ����Ĥ�����ο����碌�뤳�ȡ��ʡ�,�פ�Ʊ���ˤ����
// **************************************************************************


$mb_init = array(
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|a|A|i|I|u|U|e|E|o|O).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|k|K|g|G).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|s|S|z|Z|j|J).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|t|T|d|D|c|C).*",
	"^(��|��|��|��|��|��|��|��|��|��|n|N).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|��|h|H|b|B|v|V|p|P).*",
	"^(��|��|��|��|��|��|��|��|��|��|m|M).*",
	"^(��|��|��|��|��|��|��|��|��|��|��|��|y|Y).*",
	"^(��|��|��|��|��|��|��|��|��|��|r|R).*",
	"^(��|��|��|��|��|��|��|w|W).*",

);

$mb_id = array(
	"a","ka","sa","ta","na","ha","ma","ya","ra","wa",

);

$mb_linktext = array(
	"����","����","����","����","�ʹ�","�Ϲ�","�޹�","���","���","���",
);

$mb_separator = array(
	"","|","|","|","|","|","|","|","|","|",
);

?>