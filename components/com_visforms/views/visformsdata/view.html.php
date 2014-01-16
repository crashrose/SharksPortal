<?php
/**
 * Visformsdata view for Visforms
 *
 * @author       Aicha Vack
 * @see           visforms is extended and rivised adaptation of ckforms from cookex (http://www.cookex.eu) for Joomla 2.5
 * @package      Joomla.Site
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */
 
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport( 'joomla.application.component.view');
jimport( 'joomla.html.parameter' );


/**
 * Visdata view class for Visforms
 *
 * @package      Joomla.Site
 * @subpackage   com_visforms
 *
 * @since        Joomla 1.6 
 */
class VisformsViewVisformsdata extends JView
{
	protected $form;
	protected $items;
	protected $state;
	
	function display($tpl = null)
	{	
		/* get params from menu */
		$menu_params = $this->get('Menuparams');
		$this->assignRef('menu_params', $menu_params);
		
		if ($menu_params->get('menu-meta_description'))
		{
			$this->document->setDescription($menu_params->get('menu-meta_description'));
		}

		if ($menu_params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $menu_params->get('menu-meta_keywords'));
		}
		
		if ($show_tableborder = $menu_params->get('show_tableborder'))
		{
			$this->assignRef('show_tableborder', $show_tableborder);
		}
		
		if ($show_columnheader = $menu_params->get('show_columnheader'))
		{
			$this->assignRef('show_columnheader', $show_columnheader);
		}
				
		
		//get Item id
		$itemid = JRequest::getCmd('Itemid','-1');
		$this->assignRef('itemid' , $itemid);
		
		//get form id
		$id = JRequest::getVar('id','-1');
		$this->assignRef('id' , $id);

		if ($this->_layout == "detail")
		{

			// Get data from the model
			$item = $this->get('Detail');	
			$this->assignRef('item',$item);
		} 
		
		// Get data from the model
		$this->form	= $this->get('Form');
		$this->items = $this->get('Items');
		$this->state = $this->get('State');
		
		$pagination = $this->get('Pagination');	
		$this->assignRef('pagination', $pagination);
		
		$fields = $this->get('Datafields');
		$this->assignRef('fields',$fields);
		
		parent::display($tpl);
		
	}
}
?>