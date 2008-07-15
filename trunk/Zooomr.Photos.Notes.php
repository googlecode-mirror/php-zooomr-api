<?php

#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/
include_once 'Zooomr.php';

# Manipulate notes on photos
class ZooomrPhotosNotes
{
  function ZooomrPhotosNotes($a_zooomr_api)
  {
    if (a_zooomr_api == null)
    {
      throw new Exception("ZooomrPhotosNotes requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }
  
  # Add a note to a photo
  #
  # Required Parameters:
  # * photo_id => a photo to add a note to
  # * note_text => text of the note
  # * note_x => The left coordinate of the note
  # * note_y => The top coordinate of the note
  # * note_w => The width of the note
  # * note_h => The height of the note
  # * auth_token => your auth token
  #
  function add($a_parameter_hash)
  {
    $method = 'zooomr.photos.notes.add';
    
    $required_params = array('photo_id', 'note_x', 'note_y', 'note_w', 'note_h', 'note_text', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # Edit a note on a photo
  #
  # Required Parameters:
  # * note_id => note to edit
  # * note_text => text of the note
  # * note_x => The left coordinate of the note
  # * note_y => The top coordinate of the note
  # * note_w => The width of the note
  # * note_h => The height of the note
  # * auth_token => your auth token
  #
  function edit($a_parameter_hash)
  {
    $method = 'zooomr.photos.notes.edit';
    
    $required_params = array('note_id', 'note_x', 'note_y', 'note_w', 'note_h', 'note_text', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # delete a note
  #
  # Required Parameters:
  # * note_id => note to delete
  # * auth_token => your auth token
  #
  function delete($a_parameter_hash)
  {
    $method = 'zooomr.photos.notes.delete';
    
    $required_params = array('note_id', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
}
?>
