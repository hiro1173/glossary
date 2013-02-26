<?php
require '../../mainfile.php';
require XOOPS_MODULE_PATH.'/glossary/class/ActionFrame.class.php';
$root =& XCube_Root::getSingleton();
// set header
//header( 'Content-Type:text/xml; charset=utf-8' ) ;
$glossary = new Glossary_ActionFrame(false);
$glossary->setActionName('Rss');
$root->mController->mExecute->add(array(&$glossary, 'execute'));
$root->mController->execute();
?>