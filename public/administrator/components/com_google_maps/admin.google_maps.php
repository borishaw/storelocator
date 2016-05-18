<?php
/**
* @version $Id: admin.google_maps.php,v 1.7 2005/09/17 17:41:17 sjashe Exp $
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
		| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_google_maps' ))) {
	mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );
// See Joomla 1.5 Notes
$id 	= mosGetParam( $_GET, 'id', 0 );
$cid 	= mosGetParam( $_POST, 'cid', array(0) );
if (!is_array( $cid )) {
	$cid = array(0);
}


switch ($act) {

  case "configure": 
  switch ($task) {
    case 'save':
	   saveConfiguration($option);
	   break;
	default:
	   listConfiguration($option);
	   break;
  }
  break;
  
  default:
  switch ($task) {

	case 'new':
		editPlace( '0', $option);
		break;

	case 'edit':
		editPlace( $cid[0], $option );
		break;

	case 'editA':
		editPlace( $id, $option );
		break;

	case 'save':
		savePlace( $option );
		break;

	case 'remove':
		removegoogle_maps( $cid, $option );
		break;

	case 'publish':
		changegoogle_maps( $cid, 1, $option );
		break;

	case 'unpublish':
		changegoogle_maps( $cid, 0, $option );
		break;

	case 'orderup':
		ordergoogle_maps( $cid[0], -1, $option );
		break;

	case 'orderdown':
		ordergoogle_maps( $cid[0], 1, $option );
		break;

    case 'cancel':
        cancelPlace();
		break;

	default:
		showgoogle_maps( $option );
		break;
  }
  break;

}




function saveConfiguration($option) {
  global $database,$mosConfig_absolute_path;
  
  $row = new mosPlaceConf($database);

  $xslfile = "../components/".$option."/minipage.xsl";


  // XSL Save
  
  @chmod ($xslfile, 0766);
  $xslpermission = is_writable($xslfile);
  if (!$xslpermission) { // Make sure the xsl file is writable by the server.
     $mosmsg = "Config File Not writeable";
     exit();
  }

  // Joomla 1.5 Note
  // http://dev.joomla.org/component/option,com_jd-wp/Itemid,33/p,158/
  if (!$row -> bind($_POST)) { // attach post variables to $row
     echo "<script> alert('"
	          .$row -> getError()
			  ."'); window.history.go(-1);</script>n";
	 exit();
  }

	// save pdMarkers
    // $_POST
	$pdMarkers = mosGetParam( $_POST, 'pdMarkers', '' );
	if (is_array( $pdMarkers )) {
		$txt = array();
		foreach ( $pdMarkers as $k=>$v) {
			$txt[] = "$k=$v";
		}
		$row->pdMarkers = implode( "\n", $txt );
	}

  $xsltxt = $row->xsl; 
  if ($fp = fopen("$xslfile", "w+")) { // Write the new XSL file over the old one.
     fputs($fp, $xsltxt, strlen($xsltxt));
     fclose ($fp);
  }
  @chmod ($xslfile, 0644);

  

  unset($row->xsl); // Make sure the XSL file data is not written into the database.
  if (!$row -> store() ) {
     echo "<script> alert('"
	      .$row -> getError()
		  ."'); window.history.go(-1); </script>n";
		  
     exit();
  }
 
  // Create XML file each time config is saved.
  $xmlfile = $mosConfig_absolute_path."/components/".$option."/google_maps.xml";
  $xmlBuild = new xmlBuilder($option,$xmlfile);
  if($xmlBuild->xmlCreate()) $xmlBuild->xmlWrite();

  // Import markers from XML file

  $fileType = $_FILES['backupxml']['type'];
  $fileName = $_FILES['backupxml']['tmp_name'];
  $x = new importMarkers($fileName, $fileType);
  
  switch($x->action) {
    case 1: 
        $query = $x->buildmarkerQuery();
        $query2 = $x->buildcategoryQuery();
        break;
    case 2:
        $query = $x->buildmarkerQueryPHP5();
        $query2 = $x->buildcategoryQueryPHP5();
        break;
    case 3:
        $query = $x->buildmarkerQuery();
        $query2 = false;
        break;
    default:
        $query = false;
        $query2 = false;
        break;
    }
        
    if($query) {
        $database->setQuery($query);
        $database -> loadObjectList();
        if($database -> getErrorNum()) {
            echo $database -> stderr();
            return false;
        }
    }
    if($query2) {
        $database->setQuery($query2);
        $database -> loadObjectList();
        if($database -> getErrorNum()) {
            echo $database -> stderr();
            return false;
        }
    }


 

  mosRedirect("index2.php?option=$option&act=configure","Configuration Saved " );
}



function listConfiguration($option) {

    global $database, $mainframe, $mosConfig_absolute_path;
	$filename = "../components/".$option."/minipage.xsl"; // This is the path of the XSL sheet
	if ($fp = fopen( $filename, "r" )) {
		$xsl_sheet = fread( $fp, filesize( $filename ) );
		fclose ($fp);
	}
	
	
	$database->setQuery("SELECT * from #__google_maps_conf");
	$rows = $database -> loadObjectList();
	
	if ($database -> getErrorNum()) {
	   echo $database -> stderr();
	   return false;
	}
	
	$rows[0]->xsl = "$xsl_sheet"; // add the XSL sheet to the variable $rows so we can use it on the next page
	$query = "SELECT name, id, lat, lng"
	. " FROM #__google_maps"
	. " ORDER BY name"
	. " LIMIT 250"
	;
	$database->setQuery( $query ); // get some information for the center point data array
	$prows = $database->loadObjectList();

	HTML_google_maps::listConfiguration($option, $rows, $prows);

}


/**
* List the records
* @param string The current GET/POST option
*/
function showgoogle_maps( $option ) {
	global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

	$catid 		= $mainframe->getUserStateFromRequest( "catid{$option}", 'catid', 0 );
	$limit 		= $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
	$search 	= $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search 	= $database->getEscaped( trim( strtolower( $search ) ) );
	
	if ( $search ) {
		$where[] = "cd.name LIKE '%$search%'";
	}
	if ( $catid ) {
		$where[] = "cd.catid = '$catid'";
	}
	if ( isset( $where ) ) {
		$where = "\n WHERE ". implode( ' AND ', $where );	
	} else {
		$where = '';
	}

	// get the total number of records
	$database->setQuery( "SELECT COUNT(*) FROM #__google_maps AS cd $where" );
	$total = $database->loadResult();

	require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	// get the subset (based on limits) of required records
	$query = "SELECT cd.*, cc.title AS category, v.name as editor"
	. "\n FROM #__google_maps AS cd"
	. "\n LEFT JOIN #__categories AS cc ON cc.id = cd.catid"
	. "\n LEFT JOIN #__users AS v ON v.id = cd.checked_out"
	. $where
	. "\n ORDER BY cd.catid, cd.ordering, cd.name ASC"
	. "\n LIMIT $pageNav->limitstart, $pageNav->limit"
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	
	// build list of categories
	$javascript = 'onchange="document.adminForm.submit();"';
	$lists['catid'] = mosAdminMenus::ComponentCategory( 'catid', $option, intval( $catid ), $javascript );

	HTML_google_maps::showgoogle_maps( $rows, $pageNav, $search, $option, $lists );
}

