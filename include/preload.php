<?php
require_once("error.php");
require_once("session.php");
require_once("user.php");

better_session_start();

//global user object for authentication

if(isset($_SESSION['userid'])){
    if($user = new User($_SESSION['userid'])){
        User::set_logged_in(true);
    }
    else{
    // user does not exist, unset session.
        User::logout();
    }
}

date_default_timezone_set('America/Los_Angeles');

ini_set('display_errors', 1 );

?>
