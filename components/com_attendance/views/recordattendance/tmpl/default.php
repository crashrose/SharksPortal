<?php

// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );


// Load the tooltip behavior.
JHtml::_ ( 'behavior.framework' );
JHtml::_ ( 'behavior.tooltip' );

$document = JFactory::getDocument();
$document->addScriptDeclaration('jQuery.noConflict();');
$document->addStyleSheet('components/com_attendance/css/attendance.css');
JHtml::script(Juri::base() . '/components/com_attendance/views/recordattendance/submitbutton.js', $mootools);


$document->addScriptDeclaration('
function att_all_yes(){
yes_rads = document.getElementsByClassName("att_yes_radio")
for (c=0;c<yes_rads.length;c++){
yes_rads[c].checked=true
}
}

		function att_all_no(){
no_rads = document.getElementsByClassName("att_no_radio")
for (c=0;c<no_rads.length;c++){
no_rads[c].checked=true
}
}

		function att_all_unknown(){
unknown_rads = document.getElementsByClassName("att_unknown_radio")
for (c=0;c<unknown_rads.length;c++){
unknown_rads[c].checked=true
}
}
');

$document->addScriptDeclaration('
function tableOrdering( order, dir, task )
{
        var form = document.adminForm;
        form.filter_order.value = order;
        form.filter_order_Dir.value = dir;
        document.adminForm.submit( task );
}
');

?>
<form action="<?php echo JRoute::_('index.php?option=com_attendance&view=RecordAttendance'); ?>" method="post" name="adminForm" id="adminForm">
<table class="attendance">
    <thead><?php echo $this->loadTemplate('head');?></thead>
    <tbody><?php echo $this->loadTemplate('body');?></tbody>
    <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
</table>
	<div>
		<button type="button"  onclick="Joomla.submitbutton('RecordAttendance.save');">
            <?php echo JText::_('Submit Attendance'); ?>
        </button>
        <input type="hidden" name="event_id" value="<?php echo $this->event_id; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="redirect_name" value="countresponses" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>