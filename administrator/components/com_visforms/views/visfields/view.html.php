<?php
/**
 * Visfields view for Visforms
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
 * visfields View
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 *
 * @since        Joomla 1.6 
 */
class VisformsViewVisfields extends JView
{
	protected $form;
	protected $items;
	protected $state;
	
	/**
	 * visfields view display method
	 * @return void
	 * @since Joomla 1.6
	 **/
	function display($tpl = null)
	{
		$document = JFactory::getDocument();
		$css = '.icon-48-visform {background:url(../administrator/components/com_visforms/images/logo-banner.png) no-repeat;}';
   		$document->addStyleDeclaration($css);

		
		$document->addStyleSheet(JURI::root(true).'/administrator/components/com_visforms/css/visforms_min.css');
	
		JToolBarHelper::title(JText::_( 'COM_VISFORMS_VISFORM_FIELDS' ), 'visform' );
		JToolBarHelper::publishList('visfields.publish');
		JToolBarHelper::unpublishList('visfields.unpublish');
		JToolBarHelper::deleteList('COM_VISFORMS_DELETE_FORM_TRUE', 'visfields.remove', 'COM_VISFORMS_DELETE');
		JToolBarHelper::editListX('visfield.edit');
		JToolBarHelper::addNewX('visfield.add');
		JToolBarHelper::custom('visfields.duplicate','publish.png','publish.png',JText::_( 'COM_VISFORMS_DUBLICATE' ),true) ;
		JToolBarHelper::divider();
		JToolBarHelper::back('Forms','index.php?option=com_visforms');

		// Get data from the model
		$this->form	= $this->get('Form');
		$this->items = $this->get('Items');
		$this->state = $this->get('State');
		$pagination = $this->get('Pagination');

		$this->assignRef('pagination', $pagination);

		parent::display($tpl);
	}
}
