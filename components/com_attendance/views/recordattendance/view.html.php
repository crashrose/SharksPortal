<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );

// import Joomla view library
jimport ( 'joomla.application.component.view' );
require_once dirname ( __FILE__ ) . '/../../helpers/attendance.php';
/**
 * Attendance Record Attendance
 */
class attendanceViewRecordAttendance extends JViewLegacy {

	/**
	 * display method of event view
	 *
	 * @return void
	 */
	public function display($tpl = null) {

		$this->setLayout ( '_:edit' );
		$input = new JInput ();
		$app = JFactory::getApplication ();

		$this->pagination       = $this->get('Pagination');
		$model = $this->getModel ( 'recordAttendance', '', array () );

		$this->model = $model;

		// // get the Data
		$items = $this->get ( 'Items' );
		$pagination = $this->get('Pagination');

		// Check for errors.
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JError::raiseError ( 500, implode ( '<br />', $errors ) );
			return false;
		}
		// Assign the Data
		$this->items = $items;
		$this->pagination = $pagination;
		$this->event_id = $items[0]->event_id;
		$this->event_type = $items[0]->event_type;
		$this->event_datetime = $items[0]->event_datetime;


		// Display the template
		parent::display ( $tpl );
	}
	protected function setDocument() {
		$document = JFactory::getDocument ();
		$document->setTitle ( JText::_ ( 'COM_ATTENDANCE_RECORD_ATTENDANCE' ) );
	}
}