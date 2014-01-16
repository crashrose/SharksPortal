<?php
/**
 * Visforms view for Visforms
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
 * visforms View
 *
 * @package    Joomla.Administratoar
 * @subpackage com_visforms
 * @since      Joomla 1.6
 */
class VisformsViewVisforms extends JView
{
	protected $form;
	protected $items;
	protected $state;
	
	/**
	 * visforms view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		

		// Get data from the model
		$this->form	= $this->get('Form');
		$this->items = $this->get('Items');
		$this->state = $this->get('State');
		
		//$items = $this->get( 'Data');
		$pagination = $this->get('Pagination');


		$this->assignRef('pagination', $pagination);
		
		// We don't need toolbar in the modal window.
		if (($this->getLayout() !== 'modal') && ($this->getLayout() !== 'modal_data')) {
			$this->addToolbar();
		}
		
		parent::display($tpl);
	}
	
	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		$doc = JFactory::getDocument();
		$css = '.icon-48-visform {background:url(../administrator/components/com_visforms/images/logo-banner.png) no-repeat;}';
   		$doc->addStyleDeclaration($css);
		$doc->addStyleSheet(JURI::root(true).'/administrator/components/com_visforms/css/visforms_min.css');

		JToolBarHelper::title(JText::_( 'COM_VISFORMS' ), 'visform' );
		JToolBarHelper::publishList('visforms.publish');
		JToolBarHelper::unpublishList('visforms.unpublish');
		JToolBarHelper::deleteList('COM_VISFORMS_DELETE_FORM_TRUE', 'visforms.remove', 'COM_VISFORMS_DELETE');
		JToolBarHelper::editListX('visform.edit');
		JToolBarHelper::addNewX('visform.add');
		JToolBarHelper::custom('visforms.duplicate','publish.png','publish.png',JText::_( 'COM_VISFORMS_DUBLICATE' ),true) ;
		JToolBarHelper::custom( 'visforms.edit_css', 'css.png', 'css_f2.png', JText::_('COM_VISFORMS_EDIT_CSS'), false, false );
	}
}
