<?php
/**
 * SEF module for Joomla! - URL caching system
 *  
 *
 * @author      $Author: shumisha $
 * @copyright   Yannick Gaultier - 2007
 * @package     sh404SEF
 * @license     http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @version     $Id: shCache.php 24 2007-09-19 18:35:29Z silianacom-svn $
 * 
 * {shSourceVersionTag: Version x - 2007-09-20}  
 */

// Security check to ensure this file is being included by a parent file.
if (!defined('_VALID_MOS')) die('Direct Access to this location is not allowed.');

if (!defined('sh404SEF_FRONT_ABS_PATH')) {
  define('sh404SEF_FRONT_ABS_PATH', str_replace('\\','/',dirname(__FILE__)).'/');
}  
if (!defined('sh404SEF_ABS_PATH')) {
  define('sh404SEF_ABS_PATH', str_replace( '/components/com_sef', '', sh404SEF_FRONT_ABS_PATH) );
}
if (!defined('sh404SEF_ADMIN_ABS_PATH')) {
  define('sh404SEF_ADMIN_ABS_PATH', sh404SEF_ABS_PATH.'administrator/components/com_sef/');
}

global $sefConfig;

// URL Cache management

global $shIsoCodeCache,
       $shLangNameCache;
global $shURLDiskCache,
       $shURLMemCache, 
       $shURLCacheFileName,
       $shURLTotalCount;

$shIsoCodeCache = null;
$shLangNameCache = null;
$shURLDiskCache = null;
$shURLMemCache = null;
$shURLCacheFileName = sh404SEF_FRONT_ABS_PATH.'cache/shCacheContent.php';
$shURLTotalCount = 0;  // v 1.2.4.c added total cache size control

if (!empty($sefConfig->shUseURLCache)) 
  register_shutdown_function('shWriteURLCacheToDisk');

function sh_var_export( $cache, $start) {
  // export content of array $cache, inserting a numeric key starting at $start
  if (!count( $cache)) return '';
  $ret = '';
  foreach ($cache as $cacheItem) {
    $ret .= "\n".'$shURLDiskCache['.$start.'][\'nonSefURL\']=\''.$cacheItem['nonSefURL'].'\';';
    $ret .= "\n".'$shURLDiskCache['.$start.'][\'sefURL\']=\''.$cacheItem['sefURL'].'\';';
    $ret .= "\n".'$shURLDiskCache['.$start++.'][\'type\']=\''.$cacheItem['type'].'\';';
  }
  return $ret; 
}

