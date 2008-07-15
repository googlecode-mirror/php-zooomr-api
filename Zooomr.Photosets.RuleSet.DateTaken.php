<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.Photosets.RuleSet.php';

# DateTaken rule for a photoset
class ZooomrPhotosetsRuleSetDateTaken extends ZooomrPhotosetsRuleSetBase
{  
  
  # Constructor
  #
  # Required Parameters:
  # * date - a ruby Date object
  # 
  # Returns:
  # * a new object to be added to the ZooomrPhotosetRuleSet object
  #
  function ZooomrPhotosetsRuleSetDateTaken($a_parameter_hash)
  {
    include 'Zooomr.Constants.php';
    
    $required_params = array('min_date');
    
    ZooomrPhotosetsRuleSet::params_are_valid($required_params, null, $a_parameter_hash);
    
    if (!(is_a($a_parameter_hash['min_date'], 'DateTime')))
    {
      
      throw new Exception("zooomr.photos.recentlyUpdated requires a DateTime object for min_date");
    }
    
    // nt mktime ([ int $hour [, int $minute [, int $second [, int $month [, int $day [, int $year [, int $is_dst ]]]]]]] )
    
    $unixtime = date_format($a_parameter_hash['min_date'], "U");
    
    $this->match_test = "0"; # no match test for Date Uploaded
    $this->match_type = $PHOTOSETMATCH_DATETAKEN;
    $this->match_args = $unixtime;
  }
}
?>