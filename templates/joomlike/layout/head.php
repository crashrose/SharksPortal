<?php
/**
 *
 * head view
 *
 * @version             1.0.0
 * @package             Joomlike Framework
 * @copyright			Copyright (C) 2012 vonfio.de. All rights reserved.
 *
 */

// No direct access.
defined('_JEXEC') or die;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >

<head>
<jdoc:include type="head" />

<?php

	require_once 'templates/joomlike/lib/modules.php' ;

    // Instanz von JDocument erzeugen
    $doc = JFactory::getDocument();
    // jQuery Bibliothek vom Google-CDN hinzufügen
    $doc->addScript('http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js');$doc->addScriptDeclaration('jQuery.noConflict();');
    // Hinzufügen unser eigenen Javascript-Datei mit unseren Funktionen
    $doc->addScript($this->baseurl.'/templates/joomlike/javascript/jl_hide.js');
    // jQuery Code zum Initialisieren
       ?>

<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="shortcut icon" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/favicon.ico" />

<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/template.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/menu.css" type="text/css" />

<?php if ($this->direction == 'rtl') : ?>
<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template; ?>/css/template_rtl.css" type="text/css" />
<?php endif; ?>

<link href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template?>/css/style_<?php echo $this->params->get('colorVariation'); ?>.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/typo.css" type="text/css" />

<style type="text/css">

	@font-face { font-family: 'Carrois Gothic'; src: url(<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/fonts/CarroisGothic-Regular.ttf);  }

	#jl_left { width: <?php echo $left_sidebar_width; ?>%; }
	#jl_right { width: <?php echo $right_sidebar_width; ?>%; }
	#jl_right_out, #jl_right_out_right, #jl_content_out, #jl_content_inset1 { width: 100%; }

	#jl_right_out_left, #jl_right_out_left_right { width: <?php echo $left_sidebar_width_2; ?>%; }
	#jl_content_out_right { width: <?php echo $right_sidebar_width_2; ?>%; }

	#jl_contentleft { width: <?php echo $contentleft_sidebar_width; ?>%; }
	#jl_contentright { width: <?php echo $contentright_sidebar_width; ?>%; }
	#jl_content_inset, #jl_content_inset_contentright, #jl_content2_inset, #jl_content_contentleft { width: 100%; }

	#jl_content_inset_contentleft_contentright, #jl_content_inset_contentleft{ width: <?php echo $contentleft_sidebar_width_2; ?>%; }
	#jl_content2_inset_contentright { width: <?php echo $contentright_sidebar_width_2; ?>%; }

	.jl_separate_right { padding-right: <?php echo $cellpadding; ?>; }.jl_un_separate, .jl_separate_left { padding-left: <?php echo $cellpadding; ?>; } #jl_navigation, #jl_header {	padding-bottom: <?php echo $cellpadding; ?>; } .jl_content2_inset, #jl_contentright, #jl_contentleft, .jl_module div, #jl_contentleft, #jl_contentright, .jl_contenttop, .jl_contentbottom{ margin-bottom: <?php echo $cellpadding; ?>; }


	.jl_center { max-width: <?php echo $template_width; ?>;  min-width: 150px;}
	body, p, td, tr {
	<?php echo "font-family: ". $fontfamily .";"; ?>
	<?php echo "font-size: ". $fontsize .";"; ?>
	<?php echo "color: ". $fontcolor .";"; ?>
	}
	#jl_copyright a {	<?php echo "color: ". $fontcolor .";"; ?>	}

	#jl_background, body { background-image: url(<?php echo $this->baseurl; ?>/<?php echo $background; ?>); background-color: <?php echo $backgroundcolor; ?>; }

	a:link, a:visited, ul.menu span.separator { color: <?php echo $linkcolor; ?>; }

</style>

<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/responsive.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template ?>/css/custom.css" type="text/css" />

<!--[if lte IE 6]><style type="text/css">#jl_content_in {width: 98%;}</style><![endif]-->
<!--[if lte IE 7]><style type="text/css">.jl_user_4 { width: 24.979%; }</style><![endif]-->

</head>

<?php if(count($app->getMessageQueue())) : ?>
<jdoc:include type="message" />
<?php endif; ?>