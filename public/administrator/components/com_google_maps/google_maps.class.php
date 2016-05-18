<?php
/**
* @version $Id: google_maps.class.php,v 1.5 2005/09/17 17:41:17 sjashe Exp $
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
*   This function is needed for installations without PHP4
*/
if( !function_exists( 'html_entity_decode' ) )
{
   function html_entity_decode( $given_html, $quote_style = ENT_QUOTES ) {
       $trans_table = array_flip(get_html_translation_table( HTML_SPECIALCHARS, $quote_style ));
       $trans_table['&#39;'] = "'";
       return ( strtr( $given_html, $trans_table ) );
       }
}

class mosPlace extends mosDBTable {
	/** @var int Primary key */
	var $id=null;
	/** @var string */
	var $name=null;
	/** @var string */
	var $place_position=null;
	/** @var string */
	var $address=null;
	/** @var string */
	var $suburb=null;
	/** @var string */
	var $state=null;
	/** @var string */
	var $country=null;
	/** @var string */
	var $postcode=null;
	/** @var string */
	var $misc=null;
	/** @var string */
	var $polyColor=null;
	/** @var string */
	var $polyWidth=null;
	/** @var string */
	var $draggable=null;
	/** @var string */
	var $markerType=null;
	/** @var int */
	var $published=null;
	/** @var int */
	var $checked_out=null;
	/** @var datetime */
	var $checked_out_time=null;
	/** @var int */
	var $ordering=null;
	/** @var string */
	var $params=null;
	/** @var int A link to a category */
	var $catid=null;
	/** @var int */
	var $access=null;
	/** @var string */
	var $lat=null;
	/** @var string */
	var $lng=null;
	/** @var date */
	var $date=null;	
	/** @var string */
	var $user_id=null;

	/**
	* @param database A database connector object
	*/
	function mosPlace() {
	    global $database;
		$this->mosDBTable( '#__google_maps', 'id', $database );
	}

	function check() {
		// $this->checkLatLongGoogle();
		$testVar = new geocoder($this);
        $testVar->geocodeAddress();
		$this->lat = $testVar->latitude;
		$this->lng = $testVar->longitude;
		return true;
	}
}


class mosPlaceConf extends mosDBTable {

	/** @var int Primary key */
	var $id=null;
	/** @var string */
	var $mapWidth=null;
	/** @var string */
	var $mapHeight=null;
	/** @var string */
	var $mapBorder=null;
	/** @var int */
	var $zoomLevel=null;
	/** @var string */
	var $APIKey=null;
	/** @var string */
    var $title=null;
	/** @var string */
	var $misc=null;
	/** @var int */
    var $centerId=null;
	/** @var string */
	var $centerLng=null;
	/** @var string */
    var $centerLat=null;
	/** @var int */
	var $autoOpen=null;
	/** @var int */
	var $showScale=null;
	/** @var int */
	var $showZoom=null;
	/** @var int */
    var $whichZoom=null;
	/** @var int */
	var $showType=null;
	/** @var int */
	var $whichType=null;
	/** @var int */
	var $contZoom=null;
	/** @var int */
	var $doubleclickZoom=null;
	/** @var int */
	var $reqAd=null;
	/** @var int */
	var $reqCt=null;
	/** @var int */
	var $reqSt=null;
	/** @var int */
	var $reqCn=null;
	/** @var int */
	var $reqZp=null;
	/** @var int */
	var $reqLl=null;
	/** @var int */
	var $tooltip=null;
	/** @var string */
	var $xsl=null;
	/** @var int */
	var $pdMarkers=null;
	/** @var int */
	var $geocode=null;
	/** @var text */
	var $sideTitle=null;
	/** @var int */
	var $sideNum=null;
	/** @var text */
	var $sideStyle=null;
	/** @var int */
	var $sideShowcat=null;
	/** @var int */
	var $sideShowtitle=null;
	/** @var int */
	var $autoApprove=null;
	/** @var int */
	var $communityEnable=null;
	/** @var int */
	var $communityIcon=null;
	/** @var int */
	var $communityHidereal=null;
	/** @var int */
	var $communityLimit=null;
	/** @var int */
	var $xmlEncoding=null;
	/** @var int */
	var $xmlCache=null;
	/** @var int */
	var $xmlUrl=null;
	/** @var int */
	var $editBodytag=null;
	/** @var int */
	var $overviewEnable=null;
	/** @var int */
	var $overviewWidth=null;
	/** @var int */
	var $overviewHeight=null;
	/** @var int */
	var $safariCompat=null;
	/** @var int */
	var $catSep=null;
	/** @var int */
	var $mappingAPI=null;

	
	/**
	* @param database A database connector object
	*/
	function mosPlaceConf() {
	    global $database;
		$this->mosDBTable( '#__google_maps_conf', 'id', $database );
	}

}


