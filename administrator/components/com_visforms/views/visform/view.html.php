<?php
/**
 * Visform view for Visforms
 *
 * @author       Aicha Vack
 * @see           visforms is extended and rivised adaptation of ckforms from cookex (http://www.cookex.eu) for Joomla 2.5
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */

// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * visform view to show a singl field
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @since        Joomla 1.6 
 */
class VisformsViewVisform extends JView
{
	/**
	 * Visform view display method
	 *
	 * @return void
	 **/
	function display($tpl = null)
	{
		$visforms = $this->get('Data');
		$isNew = ($visforms->id < 1);
		
		$document = JFactory::getDocument();
		$css = '.icon-48-visform {background:url(../administrator/components/com_visforms/images/logo-banner.png) no-repeat;}';
   		$document->addStyleDeclaration($css);
	
		$text = $isNew ? JText::_( 'COM_VISFORMS_NEW' ) : JText::_( 'COM_VISFORMS_EDIT' );
		JToolBarHelper::title(JText::_( 'COM_VISFORMS' ).': <small><small>[ ' . $text.' ]</small></small>' , 'visform' );
		
		JToolBarHelper::save('visform.save');
		JToolBarHelper::apply('visform.apply');
		if ($isNew)  {
			JToolBarHelper::cancel('visform.cancel');
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'visform.cancel', 'COM_VISFORMS_CLOSE' );
		}

		JToolBarHelper::divider();
		JToolBarHelper::custom('visform.fields','edit.png','edit.png','COM_VISFORMS_FIELDS',false) ;
		
		JRequest::setVar( 'hidemainmenu', 1 );
		
		
		//$document->addScript(JURI::root(true).'/media/com_visforms/js/mootabs.js');

		$document->addStyleSheet(JURI::root(true).'/administrator/components/com_visforms/css/mootabs.css');
		$document->addStyleSheet(JURI::root(true).'/administrator/components/com_visforms/css/visforms.css');
		
		$this->assignRef('visforms',$visforms);
		
		parent::display($tpl);
	}
}
