<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/


# Class to handle responses from Zooomr - allows testing for false so that it can look like a boolean
class ZooomrResponse
{
  //attr_accessor :error_message, :error_code, :json_response
  
  # Constructor
  # Required Parameters:
  # * a_response => a response from Zooomr
  #
  function ZooomrResponse($a_response)
  { 
    // create a reference inside the global array $globalref
    global $globalref;
    $globalref[] = &$this;
    
    $this->return_code    = false;
    $this->error_message  = "ok";
    $this->error_code     = "0";
    
    if (false == $a_response)
    {  
      $this->error_message  = "No response from Zooomr!";
      $this->json_response  = json_decode("{\"stat\": \"fail\", \"code\": \"98\", \"message\": \"No response from Zooomr\" }");
    }
    else
    {  
      $this->json_response  = $a_response;
      
      if (0 == strcasecmp("ok", $a_response->stat) )
      {  
        $this->return_code    = true;
      }
      else
      {
        $this->error_code     = $a_response->code;
        $this->error_message  = $a_response->message;
      }  
    }
  }
}
?>
