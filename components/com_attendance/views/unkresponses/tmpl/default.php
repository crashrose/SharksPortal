<?php

// No direct access to this file

defined ( '_JEXEC' ) or die ( 'Restricted Access' );

// Get event date options

JFormHelper::addFieldPath ( JPATH_COMPONENT . '/models/fields' );

$event_month = JFormHelper::loadFieldType ( 'eventMonths', false );

$event_monthOptions = $event_month->getOptions (); // works only if you set your field getOptions on public!!

                                                  

// Load the tooltip behavior.

JHtml::_ ( 'behavior.framework' );

JHtml::_ ( 'behavior.tooltip' );

JHtml::_ ( 'behavior.formvalidation' );



?>

<?php

$document = JFactory::getDocument();

$document->addStyleSheet('components/com_attendance/css/attendance.css');

JHtml::script(Juri::base() . '/components/com_attendance/views/unkresponses/submitbutton.js', $mootools);



$document->addScriptDeclaration('

function rsvp_all_yes(){

el_collection = document.getElementsByClassName("att_yes_radio")

for (c=0;c<el_collection.length;c++)

el_collection[c].checked=true

}



');

$document = JFactory::getDocument();

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

<form action="<?php echo JRoute::_('index.php?option=com_attendance&view=unkResponses'); ?>"

	method="post" name="adminForm" id="adminForm" class="form-validate">


<table><tr><td width="30%"><p style="font-size:.8em;">
Filter by:

<BR><BR>



			<?php echo AttendanceHelper::response_list_options($this->state->get('filter.rsvp_cmpl'));?>

			<BR>

			<BR>

			Text search:<BR>

			<input type="text" name="filter_search"

				id="filter_search"

				value="<?php echo $this->escape($this->searchterms); ?>"

				title="<?php echo JText::_('Search by location, etc.'); ?>" 

			/>

			<button type="submit">

			<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>

			</button>

			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();">

				<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>

            </button>

			<BR>

			<BR>Event Month: <select name="filter_event_month"

				class="inputbox" onchange="this.form.submit()">

				<option value="ALL"> - Show All - </option>

                <?php echo JHtml::_('select.options', $event_monthOptions, 'value', 'event_month', $this->state->get('filter.event_month'));?>

                </select><BR><BR></p></td>
				<td>
				<p style="font-weight:bold;">INSTRUCTIONS:</p><p style="font-size:.8em;">Below is a list of practices/events that you need to RSVP to.  You can select Yes, No, or Unsure for each event. 
<BR>
<u>If you select No</u>, you MUST enter a reason and an explanation for why you will be unable to attend. You will not be able to submit a No response without both a reason and an explanation. 
<BR>
<u>If you select Unsure</u>, you can enter a reason and explanation, but they are not mandatory.
<BR>
<u>If you do not make a selection for any particular event</u>, your response will not be updated. You DON'T have to submit all responses at once. However, you MUST respond to each event on or before the "Respond by" date listed in red for each event.
<BR>
<u>There is a "Yes to All" option in the header of the table</u> which can be used to initially mark all of your responses as Yes. Once all are marked Yes you can change those that you cannot go to individually.
<BR>
Once you are done, click the "Submit Responses" button at the bottom of the page to record your responses.
<BR>
<u>You may return to this page at any time to update your responses or submit new responses, as long as you do so by the "Respond by" date written in red.</u> 
The filtering options at the top of the page allow you to select the events you want to view and/or update. 
</p>
				
				</td>
</tr>
<tr><td colspan="2">
    <?php
    $out_text = AttendanceHelper::outstanding_for_user();
    $out_text = $out_text>0?'<font color="red">'.$out_text.'</font>':$out_text;
    ?>
You currently have <?php echo $out_text;?> outstanding responses.
</td></tr></table>
<table class="attendance">

			<thead><?php echo $this->loadTemplate('head');?></thead>

			<tbody><?php echo $this->loadTemplate('body');?></tbody>

			<tfoot><?php echo $this->loadTemplate('foot');?></tfoot>

	</table>

	<div>

		<button type="button"  class="validate" 

			onclick="Joomla.submitbutton('createResponses.process');">

		<?php echo JText::_('ATTENDANCE SUBMIT RESPONSES'); ?>

	</button>

			<input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />

        <input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />

		<input type="hidden" name="task" value="" /> <input type="hidden"

			name="boxchecked" value="0" />

		<?php echo JHtml::_('form.token'); ?>

	</div>

</form>