<?php
/**
 * @author       Aicha Vack
 * @see          visforms is extended and rivised adaptation of ckforms from cookex (http://www.cookex.eu) for Joomla 2.5
 * @package     Joomla.Administrator
 * @subpackage  com_content
 * @link         http://www.vi-solutions.de
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controllerform');

/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 * @since       1.6
 */
class VisformsControllerVisfield extends JControllerForm
{
	/**
	 * Class constructor.
	 *
	 * @param   array  $config  A named array of configuration variables.
	 *
	 * @since	1.6
	 */
	function __construct($config = array())
	{

		parent::__construct($config);
		
		// Register Extra tasks
		$this->registerTask('add', 'edit');
		$this->registerTask('apply', 'save');
	}
	
	/**
	 * display the edit form
	 *
	 * @return void
	 *
	 * @since Joomla 1.6 
	 */
	function edit($key = 'fid', $urlVar = null)
	{					
		$cid = JRequest::getVar('cid', 0);
		if (is_array($cid)) 
		{
			$cid = $cid[0];
		}
		$fid = JRequest::getVar('fid', -1);
		
		$this->setRedirect(JRoute::_('index.php?option=com_visforms&view=visfield&layout=visfield_tpl&cid[]=' . $cid. '&fid=' . $fid, false));

	}

	/**
	 * save a record (and redirect to main page)
	 *
	 * @return void
	 *
	 * @since Joomla 1.6 
	 */
	public function save($key = 'fid', $urlVar = null)
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$model = $this->getModel('visfield');
		$fid = JRequest::getVar( 'fid', -1 );
		
		if ($model->store($post)) {
			$msg = JText::_( 'COM_VISFORMS_FIELD_SAVED' )." !";
		} else {
			$msg = JText::_( 'COM_VISFORMS_FIELD_SAVED_ERROR' );
		}

		$task = $this->getTask();
		
		switch ($task)
		{
			case 'apply':
			// if we have a new field that is stored for the first time, the field id is set during the storation process. We use $model->getId() to get the right id
				$link = 'index.php?option=com_visforms&task=visfield.edit&cid[]='.$model->getId().'&fid='.$fid;
				break;

			case 'save':
			default:
				$link = 'index.php?option=com_visforms&view=visfields&fid='.$fid;
				break;
		}
		
		$this->setRedirect($link, $msg);
		return true;
	}
	
	/**
	 * cancel editing a record
	 *
	 * @return void
	 *
	 * @since Joomla 1.6 
	 */
	public function cancel($key = 'fid')
	{
		// Check for request forgeries
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		
		$msg = JText::_( 'COM_VISFORMS_OPERATION_CANCELED' );
		$fid = JRequest::getVar( 'fid', -1 );
		
		$this->setRedirect( 'index.php?option=com_visforms&view=visfields&fid='. $fid, $msg );
		return true;
	}
}
