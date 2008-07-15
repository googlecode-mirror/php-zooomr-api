<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.Static.Functions.php';
#require 'json'
#require 'net/http'
#require 'digest/md5'

include_once 'Zooomr.Photos.php';
include_once 'Zooomr.People.php';
include_once 'Zooomr.Auth.php';
include_once 'Zooomr.Activity.php';
include_once 'Zooomr.Contacts.php';
include_once 'Zooomr.Favorites.php';
include_once 'Zooomr.Groups.php';
include_once 'Zooomr.Photosets.php';
include_once 'Zooomr.Tags.php';
include_once 'Zooomr.Test.php';
include_once 'Zooomr.Upload.php';
include_once 'Zooomr.Zipline.php';

include 'Zooomr.Response.php';
include 'Zooomr.Constants.php';

# Main Zooomr API Class - give access to subclasses that make it look like
# you're calling the documented methods
class ZooomrRestAPI
{
 
  //##########################################
  // Constructor
  //
  // IN:
  // * a_api_key       => your API key
  // * a_shared_secret => your shared secret
  //
  // RETURNS:
  // * new ZooomrRestAPI Object
  //
  function ZooomrRestAPI($a_api_key, $a_shared_secret)
  {
    if (null == $a_api_key)
    {
      throw new Exception("API KEY is nil");
    }
    
    if (null == $a_shared_secret)
    {
      throw new Exception("SHARED SECRET is nil");
    }
    
    $this->api_key        = $a_api_key;
    $this->shared_secret  = $a_shared_secret;
    
    $this->auth       = new ZooomrAuth($this);
    $this->people     = new ZooomrPeople($this);
    $this->photos     = new ZooomrPhotos($this);
    $this->activity   = new ZooomrActivity($this);
    $this->contacts   = new ZooomrContacts($this);
    $this->favorites  = new ZooomrFavorites($this);
    $this->groups     = new ZooomrGroups($this);
    $this->photosets  = new ZooomrPhotosets($this);
    $this->tags       = new ZooomrTags($this);
    $this->test       = new ZooomrTest($this);
    $this->upload     = new ZooomrUpload($this);
    $this->zipline    = new ZooomrZipline($this);
  }

  /*//#####################################################
  # Create the signature required for signing methods
  # see http://www.flickr.com/services/api/auth.howto.desktop.html
  # for more detialed info
  #
  # IN:
  # * a_params => a hash of parameters that are required to be passed to the method you want to call - must include the method its self
  #
  # RETURNS:
  # * a signature for the call you want to make
  #*/
  function create_signature($a_params)
  {
    # start with the shared secret
    $ascii_sig = $this->shared_secret;
    
    # append all the params in alphabetical order
    ksort ($a_params, SORT_STRING);
    
    while (list($key, $val) = each($a_params))
    {
      $ascii_sig .= $key . $val;
    }
    
    # turn it into a MD5 digest
    #puts "ASCII SIG: " + ascii_sig
    return md5($ascii_sig);
  }
  
