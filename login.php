<?php $title="Login"; require_once "header.php"; echo "<h2>$title</h2>";?>
<?php
if(User::is_logged_in()){
	echo "You're already logged in.";
}
else{
if(@$_POST['submitted'] === "true"){
    $userid = User::login($_POST['email'],$_POST['password']);
    if($userid){
        $user = new User($userid);
    }
}

if(@$_POST['submitted'] !== "true" || check_errors()){
    echo <<<LOGIN
	<p>
    <form method="POST" action="login.php">
    <input type="hidden" name="submitted" value="true">
    <table>
    <tr><td>Email:</td><td><input type="text" name="email" /></td></tr>
    <tr><td>Password:</td><td><input type="password" name="password" /></td></tr>
    <tr><td><input type="submit" value="Submit"></td></tr>
    </table>
    </form>
	</p>
LOGIN;
}
else{
    echo "You have logged in.<br />";
	echo "Redirecting in 2 seconds... If your browser does not support redirection: ";
	switch($user->get_usertype()){
	case "student":
		echo '<a href="students.php">Students</a><meta http-equiv="refresh" content="2; URL=students.php">';
	case "employer":
		echo '<a href="employers.php">Employers</a><meta http-equiv="refresh" content="2; URL=employers.php">';
	default:
		echo '<a href="index.php">Other</a><meta http-equiv="refresh" content="2; URL=index.php">';
	}
}
}
?>
<? include "footer.php"; ?>
