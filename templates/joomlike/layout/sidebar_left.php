<?php
/**
 *
 * Default view
 *
 * @version             1.0.0
 * @package             Joomlike Framework
 * @copyright			Copyright (C) 2012 vonfio.de. All rights reserved.
 *
 */
// No direct access.
defined('_JEXEC') or die;
?>

<?php if($this->countModules('left-top or left-1 or left-2 or left-bottom')) { ?>
    <div id="jl_left">
		<?php if($this->countModules('left-top')) { ?>
            <div class="jl_separate_right">
            <div class="jl_sidebar">
            <div class="jl_module"><jdoc:include type="modules" name="left-top" style="xhtml" /></div>
            </div>
            </div>
        <?php } ?>
        <?php if($this->countModules('left-1')) { ?>
            <div class="jl_user_<?php echo $left_sidebar_col; ?>">
            <div class="jl_separate_right">
            <div class="jl_sidebar">
            <div class="jl_module"><jdoc:include type="modules" name="left-1" style="xhtml" /></div>
            </div>
            </div>
            </div>
        <?php } ?>
        <?php if($this->countModules('left-2')) { ?>
            <div class="jl_user_<?php echo $left_sidebar_col; ?>">
            <div class="jl_separate_right">
            <div class="jl_sidebar">
            <div class="jl_module"><jdoc:include type="modules" name="left-2" style="xhtml" /></div>
            </div>
            </div>
            </div>
        <?php } ?>
        <div class="jl_clear"></div>
        <?php if($this->countModules('left-bottom')) { ?>
            <div class="jl_separate_right">
            <div class="jl_sidebar">
            <div class="jl_module"><jdoc:include type="modules" name="left-bottom" style="xhtml" /></div>
            </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>