  /*######################################################
  # Make a call to the REST api
  #
  # IN:
  # * a_method_to_call => method to call
  # * a_params => a hash of parameters that are required to be passed to the method you want to call - must NOT include the method its self
  #
  # RETURNS:
  # * false on failure, ZooomrResponse object on success
  #*/
  function call_method($a_method_to_call, $a_params)
  {
    
    $params                    = $a_params;
    $params['method']          = $a_method_to_call;
    $params['format']          = 'json';
    $params['nojsoncallback']  = 1;
    
    $api_sig = $this->create_signature($params);
    
    $ascii_url = 'http://api.zooomr.com/services/rest?method=' . $a_method_to_call . '&api_sig=' . $api_sig;
    
    ksort ($params, SORT_STRING);
    
    while (list($key, $val) = each($params))
    {
      $ascii_url .= '&' . $key . '=' . $val;
    }
    
		$url = urlencode($ascii_url);
		
    //print "ASCII URL: " . $ascii_url . "\n";
      
    $req = "";
    
    $handle = fopen($ascii_url, 'r');
    
    while(!feof($handle))
    {
      $req .= (fgets($handle, 1024));
    }

    fclose($handle);
    
    # check that we got a response
    //if (false == req)
    //{
    //  return false;
    //}
    
    //print "METHOD: " . $params['method'] . "\n";
    //print "RESPONSE: " . $req . "\n\n";

    $resp_hash = json_decode($req);
    
    //print_r ($resp_hash);

    return new ZooomrResponse($resp_hash);
  }
  
  
  /*######################################################
  # Make a call to the REST api
  #
  # IN:
  # * a_method_to_call => method to call
  # * a_params => a hash of parameters that are required to be passed to the method you want to call - must NOT include the method its self
  #
  # RETURNS:
  # * false on failure, ZooomrResponse document of the response on success
  #*/
  function call_post_method($a_method_to_call, $a_params)
  {  
    $a_params['method']          = $a_method_to_call;
    $a_params['format']          = 'json';
    $a_params['nojsoncallback']  = 1;
    
    $api_sig = $this->create_signature($a_params);
    
    $a_params['api_sig'] = $api_sig;
    
    $ascii_url = 'http://api.zooomr.com/services/rest?';
    
    ksort ($a_params, SORT_STRING);
    
    $params_string = "";
    
    while (list($key, $val) = each($a_params))
    {
      $params_string .= '&' . $key . '=' . (($val));
    }
    
    $params_string = ($params_string);
     
    //print "ASCII URL: " . $ascii_url . "\n";
    //print "POST PARAMS STRING: " . $params_string . "\n";
    
    $Curl_Session = curl_init($ascii_url);
    curl_setopt ($Curl_Session, CURLOPT_POST, 1);
    curl_setopt ($Curl_Session, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($Curl_Session, CURLOPT_POSTFIELDS, $params_string);
    
    $body = curl_exec ($Curl_Session);
    curl_close ($Curl_Session);
    
    if (false == req)
    {
      # this is what we expect from a post that worked
      $resp_hash = json_decode("{\"stat\": \"ok\"}");
      
      return new ZooomrResponse($resp_hash);
    }
    
    //print "RESPONSE: " . $body . "\n";

    $resp_hash = json_decode($body);
    
    //print_r ($resp_hash);

    return new ZooomrResponse($resp_hash);
  }
	
	
	
	/*###############################################
	# Start the authentication process, return a link that
	# the user needs to follow to tick the relavent box
	#
	# Required Parameters:
	# *  a_perms - "read" or "write"
	# RETURNS:
	# * ZooomrResponse object on failure to get frob, or a hash of:
	# *  frob => frob to use with getToken/complete_authentication after the link is followed
	# *  link => http link for the user to follow to allow the access)
	#*/
	function authenticate_application($a_parameter_hash)
	{
	  $required_params = array('perms');
    
    $this->params_are_valid($required_params, null, $a_parameter_hash);
    
    $response = $this->auth->getFrob();
    
    if (false == $response)
    {  
      return $response;
    }
    else
    {  
      $json = $response->json_response;
      $frob = $json->frob;
      
      $params = array( 'frob' => $frob );
      $params = array_merge($params, $a_parameter_hash);
      
      $link = $this->create_login_link($params);
      return array('frob' => $frob, 'link' => $link);
    }
  }
	
	/*################################################
	# Finishes the authentication process by calling
	# get_token
	#
	# Required Parameters:
	# * frob - frob from get_frob/authentication application
	# RETURNS:
	# * ZooomrResponse object
	#*/
	function complete_authentication($a_parameter_hash)
  {  
    $required_params = array('frob');
    
    $this->params_are_valid($required_params, null, $a_parameter_hash);
    
    return $this->auth->getToken($a_parameter_hash);
  }
	
	/*######################################################
  # Create a auth link for the user to follow to allow this app
  #
  # Required Parameters:
  # * frob - frob to use
  # * perms - "read" or "write"
  #
  # RETURNS:
  # * a URL that the user must follow in order to allow the app
  #*/
  function create_login_link($a_parameter_hash)
  {  
    $required_params = array('perms', 'frob');
    
    $this->params_are_valid($required_params, null, $a_parameter_hash);
    
    $params = array(  'api_key'     => $this->api_key );
    $params = array_merge( $params, $a_parameter_hash);
    
    $api_sig = $this->create_signature($params);
    
    $login_link = "http://www.zooomr.com/services/auth/?api_key=" . $this->api_key . "&api_sig=" . $api_sig . "&frob=" . $a_parameter_hash['frob'] . "&perms=" . $a_parameter_hash['perms'];
    
    return $login_link;
  }
  
  //# calls ZooomrRestAPI.params_are_valid  
  function params_are_valid($a_array_of_required_params, $a_array_of_extra_allowed_param_names, $a_hash_of_params_and_values)
  {
    static_params_are_valid($a_array_of_required_params, $a_array_of_extra_allowed_param_names, $a_hash_of_params_and_values);
  }
}

?>
