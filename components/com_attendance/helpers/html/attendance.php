<?php
/**
 * @package     Joomla
 * @subpackage  com_attendance
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined ( 'JPATH_BASE' ) or die ();
abstract class JHtmlAttendance {
	public static function RSVP_reason($event_id, $user_id) {
		// Create the batch selector to change the client on a selection list.
		$lines = array (
				'<select name="status_' . $event_id . '_' . $user_id . '" class="inputbox" id="status_' . $event_id . '_' . $user_id . '">',
				JHtml::_ ( 'select.options', self::statuslist (), 'value', 'status' ),
				'</select>' 
		);
		
		return implode ( "\n", $lines );
	}
	public static function statuslist() {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
		
		$query->select ( 'id As value, status_name as status' );
		$query->from ( '#__sched_rsvp_statuses' );
		$query->order ( 'status' );
		
		// Get the options.
		$db->setQuery ( $query );
		
		$options = $db->loadObjectList ();
		
		// Check for a database error.
		if ($db->getErrorNum ()) {
			JError::raiseWarning ( 500, $db->getErrorMsg () );
		}
		
		return $options;
	}
	public static function eventdatelist() {
		$db = JFactory::getDbo ();
		$query = $db->getQuery ( true );
	
		$query->select ( 'event_date As date' );
		$query->from ( '#__sched_events' );
		$query->order ( 'date' );
	
		// Get the options.
		$db->setQuery ( $query );
	
		$options = $db->loadObjectList ();
	
		// Check for a database error.
		if ($db->getErrorNum ()) {
			JError::raiseWarning ( 500, $db->getErrorMsg () );
		}
	
		return $options;
	}
}