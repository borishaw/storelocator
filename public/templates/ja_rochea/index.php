<?php
/*------------------------------------------------------------------------
# JA Rochea - May, 2007
# ------------------------------------------------------------------------
# Copyright (C) 2004-2006 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
-------------------------------------------------------------------------*/

defined( '_VALID_MOS' ) or die( 'Restricted access' );
$iso = split( '=', _ISO );
/*echo "<?xml version=\"1.0\" encoding=\"'. $iso[1] .'\"?' .'>";*/
global $ja_color_themes, $ja_header_images, $ja_width_default, $ja_color_default,
$ja_font_size_default, $ja_tool, $ja_menutype, $ja_template_path, $ja_template_absolute_path,
$ja_headerimg, $ja_color, $ja_width, $ja_font_size, $ja_template_name;

$ja_template_name = 'ja_rochea';

# BEGIN: TEMPLATE CONFIGURATIONS ##########
####################################
#support extra color themes
$ja_color_themes = array('default','dark','red'); // You can add more color array if needed
#Header images: you can add more subheader images. Please refer to User Guide for full information
$ja_header_images = array('sh01','sh02','sh03','sh04','sh05','sh06'); // Each sub header image will be assigned to each menu
####################################
# Change the width of the template
$ja_width_default = 'narrow'; // 'narrow': 800x600; 'wide': 1024x768
# default color
$ja_color_default = 'dark'; //blank for default, else pick one of in extra color themes $ja_color_themes
#font size default
$ja_font_size_default = 3;
# Enable users option
$ja_tool = 0; // 0: 0: disable all; 1: Screen tool; 2: font tool; 3: screen + font; 4: color tool; 5: screen + color; 6: font + color; 7: all;
# Choose your prefer Menu Type
$ja_menutype = 2; // 1: Split Menu; 2: Son of Suckerfish Dropdown Menu; 3: Transmenu;
# Header background image
$ja_header_type = 0; // 0: no header image; 1: header image for each menu item; 2: random header
# END: TEMPLATE CONFIGURATIONS ##########

# Define the template path ##########
$ja_template_path = $mosConfig_live_site.'/templates/'.$ja_template_name;
$ja_template_absolute_path = $mosConfig_absolute_path.'/templates/'.$ja_template_name;
include ($ja_template_absolute_path."/ja_templatetools.php");

$topnav = "";
$subnav = "";
if ($ja_menutype == 1) {
	require($ja_template_absolute_path."/ja_splitmenu.php");
	$topnav = ja_topNav('mainmenu', array('default'));
	$subnav = ja_subNav('mainmenu');
}

# Auto Collapse Divs Functions ##########
$ja_left = mosCountModules('left') || mosCountModules('user4');
$ja_right = mosCountModules('right');

if ( $ja_left && $ja_right ) {
	$divid = '';
	} elseif ( $ja_left ) {
	$divid = '-fr';
	} elseif ( $ja_right ) {
	$divid = '-fl';
	} else {
	$divid = '-f';
}

$ja_headerimg = "";
if ($ja_header_type == 1) {
	$ja_headerimg = $ja_header_images [getCurrentMenuIndex() % count($ja_header_images)];
	if (!is_file("$ja_template_absolute_path/images/headers/$ja_headerimg-bg1.jpg")) $ja_headerimg = $ja_header_images [0];
}
if ($ja_header_type == 2) {
	$ja_headerimg = $ja_header_images[rand (0, count($ja_header_images)-1)];
	if (!is_file("$ja_template_absolute_path/images/headers/$ja_headerimg-bg1.jpg")) $ja_headerimg = $ja_header_images [0];
}