class geocoder {

	/** @var int Primary key */
	var $id=null;
	/** @var text */
	var $address=null;
	/** @var text */
	var $city=null;
	/** @var text */
	var $state=null;
	/** @var text */
	var $country=null;
	/** @var text */
	var $zipcode=null;
	/** @var text */
	var $latitude=null;
	/** @var text */
	var $longitude=null;
	
	function geocoder($geoData, $addressField = 'address', $cityField = 'suburb', $stateField = 'state', $countryField = 'country', $zipcodeField = 'postcode', $latField = 'lat', $lngField = 'lng') {
        
        $this->address = $geoData->$addressField;
        $this->city = $geoData->$cityField;
        $this->state = $geoData->$stateField;
        $this->country = $geoData->$countryField;
        $this->zipcode = $geoData->$zipcodeField;
        $this->latitude = $geoData->$latField;
        $this->longitude = $geoData->$lngField;
        return true;
        
	}
	
	function geocodeAddress($batch = 0) {
        
		if($this->address) {
            $q = "";
            $q .= $this->address;
            if($this->city)    $q .= ', '.$this->city;
            if($this->state)   $q .= ', '.$this->state;
            if($this->zipcode) $q .= ', '.$this->zipcode;
            if($this->country) $q .= ','.$this->country;
        } else {
            $q = "";
            if($this->address) $q .= $this->address . ', ';
            if($this->city)    $q .= $this->city . ', ';
            if($this->state)   $q .= $this->state . ', ';
            if($this->zipcode) $q .= $this->zipcode . ', ';
            if($this->country) $q .= $this->country;
        }
            
        if($batch == 1 || $this->country == 'France' || $this->country == 'Germany' || $this->country == 'Italy' || $this->country == 'Spain' || $this->country == 'Australia' || $this->country == 'New Zealand') {
            $result = $this->googleGeocode($q);
            $lat = $result["lat"];
            $lng = $result["lng"];
        } else {
            $result = $this->yahooGeocode($q);
            $lat = $result["lat"];
            $lng = $result["lng"];
        }
      	// This sets the latitude and longitude
        $this->longitude = ($lng) ? $lng : $this->longitude;
        $this->latitude = ($lat) ? $lat : $this->latitude;
        return true; 
	}
	
	function googleGeocode($q) {
            global $database;
            // Grabs the API Key
            $query = "SELECT * FROM #__google_maps_conf WHERE id = 1";
            $database->setQuery($query);
            $rows = $database->loadObjectList();
            $confData = $rows[0];
            $apikey = $confData->APIKey;
            // Sends query to Google Geocoder 
//            $gm=fopen('http://maps.google.com/maps/geo?output=csv&q='.urlencode($q).'&key='.$apikey,'r');
//            $tmp=@fread($gm,30000);
//            fclose($gm);

            $tmp = $this->sendGeoQuery('http://maps.google.com/maps/geo?output=csv&q=',$q,$apikey);
            
            $tmpcoords = explode(',',$tmp);
            list($status,$accuracy,$lat,$lng) = $tmpcoords;
            $result["lat"] = $lat;
            $result["lng"] = $lng;
            return $result;
    }
    
    function yahooGeocode($q) {

//            $gm=fopen('http://api.local.yahoo.com/MapsService/V1/geocode?appid=maverickpl94&location='.urlencode($q),'r');
//            $tmp=@fread($gm,30000);
//            fclose($gm);

            $tmp = $this->sendGeoQuery('http://api.local.yahoo.com/MapsService/V1/geocode?appid=maverickpl94&location=',$q);
            $p = xml_parser_create();
            xml_parse_into_struct($p, $tmp, $vals, $index);
            xml_parser_free($p);

            $result["lat"] = $vals[2]["value"];
            $result["lng"] = $vals[3]["value"];
            return $result;
    }
    
