<?php

#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.php';

# Manipulate Geotags for a photo
class ZooomrPhotosGeo
{  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI object
  #
  function ZooomrPhotosGeo($a_zooomr_api)
  {
    if ($a_zooomr_api == null)
    {
      throw new Exception("ZooomrPhotosGeo requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }
  
  # Remove the current geotag from a photo
  #
  # Required Parameters:
  # * photo_id => photo to remove geotag from
  # * auth_token => your auth token
  #
  function removeLocation($a_parameter_hash)
  {
    $method = 'zooomr.photos.geo.removeLocation';
    
    $required_params = array('photo_id', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
  
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # Set the location for a photo
  #
  # Required Parameters:
  # * photo_id => photo to set geo tag for
  # * lat => latitude
  # * lon => longitude
  # * auth_token => your auth token
  #  
  # Optional Parameters
  # * accuracy => level of accurac
  #
  function setLocation($a_parameter_hash)
  {
    $method = 'zooomr.photos.geo.setLocation';
    
    $required_params = array('photo_id', 'lat', 'lon', 'auth_token');
    $optional_params = array('accuracy');
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
}
?>
