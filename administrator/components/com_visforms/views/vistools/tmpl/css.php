<?php
/**
 * Vistools editcss view for Visforms
 *
 * @author       Aicha Vack
 * @see           visforms is extended and rivised adaptation of ckforms from cookex (http://www.cookex.eu) for Joomla 2.5
 * @package      Joomla.Administrator
 * @subpackage   com_visforms
 * @link         http://www.vi-solutions.de 
 * @license      GNU General Public License version 2 or later; see license.txt
 * @copyright    2012 vi-solutions
 * @since        Joomla 1.6 
 */

//no direct access
 defined('_JEXEC') or die('Restricted access'); ?>

<form action="<?php echo JRoute::_('index.php?option=com_visforms');?>" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
    	<textarea name="viscss" id="viscss" wrap="wrap" style="width:98%;height:300px"><?php echo $this->css->content; ?></textarea>         
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="id" value="<?php echo $this->css->extension_id; 	?>" />
<input type="hidden" name="filename" value="<?php echo $this->css->filename; ?>" />
<input type="hidden" name="task" value="" />	
<?php echo JHtml::_('form.token'); ?>

</form>


<div class="visformbottom">
	visForms V1.0.0, &copy; 2012 Copyright by <a href="http://vi-solutions.de" target="_blank" class="smallgrey">vi-solutions</a>, all rights reserved. 
    visForms is Free Software released under the GNU/GPL License. 
</div>