<?php

#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.php';
include_once 'Zooomr.Photosets.RuleSet.php';

# Create and Edit photosets
class ZooomrPhotosets
{  
  # Constructor
  #
  # a_zooomr_api => a ZooomrRestAPI object
  #
  function ZooomrPhotosets($a_zooomr_api)
  {
    if (null == $a_zooomr_api)
    {
      throw new Exception("ZooomrPhotosets requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }
  
  # Create a photoset
  #
  # Required Parameters:
  # * title => title for the photoset
  # * description => desciption for the photoset
  # * primary_photo_id => ID of the photo to use for a cover photo
  # * ruleset => a ZooomrPhotosetRuleSet object populated with rules
  # * context => who to match photos from, constants from ZooomrPhotosetsContext
  # * sortmode => how to sort the set contents, constants from ZooomrPhotosetsSoftMode
  # * auth_token => Your auth token
  function create($a_parameter_hash)
  {  
    $required_params = array('title', 'description', 'primary_photo_id', 'ruleset', 'context', 'sortmode', 'auth_token');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    if (!(is_a($a_parameter_hash['ruleset'], 'ZooomrPhotosetsRuleSet')))
    {
      throw new Exception("ZooomrPhotosets.create:: ruleset should be a ZooomrPhotosetsRuleSet object!");
    }
    
    # build the ruleset
    $rules = "";
    $rule_array = $a_parameter_hash['ruleset']->rule_array;
    
    foreach ($rule_array as $rule)
    {
      if(null != rule)
      {
        $rules .= $rule->match_type . "|" . $rule->match_args . "|" . $rule->match_test . "\n";
      }
    }
    
    $method = 'zooomr.photosets.create';
    
    unset($a_parameter_hash['ruleset']); 
    
    $params = array(  'api_key' => $this->zooomr->api_key,
                      'rules'   => $rules);
    
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # delete a photoset
  #
  # Required Parameters:
  # * photoset_id - ID of the photoset to delete
  # * auth_token - your auth token
  #
  function delete($a_parameter_hash)
  {
    $method = 'zooomr.photosets.delete';
    
    $required_params = array('photoset_id', 'auth_token');
   
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key' => $this->zooomr->api_key );
    
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # Edit a photoset
  #
  # Required Parameters:
  # * photoset_id => ID for the photoset you want to edit
  # * title => title for the photoset
  # * auth_token => Your auth token
  #
  # Optional Parameters:
  # * description => desciption for the photoset
  # * primary_photo_id => ID of the photo to use for a cover photo
  # * ruleset => a ZooomrPhotosetRuleSet object populated with rules
  # * context => who to match photos from, constants from ZooomrPhotosetsContext
  # * sortmode => how to sort the set contents, constants from ZooomrPhotosetsSoftMode
  # 
  function edit($a_parameter_hash)
  {  
    $required_params = array('photoset_id' , 'title', 'auth_token');
    $optional_params = array('description', 'primary_photo_id', 'ruleset', 'context', 'sortmode');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    
    if (array_key_exists('ruleset', $a_parameter_hash))
    {
      if (!(is_a($a_parameter_hash['ruleset'], 'ZooomrPhotosetsRuleSet')))
      {
        throw new Exception("ZooomrPhotosets.edit:: a_ruleset should be a ZooomrPhotosetsRuleSet object!");
      }
       
      # build the ruleset if there is one
      $rules = "";
      $rule_array = $a_parameter_hash['ruleset']->rule_array;
      
      foreach ($rule_array as $rule)
      {
        if(null != rule)
        {
          $rules .= $rule->match_type . "|" . $rule->match_args . "|" . $rule->match_test . "\n";
        }
      }
      $a_parameter_hash['rules'] = $rules;
    }
    
    unset($a_parameter_hash['ruleset']); 
    
    $method = 'zooomr.photosets.edit';
    
    $params = array(  'api_key' => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_post_method($method, $params);
  }
  
  # Get info about a photoset
  #
  # Required Parameters:
  # * photoset_id => photoset to get info for
  #
  function getInfo($a_parameter_hash)
  {
    $method = 'zooomr.photosets.getInfo';
    
    $required_params = array('photoset_id');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
  
  # Get a list of photosets for a user
  #
  # Required Parameters:
  # * user_id => user id you want the photosets for
  #  
  function getList($a_parameter_hash)
  {
    $method = 'zooomr.photosets.getList';
    
    $required_params = array('user_id');
    
    $this->zooomr->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
  
  # Get photos from a photoset
  #
  # Required Parameters:
  # * photoset_id => ID of the photoset you want the images from
  #
  # Optional Parameters:
  # * page => page you want
  # * per_page => number of photos per page
  #
  function getPhotos($a_parameter_hash)
  {
    $method = 'zooomr.photosets.getPhotos';
    
    $required_params = array('photoset_id');
    $optional_params = array('page', 'per_page');
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->zooomr->api_key );
    $params = array_merge($params, $a_parameter_hash);
    
    return $this->zooomr->call_method($method, $params);
  }
}
?>
