<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
//Get event date options
JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$event_dates = JFormHelper::loadFieldType('eventDates', false);
$event_datesOptions = $event_dates->getOptions(); // works only if you set your field getOptions on public!!

// load tooltip behavior
JHtml::_('behavior.tooltip');

?>
<form action="<?php echo JRoute::_('index.php?option=com_attendance&view=response$task=response.edit'); ?>" method="post" name="adminForm" id="adminForm">
        <fieldset id="filter-bar">
                <div class="filter-search fltlft">
                        <input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->searchterms); ?>" title="<?php echo JText::_('Search in company, etc.'); ?>" />
                        <button type="submit">
                                <?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
                        </button>
                        <button type="button" onclick="document.id('filter_search').value='';this.form.submit();">
                                <?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>
                        </button>
                </div> 
                <div class="filter-select fltrt">

                        <select name="filter_event_month" class="inputbox" onchange="this.form.submit()">
                                <option value=""> - Select Event Date - </option>
                                <?php echo JHtml::_('select.options', $event_datesOptions, 'value', 'event_date', $this->state->get('filter.event_date'));?>
                        </select>
 
                </div>
        </fieldset>
        <table class="adminlist">
                <thead><?php echo $this->loadTemplate('head');?></thead>
                <tbody><?php echo $this->loadTemplate('body');?></tbody>
                <tfoot><?php echo $this->loadTemplate('foot');?></tfoot>
        </table>
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>