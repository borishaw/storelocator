<?php
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );


// load the html drawing class
require_once( $mainframe->getPath( 'class' ) );

/** load the html drawing class */
require_once( $mainframe->getPath( 'front_html' ) );


//Load Vars
$place_id   = intval( mosGetParam( $_REQUEST ,'id', 0 ) );
$catid 		= intval( mosGetParam( $_REQUEST ,'catid', 0 ) );
$category   = mosGetParam( $_REQUEST, 'category', null );
$sname      = mosGetParam( $_REQUEST , 'sname', null);
$center   = mosGetParam( $_REQUEST, 'center', null );
$urlLat = mosGetParam( $_REQUEST, 'lat', null );
$urlLng = mosGetParam( $_REQUEST, 'lng', null );
$urlZoom = mosGetParam( $_REQUEST, 'zoom', null );
$urlWidth = mosGetParam( $_REQUEST, 'mapWidth', null );
$urlHeight = mosGetParam( $_REQUEST, 'mapHeight', null );
$open = mosGetParam( $_REQUEST, 'open', null );
$marker = mosGetParam( $_REQUEST, 'marker', null);

/**
* Switch based on a task
*/
switch( $task ) {

   case 'new':
	    editPlace( 0, $option);
       break;
		
	case 'view':
		showWrap( $option, $category );
		break;

	case 'save':
	    savePlace( $option );
	    break;
	    
	case 'list':
        listMarkers( $option );
        break;
        
    case 'edit':
        editPlace( $place_id, $option );
        break;
   
    case 'remove':
        removePlace( $place_id, $option );
        break;

    case 'xml':
        pureXml( $option , $category );
        break;

    case 'xml2':
        pureXml2( $option , $category );
        break;

	default:
		showWrap( $option, $category );
		break;
}


/**
* Edit a record 
* @param database A database connector object
*/

function editPlace( $id, $option ) {
	global $database, $my;
	global $mosConfig_absolute_path, $mosConfig_live_site;

	if ($my->gid < 1) {
		mosNotAuth();
		return;
	}

	$row = new mosPlace( $database );
	// load the row from the db table
	$row->load( $id );

	// fail if checked out not by 'me'
	if ($row->checked_out && $row->checked_out <> $my->id) {
		mosRedirect( "index.php?option=$option",
		'The module $row->title is currently being edited by another person.' );
	}

	if ($id) {
		$row->checkout( $my->id );
	} else {
		// initialise new record
		$row->published 		= 0;
		$row->approved 		= 0;
		$row->ordering 		= 0;
	}

	// build list of categories
	$lists['catid'] 			= mosAdminMenus::ComponentCategory( 'catid', $option, intval( $row->catid ) );
    // get the configuration data
    $query2 = "SELECT * FROM #__google_maps_conf WHERE id = 1";
    $database->setQuery($query2);
    $confData = $database->loadObjectList();
    $confData = $confData[0];


	HTML_google_maps::editPlaceHTML( $option, $row, $lists , $confData);
}


