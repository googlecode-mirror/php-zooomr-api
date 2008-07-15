<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.php';

# Get user info
class ZooomrPeople
{  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI object
  #
  function ZooomrPeople($a_zooomr_api)
  {
    if (null == $a_zooomr_api)
    {
      throw new Exception("ZooomrPeople requires a ZooomrAPI object");
    }
    $this->zooomr = $a_zooomr_api;
  }
  
  # Get photos for a user
  #
  # Required Parameters:
  # * user_id => user to get photos for
  # * auth_token => your auth token
  #
  function getPhotos($a_parameter_hash)
  {
    $method = 'zooomr.people.getPhotos';
    
    $required_params =  array('user_id', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
  
  # Get info about a user
  #
  # Required Parameters:
  # * user_id => user you want info about
  #
  function getInfo($a_parameter_hash)
  {
    $method = 'zooomr.people.getInfo';
    
    $required_params = array('user_id');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);

    return $this->zooomr->call_method($method, $params);
  }
  
  # Get a list of public groups for a user
  #
  # Required Parameters:
  # * user_id => user to find groups for
  #
  function getPublicGroups($a_parameter_hash)
  {
    $method = 'zooomr.people.getPublicGroups';
    
    $required_params = array('user_id');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }  
  # Get upload stats for the calling user
  #
  # Required Parameters:
  # * auth_token => your auth token
  #
  function getUploadStatus($a_parameter_hash)
  {
    $method = 'zooomr.people.getUploadStatus';
    
    $required_params = array('auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
}  
?>
