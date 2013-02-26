<?php
//echo "-----<br />";
//echo $echo ."<br />";

/*=====================================================================
  (C)2007 BeaBo Japan by Hiroki Seike
  http://beabo.net/
=====================================================================*/
require '../../mainfile.php';
require XOOPS_MODULE_PATH.'/glossary/class/ActionFrame.class.php';

$root =& XCube_Root::getSingleton();
$root->mController->executeHeader();

$actionName = isset($_GET['action']) ? trim($_GET['action']) : 'index';

$glossary = new Glossary_ActionFrame(false);
$glossary->setActionName($actionName);

$root->mController->mExecute->add(array(&$glossary, 'execute'));

$root->mController->execute();

//$root->mController->executeView();
$out = ob_get_contents();
$root->mController->executeView();
echo $out;


?>
