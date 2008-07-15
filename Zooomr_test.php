<?php

//This work is licenced under http://creativecommons.org/licenses/GPL/2.0/

include 'Zooomr.php';


function get_user_input($a_message)
{
  print ($a_message . "\n");
  $stdin = fopen('php://stdin', 'r');   
  $input = fgets($stdin);
  
  return $input;
}

$zooomr = new ZooomrRestAPI('API_KEY', 'SHARED_SECRET');

$token = 'TOKEN_STRING';

$frob = $zooomr->auth->getFrob();

# check to see if we need to get authorisation
$response = $zooomr->auth->checkToken(array('auth_token' => $token));
#response = false

print "response ";
print_r ($response);

if (0 == strcasecmp("fail", $response->json_response->stat) )
{    
  $link_hash = $zooomr->authenticate_application(array('perms' => "write"));
  
  print_r ($link_hash);

  get_user_input( "Follow this to authenticate: " . $link_hash['link'] );
  
  $info_hash = $zooomr->complete_authentication(array('frob' => $link_hash['frob']));
}
else
{  
  $json_resp = $response->json_response;
  $token = $json_resp->auth->_content->token;
    

  $user      = $json_resp->auth->_content->user;
  $user_id   = $user->nsid;
  $username  = $user->username;
  $fullname  = $user->fullname;
  
  print "NSID: " . $user_id . ", USERNAME: " . $username . ", FULLNAME: " . $fullname;
}

# test the upload
//$zooomr->upload->uploadPhoto(array('filename' => "/tmp/cup.jpg", 'auth_token' => $token));

$photos = $zooomr->people->getPhotos(array('user_id' => 'bluemonki', 'auth_token' => $token));
$photos = $photos->json_response;

$first_photo_id = $photos->photos->photo[0]->id;

print "First photo id: " . $first_photo_id . "\n";

$zooomr->people->getPhotos(array('user_id' => 'jonward', 'auth_token' => $token));

$sizes = $zooomr->photos->getSizes(array('photo_id' => $first_photo_id, 'auth_token' => $token));

$info = $zooomr->people->getInfo(array('user_id' => "bluemonki"));

$groups = $zooomr->people->getPublicGroups(array('user_id' => "jonward"));

$uploadStatus = $zooomr->people->getUploadStatus(array('auth_token' => $token));

# photos
$tags = array( "d d", "e e", "f f" );
$tag_resp    = $zooomr->photos->addTags(array('photo_id' => $first_photo_id, 'tags' => $tags, 'auth_token' => $token));

get_user_input( "Check that the tags 'd d', 'e e' and 'f f' have been added to the first photo");

$context     = $zooomr->photos->getContext(array('photo_id' => $first_photo_id));
$favourites  = $zooomr->photos->getFavorites(array('photo_id' => $first_photo_id));
$photo_info_resp  = $zooomr->photos->getinfo(array('photo_id' => $first_photo_id));
$photo_info = $photo_info_resp->json_response;

$dd_tag_id = $photo_info->photo->tags->tag[2]->id;
$ee_tag_id = $photo_info->photo->tags->tag[1]->id;
$ff_tag_id = $photo_info->photo->tags->tag[0]->id;

$recent      = $zooomr->photos->getRecent();


$date = date_create();
$datetimenow = date_create();
$datetime100daysago = $datetimenow;
$datetime100daysago->modify("-100 days");

print "100 days ago Date is " . $datetime100daysago->format('U') . "\n";

print "Date is " . $date->format('U') . "\n";
$recentlyupdated = $zooomr->photos->recentlyUpdated(array('min_date' => $datetime100daysago, 'auth_token' => $token));

$zooomr->photos->removeTag(array('tag_id' => $dd_tag_id, 'auth_token' => $token));
get_user_input( "Check that the tag 'd d' has been removed from the first photo");

$zooomr->photos->removeTag(array('tag_id' => $ee_tag_id, 'auth_token' => $token));
get_user_input( "Check that the tag 'e e' has been removed from the first photo");

$zooomr->photos->removeTag(array('tag_id' => $ff_tag_id, 'auth_token' => $token));
get_user_input( "Check that the tag 'f f' has been removed from the first photo");

$results = $zooomr->photos->search(array('query' => "bluemonki"));