    function sendGeoQuery($url,$q,$apikey = '') {
        
        $fullUrl = $url . urlencode($q);
        if($apikey) $fullUrl .= '&key='.$apikey;
        
        if(ini_get("allow_url_fopen")) {
            $gm=fopen("$fullUrl",'r');
            $tmp=@fread($gm,30000);
            fclose($gm);
        } else {
            $ch = curl_init();
            $timeout = 20; // set to zero for no timeout
            curl_setopt($ch, CURLOPT_URL, "$fullUrl");
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $tmp= curl_exec($ch);
            curl_close($ch);
        }
        
        return $tmp;
    
    }

}

/**
*	@class	xml2array
*/

class	xml2array {
	var $root_element;

	/**
	*	constructor
	*/
	function xml2array( $xml ) {
		if($xml = domxml_open_file( $xml )){
			$this->root_element = $xml->document_element();
			return true;
		}

		return false;
	}
	
	function getResult() {
		return array( $this->root_element->tagname() => $this->_recNode2Array( $this->root_element ));
	}
    
    /**
    *     Does not break down element. Just grabs the content as is.
    */
    
    function GetContentAsString($node) {   
        $st = "";
        if($node->child_nodes()) foreach ($node->child_nodes() as $cnode)
            if ($cnode->node_type()==XML_TEXT_NODE)
                $st .= str_replace("\n","",$cnode->node_value());
            else if ($cnode->node_type()==XML_ELEMENT_NODE) {
                $st .= "<" . $cnode->node_name();
                if ($attribnodes=$cnode->attributes()) {
                    $st .= " ";
                    foreach ($attribnodes as $anode)
                        $st .= $anode->node_name() . '="' .
                        $anode->get_content() . '"';
                }   
                $nodeText = $this->GetContentAsString($cnode);
                if (empty($nodeText) && !$attribnodes)
                    $st .= " />";        // unary
                else
                    $st .= ">" . $nodeText . "</" .
                    $cnode->node_name() . ">";
            }
        return $st;
    }

	/**
	*	recursive function to walk through dom and create array
	*/
	function _recNode2Array( $domnode ) {
		if ( $domnode->node_type() == XML_ELEMENT_NODE)
		{

			$childs = $domnode->child_nodes();
			
			if($childs) foreach($childs as $child)
			{
				if ($child->node_type() == XML_ELEMENT_NODE)
				{
					$subnode = false;
					$prefix = ( $child->prefix() ) ? $child->prefix().':' : '';
					
					// try to check for multisubnodes
					foreach ($childs as $testnode)
					  if ( is_object($testnode))
						if ($child->node_name() == $testnode->node_name() && $child != $testnode)
							$subnode = true;
							
					if ( isset($result[ $prefix.$child->node_name() ]) && is_array($result[ $prefix.$child->node_name() ]))
						$subnode = true;

					if ($subnode == true)
						$result[ $prefix.$child->node_name() ][]	= $this->_recNode2Array($child);
					elseif ($child->node_name() == "misc") 
						$result[ $prefix.$child->node_name() ]	= $this->GetContentAsString($child);
					else 
						$result[ $prefix.$child->node_name() ]	= $this->_recNode2Array($child);
				}
			}
			
			if ( !isset($result) || !is_array($result) ){
				$result	=	html_entity_decode(htmlentities($domnode->get_content(), ENT_COMPAT, 'utf-8'));
			}
	
			if ( $domnode->has_attributes() )
				foreach ( $domnode->attributes() as $attrib )
				{
					$prefix = ( $attrib->prefix() ) ? $attrib->prefix().':' : '';
					$result["@".$prefix.$attrib->name()]	=	$attrib->value();
				}

			return $result;
		}
	}
}

class importMarkers {
	
	var $result;
	var $dom;
	var $fileType;
	var $action;

