<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
        <th style="font-size:.9em">        	<?php
        	if ($this->groupFilterType == ''){
        	echo 'Group By: ';
        	echo AttendanceHelper::reporting_group_by($this->groupby);
        	}
        	else {
			echo 'Showing responses for:<BR>' . $this->ItemName;
			echo '&nbsp;<BR>';
			echo '<a href="'.JRoute::_('index.php?option=com_attendance&view=countresponses').'">Clear</a>';
			} ?>

        </th>

        <th colspan="4" style="font-size:.9em"> Response
		</th>
        <th style="font-size:.9em">
        	Total Events
        </th>
</tr>
<tr>
        <th style="font-size:.9em">

        	<?php echo JHTML::_( 'grid.sort', $this->GroupByName, 'group_order', $this->sortDirection, $this->sortColumn); ?>

        </th>

        <th width="13%">
        	<?php echo JHTML::_( 'grid.sort', 'NONE', 'rsvp_none', $this->sortDirection, $this->sortColumn); ?>
        </th>
        <th width="13%">
        	<?php echo JHTML::_( 'grid.sort', 'Yes', 'rsvp_yes', $this->sortDirection, $this->sortColumn); ?>
        </th>
        <th width="13%">
        	<?php echo JHTML::_( 'grid.sort', 'No', 'rsvp_no', $this->sortDirection, $this->sortColumn); ?>
        </th>
        <th width="13%">
        	<?php echo JHTML::_( 'grid.sort', 'Unsure', 'rsvp_unsure', $this->sortDirection, $this->sortColumn); ?>
        </th>
        <th width="13%">
        	<?php echo JHTML::_( 'grid.sort', 'Total', 'total_events', $this->sortDirection, $this->sortColumn); ?>
        </th>


</tr>