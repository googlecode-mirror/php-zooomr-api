<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.php';

# Manipulate licenses for photos
class ZooomrPhotosLicense
{
  # License types
  var $LICENSE_ALL_RIGHTS_RESERVED              = "0";
  var $LICENSE_CC_ATTRIBUTION                   = "1";
  var $LICENSE_CC_NO_DERIVITIVES                = "2";
  var $LICENSE_CC_NON_COMMERCIAL_NO_DERIVITIVES = "3";
  var $LICENSE_CC_NON_COMMERCIAL                = "4";
  var $LICENSE_CC_NON_COMMERCIAL_SHARE_ALIKE    = "5";
  var $LICENSE_CC_SHARE_ALIKE                   = "6";

  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI object
  #
  function ZooomrPhotosLicense($a_zooomr_api)
  {
    if (a_zooomr_api == null)
    {
      throw new Exception("ZooomrPhotosLicense requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }  
  # Set the license for a given photo
  #
  # Required Parameters:
  # * photo_id => photo to set the license for
  # * license_id => license to user (from constants above)
  # * auth_token => your auth token
  #
  function setLicense($a_parameter_hash)
  {
    $method = 'zooomr.photos.licenses.setLicense';
    
    $required_params = array('photo_id', 'license_id', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
}

?>
