<?php
/**
 * SEF module for Joomla!
 * Originally written for Mambo as 404SEF by W. H. Welch.
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007
 * @package     sh404SEF
 * @version     $Id: admin.sef.php 24 2007-09-19 18:35:29Z silianacom-svn $
 * {shSourceVersionTag: V 1.2.4.x - 2007-09-20}
 */
 
// Security check to ensure this file is being included by a parent file.
if (!defined('_VALID_MOS')) die('Direct Access to this location is not allowed.');
// Ensure that user has access to this function.
if (!($acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'all')
    | $acl->acl_check('administration', 'edit', 'users', $my->usertype, 'components', 'com_sef'))) {
    mosRedirect('index2.php', _NOT_AUTH);
}

// Setup paths.
$sef_config_class = $GLOBALS['mosConfig_absolute_path']."/administrator/components/com_sef/sh404sef.class.php";
$sef_config_file  = $GLOBALS['mosConfig_absolute_path']."/administrator/components/com_sef/config/config.sef.php";

// shumisha 2007-03-13 added URL and iso code caching
require_once($GLOBALS['mosConfig_absolute_path'].'/components/com_sef/shCache.php');
require_once($mainframe->getPath('admin_html'));

// Make sure class was loaded.
if (!class_exists('SEFConfig')) {   // V 1.2.4.T was wrong variable name $SEFConfig_class instead of $sef_config_class
    if (is_readable($sef_config_class)) require_once($sef_config_class);
    else die(_COM_SEF_NOREAD."( $sef_config_class )<br />"._COM_SEF_CHK_PERMS);
}

// V 1.2.4.t include language file
shIncludeLanguageFile();

$cid    = mosGetParam($_REQUEST, 'cid', array(0));
$sortby = mosGetParam($_REQUEST, 'sortby', 0);
// V 1.2.4.q initialize variable, to prevent E_NOTICE errors
if (!isset($ViewModeId))
  $ViewModeId = mosGetParam($_REQUEST, 'ViewModeId', 0);
if (!isset($section))   
  $section = mosGetParam($_REQUEST, 'section', null);
if (!isset($task))   
  $task = mosGetParam($_REQUEST, 'section', null);
if (!isset($eraseCache))   
  $eraseCache = mosGetParam($_REQUEST, 'eraseCache', null);
if (!isset($returnTo))   // V 1.2.4.t
  $returnTo = mosGetParam($_REQUEST, 'returnTo', 0);  
$sefConfig = new SEFConfig();
if (!is_array($cid)) $cid = array(0);
// Action switch.

switch ($task) {
    case 'cancel': {
        cancelsh404($option, $section, $returnTo); // V 1.2.4.t added returnTo
        break;
    }
    case 'edit': {
        if ($section == 'meta')
          editMeta($cid[0], $option);
        else editSEF($cid[0], $option);
        break;
    }
    case 'help': {
        HTML_sef::help();
        break;
    }
    case 'info': {
        include ($GLOBALS['mosConfig_absolute_path'].'/administrator/components/com_sef/readme.inc.php');
        break;
    }
    case 'new': {
        editSEF(0, $option);
        break;
    }
    case 'newMeta': {
        editMeta(0, $option, 0);  // V 1.2.4.t  always return to Meta Mngt screen
        break;
    }
    case 'newMetaFromSEF': {
        editMeta(0, $option, 1, $cid[0]);  // V 1.2.4.t return to where we're coming from
        break;
    }
    case 'newHomeMeta': {
        editHomeMeta(0, $option, 0);  // V 1.2.4.t  always return to Meta Mngt screen
        break;
    }
    case 'newHomeMetaFromSEF': {
        editHomeMeta(0, $option, 1);  // V 1.2.4.t return to where we're coming from
        break;
    }
    case 'deleteHomeMeta': {
        deleteHomeMeta($option, 0);  // V 1.2.4.t return to where we're coming from
        break;
    }
    case 'deleteHomeMetaFromSEF': {
        deleteHomeMeta( $option, 1);  // V 1.2.4.t return to where we're coming from
        break;
    }
    case 'purge': {
        purge($option, $ViewModeId);
        break;
    }
    case 'purgeMeta': {
        purgeMeta($option);
        break;
    }
    case 'remove': {
        if ($section == 'meta')
        	removeMeta($cid, $option);
        else 
        	removeSEF($cid, $option);
        break;
    }
    case 'save': {
        switch ($section) {
          case 'config' : saveConfig($eraseCache); break;
          case 'meta' : saveMeta($option, empty($returnTo)?0:$returnTo); break;
          default:
           saveSEF($option);
          break; 
        }
        break;
    }
    case 'saveconfig': {
        saveConfig($eraseCache);
        break;
    }
    case 'showconfig': {
        showConfig ($option);
        break;
    }
    case 'view': {
        viewSEF($option, $ViewModeId);
        break;
    }
    case 'viewDuplicates': {
        viewDuplicates( !empty($cid[0]) ? $cid[0]:$id, $option);
        break;
    }
    case 'viewMeta': {
        viewMeta( $option);
        break;
    }
    case 'makeMainUrl': {
        makeMainUrl( !empty($cid[0]) ? $cid[0]:$id, $option);
        break;
    }
    case 'import_export': {
        HTML_sef::import_export($ViewModeId);
        break;
    }
    case 'import_export_meta': {
        HTML_sef::import_export_meta();
        break;
    }
    case 'import': {
        $userfile = mosGetParam($_FILES, 'userfile', null);
        if (!$userfile) {
            echo '<p class="error">ERROR UPLOADING FILE</p>';
            exit();
        }
        else{
            import_custom_CSV($userfile, $ViewModeId);
            break;
        }
    }
    case 'setStandardAdmin':
      $sefConfig->shAdminInterfaceType = SH404SEF_STANDARD_ADMIN;
      saveConfig($eraseCache);
    break;
    case 'setAdvancedAdmin':
      $sefConfig->shAdminInterfaceType = SH404SEF_ADVANCED_ADMIN;
      saveConfig($eraseCache);
    break;
    case 'importOpenSEF': {
        $userfile = mosGetParam($_FILES, 'userfile', null);
        if (!$userfile) {
            echo '<p class="error">ERROR UPLOADING FILE</p>';
            exit();
        }
        else{
            import_custom_CSV_OPEN_SEF($userfile, $ViewModeId);
            break;
        }
    }
    case 'import_meta': {
        $userfile = mosGetParam($_FILES, 'userfile', null);
        if (!$userfile) {
            echo '<p class="error">ERROR UPLOADING FILE</p>';
            exit();
        }
        else{
            import_custom_CSV_meta($userfile);
            break;
        }
    }
    case 'export': {
        export_custom_CSV('sh404SEF_sef_urls.csv', $ViewModeId);
        break;
    }
    case 'export_meta': {
        export_custom_CSV('sh404SEF_meta.csv', 4);
        break;
    }
    case 'dwnld': {
        $returnData = 1;
        $data =  $sefConfig->saveConfig($returnData);
        $trans_tbl = get_html_translation_table(HTML_ENTITIES);
        $trans_tbl = array_flip($trans_tbl);
        $data =strtr($data, $trans_tbl);
        output_attachment('config.sef.php',$data);
        exit();
    }
    default: {
        include_once('components/com_sef/404SEF_cpanel.php');
        displayCPanel();
        break;
    }
}

// V 1.2.4.q
function displayCPanel() {
  global $database;
  $sql = 'SELECT count(*) FROM #__redirection WHERE ';
  $database->setQuery($sql. "`dateadd` > '0000-00-00' and `newurl` = '' "); // 404
  $Count404 = $database->loadResult();
  $database->setQuery($sql. "`dateadd` > '0000-00-00' and `newurl` != '' " ); // custom
  $customCount = $database->loadResult();
  $database->setQuery($sql. "`dateadd` = '0000-00-00'"); // regular
  $sefCount = $database->loadResult();
  displayCPanelHTML( $sefCount, $Count404, $customCount);
}
/**
* List the records
* @param string The current GET/POST option
* @param int The mode of view 0=
*/

function viewSEF($option, $ViewModeId = 0)
{
    global $database, $mainframe, $mosConfig_list_limit;
    $catid = $mainframe->getUserStateFromRequest( "catid{$option}", 'catid', 0 );
    $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
    $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
    $ViewModeId = $mainframe->getUserStateFromRequest( "viewmode{$option}", 'viewmode', 0 );
    $SortById = $mainframe->getUserStateFromRequest( "SortBy{$option}", 'sortby', 0 );
    // V 1.2.4.q added search URL feature, taken from Joomla content page
    //$search = $mainframe->getUserStateFromRequest( "search{$option}{$sectionid}", 'search', '' );
    $search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	  if (get_magic_quotes_gpc()) {
		  $search = stripslashes( $search );
	  }
	  //echo 'Recherche de : '.$search.'<br />';
    // V 1.2.4.q : initialize variables
    $is404mode = false;
    $where = '';
    if ($ViewModeId == 1) {
        $where = "`dateadd` > '0000-00-00' and `newurl` = '' ";
        // V 1.2.4.q : initialize variables
        $is404mode = true;
    }elseif ( $ViewModeId == 2 ) {
        $where = "`dateadd` > '0000-00-00' and `newurl` != '' ";
    }else{
        $where = "`dateadd` = '0000-00-00'";
    }
    if ( !empty($search) ) {  // V 1.2.4.q added search URL feature
		  $where .= empty( $where) ? '': ' AND ' . "oldurl  LIKE '%" . 
                      $database->getEscaped( trim( strtolower( $search ) ) ) . "%'";
	  }
    //echo 'Ajout Requete : '.$where.'<br />';
    // make the select list for the filter
    $viewmode[] = mosHTML::makeOption( '0', _COM_SEF_SHOW0 );
    $viewmode[] = mosHTML::makeOption( '1', _COM_SEF_SHOW1 );
    $viewmode[] = mosHTML::makeOption( '2', _COM_SEF_SHOW2 );
    $lists['viewmode'] = mosHTML::selectList( $viewmode, 'viewmode', "class=\"inputbox\"  onchange=\"document.adminForm.submit();\" size=\"1\"" ,
    'value', 'text', $ViewModeId );
    // make the select list for the filter
    $orderby[] = mosHTML::makeOption( '0', _COM_SEF_SEFURL._COM_SEF_ASC);
    $orderby[] = mosHTML::makeOption( '1', _COM_SEF_SEFURL._COM_SEF_DESC );
    if ($is404mode != true) {
        $orderby[] = mosHTML::makeOption( '2', _COM_SEF_REALURL._COM_SEF_ASC );
        $orderby[] = mosHTML::makeOption( '3', _COM_SEF_REALURL._COM_SEF_DESC );
    }
    $orderby[] = mosHTML::makeOption( '4', _COM_SEF_HITS._COM_SEF_ASC );
    $orderby[] = mosHTML::makeOption( '5', _COM_SEF_HITS._COM_SEF_DESC );
    $lists['sortby'] = mosHTML::selectList( $orderby, 'sortby', "class=\"inputbox\"  onchange=\"document.adminForm.submit();\" size=\"1\"" ,
    'value', 'text', $SortById );
    switch ($SortById){
        case 1 :
            $sort = "`oldurl` DESC, `rank` ASC";
            break;
        case 2 :
            $sort = "`newurl`, `rank` ASC";
            break;
        case 3 :
            $sort = "`newurl` DESC, `rank` ASC";
            break;
        case 4 :
            $sort = "`cpt`";
            break;
        case 5 :
            $sort = "`cpt` DESC";
            break;
        default :
            $sort = "`oldurl`, `rank` ASC";
            break;
    }
    // get the total number of records
    $query = "SELECT count(*) FROM #__redirection WHERE ".$where;
    $database->setQuery( $query );
    $total = $database->loadResult();
    require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
    $pageNav = new mosPageNav( $total, $limitstart, $limit );
    // get the subset (based on limits) of required records
    $query = "SELECT * FROM #__redirection WHERE ".$where." ORDER BY ".$sort.
    " LIMIT $pageNav->limitstart,$pageNav->limit";
    $database->setQuery( $query );
    $rows = $database->loadObjectList();
    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }
    //echo 'Requete : '.$query.'<br />';
    //var_dump($rows);
    //die();
    // V 1.2.4.q added search feature
    //HTML_sef::viewSEF( $rows, $lists, $pageNav, $option, $ViewModeId);
    HTML_sef::viewSEF( $rows, $lists, $pageNav, $option, $ViewModeId, $search );
}

