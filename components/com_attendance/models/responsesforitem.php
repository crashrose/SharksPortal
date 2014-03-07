<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import the Joomla modellist library
jimport ( 'joomla.application.component.modellist' );
/**
 * attendance Model
 */
class attendanceModelResponsesForItem extends JModelList {
	protected $searchInFields = array (
			'item_val'
			,'item_order'
			,'item_status'
			, 'reason'
			,'details'
			,'approval_status'
			,'rsvp_yes'
			,'rsvp_no'
			,'rsvp_unsure'
			,'rsvp_none'
	);
	public function __construct($config = array()) {
		$config ['filter_fields'] = array_merge ( $this->searchInFields );
		parent::__construct ( $config );
	}

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return string An SQL query
	 */
	protected function getListQuery() {

		// Create a new query object.
		$db = JFactory::getDBO ();
		$query = $db->getQuery ( true );



		$cmpl = $db->escape ( $this->getState ( 'filter.cmpl' ) );
		$event_month = $db->escape ( $this->getState ( 'filter.event_month' ) );
		$regex = str_replace ( ' ', '|', $this->getState ( 'filter.search' ) );
		$filter_id = $db->escape($this->getState('filter.filter_id'));
		$filter_type = $db->escape($this->getState('filter.filter_type'));
		$item_type = $db->escape($this->getState('list.item_type'));

		$this->populateQuery($query, $cmpl,$event_month, $regex, $filter_id, $filter_type, $item_type);

		// Filter search // Extra: Search more than one fields and for multiple words
		if (! empty ( $regex )) {
			$regex = ' REGEXP ' . $db->quote ( $regex );
			$query->where ( '(' . implode ( $regex . ' OR ', $this->searchInFields ) . $regex . ')' );
		}

		$query->order($db->escape($this->getState('list.ordering', 'item_order')).' '.
				$db->escape($this->getState('list.direction', 'ASC')));

        	//Remove pagination
        	$this->setState('list.limit', 1000000);
		return $query;
	}
	protected function populateState($ordering = null, $direction = null) {
		// Initialise variables.
		$app = JFactory::getApplication ();
		$jinput = JFactory::getApplication ()->input;

		// Load the filter state.
		$search = $this->getUserStateFromRequest ( $this->context . '.filter.search', 'filter_search' );
		// Omit double (white-)spaces and set state
		$this->setState ( 'filter.search', preg_replace ( '/\s+/', ' ', $search ) );

		// Filter response cmpl status
		$state = $this->getUserStateFromRequest ( $this->context . '.filter.cmpl', 'filter_cmpl', '', 'string' );
		$this->setState ( 'filter.cmpl', $state );

		// Filter response cmpl status
		$state = $this->getUserStateFromRequest ( $this->context . '.filter.event_month', 'filter_event_month', '', 'string' );
		$this->setState ( 'filter.event_month', $state );




		$state = $this->getUserStateFromRequest ( $this->context . '.filter.filter_id', 'filter_id', '', 'string' );
		$this->setState ( 'filter.filter_id', $state );

		//$state = $jinput->get ( 'filter_type', '', 'string' );
		//$this->setState ('filter.filter_type',$state);

		//Set filter type and group type (group type is inverse of filter)
		$state = $this->getUserStateFromRequest ( $this->context . '.filter.filter_type', 'filter_type', '', 'string' );
		$this->setState ( 'filter.filter_type', $state );

		$state = $state == 'user'?'event':'user';
		$this->setState ( 'list.item_type', $state );

		//Set filter val
		//$state = $jinput->get ( 'filter_id', '', 'string' );
		//$this->setState ('filter.filter_id',$state);

		// Takes care of states: list. limit / start / ordering / direction
		parent::populateState ('item_order', 'asc' );
	}

