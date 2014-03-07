<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * attendance Model
 */

class attendanceModelUnkResponses extends JModelList
{

	protected $searchInFields = array (
			'loc.loc_name'
			,'type.event_type_name'
			,'loc.loc_name'
	);
	public function __construct($config = array()) {
		$config ['filter_fields'] = array_merge ( $this->searchInFields );
		parent::__construct ( $config );
	}

        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */

        protected function getListQuery()
        {

        	$user = JFactory::getUser();

                // Create a new query object.
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('distinct event.event_name, type.event_type_name as event_type
                		, event.event_date, date_format(event_date,\'%Y-%m\') As event_month
                		, time.time_val as event_time, event.id as event_id, user.name as user_name
                		, concat(event.id, \'_\', user.id) as event_user
                		, user.id as user_id, responses.rsvp_reason, responses.rsvp_status, responses.rsvp_date_submitted
                		, responses.rsvp_details, loc.loc_name, loc.loc_address_1, loc.loc_address_2, loc.loc_city, loc.loc_state
                		, loc.loc_zip, loc.loc_note, loc.loc_website, loc.loc_maplink, event.event_respond_by');
                // From the schedule views table
                $query->from('#__sched_events event');
				$query->join('INNER','#__sched_event_mand_grps event_grps on event.id = event_grps.event_id');
				$query->join('INNER','#__user_usergroup_map users_grps on event_grps.group_id = users_grps.group_id');
				$query->join('INNER','#__users user on user.id = users_grps.user_id');
				$query->join('INNER','#__usergroups grp on grp.id = event_grps.group_id');
				$query->join('INNER','#__sched_times time on event.event_time = time.id');
				$query->join('INNER','#__sched_locations loc on event.event_location = loc.id');
				$query->join('INNER','#__sched_event_types type on event.event_type = type.id');
				$query->join('LEFT OUTER','#__sched_responses responses on (responses.rsvp_user = user.id and responses.rsvp_event = event.id)');
				$query->where('event.event_date > now()');
// 				$query->where('responses.id is null and user.id = '.$user->id);
// 				$query->order('event_date ASC');


				$rsvp_cmpl= $db->escape($this->getState('filter.rsvp_cmpl'));

				switch ($rsvp_cmpl){
					case null:
						$where_text = "";
						$where_text = 'user.id = '.$user->id .  ' and (rsvp_active =1 or rsvp_active is null)';
						break;
					case "ALL":
						$where_text = "";
						$where_text = 'user.id = '.$user->id .  ' and (rsvp_active =1 or rsvp_active is null)';
						break;
					case "OUTSTANDING":

						$where_text = "";
						$where_text = 'user.id = '.$user->id . ' AND ( responses.id is null OR (rsvp_active=1 and rsvp_status=-1))';

						break;
					case "COMPLETE":

						$where_text = "";
						$where_text = 'user.id = '.$user->id .  ' and rsvp_active =1';
						break;
					default:
						$where_text = "";
						$where_text = 'user.id = '.$user->id .  ' and (rsvp_active =1 or rsvp_active is null)';
						break;
				}
				$event_month= $db->escape($this->getState('filter.event_month'));
				switch ($event_month){
					case null:
						break;
					case "ALL":
						break;
					default:
						$where_text = $where_text . ' AND date_format(event_date,\'%Y-%m\') = \'' . $event_month . '\'';
						break;
				}
				// Filter search // Extra: Search more than one fields and for multiple words
				$regex = str_replace(' ', '|', $this->getState('filter.search'));
                        if (!empty($regex)) {
                        $regex=' REGEXP '.$db->quote($regex);
                        $query->where('('.implode($regex.' OR ',$this->searchInFields).$regex.')');
                }

				$query->where($where_text);
				$query->order($db->escape($this->getState('list.ordering', 'event_date')).' '.
						$db->escape($this->getState('list.direction', 'ASC')));

				$this->setState('list.limit', 1000000);
				return $query;

        }
        protected function populateState($ordering = null, $direction = null)
        {
        	// Initialise variables.
        	$app = JFactory::getApplication();

        	// Load the filter state.
        	$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
        	//Omit double (white-)spaces and set state
        	$this->setState('filter.search', preg_replace('/\s+/',' ', $search));

        	//Filter response cmpl status
        	$state = $this->getUserStateFromRequest($this->context.'.filter.rsvp_cmpl', 'filter_response_complete', '', 'string');
        	$this->setState('filter.rsvp_cmpl', $state);

        	//Filter response cmpl status
        	$state = $this->getUserStateFromRequest($this->context.'.filter.event_month', 'filter_event_month', '', 'string');
        	$this->setState('filter.event_month', $state);

        	//Remove pagination
        	$this->setState('list.limit', 1000000);

        	//Takes care of states: list. limit / start / ordering / direction
        	parent::populateState('event_date', 'asc');
        }




}