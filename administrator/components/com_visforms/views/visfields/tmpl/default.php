<?php
/**
 * Visfields default view for Visforms
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
 defined('_JEXEC') or die('Restricted access'); 

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$saveOrder	= $listOrder == 'a.ordering';
?>

<form action="<?php echo JRoute::_('index.php?option=com_visforms&view=visfields&fid=' . JRequest::getVar( 'fid', -1 ));?>" method="post" name="adminForm">
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
		</div>	
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
	<thead>
		<tr>
			<th width="3%">
				<input type="checkbox" name="toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)" />
			</th>			
			<th width="40%">
				<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_LABEL', 'a.label', $listDirn, $listOrder); ?>
			</th>
            <th width="5%">
				<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_PUBLISHED', 'a.published', $listDirn, $listOrder); ?>
            </th>
			<th width="10%">
				<?php echo JHTML::_('grid.sort', JText::_( 'COM_VISFORMS_ORDER_BY' ), 'a.ordering', $listDirn, $listOrder ); ?>
				<?php if ($saveOrder) :?>
					<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'visfields.saveorder'); ?>
				<?php endif; ?>
			</th>					
			<th width="10%">
				<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_TYPE', 'a.typefield', $listDirn, $listOrder); ?>
			</th>
			<th width="3%" nowrap="nowrap">
				<?php echo JHtml::_('grid.sort', 'COM_VISFORMS_ID', 'a.id', $listDirn, $listOrder); ?>
			</th>
		</tr>			
	</thead>
	<?php
	$k = 0;
	$n=count( $this->items );
	for ($i=0; $i < $n; $i++)
	{
		$row = $this->items[$i];
		$ordering	= ($listOrder == 'a.ordering');
		$published	= JHTML::_('jgrid.published', $row->published, $i, 'visfields.', true  );
		$checked 	= JHTML::_('grid.id',   $i, $row->id );
		$link 		= JRoute::_( 'index.php?option=com_visforms&task=visfield.edit&cid[]='. $row->id.'&fid='.JRequest::getVar( 'fid', -1 ));

		?>
		<tr class="<?php echo "row$k"; ?>">
			<td class="center">
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->label; ?></a>
				<p class="smallsub">
					<?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($row->name));?>
				</p>
			</td>
            <td class="center">
                <?php echo $published;?>
            </td>
			<td class="order">					
				<?php if ($saveOrder) :?>
					<?php if ($listDirn == 'asc') : ?>
						<span><?php echo $this->pagination->orderUpIcon($i, true, 'visfields.orderup', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
						<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'visfields.orderdown', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
					<?php elseif ($listDirn == 'desc') : ?>
						<span><?php echo $this->pagination->orderUpIcon($i, true, 'visfields.orderdown', 'JLIB_HTML_MOVE_UP', $ordering); ?></span>
						<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, true, 'visfields.orderup', 'JLIB_HTML_MOVE_DOWN', $ordering); ?></span>
					<?php endif; ?>
				<?php endif; ?>
				<?php $disabled = $saveOrder ?  '' : 'disabled="disabled"'; ?>
				<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
			</td>
			<td class="center nowrap">
				<a href="<?php echo $link; ?>"><?php echo $this->escape($row->typefield); ?>
                <?php	if ($row->typefield == "text")
						{
							$opt = explode("[--]", $row->defaultvalue);
							$key = explode("===", $opt[2]);
							echo " [".$this->escape($key[1])."]";
						}
				 ?>		
                </a>
			</td>
			<td class="center">
				<?php echo $row->id; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
    
    <tfoot>
    <tr>
      <td colspan="8"><?php echo $this->pagination->getListFooter(); ?></td>
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