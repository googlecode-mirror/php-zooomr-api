<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.Photosets.RuleSet.php';

# Label rule object for a photoset
class ZooomrPhotosetsRuleSetLabels extends ZooomrPhotosetsRuleSetBase
{  
  
  # Constructor
  #
  # Required Parameters:
  # * match_test - one the provided constants above
  # * labels - array of labels to test against
  #
  # Returns:
  # * a new object to be added to the ZooomrPhotosetRuleSet object
  #
  function ZooomrPhotosetsRuleSetLabels($a_parameter_hash)
  {
    include 'Zooomr.Constants.php';
    
    $required_params = array('match_test', 'labels');
    
    ZooomrPhotosetsRuleSet::params_are_valid($required_params, null, $a_parameter_hash);
    
    if  (
              ($a_parameter_hash['match_test'] != $LABELS_MATCHALLOF) and
              ($a_parameter_hash['match_test'] != $LABELS_MATCHANYOF) and
              ($a_parameter_hash['match_test'] != $LABELS_MATCHNONEOF)
            )
    {
        throw new Exception("ZooomrPhotosetsRuleSetLabel: match_test not a recognised value");
    }
    
    if (! is_array($a_parameter_hash['labels']) )
    {
      throw new Exception("ZooomrPhotosetsRuleSetLabel: match_args must be an array");
    }
    
    
    $this->match_test = $a_parameter_hash['match_test'];
    $this->match_type = $PHOTOSETMATCH_LABEL;
    $this->match_args = join($a_parameter_hash['labels'], ",");
  }
}
?>
