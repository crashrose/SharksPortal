<?php 

/**

 *

 * Component view

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

	#ct_errorWrapper h3  { padding: 10px; color: #666; }

	#ct_errorWrapper #jl_content { border: 0 none; }

</style>

   

<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/print.css" type="text/css" media="Print" />



</head>

<body class="contentpane">

        <div class="ct_popup_bg" style="margin: 0; padding: 0 10px;">

            <jdoc:include type="component" />

        </div>

</body>

</html>