	function importMarkers($file, $fileType = 'text/xml') {
        $this->fileType = $fileType;
        switch($this->fileType) {
        
          case 'text/xml':    
            if(!function_exists('domxml_open_file')) {
                $x = new DOMDocument();
                $x->load($file);
                $this->result = simplexml_import_dom($x);
                $this->dom = $x;
                $this->action = 2;
            } else {
                $x = new xml2array($file);
                $this->result = $x->getResult();
                $this->dom = null;
                $this->action = 1;
            }
            break;
          case 'text/plain':
            $this->dom = null;
            if ($fp = fopen( $file, "r" )) {
                $data = trim(fread($fp, filesize($file)));
                fclose ($fp);
            }
            $infos = explode("\n",$data);
            for($i=0;count($infos) > $i && $infos[$i];$i++) {
                $info = explode("|",$infos[$i]);
                $this->result["xml"]["info"][$i]["@type"] = $info[0];
                $this->result["xml"]["info"][$i]["@category"] = $info[1];
                $this->result["xml"]["info"][$i]["name"] = $info[2];
                $this->result["xml"]["info"][$i]["address"] = $info[3];
                $this->result["xml"]["info"][$i]["city"] = $info[4];
                $this->result["xml"]["info"][$i]["state"] = $info[5];
                $this->result["xml"]["info"][$i]["zipcode"] = $info[6];
                $this->result["xml"]["info"][$i]["country"] = $info[7];
                $this->result["xml"]["info"][$i]["misc"] = $info[8];
                if(!is_numeric($info[9]) || !is_numeric($info[10])) {
                    $geocodeData = $this->doGeocode($i);
                    $info[9] = $geocodeData->latitude;
                    $info[10] = $geocodeData->longitude;
                }
                $this->result["xml"]["info"][$i]["lat"] = $info[9];
                $this->result["xml"]["info"][$i]["lng"] = $info[10];
            }
            $this->action = 3;
            break;
          default:
            $this->action = 0;
            break;
            
        }
	}
	
	function geocodeFormat($i) {
        $geocode->address = $this->result["xml"]["info"][$i]["address"];
        $geocode->suburb = $this->result["xml"]["info"][$i]["city"];
        $geocode->state = $this->result["xml"]["info"][$i]["state"];
        $geocode->postcode = $this->result["xml"]["info"][$i]["zipcode"];
        $geocode->country = $this->result["xml"]["info"][$i]["country"];
        $geocode->lat = $this->result["xml"]["info"][$i]["lat"];
        $geocode->lng = $this->result["xml"]["info"][$i]["lng"];
        return $geocode;
	}
	
	function doGeocode($i) {
        $geoObject = $this->geocodeFormat($i);
        $result = new geocoder($geoObject);
        $result->geocodeAddress(1);
        return $result;
	}
	
	function testDOMXML() {
        switch($fileType) {
          case 'text/xml':    
            if(!function_exists('domxml_open_file')) {
                return 2;
            } else {
                return 1;
            }
            break;
          case 'text/plain':
            return 3;
            break;
          default:
            return 0;
            break;
        }
    }
	
	
	/**
	*   Flush to flat text file
	*/
    function flatFile($dataType = "info",$seperator = '|') {
        $result = '';
        $data = $this->getResult();
        if($dataType == "info")
        {
            foreach($data["xml"]["$dataType"] as $info)
            {
                $result .= $info["@type"];
                $result .= $seperator;
                $result .= $info["@category"];
                $result .= $seperator;
                $result .= $info["name"];
                $result .= $seperator;
                $result .= $info["address"];
                $result .= $seperator;
                $result .= $info["city"];
                $result .= $seperator;
                $result .= $info["state"];
                $result .= $seperator;
                $result .= $info["zipcode"];
                $result .= $seperator;
                $result .= $info["country"];
                $result .= $seperator;
                $result .= $info["misc"];
                $result .= $seperator;
                if($info["@lat"]) {
                    $result .= "'" . $info["@lat"] . "',";
                    $result .= $seperator;
                } else {
                    $result .= "'".$info["lat"]  ."',";
                    $result .= $seperator;
                }
                if($info["@lng"]) {
                    $result .= "'".$info["@lng"]."'";
                    $result .= $seperator;
                } else {
                    $result .= "'".$info["lng"]."'";
                    $result .= $seperator;
                }
                $result .= "\n";
            }
        }
        elseif($dataType == "category")
        {
            foreach($data["xml"]["$dataType"] as $info)
            {
                for($i=0;count($info)>$i;$i++)
                {
                    $result .= current($info);
                    $result .= $seperator;
                    next($info);
                }
                $result .= "\n";
            }
        
        }
        return $result;
    }
    
    
    function buildmarkerQuery() {
        $i = 0;
        $values = "(";
        foreach($this->result["xml"]["info"] as $info) {
         if($info["@type"] != 3) {
            if($i != 0) $values .= ",(";
            $values .= "'1',";
            $values .= "'".$info["@type"]               ."',";
            $values .= "'".$info["@category"]           ."',";
            $values .= "'".addslashes($info["name"])    ."',";
            $values .= "'".addslashes($info["address"]) ."',";
            $values .= "'".addslashes($info["city"])    ."',";
            $values .= "'".addslashes($info["state"])   ."',";
            $values .= "'".addslashes($info["zipcode"]) ."',";
            $values .= "'".addslashes($info["country"]) ."',";
            if($info["@type"] == 2) {
                $numbers = "(?:[ ]?[-+]?\d+(?:\.\d+)?[ ]?)"; // This regular expression will find a number in any format
                $expression = "/{$numbers}/"; // This grabs the numbers that are hopefully in the format ([number],[number])
                preg_match_all($expression,$info["misc"],$polyPoints);
                for($i = 0;$polyPoints[0][$i];$i++) {
                    if($i==0) {
                        $temp = '(';
                    } else {
                        $temp .= ',(';
                    }
                    $temp .= $polyPoints[0][$i].',';
                    $i++;
                    $temp .= $polyPoints[0][$i].')';
                }
                $values .= "'".addslashes($temp)."',";
            } else {
                $values .= "'".addslashes($info["misc"])    ."',";
            }
            if($info["@lat"]) {
                $values .= "'" . $info["@lat"] . "',";
            } else {
                $values .= "'".$info["lat"]  ."',";
            }
            if($info["@lng"]) {
                $values .= "'".$info["@lng"]."'";
            } else {
                $values .= "'".$info["lng"]."'";
            }
            $values .= ")";
            $i++;
         }
        }
        
        $query = "INSERT IGNORE INTO #__google_maps (published,markerType,catid,name,address,suburb,state,postcode,country,misc,lat,lng) ";
        $query .= "VALUES " . $values .";";

        return $query;
    }
    
