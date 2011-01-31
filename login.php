<?php $title="Login"; require_once "header.php"; echo "<h2>$title</h2>";?>
<?php
if(User::is_logged_in()){
	echo "You're already logged in.";
}
else{
if(@$_POST['submitted'] === "true"){
    $userid = User::login($_POST['email'],$_POST['password']);
    if($userid){
        $user->get_by_id($userid);
    }
}

if(@$_POST['submitted'] !== "true" || check_errors()){
    echo <<<LOGIN
    <form method="POST" action="login.php">
    <input type="hidden" name="submitted" value="true">
    <table>
    <tr><td>Email:</td><td><input type="text" name="email" /></td></tr>
    <tr><td>Password:</td><td><input type="password" name="password" /></td></tr>
    <tr><td><input type="submit" value="Submit"></td></tr>
    </table>
    </form>
LOGIN;
}
else{
    echo "You have logged in.";
	echo '<meta http-equiv="refresh" content="2"; URL=index.php">';
	
}
}
?>
<? include "footer.php"; ?>
