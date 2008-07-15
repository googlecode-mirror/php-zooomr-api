<?php

#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/
include_once 'Zooomr.php';

# Manipulate a users favorites
class ZooomrFavorites
{  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI object
  #
  function ZooomrFavorites($a_zooomr_api)
  {
    if (null == a_zooomr_api)
    {
      throw new Exception("ZooomrFavorites requires a ZooomrAPI object");
    }
    $this->zooomr = $a_zooomr_api;
  }
  
  # Add a photo as a fave
  #
  # Required Parameters:
  # * photo_id => photo to add as a fave
  # * auth_token => your auth token
  #
  function add($a_parameter_hash)
  {
    $method = 'zooomr.favorites.add';
    
    $required_params = array('auth_token', 'photo_id');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # Get a list of faves for a user
  #
  # Required Parameters:
  # * auth_token => your auth token
  #
  # Optional Parameters:
  # * user_id => user you want the faves for (functionaults to calling user)
  # * extras => extra info to return
  # * page => page of results
  # * per_page => results per page
  #  
  function getList($a_parameter_hash)
  {
    $method = 'zooomr.favorites.getList';
    
    $required_params = array('auth_token');
    $optional_params = array('user_id', 'page', 'per_page', 'extras');
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
  
    return $this->zooomr->call_method($method, $params);
  }
  
  # Remove a photo from your faves
  #
  # Required Parameters:
  # * photo_id => photo to remove as a fave
  # * auth_token => your auth token
  function remove($a_parameter_hash)
  {
    $method = 'zooomr.favorites.remove';
    
    $required_params = array('auth_token', 'photo_id');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
}
?>
