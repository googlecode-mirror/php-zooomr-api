<?php

#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/
include_once 'Zooomr.php';

# Transform routines
class ZooomrPhotosTransform
{
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI object
  function ZooomrPhotosTransform($a_zooomr_api)
  {
    if ($a_zooomr_api == null)
    {
      throw new Exception("ZooomrPhotosTransform requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }
  
  # Rotate a photo
  #
  # Required Parameters:
  # * photo_id => the photo you want to rotate
  # * degrees => number of degrees to rotate the photo (90, 180, 270)
  # * auth_token => your auth token
  #
  function rotate($a_parameter_hash)
  {
    $method = 'zooomr.photos.transform.rotate';
    
    $required_params = array('photo_id', 'degrees', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
}

?>
