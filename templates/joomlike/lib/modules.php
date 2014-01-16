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

$template_width   					= $this->params->get("templateWidth", "920px");
$sidebar_width   					= $this->params->get("sidebarWidth", "25"); 
$cellpadding   						= $this->params->get("cellpadding", "0.5em"); 
$headerimage   					    = $this->params->get("headerimage");
$headerheight   					= $this->params->get("headerheight");
$background 						= $this->params->get("background");
$backgroundcolor 					= $this->params->get("backgroundcolor");
$fontfamily 						= $this->params->get("fontfamily");
$fontsize 							= $this->params->get("fontsize");
$fontcolor 							= $this->params->get("fontcolor");
$linkcolor 							= $this->params->get("linkcolor");
$backlink 							= $this->params->get("backlink"); 

$p0 			= $this->countModules("position-0"); 		// 0
$p1 			= $this->countModules("position-1"); 		// 1
$p2 			= $this->countModules("position-2"); 		// 2
$p3 			= $this->countModules("position-3"); 		// 3
$p4 			= $this->countModules("position-4"); 		// 4
$p5 			= $this->countModules("position-5"); 		// 5
$p6 			= $this->countModules("position-6"); 		// 6
$p7 			= $this->countModules("position-7"); 		// 7
$p8 			= $this->countModules("position-8"); 		// 8
$p9 			= $this->countModules("position-9"); 		// 9
$p10 			= $this->countModules("position-10"); 		// 10
$p11 			= $this->countModules("position-11"); 		// 11
$p12 			= $this->countModules("position-12"); 		// 12
$p13 			= $this->countModules("position-13"); 		// 13
$p14 			= $this->countModules("position-14"); 		// 14
$p15 			= $this->countModules("position-15"); 		// 15
$p16 			= $this->countModules("position-16"); 		// 16
$left1 			= $this->countModules("left-top"); 			// 17
$left2 			= $this->countModules("left-1"); 			// 18
$left3 			= $this->countModules("left-2"); 			// 19
$left4 			= $this->countModules("left-bottom"); 		// 20
$right1 		= $this->countModules("right-top"); 		// 21
$right2 		= $this->countModules("right-1"); 			// 22
$right3 		= $this->countModules("right-2"); 			// 23
$right4 		= $this->countModules("right-bottom"); 		// 24
$topmenuCount 	= $this->countModules("topmenu"); 			// 25
$articleCount 	= $this->countModules("article"); 			// 26
$searchCount	= $this->countModules("search"); 			// 27 
$logoCount		= $this->countModules("logo"); 				// 28
$contenttop1 	= $this->countModules("content-top1"); 		// 29
$contenttop2 	= $this->countModules("content-top2"); 		// 30
$contentleft 	= $this->countModules("contentleft"); 		// 31
$contentright 	= $this->countModules("contentright"); 		// 32
$contentbottom1 = $this->countModules("content-bottom1"); 	// 33
$contentbottom2 = $this->countModules("content-bottom2"); 	// 34

$position = array ( $p0, $p1, $p2, $p3, $p4, $p5, $p6, $p7, $p8, $p9, $p10, $p11, $p12, $p13, $p14, $p15, $p16, $left1, $left2, $left3, $left4, $right1, $right2,$right3,$right4, $topmenuCount, $articleCount, $searchCount, $logoCount, $contenttop1, $contenttop2,$contentleft, $contentright, $contentbottom1, $contentbottom2 );

for ( $x = 0; $x < 35; $x++ ) {
	if ($position[$x] > 0) { $position[$x] = 1; } else { $position[$x] = 0; }
}

if (( $p1 or $p2 or $p3 or $p4 or $p5 or $p6 ) > 0 ) {
	for ($x = 1; $x <= 6; $x++)  {
		if ($position[$x] > 0) {
			$position_top_first = "position-" . $x;
			break;
		} else {
			$position_top_first =FALSE;
		}
	} 
} 
if (( $p7 or $p8 ) > 0 ) {
	for ($x = 7; $x <= 8; $x++)  {
		if ($position[$x] > 0) {
			$position_first_overcontent = "position-" . $x;
			break;
		} else {
			$position_first_overcontent =	FALSE;
		}
	} 
} 
if (( $p11 or $p12 or $p13 or $p14 or $p15 or $p16 ) > 0 ) {
	for ($x = 11; $x <= 16; $x++)  {
		if ($position[$x] > 0) {
			$position_bottom_first = "position-" . $x;
			break;
		} else {
			$position_bottom_first =FALSE;
		}
	} 
} 
for ($x = 9; $x <= 10; $x++)  {
		if ($position[$x] > 0) {
			$position_first_undercontent = "position-" . $x;
			break;
		} else {
			$position_first_undercontent =	FALSE;
		}
	} 
	
$position_top 		= $p1 + $p2 +  $p3 +  $p4 +  $p5 + $p6 ;
$over_content 		= $p7 +  $p8;
$under_content 		= $p9 +  $p10;
$position_bottom 	= $p11 + $p12 + $p13 + $p14 + $p15 + $p16 ;  

if (( $position[18] > 0 ) and ( $position[19] > 0 )) { $left_sidebar_col = "2"; }
elseif (( $position[18] > 0 ) or ( $position[19] > 0 )) { $left_sidebar_col = "1"; } else { $left_sidebar_col = ""; }
if (( $position[22] > 0 ) and ( $position[23] > 0 )) { $right_sidebar_col = "2"; }
elseif (( $position[22] > 0 ) or ( $position[23] > 0 )) { $right_sidebar_col = "1"; } else { $right_sidebar_col = ""; }

if (( $position[17] > 0 ) or ( $position[18] > 0 ) or ( $position[19] > 0 ) or ( $position[20] > 0 )) { $left = "_left"; } else { $left = ""; }
if (( $position[21] > 0 ) or ( $position[22] > 0 ) or ( $position[23] > 0 ) or ( $position[24] > 0 )) { $right = "_right"; } else { $right = ""; }
if ( $position[31] > 0 ) { $contentleft 	= "_contentleft"; 	} else { $contentleft = ""; }
if ( $position[32] > 0 ) { $contentright 	= "_contentright"; 	} else { $contentright = ""; }
if ( $position[25] > 0 ) { $topmenuCount 	= "_topmenu"; 		} else { $topmenuCount = ""; }
if ( $position[26] > 0 ) { $breaking 		= "_breaking"; 		} else { $breaking = ""; }
if ( $position[27] > 0 ) { $search 			= "_search"; 		} else { $search = ""; }
if ( $logoCount 	   ) { $logoimg 		= "_logo"; 			} else { $logoimg = ""; }
$contenttop 		= $position[29] +  $position[30];
$contentbottom 		= $position[33] +  $position[34];
  


if($this->countModules('left-top or left-1 or left-2 or left-bottom')) {
	$left_sidebar_width 	=	$sidebar_width;
	$left_sidebar_width_2 	=	100 - $left_sidebar_width;
	$right_sidebar_width 	=	$left_sidebar_width * 1.32;
	$right_sidebar_width_2 	=	100 - $right_sidebar_width; 
} else {
	$right_sidebar_width 	=	$sidebar_width;
	$right_sidebar_width_2 	=	100 - $right_sidebar_width;
}

if (($contentleft or $contentright) > 0 ) {
	$contentleft_sidebar_width 		=	$sidebar_width;
	$contentleft_sidebar_width_2 	=	100 - $contentleft_sidebar_width;
	$contentright_sidebar_width 	=	$contentleft_sidebar_width * 1.32;
	$contentright_sidebar_width_2 	=	100 - $contentright_sidebar_width;
}
?>