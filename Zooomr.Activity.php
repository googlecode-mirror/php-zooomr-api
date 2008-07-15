<?php

#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/
include_once'Zooomr.php';

# Get a users activity
class ZooomrActivity
{  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI object
  #
  function ZooomrActivity($a_zooomr_api)
  {
    if (null == $a_zooomr_api)
    {
      throw new Exception("ZooomrActivity requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }
  
  # Get a users photos
  #
  # Required Parameters:
  # * auth_token => your auth token
  #
  # Optional Parameters:
  # * timeframe => timeframe to get updates for 2d - 2 days, 4h - 4 hours
  # * page => page of results
  # * per_page => results per page
  #
  function userPhotos($a_parameter_hash)
  {
    $method = 'zooomr.activity.userPhotos';
    
    $required_params = array('auth_token');
    $optional_params = array('timeframe', 'per_page', 'page');
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    $params = array( 'api_key'       => $this->zooomr->api_key,
                    'nojsoncallback'=> '1',
                    'format'        => 'json');
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
}
?>