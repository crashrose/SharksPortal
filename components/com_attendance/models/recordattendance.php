<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import the Joomla modellist library
jimport ( 'joomla.application.component.modellist' );

/**
 * attendance Model
 */
class attendanceModelRecordAttendance extends JModelList {
	protected $searchInFields = array (
			'event_id'
			,'event_datetime'
			,'user_name'
	);

	public function __construct($config = array()) {
		$config ['filter_fields'] = array_merge ( $this->searchInFields );
		parent::__construct ( $config );
	}

	protected function getListQuery() {
		// Create a new query object.
		$db = JFactory::getDBO ();
		$query = $db->getQuery ( true );
		$query->select (
				'distinct event.event_name, type.event_type_name as event_type
                		, event.event_date, concat(event_date, \' \', time.time_val) as event_datetime
                		, time.time_val as event_time, event.id as event_id, user.name as user_name, att_records.attended_status
                		, concat(event.id, \'_\', user.id) as event_user, att_records.time_arrived
                		, user.id as user_id');
		$query->from ( '#__sched_events event' );
		$query->join ( 'INNER', '#__sched_event_mand_grps event_grps on event.id = event_grps.event_id' );
		$query->join ( 'INNER', '#__user_usergroup_map users_grps on event_grps.group_id = users_grps.group_id' );
		$query->join ( 'INNER', '#__users user on user.id = users_grps.user_id' );
		$query->join ( 'INNER','#__sched_times time on event.event_time = time.id');
		$query->join ( 'INNER','#__sched_event_types type on event.event_type = type.id');
		$query->join ( 'LEFT OUTER', '#__sched_responses responses on (responses.rsvp_user = user.id and responses.rsvp_event = event.id)' );
		$query->join ( 'LEFT OUTER','#__sched_attendance_records att_records on (att_records.user_id = user.id and att_records.event_id = event.id)');
		$query->join ( 'LEFT OUTER','#__sched_attendance_statuses att_statuses on att_records.attended_status = att_statuses.id');
		$query->where( ' user.block = 0 ');
		// Filter search // Extra: Search more than one fields and for multiple words
		$query->where(' event.id = ' . $this->getState ( 'filter.event_id'));
		$query->order ('user_name ASC');
		$this->setState('list.limit', 1000000);
		return $query;
	}

	protected function populateState($ordering = null, $direction = null) {
		// Initialise variables.
		$app = JFactory::getApplication ();
		$jinput = JFactory::getApplication ()->input;
		$state = $this->getUserStateFromRequest ( $this->context . '.filter.event_id', 'event_id', '', 'string' );
		$this->setState ( 'filter.event_id', $state );
		//Remove pagination
		$this->setState('list.limit', 1000000);
		parent::populateState ('event_datetime', 'asc' );

	}
}