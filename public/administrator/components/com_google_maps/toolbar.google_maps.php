<?php
/**
* @version $Id: toolbar.google_maps.php,v 1.3 2005/09/17 17:41:17 sjashe Exp $
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ( $task ) {
	case 'new':
	case 'edit':
	case 'editA':
		TOOLBAR_google_maps::_EDIT();
		break;

	default:
	switch ($act)
	{
	    case "configure":
		TOOLBAR_google_maps::_CONFIGURE();
	    break;
	
	    default:
		TOOLBAR_google_maps::_DEFAULT();
		break;
	}
	break;
}
?>