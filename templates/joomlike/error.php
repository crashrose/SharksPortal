<?php 
/**
 *
 * Error view
 *
 * @version             1.0.0
 * @package             Joomlike Framework
 * @copyright			Copyright (C) 2012 vonfio.de. All rights reserved.
 *               
 */
  
// No direct access.
defined('_JEXEC') or die;

JHTML::_('behavior.framework', true);
$app = JFactory::getApplication();

if (!isset($this->error)) {
	$this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	$this->debug = false;
}
//get language and direction
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;
$this->params = JFactory::getApplication()->getTemplate(true)->params;
$templateURL = $this->baseurl."/templates/".$this->template;

	$logoimage   					    = $this->params->get("logoimage");
	$headerimage   					    = $this->params->get("headerimage");
	 
	$template_width   					= $this->params->get("templateWidth", "920px");
	$sidebar_width   					= $this->params->get("sidebarWidth", "25");
	$logoimage   					    = $this->params->get("logoimage");
	$headerimage   					    = $this->params->get("headerimage");
	$headerheight   					= $this->params->get("headerheight");
	$background 						= $this->params->get("background");
	$backgroundcolor 					= $this->params->get("backgroundcolor");
	$fontfamily 						= $this->params->get("fontfamily");
	$fontsize 							= $this->params->get("fontsize");
	$fontcolor 							= $this->params->get("fontcolor");
	$linkcolor 							= $this->params->get("linkcolor");
	$backlink 							= $this->params->get("backlink"); 
    ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="head" />

<title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>

<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/template.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/menu.css" type="text/css" /> 

<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/style_<?php echo $this->params->get('colorVariation'); ?>.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/typo.css" type="text/css" />

	<?php if ($this->direction == 'rtl') : ?>
	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/error_rtl.css" type="text/css" />
	<?php endif; ?>
    
<style type="text/css">

	@font-face { font-family: 'Carrois Gothic'; src: url(<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/fonts/CarroisGothic-Regular.ttf);  }

	#jl_left { width: <?php echo $left_sidebar_width; ?>%; }
	#jl_right { width: <?php echo $right_sidebar_width; ?>%; }
	#jl_right_out, #jl_right_out_right, #jl_content_out { width: 100%; }
	#jl_right_out_left, #jl_right_out_left_right { width: <?php echo $left_sidebar_width_2; ?>%; }
	#jl_content_out_right { width: <?php echo $right_sidebar_width_2; ?>%; }

	.jl_center { max-width: <?php echo $template_width; ?>;  min-width: 150px;}
	body, p, td, tr {
	<?php echo "font-family: ". $fontfamily .";"; ?> 
	<?php echo "font-size: ". $fontsize .";"; ?>
	<?php echo "color: ". $fontcolor .";"; ?>
	}
	#jl_copyright a {	<?php echo "color: ". $fontcolor .";"; ?>	} 
	
	#jl_background { background-image: url(<?php echo $this->baseurl; ?>/<?php echo $background; ?>); background-color: <?php echo $backgroundcolor; ?>; }
	 
	a:link, a:visited, ul.menu span.separator { color: <?php echo $linkcolor; ?>; } 
	
	#jl_background, body, html, #ct_errorWrapper  { height:100%; overflow: hidden; }
	#ct_errorWrapper h3  { padding:  10px 0; color: #666; }
	#ct_errorWrapper #jl_content { border: 0 none; }
	
	
	 
#jl_mainmenu {  
	padding: 0.4em 0.8em 0 0.8em;
	border: none;
	margin: 0;
	background-repeat: repeat-x; 
	background-position: top;
	border-radius: 5px 5px 0 0; border-left: 1px solid #EEE;border-right: 1px solid #EEE;
}
#jl_mainmenu ul { /* all lists */
	padding: 0;
	margin: 0;
	list-style: none;
	line-height: 1;
}

#jl_mainmenu ul li { 
	list-style: none;
	padding: 0 2px 0 0;
	margin: 0 0 3px 0;
	float: left;
	width: auto; 
}
#jl_mainmenu ul li.active a, #jl_mainmenu ul li#current a, #jl_mainmenu ul li.active:hover ul, #jl_mainmenu ul li#current:hover ul   {

}
#jl_mainmenu ul a, #jl_mainmenu ul .separator {
	color: #FFFFFF;
	text-align: center;
	display: block;
	width: auto;
	margin: 0;
	text-indent: 0;
	padding: 0 13px 0 10px;
	height: 34px;
	line-height: 33px;
	text-decoration: none;
	border: 0 none;
	font-family: 'Carrois Gothic', Helvetica, Arial, sans-serif;
	text-transform: uppercase;
	font-weight: normal;
}
#jl_mainmenu ul li:last-child a, 
#jl_mainmenu ul li:last-child .separator {
	background: url(none); 
} 
#jl_mainmenu ul li li a, #jl_mainmenu ul li li .separator {
	font-family: Helvetica, Arial, sans-serif;
	text-transform: none;
}