    function buildmarkerQueryPHP5() {
        
        $dom = $this->dom;
        $dom = $dom->getElementsByTagName('misc');
        $infos = $this->result;
        $infos = $infos->info;
        $i = 0;
        $values = "(";
        foreach($infos as $info) {
         if($info["type"] != 3) {
            if($i != 0) $values .= ",(";
            $values .= "'1',";
            $values .= "'".$info["type"]               ."',";
            $values .= "'".$info["category"]           ."',";
            $values .= "'".addslashes($info->name)    ."',";
            $values .= "'".addslashes($info->address) ."',";
            $values .= "'".addslashes($info->city)    ."',";
            $values .= "'".addslashes($info->state)   ."',";
            $values .= "'".addslashes($info->zipcode) ."',";
            $values .= "'".addslashes($info->country) ."',";
            $y = new DOMDocument();
            $contentAsText = "";
            $dom2 = $dom->item($i);
            $dom2 = $dom2->childNodes;
            for($z=0;$dom2->item($z);$z++) {
                $node = $y->importNode($dom2->item($z),true);
                $node = $y->appendChild($node);
                $contentAsText .= $y->saveXML($node);
            }
            $info->misc = $contentAsText;
            if($info["type"] == 2) {
                $numbers = "(?:[ ]?[-+]?\d+(?:\.\d+)?[ ]?)"; // This regular expression will find a number in any format
                $expression = "/{$numbers}/"; // This grabs the numbers that are hopefully in the format ([number],[number])
                preg_match_all($expression,$info->misc,$polyPoints);
                for($z = 0;isset($polyPoints[0][$z]);$z++) {
                    if($z==0) {
                        $temp = '(';
                    } else {
                        $temp .= ',(';
                    }
                    $temp .= $polyPoints[0][$z].',';
                    $z++;
                    $temp .= $polyPoints[0][$z].')';
                }
                $values .= "'".addslashes($temp)."',";
            } else {
                $values .= "'".addslashes($info->misc)    ."',";
            }
            if($info["lat"]) {
                $values .= "'" . $info["lat"] . "',";
            } else {
                $values .= "'".$info->lat  ."',";
            }
            if($info["lng"]) {
                $values .= "'".$info["lng"]."'";
            } else {
                $values .= "'".$info->lng."'";
            }
            $values .= ")";
            $i++;
         }
        }
        
        $query = "INSERT IGNORE INTO #__google_maps (published,markerType,catid,name,address,suburb,state,postcode,country,misc,lat,lng) ";
        $query .= "VALUES " . $values .";";

        return $query;
    }

