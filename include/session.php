<?php
function better_session_start(){
    if(!isset($_SESSION['created_already'])){ // can call multiple times without error
        session_start();
        $_SESSION['created_already'] = true;
        if(!isset($_SESSION['not_first_time'])){
            session_regenerate_id(); // prevent attackers from creating session ids
            $_SESSION['not_first_time'] = true;
        }
    }
}

function better_session_destroy(){
    // remove session data
    $_SESSION = array();
    // destroy session
    session_destroy();
    // destroy session cookie
    setcookie(session_name(), '', time() - 1337);  
}
?>