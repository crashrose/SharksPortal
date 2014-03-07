<?php
// No direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import Joomla table library
jimport ( 'joomla.database.table' );

/**
 * Attendance class
 */
class attendanceTableattendance extends JTable {

	/**
	 * Constructor
	 * @param object Database connector object
	 */
	function __construct(&$db) {
		parent::__construct ( '#__sched_views', 'id', $db );
	}
}