#jl_mainmenu ul a:hover {
	text-decoration: none;
}
#jl_mainmenu ul li.current, #jl_mainmenu ul li.active  {
	position: relative;
	margin: -12px 0 0 -7px;
	height: 49px;  
	padding: 0 8px 0 0;
	background: url(../images/navover_right.png) top right no-repeat; 
}
#jl_mainmenu ul li.current a, #jl_mainmenu ul li.current .separator, #jl_mainmenu ul li.active a, #jl_mainmenu ul li.active .separator {
	color: #999; 
	height: 49px;
	line-height: 49px;
	background: url(../images/navover_left.png) top left no-repeat;
	padding: 0 10px 0 18px; 
}
#jl_mainmenu ul li.current a:hover,
#jl_mainmenu ul li.current:hover,
#jl_mainmenu ul li.active:hover,
#jl_mainmenu ul li.active a:hover,
#jl_mainmenu ul li.active a:hover, #jl_mainmenu ul li.active ul  {
	background-color: transparent !important;
} 

</style>
  
</head>

<body>
  
<div id="ct_errorWrapper">
<div id="jl_background">
<div id="jl_bg">

<div class="jl_container">

    <div class="jl_center">
    
        <!-- Top -->
        <div id="jl_top">
    
			<?php if($logoimage) { ?>
            <div id="jl_topleft_search">
                <div id="jl_logo">
                <a href="<?php echo $this->baseurl; ?>"><img src="<?php echo $this->baseurl; ?>/<?php echo $logoimage; ?>"   /></a>
                </div>
            </div>
            <?php } ?>
            
            <div id="jl_topright_search_logo">
            <div id="jl_search">
            <?php $module = JModuleHelper::getModule( 'search' );
            echo JModuleHelper::renderModule( $module);	?>
            </div>
            </div>
            
            <div class="jl_clear"></div>
        
		</div>
    	<!-- Top -- End -->
        
        <!-- Navigation Bar -->
        <div id="jl_navigation">
        <div id="jl_navigation_inner">
            <div id="jl_mainmenu">
            	<?php $module = JModuleHelper::getModule( 'menu' );
                    echo JModuleHelper::renderModule( $module);	?>
                    <div class="jl_clear"></div>     
            </div>
        </div>
        <div class="jl_clear"></div>
        </div> 
        <!-- Navigation Bar -- End -->
                        
        <!-- White Container -->
        <div class="jl_white">
        
        <?php if( isset($headerimage) ) {?>
        <!-- Header -->
            <div id="jl_header">
            <div id="jl_headerimage">
                <img src="<?php echo $this->baseurl; ?>/<?php echo $headerimage; ?>" /> 
                <div class="jl_clear"></div>
            </div>
            </div>
        <!-- Header End -->
        <?php } ?>
        
        <!-- Container Main -->
        <div id="jl_maincontent">
            
            <div id="jl_content" >
              
                <div id="jl_content_in">
                
                <h1>#<?php echo $this->error->getCode() ; ?>&nbsp;<?php echo $this->error->getMessage();?></h1>
                        
                <h2><?php echo JText::_('JERROR_AN_ERROR_HAS_OCCURRED'); ?><br />
                <?php echo JText::_('JERROR_LAYOUT_PAGE_NOT_FOUND'); ?></h2>
                
                <h3><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?></h3>
                
                <?php if ($this->debug) :
                    echo $this->renderBacktrace();
                endif; ?>
                
                </div>
    
            </div>
            
            <div class="jl_clear"></div>
            
        </div>
        <!-- Container Main -- End -->
            
        </div>
        <!-- White Container -- End -->
        
	<div id="jl_footer">
	<div id="jl_footer_hr">
    
		<div id="jl_footer_left">
                        <?php $module = JModuleHelper::getModule( 'footer' );
                    echo JModuleHelper::renderModule( $module);	?>
            <div id="jl_copyright"><a href="http://www.vonfio.de">Free Joomla Template</a> vonFio.de</div>
		</div>
        
		<div id="jl_footer_right">
                        <?php $module = JModuleHelper::getModule( 'footer-nav' );
                    echo JModuleHelper::renderModule( $module);	?>
        </div>
    
    </div>
        <div class="jl_clear"></div>
    </div>
    
	<div id="jl_bottom_left"><div id="jl_bottom_right"></div></div>
        
    </div> 
    
</div>

</div>
</div>
</div>

</body>
</html>