#zooomr.photos.setMeta('photo_id' => first_photo_id, 'title' => "Using the ZAPI", 'decription' => "This meta info was set using the Zooomr REST API!", 'auth_token' => token)
$zooomr->photos->setPerms(array( 'photo_id'      => $first_photo_id,
                        'is_public'     => "1",
                        'is_friend'     => "1",
                        'is_family'     => "1",
                        'perm_comment'  => "3",
                        'perm_addmeta'  => "3",
                        'auth_token'    => $token));

# activity
$userphotos = $zooomr->activity->userPhotos(array('auth_token' => $token));
$userphotos = $zooomr->activity->userPhotos(array('auth_token' => $token, 'page' => '2', 'timeframe' => '20d', 'per_page' => '5'));

# contacts
$contacts = $zooomr->contacts->getList(array('auth_token' => $token));
$contacts = $zooomr->contacts->getList(array('auth_token' => $token, 'filter' => 'both'));
$public_contacts = $zooomr->contacts->getPublicList(array('user_id' => "bluemonki"));

# favorites
$zooomr->favorites->add(array('photo_id' => "4778592", 'auth_token' => $token));
$favs = $zooomr->favorites->getList(array('auth_token' => $token));
$favs = $zooomr->favorites->getList(array('auth_token' => $token, 'user_id' => 'jonward', 'page' => '2', 'per_page' => '5'));
$zooomr->favorites->remove(array('photo_id' => "4778592", 'auth_token' => $token));

# groups
$groupinfo = $zooomr->groups->getInfo(array('group_id' => "4@Z01", 'lang' => 'de-de'));

# comments
$comment_res = $zooomr->photos->comments->addComment(array('photo_id' => $first_photo_id, 'comment_text' =>"Test Comment", 'auth_token' => $token));
get_user_input( "Check that the a comment has been added to the first photo");

$comment_res = $comment_res->json_response;
$comment_id = $comment_res->comment->id;

$zooomr->photos->comments->editComment(array('comment_id' => $comment_id, 'comment_text' => "Edited comment", 'auth_token' => $token));
get_user_input( "Check that a comment has been edited on the first photo");

$comment_list = $zooomr->photos->comments->getList(array('photo_id' => $first_photo_id));
$zooomr->photos->comments->deleteComment(array('comment_id' => $comment_id, 'auth_token' => $token));
get_user_input( "Check that a comment has been remove from the first photo");

# geo
$zooomr->photos->geo->setLocation(array('photo_id' => $first_photo_id, 'lat' => '1', 'lon' => '1', 'auth_token' => $token));
get_user_input( "Check that a geotag has been added to the first photo");

$zooomr->photos->geo->removeLocation(array('photo_id' => $first_photo_id, 'auth_token' => $token));
get_user_input( "Check that a geotag has been removed from the first photo");

# license
$zooomr->photos->licenses->setLicense(array('photo_id' => $first_photo_id, 'license_id' => $zooomr->photos->licenses->LICENSE_CC_NON_COMMERCIAL, 'auth_token' => $token));
get_user_input( "Check that license for the first photo is CC Non-Commercial");

#photo_id_array = [4758854, 4758861, 4758866]
#tags = [ "uploaded via ZAPI", "canon 400D"]

#photo_id_array.each { |photo_id|
#  zooomr.photos.licenses.setLicense(photo_id, "5", token)
#  zooomr.photos.addTags(photo_id, tags, token)
#  }

# test tags with spaces
#tags = [ "uploaded via ZAPI", "canon 400D"];
#zooomr.photos.addTags(4734781, tags, token)


# notes
$note_doc      = $zooomr->photos->notes->add(array('photo_id' => $first_photo_id, 'note_x' => "0", 'note_y' => "0", 'note_w' => "50", 'note_h' => "50", 'note_text' => "test note", 'auth_token' => $token));
get_user_input( "Check that a note has been added to the first photo");

$note_doc      = $note_doc->json_response;
$note_id       = $note_doc->note->id;
$zooomr->photos->notes->edit(array('note_id' => $note_id, 'note_x' => "50", 'note_y' => "50", 'note_w' => "50", 'note_h' => "50", 'note_text' => "edited note text", 'auth_token' => $token));
get_user_input( "Check that a note has been edited on the first photo");

$zooomr->photos->notes->delete(array('note_id' => $note_id, 'auth_token' => $token));
get_user_input( "Check that a note has been removed from the first photo");