    function buildcategoryQuery() {
        $values = "(";
        $i = 0;
        $infos = $this->result["xml"]["category"];
        if(is_array($infos[0])) {
            foreach($infos as $info) {
                if($i != 0) $values .= ",(";
                $values .= "'1','com_google_maps',";
                $values .= "'".$info["@id"]. "',";
                if($info["@name"]) {
                    $values .= "'".$info["@name"]. "',";
                } else {
                    $values .= "'".$info. "',";
                }
                if($info["@gicon"]) {
                    $values .= "'".$info["@gicon"]. "'";
                } else {
                    $values .= "''";
                }
                $values .= ")";
                $i++;
            }
        } else {
                $values .= "'1','com_google_maps',";
                $values .= "'".$infos["@id"]. "',";
                if($infos["@name"]) {
                    $values .= "'".$infos["@name"]. "',";
                } else {
                    $values .= "'".$infos. "',";
                }
                if($infos["@gicon"]) {
                    $values .= "'".$infos["@gicon"]. "'";
                } else {
                    $values .= "''";
                }
                $values .= ")";
        }
        $query .= "INSERT IGNORE INTO #__categories (published,section,id,name,description) ";
        $query .= "VALUES $values";
        
        return $query;
    }

    function buildcategoryQueryPHP5() {
        $values = "(";
        $i = 0;
        $infos = $this->result;
        $infos = $infos->category;
        if(is_array($infos[0])) {
            foreach($infos as $info) {
                if($i != 0) $values .= ",(";
                $values .= "'1','com_google_maps',";
                $values .= "'".$info["id"]. "',";
                if($info["name"]) {
                    $values .= "'".$info["name"]. "',";
                } else {
                    $values .= "'".$info. "',";
                }
                if($info["gicon"]) {
                    $values .= "'".$info["gicon"]. "'";
                } else {
                    $values .= "''";
                }
                $values .= ")";
                $i++;
            }
        } else {
                $values .= "'1','com_google_maps',";
                $values .= "'".$infos["id"]. "',";
                if($infos["name"]) {
                    $values .= "'".$infos["name"]. "',";
                } else {
                    $values .= "'".$infos. "',";
                }
                if($infos["gicon"]) {
                    $values .= "'".$infos["gicon"]. "'";
                } else {
                    $values .= "''";
                }
                $values .= ")";
        }
        $query .= "INSERT IGNORE INTO #__categories (published,section,id,name,description) ";
        $query .= "VALUES $values";
        
        return $query;
    }

}

class xmlBuilder {
    
    var $confData;
    var $markerData;
    var $categoryData;
    var $cbData;
    var $cbFields;
    var $xmlFiledata;
    var $xmlFilename;
    var $option;
    var $catSep;
    
    function xmlBuilder($option, $file, $task = null,$catFilter = null, $markFilter = null) {
        global $database;
        $this->option = $option;
        $this->xmlFilename = $file;
        
                     

        // get the configuration data
        $query1 = "SELECT * FROM #__google_maps_conf WHERE id = 1";
        $database->setQuery($query1);
        $rows = $database->loadObjectList();
        $this->confData = $rows[0];
        
        ($task == 'pureXml2') ? $this->catSep = ',' : $this->catSep = $this->confData->catSep;
        $catQuery = $this->xmlSqlbuild($catFilter,$this->catSep, "catid");
        $markQuery = $this->xmlSqlbuild($markFilter,$this->catSep, "id");

        // Get all category data from #__categories
        $query2 = "SELECT *"
                . "\n FROM #__categories"
                . "\n Where section = '".$this->option."'"
                . "\n " .str_replace('catid','id',$catQuery)
                ;
        $database->setQuery($query2);
        $this->categoryData = $database->loadObjectList();	

        // Select all the markers from the #__google_maps table
        $query3 = "SELECT *"
                . " FROM #__google_maps"
                . " WHERE published='1'"
                . "\n " . $catQuery
                . "\n " . $markQuery
                . " ORDER BY catid, name"
                ;
		$database->setQuery( $query3 );
		$this->markerData = $database->loadObjectList();

        if($this->confData->communityEnable) {

            // Select the user data 
            $query4 = 'SELECT * FROM #__comprofiler_plugin WHERE element="geocoder"'; 
            $database->setQuery( $query4 );
            $tmp = $database->loadObjectList();
	
            $profilerFields =& new mosParameters( $tmp[0]->params );
            $this->cbFields["cbAddress"]      = $profilerFields->get('geoAddress');
            $this->cbFields["cbCity"]         = $profilerFields->get('geoCity');
            $this->cbFields["cbState"]        = $profilerFields->get('geoState');
            $this->cbFields["cbPostcode"]     = $profilerFields->get('geoPostcode');
            $this->cbFields["cbCountry"]      = $profilerFields->get('geoCountry');
        
            switch( $this->confData->communityEnable ) {
	
                case '1': // all user data is gathered whether they are online or not.
                $query5 = 'SELECT b.name, b.username, a.*  FROM #__users AS b' 
                        . ' INNER JOIN #__comprofiler AS a ON a.id = b.id'
                        . ' WHERE a.cb_geolatitude != "" LIMIT '.$this->confData->communityLimit;
                $database->setQuery( $query5 );
                $this->cbData = $database->loadObjectList();
                break;
            
                case '2': // only online user data is gathered
            
                $query5 = 'SELECT DISTINCT b.name, b.username, a.*  FROM #__users AS b, #__comprofiler AS a, #__session AS c' 
                        . ' WHERE a.id = b.id AND c.userid = a.id'
                        . ' AND a.cb_geolatitude != "" LIMIT '.$this->confData->communityLimit;
                $database->setQuery( $query5 );
                $this->cbData = $database->loadObjectList();
                break;
            }
        }
        return true;
    }
    
