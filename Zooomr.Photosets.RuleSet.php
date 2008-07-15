<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.Constants.php';

# Base object for photoset rules - don't construct
class ZooomrPhotosetsRuleSetBase
{  
  function ZooomrPhotosetsRuleSetBase()
  {
    throw new Exception("ZooomrPhotosetsRuleSetBase: don't construct me I'm just a base class!");
  }
}

include_once 'Zooomr.Photosets.RuleSet.Labels.php';
include_once 'Zooomr.Photosets.RuleSet.Views.php';
include_once 'Zooomr.Photosets.RuleSet.PeopleTags.php';
include_once 'Zooomr.Photosets.RuleSet.DateUploaded.php';
include_once 'Zooomr.Photosets.RuleSet.DateTaken.php';
include_once 'Zooomr.Photosets.RuleSet.GeoTags.php';


# RuleSet object, add ZooomrPhotosetsRuleSetLabels, ZooomrPhotosetsRuleSetViews,
# ZooomrPhotosetsRuleSetPeopleTags, ZooomrPhotosetsRuleSetGeoTags, ZooomrPhotosetsRuleSetDateUploaded,
# ZooomrPhotosetsRuleSetDateTaken objects to this and then use it in the construction of a photoset
#
# You can only have one of each!
class ZooomrPhotosetsRuleSet
{  
  # Constructor - takes no arguments
  function ZooomrPhotosetsRuleSet()
  {
    $this->rule_array = array();
    $this->rule_array = array_pad($this->rule_array, 9, null);
  }
  
  # Add a rule
  #
  # Required Parameters:
  # * rule => one of ZooomrPhotosetsRuleSetLabels, ZooomrPhotosetsRuleSetViews, ZooomrPhotosetsRuleSetPeopleTags, ZooomrPhotosetsRuleSetGeoTags, ZooomrPhotosetsRuleSetDateUploaded, ZooomrPhotosetsRuleSetDateTaken
  #
  function addRule($a_parameter_hash)
  {
    $required_params = array('rule');
    
    ZooomrRestAPI::params_are_valid($required_params, null, $a_parameter_hash);
    
    if (!(is_a($a_parameter_hash['rule'], 'ZooomrPhotosetsRuleSetBase')))
    {
      throw new Exception("ZooomrPhotosetsRuleSet.addRule only takes a ZooomrPhotosetsRuleSetBase derived object!");
    }
    
    $this->rule_array[$a_parameter_hash['rule']->match_type] = $a_parameter_hash['rule'];
  }
  
  # Another wrapper that just calls ZooomrRestAPI.params_are_valid
  function params_are_valid($a_array_of_required_params = array(), $a_array_of_extra_allowed_param_names = array(), $a_hash_of_params_and_values = array())
  {
    ZooomrRestAPI::params_are_valid($a_array_of_required_params, $a_array_of_extra_allowed_param_names, $a_hash_of_params_and_values);
  }
}
?>