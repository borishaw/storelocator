<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require($mosConfig_absolute_path."/templates/" . $mainframe->getTemplate() . "/rt_styleswitcher.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<?php
	if ( $my->id ) {
		initEditor();
	}
	mosShowHead();

	// *************************************************
	// Change this variable blow to switch color-schemes
	//
	// If you have any issues, check out the forum at
	// http://www.rockettheme.com
	//
	// *************************************************

	$default_style = "style6";			// custom | [style1... style10]
	$layout_style = "A";						// A | B
	$enable_rokzoom = "true";			// true | false
	$template_width = "950";				// width in px | fluid
	$menu_name = "mainmenu";				// mainmenu by default, can be any Joomla menu name
	$menu_type = "moomenu";					// moomenu | suckerfish | splitmenu | module
	$default_font = "default";      // smaller | default | larger
	$show_pathway = "true";					// true | false

	require($mosConfig_absolute_path."/templates/" . $mainframe->getTemplate() . "/rt_styleloader.php");

	$subnav = false;
	if ($mtype=="splitmenu") :
		require($mosConfig_absolute_path."/templates/" . $mainframe->getTemplate() . "/rt_splitmenu.php");
		$topnav = rtShowHorizMenu($menu_name);
		$subnav = rtShowSubMenu($menu_name);
	elseif ($mtype=="moomenu" or $mtype=="suckerfish") :
		require($mosConfig_absolute_path."/templates/" . $mainframe->getTemplate() . "/rt_moomenu.php");
		$subnav = false;
	endif;
	
	if ($template_width=="fluid") { 
		$template_width = "width: 95%;";
	} else {
		$template_width = 'margin: 0 auto; width: ' . $template_width . 'px;';
	}

	// make sure subnav is empty
	if (strlen($subnav) < 10) $subnav = false;
	//Are we in edit mode
	$editmode = false;
	if (  !empty( $_REQUEST['task'])  && $_REQUEST['task'] == 'edit'  ) :
		$editmode = true;
	endif;

	?>
	<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
	<link rel="shortcut icon" href="<?php echo $mosConfig_live_site;?>/images/favicon.ico" />
	<?php if($mtype=="moomenu" or $mtype=="suckerfish") :?>
	<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/rokmoomenu.css" rel="stylesheet" type="text/css" />
	<?php endif; ?>
	<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/template_css.css" rel="stylesheet" type="text/css" />
	<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/<?php echo $tstyle; ?>.css" rel="stylesheet" type="text/css" />
	<?php if($enable_rokzoom=="true") :?>
	<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/rokzoom/rokzoom.css" rel="stylesheet" type="text/css" />
	<?php endif; ?>
	<!--[if IE 7]>
	<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/template_ie7.css" rel="stylesheet" type="text/css" />
	<![endif]-->
	<!--[if lte IE 6]>
	<link href="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/template_ie6.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
	img { behavior: url(<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/css/iepngfix.htc); } 
	div#inset1, div#inset2 { filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/inset.png', sizingMethod='scale'); }
	span.loginsubmit,	span.logoutsubmit {filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/login-button.png', sizingMethod='scale'); }
	pre, blockquote {	filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/trans-quote.png', sizingMethod='scale'); }
	</style>
	<![endif]-->
	<style type="text/css">
		div.wrapper { <?php echo $template_width; ?>}
	</style>	
	<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/js/mootools.js"></script>
	<?php if($enable_rokzoom=="true") :?>
	<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/rokzoom/rokzoom.js"></script>
	<?php endif; ?>
	<?php if($mtype=="moomenu") :?>
	<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/js/mootools.bgiframe.js"></script>
	<script type="text/javascript" src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/js/rokmoomenu.js"></script>
	<script type="text/javascript">
	window.addEvent('domready', function() {
		new Rokmoomenu($E('ul.nav'), {
			bgiframe: false,
			delay: 500,
			animate: {
				props: ['opacity', 'width', 'height'],
				opts: {
					duration:400,
					fps: 100,
					transition: Fx.Transitions.Expo.easeOut
				}
			}
		});
	});
	</script>
	<?php endif; ?>	
	<?php if($mtype=="suckerfish") :
		echo "<!--[if lt IE 7]>\n";		
	  include_once( "$mosConfig_absolute_path/templates/" . $mainframe->getTemplate() . "/js/ie_suckerfish.js" );
	  echo "<![endif]-->\n";
	endif; ?>	
	<?php if($enable_rokzoom=="true") :?>
	<script type="text/javascript">
		window.addEvent('load', function() {
			RokZoom.init({
				imageDir: 'templates/<?php echo $mainframe->getTemplate(); ?>/rokzoom/images/',
				resizeFX: {
					duration: 700,
					transition: Fx.Transitions.Cubic.easeOut,
					wait: true
				},
				opacityFX: {
					duration: 500,
					wait: false	
				}
			});
		});
	</script>
	<?php endif; ?>
	</head>
	<body class="<?php echo $fontstyle; ?>">
		<div id="header">
			<div class="wrapper">
				<a href="<?php echo $mosConfig_live_site;?>" class="nounder"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/blank.gif" style="border:0;" alt="" id="logo" /></a>
				<div id="horiz-menu" class="<?php echo $mtype; ?>">
					<?php if($mtype == "splitmenu") : ?>
						<?php echo $topnav; ?>
					<?php elseif($mtype == "moomenu" or $mtype == "suckerfish") : ?>
						<?php mosShowListMenu($menu_name);	?>
					<?php else: ?>
		      	<?php mosLoadModules('toolbar',-1); ?>
			    <?php endif; ?>	
				</div>
				<?php if($subnav) : ?>
				<div id="sub-menu">
					<?php echo $subnav; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
		<div id="transparent">
			<div class="wrapper">
				<div id="pathway">
					<?php if ($show_pathway == "true") : ?>
					<?php mosPathway(); ?>
					<?php endif; ?>
				</div>
				<div id="mod-top">
					<?php mosLoadModules('top', -1); ?>
				</div>
				
				<?php if ($layout_style == "A") : ?>
					
				<div id="mainbody">
					<table id="mainframe">
						<tr valign="top">
							<td class="main">
								<?php mosMainbody(); ?>
							</td>
							<?php if (mosCountModules('user1')) : ?>
							<td class="fixed">
								<?php mosLoadModules('user1', -2); ?>
							</td>
							<?php endif; ?>
							<?php if (mosCountModules('inset')) : ?>
							<td class="fixed">
								<div id="inset1">
									<div id="inset2">
										<?php mosLoadModules('inset', -2); ?>
									</div>
								</div>
							</td>
							<?php endif; ?>
						</tr>
					</table>
				</div>
				
				<?php else : ?>
				
				
				<?php $section1count = (mosCountModules('user1')>0) + (mosCountModules('user2')>0) + (mosCountModules('user3')>0) + (mosCountModules('inset')>0); ?>
				<?php if($section1count) : ?>
				<?php $section1width = 'w' . floor(99 / $section1count); ?>
				<div class="padding">
					<table class="sections" cellspacing="0" cellpadding="0">
						<tr valign="top">
							<?php if(mosCountModules('user1')) : ?>
							<td class="fixed <?php echo $section1width ?>">
								<?php mosLoadModules('user1', -2); ?>
							</td>
							<?php endif; ?>
							<?php if(mosCountModules('user2')) : ?>
							<td class="fixed <?php echo $section1width; ?>">
								<?php mosLoadModules('user2', -2); ?>
							</td>
							<?php endif; ?>
							<?php if(mosCountModules('user3')) : ?>
							<td class="fixed <?php echo $section1width; ?>">
								<?php mosLoadModules('user3', -2); ?>
							</td>
							<?php endif; ?>
							<?php if(mosCountModules('inset')) : ?>
							<td class="fixed <?php echo $section1width; ?>">
								<div id="inset1">
									<div id="inset2">
										<?php mosLoadModules('inset', -2); ?>
									</div>
								</div>
							</td>
							<?php endif; ?>
						</tr>
					</table>
				</div>
				<?php else: ?>
				<div class="clr"></div>
				<?php endif; ?>
				
				<?php endif; ?>
				
			</div>	
		</div>
		<div id="divider"></div>
				
		<?php if ($layout_style != "A") : ?>
			
		<div id="section1" class="section">
			<div class="wrapper">
				<div id="mainbody">
					<table id="mainframe">
						<tr valign="top">
							<td class="main">
								<?php mosMainbody(); ?>
							</td>
							<?php if (mosCountModules('user4')) : ?>
							<td class="fixed">
								<?php mosLoadModules('user4', -3); ?>
							</td>
							<?php endif; ?>
							<?php if (mosCountModules('user5')) : ?>
							<td class="fixed">
								<div id="inset1">
									<div id="inset2">
										<?php mosLoadModules('user5', -3); ?>
									</div>
								</div>
							</td>
							<?php endif; ?>
						</tr>
					</table>
				</div>
			</div>
		</div>
				
		<?php else : ?>
		
		<?php $section1count = (mosCountModules('user2')>0) + (mosCountModules('user3')>0) + (mosCountModules('user4')>0) + (mosCountModules('user5')>0); ?>
		<?php if($section1count) : ?>
		<?php $section1width = 'w' . floor(99 / $section1count); ?>
		<div id="section1" class="section">
			<div class="wrapper">
				<div class="padding">
					<table class="sections" cellspacing="0" cellpadding="0">
						<tr valign="top">
							<?php if(mosCountModules('user2')) : ?>
							<td class="section <?php echo $section1width ?>">
								<?php mosLoadModules('user2', -3); ?>
							</td>
							<?php endif; ?>
							<?php if(mosCountModules('user3')) : ?>
							<td class="section <?php echo $section1width; ?>">
								<?php mosLoadModules('user3', -3); ?>
							</td>
							<?php endif; ?>
							<?php if(mosCountModules('user4')) : ?>
							<td class="section <?php echo $section1width; ?>">
								<?php mosLoadModules('user4', -3); ?>
							</td>
							<?php endif; ?>
							<?php if(mosCountModules('user5')) : ?>
							<td class="section <?php echo $section1width; ?>">
								<?php mosLoadModules('user5', -3); ?>
							</td>
							<?php endif; ?>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<?php endif; ?>
				
		<?php endif; ?>
		
		<?php $section2count = (mosCountModules('user6')>0) + (mosCountModules('user7')>0) + (mosCountModules('user8')>0) + (mosCountModules('user9')>0); ?>
		<?php if($section2count) : ?>
		<?php $section2width = 'w' . floor(99 / $section2count); ?>				
		<div id="section2" class="section">
			<div class="wrapper">
				<div class="padding">
					<table class="sections" cellspacing="0" cellpadding="0">
						<tr valign="top">
							<?php if(mosCountModules('user6')) : ?>
							<td class="section <?php echo $section2width ?>">
								<?php mosLoadModules('user6', -3); ?>
							</td>
							<?php endif; ?>
							<?php if(mosCountModules('user7')) : ?>
							<td class="section <?php echo $section2width; ?>">
								<?php mosLoadModules('user7', -3); ?>
							</td>
							<?php endif; ?>
							<?php if(mosCountModules('user8')) : ?>
							<td class="section <?php echo $section2width; ?>">
								<?php mosLoadModules('user8', -3); ?>
							</td>
							<?php endif; ?>
							<?php if(mosCountModules('user9')) : ?>
							<td class="section <?php echo $section2width; ?>">
								<?php mosLoadModules('user9', -3); ?>
							</td>
							<?php endif; ?>
						</tr>
					</table>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<div id="rocket-logo">
			<a href="http://www.rockettheme.com/" title="RocketTheme Joomla Template Club" class="nounder"><img src="<?php echo $mosConfig_live_site;?>/templates/<?php echo $mainframe->getTemplate(); ?>/images/blank.gif" alt="RocketTheme Joomla Templates" id="rocket" /></a>
		</div>
		<div id="preload">
			<span id="preload1"></span><span id="preload2"></span><span id="preload3"></span><span id="preload4"></span>
		</div>
	</body>
</html>