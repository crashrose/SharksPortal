<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
// import the Joomla modellist library
jimport('joomla.application.component.modellist');
/**
 * attendance Model
 */
 
class attendanceModelLocations extends JModelList
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
                $query->select('loc_name,id,loc_address_1,loc_address_2,loc_city,loc_state,loc_zip,loc_country,loc_phone,loc_note,loc_website,loc_maplink');
                // From the schedule views table
                $query->from('#__sched_locations');

                return $query;
				
        }
}