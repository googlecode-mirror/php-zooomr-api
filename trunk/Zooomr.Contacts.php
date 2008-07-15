<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/
include_once 'Zooomr.php';

# Manipulate a users contacts
class ZooomrContacts
{  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI object
  #
  function ZooomrContacts($a_zooomr_api)
  {
    if (null == $a_zooomr_api)
    {
      throw new Exception("ZooomrPeople requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }
  
  # Get a list of a users contacts
  #
  # Required Parameters:
  # * auth_token => your auth token
  #
  # Optional Parameters:
  # * filter => string friends,family,both
  # * page => page of results
  # * per_page => results per page
  #
  function getList($a_parameter_hash)
  {
    $method = 'zooomr.contacts.getList';
    
    $required_params = array('auth_token');
    $optional_params = array('filter', 'page', 'per_page');
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
  
  # Get a list of a users public contacts
  #
  # Required Parameters:
  # * user_id => user you want the contacts for
  #
  # Optional Parameters:
  # * page => page of results
  # * per_page => results per page
  #
  function getPublicList($a_parameter_hash)
  {
    $method = 'zooomr.contacts.getPublicList';
    
    $required_params = array('user_id');
    $optional_params = array('page', 'per_page');
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
}
?>
