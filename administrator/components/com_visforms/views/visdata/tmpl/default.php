<?php 
/**
 * Visdata default view for Visforms
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

// no direct access
defined('_JEXEC') or die( 'Restricted access' );
 
JHtml::_('behavior.multiselect');

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>


<style type="text/css">
<!--
#element-box  {
	overflow:auto !important;
}
-->
</style>

<form action="<?php echo JRoute::_('index.php?option=com_visforms&view=visdata&fid=' . JRequest::getVar( 'fid', -1 ) );?>" method="post" name="adminForm" id="adminForm" >
<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />

			<button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>
		</div>
<div class="filter-select fltrt">
	
	<select name="filter_published" class="inputbox" onchange="this.form.submit()">
	<option value=""><?php echo JText::_('JOPTION_SELECT_PUBLISHED');?></option>
	<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('trash'=>false, 'archived'=>false)), 'value', 'text', $this->state->get('filter.published'), true);?>
</select>
	
</div>	</fieldset>
	<div class="clr"> </div>

<table class="adminlist">
<thead>
    <tr>
		<th width="3%">
			<input type="checkbox" name="toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
		</th>
		<th width="3%">
			<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_PUBLISHED', 'a.published', $listDirn, $listOrder); ?>		
		</th>	

			<?php	$k = 0;
			$n=count( $this->fields );
			for ($i=0; $i < $n; $i++)
			{
				$width = 30;
				if ($n > 0) {
					$width = floor(89/$n);
				}
				$rowField = $this->fields[$i];
				if ($rowField->typefield != 'button' && $rowField->typefield != 'fieldsep')
				{
			?>
				<th width="<?php echo $width ?>%">
					<?php echo JHtml::_('grid.sort', $rowField->label, 'a.F'. $rowField->id, $listDirn, $listOrder); ?>
				</th>
			<?php         
				}
			}
			?>
			<th width="4%">
				<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_IP', 'a.ipaddress', $listDirn, $listOrder); ?>
			</th>

			<th width="3%">
				<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_ID', 'a.id', $listDirn, $listOrder); ?>
			</th>
	</tr>			
</thead>
	<?php
	$k = 0;
	$n=count( $this->items );
	for ($i=0; $i < $n; $i++)
	{	
	
		$row = &$this->items[$i];
		$published	= JHTML::_('jgrid.published', $row->published, $i, 'visdata.', true );
		$checked = JHTML::_('grid.id',   $i, $row->id );
		$link = JRoute::_( 'index.php?option=com_visforms&task=visdata.detail&fid='.JRequest::getVar( 'fid', -1 ).'&cid[]='. $row->id );

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $checked; ?>
			</td>            
            <td align="center">
                <?php echo $published;?>
            </td>
<?php
	$z=count( $this->fields );
	for ($j=0; $j < $z; $j++)
	{
		$rowField = $this->fields[$j];
		if ($rowField->typefield != 'button' && $rowField->typefield != 'fieldsep')
		{
			$prop="F".$rowField->id;
			if (isset($row->$prop) == false)
			{
				$prop=$rowField->name;
			}
			if (isset($row->$prop))
			{
				$texte = $row->$prop;
			} else {
				$texte = "&nbsp;";
			}
			if (strlen($texte) > 255) {
				$texte = substr($texte,0,255)."...";
			}
			
			$isEmail = false;
			if ($rowField->typefield == 'text') {
				$opt = explode("[--]", $rowField->defaultvalue);
				$key1 = explode("===", $opt[0]);
				$key2 = explode("===", $opt[1]);
				$key3 = explode("===", $opt[2]);
				$t_texttype = $key3[1];
				
				if ($t_texttype == 'email') {
					$isEmail = true;
				}
				
			}
			
			if ($isEmail == true) 
			{
				$linkfield = "mailto:".$texte;
			} 
			else 
			{
				$linkfield = $link;
			}
 ?>
	<td><?php echo "<a href=\"".$linkfield."\">".$texte."</a>"; ?></td> 
<?php	
		}
	}
 ?>

			<td>
				<?php echo $row->ipaddress; ?>
			</td>
			<td>
				<?php echo $row->id; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
    
    <tfoot>
    <tr>
      <td colspan="<?php echo (count($this->fields) + 4); ?>"><?php echo $this->pagination->getListFooter(); ?></td>
    </tr>
  </tfoot>

</table> 

   

  
	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>

</form>

<div class="visformbottom">
	visForms V1.0.0, &copy; 2012 Copyright by <a href="http://vi-solutions.de" target="_blank" class="smallgrey">vi-soluions</a>, all rights reserved. 
    visForms is Free Software released under the <a href="http://www.gnu.org/licenses/gpl-2.0.html"target="_blank" class="smallgrey">GNU/GPL License</a>. 
</div>