<?php
/*------------------------------------------------------------------------
# JA Drimia 1.0 - Dec, 2007
# ------------------------------------------------------------------------
# Copyright (C) 2004-2006 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
# @license - Copyrighted Commercial Software
# Author: J.O.O.M Solutions Co., Ltd
# Websites:  http://www.joomlart.com -  http://www.joomlancers.com
-------------------------------------------------------------------------*/

defined( '_VALID_MOS' ) or die( 'Restricted access' );
defined( 'DS') || define( 'DS', DIRECTORY_SEPARATOR );
include_once (dirname(__FILE__).DS.'/ja_vars.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php mosShowHead(); ?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<link href="<?php echo $ja_template_path;?>/css/template_css.css" rel="stylesheet" type="text/css" />

<script language="javascript" type="text/javascript" src="<?php echo $ja_template_path;?>/scripts/mootools.v1.1.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo $ja_template_path;?>/scripts/ja.script.js"></script>

<?php genMenuHead(); ?>

<?php if ( $my->id ) { initEditor(); } ?>

<link href="<?php echo $ja_template_path;?>/css/colors/<?php echo $ja_color; ?>.css" rel="stylesheet" type="text/css" />

<!--[if lte IE 6]>
<style type="text/css">
.clearfix {height: 1%;}
</style>
<![endif]-->

<!--[if gte IE 7.0]>
<style type="text/css">
.clearfix {display: inline-block;}
</style>
<![endif]-->
<?php if (isIE6()) { 
?>
<script type="text/javascript">
window.addEvent ('domready', makeTransBG);
function makeTransBG() {
	$$('#ja-cssmenu li ul').each(function(el){
		makeTransBg(el, null, 'scale');
	});
}
</script>
<style type="text/css">
#ja-cssmenu li li,
{
	background:transparent url(../../images/blank.png) no-repeat right;
}
</style>
<?php } ?>

</head>

<body id="bd" class="<?php echo "$ja_width fs".$ja_font_size;?>">
<a name="Top" id="Top"></a>

<ul class="accessibility">
	<li><a href="<?php echo getCurrentURL();?>#ja-content" title="Skip to content">Skip to content</a></li>
	<li><a href="<?php echo getCurrentURL();?>#ja-mainnav" title="Skip to main navigation">Skip to main navigation</a></li>
	<li><a href="<?php echo getCurrentURL();?>#ja-colwrap" title="Skip to columns">Skip to columns</a></li>
</ul>

<div id="ja-wrapper1">
<div id="ja-wrapper2">
<div id="ja-wrapper3">
<div id="ja-wrapper4" class="clearfix">

<!-- BEGIN: HEADER -->
<div id="ja-headerwrap">
<div id="ja-header">

	<h1 class="logo"><a href="index.php" title="<?php echo $mosConfig_sitename?>"><?php echo $mosConfig_sitename?></a></h1>

	<!-- BEGIN: MAIN NAVIGATION -->
	<div id="ja-mainnav">
	<?php
		//Gen menu for CSS, MOO
		//Gen first level menu for Split, Dropline
		$jamenu->genMenu (0);
	?>

	</div>
	<!-- END: MAIN NAVIGATION -->
	
	<?php if (mosCountModules('user4')) { ?>
  <div id="ja-search">
    <?php mosLoadModules('user4', -1); ?>
  </div>
	<?php } ?>
	
	<?php if ($ja_tool) { ?>
  <div id="ja-usertoolswrap">
  <div id="ja-usertools" class="clearfix">
  	<?php genToolMenu($ja_tool); ?>
  </div></div>
  <?php } ?>

</div>
</div>
<!-- END: HEADER -->

<div id="ja-containerwrap<?php echo $divid ?>" class="clearfix">
	<div id="ja-container">

		<!-- BEGIN: CONTENT -->
		<div id="ja-content">
		<div class="ja-innerpad clearfix">

			<?php
			$spotlight = array ('user1','user2');
			$topspl = calSpotlight ($spotlight, 100);
			if( $topspl ) {
			?>
			<!-- BEGIN: TOP SPOTLIGHT -->
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

			</div>
			<!-- END: TOP SPOTLIGHT -->
			<?php } ?>
			
			<div id="ja-pathwaywrap">
				<div id="ja-pathway">
				<?php mosPathway(); ?>
				</div>
			</div>
		
		  <?php mosMainBody(); ?>
		  
		  <?php if ( mosCountModules('banner') ) { ?>
			<div id="ja-banner">
				<?php	echo mosLoadModules ( 'banner',-1 ); ?>
			</div>
			<?php } ?>

		</div></div>
		<!-- END: CONTENT -->
		
		<?php if ($ja_left || $ja_right || $ja_masscol) { ?>
		<!-- BEGIN: COLUMNS -->

		<!-- BEGIN: MASSCOL -->
		<?php  if ( $ja_masscol) { ?>
		<div id="ja-masscol" class="clearfix">
			<div class="ja-newflash">
			<?php	echo mosLoadModules ( 'top',-2 ); ?>
			</div>
		</div>
		<?php } ?>
		<!-- END: MASSCOL -->

		<div id="ja-colwrap">
		<div id="ja-colwrap-bot">
		<div id="ja-colwrap-top">
		<div class="ja-innerpad">

			<?php if ($ja_left) { ?>
			<div id="ja-col1">
				<?php if ($hasSubnav) { ?>
				<div id="ja-subnav">
					<?php $jamenu->genMenu (1,1);	?>
				</div>
				<?php } ?>
				<?php	echo mosLoadModules ( 'left',-2 ); ?>
			</div>
			<?php } ?>

			<?php if ($ja_right) { ?>
			<div id="ja-col2">
				<?php	echo mosLoadModules ( 'right',-2 ); ?>
			</div>
			<?php } ?>

		</div></div></div></div><br />
		<!-- END: COLUMNS -->
		<?php } ?>

	</div>
</div>

<?php			  
	$spotlight1 = array ('user6','user7');
	$botsl1 = calSpotlight ($spotlight1, mosCountModules('user5')?60:100);
	if( $botsl1 || mosCountModules('user5')) {
?>
<!-- BEGIN: BOTTOM SPOTLIGHT -->
<div id="ja-botsl" class="clearfix">

  <?php if( mosCountModules('user5') ) {?>
  <div class="ja-box-leftcol" style="width: <?php echo $botsl1?39.9:100;?>%;">
  	<?php mosLoadModules('user5', -3); ?>
  </div>
  <?php } ?>

  <?php if( mosCountModules('user6') ) {?>
  <div class="ja-box<?php echo $botsl1['modules']['user6']; ?>" style="width: <?php echo $botsl1['width']; ?>;">
    <?php mosLoadModules('user6', -3); ?>
  </div>
  <?php } ?>

  <?php if( mosCountModules('user7') ) {?>
  <div class="ja-box<?php echo $botsl1['modules']['user7']; ?>" style="width: <?php echo $botsl1['width']; ?>;">
    <?php mosLoadModules('user7', -3); ?>
  </div>
  <?php } ?>

</div>
<!-- END: BOTTOM SPOTLIGHT -->
<?php } ?>

<!-- BEGIN: FOOTER -->
<div id="ja-footerwrap" class="clearfix">
<div id="ja-footer" class="clearfix">

	<small>Copyright &copy; <?php echo mosCurrentDate( '2005 - %Y' ) . ' ' . $GLOBALS['mosConfig_sitename'];?>.</small>
	<?php mosLoadModules('user3', -1); ?>
	<small class="ja-copyright">
	Designed by <a href="http://www.joomlart.com/" title="Visit Joomlart.com!" target="blank">JoomlArt.com</a>
	</small>
	
</div>
</div>
<!-- END: FOOTER -->

</div>
</div>
</div>
</div>

<?php mosLoadModules( 'debug', -1 );?>
</body>

</html>
