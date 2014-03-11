<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );
?><tr>	<th width="20"><input		type="checkbox"		name="toggle"		value=""		onclick="checkAll(<?php echo count($this->items); ?>);"		/>
	</th>	<th>
		<?php echo JHTML::_( 'grid.sort', 'Name', 'loc_name', $this->sortDirection, $this->sortColumn); ?>
	</th>	<th>
		<?php echo JText::_('COM_ATTENDANCE_LOCATION_ADD_1_LABEL'); ?>	</th>	<th>
		<?php echo JText::_('COM_ATTENDANCE_LOCATION_ADD_2_LABEL'); ?>	</th>	<th>
		<?php echo JHTML::_( 'grid.sort', 'City', 'loc_city', $this->sortDirection, $this->sortColumn); ?>
	</th>	<th>
		<?php echo JHTML::_( 'grid.sort', 'State', 'loc_state', $this->sortDirection, $this->sortColumn); ?>
	</th>	<th>
		<?php echo JHTML::_( 'grid.sort', 'Zip', 'loc_zip', $this->sortDirection, $this->sortColumn); ?>
	</th>	<th>
		<?php echo JText::_('COM_ATTENDANCE_LOCATION_COUNTRY_LABEL'); ?>	</th>	<th>
		<?php echo JText::_('COM_ATTENDANCE_LOCATION_PHONE_LABEL'); ?>	</th>
	<th>
		<?php echo JText::_('COM_ATTENDANCE_LOCATION_NOTE_LABEL'); ?>	</th>
	<th>
		<?php echo JText::_('COM_ATTENDANCE_LOCATION_WEBLINK_LABEL'); ?>	</th>
	<th>
		<?php echo JText::_('COM_ATTENDANCE_LOCATION_MAPLINK_LABEL'); ?>	</th></tr>