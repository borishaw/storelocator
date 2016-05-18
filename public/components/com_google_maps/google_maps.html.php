<?php
/**
* @version $Id: google_maps.html.php,v 1.15 2005/09/05 05:07:19 dhpollack Exp $
* @package Mambo
* @subpackage Places
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );


/**
* @package Mambo
* @subpackage Wrapper
*/
class HTML_google_maps {

	
	
function display( &$rows, &$params, &$menu , $visMarkCat, $mapAPI = 'google') {
	$category = $visMarkCat["category"];
	$marker = $visMarkCat["marker"];
    $cbSupport = $params->get( 'cbSupport');
?>
   <div>             
    <div id="titleDiv"><?php echo $params->get('title' , '');?></div>
    <div id="map" style="border: <?php echo $params->get('mapBorder', "1px");?>; width: <?php echo $params->get('mapWidth', "99%");?>; height: <?php echo $params->get('mapHeight', "500px");?>">Loading map...</div>
    <div id="miscDiv"><?php echo $params->get('misc', '');?></div>
    <div id="testDiv"></div>
   </div>
<script src="http://maps.google.com/maps?file=api&v=2&key=<?php echo $params->get( 'APIKey' , "You need to go to the Google Maps API page and signup for a key!"); ?>" type="text/javascript"></script>
<?php
if($mapAPI == '1') {
?><script type="text/javascript" src="http://api.maps.yahoo.com/ajaxymap?v=3.0&appid=maverickpl94"></script>
<script type="text/javascript" src="components/com_google_maps/yahoo_maps.js"></script>
<?php
} elseif($mapAPI == '2') {
?><script type="text/javascript" src="http://dev.virtualearth.net/mapcontrol/v3/mapcontrol.js"></script>
<script type="text/javascript" src="components/com_google_maps/microsoft_maps.js"></script>
<?php
} else { 
?><script type="text/javascript" src="components/com_google_maps/gicons.js"></script>
<link href="components/com_google_maps/tooltip.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="components/com_google_maps/ajaxslt/misc.js"></script>
<script type="text/javascript" src="components/com_google_maps/ajaxslt/dom.js"></script>
<script type="text/javascript" src="components/com_google_maps/ajaxslt/xpath.js"></script>
<script type="text/javascript" src="components/com_google_maps/ajaxslt/xslt.js"></script>
<script type="text/javascript" src="components/com_google_maps/ajaxslt/xpathdebug.js"></script>
<script type="text/javascript" src="components/com_google_maps/google_maps.js"></script>
<?php
}
?>
<script type="text/javascript">
//<![CDATA[


// Grab XSL File
var safariCompat = <?php echo $params->get('safariCompat','0'); ?>;
if(safariCompat == 0) {
    logging__ = false;
    xsltdebug = false;
    xpathdebug = false;
    var xmlHttp = GXmlHttp.create();
    xmlHttp.open("GET", "components/com_google_maps/minipage.xsl", false);
    xmlHttp.send(null);
}
// Defining Global Variables
//Map Globals
var map;
var xmlUrl = <?php echo $params->get('xmlUrl', "'components/com_google_maps/google_maps.xml'"); ?>;
var infoWindows = new Array();
var xmlCats = new Array();
var infoWindowsHtml = new Array();
var markers = new Array();
var infos = new Array();
var i = 0;
var autoOpen = <?php echo $params->get('autoOpen', 0); ?>;
var centerId = <?php echo $params->get( 'centerId', 0); ?>;
var centerLat = <?php echo $params->get('centerLat', 33.77525); ?>;
var centerLng = <?php echo $params->get('centerLng', -84.362199); ?>;
var zoomLevel = <?php echo $params->get( 'zoomLevel' , 10); ?>;
var contZoom = <?php echo $params->get( 'contZoom' , 0); ?>;
var doubleclickZoom = <?php echo $params->get( 'doubleclickZoom' , 0); ?>;
var whichType = <?php echo $params->get( 'whichType' , 'G_NORMAL_MAP'); ?>;
var showType = <?php echo $params->get( 'showType' , 1); ?>;
var whichZoom = <?php echo $params->get( 'whichZoom' , 1); ?>;
var showScale = <?php echo $params->get( 'showScale' , 1); ?>;
var catDisplay = [];
<?php
if($category) {
    for($i = 0;isset($category[$i]);$i++) {
        if(is_numeric($category[$i])) echo "catDisplay.push(\"$category[$i]\");\n";
    }
}
?>
var pointsArray = [];
<?php
if($marker) {
    for($i = 0;isset($marker[$i]);$i++) {
        if(is_numeric($marker[$i])) echo "pointsArray.push(\"$marker[$i]\");\n";
    }
}
?>
var cbRealname = <?php echo $params->get( 'cbRealname' , 0); ?>;
// Sidebar Globals
var sidebar_htmls = new Array();
var current_sidebar;
var sidebar_place = 0;
var sidebar_num = <?php echo $params->get('sidebarNum', 5); ?>;
var sidebar_exists = <?php echo $params->get('sidebarShow', 0); ?>;
var sidebar_showcat = <?php echo $params->get('sideShowcat',0); ?>;
var prevplace;
var nextplace;
var prevcat;
// Tooltip Globals
var tooltipShow = <?php echo $params->get('tooltips', 0); ?>;
var tooltip;
// Overview Globals
var omap;
var overviewShow = <?php echo $params->get('overviewEnable','0'); ?>;
var overviewHeight = <?php echo $params->get("overviewHeight", 200); ?>;
var overviewWidth = <?php echo $params->get("overviewWidth", 200); ?>;
// Search Globals
var ymarkers = [];
var search_html;
var yahooInfo;
// No more template editing!
var editBodytag = <?php echo $params->get('editBodytag', 0); ?>;
if(editBodytag == 0) {
    var oldOnload = window.onload;
    if (typeof window.onload != 'function') {
        window.onload = function() {
            initMap();
        };
    } else {
        window.onload = function() {
            oldOnload();
            initMap();
        };
    }
    var oldOnunload = window.onunload;
    if (typeof window.onunload != 'function') {
        window.onunload = function() {
            GUnload();
        };
    } else {
        window.onunload = function() {
            oldOnunload();
            GUnload();
        };
    }
}
   //]]>
  </script>
<?php

    // displays back button
//	mosHTML::BackButton ( $params );
}
	