function viewDuplicates( $id, $option)
{
    global $database, $mainframe, $mosConfig_list_limit;
    $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
    $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
    $SortById = $mainframe->getUserStateFromRequest( "SortBy{$option}", 'sortby', 0 );
    // V 1.2.4.q added search URL feature, taken from Joomla content page
    //$search = $mainframe->getUserStateFromRequest( "search{$option}{$sectionid}", 'search', '' );
    //$search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	  //if (get_magic_quotes_gpc()) {
		//  $search = stripslashes( $search );
	  //}
	  //echo 'Recherche de : '.$search.'<br />';
    // V 1.2.4.q : initialize variables
    $sql = 'SELECT oldurl FROM #__redirection WHERE id = "'.$id.'"';
    $database->setQuery($sql);
    $oldUrl = $database->loadResult();
    if (!empty($oldUrl)) {
    $where = 'oldurl = "'.$oldUrl.'"';
    //if ( !empty($search) ) {  // V 1.2.4.q added search URL feature
		//  $where .= empty( $where) ? '': ' AND ' . "oldurl  LIKE '%" . 
    //                  $database->getEscaped( trim( strtolower( $search ) ) ) . "%'";
	  //}
    //echo 'Ajout Requete : '.$where.'<br />';
    // make the select list for the filter
    $orderby[] = mosHTML::makeOption( '0', _COM_SEF_MANAGE_DUPLICATES_RANK._COM_SEF_ASC );
    $orderby[] = mosHTML::makeOption( '1', _COM_SEF_MANAGE_DUPLICATES_RANK._COM_SEF_DESC );
    $orderby[] = mosHTML::makeOption( '2', _COM_SEF_REALURL._COM_SEF_ASC );
    $orderby[] = mosHTML::makeOption( '3', _COM_SEF_REALURL._COM_SEF_DESC );
    $lists['sortby'] = mosHTML::selectList( $orderby, 'sortby', "class=\"inputbox\"  onchange=\"document.adminForm.submit();\" size=\"1\"" ,
    'value', 'text', $SortById );
    switch ($SortById){
        case 1 :
            $sort = "`rank` DESC";
            break;
        case 2 :
            $sort = "`oldurl` ASC";
            break;
        case 3 :
            $sort = "`oldurl` DESC";
            break; 
        default:
        	$sort = "`rank` ASC";
        break;       
    }
    // get the total number of records
    $query = "SELECT count(*) FROM #__redirection WHERE ".$where;
    $database->setQuery( $query );
    $total = $database->loadResult();
    require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
    $pageNav = new mosPageNav( $total, $limitstart, $limit );
    // get the subset (based on limits) of required records
    $query = "SELECT * FROM #__redirection WHERE ".$where." ORDER BY ".$sort.
    " LIMIT $pageNav->limitstart,$pageNav->limit";
    $database->setQuery( $query );
    $rows = $database->loadObjectList();
    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }
    //echo 'Requete : '.$query.'<br />';
    //var_dump($rows);
    //die();
    // V 1.2.4.q added search feature
    //HTML_sef::viewSEF( $rows, $lists, $pageNav, $option, $ViewModeId);
    HTML_sef::viewDuplicates( $rows, $lists, $pageNav, $option, $id
                                  // ,$search 
                                  );
    }
}

function makeMainUrl( $id, $option) {
  // find out about selected URL
    global $database;
    $sql = 'SELECT oldurl, rank,id FROM #__redirection WHERE id = "'.$id.'"';
    $database->setQuery($sql);
    $database->loadObject($selectedUrl);
    //echo '$id : '.$id.'<br />';
    //var_dump($selectedUrl);
    //die();
    if (!empty($selectedUrl)) {
      if ($selectedUrl->rank == 0) {
        mosRedirect( 'index2.php?option='.$option.'&task=view', _COM_SEF_BAD_DUPLICATES_NOTHING_TO_DO );
      } else {
        // we need to find what it the current main URL, then we'll swap ranks
        $sql = 'SELECT id, rank FROM #__redirection WHERE oldurl = "'.$selectedUrl->oldurl.'" ORDER BY `rank` ASC';
        $database->setQuery($sql);
        $database->loadObject($prevMainUrl);
        //var_dump($prevMainUrl);
        if (!empty($prevMainUrl)) {  // update both URL
          $sql = 'UPDATE #__redirection SET rank ="'.$selectedUrl->rank.'" WHERE `id` = "'.$prevMainUrl->id.'"';
          //echo '<br />$sql : '.$sql.'<br />';
          $database->setQuery($sql);
          $shErr = !$database->query();
          $sql = 'UPDATE #__redirection SET rank="0" WHERE `id` = "'.$id.'"';
          //echo '<br />$sql : '.$sql.'<br />';
          $database->setQuery($sql);
          $shErr = !$database->query() && $shErr;
          //die();
          mosRedirect( 'index2.php?option='.$option.'&task=view', 
            $shErr ? _COM_SEF_MAKE_MAIN_URL_ERROR:_COM_SEF_MAKE_MAIN_URL_OK );
        } else mosRedirect( 'index2.php?option='.$option.'&task=view', _COM_SEF_BAD_DUPLICATES_DATA );
      }
    } else mosRedirect( 'index2.php?option='.$option.'&task=view', _COM_SEF_BAD_DUPLICATES_DATA );
}

/**
* Creates a new or edits and existing user record
* @param int The id of the user, 0 if a new entry
* @param string The current GET/POST option
*/

function editSEF( $id, $option ) {
    global $database, $my, $mainframe;
    $LinkTypeId = $mainframe->getUserStateFromRequest( "linktype{$option}", 'linktype', 0 );
    $SectionId = $mainframe->getUserStateFromRequest( "sectionid{$option}", 'sectionid', 0 );
    $CategoryId = $mainframe->getUserStateFromRequest( "categoryid{$option}", 'categoryid', 0 );
    $ContentId = $mainframe->getUserStateFromRequest( "contentid{$option}", 'contentid', 0 );
    $row = new shMosSEF( $database );
    // load the row from the db table
    $row->load( $id );
    if ($id) {
        // do stuff for existing records
        if ($row->dateadd != "0000-00-00" ) $row->dateadd = date("Y-m-d");
    } else {
        // do stuff for new records
        $row->dateadd = date("Y-m-d");
    }
    HTML_sef::editSEF( $row, $lists, $option );
}

function viewMeta($option)
{
    global $database, $mainframe, $mosConfig_list_limit;
    $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
    $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
    $SortById = $mainframe->getUserStateFromRequest( "SortBy{$option}", 'sortby', 0 );
    // V 1.2.4.q added search URL feature, taken from Joomla content page
    //$search = $mainframe->getUserStateFromRequest( "search{$option}{$sectionid}", 'search', '' );
    $search = $mainframe->getUserStateFromRequest( "searchMeta{$option}", 'searchMeta', '' );
	  if (get_magic_quotes_gpc()) {
		  $search = stripslashes( $search );
	  }
	  // V 1.2.4.t  exclude homepage meta, which are edited using a specific button, as URl may vary
	  $where = 'newurl != \''.sh404SEF_HOMEPAGE_CODE.'\'';
    if ( !empty($search) ) {  // V 1.2.4.q added search URL feature
		  $where .= " AND newurl LIKE '%" . 
                      $database->getEscaped( trim( strtolower( $search ) ) ) . "%'";
	  }
    //echo 'Ajout Requete : '.$where.'<br />';
    // make the select list for the filter
    $orderby[] = mosHTML::makeOption( '0', _COM_SEF_REALURL._COM_SEF_ASC );
    $orderby[] = mosHTML::makeOption( '1', _COM_SEF_REALURL._COM_SEF_DESC );
    $lists['sortby'] = mosHTML::selectList( $orderby, 'sortby', "class=\"inputbox\"  onchange=\"document.adminForm.submit();\" size=\"1\"" ,
    'value', 'text', $SortById );
    switch ($SortById){
        case 1 :
            $sort = "`newurl` DESC";
            break;
        default :
            $sort = "`newurl` ASC";
            break;
    }
    // get the total number of records
    $query = "SELECT count(*) FROM #__sh404SEF_meta WHERE ".$where;
    //echo '$query : '.$query.'<br />';
    $database->setQuery( $query );
    $total = $database->loadResult();
    require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
    $pageNav = new mosPageNav( $total, $limitstart, $limit );
    // get the subset (based on limits) of required records
    $query = "SELECT * FROM #__sh404SEF_meta WHERE ".$where." ORDER BY ".$sort.
    " LIMIT $pageNav->limitstart,$pageNav->limit";
    //echo '$query : '.$query.'<br />';
    $database->setQuery( $query );
    $rows = $database->loadObjectList();
    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }
    //echo 'Requete : '.$query.'<br />';
    //var_dump($rows);
    //die();
    HTML_sef::viewMeta( $rows, $lists, $pageNav, $option, $search );
}

/**
* Creates a new or edits and existing user record
* @param int The id of the user, 0 if a new entry, $returnTO = 0 : back to Metamanagement, 1 = to SEF URl list
* @param string The current GET/POST option
*/

function editMeta( $id, $option, $returnTo = 0, $redirId = 0 ) {
    global $database, $my, $mainframe;
    $row = new sh404SEFMeta( $database );
    // load the row from the db table
    $url = '';
    $row->load( $id );
    //var_dump($row);
    //echo '<br />$redirIr = '.$redirId.'<br />';
    //die();
    if ($redirId) {  // do stuff for existing records
      $sql = 'SELECT oldurl, newurl FROM #__redirection WHERE id=\''.$redirId.'\';';
      $database->setQuery($sql);
      $database->loadObject($url);
      //var_dump($url);
      //die();
      if (!empty($url)) {
        $row->newurl = $url->newurl;
        $sql = 'SELECT * from #__sh404SEF_meta WHERE newurl = \''.$url->newurl.'\';';
        $database->setQuery($sql);
        $database->loadObject($newMeta);
        if (!empty($newMeta)) {
          $row->id = $newMeta->id;
          $row->metatitle = $newMeta->metatitle;
          $row->metadesc = $newMeta->metadesc;
          $row->metakey = $newMeta->metakey;
          $row->metarobots = $newMeta->metarobots;
          $row->metalang = $newMeta->metalang;          
        }
      }
    }
    if ($returnTo == 1)  // V 1.2.4.t 
      $editUrl = 0;
    else $editUrl = 1;  
    HTML_sef::editMeta( $row, $option, $returnTo, $editUrl, empty($url) ? '':$url->oldurl);
}

