<?php

#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.php';
//require 'date'
include_once 'Zooomr.Photos.Comments.php';
include_once 'Zooomr.Photos.Geo.php';
include_once 'Zooomr.Photos.License.php';
include_once 'Zooomr.Photos.Notes.php';
include_once 'Zooomr.Photos.Transform.php';

# Photo methods
class ZooomrPhotos
{
  //attr_accessor :comments, :geo, :licenses, :notes, :transform
  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI object
  #
  function ZooomrPhotos($a_zooomr_api)
  {
    if (null == $a_zooomr_api)
    {
      throw new Exception("ZooomrPeople requires a ZooomrAPI object");
    }
    
    $this->zooomr       = $a_zooomr_api;
    $this->comments     = new ZooomrPhotosComments($a_zooomr_api);
    $this->geo          = new ZooomrPhotosGeo($a_zooomr_api);
    $this->licenses     = new ZooomrPhotosLicense($a_zooomr_api);
    $this->notes        = new ZooomrPhotosNotes($a_zooomr_api);
    $this->transform    = new ZooomrPhotosTransform($a_zooomr_api);
  }

  # Get sizes of an image (contains links)
  #
  # Required Parameters:
  # * photo_id => ID of the photo you want the sizes for
  # * auth_token => your auth token
  #
  function getSizes($a_parameter_hash)
  {
    $method = 'zooomr.photos.getSizes';
    
    $required_params = array('photo_id', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }

  # Add tags to a photo
  #
  # Required Parameters:
  # * photo_id => photo to add tags to
  # * tags => array of tags (must be an array)
  # * auth_token => your auth token
  #
  function addTags($a_parameter_hash)
  {
    $method = 'zooomr.photos.addTags';
    
    $required_params = array('photo_id', 'tags', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    if (!is_array($a_parameter_hash['tags']))
    {
      throw new Exception("ZooomrPhotos.addTags:: tags must be an array");
    }
    
    $a_parameter_hash['tags'] = "\"" . join("\" \"", $a_parameter_hash['tags']) . "\"";
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # Delete a photo
  #
  # Required Parameters:
  # * photo_id => photo you want to delete
  # * auth_token => your auth token
  #
  function delete($a_parameter_hash)
  {
    $method = 'zooomr.photos.delete';
    
    $required_params = array('photo_id', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # Get next and previous for a photo
  #
  # Required Parameters:
  # * photo_id => photo you want to know next and prev for
  #
  function getContext($a_parameter_hash)
  {
    $method = 'zooomr.photos.getContext';
    
    $required_params = array('photo_id');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
  
  # Get favorites for a photo
  #
  # Required Parameters:
  # * photo_id => photo you want the favs for
  #
  # Optional Parameters:
  # * page => page of results you want
  # * per_page => number of results per page
  #
  function getFavorites($a_parameter_hash)
  {
    $method = 'zooomr.photos.getFavorites';
    
    $required_params = array('photo_id');
    $optional_params = array('page', 'per_page');
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
  
  # Get info about a photo
  #
  # Required Parameters:
  # * photo_id => photo you want info for
  #
  # Optional Parameters:
  # * secret => secret photo id, perms checking skipped if this is set and correct
  #
  function getinfo($a_parameter_hash)
  {
    $method = 'zooomr.photos.getinfo';
    
    $required_params = array('photo_id');
    $optional_params = array('secret');
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
  
  # Get a users recent photos
  #
  # Required Parameters:
  # * none
  #
  # Optional Parameters:
  # * extras => extra info to return
  # * page => page of results
  # * per_page => number of results per page
  #
  function getRecent($a_parameter_hash = null)
  {
    $method = 'zooomr.photos.getRecent';
    
   $required_params  = null;
   $optional_params = array('extras', 'page', 'per_page');
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    
    if (null != $a_parameter_hash)
    {
      $params = array_merge($params, $a_parameter_hash);
    }
    
    return $this->zooomr->call_method($method, $params);
  }
  
  # Get your recently updated photos from a given time
  #
  # Required Parameters:
  # * min_date => ruby date object
  # * auth_token => your auth token
  #
  # Optional Parameters:
  # * extras => extra info to return
  # * page => page of results required
  # * per_page => how many results per page
  #
  function recentlyUpdated($a_parameter_hash)
  {  
    $required_params = array('min_date', 'auth_token');
    $optional_params = array('extras', 'page', 'per_page');
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    
    if (!(is_a($a_parameter_hash['min_date'], 'DateTime')))
    {
      $type = get_class($a_parameter_hash['min_date']);
      var_dump($a_parameter_hash['min_date']);
      throw new Exception("Zooomr.photos.recentlyUpdated requires a DateTime object for min_date, not a " . $type);
    }
    
    // nt mktime ([ int $hour [, int $minute [, int $second [, int $month [, int $day [, int $year [, int $is_dst ]]]]]]] )
    
    $unixtime = date_format($a_parameter_hash['min_date'], "U");

    $a_parameter_hash['min_date'] = $unixtime;
    
    $params = array_merge($params, $a_parameter_hash);
    
    $method = 'zooomr.photos.recentlyUpdated';
    
    return $this->zooomr->call_method($method, $params);
  }
  
  # Remove a tag from a photo
  #
  # Required Parameters:
  # * tag_id => ID of the tag you want to remove
  # * photo_id => ID of the photo you want to remve the tag from
  #
  function removeTag($a_parameter_hash)
  {
    $method = 'zooomr.photos.removeTag';
    
    $required_params = array('tag_id', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # Search photos
  #
  # Required Parameters:
  # * query => query string
  #
  # Optional Parameters:
  # * extras => extra info to return
  # * page => page of results you want
  # * per_page => how many results per page
  #
  function search($a_parameter_hash)
  {
    $method = 'zooomr.photos.search';
    
    $required_params = array('query');
    $optional_params = array('extras', 'page', 'per_page');
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
  
  # Set meta information for a photo
  #
  # Required Parameters:
  # * photo_id => photo you want to set meta info for
  # * title => title
  # * description => description
  # * auth_token => your auth token
  #
  function setMeta($a_parameter_hash)
  {
    $method = 'zooomr.photos.setMeta';
    
    $required_params = array('photo_id', 'title', 'description', 'auth_token');
    
    $this->zooomr.$params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }

  # Set permissions for a photo
  #
  # Required Parameters:
  # * photo_id => photo to set perms on
  # * is_public => 0 or 1
  # * is_friend => 0 or 1
  # * is_family => 0 or 1
  # * perm_comment => who can add comments: 0, 1, 2, 3
  # * perm_addmeta => who can add notes/tags: 0, 1, 2, 3
  # * auth_token => your auth token
  #
  function setPerms($a_parameter_hash)
  {
    $method = 'zooomr.photos.setPerms';
    
    $required_params = array('photo_id', 'is_public', 'is_friend', 'is_family', 'perm_comment', 'perm_addmeta', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
   
    return $this->zooomr->call_post_method($method, $params);
  }
}
?>

