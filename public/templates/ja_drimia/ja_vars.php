<?php
/**
 * @copyright	Copyright (C) 2005 - 2007 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

$iso = split( '=', _ISO );
/*echo "<?xml version=\"1.0\" encoding=\"'. $iso[1] .'\"?' .'>";*/
global $ja_color_themes, $ja_header_images, $ja_width_default, $ja_color_default, $ja_font_size_default, $ja_tool, $ja_menutype, $ja_template_path, $ja_template_absolute_path, $ja_headerimg, $ja_color, $ja_width, $ja_font_size, $ja_template_name;
global $jaMainmenuLastItemActive;
$jaMainmenuLastItemActive = false;

$ja_template_name = 'ja_drimia';

# BEGIN: TEMPLATE CONFIGURATIONS ##########
####################################
#support extra color themes
$ja_color_themes = array('default','green','cyan','red'); // You can add more color array if needed
$ja_header_images_wide = array ('header1.jpg','header2.jpg','header3.jpg','header4.jpg','header5.jpg');
$ja_header_images_narrow = array ('header1-n.jpg','header2-n.jpg','header3-n.jpg','header4-n.jpg','header5-n.jpg');
####################################
# Change the width of the template
$ja_width_default = 'wide'; // 'narrow': 800x600; 'wide': 1024x768
# default color
$ja_color_default = 'default'; //blank for default, else pick one of in extra color themes $ja_color_themes
#font size default
$ja_font_size_default = 3;
# Enable users option
$ja_tool = 6; // 0: 0: disable all; 1: Screen tool; 2: font tool; 3: screen + font; 4: color tool; 5: screen + color; 6: font + color; 7: all;
# Choose your prefer Menu Type
$ja_menutype = 1; // 1: Split Menu; 2: Son of Suckerfish Dropdown Menu; 3: Moomenu
# END: TEMPLATE CONFIGURATIONS ##########

# Define the template path ##########
$ja_template_absolute_path = $mosConfig_absolute_path.'/templates/'.$ja_template_name;
include ($ja_template_absolute_path."/ja_templatetools.php");
$ja_template_path = getLiveSiteURL().'/templates/'.$ja_template_name;

//Main navigation
$japarams = new mosParameters('');
$japarams->set( 'menu_images_align', 'left' );
$japarams->set( 'menutype', 'mainmenu' );
switch ($ja_menutype) {
	case 1:
		$menu = "Splitmenu";
		include_once( $ja_template_absolute_path.'/ja_menus/'.$menu.'.class.php' );
		break;
	case 2:
	case 3:
		$menu = "CSSmenu";
		include_once( $ja_template_absolute_path.'/ja_menus/'.$menu.'.class.php' );
		break;
}
$menuclass = "JA_$menu";
$jamenu = new $menuclass ($japarams);

$hasSubnav = false;
if (($jamenu->hasSubMenu (1) && $ja_menutype == 1) ) 
	$hasSubnav = true;
//End for main navigation

# Auto Collapse Divs Functions ##########
$ja_left = mosCountModules( 'left' );
$ja_right = mosCountModules( 'right' );
$ja_masscol = mosCountModules('top');
if ( $ja_left && $ja_right ) {
  //2 columns on the right
	$divid = '';
} elseif ( ($ja_left || $ja_right) && !$ja_masscol ) {
  //One column without masscol
	$divid = '-c';
} elseif (($ja_left || $ja_right) && $ja_masscol) {
  //One column with masscol
	$divid = '-cm';
} elseif ($ja_masscol) {
  //masscol only
	$divid = '-m';
} else {
  //No column in right
	$divid = '-f';
}

$msie='/msie\s(5\.[5-9]|[6]\.[0-9]*).*(win)/i';
$supported_browsers = !isset($_SERVER['HTTP_USER_AGENT']) ||
	!preg_match($msie,$_SERVER['HTTP_USER_AGENT']) ||
	preg_match('/opera/i',$_SERVER['HTTP_USER_AGENT']);

/*********** JA MooTabs Options ****************/
$ja_mootabs_options = "
	width: 			'414px', 
	height: 		'auto', 
	duration:		1000,
	changeTransition: Fx.Transitions.Expo.easeOut,
	animType:		'animMove'
";
/*********** End JA MooTabs ********************/

?>
