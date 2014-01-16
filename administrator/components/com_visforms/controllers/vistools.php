<?php
/**
 * vistools controller for Visforms
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

jimport( 'joomla.application.component.controller' );

/**
 * vistools Controller
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @since        Joomla 1.6 
 */
class VisformsControllerVistools extends JController
{
	/**
	 * constructor (Register some extra tasks)
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function __construct()
	{	
		parent::__construct();
		
		$this->registerTask('apply', 'save');
				
	}

	/**
	 * display the visforms CSS
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function editCSS()
	{	
		// Initialise variables.
		$app = JFactory::getApplication();
		$context = 'com_visforms.edit.css';		
		$model = $this->getModel('vistools');
		$id = $model->getComponentId();
		$name = 'visforms.css';
		$recordId = urlencode(base64_encode($id.':'.$name));

		// Check-out succeeded, push the new record id into the session.
		$app->setUserState($context.'.id',	$recordId);
		$app->setUserState($context.'.data', null);
		$this->setRedirect("index.php?option=com_visforms&view=vistools&layout=css");
	}

	/**
	 * Save visforms CSS
	 *
	 * @return void
	  * @since Joomla 1.6
	 **/
	function save()
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		// Initialise variables.
		$app		= JFactory::getApplication();
		$data['extension_id'] = JRequest::getVar('id', int, 'post', 0);
		$data['filename'] = JRequest::getVar('filename', string, 'post', '');
		$data['content'] = JRequest::getVar('viscss', '', 'post', 'string', JREQUEST_ALLOWRAW);
		$context	= 'com_visforms.edit.css';
		$task		= $this->getTask();
		$model		= $this->getModel('vistools');
		
		// Match the stored id's with the submitted.
		if (empty($data['extension_id']) || empty($data['filename'])) {
			return JError::raiseError(500, JText::_('COM_VISFORMS_ERROR_SOURCE_ID_FILENAME_MISMATCH'));
		}
		elseif ($data['extension_id'] != $model->getState('extension.id')) {
			return JError::raiseError(500, JText::_('COM_VISFORMS_ERROR_SOURCE_ID_FILENAME_MISMATCH'));
		}
		elseif ($data['filename'] != $model->getState('filename')) {
			return JError::raiseError(500, JText::_('COM_VISFORMS_ERROR_SOURCE_ID_FILENAME_MISMATCH'));
		}
		
		// Attempt to save the data.
		if (!$model->save($data))
		{
			// Save the data in the session.
			$app->setUserState($context.'.data', $data);

			// Redirect back to the edit screen.
			$this->setMessage(JText::sprintf('JERROR_SAVE_FAILED', $model->getError()), 'warning');
			$this->setRedirect(JRoute::_('index.php?option=com_visforms&view=vistools&layout=css', false));
			return false;
		}
		$this->setMessage(JText::_('COM_VISFORMS_FILE_SAVED'));
		
		// Redirect the user and adjust session state based on the chosen task.
		switch ($task)
		{
			case 'apply':
				// Reset the record data in the session.
				$app->setUserState($context.'.data',	null);

				// Redirect back to the edit screen.
				$this->setRedirect(JRoute::_('index.php?option=com_visforms&view=vistools&layout=css', false));
				break;

			default:
				// Clear the record id and data from the session.
				$app->setUserState($context.'.id', null);
				$app->setUserState($context.'.data', null);

				// Redirect to the list screen.
				$this->setRedirect(JRoute::_('index.php?option=com_visforms', false));
				break;
		}
	}	
}
?>
