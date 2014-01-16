<?php 
/**
 *
 * modules view
 *
 * @version             1.0.0
 * @package             Joomlike Framework
 * @copyright			Copyright (C) 2012 vonfio.de. All rights reserved.
 *               
 */
 
// No direct access. 
defined('_JEXEC') or die;


/*
 * Module chrome : Main Menu
 */
function modChrome_mainmenu( $module, &$params, &$attribs ) {
	if (!empty ($module->content)) : ?>
    	<div id="jl_mainmenu">
            <a href="#<?php echo $module->id; ?>"
                title="<?php echo JText::_('TPL_JOOMLIKE_CLICK'); ?>"
                onclick="auf('jl_mainmenu_mini'); return false"
                class="toggleMainmenu" id="link_<?php echo $module->id?>"><?php echo $module->title; ?></a>
            <div class="jl_menu">
            	<?php
				$modulecontent = str_replace( '<ul class="menu">', '<ul class="mainmenu suckerfish">', $module->content );
				echo $modulecontent; ?>
                <div class="jl_clear"></div>
			</div>
            <div class="responsive_menu" id="jl_mainmenu_mini" style="display:none;">
            	<?php
				$modulecontent = str_replace( '<ul class="menu">', '<ul class="mainmenu suckerfish">', $module->content );
				echo $modulecontent; ?>
                <div class="jl_clear"></div>
			</div>
		</div>
	<?php endif;
}
/*
 * Module chrome : Sub Menu
 */
function modChrome_submenu( $module, &$params, &$attribs ) {
	if (!empty ($module->content)) : ?>
    	<div id="jl_submenu">
            <a href="#<?php echo $module->id; ?>"
                title="<?php echo JText::_('TPL_JOOMLIKE_CLICK'); ?>"
                onclick="auf('jl_submenu_mini'); return false"
                class="toggleSubmenu" id="link_<?php echo $module->id?>"><?php echo $module->title; ?></a>
            <div class="jl_menu">
            	<?php
				$modulecontent = str_replace( '<ul class="menu">', '<ul class="submenu suckerfish">', $module->content );
				echo $modulecontent; ?>
                <div class="jl_clear"></div>
			</div>
            <div class="responsive_menu" id="jl_submenu_mini" style="display:none;">
            	<?php
				$modulecontent = str_replace( '<ul class="menu">', '<ul class="submenu suckerfish">', $module->content );
				echo $modulecontent; ?>
                <div class="jl_clear"></div>
			</div>
		</div>
	<?php endif;
}
 
/*
 * Module chrome : Responsive
 */
 
function modChrome_responsive($module, &$params, &$attribs)
{ 
	if (isset( $attribs['position'] )) {  $position = $attribs['position'];} else {  $position = '';}

	if (!empty ($module->content)) { ?>

    <div class="moduletable<?php echo htmlspecialchars($params->get('moduleclass_sfx'));?>">
    <div class="module_responsive_out">
    
        <?php if ($module->showtitle) : ?>
		<div class="jl_normal"><h3><?php echo $module->title; ?></h3></div>
        <?php endif; ?>
        
        <div class="jl_small" id="<?php echo $module->id; ?>">
            <h3> 
            <a href="#<?php echo $module->id; ?>"
                title="<?php echo JText::_('TPL_JOOMLIKE_CLICK'); ?>"
                onclick="auf('module_<?php echo $module->id; ?>'); return false"
                class="toggleModule" id="link_<?php echo $module->id?>">
                <?php echo $module->title; ?> 
            </a> 
            </h3>
        </div>
        
        <div class="jl_normal"><?php echo $module->content; ?></div>
        <div class="jl_small" id="module_<?php echo $module->id; ?>" style="display:none"><?php echo $module->content; ?></div>
        
    </div>
    </div>
<?php 
	}
}

?>