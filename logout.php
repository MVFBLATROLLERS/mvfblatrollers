<?php
$title = "Logout";

require_once("header.php"); /* add text here */

if(User::is_logged_in()){
    //code goes here
    User::logout();
    echo <<<LOGOUT
    <p>You have been logged out. Have a nice day.</p>
LOGOUT;
	echo "Redirecting in 2 seconds... If your browser does not support redirection: <a href=\"index.php\">Home</a>";
	echo '<meta http-equiv="refresh" content="2; URL=index.php">';

}
else{
    echo <<<NOTLOGGEDIN
    <div id="not_logged_in_warning">
    You must be logged in to logout.
    <a href="login.php" id="not_logged_in_warning_login_link">Login</a>
    </div>
NOTLOGGEDIN;
}



require_once("footer.php");
?>

