<?php
if (!defined('XOOPS_ROOT_PATH')) exit();

require_once XOOPS_MODULE_PATH . '/glossary/class/AbstractDeleteAction.class.php';
require_once XOOPS_MODULE_PATH . '/glossary/forms/WordDeleteForm.class.php';

class Glossary_WordDeleteAction extends Glossary_AbstractDeleteAction
{
	function _getId()
	{
		return xoops_getrequest('wordid');
	}

	function &_getHandler()
	{
		$handler =& xoops_getmodulehandler('word');
		return $handler;
	}

	function _setupActionForm()
	{
		$this->mActionForm = new Glossary_WordDeleteForm();
		$this->mActionForm->prepare();
	}

	function executeViewInput(&$controller, &$xoopsUser, &$render)
	{
		$root =& XCube_Root::getSingleton();
		$textFilter =& $root->getTextFilter();    // チE��ストフィルター

		$configDesrLength     = $root->mContext->mModuleConfig['desrlength'];    // Number of the indication description
		$wordDesc = $this->mObject->get('description') ;

		// HTML tag script 除去
		$wordDesc = $textFilter->toShowTarea($wordDesc, $html=1, $smiley=1, $xcode=0, $image=1, $br=1,false);
		$wordDesc = preg_replace('!<script.*?>.*?</script.*?>!is', '', $wordDesc);
//		$wordDesc = strip_tags($wordDesc);
		if ( !XOOPS_USE_MULTIBYTES ) {
			$wordDesc = substr ( $wordDesc, 0, $configDesrLength -1 ) . "...";
		} else {
			$wordDesc = xoops_substr( $wordDesc, 0, $configDesrLength +2 );
		}

		// Bread Crubs
		$this->breadcrumbs[] = array('name' => $root->mContext->mModule->mXoopsModule->getVar('name') , 'url' => XOOPS_MODULE_URL . '/glossary/' ) ;
		$this->breadcrumbs[] = array('name' =>_MD_GLOSSARY_WORD_DELETE) ;
		$moduleHeader = '<link rel="stylesheet" type="text/css" href="' . XOOPS_MODULE_URL. '/glossary/module.css" />'."\n";

		$render->setTemplateName('glossary_word_delete.html');

		$render->setAttribute('actionForm', $this->mActionForm);
		$render->setAttribute('object', $this->mObject);

		$render->setAttribute('word_description' , $wordDesc);

		$render->setAttribute('config'  , $this->mConfig);
		$render->setAttribute('xoops_module_header',$moduleHeader);
		$render->setAttribute('xoops_breadcrumbs' ,$this->breadcrumbs) ;
	}

	function executeViewSuccess(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect('index.php', 1, _MD_GLOSSARY_WORD_DELETEED);
	}

	function executeViewError(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeRedirect('index.php', 1, _MD_GLOSSARY_WORD_DELETE_ERROR);
	}

	function executeViewCancel(&$controller, &$xoopsUser, &$render)
	{
		$controller->executeForward('index.php');
	}
}

?>
