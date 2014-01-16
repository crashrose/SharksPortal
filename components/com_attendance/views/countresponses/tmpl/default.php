<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );
// Get event date options
JFormHelper::addFieldPath ( JPATH_COMPONENT . '/models/fields' );
$document = JFactory::getDocument();

$event_month = JFormHelper::loadFieldType ( 'eventMonths', false );
$event_monthOptions = $event_month->getOptions (); // works only if you set your field getOptions on public!!
                                                  
// Load the tooltip behavior.
JHtml::_ ( 'behavior.framework' );
JHtml::_ ( 'behavior.tooltip' );
JHtml::_ ( 'behavior.formvalidation' );
JHtml::_ ( 'behavior.modal' );


$document = JFactory::getDocument();
$document->addStyleSheet('components/com_attendance/css/attendance.css');
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

<form
	action="<?php echo JRoute::_('index.php?option=com_attendance&view=CountResponses'); ?>"
	method="post" name="adminForm" id="adminForm">
Filter by:
<BR><BR>

			<?php echo AttendanceHelper::report_compl_filter($this->state->get('filter.cmpl'));?>
			<BR>

			<BR>Event Month: <select name="filter_event_month"
				class="inputbox" onchange="this.form.submit()">
				<option value="ALL"> - Show All - </option>
                <?php echo JHtml::_('select.options', $event_monthOptions, 'value', 'event_month', $this->state->get('filter.event_month'));?>
                </select><BR>
                <table class="grouped_attendance_report">
			<thead><?php echo $this->loadTemplate('head');?></thead>
			<tbody><?php echo $this->loadTemplate('body');?></tbody>
			<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
	</table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="group_val" value="<?php echo $this->groupFilterVal; ?>" />
		<input type="hidden" name="val_type" value="<?php echo $this->groupFilterType; ?>" />
		<input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
        <input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>