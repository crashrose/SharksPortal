<?php
/**
* @version joomla 1.6x 1.0 $
* @package Donation Thermometer
* @copyright (C) 2011 Jodee Millman
* @license http://creativecommons.org/licenses/by/2.5/
* @version 1.7.0 $
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Restricted access');

$datename = $params->get('datename');
$current1 = $params->get('current1');
$current2 = $params->get('current2');
$goal1 = $params->get('goal1');
$goal2 = $params->get('goal2');
$height1 = $params->get('height1');
$font1 = $params->get('font1');
$font2 = $params->get('font2');
$font3 = $params->get('font3');
$fontsize1 = $params->get('fontsize1');
$fontsize2 = $params->get('fontsize2');
$fontsize3 = $params->get('fontsize3');
$fontsize4 = $params->get('fontsize4');
$barbgcolor = $params->get('barbgcolor');
$barfgcolor = $params->get('barfgcolor');
$txcolor1 = $params->get('txcolor1');
$txcolor2 = $params->get('txcolor2');
$txcolor3 = $params->get('txcolor3');
$txcolor4 = $params->get('txcolor4');
$currency1 = $params->get('currency1');
$currency2 = $params->get('currency2');
$date1 = $params->get('date1');
$bulbimage = $params->get('bulbimage');
$pretext1 = $params->get('pretext1');
$posttext1 = $params->get('posttext1');
$thermborder = $params->get('thermborder');
$thermbordertype = $params->get('thermbordertype');
$thermbordercolor = $params->get('thermbordercolor');
$addstyle1 = $params->get('addstyle1');
$addstyle2 = $params->get('addstyle2');
$addstyle3 = $params->get('addstyle3');
$number1 = 35;
$barbgheight = $height1 - $number1;
$whitebarheight = 100 - (($current1 / $goal1) * 100);
$imageheight = $height1 - 58;
$bulbplacement = $imageheight + 12;
$bulbtextplacement = $imageheight + 28;
$thermometerheight = $height1 - 46;
$bulbpercent = (($current1 / $goal1) * 100);
$rounded_number = round($bulbpercent);

?>

<div id="dtcontainall" style="width:100%; border: 0px;">
    <div id="dtpretext" style="width: 100%; font-family: <?php echo $font2; ?>; font-size: <?php echo $fontsize3; ?>px; color: <?php echo $txcolor3; ?>; border: 0px; <?php echo $addstyle1; ?>"><?php echo $pretext1; ?></div>
    <div id="dtcontain" style="width: 150px; border: <?php echo $thermborder; ?>px <?php echo $thermbordertype; ?> <?php echo $thermbordercolor; ?>;">
        <div id="dtspacer1" style="height:5px; position:relative; border: 0px;"></div>
        <div id="dtgoalamount" style="width: 70px; margin-left: 60px; padding: 0px; position: relative; border: 0px; text-align: left; color:<?php echo $txcolor2; ?>; font-family: <?php echo $font1; ?>; font-size: <?php echo $fontsize2, "px; ", $addstyle2; ?>"><?php echo $currency1, " ", $goal1; if ($goal2 != "") {echo "<br/>", $currency2, " ", $goal2;}?></div>
        <div id="dtcontainer" style="height: <?php echo $height1; ?>px; width: 140px; margin-left: 0px; padding: 0px; position: relative; border: 0px;">
            <div id="dtthermometer" style="height: <?php echo $thermometerheight; ?>px; width: 30px; margin-top: 0px; margin-left: 20px; padding: 0px; position: absolute; border: 0px;">
                <div id="dtbarbg" style="background: <?php echo $barbgcolor; ?>; height:<?php echo $barbgheight; ?>px; width: 30px; margin-left: 0px; margin-top: 0px; padding: 0px; position: absolute; z-index: 11; border: 0px;"></div>
                <div id="dtwhitebar" style="background: <?php echo $barfgcolor; ?>; height: <?php echo $whitebarheight; ?>%; width: 30px; margin-left: 0px; margin-top: 0px; padding: 0px; position: absolute; z-index: 12; border: 0px;"></div>
                <div id="dtthermometerimage1" style="width:120px; margin-left: 0px; margin-top: 0px; padding: 0px; position: absolute; z-index: 13; border: 0px;">
                    <img id="thermometertop" src="modules/mod_donthermometer/thermometertop.png" style="margin:0px; padding:0px;" alt="donation thermometer" border="0" height="12px" width="30px" align="left" /><br />
                </div>
                <div id="dtthermometerimage2" style="width:120px; margin-left: 0px; margin-top: 12px; padding: 0px; position: absolute; z-index: 13; border: 0px;">                                        
                    <img id="thermometermid" src="modules/mod_donthermometer/thermometermid.png" style="margin:0px; padding:0px;" alt="donation thermometer" border="0" height="<?php echo $imageheight; ?>px" width="30px" align="left" /><br />
                </div>
            </div>
            <div id="dtthermgraph" style="width: 75px; height: <?php echo $thermometerheight; ?>px; float: right; position: absolute; margin-left: 50px;">
                <div id="dtcol1row1" style="width: 5px; height: 0px; float: left; position: relative; border-top: 1px solid <?php echo $txcolor2; ?>;"></div>
                <div id="dtcol1row2" style="width: 5px; height: <?php echo $whitebarheight; ?>%; float: left; position: relative;"></div>
                <div id="dtcol2row2" style="width: 65px; height: <?php echo $whitebarheight; ?>%; float: right; position: relative;"></div>
                <div id="dtcol1row3" style="width: 5px; float: left; position: relative; border-top: 1px solid <?php echo $txcolor2; ?>;"></div>
                <div id="dtcol2row3" style="width: 65px; float: right; position: relative; margin-left: 5px; color:<?php echo $txcolor2; ?>; font-family: <?php echo $font1; ?>; font-size: <?php echo $fontsize2; ?>px; <?php echo $addstyle2; ?>"><?php echo $currency1, " ", $current1; if ($goal2 != "") {echo "<br/>", $currency2, " ", $current2;} ?></div>
            </div>
            <div id="dtimagebulb" style="width:140px; margin-top: <?php echo $bulbplacement; ?>px; margin-left: 10px; z-index: 13; position: absolute;">
                <img id="dtbulbimage" src="modules/mod_donthermometer/<?php echo $bulbimage; ?>" style="margin:0px; padding:0px;" alt="donation thermometer" border="0" height="46px" width="50px" align="left" />
            </div>
            <div id="dtbulbtext" style="width: 50px; margin-top: <?php echo $bulbtextplacement; ?>px; margin-left: 10px; z-index: 14; position: absolute;"><div align="center" style="width:50px; font-family: <?php echo $font1; ?>; font-size: <?php echo $fontsize1; ?>px; color: <?php echo $txcolor1; ?>; font-weight: bold; text-align: center;"><?php echo $rounded_number; ?>%</div></div>
            <div id="dtlastupdated" style="width: 70px; position: absolute; bottom: 0px; right: 0px; font-family: <?php echo $font1; ?>; font-size: <?php echo $fontsize2; ?>px; color:<?php echo $txcolor2; ?>; text-align: right; <?php echo $addstyle2; ?>"><?php echo $datename; ?><br /><?php echo $date1; ?></div>
        </div>
        <div id="dtspacer2" style="height:5px; position:relative; border: 0px;"></div>
    </div>
    <div id="dtposttext" style="width: 100%; font-family: <?php echo $font3; ?>; font-size: <?php echo $fontsize4; ?>px; color: <?php echo $txcolor4; ?>; border: 0px; <?php echo $addstyle3; ?>"><?php echo $posttext1; ?></div>
</div>