<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.php';

# Test API methods - all methods return a ZooomrResponse object
class ZooomrTest
{  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI instance
  function ZooomrTest($a_zooomr_api)
  {
    if (null == a_zooomr_api)
    {
      throw new Exception("ZooomrTest requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }
  
  # echo the parameters passed to Zooomr
  #
  # Required Parameters:
  # * none
  # Optional Parameters:
  # * anything you like!!
  #
  function echo_call($a_parameter_hash = array() )
  {
    $method = 'zooomr.test.echo';
                
    return $this->zooomr->call_method($method, $a_parameter_hash);
  }
  
  # show your current login info
  #
  # Required Parameters:
  # * auth_token => Your auth token
  #
  function login($a_parameter_hash)
  {
    $method = 'zooomr.test.login';
    
    $required_params = array('auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
}
