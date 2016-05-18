<?php
// no direct access
defined( '_VALID_MOS' ) or die( 'Restricted access' );

global $mosConfig_live_site;

$title = $params->get('title');
$path = $params->get('image');
$height = intval($params->get('height'));
$text = $params->get('fulltext');

$color = $params->get('textcolor');
if ($color) $color = " color:#$color;";
$bgcolor = $params->get('bgcolor');
if ($bgcolor) $bgcolor = " background-color:#$bgcolor;";
$trans = intval($params->get('transparent'));
if ($trans) $trans = " opacity:".($trans/100)."; filter:alpha(opacity=".$trans.");";
else $trans = "";
$xheight = intval($params->get('expandheight'));

$path = $mosConfig_live_site . "/" . $path;
if (!defined( '_MOD_JA_SLWI')) {
	echo '
	<script type="text/javascript" src="'.$mosConfig_live_site.'/modules/ja_slwi/mootools.v1.1.pak.js"></script>
	<script type="text/javascript" src="'.$mosConfig_live_site.'/modules/ja_slwi/ja_slwi.js"></script>
	<script type="text/javascript">
		jaSLWI.expandH = '.$xheight.';
	</script>';
	define( '_MOD_JA_SLWI', 1 );
}
echo '
<div class="ja-slwi" style="position: relative; height: '.$height.'px; margin: 0; padding: 0;background:url('.$path.') no-repeat">	
	<div class="ja-slwi-container" style="position: absolute; z-index: 1; bottom: 0; left: 0;">
		<p>&nbsp;</p>
		<div class="ja-slwi-text" style="position:relative;height: 0; overflow: hidden;">
		<div style="position: absolute; top:0;left:0;height:'.$xheight.'px;width:100%;'.$bgcolor.$trans.'">&nbsp;</div>
		<div style="position: absolute; top:0;left:0;height:'.$xheight.'px;'.$color.'"><h3>'.$title.'</h3>'.$text.'</div>
		</div>
	</div>
</div>';
?>
