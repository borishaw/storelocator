<?php
/**
* @version $Id: admin.google_maps.html.php,v 1.8 2005/09/17 17:41:17 dhpollack Exp $
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage google_maps
*/
class HTML_google_maps {

	function createJSArray($object, $key) {
		$j = 0;
		$return = '["';
		while($object[$j]->$key) {
			if($j == 0) {
				$return .= $object[$j]->$key;
			} elseif ($j > 0) {
				$return .= '","';
				$return .= $object[$j]->$key;
			}
			$j++;
		}
		$return .= '"]';
		return $return;
    }

	
	function showgoogle_maps( &$rows, &$pageNav, $search, $option, &$lists ) {
		global $my;

		mosCommonHTML::loadOverlib();
		?>
		<form action="index2.php" method="post" name="adminForm">
		<table class="adminheading">
		<tr>
			<th>
			Google Maps Marker Manager
			</th>
			<td>
			Filter:
			</td>
			<td>
			<input type="text" name="search" value="<?php echo $search;?>" class="inputbox" onChange="document.adminForm.submit();" />
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
			<th width="20" class="title">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($rows); ?>);" />
			</th>
			<th class="title">
			Name
			</th>
			<th width="5%" class="title" nowrap="true">
			Published
			</th>
			<th colspan="2" nowrap="nowrap" width="5%">
			Reorder
			</th>
			<th width="15%" align="left">
			Category
			</th>
		</tr>
		<?php
		$k = 0;
		for ($i=0, $n=count($rows); $i < $n; $i++) {
			$row = $rows[$i];

			$link 	= 'index2.php?option=com_google_maps&task=editA&hidemainmenu=1&id='. $row->id;

			$img 	= $row->published ? 'tick.png' : 'publish_x.png';
			$task 	= $row->published ? 'unpublish' : 'publish';
			$alt 	= $row->published ? 'Published' : 'Unpublished';

			$checked 	= mosCommonHTML::CheckedOutProcessing( $row, $i );

			$row->cat_link 	= 'index2.php?option=com_categories&section=com_google_maps&task=editA&hidemainmenu=1&id='. $row->catid;
			?>
			<tr class="<?php echo "row$k"; ?>">
				<td>
				<?php echo $pageNav->rowNumber( $i ); ?>
				</td>
				<td>
				<?php echo $checked; ?>
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
				<img src="images/<?php echo $img;?>" width="12" height="12" border="0" alt="<?php echo $alt; ?>" />
				</a>
				</td>
				<td>
				<?php echo $pageNav->orderUpIcon( $i, ( $row->catid == @$rows[$i-1]->catid ) ); ?>
				</td>
				<td>
				<?php echo $pageNav->orderDownIcon( $i, $n, ( $row->catid == @$rows[$i+1]->catid ) ); ?>
				</td>
				<td>
				<a href="<?php echo $row->cat_link; ?>" title="Edit Category">
				<?php echo $row->category; ?>
				</a>
				</td>
			</tr>
			<?php
			$k = 1 - $k;
		}
		?>
		</table>
		<?php echo $pageNav->getListFooter(); ?>

		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="hidemainmenu" value="0">
		<input type="hidden" name="act" value="all" />

