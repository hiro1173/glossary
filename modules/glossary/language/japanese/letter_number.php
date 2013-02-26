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

$MYDIRNAME = strtoupper(basename(dirname(dirname(dirname(__FILE__)))));
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
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(0|��)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(1|��)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(2|��)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(3|��)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(4|��)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(5|��)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(6|��)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(7|��)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(8|��)",
	"^([^\x21-\x7e]{2}|[\x21-\x7e]{1})(9|��)",
);

$mb_id = array(
	"01","02","03","04","05","06","07","08","09","10",
);

$mb_linktext = array(
	"��","��","��","��","��","��","��","��","��","��",
);

$mb_separator = array(
	"","|","|","|","|","|","|","|","|","|",
);

?>