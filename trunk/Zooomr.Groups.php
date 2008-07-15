<?php

#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/
include_once 'Zooomr.php';

# Info about groups
class ZooomrGroups
{  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI object
  #
  function ZooomrGroups($a_zooomr_api)
  {
    if (null == $a_zooomr_api)
    {
      throw new Exception("ZooomrGroups requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }
  
  # Get info about a group
  #
  # Required Parameters:
  # * group_id => id of the group you want info for
  #
  # Optional Parameters:
  # * lang => language for response
  #
  function getInfo($a_parameter_hash)
  {
    $method = 'zooomr.groups.getInfo';
    
    $required_params = array('group_id');
    $optional_params = array('lang');
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
}
?>
