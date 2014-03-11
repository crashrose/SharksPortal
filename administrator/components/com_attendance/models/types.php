<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import the Joomla modellist library
jimport ( 'joomla.application.component.modellist' );

/**
 * attendance Model
 */
class attendanceModelTypes extends JModelList {
	protected $searchInFields = array(
			'event_type_name',
	);

	public function __construct($config = array()) {
		$config ['filter_fields'] = array_merge ( $this->searchInFields );
		parent::__construct ( $config );
	}

	/**
	 * Method to build an SQL query to load the list data.
	 * @return string An SQL query
	 */
	protected function getListQuery() {
		// Create a new query object.
		$db = JFactory::getDBO ();
		$query = $db->getQuery ( true );
		// Select some fields
		$query->select ( 'event_type_name as event_type_name, id as id' );
		// From the schedule views table
		$query->from ( '#__sched_event_types' );
		$query->order($db->escape($this->getState('list.ordering', 'event_type_name')).' '.
				$db->escape($this->getState('list.direction', 'ASC')));
		return $query;
	}
	protected function populateState($ordering = null, $direction = null) {
		parent::populateState('event_type_name', 'ASC');
	}
}