# transform
$zooomr->photos->transform->rotate(array('photo_id' => $first_photo_id, 'degrees' => "90", 'auth_token' => $token));
get_user_input( "Check that a rotation has been applied to the first photo");
$zooomr->photos->transform->rotate(array('photo_id' => $first_photo_id, 'degrees' => "270", 'auth_token' => $token));

# photosets
# create a rule set object
$rule_set = new ZooomrPhotosetsRuleSet();

# create a label rule object
$label_rule = new ZooomrPhotosetsRuleSetLabels(
                                               array(
                                                     "match_test" => $LABELS_MATCHNONEOF,
                                                     'labels'     => array("bluemonki")
                                                     )
                                               );

# create a views rule object
$view_rule = new ZooomrPhotosetsRuleSetViews(array('match_test' => $VIEWS_GREATERTHAN, 'views' => "100"));

# create a people tag rule
$peopletag_rule = new ZooomrPhotosetsRuleSetPeopleTags(array('match_test' => $PEOPLETAG_MATCHANYOF, 'people_tags' => array("bluemonki") ));

# create a dateuploaded rule
$dateuploaded_rule = new ZooomrPhotosetsRuleSetDateUploaded(array('min_date' => $datetime100daysago));

# create a datetaken rule
$datetaken_rule = new ZooomrPhotosetsRuleSetDateTaken(array('min_date' => $datetime100daysago));

# create a geotags rule
$geotags_rule = new ZooomrPhotosetsRuleSetGeoTags(array('lat' => 51.3827, 'lon' => -2.7191));

# add the rules to the ruleset object
$rule_set->addRule(array('rule' => $label_rule));



$rule_set->addRule(array('rule' => $view_rule));
$rule_set->addRule(array('rule' => $peopletag_rule));
$rule_set->addRule(array('rule' => $dateuploaded_rule));
$rule_set->addRule(array('rule' => $datetaken_rule));
$rule_set->addRule(array('rule' => $geotags_rule));


$photoset_doc = $zooomr->photosets->create(
                                           array(
                                                  'title'             => "photo set title",
                                                  'description'       => "description",
                                                  'primary_photo_id'  => $first_photo_id,
                                                  'ruleset'           => $rule_set,
                                                  'context'           => $PHOTOSFROM_EVERYONE,
                                                  'sortmode'          => $SORTEDBY_AWESOMENESS,
                                                  'auth_token'        => $token
                                                  )
                                          );

get_user_input( "Check that a photoset has been created");

$photoset_doc = $photoset_doc->json_response;
                
#photoset_doc = zooomr.photosets.create("Photoset title",
#                                       "description",
#                                       first_photo_id,
#                                       rule_set,
#                                       $PHOTOSFROM_EVERYONE,
#                                       $SORTEDBY_AWESOMENESS,
#                                       token)


$photoset_id = $photoset_doc->photoset->id;
$zooomr->photosets->getInfo(array('photoset_id' => $photoset_id));
$zooomr->photosets->getInfo(array('photoset_id' => "30060"));
$zooomr->photosets->getList(array('user_id' => "bluemonki"));

$zooomr->photosets->edit(array('photoset_id' => $photoset_id, 'title' => "New title", 'primary_photo_id' => $first_photo_id, 'auth_token' => $token));
get_user_input( "Check that a photoset has been edited");

$zooomr->photosets->getPhotos(array('photoset_id' => $photoset_id));
$zooomr->photosets->delete(array('photoset_id' => $photoset_id, 'auth_token' => $token));
get_user_input( "Check that a photoset has been deleted");

# tags
$photo_tags  = $zooomr->tags->getListPhoto(array('photo_id' => $first_photo_id));
$user_tags   = $zooomr->tags->getListUser(array('user_id' => "bluemonki"));

# test
$params = array( 'param_name' => "param_value");
$zooomr->test->echo_call($params);

$zooomr->test->login(array('auth_token' => $token));

# delete the photo
$zooomr->photos->delete(array('photo_id' => $first_photo_id, 'auth_token' => $token));
get_user_input( "Check that the first photo has been deleted");

# test zipline
$zooomr->zipline->postLine(array('status' => "Final testing of the PHP Zooomr API", 'auth_token' => $token));
$zooomr->zipline->getLine(array('auth_token' => $token));
get_user_input( "Check that a zipline post has been created");

?>