/**
* Creates a new or edits and existing user record
* @param int The id of the record, 0 if a new entry
* @param string The current GET/POST option
*/
function editPlace( $id, $option ) {
	global $database, $my;
	global $mosConfig_absolute_path, $mosConfig_live_site, $mosConfig_zero_date;


	$row = new mosPlace( $database );
	// load the row from the db table
	$row->load( $id );


	if ($id) {
	// do stuff for existing records
		$row->checkout($my->id);
	} else {
		// do stuff for new records
		$row->ordering = 0;
		$row->published = 1;
	}
	$lists = array();

	// build the html select list for ordering
	$query = "SELECT ordering AS value, name AS text"
	. "\n FROM #__google_maps"
	. "\n WHERE published >= 0"
	. "\n AND catid = '$row->catid'"
	. "\n ORDER BY ordering"
	;
	$lists['ordering'] 			= mosAdminMenus::SpecificOrdering( $row, $id, $query, 1 );
	
	// build list of categories
	$lists['catid'] 			= mosAdminMenus::ComponentCategory( 'catid', $option, intval( $row->catid ) );
	// build the html select list for images
	// $lists['image'] 			= mosAdminMenus::Images( 'image', $row->image );
	// build the html select list for the group access
	$lists['access'] 			= mosAdminMenus::Access( $row );
	// build the html radio buttons for published
	$lists['published'] 		= mosHTML::yesnoradioList( 'published', '', $row->published );

	// get params definitions
	// $file = $mosConfig_absolute_path .'/administrator/components/com_google_maps/google_maps_items.xml';
	$row->params =& new mosParameters( $row->params );
	$params = null;
	
	$database->setQuery("SELECT * from #__google_maps_conf");
	$confData2 = $database -> loadObjectList();
	$confData = $confData2[0];
	
	HTML_google_maps::editPlace( $row, $lists, $option, $confData, $params );
}


