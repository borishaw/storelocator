<?php
/**
 * sh404SEF support for com_poll component.
 * Copyright Yannick Gaultier (shumisha) - 2007
 * shumisha@gmail.com
 * @version     $Id: com_poll.php 24 2007-09-19 18:35:29Z silianacom-svn $
 * {shSourceVersionTag: Version x - 2007-09-20}
 */
 
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ------------------  standard plugin initialize function - don't change ---------------------------
global $sh_LANG, $sefConfig;  
$shLangName = '';
$shLangIso = '';
$title = array();
$shItemidString = '';
$dosef = shInitializePlugin( $lang, $shLangName, $shLangIso, $option);
// ------------------  standard plugin initialize function - don't change ---------------------------

// ------------------  load language file - adjust as needed ----------------------------------------
$shLangIso = shLoadPluginLanguage( 'com_poll', $shLangIso, '_COM_SEF_SH_POLL_VOTE');
// ------------------  load language file - adjust as needed ----------------------------------------

$task = isset($task) ? $task : null; 
switch ($task) {
  case 'vote':
	  $title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_POLL_VOTE'];
	break;
  default:
    $title[] = $sh_LANG[$shLangIso]['_COM_SEF_SH_POLL_RESULTS'];                                         
  break;
}

if (!empty($id)) {
   $query = 'SELECT title, id FROM #__polls WHERE id = "'.$id.'"';
   $database->setQuery($query);
   if (shTranslateURL($option, $shLangName))
     $database->loadObject( $pollTitle);
   else  $database->loadObject( $pollTitle, false);
   if ($database->getErrorNum()) {
    die( $database->stderr());
   } 
   else $title[] = $pollTitle->title;
  }
else $title[] = '/'; // V 1.2.4.s
    
shRemoveFromGETVarsList('option');
if (!empty($Itemid))
  shRemoveFromGETVarsList('Itemid');
shRemoveFromGETVarsList('lang');
if (!empty($task))
  shRemoveFromGETVarsList('task');
if (!empty($id))  
  shRemoveFromGETVarsList('id');

// ------------------  standard plugin finalize function - don't change ---------------------------  
if ($dosef){
   $string = shFinalizePlugin( $string, $title, $shAppendString, $shItemidString, 
      (isset($limit) ? @$limit : null), (isset($limitstart) ? @$limitstart : null), 
      (isset($shLangName) ? @$shLangName : null));
}      
// ------------------  standard plugin finalize function - don't change ---------------------------

?>