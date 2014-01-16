<?php
/**
 * visdforms controller for Visforms
 *
 * @author       Aicha Vack
* @see           visforms is extended and rivised adaptation of ckforms from cookex (http://www.cookex.eu) for Joomla 2.5 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */

// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controllerform');

/**
 * visforms Controller
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @since        Joomla 1.6 
 */
class VisformsControllerVisform extends JControllerForm
{
	/**
	 * constructor (registers additional tasks to methods)
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask('add', 'edit');
		$this->registerTask('apply', 'save');
	}
	
	/**
	 * display the edit form
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function edit($key = null, $urlVar = null)
	{
		$cid = JRequest::getVar('cid', 0);
		if (is_array($cid)) 
		{
			$cid = $cid[0];
		}
		
		$this->setRedirect(JRoute::_('index.php?option=com_visforms&view=visform&layout=form&cid[]=' . $cid, false));
	}

	/**
	 * save a record (and redirect to main page)
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function save($key = null, $urlVar = null)
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$model = $this->getModel('visform');
		if ($model->store()) {
			$msg = JText::_( 'COM_VISFORMS_FORM_SAVED' )." !";
		} else {
			$msg = JText::_( 'COM_VISFORMS_FORM_SAVED_ERROR' );
		}

		$task = $this->getTask();
		
		switch ($task)
		{
			case 'apply':
				$link = 'index.php?option=com_visforms&task=visform.edit&cid[]='. $model->getId() ;
				break;

			case 'save':
			default:
				$link = 'index.php?option=com_visforms';
				break;
		}
		
		$this->setRedirect($link, $msg);
		return true;
	}

	/**
	 * cancel editing a record
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function cancel($key = null)
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$msg = JText::_( 'COM_VISFORMS_OPERATION_CANCELED' );
		$this->setRedirect( 'index.php?option=com_visforms', $msg );
		return true;
	}
	
	
	/**
	 * display the fields list for the selected form
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function fields()
	{
		$fid = JRequest::getVar( 'id', -1);
		$this->setRedirect( "index.php?option=com_visforms&view=visfields&fid=".$fid, $msg );
		return true;
	}	
	
}
?>
