<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>

<h3>Recording Attendance Records for:</h3>
<h2><?php echo $this->event_type . ' on ' . date("D. M j, Y",strtotime($this->event_datetime)) . ' at ' . date("g:s a",strtotime($this->event_datetime)) ?></h2>
<tr>
        <th>
                <?php echo JText::_('Attendee'); ?>
        </th>
        <th style="font-size:.8em">Yes to All:
                <input type="radio" name="toggle" value="1" onclick="att_all_yes()" />
        </th>
        <th style="font-size:.8em">No to All:
                <input type="radio" name="toggle" value="1" onclick="att_all_no()" />
        </th>
        <th style="font-size:.8em">Unsure to All:
                <input type="radio" name="toggle" value="1" onclick="att_all_unknown()" />
        </th>
        <th>
                <?php echo JText::_('Time Arrived'); ?>
        </th>

</tr>