    function xmlSqlbuild($catFilter, $catSep = ',' , $catName = 'id') {
        $sqlQuery = '';
        if($catFilter) {
            $catFilter2 = explode($catSep,$catFilter);
            $sqlQuery = " AND (";
            for($i=0; count($catFilter2) > $i; $i++) {
                if($i != 0)                $sqlQuery .= ' OR';
                if(is_numeric($catFilter2[$i])) $sqlQuery .= ' '.$catName.'="' . $catFilter2[$i] . '" '."\n";
            }
            $sqlQuery .= ')';
        }
        return $sqlQuery;
    
    }
    
    function textCreate() {
        $info = '';
        if (count($this->markerData) > 0) {
            foreach ($this->markerData as $row) {
                $info .= $row->markerType .'|';
                $info .= $row->catid .'|';
                $info .= $row->name .'|';
                $info .= $row->address .'|';
                $info .= $row->suburb .'|';
                $info .= $row->state .'|';
                $info .= $row->postcode .'|';
                $info .= $row->country .'|';
                $info .= str_replace("\n",'',$row->misc) .'|';
                $info .= $row->lat .'|';
                $info .= $row->lng ."\n";
            }
        }
        $this->xmlFiledata = $info;
    }
    
    function xmlCreate() {

        /* Community Builder Integration 
	
        Here the Community Builder data is taken 
        from the comprofiler tables and inserted 
        into the $params->cb object.              */

        $badChars = array('&');
        $goodChars = array('&amp;');
        ($this->confData->xmlEncoding) ? $xmlEncoding = $this->confData->xmlEncoding : $xmlEncoding = 'ISO-8859-1';
	
        $info = "<?xml version=\"1.0\" encoding=\"".$xmlEncoding."\"?>\n<xml>\n";
        if($this->confData->communityEnable) {
            $info .= '<category id="-3"';
            $info .= ' name="Users"';
            if(is_numeric($this->confData->communityIcon)) $info .= ' gicon="'.$this->confData->communityIcon.'"';
            $info .= " />\n";
        }
        if(count($this->categoryData)) {
         foreach($this->categoryData as $catName) {
            $info .= '<category id="'.$catName->id.'"';
            $info .= ' name="'.$catName->name.'"';
            if(is_numeric($catName->description)) $info .= ' gicon="'.$catName->description .'"';
            $info .= " />\n";
         }
        }
       if (count($this->markerData) > 0) {
        foreach ($this->markerData as $row) {
            $info .= "<info id=\"".$row->id."\" category=\"".$row->catid."\" draggable=\"".$row->draggable."\" type=\"".$row->markerType."\" lat=\"".$row->lat."\" lng=\"".$row->lng."\">";
            $info .= ($row->name) ? "<name>".str_replace($badChars,$goodChars,$row->name)."</name>" : '<name />';
            $info .= ($row->address) ? "<address>".str_replace($badChars,$goodChars,str_replace($goodChars,$badChars,$row->address))."</address>" : '<address />';
            $info .= ($row->suburb) ? "<city>". str_replace($badChars,$goodChars,str_replace($goodChars,$badChars,$row->suburb))."</city>" : '<city />';
            $info .= ($row->state) ? "<state>".str_replace($badChars,$goodChars,str_replace($goodChars,$badChars,$row->state))."</state>" : '<state />';
            $info .= ($row->postcode) ? "<zipcode>".$row->postcode."</zipcode>" : '<zipcode />';
            $info .= ($row->country) ? "<country>".str_replace($badChars,$goodChars,str_replace($goodChars,$badChars,$row->country))."</country>" : '<country />';
            if($row->markerType == 2) {
                $polyColor = (!$row->polyColor) ? "#FF0000" : $row->polyColor;
                $polyWidth = (!$row->polyWidth) ? 10 : $row->polyWidth;
                $info .= '<misc polycolor="'.$polyColor.'" polywidth="'.$polyWidth.'">';
                $row->misc = str_replace(" ", "", $row->misc);
                $numbers = "(?:[ ]?[-+]?\d+(?:\.\d+)?[ ]?)"; // This regular expression will find a number in any format
                $expression = "/{$numbers}/"; // This grabs the numbers that are hopefully in the format ([number],[number])
                preg_match_all($expression,$row->misc,$polyPoints);
                for($i = 0;$polyPoints[0][$i];$i++) {
                    $info .= '<point lat="'.$polyPoints[0][$i].'" ';
                    $i++;
                    $info .= 'lng="'.$polyPoints[0][$i].'" />';
                }
                $info .= "</misc>";
            } else {
                $info .= ($row->misc) ? "<misc>".str_replace($badChars,$goodChars,str_replace($goodChars,$badChars,$row->misc))."</misc>" : '<misc />';
            }
            $info .= "</info>\n";

            $prevCatid = $row->catid;
        } // end of foreach
       } // end of check for rows (if)
        if($this->confData->communityEnable) {
            $cbFields = $this->cbFields;
            $z = 0;
            foreach($this->cbData as $row) {
                $info .= '<info id="310'.$row->id.'" userid="'.$row->id.'" lat="'.$row->cb_geolatitude.'" lng="'.$row->cb_geolongitude.'" category="-3" type="3" username="'.$row->username.'">';
                $info .= ($row->name && !$this->confData->communityHidereal) ? '<name>'.str_replace($badChars,$goodChars,$row->name).'</name>' : '<name />';
                if($row->avatar) {
                    (file_exists("images/comprofiler/tn".$row->avatar)) ? $thumb = 1 : $thumb = 0; 
                    $info .= '<avatar thumb="'.$thumb.'">'.$row->avatar.'</avatar>';
                }
                $info .= ($row->$cbFields["cbAddress"]) ? "<address>".str_replace($badChars,$goodChars,str_replace($goodChars,$badChars,$row->$cbFields["cbAddress"]))."</address>" : '<address />';
                $info .= ($row->$cbFields["cbCity"]) ? "<city>". str_replace($badChars,$goodChars,str_replace($goodChars,$badChars,$row->$cbFields["cbCity"]))."</city>" : '<city />';
                $info .= ($row->$cbFields["cbState"]) ? "<state>".str_replace($badChars,$goodChars,str_replace($goodChars,$badChars,$row->$cbFields["cbState"]))."</state>" : '<state />';
                $info .= ($row->$cbFields["cbPostcode"]) ? "<zipcode>".str_replace($badChars,$goodChars,str_replace($goodChars,$badChars,$row->$cbFields["cbPostcode"]))."</zipcode>" : '<zipcode />';
                $info .= ($row->$cbFields["cbCountry"]) ? "<country>".str_replace($badChars,$goodChars,str_replace($goodChars,$badChars,$row->$cbFields["cbCountry"]))."</country>" : '<country />';
                $info .= "</info>\n";
                $z++;
            }
        }
        $info .= "</xml>";
        $this->xmlFiledata = $info;
        return true;
    }
    
    /*
    *  Write to XML File
    *  Here we write to the xml file that will
    *  work as a cache system so the component won't 
    *  hit the database every time a user comes to 
    *  the site.
    */


    function xmlWrite($autoRefresh = 0) {
        global $mosConfig_absolute_path;
    
        $refreshTime = $this->confData->xmlCache;
        $modTime = filemtime($mosConfig_absolute_path .'/components/com_google_maps/google_maps.xml');
        $currentTime = time();
        
    
        if (!is_writable($this->xmlFilename)) { // Make sure the xsl file is writable by the server.
            $mosmsg = "Config File Not writeable";
            return false;
        } elseif(((($currentTime - $modTime)/60) > $refreshTime && $refreshTime != -1) || $autoRefresh == 0){
            $fp = fopen($this->xmlFilename, "w+");
            fputs($fp, $this->xmlFiledata, strlen($this->xmlFiledata));
            fclose ($fp);
            return true;
        }
    }

}

?>