/**
* Saves the record on an edit form submit
* @param database A database connector object
*/
function savePlace( $option ) {
	global $database, $my;

	if ($my->gid < 1) {
		mosNotAuth();
		return;
	}
	// See Joomla 1.5 Note
	$row = new mosPlace( $database );
	if (!$row->bind( $_POST, "approved published" )) {
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
	$confData = $database->loadObjectList();
	$confData = $confData[0];

	$isNew = $row->id < 1;

	$row->date = date( "Y-m-d H:i:s" );

	// pre-save checks
	if($confData->geocode) { 
		if (!$row->check()) {
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
	}
	
	$row->published = $confData->autoApprove;
	
	// If we didnt generate a lat/lng, mark as unpublished
	if ($row->lat == "" || $row->lng == "" && $row->markerType != "2") {
    	$row->published = 0;
	}
    
	// save the changes
	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}
	
	$row->checkin();
	
	/** Notify admin's **/ 
	$query = "SELECT email, name"
	. "\n FROM #__users"
	. "\n WHERE usertype = 'Super Administrator'"
	. "\n AND sendemail = '1'"
	;
	$database->setQuery( $query );
	if(!$database->query()) {
		echo $database->stderr( true );
		return;
	}

	$adminRows = $database->loadObjectList();
	foreach( $adminRows as $adminRow) {
		mosSendAdminMail($adminRow->name, $adminRow->email, "", "Google Map Marker", $row->title, $my->username );
	}

    // Joomla 1.5 Note
	$msg 	= $row->published ? "Thank you for your submission" : _THANK_SUB;
	$Itemid = mosGetParam( $_POST, 'Returnid', '' );
	mosRedirect( 'index.php?option=' .$option. '&Itemid='. $Itemid, $msg );
}


/**
* Removes records
* @param array An array of id keys to remove
* @param string The current GET/POST option
*/
function removePlace( &$cid, $option ) {
	global $database;

	if (count( $cid )) {
		$database->setQuery( "DELETE FROM #__google_maps WHERE id = $cid" );
		if (!$database->query()) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
	}

	mosRedirect( "index.php?option=$option" );
}

function showWrap( $option, $category , $iFrame = 0) {
    global $mosConfig_absolute_path;
	global $mainframe, $database, $my;
	global $mosConfig_live_site;
	global $Itemid;
	global $center, $marker, $open, $urlLat, $urlLng, $urlZoom, $urlWidth, $urlHeight, $sname;

	$menu =& new mosMenu( $database );
	$menu->load( $Itemid );

	$params =& new mosParameters( $menu->params );

	$params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
	$params->def( 'page_title', '1' );

    // get the configuration data
    $query = "SELECT * FROM #__google_maps_conf WHERE id = 1";
	$database->setQuery($query);
	$rows = $database->loadObjectList();
	$confData = $rows[0];

    $pcategory = explode($confData->catSep,$category);
    $pmarker = explode($confData->catSep,$marker);
    $visMarkCat["marker"] = $pmarker;
	$visMarkCat["category"] = $pcategory;

	$params->def( 'updateTime', $confData->xmlCache );
    $params->def( 'editBodytag', $confData->editBodytag );
	$params->def( 'tooltips'  , $confData->tooltip );
	$params->def( 'safariCompat', $confData->safariCompat );
	$params->def( 'overviewHeight' , $confData->overviewHeight );
	$params->def( 'overviewWidth'  , $confData->overviewWidth );
	$params->def( 'overviewEnable' , $confData->overviewEnable );
	$params->def( 'livesite',  $mosConfig_live_site );
	$params->def( 'APIKey',    $confData->APIKey);
	$params->def( 'sidebarShow' , $confData->sideShowtitle);
	$params->def( 'sidebarNum' , $confData->sideNum);
	$params->def( 'sideShowcat' ,$confData->sideShowcat);
	if(isset($center) && is_numeric($center)) {
	    $params->def( 'centerId', $center );
	    $urlCenter = true;
	} else {
	    $params->def( 'centerId', $confData->centerId );
	    $urlCenter = false;
	}
	$params->def( 'sidebarNum' , $confData->sideStyle);
	if(is_numeric($urlZoom)) {
        $params->def( 'zoomLevel', $urlZoom);
	} else {
        $params->def( 'zoomLevel', $confData->zoomLevel);
	}
	$params->def( 'contZoom' , $confData->contZoom );
	$params->def( 'doubleclickZoom' , $confData->doubleclickZoom );
	$params->def( 'mapBorder', $confData->mapBorder);
    if(!is_null($urlWidth) && strlen($urlWidth) < 7) {
        $params->def( 'mapWidth', $urlWidth);
    } else {
        $params->def( 'mapWidth', $confData->mapWidth);
	}
	if(!is_null($urlHeight) && strlen($urlHeight) < 7) {
        $params->def( 'mapHeight', $urlHeight);
	} else {
        $params->def( 'mapHeight', $confData->mapHeight);
    }
	$params->def( 'title', $confData->title);
	$params->def( 'misc',  $confData->misc);
	$params->def( 'showScale',$confData->showScale);
	$params->def( 'showType',$confData->showType);
    if($confData->xmlUrl == 1) {
        $urlTmp = '';
        if(isset($category)) $urlTmp .= trim('&category='.str_replace('|',',',$category));
        if(isset($marker)) $urlTmp .= trim('&marker='.str_replace('|',',',$marker));
        $params->def( 'xmlUrl' , "'index2.php?option=com_google_maps&task=xml2&no_html=1" . $urlTmp ."'");
    } else {
        $params->def( 'xmlUrl' , "'components/com_google_maps/google_maps.xml'" );
    }
    switch($confData->mappingAPI) {
      case '1':
      	switch($confData->whichType) {
            ////// This is where the map type is selected. Satellite Maps are best
            ////// for foreign places where street level maps are unavailible. 
            case "1":
                $params->def( 'whichType', 'YAHOO_MAP_REG');
                break;
		
            case "2":
                $params->def( 'whichType', "YAHOO_MAP_SAT");
                break;
		
            case "3":
                $params->def( 'whichType', 'YAHOO_MAP_HYB');
                break;
		
            default:
                $params->def( 'whichType', 'YAHOO_MAP_REG');
                break;
		
        }
        break;
      case '2':
        switch($confData->whichType) {
            ////// This is where the map type is selected. Satellite Maps are best
            ////// for foreign places where street level maps are unavailible. 
            case "1":
                $params->def( 'whichType', '"f"');
                break;
		
            case "2":
                $params->def( 'whichType', '"a"');
                break;
		
            case "3":
                $params->def( 'whichType', '"h"');
                break;
		
            default:
                $params->def( 'whichType', '"r"');
                break;
        }
        break;
      default:
        switch($confData->whichType) {
            ////// This is where the map type is selected. Satellite Maps are best
            ////// for foreign places where street level maps are unavailible. 
            case "1":
                $params->def( 'whichType', 'G_NORMAL_MAP');
                break;
		
            case "2":
                $params->def( 'whichType', "G_SATELLITE_MAP");
                break;
		
            case "3":
                $params->def( 'whichType', 'G_HYBRID_MAP');
                break;
		
            default:
                $params->def( 'whichType', 'G_NORMAL_MAP');
                break;
        }
        break;
    }

	if($confData->showZoom == 1) { // this makes sure people want the zoom/pan controls visible
		$params->def( 'whichZoom', $confData->whichZoom);
	} else { // The zoom controls are not displayed with the map
		$params->def( 'whichZoom', '0');
	}
	
	///// This code does the auto info window open stuff.
	///// The configuration flag is overrided by the url flag $open vs. $rows[0]->autoOpen
	
	if($open !== null && is_numeric($open)) {
		$params->def('autoOpen', $open);
	} elseif ($confData->autoOpen) {
		$params->def('autoOpen', $confData->autoOpen);
	} else {
		$params->def('autoOpen', 0);
	}
	
	unset($rows); // frees the $rows variable so it can be used by the actual markers

	// Select all the google_maps from category to map
    if($urlCenter == true) {
        $query2 = "SELECT *"
                . " FROM #__google_maps"
                . " WHERE published='1'"
                . " AND id = '".$params->get('centerId')."'"
                . " AND access <= '". $my->gid ."'"
                ;


		$database->setQuery( $query2 );
		$rows = $database->loadObjectList();

        $slng = null;
        $slat = null;
        if(!empty($rows[0]) && $rows[0]->lat) {
            $slng = $rows[0]->lng;
            $slat = $rows[0]->lat;
        }
	}
	///// This is very similar to the auto open function. There is a test 
	///// to make sure that the url specified center is actually on the map. 
	///// Non-showing points cannot be the center of the map thru the URL, 
	///// only thru the configuration is this possible.
	
    if($center === "0" && is_numeric($urlLat) && is_numeric($urlLng)) {
	  $params->def('centerLng', $urlLng);
	  $params->def('centerLat', $urlLat);
    } elseif(isset($center) AND !is_null($slng)) {
	  $params->def('centerLng', $slng);
	  $params->def('centerLat', $slat);
	} elseif($confData->centerId == "-1") {
		$database->setQuery( "SELECT * FROM #__comprofiler WHERE user_id = '".$my->id."'" );
		$userCenter = $database->loadObjectList();
		($userCenter[0]->cb_geolatitude) ? $params->def('centerLat', $userCenter[0]->cb_geolatitude) : $params->def('centerLat', $confData->centerLat);
		($userCenter[0]->cb_geolongitude) ? $params->def('centerLng', $userCenter[0]->cb_geolongitude) : $params->def('centerLng', $confData->centerLng);
     } elseif(!is_null($sname)) {
		$database->setQuery( "SELECT id,lat,lng FROM #__google_maps WHERE name = '".stripslashes(urldecode($sname))."'" );
        $atlspecials = $database->loadObjectList();
        $params->def('centerId', $atlspecials[0]->id);
		$params->def('centerLng', $atlspecials[0]->lng);
		$params->def('centerLat', $atlspecials[0]->lat);
     } else {
        $params->def( 'centerId', $confData->centerId );
		$params->def('centerLng', $confData->centerLng);
		$params->def('centerLat', $confData->centerLat);
	}
	
	/* Community Builder Integration 
	
	Here the Community Builder data is taken 
	from the comprofiler tables and inserted 
	into the $params->cb object.              */
	
	if($confData->communityEnable) {
        $params->def( 'cbSupport', 1);
        $params->def( 'cbRealname', $confData->communityHidereal);
	} else {
        $params->def( 'cbSupport', 0);
    }
	
    $mainframe->SetPageTitle($menu->name); // I've gotta change this!
	
	// I'm not really sure what any of these variables are. 
	// I should look into that.
	
	$params->def('image',1);
 	$params->set('introtext', 0 );
 	$params->set('popup', 0 );
 	
    // Create XML file if cache is used.
    if($confData->xmlCache != -1) {
        $xmlfile = $mosConfig_absolute_path."/components/".$option."/google_maps.xml";
        $xmlBuild = new xmlBuilder($option,$xmlfile);
        if($xmlBuild->xmlCreate()) $xmlBuild->xmlWrite(1);
    }

	
	if($iFrame == 1) {
        HTML_google_maps::displayNoHtml( $rows, $params, $menu , $visMarkCat, $confData->mappingAPI);
    } else {
        HTML_google_maps::display( $rows, $params, $menu , $visMarkCat, $confData->mappingAPI);
    }
}


/**
* List the records
* @param string The current GET/POST option
*/
function listMarkers( $option ) {
	global $database, $mainframe, $mosConfig_list_limit, $my;

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

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	// get the subset (based on limits) of required records
	$query = "SELECT * FROM #__google_maps AS cd"
//	. $where
//	. "\n ORDER BY cd.catid, cd.ordering, cd.name ASC"
    . "\n WHERE cd.user_id = $my->id"
//	. "\n LIMIT $pageNav->limitstart, $pageNav->limit"
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();
    
	
	// build list of categories
	$javascript = 'onchange="document.adminForm.submit();"';
	$lists['catid'] = mosAdminMenus::ComponentCategory( 'catid', $option, intval( $catid ), $javascript );

	HTML_google_maps::listMarkers( $rows, $pageNav, $search, $option, $lists );
}

function pureXml( $option, $category ) {
  global $mosConfig_absolute_path;
  // Create XML file each time config is saved.
  $xmlfile = $mosConfig_absolute_path."/components/".$option."/google_maps.xml";
  
  $xmlBuild = new xmlBuilder($option,$xmlfile);
  if($xmlBuild->xmlCreate()) $xmlBuild->xmlWrite();
}

function pureXml2( $option, $category ) {
  global $mosConfig_absolute_path, $task, $marker;


  // Create XML file each time config is saved.
  $xmlfile = $mosConfig_absolute_path."/components/".$option."/google_maps.xml";
  
  $xmlBuild = new xmlBuilder($option,$xmlfile,$task,$category,$marker);
  if($xmlBuild->xmlCreate()) {
    header("Content-Type: text/xml");
    header ("Content-length: ".strlen($xmlBuild->xmlFiledata)."");
    echo $xmlBuild->xmlFiledata;
  }
}


?>

 
 