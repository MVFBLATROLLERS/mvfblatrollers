<?php

class Validate{
    public static function alphanum($string){
        if (preg_match('/[^A-Za-z0-9_ ]/', $string) || strpos($string, "\0")){
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    public static function email($email){
		if($email === "root@localhost")
			return true;
		else
			return filter_var($email, FILTER_VALIDATE_EMAIL) && (strpos($email, "\0") === FALSE);
    }
}
?>