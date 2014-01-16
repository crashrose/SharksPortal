<?php 
/**
 *
 * Framework view
 *
 * @version             1.0.0
 * @package             Joomlike Framework
 * @copyright			Copyright (C) 2012 vonfio.de. All rights reserved.
 *               
 */
  
// No direct access.
defined('_JEXEC') or die;

class TemplateLayout
{
	
    function loadBlock($path, $template)
    { 
		require_once 'templates/'.$template.'/layout/' . $path . '.php' ;  
    }
	
    function loadModuleBlock($position, $moduleCounts, $moduleposition, $modulestyle, $position_first)
    {
		
		if ( $position == "top" ) {
			echo '<div id="jl_'. $moduleposition.'"><jdoc:include type="modules" name="'. $moduleposition.'" style="'. $modulestyle .'" /></div>';
		}
		
		if ( $position == "positions" ) {
			if ($position_first == $moduleposition ) { $first = " first"; } else { $first = ""; }
			
			echo '<div class="jl_user_'. $moduleCounts .' '. $first. '">';
				echo '<div class="jl_separate_left">';
					echo '<div class="jl_module">';
						echo '<jdoc:include type="modules" name="'. $moduleposition.'" style="'. $modulestyle .'" />';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		} 
		 
		if ( $position == "user_content" ) {
			if ($position_first == $moduleposition ) { $first = " first"; } else { $first = ""; }
			
			echo '<div class="jl_user_'. $moduleCounts .' '. $first. '">';
					echo '<div class="jl_separate_left">';
						echo '<div class="jl_module">';
						echo '<jdoc:include type="modules" name="'. $moduleposition .'" style="'. $modulestyle .'" position="'. $moduleposition .'" />';
						echo '</div>';
					echo '</div>';
			echo '</div>';
		}
		
		if ( $position == "innercontent" ) {
			
			echo '<div class="jl_user_'. $moduleCounts .' '. $first. '">'; 
				echo '<div class="jl_module">';
					echo '<jdoc:include type="modules" name="'. $moduleposition .'" style="'. $modulestyle .'" position="'. $moduleposition .'" />';
				echo '</div>';
			echo '</div>';
		}
		
		if ( $position == "innercontent_sidebar" ) {
			echo '<div id="jl_'. $moduleposition .'">';
					echo '<div class="jl_sidebar">';
						echo '<div class="jl_module">';
						echo '<jdoc:include type="modules" name="'. $moduleposition .'" style="'. $modulestyle .'" />';
						echo '</div>';
					echo '</div>';
			echo '</div>';
		}
		 
    }
}

?>