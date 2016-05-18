<?php

/*
function com_install() {
  echo "Installation Successfull";
}
*/


function com_install() {
	global $database, $mosConfig_absolute_path;

	// Find component id and link from the components table.
	$sql = "SELECT id, link from #__components WHERE name='Google Maps'";
	$database->setQuery($sql);
	$row = null;
	if ( !$database->loadObject( $row ) ) {
		#return $database->stderr();
		return false;
	}

	
	// Insert a default category for the google_maps section.
	$cat = new mosCategory( $database );
	$cat->title = "default";
	$cat->name = "default";
	$cat->image = "";
	$cat->section = "com_google_maps";
	$cat->image_position = "left";
	$cat->description = "";
	$cat->published = "1";
	if ( !$cat->store() || !$cat->checkin()) {
		return false;
	}

	// Get the category id
	$database->setQuery( "SELECT id FROM #__categories WHERE section='com_google_maps'" );
	if ( !$catid = $database->loadResult() ) {
		return false;
	}

	// Change the image for the settings submenu in the admin section.
	$sql = "UPDATE #__components SET admin_menu_img='js/ThemeOffice/config.png' WHERE admin_menu_link='option=com_google_maps&task=conf'";
	$database->setQuery($sql);
	if ( !$database->query() ) {
		return false;
	}

	// Change the image for the Mange Properties submenu in the admin section.
	$sql = "UPDATE #__components SET admin_menu_img='js/ThemeOffice/help.png' WHERE admin_menu_link='option=com_google_maps&task=info'";
	$database->setQuery($sql);
	if ( !$database->query() ) {
		return false;
	}

	
/*
	// Add section id and category id to configuration file.
	$cfgfile = "$mosConfig_absolute_path/components/com_mamblog/configuration.php";
	$config = file( $cfgfile );
	$newitems = array( "<?php\n", "\$cfg_mamblog['sectionid'] = \"$secid\";\n", "\$cfg_mamblog['catid'] = \"$catid\";\n" );
	array_splice( $config, 0, 1, $newitems );
	$config = implode( "", $config );
	if ( $fp = fopen( $cfgfile, "w" ) ) {
		fwrite( $fp, $config, strlen( $config ) );
		fclose( $fp );
	} else {
		return false;
	}
*/
/*
	# Add help information
INSERT INTO #__help
( lang, context, name, title, parent, ordering, catid, helptext )
VALUES (
'eng',
'com_mamblog',
'Mamblog',
'The Mamblog Component',
'13',
'7',
'3',
'asdf asdf af asdf'
)
*/
  $filename = "../administrator/components/com_google_maps/help/README.html" ;
  $dataFile = file( $filename ) ;
  
    echo "Installed Successfully\n<br />\n";
    echo "<div align='left'>";
    echo "<p><pre>";
    $i = 0;
    while ($dataFile[$i]) {
		echo $dataFile[$i];
		$i++;
	}
    echo "</pre></p>";
    echo "</div>";
}



?>