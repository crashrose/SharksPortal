<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * attendance Model
 */
 
class attendanceModelEvents extends JModelList
{

        /**
         * Method to build an SQL query to load the list data.
         *
         * @return      string  An SQL query
         */
		 
        protected function getListQuery()
        {
                // Create a new query object.           
                $db = JFactory::getDBO();
                $query = $db->getQuery(true);
                // Select some fields
                $query->select('event.event_name as event_name,event.event_date as event_date,time.time_val as event_time,type.event_type_name as event_type,loc.loc_name as event_location,owner.name as event_owner, event.event_respond_by as event_respond_by, event.id as id');
                // From the schedule views table
                $query->from('#__sched_events AS event');
				$query->join('INNER','#__sched_locations loc ON event.event_location = loc.id');
				$query->join('INNER','#__users owner ON event.event_owner = owner.id');
				$query->join('INNER','#__sched_event_types type ON event.event_type = type.id');
				$query->join('INNER','#__sched_times time ON event.event_time = time.id');
                return $query;
				
        }
}