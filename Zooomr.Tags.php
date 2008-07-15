<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.php';

# Tag manipulation methods - all methods return a ZooomrResponse object
class ZooomrTags
{  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI instance
  function ZooomrTags($a_zooomr_api)
  {
    if (null == a_zooomr_api)
    {
      throw new Exception("ZooomrTags requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }
  
  # Get a list of tags for a photo
  #
  # Required Parameters:
  # * photo_id => the ID of the photo you want the tags for
  #
  function getListPhoto($a_parameter_hash)
  {
    $method = 'zooomr.tags.getListPhoto';
    
    $required_params = array('photo_id');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
  
  # Get a list of tags used by the user
  #
  # Required Parameters:
  # * user_id => the user id you want to know the tags for
  #  
  function getListUser($a_parameter_hash)
  {
    $method = 'zooomr.tags.getListUser';
    
    $required_params = array('user_id');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
}
?>