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

if($this->countModules('right-1 or right-2 or right-top or right-bottom')) { ?>
    <div id="jl_right">
    <?php if($this->countModules('right-top')) { ?>
        <div class="jl_separate_left">
        <div class="jl_sidebar">
        <div class="jl_module"><jdoc:include type="modules" name="right-top" style="xhtml" /></div>
        </div>
        </div>
    <?php } ?>
    <?php if($this->countModules('right-1')) { ?>
        <div class="jl_user_<?php echo $right_sidebar_col; ?>">
        <div class="jl_separate_left">
        <div class="jl_sidebar">
        <div class="jl_module"><jdoc:include type="modules" name="right-1" style="xhtml" /></div>
        </div>
        </div>
        </div>
    <?php } ?>
    <?php if($this->countModules('right-2')) { ?>
        <div class="jl_user_<?php echo $right_sidebar_col; ?>">
        <div class="jl_separate_left">
        <div class="jl_sidebar">
        <div class="jl_module"><jdoc:include type="modules" name="right-2" style="xhtml" /></div>
        </div>
        </div>
        </div>
    <?php } ?>
    <div class="jl_clear"></div>
    <?php if($this->countModules('right-bottom')) { ?>
        <div class="jl_separate_left">
        <div class="jl_sidebar">
        <div class="jl_module"><jdoc:include type="modules" name="right-bottom" style="xhtml" /></div>
        </div>
        </div>
    <?php } ?>
    </div>
<?php } ?>