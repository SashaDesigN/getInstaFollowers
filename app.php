<?php

# get Instagram API
include __DIR__.'/vendor/Instagram-API/src/Instagram.php';
# get MongoDB connection
include __DIR__.'/vendor/Database.php';
# get users data (login, pass, logs)
$users = json_decode(file_get_contents(__DIR__.'/vendor/accounts.json'));
# get config file
# here we will save pagination cursor for Instagram API
# and count of scraped followers
$config = json_decode(file_get_contents(__DIR__.'/config.json'));

# set current user - this is only variable name and will use as key, not a real Insta nickname
$config->current = 'alex';

# new Instagram API instance
$I = new Instagram(
  $users->{$config->current}->name,
  $users->{$config->current}->password
);

# each account have a personal table with it followers
$followers = $db->selectCollection('insta_'.$config->current);

# recursive function which will paginate followers list
function makeRequest(){
  echo "\nmake request";
  global $config, $I, $followers, $users;
  # get cursor
  $next = $config->account->{$config->current}->next == '' ? null : $config->account->{$config->current}->next;
  # make API request with current cursor
  $req = $I->getUserFollowers($users->{$config->current}->id, $next);
  # parse response
  if(isset($req['users']) && is_array($req['users']) && count($req['users'])){
    # save users to db
    for($i=0,$c=count($req['users']);$i<$c;$i++){
      # check if this user not exists
      $check = $followers->findOne(['username' => $req['users'][$i]['username'] ]);
      if(!isset($check['pk'])){
        # user is new - save it
        $account = [
          'pk' => $req['users'][$i]['pk'],
          'username' => $req['users'][$i]['username'],
          'actions' => []
        ];
        $followers->insert($account);
      }
      # increase count of scraped followers
      $config->account->{$config->current}->log->count++;
    }
    # save cursor if it exists
    if(isset($req['next_max_id'])){
      # change it value in config
      $config->account->{$config->current}->next = $req['next_max_id'];
      # save config
      file_put_contents('config.json',json_encode($config));
      echo "\ndone ".$config->account->{$config->current}->log->count;
      # recursion to simulate pagination
      makeRequest();
    } else {
      # all is done
      # but we still must update config to save log->count value
      file_put_contents('config.json',json_encode($config));

      # here you can do call of your callback function
      echo "all is done";
    }
  }
}

makeRequest();

?>
