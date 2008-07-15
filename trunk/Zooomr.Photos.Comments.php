<?php

#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.php';

# Manipulate comments for photos
class ZooomrPhotosComments
{  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI object
  #
  function ZooomrPhotosComments($a_zooomr_api)
  {
    if (null == a_zooomr_api)
    {
      throw new Exception("ZooomrPhotosComments requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }
  
  # Add a comment to a photo
  #
  # Required Parameters:
  # * photo_id => a photo to add a comment for
  # * comment_text => comment
  # * auth_token => your auth token
  #
  function addComment($a_parameter_hash)
  {
    $method = 'zooomr.photos.comments.addComment';
    
    $required_params = array('auth_token', 'photo_id', 'comment_text');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # delete a comment
  #
  # Required Parameters:
  # * comment_id => comment to delete
  # * auth_token => your auth token
  #
  function deleteComment($a_parameter_hash)
  {
    $method = 'zooomr.photos.comments.deleteComment';
    
    $required_params = array('comment_id', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # Edit a comment
  #
  # Required Parameters:
  # * comment_id => comment to edit
  # * comment_text => new comment text
  # * auth_token => your auth token
  #
  function editComment($a_parameter_hash)
  {
    $method = 'zooomr.photos.comments.editComment';
    
    $required_params = array('comment_id', 'auth_token', 'comment_text');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # Get a list of comments for a photo
  #
  # Required Parameters:
  # * photo_id => photo you want the comments for
  #
  function getList($a_parameter_hash)
  {
    $method = 'zooomr.photos.comments.getList';
    
    $required_params = array('photo_id');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }

}
?>