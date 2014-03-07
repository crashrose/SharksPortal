<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modeladmin');
/**
 * attendance Model
 */
class attendanceModelResponseDetails extends JModelLegacy {
	protected $searchInFields = array('item_id', 'item_order', 'item_status', 'reason', 'details', 'approval_status', 'rsvp_yes', 'rsvp_no', 'rsvp_unsure', 'rsvp_none');
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return string An SQL query
	 */
	public function getItem() {
		// Create a new query object.
		$app = JFactory::getApplication();
		$jinput = JFactory::getApplication() -> input;
		$item_id = $jinput -> get('id', '', 'string');
		$event_user = $jinput -> get('event_user', '', 'string');
		list($event, $user) = explode("_", $event_user);

		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db -> getQuery(true);
		// Select some fields
		$query -> select('event.event_name, type.event_type_name as event_type, event.event_date
						, IF (time_val = \'TBD\', concat(date_format(event.event_date,\'%c/%e/%y\'), \' TBD\'), date_format(concat(event.event_date, \' \', time.time_val),\'%c/%e/%y %l:%i %p\')) as event_dt
                		, time.time_val as event_time, event.id as event_id
						, loc.loc_name, loc.loc_address_1, loc.loc_address_2, loc.loc_city, loc.loc_state
                		, loc.loc_zip, loc.loc_note, loc.loc_website, loc.loc_maplink, event.event_respond_by');
			$query -> from('#__sched_events event');
			$query -> join('INNER', '#__sched_times time on event.event_time = time.id');
			$query -> join('INNER', '#__sched_locations loc on event.event_location = loc.id');
			$query -> join('INNER', '#__sched_event_types type on event.event_type = type.id');
		if ($item_id != '') {
			$query -> select('response.rsvp_review_status, response.rsvp_date_reviewed, review_status.review_status_name
    					, (Case
							when response.rsvp_status = \'-1\'
							then \'Unsure\'
							when response.rsvp_status = \'0\'
							then \'No\'
							when response.rsvp_status = \'1\'
							then \'Yes\'
							else \'No Answer\'
						End) as rsvp_eng_status
						, response.rsvp_reason, response.rsvp_status, response.rsvp_date_submitted, reason.reason_name
						, user.name as user_name, user.id as user_id, event_user, response.id as rsvp_id
                		, response.rsvp_details	, review_user.name as reviewed_by');
			$query -> join('INNER', '#__sched_responses response on response.rsvp_event = event.id');
			$query -> join('LEFT OUTER', '#__sched_rsvp_reasons reason on reason.id = response.rsvp_reason');
			$query -> join('INNER', '#__users user on response.rsvp_user = user.id');
			$query -> join('LEFT OUTER', '#__users review_user on user.id = response.rsvp_reviewed_by_user');
			$query -> join('LEFT OUTER', '#__sched_review_statuses review_status on response.rsvp_review_status = review_status.id');
			$query -> where(' response.event_user = \'' . $event_user . '\' and response.rsvp_active = 1 ');
		} else {
			$query -> select('\'' . $user . '\' as user_id, \'' . JFactory::getUser($user)->name . '\' as user_name
		, \'No Answer\' as rsvp_eng_status, \'\' as rsvp_status, \'' . $event_user . '\' as event_user'
		);
			$query -> where(' event.id = \'' . $event . '\' ');
		}
		$db -> setQuery($query);
		$data = $db -> loadAssoc();
		$item = JArrayHelper::toObject($data, 'JObject');
		return $item;
	}

	protected function populateState($ordering = null, $direction = null) {
		// Initialise variables.
		$app = JFactory::getApplication();
		$jinput = JFactory::getApplication() -> input;
		//dumpTrace( $jinput);
		// Load the filter state.
		//Set filter type and group type (group type is inverse of filter)
		$state = $jinput -> get('id', '', 'string');
		$this -> setState('filter.item_id', $state);

		$state = $jinput -> get('event_user', '', 'string');
		$this -> setState('filter.event_user', $state);

		//Set filter type and group type (group type is inverse of filter)
		$state = $jinput -> get('filter_type', '', 'string');
		$this -> setState('filter.filter_type', $state);
		$state = $state == 'user' ? 'event' : 'user';
		$this -> setState('list.item_type', $state);
		//Set filter val
		$state = $jinput -> get('filter_id', '', 'string');
		$this -> setState('filter.filter_id', $state);

		$state = $jinput -> get('list_view', '', 'string');
		$this -> setState('list.list_view', $state);

		// Takes care of states: list. limit / start / ordering / direction
		parent::populateState('item_id', 'asc');
	}

}