/**
* Saves the record from an edit form submit
* @param string The current GET/POST option
*/
function savePlace( $option ) {
	global $database, $mosConfig_absolute_path;
    
    // See Joomla 1.5 Note
	$row = new mosPlace( $database );
	if (!$row->bind( $_POST )) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	// save params
	$params = mosGetParam( $_POST, 'params', '' );
	if (is_array( $params )) {
		$txt = array();
		foreach ( $params as $k=>$v) {
			$txt[] = "$k=$v";
		}
		$row->params = implode( "\n", $txt );
	}

    $q2 = "SELECT * FROM #__google_maps_conf WHERE id = 1";
	$database->setQuery($q2);
	$confData2 = $database->loadObjectList();
	$confData = $confData2[0];

	// pre-save checks
	if($confData->geocode) { 
		if (!$row->check()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
	}
	// If we didnt generate a lat/lng, mark as unpublished
	if ($row->lat == "" || $row->lng == "") {
    	$row->published = 0;
	}

	// save the changes
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	$row->checkin();
	$row->updateOrder();

    // Create XML file each time config is saved.
    $xmlfile = $mosConfig_absolute_path."/components/".$option."/google_maps.xml";
    $xmlBuild = new xmlBuilder($option,$xmlfile);
    if($xmlBuild->xmlCreate()) $mosmsg = "XML Built \n";
    if($xmlBuild->xmlWrite())  $mosmsg .= "XML Wrote \n";

	mosRedirect( "index2.php?option=$option");
}

/**
* Removes records
* @param array An array of id keys to remove
* @param string The current GET/POST option
*/
function removegoogle_maps( &$cid, $option ) {
	global $database,$mosConfig_absolute_path;

	if (count( $cid )) {
		$cids = implode( ',', $cid );
		$database->setQuery( "DELETE FROM #__google_maps WHERE id IN ($cids)" );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
	}
	
	// Create XML file each time config is saved.
    $xmlfile = $mosConfig_absolute_path."/components/".$option."/google_maps.xml";
    $xmlBuild = new xmlBuilder($option,$xmlfile);
    if($xmlBuild->xmlCreate()) $mosmsg = "XML Built \n";
    if($xmlBuild->xmlWrite())  $mosmsg .= "XML Wrote \n";


	mosRedirect( "index2.php?option=$option&act=all" );
}

/**
* Changes the state of one or more place pages
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The current option
*/
function changePlace( $cid=null, $state=0, $option ) {
	global $database, $my;

	if (count( $cid ) < 1) {
		$action = $state == 1 ? 'publish' : 'unpublish';
		echo "<script> alert('Select a record to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__google_maps SET published='$state'"
	. "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))"
	);
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1) {
		$row = new mosPlace( $database );
		$row->checkin( intval( $cid[0] ) );
	}

	mosRedirect( "index2.php?option=$option&act=all" );
}

/** JJC
* Moves the order of a record
* @param integer The increment to reorder by
*/
function ordergoogle_maps( $uid, $inc, $option ) {
	global $database;
	
	$row = new mosPlace( $database );
	$row->load( $uid );
	$row->move( $inc, "published >= 0" );

	mosRedirect( "index2.php?option=$option&act=all" );
}

/** PT
* Cancels editing and checks in the record
*/
function cancelPlace() {
	global $database;
	
	// See Joomla 1.5 Note
	$row = new mosPlace( $database );
	$row->bind( $_POST );
	$row->checkin();
	mosRedirect('index2.php?option=com_google_maps&act=all');
}



/**
* Changes the state of one or more place pages
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The current option
*/
function changegoogle_maps( $cid=null, $state=0, $option ) {
	global $database, $my;

	if (count( $cid ) < 1) {
		$action = $state == 1 ? 'publish' : 'unpublish';
		echo "<script> alert('Select a record to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$database->setQuery( "UPDATE #__google_maps SET published='$state'"
	. "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))"
	);
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	if (count( $cid ) == 1) {
		$row = new mosPlace( $database );
		$row->checkin( intval( $cid[0] ) );
	}

	mosRedirect( "index2.php?option=$option&act=all" );
}

?>