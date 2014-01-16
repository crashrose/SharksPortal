<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );

// import Joomla view library
jimport ( 'joomla.application.component.view' );
require_once dirname ( __FILE__ ) . '/../../helpers/attendance.php';
/**
 * Attendance Event View
 */
class attendanceViewResponse extends JViewLegacy {
	
	/**
	 * display method of event view
	 * 
	 * @return void
	 */
	public function display($tpl = null) {
	
		$this->setLayout ( '_:edit' );
		$input = new JInput ();
		$app = JFactory::getApplication ();
		

		$model = $this->getModel ( 'response', '', array () );
		
		$this->model = $model;

		// // get the Data
		$form = $this->get ( 'Form' );
		$item = $this->get ( 'Item' );

		
		// Check for errors.
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JError::raiseError ( 500, implode ( '<br />', $errors ) );
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;
			
		$eng_vals = AttendanceHelper::getEventDetails($item->rsvp_event);
		$this->eng_vals = $eng_vals;
		
		// Display the template
		parent::display ( $tpl );
	}
	protected function setDocument() {
		$document = JFactory::getDocument ();
		$document->setTitle ( JText::_ ( 'COM_ATTENDANCE_ADMINISTRATION' ) );
	}
}