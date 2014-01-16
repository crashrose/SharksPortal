<?php
/**
 * vistools model for Visforms
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

jimport( 'joomla.application.component.modelform' );

/**
 * vistools Model
 *
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @since        Joomla 1.6 
 */
class VisformsModelVistools extends JModelForm
{
	/*
	 * Constructor
	 *
	 * @return void
	 * @since Joomla 1.6
	 */
	function __construct()
	{
		parent::__construct();

		//$this->setId((int)JRequest::getVar('fid',  0));		
	}
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		jimport('joomla.filesystem.file');

		$app = JFactory::getApplication('administrator');

		// Load the User state.
		$id = $app->getUserState('com_visforms.edit.css.id');

		// Parse the component id out of the compound reference.
		$css = explode(':', base64_decode($id));
		$this->setState('extension.id', (int) array_shift($css));

		$fileName = array_shift($css);
		$this->setState('filename', $fileName);
		$this->setState('.data', null);

		// Save the syntax for later use
		$app->setUserState('editor.source.syntax', JFile::getExt($fileName));

	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_visforms.vistools', 'vistools', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_visforms.edit.css.data', array());
		if (empty($data)) {
			$data = $this->getCss();
		}

		return $data;
	}

	/**
	 * Method to get the css file
	 *
	 * @return	mixed	Object on success, false on failure.
	 * @since	1.6
	 */
	function getCss()
	{
		$css = new StdClass;
		
		$fileName	= $this->getState('filename');
		$csspath = JPATH_SITE . DS . 'media' . DS . 'com_visforms' . DS . 'css' . DS . 'visforms.css';
		
		if (file_exists($csspath)) 
		{
			jimport('joomla.filesystem.file');
			$css->extension_id	= $this->getState('extension.id');
			$css->filename		= $this->getState('filename');
			$css->content = JFile::read($csspath);

			if ($css->content !== false)
			{
				$css->content = htmlspecialchars($css->content, ENT_COMPAT, 'UTF-8');
			}
		}
		else 
		{
			$this->setError(JText::_('COM_VISFORMS_FILE_NOT_FOUND'));
		}

		return $css;
	}
	
	/**
	 * Method to retrieve the component Id
	 *
	 * @return int $id
	 * @since Joomla 1.6
	 *
	 */
	
	public function getComponentId() 
	{
		//Initialise Variables
		$db		= $this->getDbo();
		$query	= $db->getQuery(true);

		// Select the required field from the table.
		$query->select('a.extension_id');
		$query->from($db->quoteName('#__extensions').' AS a');

		// Filter by extension type.
		$query->where($db->quoteName('type').' = '.$db->quote('component') . ' and ' . $db->quoteName('name').' = '.$db->quote('visforms'));
		$db->setQuery($query);
		if (!$id = $db->loadResult())
		{
			return false;
		}
		
		return $id;
	
	}
	
	/**
	 * Method to store the source file contents.
	 *
	 * @param	array	$data The souce data to save.
	 *
	 * @return	boolean	True on success, false otherwise and internal error set.
	 * @since	1.6
	 */
	public function save($data)
	{
		jimport('joomla.filesystem.file');
		
		// Initialize some variables
		
		$fileName	= $this->getState('filename');
		$filePath	= JPATH_SITE . DS . 'media' . DS . 'com_visforms' . DS . 'css' . DS . $fileName;
		
		// Include the extension plugins for the save events.
		JPluginHelper::importPlugin('extension');

		// Set FTP credentials, if given.
		JClientHelper::setCredentialsFromRequest('ftp');
		$ftp = JClientHelper::getCredentials('ftp');

		// Try to make the template file writeable.
		if (!$ftp['enabled'] && JPath::isOwner($filePath) && !JPath::setPermissions($filePath, '0644')) {
			$this->setError(JText::_('COM_TEMPLATES_ERROR_SOURCE_FILE_NOT_WRITABLE'));
			return false;
		}

		// Trigger the onExtensionBeforeSave event.
		if (in_array(false, $result, true)) {
			$this->setError($table->getError());
			return false;
		}

		$return = JFile::write($filePath, $data['content']);  

		// Try to make the template file unwriteable.
		if (!$ftp['enabled'] && JPath::isOwner($filePath) && !JPath::setPermissions($filePath, '0444')) {
			$this->setError(JText::_('COM_TEMPLATES_ERROR_SOURCE_FILE_NOT_UNWRITABLE'));
			return false;
		} elseif (!$return) {
			$this->setError(JText::sprintf('COM_TEMPLATES_ERROR_FAILED_TO_SAVE_FILENAME', $fileName));
			return false;
		}

		return true;
	}
	
}