$ja_tool_left = 0;
switch ($ja_tool) {
	case 0: $ja_tool_left = 0; break;
	case 1: $ja_tool_left = -30; break;
	case 2: $ja_tool_left = -30; break;
	case 3: $ja_tool_left = -80; break;
	case 4: $ja_tool_left = -30; break;
	case 5: $ja_tool_left = -80; break;
	case 6: $ja_tool_left = -100; break;
	case 7: $ja_tool_left = -130; break;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php mosShowHead(); ?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<link href="<?php echo $ja_template_path;?>/css/template_css.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript" src="<?php echo $ja_template_path;?>/scripts/ja.script.js"></script>

<?php genMenuHead(); ?>

<?php if ( $my->id ) { initEditor(); } ?>

<!--[if lte IE 6]>
<style type="text/css">
.clearfix {height: 1%;}
#ja-subhead div.innerpad {
	background: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $ja_template_path;?>/images/top-bg-narrow.png', sizingMethod='crop');
}
.wide #ja-subhead div.innerpad {
	background: none;
	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $ja_template_path;?>/images/top-bg.png', sizingMethod='crop');
}

</style>
<![endif]-->

<!--[if gte IE 7.0]>
<style type="text/css">
.clearfix {display: inline-block;}
</style>
<![endif]-->

<link href="<?php echo $ja_template_path;?>/css/colors/<?php echo $ja_color; ?>.css" rel="stylesheet" type="text/css" />

</head>

<body id="bd" class="<?php echo "$ja_width fs".$ja_font_size;?>">
<a name="Top" id="Top"></a>

<ul class="accessibility">
	<li><a href="<?php echo getCurrentURL();?>#ja-content" title="Skip to content">Skip to content</a></li>
	<li><a href="<?php echo getCurrentURL();?>#ja-mainnav" title="">Skip to main navigation</a></li>
	<li><a href="<?php echo getCurrentURL();?>#ja-col1" title="">Skip to 1st column</a></li>
	<li><a href="<?php echo getCurrentURL();?>#ja-col2" title="">Skip to 2nd column</a></li>
</ul>

<div id="ja-wrapper">

<!-- BEGIN: HEADER -->
<div id="ja-header">

	<div class="clearfix">
	<h1>
		<a href="index.php">
			<?php echo $mosConfig_sitename?>
		</a>
	</h1>

	<!-- BEGIN: MAIN NAVIGATION -->
	<div id="ja-mainnavwrap">
	<div id="ja-mainnav">
	<?php
		switch ($ja_menutype) {
			case 1: echo $topnav;
			break;
			case 2:
				include($ja_template_absolute_path."/ja_cssmenu.php");
			break;
			case 3:
				include($ja_template_absolute_path."/ja_transmenu.php");
			case 4:
				echo $topnav;
			break;
		}
	?>
	</div>

	<?php if ($ja_tool) {?>
	<div id="ja-usertoolswrap">
		<span class="ja-sitetool">&nbsp;</span>
		<div id="ja-usertools" style="left:<?php echo $ja_tool_left; ?>px">
			<?php genToolMenu($ja_tool); ?>
		</div>
	</div>
	<?php } ?>
	</div>
	<!-- END: MAIN NAVIGATION -->

	<?php if ($subnav) { ?>
	<div id="ja-subnav" class="clearfix">
		<?php echo $subnav; ?>
	</div>
	<?php } else { ?>
	<div class="header-sep"></div>
	<?php } ?>

	</div>

	<div id="ja-subhead" style="background: url(<?php echo "$ja_template_path/images/headers/$ja_headerimg-bg1.jpg";?>) no-repeat bottom left;">
		<div class="innerpad">
			<?php	echo mosLoadModules ( 'top',-2 ); ?>
		</div>
	</div>

</div>
<!-- END: HEADER -->