		</form>
		<?php
	}

	function editPlace( &$row, &$lists, $option, &$confData, &$params ) {
		global $mosConfig_live_site, $my;

		$tabs = new mosTabs(0);

		mosCommonHTML::loadOverlib();
		
		$polyParams = $row->params;

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
				submitform( pressbutton );
			}
		}
		
		function enablePolyline() {
			var form = document.adminForm;
			var markerType = form.markerType.value;
			if (markerType == 2) 
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
		<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<form action="index2.php" method="post" name="adminForm">

		<table class="adminheading">
		<tr>
			<th>
			Place:
			<small>
			<?php echo $row->id ? 'Edit' : 'New';?>
			</small>
			</th>
		</tr>
		</table>

		<table width="100%">
		<tr>
			<td width="60%" valign="top">
				<table width="100%" class="adminform">
				<tr>
					<th colspan="2">
					Place Details
					</th>
				<tr>
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
			</td>
			<td width="40%" valign="top">
				<?php
				$tabs->startPane("content-pane");
				?>
				<table width="100%" class="adminform">
				<tr>
					<th colspan="2">
					Publishing Info
					</th>
				<tr>
				<tr>
					<td valign="top" align="right">
					Published:
					</td>
					<td>
					<?php echo $lists['published']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					Ordering:
					</td>
					<td>
					<?php echo $lists['ordering']; ?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="right">
					Access:
					</td>
					<td>
					<?php echo $lists['access']; ?>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;

					</td>
				</tr>
				<tr>
					<td colspan="2"><center><script type="text/javascript">
					<!--
                            google_ad_client = "pub-4724761257063482";
                            google_ad_width = 250;
                            google_ad_height = 250;
                            google_ad_format = "250x250_as";
                            google_ad_type = "text";
                            google_ad_channel ="4235430899";
                            google_color_border = "940F04";
                            google_color_bg = "E6E6E6";
                            google_color_link = "0000FF";
                            google_color_url = "008000";
                            google_color_text = "000000";
                            //--></script>
                         <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script></center></td>
				</tr>
				</table>
				<?php
				$tabs->endPane();
				?>
			</td>
		</tr>
		</table>

		<script language="Javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
		<input type="hidden" name="option" value="<?php echo $option; ?>" />
		<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="image" value="" />
		<input type="hidden" name="user_id" value="<?php echo $my->id ?>" />
    	<input type="hidden" name="act" value="all" />
		</form>
		<?php
	}


	
	
	function listConfiguration($option, &$rows, &$prows) {
	
		$row = $rows[0];
		$tabs = new mosTabs(0);
		mosMakeHtmlSafe( $row, ENT_QUOTES, 'xsl' );
//		$pdParams = $row->pdMarkers;
	?>
	<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
		<script language="javascript" type="text/javascript">

		function defaultConfig() {
            var form = document.adminForm;
			var defaultStyle = ("<\?xml version=\"1.0\"?>"
			+  "\n"+"<xsl:stylesheet version=\"1.0\" xmlns:xsl=\"http://www.w3.org/1999/XSL/Transform\">"
			+  "\n"+"	<xsl:template match=\"/\">"
			+  "\n"+"		<div class=\"infoWindow\" style=\"white-space:nowrap;min-width:200px\">"
			+  "\n"+"		    <xsl:apply-templates/>"
			+  "\n"+"		</div>"
			+  "\n"+"	</xsl:template>"
			+  "\n"+"	<xsl:template match=\"info\">"
			+  "\n"+"	<!-- This is the info window for all the markers in the Joomla database -->"
			+  "\n"+"     <p>"
			+  "\n"+"		<b><xsl:value-of select=\"name\"/></b>"
			+  "\n"+"		<br /><xsl:value-of select=\"address\"/>"
			+  "\n"+"		<br /><xsl:value-of select=\"city\"/>, <xsl:value-of select=\"state\"/><xsl:text> </xsl:text><xsl:value-of select=\"zipcode\"/>"
			+  "\n"+"     </p>"
			+  "\n"+"	</xsl:template>"
			+  "\n"+"	<xsl:template match=\"Result\">"
			+  "\n"+"	<!-- This is the info window for all the Yahoo Local Search component -->"
			+  "\n"+"     <p>"
			+  "\n"+"	    <xsl:choose>"
			+  "\n"+"		<xsl:when test=\"BusinessUrl\">"
			+  "\n"+"           <a>"
			+  "\n"+"               <xsl:attribute name=\"href\">"
			+  "\n"+"		            <xsl:value-of select=\"BusinessUrl\"/>"
			+  "\n"+"		        </xsl:attribute>"
			+  "\n"+"               <b><xsl:value-of select=\"Title\"/></b>"
			+  "\n"+"           </a>"
			+  "\n"+"       </xsl:when>"
			+  "\n"+"       <xsl:otherwise>"
			+  "\n"+"               <b><xsl:value-of select=\"Title\"/></b>"
			+  "\n"+"       </xsl:otherwise>"
			+  "\n"+"       </xsl:choose>"
			+  "\n"+"       <br /><xsl:value-of select=\"Address\"/>"
			+  "\n"+"       <br /><xsl:value-of select=\"City\"/>, <xsl:value-of select=\"State\"/>"
			+  "\n"+"       <br /><xsl:value-of select=\"Phone\"/>"
			+  "\n"+"		</p>"
			+  "\n"+"	</xsl:template>"
			+  "\n"+"	<!-- Here are some common things you can do in your info window "
			+  "\n"+""
			+  "\n"+"		Adding Driving Directions"
			+  "\n"+""
			+  "\n"+"		1. 1. Add the following code into the info template where you want the driving directions:"
			+  "\n"+""
			+  "\n"+"		<br /><br />"
			+  "\n"+"		<form action=\"http://maps.google.com/maps\" method=\"get\" target=\"_blank\">"
			+  "\n"+"		<i>Your address</i>: <br /><input type=\"text\" name=\"saddr\" size=\"20\" /><br />"
			+  "\n"+"		<input type=\"hidden\" name=\"daddr\"><xsl:attribute name=\"value\"><xsl:value-of select=\"address\"/><xsl:text>, </xsl:text><xsl:value-of select=\"city\"/>, <xsl:value-of select=\"state\"/><xsl:text> </xsl:text><xsl:value-of select=\"zipcode\"/></xsl:attribute></input>"
			+  "\n"+"		<input type=\"submit\" value=\"Directions\"/></form><br />"
			+  "\n"+""
			+  "\n"+"      ::::::::::::::::::::::::::::::::::"
			+  "\n"+""
			+  "\n"+"		Adding HTML into the Info Window"
			+  "\n"+""
			+  "\n"+"	1. Put the HTML you want added into the misc field of the marker"
			+  "\n"+"	2. add the following line into the info template where you want this HTML to go: <xsl:copy-of select=\"misc\" />"
			+  "\n"+""
			+  "\n"+"	-->"
			+  "\n"+""
			+  "\n"+"</xsl:stylesheet>");

			form.xsl.value = defaultStyle;

		}


		function submitbutton(pressbutton) {
            var form = document.adminForm;
			if (pressbutton == 'cancel') {
				submitform( pressbutton );
				return;
			}
						// do field validation
			if ( form.APIKey.value == "[Enter your API Key here]" ) {
				alert( "You must provide an API key." );
			} else {

				form.centerLat.disabled = false;
				form.centerLng.disabled = false;
				submitform( pressbutton );
			}
		}
		
		function changeCoord(lng, lat) {
            var form = document.adminForm;
			var cLat = "<?php echo $row->centerLat; ?>";
			var cLng = "<?php echo $row->centerLng; ?>";
			var id = form.centerId.options[form.centerId.selectedIndex].id;
			if (id == "userDef" || id == "currentUser") 
			{
				form.centerLat.disabled = false;
				form.centerLng.disabled = false;
				form.centerLat.value = form.centerLat.value;
				form.centerLng.value = form.centerLng.value;
			} 
			else 
			{
				form.centerLat.disabled = true;
				form.centerLng.disabled = true;
				form.centerLat.value = lat[id];
				form.centerLng.value = lng[id];
			}
		}
		
		function enablePdmarkers() {
            var form = document.adminForm;
			var pdmarkers = form.pdenable.value;
			if (pdmarkers == 1) 
			{
				form.pdstandardtip.disabled = false;
				form.pdtooltip.disabled = false;
			} 
			else 
			{
				form.pdstandardtip.disabled = true;
				form.pdtooltip.disabled = true;
			}
		}
		
		function enableSidetitle() {
            var form = document.adminForm;
            if(form.sideShowtitle.value == 1) {
               form.sideTitle.disabled = false;
            } else {
               form.sideTitle.disabled = true;
            }
        }

<?php
		$j = 0;
		$lng_array = '["';
		$lat_array = '["';
		for($j=0;count($prows) > $j;$j++) {
			if($j == 0) {
				$lng_array .= $prows[$j]->lng;
				$lat_array .= $prows[$j]->lat;
			} elseif ($j > 0) {
				$lng_array .= '","';
				$lng_array .= $prows[$j]->lng;
				$lat_array .= '","';
				$lat_array .= $prows[$j]->lat;
			}
		}
		$lng_array .= '"]';
		$lat_array .= '"]';
		
		echo "      var lng_array = $lng_array \n";
		echo "      var lat_array = $lat_array \n";

?>			
		</script>

	<form action="index2.php" enctype="multipart/form-data" method="post" name="adminForm">

	<table class="adminheading">
		<tr>
			<th>
			Google Maps:
			<small>Configure</small>
			</th>
		</tr>
	</table>
	<br />
<?php
	$tabs->startPane("configuration-pane");
	$tabs->startTab("General","configuration-pane");
?>

	<table cellspadding="4" cellspacing="0" border="0" width="99%" class="adminform">

	  <tr><td colspan="2"><center><script type="text/javascript">
	  <!--
google_ad_client = "pub-4724761257063482";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text";
google_ad_channel ="4235430899";
google_color_border = "940F04";
google_color_bg = "E6E6E6";
google_color_link = "0000FF";
google_color_url = "008000";
google_color_text = "000000";
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></center></td></tr>


   	  <tr>
		<th colspan="2">
		Required Configuration
		</th>
	  </tr>

	  <tr><td>Google API Key</td>
	  <td>
	  <input class="inputbox" type="text" name="APIKey" size="50" maxlength="100" value="<?php echo $row->APIKey;?>" />
	  </td></tr>

	  <tr><td> </td>
	  <td>
	  </td></tr>

   	  <tr>
		<th colspan="2">
		Optional Configuration
		</th>
	  </tr>

	  <tr><td>Tooltips</td>
	  <td>
	  <select name="tooltip">
		<option value="0" <?php if($row->tooltip == 0) echo "selected=\"selected\""; ?>>Hide</option>
		<option value="1" <?php if($row->tooltip == 1) echo "selected=\"selected\""; ?>>Show</option>
	  </select>
	  </td></tr>

	  <tr><td>Map Border</td>
	  <td>
	  <input class="inputbox" type="text" name="mapBorder" size="50" maxlength="100" value="<?php echo $row->mapBorder;?>" />
	  </td></tr>

	  <tr><td>Map Width</td>
	  <td>
	  <input class="inputbox" type="text" name="mapWidth" size="10" maxlength="10" value="<?php echo $row->mapWidth;?>" />
	  </td></tr>

	  <tr><td>Map Height</td>
	  <td>
	  <input class="inputbox" type="text" name="mapHeight" size="10" maxlength="10" value="<?php echo $row->mapHeight;?>" />
	  </td></tr>

	  <tr><td>Zoom Level</td>
	  <td>
	  <select name="zoomLevel">
	  <?php
		$i = 1;
		while($i < 18) {
?>
		<option value="<?php echo $i; ?>" <?php if($i == $row->zoomLevel) echo "selected=\"selected\""?>><?php echo $i; ?></option>
<?php
		$i++;
		}
		?>
		</select>
	  </td></tr>

	  <tr><td>Center Point</td>
	  <td>
	  <select name="centerId" onchange="changeCoord(lng_array, lat_array);">

			<option id="currentUser" value="-1" <?php if($row->centerId == -1) echo "selected=\"selected\""; ?>>Current User</option>
			<option id="userDef" value="0" <?php if($row->centerId == 0) echo "selected=\"selected\""; ?>>User Defined</option>
			<?php
			$i = 0;
			
			foreach($prows as $prow) {
?>
				<option id="<?php echo $i; ?>" value="<?php echo $prow->id; ?>" <?php if($prow->id == $row->centerId) echo "selected=\"selected\""; ?>><?php echo $prow->name; ?></option>
<?php
				$i++;
			}
		
		?>
		</select>
	  </td></tr>

	  <tr><td>Center Point Latitude</td>
	  <td>
	  <input class="inputbox" type="text" name="centerLat" size="10" maxlength="10" value="<?php echo "$row->centerLat"; ?>" <?php if($row->centerId >= 0) echo "disabled"; ?> />
	  </td></tr>
	  
	  <tr><td>Center Point Longitude</td>
	  <td>
	  <input class="inputbox" type="text" name="centerLng" size="10" maxlength="10" value="<?php echo "$row->centerLng"; ?>" <?php if($row->centerId >= 0) echo "disabled"; ?> />
	  </td></tr>

	  <tr><td>Automatically Open Center Point Info Window</td>
	  <td>
	  <select name="autoOpen">
		<option value="0" <?php if($row->autoOpen == 0) echo "selected=\"selected\""; ?>>No</option>
		<option value="1" <?php if($row->autoOpen == 1) echo "selected=\"selected\""; ?>>Yes</option>
	  </select>
	  </td></tr>

	  <tr><td>Map Scale Control</td>
	  <td>
		<select name="showScale">
		  <option value="1" <?php if($row->showScale == 1) echo "selected=\"selected\""; ?>>Show</option>
		  <option value="2" <?php if($row->showScale == 2) echo "selected=\"selected\""; ?>>Hide</option>
		</select>
		<br/>
	  </td></tr>

	  <tr><td>Map Zoom Controls</td>
	  <td>
		<select name="showZoom">
		  <option value="1" <?php if($row->showZoom == 1) echo "selected=\"selected\""; ?>>Show</option>
		  <option value="2" <?php if($row->showZoom == 2) echo "selected=\"selected\""; ?>>Hide</option>
		</select>
		<br/>
	  </td></tr>

	  <tr><td></td>
	  <td>
		&nbsp;&nbsp;<input type="radio" name="whichZoom" value="1" <?php if($row->whichZoom == 1) echo "checked"; ?>/>Large Pan and Zoom Control
		<br />
		&nbsp;&nbsp;<input type="radio" name="whichZoom" value="2" <?php if($row->whichZoom == 2) echo "checked"; ?>/>Small Pan and Zoom Control
		<br />
		&nbsp;&nbsp;<input type="radio" name="whichZoom" value="3" <?php if($row->whichZoom == 3) echo "checked"; ?>/>Zoom Control Only
	  </td></tr>

	  <tr><td>Enable Continuous Zoom</td>
	  <td>
	  <select name="contZoom">
		<option value="0" <?php if($row->contZoom == 0) echo "selected=\"selected\""; ?>>No</option>
		<option value="1" <?php if($row->contZoom == 1) echo "selected=\"selected\""; ?>>Yes</option>
	  </select>
	  </td></tr>
      
      <tr><td>Enable Double Click Zoom</td>
	  <td>
	  <select name="doubleclickZoom">
		<option value="0" <?php if($row->doubleclickZoom == 0) echo "selected=\"selected\""; ?>>No</option>
		<option value="1" <?php if($row->doubleclickZoom == 1) echo "selected=\"selected\""; ?>>Yes</option>
	  </select>
	  </td></tr>

	  <tr><td>Map Type Controls</td>
	  <td>
		<select name="showType">
		  <option value="1" <?php if($row->showType == 1) echo "selected=\"selected\""; ?>>Show</option>
		  <option value="2" <?php if($row->showType == 2) echo "selected=\"selected\""; ?>>Hide</option>
		</select>
		<br/>
	  </td></tr>

	  <tr><td></td>
	  <td>
		&nbsp;&nbsp;<input type="radio" name="whichType" value="1" <?php if($row->whichType == 1) echo "checked"?>/>Normal Map
		<br />
		&nbsp;&nbsp;<input type="radio" name="whichType" value="2" <?php if($row->whichType == 2) echo "checked"?>/>Satellite Map
		<br />
		&nbsp;&nbsp;<input type="radio" name="whichType" value="3" <?php if($row->whichType == 3) echo "checked"?>/>Hybrid Map
		<br />
	  </td></tr>

	  <tr><td>Title</td>
	  <td>
      <textarea name="title" rows="5" cols="50" class="inputbox"><?php echo $row->title; ?></textarea>
	  </td></tr>

	  <tr><td>Misc (footer)</td>
	  <td>
      <textarea name="misc" rows="5" cols="50" class="inputbox"><?php echo $row->misc; ?></textarea>
	  </td></tr>


	</table>
<?php
	$tabs->endTab();
	$tabs->startTab("Advanced","configuration-pane");
?>
	<table cellspadding="4" cellspacing="0" border="0" width="99%" class="adminform">


   	  <tr>
		<th colspan="2">
		Advanced Settings
		</th>
	  </tr>

	  <tr><td>URL Category Separator</td>
	  <td>
	  <select name="catSep">
		<option value="," <?php if($row->catSep == ",") echo "selected=\"selected\""; ?>>, (Normal Separator)</option>
		<option value="|" <?php if($row->catSep == "|") echo "selected=\"selected\""; ?>>| (SEF Separator)</option>
	  </select>
	  </td></tr>

	  <tr><td>Enable Overview MiniMap</td>
	  <td>
	  <select name="overviewEnable">
		<option value="0" <?php if($row->overviewEnable == "0") echo "selected=\"selected\""; ?>>Hide</option>
		<option value="1" <?php if($row->overviewEnable == "1") echo "selected=\"selected\""; ?>>Show On Map</option>
		<option value="2" <?php if($row->overviewEnable == "2") echo "selected=\"selected\""; ?>>Show In Module</option>
	  </select>
	  </td></tr>

	  <tr><td>Overview MiniMap Height</td>
	  <td>
        <input class="inputbox" type="text" name="overviewHeight" size="10" maxlength="10" value="<?php echo $row->overviewHeight ?>" />
	  </td></tr>

	  <tr><td>Overview MiniMap Width</td>
	  <td>
        <input class="inputbox" type="text" name="overviewWidth" size="10" maxlength="10" value="<?php echo $row->overviewWidth ?>" />
	  </td></tr>
	  
<!--
	  <tr><td>Use Safari Compatibility Mode</td>
	  <td>
	  <select name="safariCompat">
		<option value="0" <?php if($row->safariCompat == "0") echo "selected=\"selected\""; ?>>No</option>
		<option value="1" <?php if($row->safariCompat == "1") echo "selected=\"selected\""; ?>>Yes</option>
	  </select>
	  </td></tr>
-->
	  <tr><td>Dynamic XML Creation</td>
	  <td>
	  <select name="xmlUrl">
		<option value="0" <?php if($row->xmlUrl == "0") echo "selected=\"selected\""; ?>>No</option>
		<option value="1" <?php if($row->xmlUrl == "1") echo "selected=\"selected\""; ?>>Yes</option>
	  </select>
	  </td></tr>

	  <tr><td>Minutes between XML Caching</td>
	  <td>
        <input class="inputbox" type="text" name="xmlCache" size="10" maxlength="10" value="<?php echo $row->xmlCache;?>" />
	  </td></tr>

	  <tr><td>XML File Encoding</td>
	  <td>
        <input class="inputbox" type="text" name="xmlEncoding" size="10" maxlength="20" value="<?php echo $row->xmlEncoding;?>" />
	  </td></tr>

	  <tr><td>Automatically Geocode</td>
	  <td>
	  <select name="geocode">
		<option value="0" <?php if($row->geocode == 0) echo "selected=\"selected\""; ?>>No</option>
		<option value="1" <?php if($row->geocode == 1) echo "selected=\"selected\""; ?>>Yes</option>
	  </select>
	  </td></tr>

	  <tr><td>Edit Body Tag (do not change)</td>
	  <td>
	  <select name="editBodytag">
		<option value="0" <?php if($row->editBodytag == "0") echo "selected=\"selected\""; ?>>No</option>
		<option value="1" <?php if($row->editBodytag == "1") echo "selected=\"selected\""; ?>>Yes</option>
	  </select>
	  </td></tr>

	  <tr><td>Auto Approve User Submissions</td>
	  <td>
	  <select name="autoApprove">
		<option value="0" <?php if($row->autoApprove == 0) echo "selected=\"selected\""; ?>>No</option>
		<option value="1" <?php if($row->autoApprove == 1) echo "selected=\"selected\""; ?>>Yes</option>
	  </select>
	  </td></tr>

	  <tr><td>Require User Input For:</td>
	  <td>
        <input type="checkbox" name="reqAd" value="1" <?php if($row->reqAd == 1) echo "checked"; ?>> Address<br>
	  </td></tr>

	  <tr><td></td>
	  <td>
        <input type="checkbox" name="reqCt" value="1" <?php if($row->reqCt == 1) echo "checked"; ?>> City<br>
        <input type="checkbox" name="reqSt" value="1" <?php if($row->reqSt == 1) echo "checked"; ?>> State<br>
        <input type="checkbox" name="reqCn" value="1" <?php if($row->reqCn == 1) echo "checked"; ?>> Country<br>
        <input type="checkbox" name="reqZp" value="1" <?php if($row->reqZp == 1) echo "checked"; ?>> Zip Code<br>
        <input type="checkbox" name="reqLl" value="1" <?php if($row->reqLl == 1) echo "checked"; ?>> Coordinates<br>
	  </td></tr>
	  
   	  <tr>
		<th colspan="2">
		Backup Marker and Category Data
		</th>
	  </tr>
	  <tr>

	  <td colspan="2">
		
		<br />
		-----------------------------------------------------------------------------------
		<br /><br/>
		<strong>** Important Note: **</strong>
		<br />
        Restoring your data multiple times with the same file may cause duplicate entries into your database. 
		<br />
		<br /> 
		-----------------------------------------------------------------------------------
		<br />
	  </td>


	  <tr><td>Restore Marker and Category Data (Upload XML)</td>
	  <td>
        <input name="backupxml" type="file">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
	  </td></tr>

   	  <tr>
		<th colspan="2">
		Select Mapping API
		</th>
	  </tr>
	  <tr>

	  <td colspan="2">
		<strong>** Important Note: **</strong>
		<br />
        Only the Google Maps API is fully supported. The other APIs work, but are not fully functional. 
		<br />
	  </td>

	  <tr>
	   <td>Mapping API</td>
	   <td>
        <select name="mappingAPI">
            <option value="0" <?php if($row->mappingAPI == 0) echo "selected=\"selected\""; ?>>Google</option>
            <option value="1" <?php if($row->mappingAPI == 1) echo "selected=\"selected\""; ?>>Yahoo</option>
            <option value="2" <?php if($row->mappingAPI == 2) echo "selected=\"selected\""; ?>>Microsoft</option>
	    </select>
	   </td>
	  </tr>
	  
	  

	</table>

<?php
	$tabs->endTab();
	$tabs->startTab("XSL","configuration-pane");
?>
	<table cellspadding="4" cellspacing="0" border="0" width="99%" class="adminform">

   	  <tr>
		<th colspan="2">
		Minipage.xsl
		</th>
	  </tr>

	  <tr>

	  <td colspan="2">
		
		<br />
		-----------------------------------------------------------------------------------
		<br /><br/>
		<strong>** Warning **</strong>
		<br />
		Editing this part of the configuration may cause your info windows to stop working.<br />
		You must use well formed HTML and XML or else the info windows will not pop-up.<br />
		If you are unfamiliar with XSL, a good tutorial can be found <a href="http://www.w3schools.com/xsl/">here</a>.<br />
		This is an advanced feature of the component. Consider yourself warned.<br />
		<br />
		<br /> 
		-----------------------------------------------------------------------------------
		<br />
	  </td>
	  </tr>


	  <tr>
	  <td colspan="2">
		<textarea name="xsl" rows="25" cols="100%" class="inputbox"><?php echo $row->xsl; ?></textarea>
		<br />
		<input class="inputbox" type="button" size="20" value="Default" onClick="defaultConfig()"/>
	  </td>
	  </tr>
	
	</table>
	
<?php
	$tabs->endTab();
	if(file_exists("../modules/mod_google_maps_sidebar.php")) {
	$tabs->startTab("Sidebar","configuration-pane");
?>
	<input type="hidden" name="sideShowtitle" value="1" />

	<table cellspadding="4" cellspacing="0" border="0" width="99%" class="adminform">
   	  <tr>
		<th colspan="2">
		Google Maps Sidebar
		</th>
	  <tr>
	  

	  <tr><td>List by Category</td>
	  <td>
	  <select name="sideShowcat">
		<option value="0" <?php if($row->sideShowcat == 0) echo "selected=\"selected\""; ?>>No</option>
		<option value="1" <?php if($row->sideShowcat == 1) echo "selected=\"selected\""; ?>>Yes</option>
	  </select>
	  </td></tr>

	  <tr><td>Number of Markers to List</td>
	  <td>
	  <input class="inputbox" type="text" name="sideNum" size="2" maxlength="3" value="<?php echo $row->sideNum;?>" />
	  </td></tr>
	  
	</table>

<?php
    $tabs->endTab();
    } else {
     echo '<input type="hidden" name="sideShowtitle" value="0" />';
    }
	if(file_exists("../components/com_comprofiler/plugin/user/plug_geocoder/geocoder.php")) {
	$tabs->startTab("CB","configuration-pane");
?>
	<table cellspadding="4" cellspacing="0" border="0" width="99%" class="adminform">

   	  <tr>
		<th colspan="2">
		Community Builder
		</th>
	  <tr>

	 <tr><td>Map Users</td>
	  <td>
	  <select name="communityEnable">
		<option value="0" <?php if($row->communityEnable == 0) echo "selected=\"selected\""; ?>>No</option>
		<option value="1" <?php if($row->communityEnable == 1) echo "selected=\"selected\""; ?>>All Users</option>
		<option value="2" <?php if($row->communityEnable == 2) echo "selected=\"selected\""; ?>>Online Users</option>
	  </select>
      </td>
     </tr>

	 <tr><td>Hide Real Names</td>
	  <td>
	  <select name="communityHidereal">
		<option value="0" <?php if($row->communityHidereal == 0) echo "selected=\"selected\""; ?>>No</option>
		<option value="1" <?php if($row->communityHidereal == 1) echo "selected=\"selected\""; ?>>Yes</option>
	  </select>
      </td>
     </tr>

  	  <tr><td>User Category Icon</td>
	  <td>
	  <input class="inputbox" type="text" name="communityIcon" size="2" maxlength="3" value="<?php echo $row->communityIcon ?>" />
	  </td></tr>

  	  <tr><td>Total Number of Users Mapped (highly recommended to be below 200)</td>
	  <td>
	  <input class="inputbox" type="text" name="communityLimit" size="4" maxlength="5" value="<?php echo $row->communityLimit ?>" />
	  </td></tr>
	</table>


<?php
    $tabs->endTab();
    }
    $tabs->startTab("Troubleshoot","configuration-pane");
?>
	<table cellspadding="4" cellspacing="0" border="0" width="99%" class="adminform">
   	<tr>
	 <th colspan="2">
		Troubleshoot
	 </th>
	</tr>
	<tr>  
	  <td colspan="2">

    <h3>Here are some helpful tips for troubleshooting this component.</h3><br />
    <ul>
        <li><h3>Download <script type="text/javascript"><!--
google_ad_client = "pub-4724761257063482";
google_ad_output = "textlink";
google_ad_format = "ref_text";
google_cpa_choice = "CAAQzcLH7QEaCD_4BVTjvVryKLGsuIEB";
google_ad_channel = "";
//--></script>
<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>. Firefox is a FAR superior browser than Internet Explorer for almost all things. Even if you don't like to use it for 
your day to day browsing, there are a lot of features that are very helpful for webmasters. The rest of this will assume that you 
are running Firefox.</h3></li>
        <li><h3> Read the <a href="components/com_google_maps/help/README.html">README</a> file. I don't keep it as up to date as I should, 
             but it's a good starting point.</h3></li>
        <li><h3> If your markers mysteriously disappear or won't disappear, then try the following before asking for help.</h3>
          <ul>
            <li><h3>Watch out for special characters. Foriegn characters may cause IE to choke on your XML. If this is the case you'll have to 
                edit the ISO encoding of your XML file in the advanced section of this configuration. Look on the internet to find your countries 
                ISO encoding.</h3></li>
            <li><h3>Watch out for bad XHTML in your XML file. XHTML is a more strict form of HTML. All tags must be closed properly. &lt;br&gt; is bad 
                XHTML. Use &lt;br /&gt; instead. Generally if you look at your <a href="../components/com_google_maps/google_maps.xml">own XML file</a> 
                you'll see errors pop up in Firefox.</h3></li>
            <li><h3>Check your <a href="../components/com_google_maps/google_maps.xml">XML file</a>. It's important enough that I mention it twice.</h3></li>
            <li><h3>Flush your cache and restart Internet Explorer. This is a known problem with Internet Explorer and is one of the reasons 
                I hate the browser. Honestly, it's caused me too much grief. Firefox isn't perfect, but nothing is.</h3></li>
            <li><h3>Rebuild your XML file. <a href="../index.php?option=com_google_maps&task=xml">Click here to rebuild your XML file</a>.</h3></li>
          </ul>
         </li>
         <li><h3>The "XSL file" can be edited for this components configuration under the "XSL" tab. This is where you add links 
             to the info window (bubble that appears when you click markers) and directions. Instructions to do so are in the 
             XSL file itself.</h3></li>
         <li><h3>If you just get the "Loading Map...", but the map never loads then open the javascript console under tools in Firefox. 
             It may give you an error message that will lead you to your problem.</h3></li>
         <li><h3>If "nothing happens" when you click your markers then look at the javascript console in Firefox. You may see that xmlDoc has no 
             properties or something like that. This means that your server doesn't handle files with the xsl extension (file.xsl) correctly. You 
             must get your host to change the MIME type of xsl files to text/xml. If you run your own server then look up how to add MIME types for 
             your particular server. You can test this be going to <a href="../components/com_google_maps/minipage.xsl">your xsl file</a>. If 
             there is pretty formatting then your server is configured correctly and if it comes up as plain text then you'll need to fix your 
             MIME type.</h3></li>
         <li><h3>When all else fails go to the <a href="http://forge.joomla.org/sf/discussion/do/listTopics/projects.google_maps/discussion.general_discussion">dicussion board</a> at the project homepage and ask your question. REMEMBER TO POST A URL TO YOUR 
             WEBSITE! This will help you get your problem fixed and allow me to keep my sanity. Without a URL it is very diffifult to diagnose a problem.</h3></li>
         <li><h3><a href="http://www.flickr.com/photos/95948121@N00/sets/72157594241014488/">Step-By-Step Visual Instructions</a>. I've created a photo set on 
             Flickr.com that shows basically what you should do to install the component. If you have problems make sure your configuration looks similar to 
             this setup. Note the XSL and XML files as those will look different if your server isn't configured correctly.</h3></li>
         <li><h3>Finally, I want to thank all of the people that use this component. You are the reason that this thing gets better and better. 
             Without the kind words from you, I probably would have stopped doing this a long time ago.</h3></li>
     
     </ul>
     
     <br /><br />
     </td>
    </tr>
    </table>
<?php    
    $tabs->endTab();
	$tabs->endPane();
?>

	<input type="hidden" name="option" value="<?php echo $option; ?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="id" value="<?php echo $row->id; ?>" />
	<input type="hidden" name="act" value="configure" />
	
	</form>
    <br /><br />
                <!-- FeedBurner Email Subscription Service. -->
                <form name="feedburnerForm" style="text-align:center;" action="http://www.feedburner.com/fb/a/emailverify" method="post" target="popupwindow" onsubmit="window.open('http://www.feedburner.com', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true"><p>Subscribe to this component's blog via email:</p><p><input type="text" style="width:140px" name="email"/></p><input type="hidden" value="http://feeds.feedburner.com/~e?ffid=405302" name="url"/><input type="hidden" value="Joomla! Google Maps Blog" name="title"/><input type="submit" value="Subscribe" /></form>
                

 <?php

 }
}
?>