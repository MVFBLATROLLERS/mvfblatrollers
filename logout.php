<?php
$title = "Logout";

require_once("header.php"); /* add text here */

if(User::is_logged_in()){
    //code goes here
    User::logout();
    echo <<<LOGOUT
    <p>You have been logged out. Have a nice day.</p>
LOGOUT;
}
else{
    echo<<<NOTLOGGEDIN
    <div id="not_logged_in_warning">
    You must be logged in to logout.
    <a href="login.php" id="not_logged_in_warning_login_link">Login</a>
    </div>
NOTLOGGEDIN;
}



require_once("footer.php");
?>

