<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import the Joomla modellist library
jimport ( 'joomla.application.component.modellist' );
/**
 * attendance Model
 */
class attendanceModelCountResponses extends JModelList {
	protected $searchInFields = array (
			'event_type'
			,'event_date'
			,'event_loc'
			,'user_name'
			,'group_name'
			,'rsvp_yes'
			,'rsvp_no'
			,'rsvp_unsure'
			,'rsvp_none'
			,'total_events'
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
		$subquery = $db->getQuery ( true );
		$totalquery = $db->getQuery ( true );

		$cmpl = $db->escape ( $this->getState ( 'filter.cmpl' ) );
		$event_month = $db->escape ( $this->getState ( 'filter.event_month' ) );
		$regex = str_replace ( ' ', '|', $this->getState ( 'filter.search' ) );
		$group_by = $db->escape($this->getState('list.groupby'));
		$group_val_filter = $db->escape($this->getState('filter.group_val'));
		$group_type_filter = $db->escape($this->getState('filter.val_type'));


		$this->populateSubQuery($subquery, $cmpl,$event_month, $regex, $group_val_filter, $group_type_filter);
		$this->populateQuery($query, $group_by, $group_type_filter);
		// Filter search // Extra: Search more than one fields and for multiple words
		if (! empty ( $regex )) {
			$regex = ' REGEXP ' . $db->quote ( $regex );
			$subquery->where ( '(' . implode ( $regex . ' OR ', $this->searchInFields ) . $regex . ')' );
		}
		$query->from ( '(' . $subquery . ') all_event_users' );
		$totalquery->select ('*');
		$totalquery->from ('(' . $query . ') response_totals');

		$totalquery->order($db->escape($this->getState('list.ordering', 'group_order')).' '.
				$db->escape($this->getState('list.direction', 'ASC')));
        	//Remove pagination
        	$this->setState('list.limit', 1000000);
		return $totalquery;
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

		$state = $jinput->get ( 'group_val', '', 'string' );
		$this->setState ('filter.group_val',$state);
		$filtered = $state!==''?1:0;


		$state = $jinput->get ( 'val_type', '', 'string' );
		$this->setState ('filter.val_type',$state);
		$filter_type = $state;
		// Select Report Grouping
		if ($filtered==1){
		$state = $filter_type == 'user'?'event':'user';
		}
			else{
			$state = $this->getUserStateFromRequest ( $this->context . '.list.groupby', 'list_groupby', '', 'string' );
			}


$this->setState ( 'list.groupby', $state );

		// Takes care of states: list. limit / start / ordering / direction
		parent::populateState ('group_order', 'asc' );
	}
	public function populateQuery(&$query, $group_by, $group_type_filter) {
// 		$filter_info = $group_type_filter!=''?', filtered_val ':', 0 as filtered_val';
				$query->select ( 'SUM(event_count) as total_events
						, filtered_val
				, SUM(rsvp_none) as rsvp_none
				, SUM(rsvp_yes) as rsvp_yes
				, SUM(rsvp_no) as rsvp_no
				, SUM(rsvp_unsure) as rsvp_unsure'
	);

		switch ($group_by) {
			case 'user_id' :
				$query->select('user_name as group_val
						, user_id as group_id
						, user_name as group_order
						, \'user\' as group_type
						, \'User Name\' as group_type_eng' );
				$query->group('user_name');
				break;
				case 'event_date' :
					$query->select('event_string as group_val
						, event_id as group_id
						, event_date as group_order
						, \'event\' as group_type
						, \'Event Date\' as group_type_eng' );
					$query->group('event_date');
					break;
			default :
				$query->select('user_name as group_val
						, user_id as group_id
						, user_name as group_order
						, \'user\' as group_type
						, \'User Name\' as group_type_eng' );
				$query->group('user_name');
				$this->setState ( 'list.groupby', 'user_name' );
				break;
		}
		return true;
	}
	public function populateSubQuery(&$subquery, $cmpl, $event_month, $regex, $group_val_filter, $group_type_filter) {
		$subquery->select ( 'distinct event.event_name, event.id as event_id
               	, user.name as user_name, user.id as user_id, CONCAT(event.id, \'_\', user.id) as event_user
                , 1 as event_count, time.time_val
                , concat(event_type_name, \' \', IF (time_val = \'TBD\', concat(date_format(event.event_date,\'%a %c/%e/%y\'), \' TBD\'), date_format(concat(event.event_date, \' \', time.time_val),\'%a %c/%e/%y %l:%i %p\'))) as event_string
                , IF (time_val = \'TBD\', concat(date_format(event.event_date,\'%y/%m/%d\'), \' TBD\'), date_format(concat(event.event_date, \' \', time.time_val),\'%y/%m/%d %T\')) as event_date
               	, IF(responses.id is null,1,0) as rsvp_none
                , IF(responses.rsvp_status = 1,1,0) as rsvp_yes
                , IF(responses.rsvp_status = 0,1,0) as rsvp_no
                , IF(responses.rsvp_status = -1,1,0) as rsvp_unsure' );

		$subquery->from ( '#__sched_events event' );
		$subquery->join ( 'INNER', '#__sched_event_mand_grps event_grps on event.id = event_grps.event_id' );
		$subquery->join ( 'INNER', '#__user_usergroup_map users_grps on event_grps.group_id = users_grps.group_id' );
		$subquery->join ( 'INNER', '#__users user on user.id = users_grps.user_id' );
		$subquery->join ( 'INNER','#__sched_locations loc on event.event_location = loc.id');
		$subquery->join ( 'INNER','#__sched_times time on event.event_time = time.id');
		$subquery->join ( 'INNER','#__sched_event_types type on event.event_type = type.id');
		$subquery->join ( 'LEFT OUTER', '#__sched_responses responses on (responses.rsvp_user = user.id and responses.rsvp_event = event.id)' );
		$subquery->where( 'user.block = 0');
		//Filter on only events with a response
		switch ($cmpl) {
			case "OUTSTANDING": $subquery->where( ' (responses.id is null OR (rsvp_active=1 and rsvp_status=-1)) ');  break;
			case "ALL": $subquery->where( ' (rsvp_active =1 or rsvp_active is null) ');  break;
			case "NO": $subquery->where( ' (rsvp_status=0 and rsvp_active=1) ');  break;
			default: $subquery->where( ' (rsvp_active =1 or rsvp_active is null) ');  break;
		}


		//Filter on Event Month
		switch ($event_month) {
			case null: break;
			case "ALL": break;
			default: $subquery->where( ' date_format(event_date,\'%Y-%m\') = \'' . $event_month . '\''); break;
		}
// 		echo str_replace('_id', '.id', $group_type_filter)) . '='. $group_val_filter;
		//Filter on Group Value
		if($group_type_filter !=''){
				$subquery->select( $group_type_filter . '.id as filtered_val');
				$subquery->where( ' '.$group_type_filter .'.id = \''.$group_val_filter.'\'');
				}
		else{

				$subquery->select( '0 as filtered_val');
		}
// if (!($group_type_filter=='')){
// 	$subquery->select( str_replace('_id', '.name', $group_type_filter) . ' as filtered_val');
// 	$subquery->where ( str_replace('_id', '.id', $group_type_filter) . '='. $group_val_filter);
// }
		return true;

	}
}