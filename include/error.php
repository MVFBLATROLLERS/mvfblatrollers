<?php

$error = FALSE;

function e_var_export($var){
    $return = print_r($var, true);
    $return = str_replace(" ", "&nbsp;", $return);
    $return = nl2br($return, true);
    user_error($return);
}

function check_errors(){
	return $GLOBALS['error'];
}

function user_error_handler($errorno, $errstr, $errfile, $errline){
	echo('<span id="error">'.$errstr.'</span><br />');
	$GLOBALS['error'] = TRUE;
}

set_error_handler("user_error_handler", E_USER_NOTICE | E_USER_WARNING);
?>
