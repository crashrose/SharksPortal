<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
 JTable::addIncludePath ( JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_attendance' . DS . 'tables' );
 
/**
 * Attendance Event Model
 */
class attendanceModelApprovalForm extends JModelAdmin
{
        /**
         * Returns a reference to the a Table object, always creating it.
         *
         * @param       type    The table type to instantiate
         * @param       string  A prefix for the table class name. Optional.
         * @param       array   Configuration array for model. Optional.
         * @return      JTable  A database object
         * @since       2.5
         */
	public function getTable($type = 'Responses', $prefix = 'attendanceTable', $config = array())
	{
		$table = JTable::getInstance($type, $prefix, $config);
        		return $table;
	}
	/**
	 * Method to get the record form.
	 *
	 * @param       array   $data           Data for the form.
	 * @param       boolean $loadData       True if the form is to load its own data (default case), false if not.
	 * @return      mixed   A JForm object on success, false on failure
	 * @since       2.5
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_attendance.approvalform', 'approvalform', array('control' => 'jform', 'load_data' => $loadData));

		if (empty($form))
		{
			return false;
		}
		return $form;
	}
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return      mixed   The data for the form.
	 * @since       2.5
	 */
	public function loadFormData()
	{		
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_attendance.edit.approvalform.data', array());
		if (empty($data))
		{
			$data = $this->getItem();
		}
		return $data;
	}
	

}
