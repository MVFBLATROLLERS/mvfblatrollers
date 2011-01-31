<?php

$error = '';

function print_err($string){
    $GLOBALS['error'] .= $string . "<br />\n";
}

function e_var_export($var){
    $return = print_r($var, true);
    $return = str_replace(" ", "&nbsp;", $return);
    $return = nl2br($return, true);
    print_err($return);
}

function print_errors(){
    echo("<div id=\"error\">".$GLOBALS['error']."</div>");
}

function check_errors(){
    if(empty($GLOBALS['error']))
        return FALSE;
    else
        return TRUE;
}
?>
