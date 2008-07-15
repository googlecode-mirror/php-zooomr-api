<?php
 
  // Internal method for checking if the passed hash of params is acceptable to a given methods parameter list
  function static_params_are_valid($a_array_of_required_params, $a_array_of_extra_allowed_param_names, $a_hash_of_params_and_values)
  {  
    if ( null == $a_array_of_required_params )
    {
      $a_array_of_required_params = array();
    }
    
    # get the keys
    $array_of_passed_params = array();
    if( null != $a_hash_of_params_and_values )
    {
      $array_of_passed_params = array_keys($a_hash_of_params_and_values);
    }
    
    if ( null != $a_array_of_required_params )
    {
      ksort($a_array_of_required_params);
      
      # check that all the required params are in the hash
      $missing_required_params = array_diff_key($a_array_of_required_params, $array_of_passed_params);
      
      if (sizeof($missing_required_params) != 0)
      {
        throw new Exception("Zooomr::params_are_valid missing  required parameter(s) " . join(",", $missing_required_params) . " was passed: " . print_r($a_hash_of_params_and_values));
        return false;
      }
    }
    
    if ( null == $a_hash_of_params_and_values && null == $a_array_of_extra_allowed_param_names)
    {
      # don't worry about it if they're both nil
    }
    elseif( (!null == $a_array_of_extra_allowed_param_names) )
    {
      # check that there aren't any extra ones we weren't expecting
      ksort($a_array_of_extra_allowed_param_names);
      
      # make sure we've removed the mandatory ones
      $extra_params = $array_of_passed_params;
      if( null != $a_array_of_required_params )
      {
        $extra_params = array_diff($array_of_passed_params, $a_array_of_required_params);
      }
          
      ksort($extra_params);
      
      $unrecognised_params = array_diff($extra_params, $a_array_of_extra_allowed_param_names);
      
      if (0 != sizeof($unrecognised_params))
      {
        throw new Exception("Zooomr::params_are_valid unrecognised parameter(s) " . join(",", $unrecognised_params));
        return false;
      }
    }
  }

?>