	public function populateQuery(&$query, $cmpl, $event_month, $regex, $filter_id, $filter_type, $item_type) {


		$query->select ( 'distinct concat(event.id, \'_\', user.id) as event_user
			, IF(responses.id is null,1,0) as rsvp_none
			, IF(responses.rsvp_status = 1,1,0) as rsvp_yes
			, IF(responses.rsvp_status = 0,1,0) as rsvp_no
			, IF(responses.rsvp_status = -1,1,0) as rsvp_unsure
			, responses.rsvp_status, responses.id as rsvp_id
			, IF(responses.rsvp_status = 0,approval_status.review_status_name,\'\')  as approval_status
			, (Case
				when responses.rsvp_status = \'-1\'
					then \'Unsure\'
				when responses.rsvp_status = \'0\'
					then \'No\'
				when responses.rsvp_status = \'1\'
					then \'Yes\'
				else \'No Answer\'
			End) as item_status
			, reasons.reason_name as reason, responses.rsvp_details as details
			' );

			switch ($item_type) {
			case 'user' :
				$query->select(
						' user.name as item_val
						, user.id as item_id
						, user.name as item_order
						, concat(event_type_name, \' \', IF (time_val = \'TBD\', concat(date_format(event.event_date,\'%c/%e/%y\'), \' TBD\'), date_format(concat(event.event_date, \' \', time.time_val),\'%c/%e/%y %l:%i %p\'))) as filter_val
						, event.id as filter_id
						, \'user\' as item_type
						, \'event\' as filter_type
						, \'User Name\' as item_type_eng
						, \'Event Date\' as filter_type_eng');
				break;
				case 'event' :
					$query->select(
						' concat(event_type_name, \' \', IF (time_val = \'TBD\', concat(date_format(event.event_date,\'%c/%e/%y\'), \' TBD\'), date_format(concat(event.event_date, \' \', time.time_val),\'%c/%e/%y %l:%i %p\'))) as item_val
						, event_id as item_id
						, IF (time_val = \'TBD\', concat(date_format(event.event_date,\'%y/%m/%d\'), \' TBD\'), date_format(concat(event.event_date, \' \', time.time_val),\'%y/%m/%d %T\')) as item_order
						, user.name as filter_val
						, user.id as filter_id
						, \'event\' as item_type
						, \'Event Date\' as item_type_eng
						, \'User Name\' as filter_type_eng' );
					break;
			default :
				$query->select(
						' user.name as item_val
						, user.id as item_id
						, user.name as item_order
						, concat(event_type_name, \' \', IF (time_val = \'TBD\', concat(date_format(event.event_date,\'%c/%e/%y\'), \' TBD\'), date_format(concat(event.event_date, \' \', time.time_val),\'%c/%e/%y %l:%i %p\'))) as filter_val
						, event.id as filter_id
						, \'user\' as item_type
						, \'event\' as filter_type
						, \'User Name\' as item_type_eng
						, \'Event Date\' as filter_type_eng');
				break;
		}

		$query->from ( '#__sched_events event' );
		$query->join ( 'INNER', '#__sched_event_mand_grps event_grps on event.id = event_grps.event_id' );
		$query->join ( 'INNER', '#__user_usergroup_map users_grps on event_grps.group_id = users_grps.group_id' );
		$query->join ( 'INNER', '#__users user on user.id = users_grps.user_id' );
		$query->join ( 'INNER','#__sched_locations loc on event.event_location = loc.id');
		$query->join ( 'INNER','#__sched_times time on event.event_time = time.id');
		$query->join ( 'INNER','#__sched_event_types type on event.event_type = type.id');
		$query->join ( 'LEFT OUTER', '#__sched_responses responses on (responses.rsvp_user = user.id and responses.rsvp_event = event.id)' );
		$query->join ( 'LEFT OUTER','#__sched_rsvp_reasons reasons on responses.rsvp_reason = reasons.id');
		$query->join ( 'LEFT OUTER','#__sched_review_statuses approval_status on responses.rsvp_review_status = approval_status.id');
		$query->where( ' user.block = 0 ');
		$query->where(' '. $filter_type.'.id = \''.$filter_id.'\' ');

		//Filter on only events with a response
		switch ($cmpl) {
			case "OUTSTANDING": $query->where( ' (responses.id is null OR (rsvp_active=1 and rsvp_status=-1)) ');  break;
			case "ALL": $query->where( ' (rsvp_active =1 or rsvp_active is null) ');  break;
			case "NO": $query->where( ' (rsvp_status=0 and rsvp_active=1) ');  break;
			default: $query->where( ' (rsvp_active =1 or rsvp_active is null) ');  break;
		}

		//Filter on Event Month
		switch ($event_month) {
			case null: break;
			case "ALL": break;
			default: $query->where( ' date_format(event_date,\'%Y-%m\') = \'' . $event_month . '\''); break;
		}

	return true;

	}
}