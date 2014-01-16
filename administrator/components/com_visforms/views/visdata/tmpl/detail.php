<?php 
/**
 * Visdata detail view for Visforms
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

<form action="index.php" method="post" name="adminForm" id="adminForm">
 
    <div id="tabs1">
		<table class="admintable">

        <tr>
            <td width="100" align="right" class="key">
                <label for="title">
                   <?php echo JText::_( 'COM_VISFORMS_ID' ); ?>
                </label>
            </td>
            <td>
                <?php echo $this->item->id; ?>
            </td>
        </tr>
        <tr>
            <td width="100" align="right" class="key">
                <label for="title">
                    <?php echo JText::_( 'COM_VISFORMS_DATE' ); ?>:
                </label>
            </td>
            <td>
                <?php echo $this->item->created; ?>
            </td>
        </tr>
         
	<?php	$k = 0;
		$n=count( $this->fields );
		for ($i=0; $i < $n; $i++)
		{
			$rowField = $this->fields[$i];
			if ($rowField->typefield != 'button' && $rowField->typefield != 'fieldsep')
			{
				$prop="F".$rowField->id;
				if (isset($this->item->$prop) == false)
				{
					$prop=$rowField->name;
				}
				
				if (isset($this->item->$prop))
				{
					$texte = $this->item->$prop;
				} else {
					$texte = "&nbsp;";
				}
							
 	?>
    
        <tr>
            <td width="100" align="right" class="key">
                <label for="title">
                    <?php echo  $rowField->label; ?>:
                </label>
            </td>
            <td>
<?php             

			if ($rowField->typefield == 'text') {
				$opt = explode("[--]", $rowField->defaultvalue);
				$key1 = explode("===", $opt[0]);
				$key2 = explode("===", $opt[1]);
				$key3 = explode("===", $opt[2]);
				$t_texttype = $key3[1];
				
				if ($t_texttype == 'email') {
					$texte = '<a href="mailto:'.$texte.'">'.$texte.'</a>';
				}
				
			}           
 ?>
             
                <?php echo  $texte; ?>
            </td>
        </tr>
            
	<?php	
			}
		}
 	?>
        <tr>
            <td width="100" align="right" class="key">
                <label for="title">
                   <?php echo JText::_( 'COM_VISFORMS_IP' ); ?>
                </label>
            </td>
            <td>
                <?php echo $this->item->ipaddress; ?>
            </td>
        </tr>

		</table>        
	</div>

<input type="hidden" name="option" value="com_visforms" />
<input type="hidden" name="id" value="<?php echo $this->visforms->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="visforms" />

</form>
<div class="visformbottom visformbottomborder">
	visForms V1.0.0, &copy; 2012 Copyright by <a href="http://vi-solutions.de" target="_blank" class="smallgrey">vi-soluions</a>, all rights reserved. 
    visForms is Free Software released under the <a href="http://www.gnu.org/licenses/gpl-2.0.html"target="_blank" class="smallgrey">GNU/GPL License</a>. 
</div>
