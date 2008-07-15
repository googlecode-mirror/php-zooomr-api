<?php

#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/
include_once 'Zooomr.php';

# Auth routines
class ZooomrAuth
{  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI object
  #
  function ZooomrAuth($a_zooomr_api)
  {
    if (null == $a_zooomr_api)
    {
      throw new Exception("ZooomrAuth requires a ZooomrAPI object");
    }
    // create a reference inside the global array $globalref
    //global $globalref;
    //$globalref[] = &$this;
    
    $this->zooomr = $a_zooomr_api;
  }
  
  ###############################################
	# Call the zooomr.auth.getFrob method
	#
	function getFrob()
  {
    $method    = 'zooomr.auth.getFrob';
    
    $params    = array(  'api_key' => $this->zooomr->api_key );
    
    return $this->zooomr->call_method($method, $params);
  }
	
	
	###############################################
	# Call the zooomr.auth.getToken method
	#
	# Required Parameters:
	# * frob => a frob to get the token with (must have authed with zooomr first)
	#
  function getToken($a_parameter_hash)
  {
    $method    = 'zooomr.auth.getToken';
    
    $required_params = array('frob');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
  
  ###############################################
	# Call the zooomr.auth.checkToken method
	#
	# Required Parameters:
	# * token  => token to check
	#
  function checkToken($a_parameter_hash)
  {  
    $method = 'zooomr.auth.checkToken';
    
    $required_params = array('auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
}
?>