<?php
#This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include_once 'Zooomr.php';
//require 'rubygems'
//require 'mime/types'
//require "base64"

# Upload methods - all methods return a ZooomrResponse object
class ZooomrUpload
{  
  # Constructor
  #
  # * a_zooomr_api => a ZooomrRestAPI instance
  #
  function ZooomrUpload($a_zooomr_api)
  {
    if (null == a_zooomr_api)
    {
      throw new Exception("ZooomrFavorites requires a ZooomrAPI object");
    }
    
    $this->zooomr = $a_zooomr_api;
  }
  
  #  Upload a photo to Zooomr
  #
  #  Required Parameters:
  #  * filename => Filename of the file to upload
  #  * auth_token + Your auth token
  #  Optional Parameters:
  #  * title  => Title for image
  #  * description => Description for image
  #  * tags  => An array of tags to apply to the photo.
  #  * is_public, is_friend, is_family  => Set to 0 for no, 1 for yes. Specifies who can view the photo.
  #  * safety_level => Set to 1 for Safe, 2 for Moderate, or 3 for Restricted.
  #  * content_type => Set to 1 for Photo, 2 for Screenshot, or 3 for Other.
  #  * hidden => Set to 1 to keep the photo in global search results, 2 to hide from public searches.
  #  
  function uploadPhoto($a_parameters_hash)
  {  
    $required_params = array( 'filename', 'auth_token');
    $optional_params = array( 'title', 'description', 'tags', 'is_public', 'is_friend', 'is_family', 'safety_level', 'content_type', 'hidden');
    
    $params = array(  'api_key'         => $this->zooomr->api_key,
                      'format'          => 'json',
                      'nojsoncallback'  => 1,
             );
    
    $a_filename        = $a_parameters_hash['filename'];
    $filesize          = filesize($a_filename);
    $file              = fopen($a_filename, "rb"); #photo data
    
    if (!$file)
    {
      die ("Failed to open file " . $a_filename . "\n");
    }
    
    $this->zooomr->params_are_valid($required_params, $optional_params, $a_parameters_hash);
    
    unset($a_parameters_hash['filename']);
    
    if (array_key_exists('tags', $a_parameters_hash))
    {
      if (!(is_array( $a_parameters_hash['tags']) ))
      {
        throw new Exception("Upload:: tags should be an array!");
      }
    }
    
    $ascii_url = 'http://upload.zooomr.com/services/upload/';
    
    $params = array_merge($params, $a_parameters_hash);
    
    # create the post request
    $post_boundary = "---------------------------7d44e178b0434";
    $post_data     = "";
    
    ksort ($params);
    
    while (list($key, $value) = each($params))
    {
      $post_data .= "--" . $post_boundary . "\r\n";
      $post_data .= "Content-Disposition: form-data; name=\"" . $key . "\"\r\n\r\n";
      $post_data .= $value . "\r\n";
    }
     
    $api_sig           = $this->zooomr->create_signature($params);
    $params['api_sig'] = $api_sig;
    $params['photo']   = fread($file, $filesize);
    
    $post_data .= "--" . $post_boundary . "\r\n";
    $post_data .= "Content-Disposition: form-data; name=\"api_sig\"\r\n\r\n";
    $post_data .= $api_sig . "\r\n";

    # add the photo data
    $post_data .= "--" . $post_boundary . "\r\n";
    $post_data .= "Content-Disposition: form-data; name=\"photo\"; filename=\"" . $a_filename . "\"\r\n";
    $post_data .= "Content-Transfer-Encoding: binary\r\n";
    $post_data .= "Content-Type: ";
    
    //$post_data .= mime_content_type($a_filename);
    $post_data .= "image/jpg";
    $post_data .= "\r\n\r\n";
    $post_data .= $params['photo'] . "\r\n";
    $post_data .= "--" . $post_boundary . "--";
    
    $Curl_Session = curl_init($ascii_url);
    curl_setopt ($Curl_Session, CURLOPT_POST, 1);
    curl_setopt ($Curl_Session, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt ($Curl_Session, CURLOPT_HTTPHEADER, array("Content-type: multipart/form-data; boundary=" . $post_boundary, "Expect:") );
    
    $body = curl_exec ($Curl_Session);
    curl_close ($Curl_Session);
    
    #  jsonZooomrApi({"ticket": {"_content": "1vl8zc-15k-50N-2M-3b-16d2Hjj1y"}, "stat": "ok", "photoid": {"_content": 4808881}, "secret": {"_content": "9a472d5d15"}});
    //ereg ("jsonZooomrApi\((.*?)\);", $body, $regs);
    
    $body_without_callback = $regs[0];
    $resp_hash = json_decode($body_without_callback);

    return new ZooomrResponse($resp_hash);
  }
}
?>