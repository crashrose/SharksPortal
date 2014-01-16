<?php
/**
 * Default controller for Visforms
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

jimport('joomla.application.component.controller');

/**
 * Default controller class for Visforms
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 *
 * @since        Joomla 1.6 
 */

class VisformsController extends JController
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   array    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController          This object to support chaining.
	 *
	 * @since	1.6
	 */
	public function display($cachable = false, $urlparams = false)
	{	
		parent::display($cachable, $urlparams);
		return $this;
	}
}

?>
