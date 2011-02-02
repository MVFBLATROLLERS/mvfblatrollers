<?php $title="Employer Portal"; require_once "header.php"; ?>
<h2><?php echo $title ?></h2>
<?php if(!User::is_logged_in() || @$user->get_usertype() != 'employer'){
		echo "<h3><a href='employer_reg.php'>Register for an account!</a></h3>";
		echo <<<CONTENT
		<p><h4>Registering has many benefits.</h4>
		You can:
		<ul>
		<li>Post internship positions</li>
		<li>Find students based on location, education and interests</li>
		<li>View applicant's uploaded resumes</li>
		<li>Quickly contact applicants with a familiar method - email</li>
		<li>It's free!</li>
		</ul>
		</p>
CONTENT;
	}
?>

<? include "footer.php"; ?>
