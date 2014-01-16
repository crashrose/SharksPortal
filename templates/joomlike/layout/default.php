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
    
<body class="jl_style_<?php echo $this->params->get('colorVariation'); ?>">

<div id="jl_background">
<div id="jl_bg">

<div class="jl_container">

<div class="jl_center">

    <!-- Top -->
	<?php if($this->countModules('logo or article or topmenu or search')) { ?>
	<div id="jl_top">
    
		<?php if($this->countModules('logo')) { ?>
		<div id="jl_topleft<?php echo $breaking . $topmenuCount . $search; ?>">
        	<div id="jl_logo">
            <a href="<?php echo $this->baseurl; ?>"> 
                <jdoc:include type="modules" name="logo" style="xhtml" />
            </a>
            </div>
        </div>
	    <?php } ?>
        
		<?php if($this->countModules('article or topmenu or search')) { ?>
			<div id="jl_topright<?php echo $breaking . $topmenuCount . $search . $logoimg; ?>">
            
                <?php if($this->countModules('article')) { $joomlikelayout->loadModuleBlock('top', '', 'article', 'xhtml', ''); } ?>
                <?php if($this->countModules('topmenu')) { $joomlikelayout->loadModuleBlock('top', '', 'topmenu', 'responsive', ''); } ?>
                <?php if($this->countModules('search')) { $joomlikelayout->loadModuleBlock('top', '', 'search', 'xhtml', ''); } ?>
                
	        </div>
	    <?php } ?>
        
        <div class="jl_clear"></div>
	</div>
    <?php } ?>
    <!-- Top -- End -->
	
    <!-- Navigation Bar -->
	<?php  if( ($mainmenu_show = 1) or ($submenu_show = 1) ) { ?>
    <div id="jl_navigation">
	<div id="jl_navigation_inner">
    	<jdoc:include type="modules" name="mainmenu" style="mainmenu" />
        <jdoc:include type="modules" name="submenu" style="submenu" />
    </div>
    <div class="jl_clear"></div>
    
    <!-- Toolbar -->
    <?php if($this->countModules('toolbar or login')) { ?>
    <div id="jl_toolbar">
    	<div class="left"><jdoc:include type="modules" name="toolbar" style="xhtml" /></div>
    	<div class="right"><jdoc:include type="modules" name="login" style="xhtml" /></div>
        <div class="jl_clear"></div>
    </div>
    <?php } ?>
    <!-- Toolbar -- End --> 
    
    </div>
    <?php } ?>
	<!-- Navigation Bar -- End -->
                    
    <!-- White Container -->
    <div class="jl_white">
    
    <!-- Header -->
    <?php if( $this->countModules('header') ) {?>
    <div id="jl_header">
	    <div id="jl_headerimage">  
            <div class="jl_header"><jdoc:include type="modules" name="header" style="xhtml" /></div> 
            <div class="jl_clear"></div>
        </div>
	</div>
    <?php } ?>
    <!-- Header End -->    
    
    <!-- Container Main -->
    <div id="jl_container_main">
        
        <!-- Position 1, 2, 3 , 4 , 5 , 6 --> 
		<?php if($this->countModules('position-1 or position-2 or position-3 or position-4 or position-5 or position-6')) : ?>
	        <div class="jl_positions">
            
			<?php if($this->countModules('position-1')) { $joomlikelayout->loadModuleBlock('positions', $position_top, 'position-1', 'responsive', $position_top_first); } ?>
			<?php if($this->countModules('position-2')) { $joomlikelayout->loadModuleBlock('positions', $position_top, 'position-2', 'responsive', $position_top_first); } ?>
			<?php if($this->countModules('position-3')) { $joomlikelayout->loadModuleBlock('positions', $position_top, 'position-3', 'responsive', $position_top_first); } ?>
            <?php if($this->countModules('position-4')) { $joomlikelayout->loadModuleBlock('positions', $position_top, 'position-4', 'responsive', $position_top_first); } ?>
			<?php if($this->countModules('position-5')) { $joomlikelayout->loadModuleBlock('positions', $position_top, 'position-5', 'responsive', $position_top_first); } ?>
            <?php if($this->countModules('position-6')) { $joomlikelayout->loadModuleBlock('positions', $position_top, 'position-6', 'responsive', $position_top_first); } ?>
            
            <div class="jl_clear"></div>
            
	        </div>
        <?php endif; ?>
        <!-- Position 1, 2, 3 , 4 , 5 , 6 -- End --> 
        
        <div id="jl_maincontent">
        
        	<div id="jl_right_out<?php echo $left . $right; ?>">
            
            	<div id="jl_content_out<?php echo $right; ?>">
                 
        			<!-- Position 7 , 8 --> 
	                <?php if($this->countModules('position-7 or position-8')) { 
	        		echo '<div class="jl_over_content">';
						if($this->countModules('position-7')) { $joomlikelayout->loadModuleBlock('user_content', $over_content, 'position-7', 'responsive', $position_first_overcontent); }
						if($this->countModules('position-8')) { $joomlikelayout->loadModuleBlock('user_content', $over_content, 'position-8', 'responsive', $position_first_overcontent); }
					echo '</div>';
                    } ?>
        			<!-- Position 7 , 8 -- End --> 
                    
                    <div id="jl_maincontent_2">
                        
                        <div id="jl_content_inset<?php echo $contentleft . $contentright; ?>">
                        
                            <div id="jl_content2_inset<?php echo $contentright; ?>" class="jl_content2_inset">
                            
								<?php if($this->countModules('content-top1 or content-top2')) { ?>
                                <div class="jl_contenttop">
                                
                                <?php if($this->countModules('content-top1')) { 
                                $joomlikelayout->loadModuleBlock('innercontent', $contenttop, 'content-top1', 'responsive', $position_first_contenttop); 
                                }
								if($this->countModules('content-top2')) { 
                                $joomlikelayout->loadModuleBlock('innercontent', $contenttop, 'content-top2', 'responsive', $position_first_contenttop); 
                                } ?>
                                <div class="jl_clear"></div>
                                
                                </div>
                                <?php } ?>
                            
                                <?php if($this->countModules('breadcrumbs')) { $joomlikelayout->loadModuleBlock('top', '', 'breadcrumbs', 'xhtml', '');  } ?>
                                
                                <div id="jl_content">
                                <div id="jl_content_component"><jdoc:include type="component" /></div>
                                <div class="jl_clear"></div>
                                </div>
                                
                                
								<?php if($this->countModules('content-bottom1 or content-bottom2')) { ?>
                                <div class="jl_contentbottom">
                                
                                <?php if($this->countModules('content-bottom1')) { 
                                $joomlikelayout->loadModuleBlock('innercontent', $contentbottom, 'content-bottom1', 'responsive', ''); 
                                }
								if($this->countModules('content-bottom2')) { 
                                $joomlikelayout->loadModuleBlock('innercontent', $contentbottom, 'content-bottom2', 'responsive', ''); 
                                } ?>
                                <div class="jl_clear"></div>
                                
                                </div>
                                <?php } ?>
                                
                                
                            </div>
                            
                            <!-- Inset 2 --> 
                            <?php if($this->countModules('contentright')) { $joomlikelayout->loadModuleBlock('innercontent_sidebar', '', 'contentright', 'xhtml', ''); } ?>
                        
                        </div>
                        
                        <!-- Inset 1 -->
                        <?php if($this->countModules('contentleft')) { $joomlikelayout->loadModuleBlock('innercontent_sidebar', '', 'contentleft', 'xhtml', ''); } ?>
                     
		            </div>
                            
        			<!-- Position 9 , 10 --> 
	                <?php if($this->countModules('position-9 or position-10')) {
	        		echo '<div class="jl_under_content">';
						if($this->countModules('position-9')) { $joomlikelayout->loadModuleBlock('user_content', $under_content, 'position-9', 'responsive', $position_first_undercontent); } 
						if($this->countModules('position-10')) { $joomlikelayout->loadModuleBlock('user_content', $under_content, 'position-10', 'responsive', $position_first_undercontent); } 
					echo '</div>';
                    } ?>
        			<!-- Position 9 , 10 -- End --> 
				</div>
                
    			<!-- Right -->   
				<?php require_once 'templates/joomlike/layout/sidebar_right.php';  ?>
    			<!-- Right -- End -->  
                
			</div>
                
    		<!-- Left -->     
			<?php require_once 'templates/joomlike/layout/sidebar_left.php';  ?>
    		<!-- Left -- End -->     
                 
		</div>
        
        <div class="jl_clear"></div>
              
    	<!-- Position 11 , 12, 13, 14, 15, 16 -->      
		<?php if($this->countModules('position-11 or position-12 or position-13 or position-14 or position-15 or position-16')) : ?>
	        <div class="jl_positions">
            <?php if($this->countModules('position-11')) { $joomlikelayout->loadModuleBlock('positions', $position_bottom, 'position-11', 'xhtml', $position_bottom_first); } ?>
            <?php if($this->countModules('position-12')) { $joomlikelayout->loadModuleBlock('positions', $position_bottom, 'position-12', 'xhtml', $position_bottom_first); } ?>
            <?php if($this->countModules('position-13')) { $joomlikelayout->loadModuleBlock('positions', $position_bottom, 'position-13', 'xhtml', $position_bottom_first); } ?>
            <?php if($this->countModules('position-14')) { $joomlikelayout->loadModuleBlock('positions', $position_bottom, 'position-14', 'xhtml', $position_bottom_first); } ?>
            <?php if($this->countModules('position-15')) { $joomlikelayout->loadModuleBlock('positions', $position_bottom, 'position-15', 'xhtml', $position_bottom_first); } ?>
            <?php if($this->countModules('position-16')) { $joomlikelayout->loadModuleBlock('positions', $position_bottom, 'position-16', 'xhtml', $position_bottom_first); } ?>
            <div class="jl_clear"></div>
	        </div>
        <?php endif; ?>
    	<!-- Position 11 , 12, 13, 14, 15, 16 -- End -->
    
    </div>
    <!-- Container Main -- End -->
	    
	</div>
    <!-- White Container -- End -->
    
	<?php $joomlikelayout->loadBlock('footer', $this->template);  ?>  

</div>
<!-- Center -- End -->
</div>
<!-- Container -- End -->
</div>
<!-- Background -- End -->
</div>
 
</body>
</html>