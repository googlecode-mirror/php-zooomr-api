<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.Photosets.RuleSet.php';

# A Views rule for a photoset
class ZooomrPhotosetsRuleSetViews extends ZooomrPhotosetsRuleSetBase
{
 
  # Constructor
  #
  # Required Parameters:
  # * match_test - one the provided constants above
  # * views - the number of views to test against
  #
  # Returns:
  # * a new object to be added to the ZooomrPhotosetRuleSet object
  #
  function ZooomrPhotosetsRuleSetViews($a_parameter_hash)
  {
    include 'Zooomr.Constants.php';
    
    $required_params = array('match_test', 'views');
    
    ZooomrPhotosetsRuleSet::params_are_valid($required_params, null, $a_parameter_hash);
    
    if (  ($a_parameter_hash['match_test'] != $VIEWS_EQUALTO) and
          ($a_parameter_hash['match_test'] != $VIEWS_NOTEQUALTO) and
          ($a_parameter_hash['match_test'] != $VIEWS_GREATERTHAN) and
          ($a_parameter_hash['match_test'] != $VIEWS_LESSTHAN)
        )
    {
      throw new Exception("ZooomrPhotosetsRuleSetView: a_match constant not a recognised value");
    }
      
    $this->match_test = $a_parameter_hash['match_test'];
    $this->match_type = $PHOTOSETMATCH_VIEWS;
    $this->match_args = $a_parameter_hash['views'];
  }
}
