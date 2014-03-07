<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );
?><tr>	<th width="20">
		<input			type="checkbox"			name="toggle"			value=""			onclick="checkAll(<?php echo count($this->items); ?>);"			/>
	</th>	<th>		<?php echo JText::_('COM_ATTENDANCE_EVENT_TYPES_HEADING_NAME'); ?>	</th></tr>