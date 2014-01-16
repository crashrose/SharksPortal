	<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Attendance Location Admin View
 */
class attendanceViewResponses extends JViewLegacy
{
        /**
         * attendance locations view display method
         * @return void
         */
	
        function display($tpl = null) 
        {
        	$this->items            = $this->get('Items');
        	$this->pagination       = $this->get('Pagination');
        	$this->state            = $this->get('State');
        	
        	//Following variables used more than once
        	$this->sortColumn       = $this->state->get('list.ordering');
        	$this->sortDirection    = $this->state->get('list.direction');
        	$this->searchterms      = $this->state->get('filter.search');
        	
        	
                // Get data from the model
                $items = $this->get('Items');
                $pagination = $this->get('Pagination');
 
                // Check for errors.
                if (count($errors = $this->get('Errors'))) 
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                // Assign data to the view
                $this->items = $items;
                $this->pagination = $pagination;
				
                // Display the template
                parent::display($tpl);
        }

}