	/**
	* Writes the edit form for new and existing record (FRONTEND)
	*
	* A new record is defined when <var>$row</var> is passed with the <var>id</var>
	* property set to 0.
	* @param mosPlace The place object
	* @param string The html for the categories select list
	*/
	function editPlaceHTML( $option, &$row, &$lists ,$confData) {
		global $mosConfig_live_site, $mosConfig_absolute_path, $my;
        require_once( $mosConfig_absolute_path . '/includes/HTML_toolbar.php' );
        require_once( $mosConfig_absolute_path . '/administrator/includes/menubar.html.php' );

		$tabs = new mosTabs(0);

		mosCommonHTML::loadOverlib();
		
		$title = ( $row->id ?  'Edit'  : 'New' );

				$countries = array( 'us' => 'United States', 
									'uk' => 'United Kingdom', 
									'af' => 'Afghanistan', 
									'al' => 'Albania', 
									'ag' => 'Algeria', 
									'an' => 'Andorra', 
									'ao' => 'Angola', 
									'av' => 'Anguilla', 
									'ac' => 'Antigua And Barbuda', 
									'ar' => 'Argentina', 
									'am' => 'Armenia', 
									'aa' => 'Aruba', 
									'at' => 'Ashmore And Cartier Islands', 
									'as' => 'Australia', 
									'au' => 'Austria', 
									'aj' => 'Azerbaijan', 
									'bf' => 'Bahamas', 
									'ba' => 'Bahrain', 
									'bg' => 'Bangladesh', 
									'bb' => 'Barbados', 
									'bs' => 'Bassas Da India', 
									'bo' => 'Belarus', 
									'be' => 'Belgium', 
									'bh' => 'Belize', 
									'bn' => 'Benin', 
									'bd' => 'Bermuda', 
									'bt' => 'Bhutan', 
									'bl' => 'Bolivia', 
									'bk' => 'Bosnia And Herzegovina', 
									'bc' => 'Botswana', 
									'bv' => 'Bouvet Island', 
									'br' => 'Brazil', 
									'io' => 'British Indian Ocean Territory', 
									'vi' => 'British Virgin Islands', 
									'bx' => 'Brunei', 
									'bu' => 'Bulgaria', 
									'uv' => 'Burkina Faso', 
									'bm' => 'Burma', 
									'by' => 'Burundi', 
									'iv' => 'Cote d\'Ivoire', 
									'cb' => 'Cambodia', 
									'cm' => 'Cameroon', 
									'ca' => 'Canada', 
									'cv' => 'Cape Verde', 
									'cj' => 'Cayman Islands', 
									'ct' => 'Central African Republic', 
									'cd' => 'Chad', 
									'ci' => 'Chile', 
									'ch' => 'China', 
									'kt' => 'Christmas Island', 
									'ip' => 'Clipperton Island', 
									'ck' => 'Cocos (Keeling) Islands', 
									'co' => 'Colombia', 
									'cn' => 'Comoros', 
									'cf' => 'Congo', 
									'cg' => 'Congo (Demo. Republic)', 
									'cw' => 'Cook Islands', 
									'cr' => 'Coral Sea Islands', 
									'cs' => 'Costa Rica', 
									'hr' => 'Croatia', 
									'cu' => 'Cuba', 
									'cy' => 'Cyprus', 
									'ez' => 'Czech Republic', 
									'da' => 'Denmark', 
									'dj' => 'Djibouti', 
									'do' => 'Dominica', 
									'dr' => 'Dominican Republic', 
									'tt' => 'East Timor', 
									'ec' => 'Ecuador', 
									'eg' => 'Egypt', 
									'es' => 'El Salvador', 
									'ek' => 'Equatorial Guinea', 
									'er' => 'Eritrea', 
									'en' => 'Estonia', 
									'et' => 'Ethiopia', 
									'eu' => 'Europa Island', 
									'fk' => 'Falkland Islands (Islas Malvinas)', 
									'fo' => 'Faroe Islands', 
									'fj' => 'Fiji', 
									'fi' => 'Finland', 
									'fr' => 'France', 
									'fg' => 'French Guiana', 
									'fp' => 'French Polynesia', 
									'fs' => 'French Southern/Antarctic Lands', 
									'gb' => 'Gabon', 
									'ga' => 'Gambia', 
									'gz' => 'Gaza Strip', 
									'gg' => 'Georgia', 
									'gm' => 'Germany', 
									'gh' => 'Ghana', 
									'gi' => 'Gibraltar', 
									'go' => 'Glorioso Islands', 
									'gr' => 'Greece', 
									'gl' => 'Greenland', 
									'gj' => 'Grenada', 
									'gp' => 'Guadeloupe', 
									'gt' => 'Guatemala', 
									'gk' => 'Guernsey', 
									'gv' => 'Guinea', 
									'pu' => 'Guinea-Bissau', 
									'gy' => 'Guyana', 
									'ha' => 'Haiti', 
									'hm' => 'Heard Island/McDonald Islands', 
									'ho' => 'Honduras', 
									'hk' => 'Hong Kong', 
									'hu' => 'Hungary', 
									'ic' => 'Iceland', 
									'in' => 'India', 
									'id' => 'Indonesia', 
									'ir' => 'Iran', 
									'iz' => 'Iraq', 
									'ei' => 'Ireland', 
									'im' => 'Isle Of Man', 
									'is' => 'Israel', 
									'it' => 'Italy', 
									'jm' => 'Jamaica', 
									'jn' => 'Jan Mayen', 
									'ja' => 'Japan', 
									'je' => 'Jersey', 
									'jo' => 'Jordan', 
									'ju' => 'Juan De Nova Island', 
									'kz' => 'Kazakhstan', 
									'ke' => 'Kenya', 
									'kr' => 'Kiribati', 
									'ku' => 'Kuwait', 
									'kg' => 'Kyrgyzstan', 
									'la' => 'Laos', 
									'lg' => 'Latvia', 
									'le' => 'Lebanon', 
									'lt' => 'Lesotho', 
									'li' => 'Liberia', 
									'ly' => 'Libya', 
									'ls' => 'Liechtenstein', 
									'lh' => 'Lithuania', 
									'lu' => 'Luxembourg', 
									'mc' => 'Macau', 
									'mk' => 'Macedonia', 
									'ma' => 'Madagascar', 
									'mi' => 'Malawi', 
									'my' => 'Malaysia', 
									'mv' => 'Maldives', 
									'ml' => 'Mali', 
									'mt' => 'Malta', 
									'rm' => 'Marshall Islands', 
									'mb' => 'Martinique', 
									'mr' => 'Mauritania', 
									'mp' => 'Mauritius', 
									'mf' => 'Mayotte', 
									'mx' => 'Mexico', 
									'fm' => 'Micronesia', 
									'md' => 'Moldova', 
									'mn' => 'Monaco', 
									'mg' => 'Mongolia', 
									'mh' => 'Montserrat', 
									'mo' => 'Morocco', 
									'mz' => 'Mozambique', 
									'wa' => 'Namibia', 
									'nr' => 'Nauru', 
									'np' => 'Nepal', 
									'nl' => 'Netherlands', 
									'nt' => 'Netherlands Antilles', 
									'nc' => 'New Caledonia', 
									'nz' => 'New Zealand', 
									'nu' => 'Nicaragua', 
									'ng' => 'Niger', 
									'ni' => 'Nigeria', 
									'ne' => 'Niue', 
									'nm' => 'No Man\'s Land', 
									'nf' => 'Norfolk Island', 
									'kn' => 'North Korea', 
									'no' => 'Norway', 
									'os' => 'Oceans', 
									'mu' => 'Oman', 
									'pk' => 'Pakistan', 
									'ps' => 'Palau', 
									'pm' => 'Panama', 
									'pp' => 'Papua New Guinea', 
									'pf' => 'Paracel Islands', 
									'pa' => 'Paraguay', 
									'pe' => 'Peru', 
									'rp' => 'Philippines', 
									'pc' => 'Pitcairn Islands', 
									'pl' => 'Poland', 
									'po' => 'Portugal', 
									'qa' => 'Qatar', 
									're' => 'Reunion', 
									'ro' => 'Romania', 
									'rs' => 'Russia', 
									'rw' => 'Rwanda', 
									'sh' => 'Saint Helena', 
									'sc' => 'Saint Kitts And Nevis', 
									'st' => 'Saint Lucia', 
									'sb' => 'Saint Pierre And Miquelon', 
									'vc' => 'Saint Vincent And The Grenadines', 
									'ws' => 'Samoa', 
									'sm' => 'San Marino', 
									'tp' => 'Sao Tome And Principe', 
									'sa' => 'Saudi Arabia', 
									'sg' => 'Senegal', 
									'yi' => 'Serbia And Montenegro', 
									'se' => 'Seychelles', 
									'sl' => 'Sierra Leone', 
									'sn' => 'Singapore', 
									'lo' => 'Slovakia', 
									'si' => 'Slovenia', 
									'bp' => 'Solomon Islands', 
									'so' => 'Somalia', 
									'sf' => 'South Africa', 
									'sx' => 'South Georgia/Sandwich Islands', 
									'ks' => 'South Korea', 
									'sp' => 'Spain', 
									'pg' => 'Spratly Islands', 
									'ce' => 'Sri Lanka', 
									'su' => 'Sudan', 
									'ns' => 'Suriname', 
									'sv' => 'Svalbard', 
									'wz' => 'Swaziland', 
									'sw' => 'Sweden', 
									'sz' => 'Switzerland', 
									'sy' => 'Syria', 
									'tw' => 'Taiwan', 
									'ti' => 'Tajikistan', 
									'tz' => 'Tanzania', 
									'th' => 'Thailand', 
									'to' => 'Togo', 
									'tl' => 'Tokelau', 
									'tn' => 'Tonga', 
									'td' => 'Trinidad And Tobago', 
									'te' => 'Tromelin Island', 
									'ts' => 'Tunisia', 
									'tu' => 'Turkey', 
									'tx' => 'Turkmenistan', 
									'tk' => 'Turks And Caicos Islands', 
									'tv' => 'Tuvalu', 
									'ug' => 'Uganda', 
									'up' => 'Ukraine', 
									'uf' => 'Undersea Features', 
									'ae' => 'United Arab Emirates', 
									'uy' => 'Uruguay', 
									'uz' => 'Uzbekistan', 
									'nh' => 'Vanuatu', 
									'vt' => 'Vatican City', 
									've' => 'Venezuela', 
									'vm' => 'Vietnam', 
									'wf' => 'Wallis And Futuna', 
									'we' => 'West Bank', 
									'wi' => 'Western Sahara', 
									'ym' => 'Yemen', 
									'za' => 'Zambia', 
									'zi' => 'Zimbabwe', );
		$Returnid = intval( mosGetParam( $_REQUEST, 'Returnid', 0 ) );

        function placeDelete( $task='remove', $alt=_CMN_CANCEL ) {
            $image = mosAdminMenus::ImageCheck( 'cancel_f2.png', '/images/', NULL, NULL, $alt, $task, 1 );
            ?>
            <td>
            <a class="toolbar" href="javascript:submitbutton('<?php echo $task;?>');" >
                <?php echo $image;?></a>
            </td>
            <?php
        }
	
        $confData = $row->confData;
        unset($row->confData);

		?>
		<script language="javascript" type="text/javascript">
		function submitbutton(pressbutton) {
			var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
			// do field validation
			if ( form.name.value == "" ) {
				alert( "You must provide a name." );
			} else if ( form.catid.value == "0" ) {
				alert( "Please select a Category." );
			}
    <?php if($confData->reqAd == 1) { ?>			  
              else if ( form.address.value == "" ) {
				alert( "You must provide an address." );
			} 
    <?php      } if($confData->reqCt == 1) { ?>
			else if ( form.suburb.value == "" ) {
				alert( "You must provide a city." );
			}
	<?php      } if($confData->reqSt == 1) { ?>
			  else if ( form.state.value == "" ) {
				alert( "You must provide a state." );
			}
	<?php      } if($confData->reqCn == 1) { ?>
			else if ( form.country.value == "" ) {
				alert( "You must provide a country." );
			}
	<?php      } if($confData->reqZp == 1) { ?>
			 else if ( form.postcode.value == "" ) {
				alert( "You must provide a zipcode." );
			}
	<?php      } if($confData->reqLl == 1) { ?>
			 else if ( form.lat.value == "" ) {
				alert( "You must provide a latitude." );
			} else if ( form.lng.value == "" ) {
				alert( "You must provide a longitude." );
			} 
	<?php      } ?>
			else {
				<?php getEditorContents( 'editor1', 'misc' ) ; ?>
				submitform( pressbutton );
			}
		}
		
		function enablePolyline() {
			var form = document.adminForm;
			var polyline = form.polyEnable.value;
			if (polyline == 2) 
			{
				form.polyColor.disabled = false;
				form.polyWidth.disabled = false;
			} 
			else 
			{
				form.polyColor.disabled = true;
				form.polyWidth.disabled = true;
			}
		}
		</script>

		<form action="<?php echo sefRelToAbs("index.php"); ?>" method="post" name="adminForm" id="adminForm">
		<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td class="contentheading">
			<?php echo 'Submit new Place:';?>
			</td>
			<td width="10%">
			<?php
			mosToolBar::startTable();
			mosToolBar::spacer();
			mosToolBar::save();
			placeDelete();
			mosToolBar::back();
			mosToolBar::endtable();
			?>
			</td>
		</tr>
		</table>

		<table cellpadding="4" cellspacing="1" border="0" width="100%">
				<tr>
					<td width="20%" align="right">
					Category:
					</td>
					<td width="40%">
					<?php echo $lists['catid'];?>
					</td>
				</tr>
				<tr>
					<td>Marker Type:</td>
					<td>
						<select name="markerType" id="markerType" onchange="enablePolyline();">
						<option value="1" <?php if($row->markerType == 1) echo 'selected="selected"' ?>>Marker</option>
						<option value="2" <?php if($row->markerType == 2) echo 'selected="selected"' ?>>Polyline</option>
					</select>
					</td>
				</tr>
				<tr>
					<td>Draggable Marker:</td>
					<td>
						<select name="draggable" id="draggable">
						<option value="0" <?php if($row->draggable == 0) echo 'selected="selected"' ?>>No</option>
						<option value="1" <?php if($row->draggable == 1) echo 'selected="selected"' ?>>Yes</option>
					</select>
					</td>
				</tr>
				<tr>
					<td width="20%" align="right">
					Name:
					</td>
					<td >
					<input class="inputbox" type="text" name="name" size="50" maxlength="100" value="<?php echo $row->name; ?>" />
					</td>
				</tr>
				<tr>
					<td align="right">
					Street Address:
					</td>
					<td>
					<input class="inputbox" type="text" name="address" size="50" value="<?php echo $row->address; ?>" />
					</td>
				</tr>
				<tr>
					<td align="right">
					City/Town:
					</td>
					<td>
					<input class="inputbox" type="text" name="suburb" size="50" maxlength="50" value="<?php echo $row->suburb;?>" />
					</td>
				</tr>
				<tr>
					<td align="right">
					State/County:
					</td>
					<td>
					<input class="inputbox" type="text" name="state" size="50" maxlength="20" value="<?php echo $row->state;?>" />
					</td>
				</tr>

				<tr>
					<td align="right">
					Country:
					</td>
					<td>
				<select name="country">
					<option> </option>
					<?php
					while(current($countries)) {
					?>
					<option  value="<?php echo current($countries) ?>" <?php if($row->country == current($countries)) echo 'selected="selected"' ?>><?php echo current($countries) ?></option>
					<?php
					next($countries);
					}
					?>
				</select>
					</td>
				</tr>
				<tr>
					<td align="right">
					Postal Code/ZIP:
					</td>
					<td>
					<input class="inputbox" type="text" name="postcode" size="25" maxlength="10" value="<?php echo $row->postcode; ?>" />
					</td>
				</tr>
				<tr>
					<td align="right">
					Latitude:
					</td>
					<td>
					<input class="inputbox" type="text" name="lat" size="25" maxlength="15" value="<?php echo $row->lat; ?>" />
					</td>
				</tr>
				<tr>
					<td align="right">
					Longitude:
					</td>
					<td>
					<input class="inputbox" type="text" name="lng" size="25" maxlength="15" value="<?php echo $row->lng; ?>" />
					</td>
				</tr>
				<tr>
					<td align="right">
					Polyline Color:
					</td>
					<td>
					<input class="inputbox" type="text" name="polyColor" id="polyColor" size="50" maxlength="50" value="<?php echo $row->polyColor;?>" <?php if($row->markerType != 2) echo 'disabled' ?>/>
					</td>
				</tr>

				<tr>
					<td align="right">
					Polyline Width:
					</td>
					<td>
					<input class="inputbox" type="text" name="polyWidth" id="polyWidth" size="50" maxlength="50" value="<?php echo $row->polyWidth;?>" <?php if($row->markerType != 2) echo 'disabled' ?>/>
					</td>
				</tr>

				<tr>
					<td align="right" valign="top">
					Miscellaneous:
					</td>
					<td>
						<textarea name="misc" rows="8" cols="65" class="inputbox"><?php echo $row->misc; ?></textarea>
					</td>
				</tr>
				</table>

		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="ordering" value="<?php echo $row->ordering; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="user_id" value="<?php echo $my->id ?>" />
		<input type="hidden" name="approved" value="<?php echo $row->approved; ?>" />
		<input type="hidden" name="Returnid" value="<?php echo $Returnid; ?>" />
		</form>
		<?php
	}

