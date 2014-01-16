<?php
/**
 * Vistools view for Visforms
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
 * ckfield View
 *
 * @package    CK.Joomla
 * @subpackage Components
 */
class VisformsViewVistools extends JView
{
	protected $form;
	protected $state;
	
	
	/**
	 * display method of ckfield view
	 * @return void
	 **/
	function display($tpl = null)
	{
		
		$doc = JFactory::getDocument();
		$css = '.icon-48-visform {background:url(../administrator/components/com_visforms/images/logo-banner.png) no-repeat;}';
   		$doc->addStyleDeclaration($css);
		$doc->addStyleSheet(JURI::root(true).'/administrator/components/com_visforms/css/visforms_min.css');

		JToolBarHelper::title(JText::_('COM_VISFORMS_EDIT_CSS_BUTTON_TEXT'), 'visform');
		JToolBarHelper::apply('vistools.apply');
		JToolBarHelper::save('vistools.save');

		$css = $this->get('Css');
		$this->assignRef('css',$css);
		// Get data from the model
		$this->form	= $this->get('Form');
		$this->state = $this->get('State');	
			
		
					
		JToolBarHelper::cancel('cancel', 'Close');

		JRequest::setVar('hidemainmenu', 1);
		
		parent::display($tpl);
	}
}
