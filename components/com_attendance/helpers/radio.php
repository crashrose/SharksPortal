<?php


jimport('joomla.form.fields.radio');

class AttendanceRadio extends JFormFieldRadio
{
	
	
	
	function rsvp_status($id,$val){
		jimport('joomla.form.helper');
		$yes_no = JFormHelper::loadFieldType('radio');
			$name = 'rsvp_status';
	$group = 'rsvp_status_'.$id;	


	var_dump ($yes_no);
	
	}
}