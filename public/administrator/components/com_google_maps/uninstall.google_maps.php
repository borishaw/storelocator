<?php

function com_uninstall() {
	global $database;
	// Remove the menu items for the component.
	$database->setQuery( "DELETE FROM #__menu WHERE link LIKE 'index.php?option=com_google_maps%'" );
	if ( !$database->query() ) {
		return false;
	}


	
	$database->setQuery( "DELETE FROM #__categories WHERE section='com_google_maps'" );
	if ( !$database->query() ) {
	   return false;
	} else {
		print "<p>Couldn't find google_maps categories, make sure you delete it.</p>";	
	}
	

	return "Google Maps. Successfully Uninstalled";
}


?>