<?php
$mosConfig_live_site = urldecode($GLOBALS["livesite"]);
$updateTime = urldecode($GLOBALS["updateTime"]);
header('Content-Type: text/xml');
$xmlfile = "google_maps.xml";
   if($updateTime > 0) {
    if(date('U',time() - filemtime($xmlfile)) >= ($updateTime * 60) || filesize($xmlfile) < 5) {
        $url = $mosConfig_live_site . '/index.php?option=com_google_maps&task=xml&' . $GLOBALS["argv"][0];
        $tmp = fopen($url,"r");
        fclose($tmp);
    }
   }
        $fp = fopen($xmlfile, "r");
        $xml = fread($fp, filesize($xmlfile));
        fclose ($fp);
        echo $xml;



?>



