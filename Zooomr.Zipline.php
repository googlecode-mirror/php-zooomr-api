<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.php';

# Zipline methods  - all methods return a ZooomrResponse object
class ZooomrZipline
{  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI instance
  #
  function ZooomrZipline($a_zooomr_api)
  {
    if (null == $a_zooomr_api)
    {
      throw new Exception("ZooomrZipline requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }
  
  # Post some text to zipline
  #
  # Required Parameters:
  # * status => the text you want to post
  # * auth_token => Your auth token
  #
  function postLine($a_parameter_hash)
  {
    $method = 'zooomr.zipline.postLine';
    
    $required_params = array('status', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # Get all of your posts from Zipline
  #
  # Required Parameters:
  # * auth_token => Your auth token
  #
  function getLine($a_parameter_hash)
  {
    $method = 'zooomr.zipline.getLine';
    
    $required_params = array('auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
}
?>