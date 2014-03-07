<?php
// No direct access to this file
JHtml::addIncludePath(JPATH_PLATFORM . '/helpers/html');
JLoader::register('JHtmlRSVP', JPATH_COMPONENT . '/helpers/html/rsvp.php');
JHtml::register('rsvp.panel', array('JHtmlRSVP', 'panel'));

defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('radio');
/**
 * Attendance Location Admin View
 */
class attendanceViewCountResponses extends JViewLegacy
{
        /**
         * attendance locations view display method
         * @return void
         */
        function display($tpl = null)
        {
        	$this->items            = $this->get('Items');
        	//$this->pagination       = $this->get('Pagination');
        	$this->state            = $this->get('State');


        	//Following variables used more than once
        	$this->sortColumn       = $this->state->get('list.ordering');
        	$this->sortDirection    = $this->state->get('list.direction');
        	$this->searchterms      = $this->state->get('filter.search');
        	$this->groupby          = $this->state->get('list.groupby');
        	$this->groupFilterVal      = $this->state->get('filter.group_val');
        	$this->groupFilterType      = $this->state->get('filter.val_type');

        	require_once JPATH_COMPONENT.'/helpers/attendance.php';
        	require_once JPATH_COMPONENT.'/helpers/html/grid.php';

                // Get data from the model
                $items = $this->get('Items');
                //$pagination = $this->get('Pagination');

                // Check for errors.
                if (count($errors = $this->get('Errors')))
                {
                        JError::raiseError(500, implode('<br />', $errors));
                        return false;
                }
                // Assign data to the view
                $this->items = $items;
                $this->ItemName = $items[0]->filtered_val;
                $this->GroupByName = $items[0]->group_type_eng;
                $this->pagination = $pagination;



                // Display the template
                parent::display($tpl);
        }



}