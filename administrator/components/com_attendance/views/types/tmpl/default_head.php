<?php
// No direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted Access' );
?><tr>	<th width="20">
		<input			type="checkbox"			name="toggle"			value=""			onclick="checkAll(<?php echo count($this->items); ?>);"			/>
	</th>	<th>
		<?php echo JHTML::_( 'grid.sort', 'Name', 'event_type_name', $this->sortDirection, $this->sortColumn); ?>
	</th></tr>