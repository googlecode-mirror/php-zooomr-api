<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.Photosets.RuleSet.php';

# GeoTag rule for a photoset
class ZooomrPhotosetsRuleSetGeoTags extends ZooomrPhotosetsRuleSetBase
{  

  # Constructor
  #
  # Required Parameters:
  # * lat - latitude
  # * lon - longitude
  #
  # Optional Parameters:
  # * map_zoom_level - Zoom level for the map displayed next to the photoset
  #
  # Returns:
  # * a new object to be added to the ZooomrPhotosetRuleSet object (defaults to 3)
  #
  function ZooomrPhotosetsRuleSetGeoTags($a_parameter_hash)
  {
    include 'Zooomr.Constants.php';
    
    $required_params = array('lat', 'lon');
    $optional_params = array('map_zooom_level');
    
    ZooomrPhotosetsRuleSet::params_are_valid($required_params, $optional_params, $a_parameter_hash);
    
    if ( ! array_key_exists('map_zoom_level', $a_parameter_hash) )
    {
      $a_parameter_hash['map_zoom_level'] = 3;
    }
    
    $params = array();
    $params = array_merge($params, $a_parameter_hash);
    
    $this->match_test = "0"; # no match constant for GeoTags
    $this->match_type = $PHOTOSETMATCH_GEO;
    $this->match_args = "" . $a_parameter_hash['lat'] . "," . $a_parameter_hash['lon'] . "," . $a_parameter_hash['map_zooom_level'];
  }
}
?>