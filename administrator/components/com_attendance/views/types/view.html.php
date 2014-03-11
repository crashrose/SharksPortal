<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import Joomla view library
jimport ( 'joomla.application.component.view' );

/**
 * Attendance Event Types Admin View
 */
class attendanceViewTypes extends JView {

	/**
	 * attendance event types view display method
	 * @return void
	 *
	 *
	 */
	function display($tpl = null) {
		// Get data from the model
		$items = $this->get ( 'Items' );
		$pagination = $this->get ( 'Pagination' );
		$state = $this->get('State');

		$this->sortDirection = $state->get('list.direction');
		$this->sortColumn = $state->get('list.ordering');
		// Check for errors.
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JError::raiseError ( 500, implode ( '<br />', $errors ) );
			return false;
		}
		// Assign data to the view
		$this->items = $items;
		$this->pagination = $pagination;
		// Set the toolbar
		$this->addToolBar ();
		// Display the template
		parent::display ( $tpl );
	}

	protected function addToolBar() {
		JToolBarHelper::title ( JText::_ ( 'COM_ATTENDANCE_MANAGER_EVENT_TYPES' ) );
		JToolBarHelper::deleteList ( '', 'types.delete' );
		JToolBarHelper::editList ( 'type.edit' );
		JToolBarHelper::addNew ( 'type.add' );
	}
}