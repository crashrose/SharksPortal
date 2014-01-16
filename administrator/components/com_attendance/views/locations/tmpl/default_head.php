<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access'); ?>
<tr>
        <th width="20">
                <input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
        </th>   
        <th>
                <?php echo JText::_('COM_ATTENDANCE_LOCATION_NAME_LABEL'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_ATTENDANCE_LOCATION_ADD_1_LABEL'); ?>
        </th>                
        <th>
                <?php echo JText::_('COM_ATTENDANCE_LOCATION_ADD_2_LABEL'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_ATTENDANCE_LOCATION_CITY_LABEL'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_ATTENDANCE_LOCATION_STATE_LABEL'); ?>
        </th>
		<th>
                <?php echo JText::_('COM_ATTENDANCE_LOCATION_ZIP_LABEL'); ?>
        </th>   
        <th>
                <?php echo JText::_('COM_ATTENDANCE_LOCATION_COUNTRY_LABEL'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_ATTENDANCE_LOCATION_PHONE_LABEL'); ?>
        </th>                
        <th>
                <?php echo JText::_('COM_ATTENDANCE_LOCATION_NOTE_LABEL'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_ATTENDANCE_LOCATION_WEBLINK_LABEL'); ?>
        </th>
        <th>
                <?php echo JText::_('COM_ATTENDANCE_LOCATION_MAPLINK_LABEL'); ?>
        </th>               
</tr>