function shWriteURLCacheToDisk() {
  global $shURLDiskCache, $shURLMemCache, $shURLCacheFileName, $sefConfig;
  
  if (!count($shURLMemCache)) return; // nothing to do, no new URL to write to disk
  if (!file_exists($shURLCacheFileName))
    $cache = '<?php // shCache : URL cache file for sh404SEF
//'.$sefConfig->version.'    
if (!defined(\'_VALID_MOS\')) die(\'Direct Access to this location is not allowed.\');';
  else 
    $cache = '<?php';
  $count = count( $shURLDiskCache);
  $cache .= sh_var_export( $shURLMemCache, $count); // only need to write memory cache, ie: those URL added since last read of cache from disk
  $cache .= "\n".'?'.'>';
  $cacheFile=fopen( $shURLCacheFileName,'ab');
  if ($cacheFile) {
    fwrite( $cacheFile, $cache);
    fclose( $cacheFile);
  }  
}

// fetch an URL from cache, return null if not found
function shGetSefURLFromCache($string, &$url) {
  global $sefConfig, $shURLDiskCache, $shURLMemCache;
  
  if (!$sefConfig->shUseURLCache) {
    $url = null;
    return sh404SEF_URLTYPE_NONE;
  }  
  shLoadURLCache();  
  if (empty($shURLDiskCache) && empty($shURLMemCache)) {
    $url = null;
    return sh404SEF_URLTYPE_NONE;
  } 
  if (!empty($shURLDiskCache)) 
    foreach ($shURLDiskCache as $cacheItem) {
      if ($cacheItem['nonSefURL'] == $string) {
        //echo 'DiskCacheHit = '.$string.'<br />';
        $url = $cacheItem['sefURL'];
        return $cacheItem['type'];
      }  
    } 
  if (!empty($shURLMemCache))  
    foreach ($shURLMemCache as $cacheItem) {
      if ($cacheItem['nonSefURL'] == $string) {
      //echo 'MemCacheHit = '.$string.'<br />';
        $url = $cacheItem['sefURL'];
        return $cacheItem['type'];
      }  
    } 
  return sh404SEF_URLTYPE_NONE;
}

// fetch an URL from cache, return null if not found
function shGetNonSefURLFromCache($string, &$url) {
  global $sefConfig, $shURLDiskCache, $shURLMemCache;
  
  if (!$sefConfig->shUseURLCache) {
    $url = null;
    return sh404SEF_URLTYPE_NONE;
  }  
  shLoadURLCache();  
  if (empty($shURLDiskCache) && empty($shURLMemCache)) {
    $url = null;
    return sh404SEF_URLTYPE_NONE;
  }
  if (!empty($shURLDiskCache))
    foreach ($shURLDiskCache as $cacheItem) {
      if ($cacheItem['sefURL'] == $string) {
        $url = $cacheItem['nonSefURL'];
        return $cacheItem['type'];
      }  
    } 
  if (!empty($shURLMemCache))  
    foreach ($shURLMemCache as $cacheItem) {
      if ($cacheItem['sefURL'] == $string) {
        $url = $cacheItem['nonSefURL'];
        return $cacheItem['type'];
      }  
    }   
  return sh404SEF_URLTYPE_NONE;
}

function shAddSefURLToCache( $nonSefURL, $sefURL, $URLType) {
  global $sefConfig, $shURLMemCache, $shURLTotalCount;
  if (!$sefConfig->shUseURLCache) return null;
  if ($shURLTotalCount >= $sefConfig->shMaxURLInCache) return null;  // v 1.2.4.c added total cache size control
  // Filter out non sef url which include &mosmsg, as I don't want to have a cache entry for every single msg
  // that can be thrown at me, including every 404 error
  if (strpos(strtolower($nonSefURL), '&mosmsg')) return null;
  $count = count($shURLMemCache);
  $shURLMemCache[$count]['nonSefURL'] = $nonSefURL;
  $shURLMemCache[$count]['sefURL'] = $sefURL;
  $shURLMemCache[$count]['type'] = $URLType;
  $shURLTotalCount++;  // v 1.2.4.c added total cache size control
  return true;
}

function shRemoveURLFromCache( $nonSefURLList) {
  global $sefConfig, $shURLMemCache, $shURLDiskCache, $shURLTotalCount;
  
  if (!$sefConfig->shUseURLCache || empty($nonSefURLList)) return null;
  $foundInDiskCache = false;
  $foundInMemCache = false;
  foreach ($nonSefURLList as $nonSefURL) {
    if (!empty($shURLMemCache)) { 
      foreach ($shURLMemCache as $cacheItem) { // look up in memory cache
        if ($cacheItem['nonSefURL'] == $nonSefURL) {
          unset($cacheItem);
          $shURLTotalCount--; 
          $foundInMemCache = true;
          break;
        }
      } 
    }    
    if (!empty($shURLDiskCache)) {
      foreach ($shURLDiskCache as $cacheItem) {  // look up disk cache
        if ($cacheItem['nonSefURL'] == $nonSefURL) {
          unset($cacheItem);
          $shURLTotalCount--;
          $foundInDiskCache = true;
          break;
        }
      }  
    }  
  } 
  if ($foundInMemCache) {
    $shURLMemCache = array_values($shURLMemCache); // simply reindex mem cache
    return;
  }
  if ($foundInDiskCache) { // we need to remove these url from the disk cache file
    // to make it simpler, I simply rewrite the complete file
    $shURLMemCache = (empty($shURLMemCache) ? 
                     array_values($shURLDiskCache)
                    :array_merge($shURLDiskCache, $shURLMemCache));
    $shURLDiskCache = array();  // don't need disk cache anymore, as all URL are in mem cache
    // so we remove both on disk cache and in memory copy of on disk cache
    if (file_exists(sh404SEF_FRONT_ABS_PATH.'cache/shCacheContent.php'))
      unlink(sh404SEF_FRONT_ABS_PATH.'cache/shCacheContent.php');
    // no need to write new URL list in disk file, as this will be done automatically at shutdown  
  }  
}

function shGetMem( $arr) {
  ob_start();
  print_r($arr);
  $mem = ob_get_contents();
  ob_end_clean();
  $mem = preg_replace("/\n +/", "", $mem);
  $mem = strlen($mem);
  return $mem;
}
// load cached URL from disk into an array in memory
function shLoadURLCache() {
  global $shURLDiskCache, $shURLCacheFileName, $shURLTotalCount, $shURLMemCache;
  static $shDiskCacheLoaded = false;
  if (!$shDiskCacheLoaded) {
    if (file_exists( $shURLCacheFileName)) {
      $shURLDiskCache = array();  // V 1.2.4.t
      include($shURLCacheFileName);
      $shDiskCacheLoaded = !empty($shURLDiskCache);
      $shURLTotalCount = !empty($shURLDiskCache) ? count($shURLDiskCache) : 0;
    } else {
        $shURLDiskCache = array();  // V 1.2.4.t
        $shDiskCacheLoaded = false;
    }    
  }     
}

?>
