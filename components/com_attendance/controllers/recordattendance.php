<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import Joomla controlleradmin library
jimport ( 'joomla.application.component.controlleradmin' );

/**
 * Unknown Responses Controller
 */
class attendanceControllerRecordAttendance extends JControllerAdmin {
	protected $text_prefix = 'COM_ATTENDANCE_RECORD_ATTENDANCE';
	/**
	 * Proxy for getModel.
	 * @since 2.5
	 */
	protected $view_list = 'CountResponses';

	public function getModel($name = 'RecordAttendance', $prefix = 'attendanceModel') {
		$model = parent::getModel ( $name, $prefix, array (
				'ignore_request' => true
		) );
		return $model;
	}

	public function save() {
		$jinput = JFactory::getApplication ()->input;
		$submitted_data = $jinput->get ( 'jform', Array (), 'array' );
		$att_status = $jinput->get ( 'att_status', Array (), 'array' );
		$event_id = $jinput->get ( 'event_id', 0, 'int' );
		$user_id = $jinput->get ( 'user_id', Array (), 'array' );
		$time_arrived = $jinput->get ( 'time_arrived', Array (), 'array' );
		$insert = Array ();
		foreach ( $att_status as $key => $val ) {
			$insert [] = $event_id . ', ' . $user_id [$key] . ', \'' . $event_id . '_' . $user_id [$key] . '\', \'' . $time_arrived [$key] . '\', ' . $att_status [$key];
		}
		$insert = implode ( '), (', $insert ) ;
		// echo ($insert);
		// Store the group data if the user data was saved.
		// Delete the old attendance records
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		$query->delete ();
		$query->from ( $db->quoteName ( '#__sched_attendance_records' ) );
		$query->where ( $db->quoteName ( 'event_id' ) . ' = ' . ( int ) $event_id );
		$db->setQuery ( $query );
		$db->execute ();
		// Check for a database error.
		if ($db->getErrorNum ()) {
			$this->setError ( $db->getErrorMsg () );
			return false;
		}
		// Set the new user group maps.
		$query->clear ();
		$query->insert ( $db->quoteName ( '#__sched_attendance_records' ) );
		$query->columns ( array (
				$db->quoteName ( 'event_id' ),
				$db->quoteName ( 'user_id' ),
				$db->quoteName ( 'event_user' ),
				$db->quoteName ( 'time_arrived' ),
				$db->quoteName ( 'attended_status' )
		) );
		$query->values ( $insert );
		$db->setQuery ( $query );
// 		echo((string)$db->getQuery());
		$db->execute ();
		// Check for a database error.
		if ($db->getErrorNum ()) {
			$this->setError ( $db->getErrorMsg () );
			return false;
		}
$view = $this->getView ('countResponses', 'html', 'attendanceView' );
		$model = $this->getModel ( 'countResponses', 'attendanceModel', array () );
		$model->setState ('list.groupby','event_date');
		$view->setModel ( $model, true );
		$view->display ();

		// parent::save($data);
	}
}