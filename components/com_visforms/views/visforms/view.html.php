<?php
/**
 * Visforms view for Visforms
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
jimport( 'joomla.html.parameter');
JHTML::_('behavior.tooltip');

/**
 * Visforms View class
 *
 * @package		Joomla.Site
 * @subpackage	com_visforms
 * @since		1.6
 */
class VisformsViewVisforms extends JView
{
	function display($tpl = null)
	{	
		/* get params from menu */
		$menu_params = $this->get('menuparams');
		
		/* get data from database */
		$visforms = $this->get('Data');
		
		
		$post = JRequest::get('post', JREQUEST_ALLOWHTML);
		$this->assignRef( 'post',$post );
		

	
		$this->assignRef( 'visforms',$visforms );
		$this->assignRef('menu_params', $menu_params);
		
		$formLink = "index.php?option=com_visforms&view=visforms&task=send&id=".$visforms->id;				
		$this->assignRef( 'formLink',$formLink );
	

		$document = JFactory::getDocument();
		
		// Set metadata Description and Keywords - we could use $this->document instead of $document
		
		if ($this->menu_params->get('menu-meta_description'))
		{
			$document->setDescription($this->menu_params->get('menu-meta_description'));
		}

		if ($this->menu_params->get('menu-meta_keywords'))
		{
			$document->setMetadata('keywords', $this->menu_params->get('menu-meta_keywords'));
		}
		
		/* Add css and js links*/
		
		$document->addCustomTag('<script type="text/javascript" src="'.JURI::root(true).'/media/com_visforms/js/formcheck.js"></script>');
		$document->addStyleSheet(JURI::root(true).'/media/com_visforms/css/visforms.css');
		$document->addStyleSheet(JURI::root(true).'/media/com_visforms/js/theme/classic/formcheck.css');
		
		parent::display($tpl);
		
	}

}
?>