 	function listMarkers( &$rows, &$pageNav, $search, $option, &$lists ) {
		global $mosConfig_live_site, $mosConfig_absolute_path, $my;
        require_once( $mosConfig_absolute_path . '/includes/HTML_toolbar.php' );
        require_once( $mosConfig_absolute_path . '/administrator/includes/menubar.html.php' );

		mosCommonHTML::loadOverlib();
		?>
		<form action="index.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			Google Maps Marker Manager
			</th>
			<td>
			Filter:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" />
			</td>
			<td width="right">
			<?php echo $lists['catid'];?>
			</td>
		</tr>
		</table>
		<table class="adminlist">
		<tr>
			<th width="20">
			#
			</th>
			<th class="title">
			Name
			</th>
			<th width="5%" class="title" nowrap="true">
			Published
			</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count($rows); $i < $n; $i++) {
			$row = $rows[$i];

			$link 	= 'index.php?option=com_google_maps&task=edit&id='. $row->id;

			$img 	= $row->published ? "tick.png" : "publish_x.png";
			$task 	= $row->published ? 'unpublish' : 'publish';
			$alt 	= $row->published ? 'Published' : 'Unpublished';


			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php
				if ( $row->checked_out && ( $row->checked_out != $my->id ) ) {
					echo $row->name;
				} else {
					?>
					<a href="<?php echo $link; ?>" title="Edit Place">
					<?php echo $row->name; ?>
					</a>
					<?php
				}
				?>
				</td>
				<td align="center">
				<a href="javascript: void(0);" onClick="return listItemTask('cb<?php echo $i;?>','<?php echo $task;?>')">
				<img src="/administrator/images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>

		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="list" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0">

		</form>
		<?php
	}

	
	
}
?>