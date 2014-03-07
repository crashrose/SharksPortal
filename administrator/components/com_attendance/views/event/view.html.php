<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
// import Joomla view library
jimport ( 'joomla.application.component.view' );

/**
 * Attendance Event View
 */
class attendanceViewEvent extends JView {

	/**
	 * display method of event view
	 * @return void
	 *
	 *
	 */
	public function display($tpl = null) {
		// get the Data
		$form = $this->get ( 'Form' );
		$item = $this->get ( 'Item' );
		// Check for errors.
		if (count ( $errors = $this->get ( 'Errors' ) )) {
			JError::raiseError ( 500, implode ( '<br />', $errors ) );
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;
		// Set the toolbar
		$this->addToolBar ();
		// Display the template
		parent::display ( $tpl );
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() {
		$input = JFactory::getApplication ()->input;
		$input->set ( 'hidemainmenu', true );
		$isNew = ($this->item->id == 0);
		JToolBarHelper::title ( $isNew ? JText::_ ( 'COM_ATTENDANCE_MANAGER_EVENT_NEW' ) : JText::_ ( 'COM_ATTENDANCE_MANAGER_EVENT_EDIT' ) );
		JToolBarHelper::save ( 'event.save' );
		JToolBarHelper::cancel ( 'event.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE' );
	}

	protected function setDocument() {
		$document = JFactory::getDocument ();
		$document->setTitle ( JText::_ ( 'COM_ATTENDANCE_ADMINISTRATION' ) );
	}
}