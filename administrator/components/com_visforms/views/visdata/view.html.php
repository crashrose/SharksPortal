<?php
/**
 * Visdata view for Visforms
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
 * Dataview to show data of a single form
 *
 * @package		Joomla.Administrator
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsViewVisdata extends JView
{
	protected $form;
	protected $items;
	protected $state;
	
	
	/**
	 * Visdata view display method
	 *
	 * @return void
	 **/
	function display($tpl = null)
	{
		
		
		if ($this->_layout == "detail")
		{
			$this->addTitle();
			JToolBarHelper::back('COM_VISFORMS_DATA_LIST');

			// Get data from the model
			$item = $this->get('Detail');
			
			$this->assignRef('item',$item);

		} else {
			// We don't need toolbar and title in the modal window.
			if ($this->getLayout() !== 'modal') {
				$this->addTitle();
				$this->addToolbar();
			}
	
			// Get data from the model
			$this->form	= $this->get('Form');
			$this->items = $this->get('Items');
			$this->state = $this->get('State');
			$pagination = $this->get('Pagination');		

			$this->assignRef('pagination', $pagination);


		}
		
		$fields = $this->get('Datafields');
		$this->assignRef('fields',$fields);

		parent::display($tpl);
	}
	
	/**
	 * Add the page toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{	
		JToolBarHelper::publishList('visdata.publish');
		JToolBarHelper::unpublishList('visdata.unpublish');
		JToolBarHelper::custom('visdata.export','export.png','export.png','Export',false) ;
		JToolBarHelper::deleteList('COM_VISFORMS_DELETE_DATASET_TRUE','visdata.remove', 'COM_VISFORMS_DELETE');
		JToolBarHelper::back('Forms','index.php?option=com_visforms');
	}
	
	/**
	 * Add the page title.
	 *
	 * @since	1.6
	 */
	protected function addTitle()
	{
		$doc = JFactory::getDocument();
		$css = '.icon-48-visform {background:url(../administrator/components/com_visforms/images/logo-banner.png) no-repeat;}';
   		$doc->addStyleDeclaration($css);
		$doc->addStyleSheet(JURI::root(true).'/administrator/components/com_visforms/css/visforms_min.css');	
		JToolBarHelper::title(JText::_( 'COM_VISFORMS_VISFORM_DATA' ), 'visform' );
	}
}
