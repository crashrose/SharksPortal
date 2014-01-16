<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * attendance Model
 */
 
class attendanceModelTypes extends JModelList
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
                $query->select('event_type_name as event_type_name, id as id');
                // From the schedule views table
                $query->from('#__sched_event_types');

                return $query;
				
        }
}