
<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * attendance Model
*/

class attendanceModelResponses extends JModelList
{
	
	protected $searchInFields = array('text','event.event_date');
	
	
	public function __construct($config = array()) {
		$config['filter_fields']=array_merge($this->searchInFields,array('event.event_date'));
		parent::__construct($config);
	}
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
		
	protected function getListQuery()
	{
		 
		$user = JFactory::getUser();
		/////
		/////
		/////
		//*** UPDATE THIS WIH QUERY FOR COMPELETED RESPONSES
		 
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		$query->select('responses.id as id, event.event_name, event.event_date, time.time_val, event.id as event_id, user.id as user_id, user.name as rsvp_user_name, reason.reason_name as rsvp_reason, responses.rsvp_details, responses.rsvp_status');
		// From the schedule views table
		$query->from('#__sched_responses responses');
		$query->join('INNER','#__sched_events event on event.id = responses.rsvp_event');
		$query->join('INNER','#__sched_times time on event.event_time = time.id');
		$query->join('INNER','#__sched_rsvp_reasons reason on responses.rsvp_reason = reason.id');
		$query->join('INNER','#__users user on user.id = responses.rsvp_user');
// 		$query->where('user.id = '.$user->id);

		
		// Filter search // Extra: Search more than one fields and for multiple words
		$regex = str_replace(' ', '|', $this->getState('filter.search'));
		if (!empty($regex)) {
			$regex=' REGEXP '.$db->quote($regex);
			$query->where('('.implode($regex.' OR ',$this->searchInFields).$regex.')');
		}
		
		// Filter date
		$event_date= $db->escape($this->getState('filter.event_date'));
		if (!empty($event_date)) {
			$query->where('(event.event_date='.$event_date.')');
		}
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
	
		//Filter (dropdown) state
		$state = $this->getUserStateFromRequest($this->context.'.filter.state', 'filter_state', '', 'string');
		$this->setState('filter.state', $state);
	
		//Filter (dropdown) company
		$state = $this->getUserStateFromRequest($this->context.'.filter.event_date', 'filter_event_date', '', 'string');
		$this->setState('filter.event_date', $state);
	
		//Takes care of states: list. limit / start / ordering / direction
		parent::populateState('event.name', 'asc');
	}
}