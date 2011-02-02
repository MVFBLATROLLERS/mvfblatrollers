<?php 
$title="Employer Registration"; 
require_once "header.php"; 
ob_start();
require_once "include/validate.php";
require_once "include/recaptchalib.php";
require_once "include/employer.php";

if(@$_POST['submitted'] === 'true'){
	$a = true;
}

function getf($f){
	global $a;
	if($a)
		echo $_POST[$f];
	else
		echo null;
}
?>
<h2>Employer Registration</h2>
<form method="post" action="/employer_reg.php">
<input type="hidden" name="submitted" value="true" />
<table>
<tr>
	<td colspan="2"><strong>The first four fields are required.<strong></td>
</tr><tr>
	<td>Username: </td><td><input type="text" name="username" value="<?php getf('username');?>"/>
	<?php if($a)
		if($_POST['username'] == ''){
			trigger_error("Username must not be empty.");
		}
		else if(!Validate::alphanum($username = $_POST['username'])){
			trigger_error("Username must be alphanumeric.");
		}
		else if(User::username_exists($username)){
			trigger_error("Username already exists. Choose another.");
		}
	?></td>
</tr><tr>
	<td>Valid Email Address: </td><td><input type="text" name="email" value="<?php getf('email');?>"/>
	<?php if($a)
		if(!Validate::email($email = $_POST['email'])){
			trigger_error("Email is not valid.");
		}
		else if(User::email_exists($email)){
			trigger_error("Email already exists. Choose another.");
		}

	?></td>
</tr><tr>
	<td>Password: </td><td><input type="password" name="password" /></td>
</tr><tr>
	<td>Confirm Password: </td><td><input type="password" name="confirm" />
	<?php if($a)
		if($_POST['password'] != $_POST['confirm']){
			trigger_error("Passwords do not match.");
		}
		else if(strlen($_POST['password']) < 6){
			trigger_error("Passwords should be at least 6 letters long.");
		}
		else{
			$password = $_POST['password'] ;
		}
	?></td>
</tr><tr>
	<td>Company: </td><td><input type="text" name="company" value="<?php getf('company');?>"/>
	<?php if($a)
		if($_POST['company'] == ''){
			trigger_error("Company name cannot be blank.");
		}
	?> </td>
</tr><tr>
	<td>Other details about the company: <br />(10000 characters maximum): </td>
	<td><textarea name="about_me" id="about_me" cols="60" rows="30"><?php getf('about_me');?></textarea>
	<br />
	<span id="about_me_counter">Characters remaining: 10000</span>
	<br />
	<?php
	if(@strlen($_POST['about_me']) > 10000){
		trigger_error("10000 characters maximum.");
	}
	?>
	</td>

	<script type="text/javascript">
	$('#about_me').keyup(function (){
		var left = 10000 - $(this).val().length;
		$('#about_me_counter').text('Characters remaining: '+left);
		if(left<0)
			$('#about_me_counter').css('color', 'red');
		else
			$('#about_me_counter').css('color', 'black');
	});
	</script>
</tr><tr>
	<td>Required to ensure you are human.</td><td><?php echo recaptcha_get_html($recaptcha_publickey);?></td>
</tr><tr>
	<td></td><td><input type="submit" value="Submit" /></td>
</tr>
</table>
</form>
<?php
if(!check_errors() && $a){
	ob_clean();
	$userid = Employer::create($_POST['username'], $_POST['email'], $_POST['password']);
	$employer = new Employer($userid);
	$employer->set_property($_POST['company'], 'company');
	if(!check_errors()){
		echo "Registration was successful. You will recieve an email to activate your account.";
	}
}
else{
	ob_end_flush();
}
include "footer.php"; 
 
?>