<div id="ja-container<?php echo $divid; ?>" class="clearfix">

	<!-- BEGIN: CONTENT -->

	<div id="ja-mainbody<?php echo $divid; ?>">
	<div id="ja-contentwrap">

		<div id="ja-content">

		<?php
		$spotlight = array ('user1','user2','user5');
		$topspl = calSpotlight ($spotlight);
		if( $topspl ) {
		?>
		<!-- BEGIN: TOP SPOTLIGHT -->
		<div id="ja-topslwrap">
			<div id="ja-topsl" class="clearfix">

			  <?php if( mosCountModules('user1') ) {?>
			  <div class="ja-box<?php echo $topspl['modules']['user1']; ?>" style="width: <?php echo $topspl['width']; ?>;">
			    <?php mosLoadModules('user1', -2); ?>
			  </div>
			  <?php } ?>

			  <?php if( mosCountModules('user2') ) {?>
			  <div class="ja-box<?php echo $topspl['modules']['user2']; ?>" style="width: <?php echo $topspl['width']; ?>;">
			    <?php mosLoadModules('user2', -2); ?>
			  </div>
			  <?php } ?>

			  <?php if( mosCountModules('user5') ) {?>
			  <div class="ja-box<?php echo $topspl['modules']['user5']; ?>" style="width: <?php echo $topspl['width']; ?>;">
			    <?php mosLoadModules('user5', -2); ?>
			  </div>
			  <?php } ?>

			</div>
			<div class="sep"></div>
		</div>
		<!-- END: TOP SPOTLIGHT -->
		<?php } ?>

		<?php if ($option != 'com_frontpage') {?>
		<div id="ja-pathway">
			<div class="innerpad">
				<?php mosPathway(); ?>
			</div>
		</div><div class="clr"></div>
		<?php } ?>

		<?php mosMainBody(); ?>

		<?php if ( mosCountModules('banner') ) { ?>
		<div id="ja-banner">
			<?php	echo mosLoadModules ( 'banner',-1 ); ?>
		</div>
		<?php } ?>

		</div>
	</div>
	<!-- END: CONTENT -->

	<?php if ($ja_right) { ?>
	<!-- BEGIN: RIGHT COLUMN -->
	<div id="ja-col2">
		<div class="innerpad">
		<?php	echo mosLoadModules ( 'right',-3 );?>
		</div>

<p><a href="http://hansdairy.com/index.php/Contact-Us/">
<img border="0" src="http://www.hansdairy.com/images/contact-now.gif" width="140" height="40"></a></p>


	</div>
	<!-- END: RIGHT COLUMN -->
	<?php } ?>

	</div>

	<?php if ($ja_left) { ?>
	<!-- BEGIN: LEFT COLUMN -->
	<div id="ja-col1" style="background: url(<?php echo "$ja_template_path/images/headers/$ja_headerimg-bg2-$ja_width.jpg";?>) no-repeat top left;">
		<div class="innerpad">

		<?php if (mosCountModules('user4')) {?>
		<div id="ja-search">
			<?php mosLoadModules ( 'user4', -2 ); ?>
		</div>
		<?php } ?>

		<?php	echo mosLoadModules ( 'left',-2 );?>
		</div>
	</div>
	<br />
	<!-- END: LEFT COLUMN -->
	<?php } ?>

</div>

<!-- BEGIN: FOOTER -->
<?php if ( mosCountModules('user3') ) { ?>
<div id="ja-botnavwrap" class="clearfix">
	<small>www.HANSDAIRY.com</small>
	<div id="ja-botnav" class="clearfix">
		<?php mosLoadModules ( 'user3',-1 ); ?>
		<ul class="accessibility">
			<li><a title="Go to Top" href="<?php echo getCurrentURL();?>#Top" class="gotop-button">Top</a></li>
		</ul>
	</div>
</div>
<?php } ?>

<div id="logo-ext">
  <a href="index.php"><img src="<?php echo $ja_template_path;?>/images/logo-ext-<?php echo $ja_color;?>.gif" alt="<?php echo $mosConfig_sitename?>" /></a>
</div>

<div id="ja-footer">
	<?php include_once( $ja_template_absolute_path.'/footer.php' ); ?>
	<div class="clr"></div>
</div>
<!-- END: FOOTER -->

</div>

<?php mosLoadModules( 'debug', -1 );?>
</body>

</html>