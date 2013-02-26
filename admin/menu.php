<?php
/*=====================================================================
  (C)2007 BeaBo Japan by Hiroki Seike
  http://beabo.net/
=====================================================================*/

$adminmenu[1] = array(
    'title'       => _MI_GLOSSARY_MAIN ,
    'description' => _MI_GLOSSARY_MAIN_DSC ,
    'link'        => 'admin/index.php' ,
    'keywords'    => '',
    'show'        => true
) ;

$adminmenu[2] = array(
    'title'       => _MI_GLOSSARY_WORD,
    'description' => _MI_GLOSSARY_WORD_DSC ,
    'link'        => 'admin/index.php?action=WordList' ,
    'keywords'    => '',
    'show'        => true
) ;


$adminmenu[3] = array(
    'title'       => _MI_GLOSSARY_TAG,
    'description' => _MI_GLOSSARY_TAG_DSC ,
    'link'        => 'admin/index.php?action=TagList' ,
    'keywords'    => '',
    'show'        => true
) ;


$showCategory = isset( $xoopsModuleConfig['use_category']) ? intval( $xoopsModuleConfig['use_category']) : 0;

$adminmenu[4] = array(
    'title'       => _MI_GLOSSARY_CATEGORY,
    'description' => _MI_GLOSSARY_CATEGORY_DSC ,
    'link'        => 'admin/index.php?action=CategoryList' ,
    'keywords'    => '',
    'show'        => $showCategory
) ;

?>
