<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );
?><tr>	<th width="20">
		<input		type="checkbox"		name="toggle"		value=""		onclick="checkAll(<?php echo count($this->items); ?>);"		/>
	</th>	<th>		<?php echo JText::_('COM_ATTENDANCE_EVENTS_HEADING_NAME'); ?>	</th>	<th>
		<?php echo JHTML::_( 'grid.sort', 'Date', 'event_datetime', $this->sortDirection, $this->sortColumn); ?>
	</th>	<th>
		<?php echo JHTML::_( 'grid.sort', 'Event Type', 'event_type', $this->sortDirection, $this->sortColumn); ?>
	</th>	<th>
		<?php echo JHTML::_( 'grid.sort', 'Location', 'event_location', $this->sortDirection, $this->sortColumn); ?>
	</th>	<th>
		<?php echo JHTML::_( 'grid.sort', 'Event Owner', 'event_owner', $this->sortDirection, $this->sortColumn); ?>
	</th></tr>