// V 1.2.4.t edit homepage meta

function editHomeMeta( $id, $option, $returnTo = 0) { // 0 = return to Meta page, 1 = return to SEF URL page
    global $database, $my, $mainframe;
    $row = new sh404SEFMeta( $database );
    // load the row from the db table
    $row->load( $id );
    //echo '<br />$id = '.$idd.'<br />';
    //var_dump($row);
    //echo '<br />$redirIr = '.$redirId.'<br />';
    //die();
    $row->newurl = sh404SEF_HOMEPAGE_CODE;
    $sql = 'SELECT * from #__sh404SEF_meta WHERE newurl = "'.$row->newurl.'"';
    $database->setQuery($sql);
    $database->loadObject($newMeta);
    if (!empty($newMeta)) {
      $row->id = $newMeta->id;
      $row->metatitle = $newMeta->metatitle;
      $row->metadesc = $newMeta->metadesc;
      $row->metakey = $newMeta->metakey;
      $row->metarobots = $newMeta->metarobots;
      $row->metalang = $newMeta->metalang;          
    }
    //echo '<br />';
    //var_dump($row);
    //echo '<br />';
    //die();
    HTML_sef::editMeta( $row, $option, $returnTo, 0, ''); // V 1.2.4.t never edit URL if home meta
}

function deleteHomeMeta( $option, $returnTo = 0) {
    global $database, $my, $mainframe;
    $sql = 'DELETE from #__sh404SEF_meta WHERE newurl = "'.sh404SEF_HOMEPAGE_CODE.'"';
    $database->setQuery($sql);
    $database->query();
    if ($database->getErrorNum()) {
        $mosmsg = $database->stderr();
    } else $mosmsg = _COM_SEF_SUCCESSPURGE;
    $returnTask = empty($returnTo) ? '&task=viewMeta' : '&task=view';
    mosRedirect( 'index2.php?option='.$option.$returnTask.'&mosmsg='.$mosmsg );
}
/**
* Saves the record from an edit form submit
* @param string The current GET/POST option
*/

function saveSEF( $option ) {
    global $database, $my, $sefConfig;
    $mosMosg = ''; // V 1.2.4.t
    $row = new shMosSEF( $database );
    if (!$row->bind( $_POST )) {
        echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
        exit();
    }
    // pre-save checks
    if (!$row->check()) {
        echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
        exit();
    }
    // shumisha 2007-03-16 remove previous redirection from cache
    shLoadURLCache(); // must load cache from disk, so that it can be written back later, with new url
    $urlType = $row->dateadd == '0000-00-00' ? sh404SEF_URLTYPE_AUTO : sh404SEF_URLTYPE_CUSTOM; // V 1.2.4.t
    //echo 'url = '.$row->newurl.'<br />';
    //echo '$urlType = '.$urlType.'<br />';
    //echo 'result = '.preg_match( '/(&|\?)lang=[a-zA-Z]{2,3}/iU', $row->newurl).'<br />';
    if (   ($urlType == sh404SEF_URLTYPE_CUSTOM) 
        && !preg_match( '/(&|\?)lang=[a-zA-Z]{2,3}/iU', $row->newurl)) {  // no lang string, let's add default
        $shTemp = explode( '_', $GLOBALS['mosConfig_locale']);
        $shLangTemp = $shTemp[0] ? $shTemp[0] : 'en';
        $row->newurl .= '&lang='.$shLangTemp;
        //echo 'adding lang = '.$shLangTemp.'<br />';
      
    } //else echo 'Not adding lang<br />';
    $row->newurl = shSortUrl($row->newurl); // V 1.2.4.t
    //echo 'row<br />';
    //var_dump($row);
    //die();
    $query = "SELECT newurl, rank, id FROM #__redirection WHERE oldurl = '".$row->oldurl."' ORDER BY rank ASC";
		$database->setQuery($query);
    $dbUrlList = $database->loadObjectList();
    if (count($dbUrlList) > 0) {   // there are URL with same SEF URL
      if (!$sefConfig->shRecordDuplicates) {  // we don't allow duplicates : reject this URL
        $mosMsg = _COM_SEF_DUPLICATE_NOT_ALLOWED;
      }else {  // same SEF, but we allow duplicates
        foreach ($dbUrlList as $urlInDB) {  // same SEF, but is the non-sef in this list of URl with same SEF ?
          if ($urlInDB->newurl == $row->newurl)
            $mosMsg = _COM_SEF_URLEXIST; 
        }
        //echo '<br />New URL 1= '.$row->newurl.'<br />';
        //echo 'Old URL 1= '.$row->oldurl.'<br />';
        //echo '$mosMosg= '.$mosMosg.'<br />';
        //echo '$dbUrlList = <br />';
        //var_dump($dbUrlList);
        //die();
        if ($mosMosg != _COM_SEF_URLEXIST) {  // we have not the same non-sef in the db, so this is an existing URL
          $shTemp = array('nonSefURL' => $row->newurl);   // fo which we must update the SEF url and the rank
          shRemoveURLFromCache($shTemp);  // remove the old url from cache
          $shNewMaxRank = $dbUrlList[count($dbUrlList)-1]->rank+1;
          $query = "UPDATE #__redirection SET oldurl='".$row->oldurl."', newurl='".$row->newurl."', rank='".$shNewMaxRank."', dateadd='".$row->dateadd."' WHERE id = '".$row->id."'";  // update DB
          $database->setQuery($query);
          $database->query(); 
          shAddSefURLToCache( $row->newurl, $row->oldurl, $urlType); // put custom URL in DB and cache
        }
      }
    } else {   // there is no URL with same SEF URL
      $shTemp = array('nonSefURL' => $row->newurl);
      //echo 'New URL 2= '.$row->newurl.'<br />';
      //echo 'Old URL 2= '.$row->oldurl.'<br />';
      //die();
      shRemoveURLFromCache($shTemp);  // remove it from cache
      shAddSefURLToCache( $row->newurl, $row->oldurl, $URLType);  // add also cache 
      if (!$row->store()) {  // simply store URL. If there is already one with same non-sef, this will raise an error in store()
          echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
          exit();
        }
    }  
  //die();
    mosRedirect( 'index2.php?option='.$option.'&task=view'.(empty($mosMsg)?'':'&mosmsg='.$mosMsg) );
}

/**
* Removes records
* @param array An array of id keys to remove
* @param string The current GET/POST option
*/

function removeSEF( &$cid, $option ) {
    global $database;
    if (!is_array( $cid ) || count( $cid ) < 1) {
        echo "<script> alert('"._COM_SEF_SELECT_DELETE."'); window.history.go(-1);</script>\n";
        exit;
    }
    if (count( $cid )) {
        $cids = implode( ',', $cid );
        // shumisha 2007-03-16 remove also from URL cache
        $query = "SELECT `newurl` FROM #__redirection"
        . "\n WHERE id IN ($cids)";
        $database->setQuery( $query );
        $rows = $database->loadResultArray();
        shLoadURLCache(); // must load cache from disk, so that it can be written back later properly
        shRemoveURLFromCache($rows);  
        // shumisha end of change
        $query = "DELETE FROM #__redirection"
        . "\n WHERE id IN ($cids)"
        ;
        $database->setQuery( $query );
        if (!$database->query()) {
            echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
        }
    }
    mosRedirect( 'index2.php?option='.$option.'&task=view' );
}

/**
* Saves the record from an edit form submit
* @param string The current GET/POST option
* $returnTo : 0 -> return to meta management, 1 return to SEF URL List
*/

function saveMeta( $option, $returnTo = 0 ) {
    global $database, $my;
    $row = new sh404SEFMeta( $database );
    if (!$row->bind( $_POST )) {
        echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
        exit();
    }
    if ( $row->newurl != sh404SEF_HOMEPAGE_CODE &&  // don't add on homepage
         !preg_match( '/(&|\?)lang=[a-zA-Z]{2,3}/iU', $row->newurl)) {  // no lang string, let's add default
        $shTemp = explode( '_', $GLOBALS['mosConfig_locale']);
        $shLangTemp = $shTemp[0] ? $shTemp[0] : 'en';
        $row->newurl .= '&lang='.$shLangTemp;
      
    } 
    
    if ( $row->newurl != sh404SEF_HOMEPAGE_CODE)
      $row->newurl = shSortUrl($row->newurl); // V 1.2.4.t
    // pre-save checks
    if (!$row->check()) {
        echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
        exit();
    }
    //echo '<br />after check; <br />';
    // save the changes
    if (!$row->store()) {
        echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
        exit();
    }
    $returnTask = empty($returnTo) ? '&task=viewMeta' : '&task=view';
    mosRedirect( 'index2.php?option='.$option.$returnTask );
}

/**
* Removes records
* @param array An array of id keys to remove
* @param string The current GET/POST option
*/

function removeMeta( &$cid, $option ) {
    global $database;
    if (!is_array( $cid ) || count( $cid ) < 1) {
        echo "<script> alert('"._COM_SEF_SELECT_DELETE."'); window.history.go(-1);</script>\n";
        exit;
    }
    if (count( $cid )) {
        $cids = implode( ',', $cid );
        $query = "DELETE FROM #__sh404SEF_meta"
          . "\n WHERE id IN ($cids)";
        $database->setQuery( $query );
        if (!$database->query()) {
            echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
        }
    }
    mosRedirect( 'index2.php?option='.$option.'&task=viewMeta' );
}

/**
* Cancels an edit operation
* @param string The current GET/POST option
*/

function cancelsh404( $option, $section, $returnTo ) {  // V 1.2.4.s reworked for meta V 1.2.4.t added returnTo
    if (!empty($returnTo))
      mosRedirect( 'index2.php?option='.$option.'&task=view' );
    switch ($section) {
      case 'config':
        mosRedirect( 'index2.php?option='.$option );
      break;  
      case 'meta' :
        mosRedirect( 'index2.php?option='.$option.'&task=viewMeta' );
      break;
      default:
        mosRedirect( 'index2.php?option='.$option.'&task=view' );
      break;    
    }
}

