<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.Photosets.RuleSet.php';

# A PeopleTag rule for a photoset
class ZooomrPhotosetsRuleSetPeopleTags extends ZooomrPhotosetsRuleSetBase
{  
  
  # Constructor
  #
  # Required Parameters:
  # * match_test - one the provided constants above
  # * people_tags - array of people tags to test against
  #
  # Returns:
  # * a new object to be added to the ZooomrPhotosetRuleSet object
  #
  function ZooomrPhotosetsRuleSetPeopleTags($a_parameter_hash)
  {
    include 'Zooomr.Constants.php';
    
    $required_params = array('match_test', 'people_tags');
    
    ZooomrPhotosetsRuleSet::params_are_valid($required_params, null, $a_parameter_hash);
    
    if (
        ($a_parameter_hash['match_test'] != $PEOPLETAG_MATCHALLOF) and
        ($a_parameter_hash['match_test'] != $PEOPLETAG_MATCHANYOF) and
        ($a_parameter_hash['match_test'] != $PEOPLETAG_MATCHNONEOF)
       )
    {
        throw new Exception("ZooomrPhotosetsRuleSetPeopleTags: a_match constant not a recognised value");
    }
    
    if (!(is_array($a_parameter_hash['people_tags'])))
    {
      throw new Exception("ZooomrPhotosetsRuleSetPeopleTags: match_args must be an array");
    }
      
    $this->match_test = $a_parameter_hash['match_test'];
    $this->match_type = $PHOTOSETMATCH_PEOPLETAG;
    $this->match_args = join(",", $a_parameter_hash['people_tags']);
  }
}
?>