function showConfig($option)
{
    global $sefConfig, $sef_config_file;
    global $database;
    $std_opt = 'class="inputbox" size="2"';
    $lists['enabled'] =  mosHTML::yesnoRadioList('Enabled', $std_opt, $sefConfig->Enabled );
    $lists['lowercase'] =  mosHTML::yesnoRadioList('LowerCase', $std_opt, $sefConfig->LowerCase );
    $lists['showsection'] =  mosHTML::yesnoRadioList('ShowSection', $std_opt, $sefConfig->ShowSection );
    $lists['showcat'] =  mosHTML::yesnoRadioList('ShowCat', $std_opt, $sefConfig->ShowCat );
    // shumisha 2007-04-01 new params for cache :
    $lists['shUseURLCache'] =  mosHTML::yesnoRadioList('shUseURLCache', $std_opt, $sefConfig->shUseURLCache );
    // shumisha 2007-04-03 new params for translation and Itemid :
    $lists['shTranslateURL'] =  mosHTML::yesnoRadioList('shTranslateURL', $std_opt, $sefConfig->shTranslateURL );
    $lists['shInsertLanguageCode'] =  mosHTML::yesnoRadioList('shInsertLanguageCode', $std_opt, 
                                         $sefConfig->shInsertLanguageCode );
    $lists['shInsertGlobalItemidIfNone'] =  mosHTML::yesnoRadioList('shInsertGlobalItemidIfNone', 
      $std_opt, $sefConfig->shInsertGlobalItemidIfNone );
    $lists['shInsertTitleIfNoItemid'] =  mosHTML::yesnoRadioList('shInsertTitleIfNoItemid', 
      $std_opt, $sefConfig->shInsertTitleIfNoItemid );
    $lists['shAlwaysInsertMenuTitle'] =  mosHTML::yesnoRadioList('shAlwaysInsertMenuTitle', 
      $std_opt, $sefConfig->shAlwaysInsertMenuTitle );
      $lists['shAlwaysInsertItemid'] =  mosHTML::yesnoRadioList('shAlwaysInsertItemid', 
      $std_opt, $sefConfig->shAlwaysInsertItemid );
    // shumisha 2007-04-11 new params for Numerical Id insert :
    $lists['shInsertNumericalId'] =  mosHTML::yesnoRadioList('shInsertNumericalId', 
      $std_opt, $sefConfig->shInsertNumericalId ); 
    // build the html select list for category : copied from rd_rss admin file
    // note : we could do only one request to db and sort in memory !
    $lookup = '';
		if ( $sefConfig->shInsertNumericalIdCatList ) {
		    // V 1.2.4.q shInsertNumericalIdCatList can be empty so let's protect query
		    $shANDCatList = implode(', ', $sefConfig->shInsertNumericalIdCatList);
		    if (!empty($shANDCatList))
		      $shANDCatList = "\n AND c.id IN ( ".$shANDCatList." )";
				$query = "SELECT c.id AS `value`, c.section AS `id`, CONCAT_WS( ' / ', s.title, c.title) AS `text`"
				. "\n FROM #__sections AS s"
				. "\n INNER JOIN #__categories AS c ON c.section = s.id"
				. "\n WHERE s.scope = 'content'"
				// V 1.2.4.q shInsertNumericalIdCatList can be empty so let's protect query
				. $shANDCatList
				. "\n ORDER BY s.name,c.name"
				;
				$database->setQuery( $query );
				$lookup = $database->loadObjectList();
			}
		$category[] = mosHTML::makeOption( '', _COM_SEF_SH_INSERT_NUMERICAL_ID_ALL_CAT );
		$query = "SELECT c.id AS `value`, c.section AS `id`, CONCAT_WS( ' / ', s.title, c.title) AS `text`"
		. "\n FROM #__sections AS s"
		. "\n INNER JOIN #__categories AS c ON c.section = s.id"
		. "\n WHERE s.scope = 'content'"
		. "\n ORDER BY s.name,c.name"
		;
		$database->setQuery( $query );
		$category = array_merge( $category, $database->loadObjectList() );
		$category = mosHTML::selectList( $category, 'shInsertNumericalIdCatList[]', 'class="inputbox" size="10" multiple="multiple"', 'value', 'text', $lookup );
		$lists['shInsertNumericalIdCatList'] = $category;
    // shumisha 2007-04-03 new params for Virtuemart plugin :
    $lists['shVmInsertShopName'] =  mosHTML::yesnoRadioList('shVmInsertShopName', 
      $std_opt, $sefConfig->shVmInsertShopName );
    $lists['shInsertProductId'] =  mosHTML::yesnoRadioList('shInsertProductId', 
      $std_opt, $sefConfig->shInsertProductId );
    $lists['shVmUseProductSKU'] =  mosHTML::yesnoRadioList('shVmUseProductSKU', 
      $std_opt, $sefConfig->shVmUseProductSKU );  
    $lists['shVmInsertManufacturerName'] =  mosHTML::yesnoRadioList('shVmInsertManufacturerName', 
      $std_opt, $sefConfig->shVmInsertManufacturerName );
    $lists['shInsertManufacturerId'] =  mosHTML::yesnoRadioList('shInsertManufacturerId', 
      $std_opt, $sefConfig->shInsertManufacturerId );
    $shVMInsertCat[] = mosHTML::makeOption( '0', _COM_SEF_SH_VM_DO_NOT_SHOW_CATEGORIES );
    $shVMInsertCat[] = mosHTML::makeOption( '1', _COM_SEF_SH_VM_SHOW_LAST_CATEGORY );
    $shVMInsertCat[] = mosHTML::makeOption( '2', _COM_SEF_SH_VM_SHOW_ALL_CATEGORIES );
    $lists['shVMInsertCategories'] = mosHTML::selectList( $shVMInsertCat, 'shVMInsertCategories', "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shVMInsertCategories); 
    $lists['shInsertCategoryId'] =  mosHTML::yesnoRadioList('shInsertCategoryId', 
      $std_opt, $sefConfig->shInsertCategoryId );  
    $lists['shVmInsertFlypage'] =  mosHTML::yesnoRadioList('shVmInsertFlypage',  // V 1.2.4.q
      $std_opt, $sefConfig->shVmInsertFlypage );  
    // shumisha 2007-04-03 end of new params for Virtuemart plugin
    
    // V 1.2.4.q new param for URL encoding
    $lists['shEncodeUrl'] =  mosHTML::yesnoRadioList('shEncodeUrl', 
      $std_opt, $sefConfig->shEncodeUrl );
      
    $lists['guessItemidOnHomepage'] =  mosHTML::yesnoRadioList('guessItemidOnHomepage', 
      $std_opt, $sefConfig->guessItemidOnHomepage );  
      
    $lists['shForceNonSefIfHttps'] =  mosHTML::yesnoRadioList('shForceNonSefIfHttps',  // V 1.2.4.q
      $std_opt, $sefConfig->shForceNonSefIfHttps );   

    $shRewriteMode[] = mosHTML::makeOption( '0', _COM_SEF_SH_RW_MODE_NORMAL );
    $shRewriteMode[] = mosHTML::makeOption( '1', _COM_SEF_SH_RW_MODE_INDEXPHP );
    $shRewriteMode[] = mosHTML::makeOption( '2', _COM_SEF_SH_RW_MODE_INDEXPHP2 );
    $lists['shRewriteMode'] = mosHTML::selectList( $shRewriteMode, 'shRewriteMode', "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shRewriteMode); 
      
    $lists['shRecordDuplicates'] =  mosHTML::yesnoRadioList('shRecordDuplicates',  // V 1.2.4.r
      $std_opt, $sefConfig->shRecordDuplicates );  
    $lists['shRemoveGeneratorTag'] =  mosHTML::yesnoRadioList('shRemoveGeneratorTag',  // V 1.2.4.r
      $std_opt, $sefConfig->shRemoveGeneratorTag );
    $lists['shPutH1Tags'] =  mosHTML::yesnoRadioList('shPutH1Tags',  // V 1.2.4.r
      $std_opt, $sefConfig->shPutH1Tags );
    $lists['shMetaManagementActivated'] =  mosHTML::yesnoRadioList('shMetaManagementActivated',  // V 1.2.4.r
      $std_opt, $sefConfig->shMetaManagementActivated ); 
    $lists['shInsertContentTableName'] =  mosHTML::yesnoRadioList('shInsertContentTableName',  // V 1.2.4.r
      $std_opt, $sefConfig->shInsertContentTableName );  
    $lists['shAutoRedirectWww'] =  mosHTML::yesnoRadioList('shAutoRedirectWww',  // V 1.2.4.r
      $std_opt, $sefConfig->shAutoRedirectWww );  
    $lists['shVmInsertProductName'] =  mosHTML::yesnoRadioList('shVmInsertProductName',  // V 1.2.4.s
      $std_opt, $sefConfig->shVmInsertProductName ); 
      
    //$lists['usealias'] =  mosHTML::yesnoRadioList('UseAlias', $std_opt, $sefConfig->UseAlias );
    if ($sefConfig->UseAlias == 0) {
        $fulltitle = 'checked="checked"';
        $titlealias = '';
    }
    else {
        $titlealias = 'checked="checked"';
        $fulltitle = '';
    }
    $lists['usealias'] =  '
		<input type="radio" name="UseAlias" value="0" class="inputbox"' . $fulltitle . 'size="2" />' . _FULL_TITLE . '
		<input type="radio" name="UseAlias" value="1" class="inputbox"' . $titlealias . 'size="2" />' . _TITLE_ALIAS . '
	';
    // shumisha 2007-04-11 new params for non-sef to sef 301 redirect :
    $lists['shRedirectNonSefToSef'] =  mosHTML::yesnoRadioList('shRedirectNonSefToSef', 
      $std_opt, $sefConfig->shRedirectNonSefToSef ); 
    // shumisha 2007-05-04 new params for joomla sef to sef 301 redirect :
    $lists['shRedirectJoomlaSefToSef'] =  mosHTML::yesnoRadioList('shRedirectJoomlaSefToSef', 
      $std_opt, $sefConfig->shRedirectJoomlaSefToSef ); 
    // shumisha 2007-04-25 new params to activate iJoomla magazine in content :
    $lists['shActivateIJoomlaMagInContent'] =  mosHTML::yesnoRadioList('shActivateIJoomlaMagInContent', 
      $std_opt, $sefConfig->shActivateIJoomlaMagInContent ); 
    $lists['shInsertIJoomlaMagIssueId'] =  mosHTML::yesnoRadioList('shInsertIJoomlaMagIssueId', 
      $std_opt, $sefConfig->shInsertIJoomlaMagIssueId );  
    $lists['shInsertIJoomlaMagName'] =  mosHTML::yesnoRadioList('shInsertIJoomlaMagName', 
      $std_opt, $sefConfig->shInsertIJoomlaMagName ); 
    $lists['shInsertIJoomlaMagMagazineId'] =  mosHTML::yesnoRadioList('shInsertIJoomlaMagMagazineId', 
      $std_opt, $sefConfig->shInsertIJoomlaMagMagazineId );  
    $lists['shInsertIJoomlaMagArticleId'] =  mosHTML::yesnoRadioList('shInsertIJoomlaMagArticleId', 
      $std_opt, $sefConfig->shInsertIJoomlaMagArticleId );  
    // shumisha 2007-04-27 new params for Community Builder :  
    $lists['shInsertCBName'] =  mosHTML::yesnoRadioList('shInsertCBName', 
      $std_opt, $sefConfig->shInsertCBName );
    $lists['shCBInsertUserName'] =  mosHTML::yesnoRadioList('shCBInsertUserName', 
      $std_opt, $sefConfig->shCBInsertUserName );
    $lists['shCBInsertUserId'] =  mosHTML::yesnoRadioList('shCBInsertUserId', 
      $std_opt, $sefConfig->shCBInsertUserId );
    $lists['shCBUseUserPseudo'] =  mosHTML::yesnoRadioList('shCBUseUserPseudo', 
      $std_opt, $sefConfig->shCBUseUserPseudo );  
        
    // V 1.2.4.k 404 errors loggin is now optional  
    $lists['shLog404Errors'] =  mosHTML::yesnoRadioList('shLog404Errors', 
      $std_opt, $sefConfig->shLog404Errors );  
    $lists['shVmAdditionalText'] =  mosHTML::yesnoRadioList('shVmAdditionalText', 
      $std_opt, $sefConfig->shVmAdditionalText );
    $lists['shVmInsertFlypage'] =  mosHTML::yesnoRadioList('shVmInsertFlypage', 
      $std_opt, $sefConfig->shVmInsertFlypage ); 
      
    // V 1.2.4.m added fireboard params
    $lists['shInsertFireboardName'] =  mosHTML::yesnoRadioList('shInsertFireboardName', 
      $std_opt, $sefConfig->shInsertFireboardName );
    
    $lists['shFbInsertCategoryName'] =  mosHTML::yesnoRadioList('shFbInsertCategoryName', 
      $std_opt, $sefConfig->shFbInsertCategoryName );
    $lists['shFbInsertCategoryId'] =  mosHTML::yesnoRadioList('shFbInsertCategoryId', 
      $std_opt, $sefConfig->shFbInsertCategoryId );
    $lists['shFbInsertMessageSubject'] =  mosHTML::yesnoRadioList('shFbInsertMessageSubject', 
      $std_opt, $sefConfig->shFbInsertMessageSubject );    
    $lists['shFbInsertMessageId'] =  mosHTML::yesnoRadioList('shFbInsertMessageId', 
      $std_opt, $sefConfig-> shFbInsertMessageId);
    
    // V 1.2.4.r MyBlog params   
    $lists['shInsertMyBlogName'] =  mosHTML::yesnoRadioList('shInsertMyBlogName', 
      $std_opt, $sefConfig->shInsertMyBlogName );   
    $lists['shMyBlogInsertPostId'] =  mosHTML::yesnoRadioList('shMyBlogInsertPostId', 
      $std_opt, $sefConfig->shMyBlogInsertPostId );
    $lists['shMyBlogInsertTagId'] =  mosHTML::yesnoRadioList('shMyBlogInsertTagId', 
      $std_opt, $sefConfig->shMyBlogInsertTagId );
    $lists['shMyBlogInsertBloggerId'] =  mosHTML::yesnoRadioList('shMyBlogInsertBloggerId', 
      $std_opt, $sefConfig->shMyBlogInsertBloggerId );  

    /* Docman parameters  V 1.2.4.r*/
    $lists['shInsertDocmanName'] =  mosHTML::yesnoRadioList('shInsertDocmanName', 
      $std_opt, $sefConfig->shInsertDocmanName );
    $lists['shDocmanInsertDocId'] =  mosHTML::yesnoRadioList('shDocmanInsertDocId', 
      $std_opt, $sefConfig->shDocmanInsertDocId );
    $lists['shDocmanInsertDocName'] =  mosHTML::yesnoRadioList('shDocmanInsertDocName', 
      $std_opt, $sefConfig->shDocmanInsertDocName ); 
    $lists['shDMInsertCategoryId'] =  mosHTML::yesnoRadioList('shDMInsertCategoryId',  // V 1.2.4.t
      $std_opt, $sefConfig->shDMInsertCategoryId );  
    $shDMInsertCat[] = mosHTML::makeOption( '0', _COM_SEF_SH_VM_DO_NOT_SHOW_CATEGORIES );
    $shDMInsertCat[] = mosHTML::makeOption( '1', _COM_SEF_SH_VM_SHOW_LAST_CATEGORY );
    $shDMInsertCat[] = mosHTML::makeOption( '2', _COM_SEF_SH_VM_SHOW_ALL_CATEGORIES );
    $lists['shDMInsertCategories'] = mosHTML::selectList( $shDMInsertCat, 'shDMInsertCategories', "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shDMInsertCategories);    
    
    
    $lists['shInsertContentBlogName'] =  mosHTML::yesnoRadioList('shInsertContentBlogName',  // V 1.2.4.t
      $std_opt, $sefConfig->shInsertContentBlogName );
      
    $lists['shInsertMTreeName'] =  mosHTML::yesnoRadioList('shInsertMTreeName',  // V 1.2.4.t
      $std_opt, $sefConfig->shInsertMTreeName );   
    $lists['shMTreeInsertListingName'] =  mosHTML::yesnoRadioList('shMTreeInsertListingName',  // V 1.2.4.t
      $std_opt, $sefConfig->shMTreeInsertListingName );   
    $lists['shMTreeInsertListingId'] =  mosHTML::yesnoRadioList('shMTreeInsertListingId',  // V 1.2.4.t
      $std_opt, $sefConfig->shMTreeInsertListingId );
    $lists['shMTreePrependListingId'] =  mosHTML::yesnoRadioList('shMTreePrependListingId',  // V 1.2.4.t
      $std_opt, $sefConfig->shMTreePrependListingId );
    $shMTreeInsertCat[] = mosHTML::makeOption( '0', _COM_SEF_SH_VM_DO_NOT_SHOW_CATEGORIES );
    $shMTreeInsertCat[] = mosHTML::makeOption( '1', _COM_SEF_SH_VM_SHOW_LAST_CATEGORY );
    $shMTreeInsertCat[] = mosHTML::makeOption( '2', _COM_SEF_SH_VM_SHOW_ALL_CATEGORIES );
    $lists['shMTreeInsertCategories'] = mosHTML::selectList( $shMTreeInsertCat, 'shMTreeInsertCategories', "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shMTreeInsertCategories);      
    $lists['shMTreeInsertCategoryId'] =  mosHTML::yesnoRadioList('shMTreeInsertCategoryId',  // V 1.2.4.t
      $std_opt, $sefConfig->shMTreeInsertCategoryId );
    $lists['shMTreeInsertUserName'] =  mosHTML::yesnoRadioList('shMTreeInsertUserName',  // V 1.2.4.t
      $std_opt, $sefConfig->shMTreeInsertUserName );            
    $lists['shMTreeInsertUserId'] =  mosHTML::yesnoRadioList('shMTreeInsertUserId',  // V 1.2.4.t
      $std_opt, $sefConfig->shMTreeInsertUserId );

    $lists['shInsertNewsPName'] =  mosHTML::yesnoRadioList('shInsertNewsPName',  // V 1.2.4.t
      $std_opt, $sefConfig->shInsertNewsPName ); 
    $lists['shNewsPInsertCatId'] =  mosHTML::yesnoRadioList('shNewsPInsertCatId',  // V 1.2.4.t
      $std_opt, $sefConfig->shNewsPInsertCatId ); 
    $lists['shNewsPInsertSecId'] =  mosHTML::yesnoRadioList('shNewsPInsertSecId',  // V 1.2.4.t
      $std_opt, $sefConfig->shNewsPInsertSecId );     

    /* Remository parameters  V 1.2.4.t  */
    $lists['shInsertRemoName'] =  mosHTML::yesnoRadioList('shInsertRemoName', 
      $std_opt, $sefConfig->shInsertRemoName );
    $lists['shRemoInsertDocId'] =  mosHTML::yesnoRadioList('shRemoInsertDocId', 
      $std_opt, $sefConfig->shRemoInsertDocId );
    $lists['shRemoInsertDocName'] =  mosHTML::yesnoRadioList('shRemoInsertDocName', 
      $std_opt, $sefConfig->shRemoInsertDocName ); 
    $lists['shRemoInsertCategoryId'] =  mosHTML::yesnoRadioList('shRemoInsertCategoryId',  // V 1.2.4.t
      $std_opt, $sefConfig->shRemoInsertCategoryId );  
    $shRemoInsertCat[] = mosHTML::makeOption( '0', _COM_SEF_SH_VM_DO_NOT_SHOW_CATEGORIES );
    $shRemoInsertCat[] = mosHTML::makeOption( '1', _COM_SEF_SH_VM_SHOW_LAST_CATEGORY );
    $shRemoInsertCat[] = mosHTML::makeOption( '2', _COM_SEF_SH_VM_SHOW_ALL_CATEGORIES );
    $lists['shRemoInsertCategories'] = mosHTML::selectList( $shRemoInsertCat, 'shRemoInsertCategories', "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shRemoInsertCategories); 

    // V 1.2.4.t 16/08/2007 15:43:31 
    $lists['shCBShortUserURL'] =  mosHTML::yesnoRadioList('shCBShortUserURL', 
      $std_opt, $sefConfig->shCBShortUserURL ); 

    // V 1.2.4.t 19/08/2007 16:26:46
    $lists['shKeepStandardURLOnUpgrade'] =  mosHTML::yesnoRadioList('shKeepStandardURLOnUpgrade', 
      $std_opt, $sefConfig->shKeepStandardURLOnUpgrade );
    $lists['shKeepCustomURLOnUpgrade'] =  mosHTML::yesnoRadioList('shKeepCustomURLOnUpgrade', 
      $std_opt, $sefConfig->shKeepCustomURLOnUpgrade );
    $lists['shKeepMetaDataOnUpgrade'] =  mosHTML::yesnoRadioList('shKeepMetaDataOnUpgrade', 
      $std_opt, $sefConfig->shKeepMetaDataOnUpgrade );
    $lists['shKeepModulesSettingsOnUpgrade'] =  mosHTML::yesnoRadioList('shKeepModulesSettingsOnUpgrade', 
      $std_opt, $sefConfig->shKeepModulesSettingsOnUpgrade );
      
    // V 1.2.4.t 24/08/2007 12:56:16  
    $lists['shMultipagesTitle'] =  mosHTML::yesnoRadioList('shMultipagesTitle', 
      $std_opt, $sefConfig->shMultipagesTitle );
      
      
    // V x
    $lists['shKeepConfigOnUpgrade'] =  mosHTML::yesnoRadioList('shKeepConfigOnUpgrade', 
      $std_opt, $sefConfig->shKeepConfigOnUpgrade );
	
	// security parameters  V x
	$lists['shSecEnableSecurity'] =  mosHTML::yesnoRadioList('shSecEnableSecurity', 
      $std_opt, $sefConfig->shSecEnableSecurity );
    $lists['shSecLogAttacks'] =  mosHTML::yesnoRadioList('shSecLogAttacks', 
      $std_opt, $sefConfig->shSecLogAttacks );
    $lists['shSecOnlyNumVars'] = implode("\n",$sefConfig->shSecOnlyNumVars);
    $lists['shSecAlphaNumVars'] = implode("\n",$sefConfig->shSecAlphaNumVars); 
    $lists['shSecNoProtocolVars'] = implode("\n",$sefConfig->shSecNoProtocolVars); 
    $lists['ipWhiteList'] = implode("\n",$sefConfig->ipWhiteList);
	$lists['ipBlackList'] = implode("\n",$sefConfig->ipBlackList);
	$lists['uAgentWhiteList'] = implode("\n",$sefConfig->uAgentWhiteList);
	$lists['uAgentBlackList'] = implode("\n",$sefConfig->uAgentBlackList);
    
    $lists['shSecCheckHoneyPot'] =  mosHTML::yesnoRadioList('shSecCheckHoneyPot', 
      $std_opt, $sefConfig->shSecCheckHoneyPot ); 
    $lists['shSecActivateAntiFlood'] =  mosHTML::yesnoRadioList('shSecActivateAntiFlood', 
      $std_opt, $sefConfig->shSecActivateAntiFlood );  
    $lists['shSecAntiFloodOnlyOnPOST'] =  mosHTML::yesnoRadioList('shSecAntiFloodOnlyOnPOST', 
      $std_opt, $sefConfig->shSecAntiFloodOnlyOnPOST );  

    //$lists['insertSectionInBlogTableLinks'] =  mosHTML::yesnoRadioList('insertSectionInBlogTableLinks', 
    //  $std_opt, $sefConfig->insertSectionInBlogTableLinks );    

    // V x : per language insert iso code and translate URl params and page text

   	$activeLanguages = shGetActiveLanguages();
   	$lists['activeLanguages'][] = $GLOBALS['mosConfig_lang'];  // put default in first place
   	
   	$shLangOption[] = mosHTML::makeOption( '0', _COM_SEF_SH_DEFAULT );
    $shLangOption[] = mosHTML::makeOption( '1', _COM_SEF_SH_YES );
    $shLangOption[] = mosHTML::makeOption( '2', _COM_SEF_SH_NO );
   	
	foreach ($activeLanguages as $language) {
		$currentLang = $language->code;
		if ($currentLang != $GLOBALS['mosConfig_lang']) $lists['activeLanguages'][] = $currentLang;
  		$lists['languages_'.$currentLang.'_translateURL'] =  
  			mosHTML::selectList( $shLangOption, 'languages_'.$currentLang.'_translateURL', 
  								 "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shLangTranslateList[$currentLang]);
     	$lists['languages_'.$currentLang.'_insertCode'] =  
  			mosHTML::selectList( $shLangOption, 'languages_'.$currentLang.'_insertCode', 
  								 "class=\"inputbox\" size=\"1\"" , 'value', 'text',  $sefConfig->shLangInsertCodeList[$currentLang]);	 
  	}
    
    // V 1.3 RC shCustomTags params
	$lists['shInsertNoFollowPDFPrint'] =  mosHTML::yesnoRadioList('shInsertNoFollowPDFPrint', 
      $std_opt, $sefConfig->shInsertNoFollowPDFPrint );
	$lists['shInsertReadMorePageTitle'] =  mosHTML::yesnoRadioList('shInsertReadMorePageTitle', 
      $std_opt, $sefConfig->shInsertReadMorePageTitle );
	$lists['shMultipleH1ToH2'] =  mosHTML::yesnoRadioList('shMultipleH1ToH2', 
      $std_opt, $sefConfig->shMultipleH1ToH2 ); 
         
    // get a list of the static content items for 404 page
    $query = "SELECT id, title"
    . "\n FROM #__content"
    . "\n WHERE sectionid = 0 AND title != '404'"
    . "\n AND catid = 0"
    . "\n ORDER BY ordering"
    ;
    $database->setQuery( $query );
    $items = $database->loadObjectList();
    $options = array(  mosHTML::makeOption( 0, "("._COM_SEF_DEF_404_PAGE.")")  );
    //$options[] = mosHTML::makeOption( 9999999, "(Front Page)" ); // 1.2.4.t
    // assemble menu items to the array
    foreach ( $items as $item ) {
        $options[] = mosHTML::makeOption( $item->id, $item->title );
    }
    $lists['page404'] = mosHTML::selectList( $options, 'page404', 'class="inputbox" size="1"', 'value', 'text', $sefConfig->page404 );
    $sql='SELECT id,introtext FROM #__content WHERE `title`="404"';
    $row = null;
    $database->setQuery($sql);
    $database->loadObject( $row );
    if (!empty($row) && !empty($row->introtext))  // V 1.2.4.t
    $txt404 = $row->introtext;
    else
    $txt404 = _COM_SEF_DEF_404_MSG;
    // get list of installed components for advanced config
    $installed_components = $undefined_components = array();
    $sql='SELECT SUBSTRING(link,8) AS name FROM #__components WHERE CHAR_LENGTH(link) > 0 ORDER BY name';
    $database->setQuery($sql);
    $installed_components = $database->loadResultArray();
    $installed_components = str_replace('com_', '', $installed_components); // V 1.2.4.m
    $undefined_components= array_values(array_diff($installed_components,array_intersect($sefConfig->predefined, $installed_components))); 
    //build mode list and create the list
    $mode = array();
    $mode[] = mosHTML::makeOption( 0, _COM_SEF_USE_DEFAULT);
    $mode[] = mosHTML::makeOption( 1, _COM_SEF_NOCACHE);
    $mode[] = mosHTML::makeOption( 2, _COM_SEF_SKIP);
    $modeTranslate[] = mosHTML::makeOption( 0, _COM_SEF_SH_TRANSLATE_URL); // V 1.2.4.m
    $modeTranslate[] = mosHTML::makeOption( 1, _COM_SEF_SH_DO_NOT_TRANSLATE_URL);
    $modeInsertIso[] = mosHTML::makeOption( 0, _COM_SEF_SH_INSERT_LANGUAGE_CODE);
    $modeInsertIso[] = mosHTML::makeOption( 1, _COM_SEF_SH_DO_NOT_INSERT_LANGUAGE_CODE);
    $modeshDoNotOverrideOwnSef[] = mosHTML::makeOption( 0, _COM_SEF_SH_OVERRIDE_SEF_EXT);
    $modeshDoNotOverrideOwnSef[] = mosHTML::makeOption( 1, _COM_SEF_SH_DO_NOT_OVERRIDE_SEF_EXT);
    while (list($index, $name) = each($undefined_components)){
        $selectedmode = ((in_array($name,$sefConfig->nocache))*1)+((in_array($name,$sefConfig->skip))*2);
        $lists['adv_config'][$name]['manageURL'] = mosHTML::selectList( $mode, 'com_'.$name.'___manageURL', 'class="inputbox" size="1"', 'value', 'text',$selectedmode);
        $selectedmode = in_array($name,$sefConfig->notTranslateURLList);
        $lists['adv_config'][$name]['translateURL'] = mosHTML::selectList( $modeTranslate, 'com_'.$name.'___translateURL', 'class="inputbox" size="1"', 'value', 'text',$selectedmode);
        
        $selectedmode = in_array($name,$sefConfig->notInsertIsoCodeList);
        $lists['adv_config'][$name]['insertIsoCode'] = mosHTML::selectList( $modeInsertIso, 'com_'.$name.'___insertIsoCode', 'class="inputbox" size="1"', 'value', 'text',$selectedmode);
        
        $selectedmode = in_array($name,$sefConfig->shDoNotOverrideOwnSef);
        $lists['adv_config'][$name]['shDoNotOverrideOwnSef'] = mosHTML::selectList( $modeshDoNotOverrideOwnSef, 'com_'.$name.'___shDoNotOverrideOwnSef', 'class="inputbox" size="1"', 'value', 'text',$selectedmode);
        $defaultString = empty($sefConfig->defaultComponentStringList[@$name]) ? '':$sefConfig->defaultComponentStringList[$name];
        $compName = 'com_'.$name.'___defaultComponentString'; 
        $lists['adv_config'][$name]['defaultComponentString'] = 
        	'<td width="150"><input type="text" name="'.$compName.'" value="'.$defaultString.'" size="30" maxlength="30"></td>';
    }
    //	echo "<pre>";
    //	print_r($undefined_components);
    //	print_r($lists);
    //	echo "</pre>";
    HTML_sef::configuration($lists, $txt404);
}

function advancedConfig($key,$value){

    GLOBAL $sefConfig;
    if ((strpos($key,"com_")) !== false) {
        // V 1.2.4.m
        $key = str_replace('com_','',$key);
        $param = explode('___',$key);
        switch ($param[1]) {
          case 'manageURL' :
            switch ($value) {
              case 1 :
                  array_push($sefConfig->nocache,$param[0]);
                  break;
              case 2 :
                  array_push($sefConfig->skip,$param[0]);
                  break;
            }
          break;
          case 'translateURL':
            if ($value == 1)
              array_push($sefConfig->notTranslateURLList,$param[0]);
          break;
          case 'insertIsoCode':
            if ($value == 1)
              array_push($sefConfig->notInsertIsoCodeList,$param[0]);
          break;  
          case 'shDoNotOverrideOwnSef':
            if ($value == 1)
              array_push($sefConfig->shDoNotOverrideOwnSef,$param[0]);
          break;
          case 'defaultComponentString':
            $cleanedUpValue = empty($value) ? '': titleToLocation($value);
            $cleanedUpValue = trim( $cleanedUpValue, $sefConfig->friendlytrim); 
            $sefConfig->defaultComponentStringList[$param[0]] = $cleanedUpValue;
          break; 
        }  
    } else {
    
    switch ($key){
    	case 'shSecOnlyNumVars':
	    	if (!empty($value))
	    		$sefConfig->shSecOnlyNumVars = explode("\n", $value);
    		foreach ($sefConfig->shSecOnlyNumVars as $k=>$v) {
    			$sefConfig->shSecOnlyNumVars[$k] = trim($v);
    		}
    		$sefConfig->shSecOnlyNumVars = array_filter($sefConfig->shSecOnlyNumVars);
    	break;
    	case 'shSecAlphaNumVars':
    		if (!empty($value))
    			$sefConfig->shSecAlphaNumVars = explode("\n", $value);
    		foreach ($sefConfig->shSecAlphaNumVars as $k=>$v) {
    			$sefConfig->shSecAlphaNumVars[$k] = trim($v);
    		}
    		$sefConfig->shSecAlphaNumVars = array_filter($sefConfig->shSecAlphaNumVars);
   		break;
    	case 'shSecNoProtocolVars':
    		if (!empty($value))
    			$sefConfig->shSecNoProtocolVars = explode("\n", $value);
    		foreach ($sefConfig->shSecNoProtocolVars as $k=>$v) {
    			$sefConfig->shSecNoProtocolVars[$k] = trim($v);
    		}
   			$sefConfig->shSecNoProtocolVars = array_filter($sefConfig->shSecNoProtocolVars);
    	break;
    }

    if (preg_match('/languages_([a-zA-Z]*)_translateURL/U', $key, $matches)) {
    	$sefConfig->shLangTranslateList[$matches[1]] = $value;
    }
    if (preg_match('/languages_([a-zA-Z]*)_insertCode/U', $key, $matches)) {
    	$sefConfig->shLangInsertCodeList[$matches[1]] = $value;
    }
    if (preg_match('/languages_([a-zA-Z]*)_pageText/U', $key, $matches)) {
    	$sefConfig->pageTexts[$matches[1]] = $value;
    }    
    } 
}

function saveConfig($eraseCache) {

    global $database,$sefConfig,$sef_config_file;
    //set skip and nocache arrays
    $sefConfig->skip = array();
    $sefConfig->nocache = array();
    $sefConfig->notTranslateURLList = array();
    $sefConfig->notInsertIsoCodeList = array();
    $sefConfig->shDoNotOverrideOwnSef = array();
    $sefConfig->shSecOnlyNumVars = array();
    $sefConfig->shSecAlphaNumVars = array();
    $sefConfig->shSecNoProtocolVars = array();
    $sefConfig->ipWhiteList = array();
    $sefConfig->ipBlackList = array();
    $sefConfig->uAgentWhiteList = array();
    $sefConfig->uAgentBlackList = array();
	$sefConfig->shLangTranslateList = array();
	$sefConfig->shLangInsertCodeList = array();
	$sefConfig->defaultComponentStringList = array();
	
    foreach($_POST as $key => $value) {
        $sefConfig->set($key, $value);
        advancedConfig($key, $value);
    }
    $sql='SELECT id  FROM #__content WHERE `title`="404"';
    $database->setQuery( $sql );
    if ($id = $database->loadResult()){
        $sql = 'UPDATE #__content SET introtext="'.$_POST['introtext'].'",  modified ="'.date("Y-m-d H:i:s").'" WHERE `id` = "'.$id.'";';
    }else{
        $sql='SELECT MAX(id)  FROM #__content';
        $database->setQuery( $sql );
        if ($max = $database->loadResult()){
            $max++;
            $sql = 'INSERT INTO #__content VALUES( "'.$max.'", "404", "404", "'.$_POST['introtext'].'", "", "1", "0", "0", "0", "2004-11-11 12:44:38", "62", "", "'.date("Y-m-d H:i:s").'", "0", "62", "2004-11-11 12:45:09", "2004-10-17 00:00:00", "0000-00-00 00:00:00", "", "", "menu_image=-1\nitem_title=0\npageclass_sfx=\nback_button=\nrating=0\nauthor=0\ncreatedate=0\nmodifydate=0\npdf=0\nprint=0\nemail=0", "1", "0", "0", "", "", "0", "750");';
        }
    }
    $database->setQuery( $sql );
    if (!$database->query()) {
        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
    }
    $config_written = $sefConfig->saveConfig(0);
    if($config_written != 0) {
        // V 1.2.4.t 20/08/2007 16:14:37 added another confirm from user
        if ($eraseCache)
           mosRedirect( $GLOBALS['mosConfig_live_site']
                       .'/administrator/index2.php?option=com_sef&task=purge&viewmode=0&confirmed=0');
        else mosRedirect( "index2.php?option=com_sef", _COM_SEF_CONFIG_UPDATED );
    }else mosRedirect( "index2.php?option=com_sef", _COM_SEF_WRITE_ERROR);
}

function purge($option, $ViewModeId=0  ) {

    GLOBAL $database, $mainframe,
           // shumisha 2007-03-14 URL caching : we must clear URL cache as well
           $mosConfig_absolute_path;
    $ViewModeId = $mainframe->getUserStateFromRequest( "viewmode{$option}", 'viewmode', 0 );
    $SortById = $mainframe->getUserStateFromRequest( "SortBy{$option}", 'sortby', 0 );
    $confirmed = mosGetParam( $_REQUEST, 'confirmed', '' ); // mambo checks default value type, must be '' instead of 0
    switch ($ViewModeId) {
        case '1': // 404
            $where = "`dateadd` > '0000-00-00' and `newurl` = '' ";
            break;
        case '2':  // custom
            $where = "`dateadd` > '0000-00-00' and `newurl` != '' ";
            break;
        default:  // automatic
            $where = "`dateadd` = '0000-00-00'";
            break;
    }
    if ( !empty($confirmed)){
        $query = "DELETE FROM #__redirection WHERE ".$where;
        // shumisha 2007-03-14 URL caching : we must clear URL cache as well
        if (file_exists($mosConfig_absolute_path.'/components/com_sef/cache/shCacheContent.php'))
          unlink($mosConfig_absolute_path.'/components/com_sef/cache/shCacheContent.php');
        // shumisha end of addition
        $database->setQuery( $query );
        if (!$database->query()) {
            echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
        }else{
            $message = _COM_SEF_SUCCESSPURGE;
        }
        mosRedirect('index2.php?option=com_sef', $message);
    }else{
        // get the total number of records
        $query = "SELECT count(*) FROM #__redirection WHERE ".$where;
        $database->setQuery( $query );
        $total = $database->loadResult();
        if (!$database->query()) {
            echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
        }
        switch ($total) {
            case '0';
              $message = _COM_SEF_NORECORDS;
              mosRedirect('index2.php?option=com_sef', $message);
            break;
            case '1';
              $message = _COM_SEF_WARNDELETE.$total._COM_SEF_RECORD;
            break;
            default:
                $message = _COM_SEF_WARNDELETE.$total._COM_SEF_RECORDS;
        }
        HTML_sef::purge($option, $message, $confirmed); 
    }
}

function purgeMeta($option ) {  // V 1.2.4.s

    GLOBAL $database, $mainframe;
    $confirmed = mosGetParam( $_REQUEST, 'confirmed', 0 );
    if ( !empty($confirmed)){
        $query = "DELETE FROM #__sh404SEF_meta WHERE 1";
        $database->setQuery( $query );
        if (!$database->query()) {
            echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
        }else{
            $message = _COM_SEF_META_SUCCESS_PURGE;
        }
        mosRedirect('index2.php?option=com_sef', $message);
    }else{
        // get the total number of records
        $query = "SELECT count(*) FROM #__sh404SEF_meta WHERE 1";
        $database->setQuery( $query );
        $total = $database->loadResult();
        if (!$database->query()) {
            echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
        }
        switch ($total) {
            case '0';
              $message = _COM_SEF_NORECORDS;
              mosRedirect('index2.php?option=com_sef', $message);
            break;
            case '1';
              $message = _COM_SEF_WARNDELETE.$total._COM_SEF_RECORD;
            break;
            default:
                $message = _COM_SEF_WARNDELETE.$total._COM_SEF_RECORDS;
        }
        HTML_sef::purgeMeta($option, $message, $confirmed); 
    }
}
function backup_custom(){

    GLOBAL $database;
    $SQL = array();
    $table = $GLOBALS['mosConfig_dbprefix']."redirection";
    $query ="SELECT * FROM `$table` WHERE `dateadd` > '0000-00-00' and `newurl` != '' ";
    $database->setQuery( $query );
    if ($rows = $database->loadRowList()) {
        foreach ($rows as $row) {
            $SQL[] = "INSERT INTO `$table` VALUES('','".$row[1]."','".$row[2]."','".$row[3]."','".$row[4]."');\n";
        }
    }else{
        die(_COM_SEF_NOACCESS.$table);
    }
    return $SQL;
}

function shNonEmpty($string) {  // V 1.2.4.s
  if (empty($string))
    return '&nbsp';
  else return $string;
}
function shUnEmpty($string) {  // V 1.2.4.s
  if ($string == '&nbsp')
    return '';
  else return $string;
}

function backup_custom_CSV( $which = 0){ // which = 0:all, 2 = custom redirect, 1 = 404)

    GLOBAL $database;
    $CSV = array();
    switch ($which) {
      case 1: // 404
        $where = "WHERE `dateadd` > '0000-00-00' and `newurl` == '' ";
      break;  // Custom
      case 2:
        $where = "WHERE `dateadd` > '0000-00-00' and `newurl` != '' ";
      break;
      default:  // default
        $where = '';
      break;
    }
    $CSV[] = "\"id\",\"Count\",\"Rank\",\"SEF URL\",\"non-SEF URL\",\"Date added\"\n"; // V 1.2.4.s
    $query ='SELECT * FROM #__redirection '.$where;
    $database->setQuery( $query );
    $rows = $database->loadRowList();
    if (!empty($rows)) {
        foreach ($rows as $row) {
          $CSV[] = "\"$row[0]\",\"$row[1]\",\"$row[2]\",\"$row[3]\",\"$row[4]\",\"$row[5]\"\n";  // V 1.2.4.s
        }
    }else{
        mosRedirect('index2.php?option=com_sef',_COM_SEF_NOACCESS);
    }
    return $CSV;
}

function output_attachment($filename,&$data){

    if (!headers_sent()) {
        header ('Expires: 0');
        header ('Last-Modified: '.gmdate ('D, d M Y H:i:s', time()) . ' GMT');
        header ('Pragma: public');
        header ('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header ('Accept-Ranges: bytes');
        header ('Content-Length: ' . strlen($data));
        header ('Content-Type: Application/octet-stream');
        header ('Content-Disposition: attachment; filename="' . $filename . '"');
        header ('Connection: close');
        ob_end_clean(); //flush the mambo stuff from the ouput buffer
        print $data; // and send the sql
        die();
    }else{
        mosRedirect('index2.php?option=com_sef',_COM_SEF_FATAL_ERROR_HEADERS);
    }
}

function export_custom($filename){

    GLOBAL $database;
    $sql_data = backup_custom();
    $sql_data = implode("\r", $sql_data);
    if (!headers_sent()) {
        while (ob_get_level() > 0) {
            ob_end_clean(); //flush the mambo stuff from the ouput buffer
        }
        // Determine Browser
        if (ereg( 'MSIE ([0-9].[0-9]{1,2})',$_SERVER["HTTP_USER_AGENT"],$log_version)) {
            $BROWSER_VER=$log_version[1];
            $BROWSER_AGENT='IE';
        } elseif (ereg( 'Opera ([0-9].[0-9]{1,2})',$_SERVER["HTTP_USER_AGENT"],$log_version)) {
            $BROWSER_VER=$log_version[1];
            $BROWSER_AGENT='OPERA';
        } elseif (ereg( 'Mozilla/([0-9].[0-9]{1,2})',$_SERVER["HTTP_USER_AGENT"],$log_version)) {
            $BROWSER_VER=$log_version[1];
            $BROWSER_AGENT='MOZILLA';
        } else {
            $BROWSER_VER=0;
            $BROWSER_AGENT='OTHER';
        }
        ob_start();
        header ('Expires: 0');
        header ('Last-Modified: '.gmdate ('D, d M Y H:i:s', time()) . ' GMT');
        header ('Pragma: public');
        header ('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header ('Accept-Ranges: bytes');
        header ('Content-Length: ' . strlen($sql_data));
        header ('Content-Type: Application/octet-stream');
        header ('Content-Disposition: attachment; filename="' . $filename . '"');
        header ('Connection: close');
        /*
        if ($BROWSER_AGENT == 'IE') {
        header('Content-Disposition: inline; filename="'.$filename.'";');
        header('Pragma: cache');
        header('Cache-Control: public, must-revalidate, max-age=0');
        header('Connection: close');
        header("Expires: ".gmdate("D, d M Y H:i:s", time()+60)." GMT");
        header("Last-Modified: ".gmdate("D, d M Y H:i:s", time())." GMT");
        }else{
        $header="Content-Disposition: attachment; filename=".$filename.";";
        header($header );
        header("Content-Length: ".strlen($sql_data));
        }
        */
        echo($sql_data);
        ob_end_flush();
        die();
    }else{
        echo "Error! Not Good!";
        mosRedirect('index2.php?option=com_sef', COM_SEF_FATAL_ERROR_HEADERS);
    }
}

function import_custom($userfile){

    GLOBAL $database;
    $uploaddir = $GLOBALS['mosConfig_absolute_path'].'/media/';
    $uploadfile = $uploaddir . basename($userfile['name']);
    if (move_uploaded_file($userfile['tmp_name'], $uploadfile)) {
        echo '<p class="message">'._COM_SEF_UPLOAD_OK.'</p>';
        $results = true;
        $lines = file($uploadfile);
        //		echo "<pre>";
        //		print_r($lines);
        //		echo "</pre>";
        foreach ($lines as $line){
            $line = trim($line);
            if( substr($line,0,40) == "INSERT INTO `".$GLOBALS['mosConfig_dbprefix']."redirection` VALUES('',"){
                $database->setQuery( $line );
                if (! $database->query()){
                    echo "<p class='error'>"._COM_SEF_ERROR_IMPORT."<pre>$line</pre></p>";
                    $results = false;
                }
            }else{
                mosRedirect('index2.php?option=com_sef',_COM_SEF_INVALID_SQL.substr($line,0,40));
            }
        }
        unlink($uploadfile) OR mosRedirect('index2.php?option=com_sef',_COM_SEF_NO_UNLINK);
        if ($results) echo '<p class="message">'._COM_SEF_IMPORT_OK.'</p>';
		?>
		<form><input type="button" value="<?php echo _COM_SEF_PROCEED; ?>" onClick="javascript:location.href='index2.php?option=com_sef&task=view&viewmode=2'"></form>
		<?php
    }else{
        echo "<p class='error'>"._COM_SEF_WRITE_FAILED."</p>";
        $results = false;
    }
    return $result;
}

function export_custom_CSV($filename, $which = 0){ // which = 0:all, 1 = custom redirect, 2 = 404
                                                   // which = 4  V 1.2.4. 

    GLOBAL $database;
    $csv_data = ($which == 4 )? backup_custom_CSV_meta() : backup_custom_CSV( $which);  // 1.2.4.t bug #166
    $csv_data = implode("\r", $csv_data);
    if (!headers_sent()) {
        while (ob_get_level() > 0) {
            ob_end_clean(); //flush the mambo stuff from the ouput buffer
        }
        // Determine Browser
        if (ereg( 'MSIE ([0-9].[0-9]{1,2})',$_SERVER["HTTP_USER_AGENT"],$log_version)) {
            $BROWSER_VER=$log_version[1];
            $BROWSER_AGENT='IE';
        } elseif (ereg( 'Opera ([0-9].[0-9]{1,2})',$_SERVER["HTTP_USER_AGENT"],$log_version)) {
            $BROWSER_VER=$log_version[1];
            $BROWSER_AGENT='OPERA';
        } elseif (ereg( 'Mozilla/([0-9].[0-9]{1,2})',$_SERVER["HTTP_USER_AGENT"],$log_version)) {
            $BROWSER_VER=$log_version[1];
            $BROWSER_AGENT='MOZILLA';
        } else {
            $BROWSER_VER=0;
            $BROWSER_AGENT='OTHER';
        }
        ob_start();
        header ('Expires: 0');
        header ('Last-Modified: '.gmdate ('D, d M Y H:i:s', time()) . ' GMT');
        header ('Pragma: public');
        header ('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header ('Accept-Ranges: bytes');
        header ('Content-Length: ' . strlen($csv_data));
        header ('Content-Type: Application/octet-stream');
        header ('Content-Disposition: attachment; filename="' . $filename . '"');
        header ('Connection: close');
        echo($csv_data);
        ob_end_flush();
        die();
    }else{
        echo "Error! Not Good!";
        mosRedirect('index2.php?option=com_sef',_COM_SEF_FATAL_ERROR_HEADERS);
    }
}

function import_custom_CSV($userfile, $ViewModeId=0) {

    GLOBAL $database;
    $uploaddir = $GLOBALS['mosConfig_absolute_path'].'/media/';
    $uploadfile = $uploaddir . basename($userfile['name']);
    if (move_uploaded_file($userfile['tmp_name'], $uploadfile)) {
        echo '<p class="message">'._COM_SEF_UPLOAD_OK.'</p>';
        $results = true;
        $lines = file($uploadfile);
        array_shift($lines);  // remove header line
        foreach ($lines as $line){
            $line = trim($line);
            $line = trim($line, '"');
            $lineBits = explode('","', $line);
            // V 1.2.4.s : previous version handling
            switch (count($lineBits)) {
              case 6 :
                $q = 'INSERT INTO `#__redirection` VALUES(\'\',"'.$lineBits[1].'", "'.$lineBits[2]
                      .'", "'.$lineBits[3].'", "'.$lineBits[4].'", "'.$lineBits[5].'")';
              break;
              case 5 : // prior to version 1.2.4.q, no rank field : bug fixed in V t 
                $q = 'INSERT INTO `#__redirection` VALUES(\'\',"'.$lineBits[1].'", \'10\', "'.$lineBits[2].'", "'
                      .$lineBits[3].'", "'.$lineBits[4].'" )';
              break;
            }
            
            $database->setQuery( $q );

            if (! $database->query()){
                    echo $database->stderr();
              echo "<p class='error'>"._COM_SEF_ERROR_IMPORT."<pre>$line</pre></p>";
              $results = false;
            }
        }
        unlink($uploadfile) OR mosRedirect('index2.php?option=com_sef',_COM_SEF_NO_UNLINK);
        if ($results) echo '<p class="message">'._COM_SEF_IMPORT_OK.'</p>';
		?>
		<form><input type="button" value="<?php echo _COM_SEF_PROCEED; ?>" onClick="javascript:location.href='index2.php?option=com_sef&task=view&viewmode=<?php echo $ViewModeId;?>'"></form>
		<?php
    }else{
        echo "<p class='error'>"._COM_SEF_WRITE_FAILED."</p>";
        $results = false;
    }
    return $results;
}


function import_custom_CSV_OPEN_SEF($userfile) {  // V 1.2.4.t

    GLOBAL $database;
    $uploaddir = $GLOBALS['mosConfig_absolute_path'].'/media/';
    $uploadfile = $uploaddir . basename($userfile['name']);
    if (move_uploaded_file($userfile['tmp_name'], $uploadfile)) {
        echo '<p class="message">'._COM_SEF_UPLOAD_OK.'</p>';
        $results = true;
        $fileContent = file($uploadfile);
        for ($i=1; $i<6;$i++) // remove header
          array_shift($fileContent);
        $lines = explode('" "', $fileContent[0]);  // only way I could find to split lines
        $shCount = 0;
        foreach ($lines as $line){
            $line = trim($line);
            $lineBits = explode(';', $line);
            $sefUrl = ltrim(trim($lineBits[2],'"'), '/');
            $nonSef = trim($lineBits[3], '"');
            if ($sefUrl != 'NULL' && $nonSsef != 'NULL') {  // don't import records without SEF or non-SEF URL
                $dateAdd = date('Y-m-d');
                if (!preg_match( '/(&|\?)lang=[a-zA-Z]{2,3}/iU', $nonSef)) {  // no lang string, let's add default
                  $shTemp = explode( '_', $GLOBALS['mosConfig_locale']);
                  $shLangTemp = $shTemp[0] ? $shTemp[0] : 'en';
                  $nonSef .= '&lang='.$shLangTemp;
                }
                $nonSef = shSortUrl($nonSef);  // and sort URl so that we always find it
                // Link priority works opposed to rank. The highest LP wins, whereas the lowest ranks win
                // not so simple though, the OSEF system may have several links with same LP, whereas I don't want to have that
                // So let's do rank = 1000-LP. If there is one link with LP =99, it will be used, as it will have lowest rank;
                // if there are several, the first one will be used (just as in OpenSEF), but user is still able
                // to select the URL he wants touse, as doing so in sh404SEF cPanel will set rank=0
                $q = 'INSERT INTO `#__redirection` VALUES(\'\',"0", "'.(1000-(int)$lineBits[17])
                          .'", "'.$sefUrl.'", "'.$nonSef.'", "'.$dateAdd.'")';
                          
                          
                    
                $database->setQuery( $q );
                if (! $database->query()){
                  echo $database->stderr();
                  echo "<p class='error'>"._COM_SEF_ERROR_IMPORT."<pre>$line</pre></p>";
                  $results = false;
                }
                
                $shCount++;
            }
        }
        unlink($uploadfile) OR mosRedirect('index2.php?option=com_sef',_COM_SEF_NO_UNLINK);
        if ($results) echo '<p class="message">'._COM_SEF_IMPORT_OK.' ('.$shCount.')</p>'; 
		?>
		<form><input type="button" value="<?php echo _COM_SEF_PROCEED; ?>" onClick="javascript:location.href='index2.php?option=com_sef&task=view&viewmode=2'"></form>
		<?php
    }else{
        echo "<p class='error'>"._COM_SEF_WRITE_FAILED."</p>";
        $results = false;
    }
    return $results;
}

function import_custom_CSV_meta($userfile) {  // V 1.2.4.s

    GLOBAL $database;
    $uploaddir = $GLOBALS['mosConfig_absolute_path'].'/media/';
    $uploadfile = $uploaddir . basename($userfile['name']);
    if (move_uploaded_file($userfile['tmp_name'], $uploadfile)) {
        echo '<p class="message">'._COM_SEF_UPLOAD_OK.'</p>';
        $results = true;
        $lines = file($uploadfile);
        array_shift($lines);  // remove header line
        foreach ($lines as $line){
            $line = trim($line);
            $line = trim($line, '"');
            $lineBits = explode('","', $line);
            //var_dump($lineBits);
            $q = 'INSERT INTO `#__sh404SEF_meta` VALUES(\'\',"'.shUnEmpty($lineBits[1]).'", "'.shUnEmpty($lineBits[2]).'", "'.shUnEmpty($lineBits[3]).'", "'.shUnEmpty($lineBits[4]).'", "'.shUnEmpty($lineBits[5]).'", "'.shUnEmpty($lineBits[6]).'")';
            $database->setQuery( $q );
            if (! $database->query()){
              echo "<p class='error'>"._COM_SEF_ERROR_IMPORT."<pre>$line</pre></p>";
              $results = false;
            }
        }
        unlink($uploadfile) OR mosRedirect('index2.php?option=com_sef',_COM_SEF_NO_UNLINK);
        if ($results) echo '<p class="message">'._COM_SEF_IMPORT_META_OK.'</p>';
		?>
		<form><input type="button" value="<?php echo _COM_SEF_PROCEED; ?>" onClick="javascript:location.href='index2.php?option=com_sef&task=viewMeta'"></form>
		<?php
    }else{
        echo "<p class='error'>"._COM_SEF_WRITE_FAILED."</p>";
        $results = false;
    }
    return $results;
}

function backup_custom_CSV_meta(){ // 1.2.4.s

    GLOBAL $database;
    $CSV = array();
    $CSV[] = "\"id\",\"newurl\",\"metadesc\",\"metakey\",\"metatitle\",\"metalang\",\"metarobots\" \n"; // V 1.2.4.s
    $query ='SELECT * FROM #__sh404SEF_meta WHERE 1';
    $database->setQuery( $query );
    $rows = $database->loadRowList();
    if (!empty($rows)) {
        foreach ($rows as $row) {
          $CSV[] = "\"".shNonEmpty($row[0])."\",\"".shNonEmpty($row[1])."\",\"".shNonEmpty($row[2])."\",\"".shNonEmpty($row[3])."\",\"".shNonEmpty($row[4])."\",\"".shNonEmpty($row[5])."\",\"".shNonEmpty($row[6])."\" \n";  // V 1.2.4.s
        }
    }else{
        mosRedirect('index2.php?option=com_sef',_COM_SEF_NOACCESS);
    }
    return $CSV;
}


?>
