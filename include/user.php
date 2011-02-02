<?php
require_once("db.php");
require_once("error.php");
require_once("validate.php");

define("HASH_ALG", 'sha512');

class User {
    protected $userid;
    protected $username;
    protected $email;
    protected $password_hash;
    protected $data;
    protected static $logged_in; //bool
    
	public function __construct($userid){
		$this->get_by_id($userid);
	}
    /* login and logout must be called before output begins!!! */
    public static function login($email, $password){
        better_session_start();
        // email to lowercase
        $email = strtolower($email);
        // calculate password hash
        $hash = hash(HASH_ALG, $password.$email); //salt is email

        // check if email address is valid
        if(!Validate::email($email)){
            trigger_error('Invalid email address.');
            return FALSE;
        }
        // email column is indexed, so search that
        $result = $GLOBALS['mysqli']->query( "SELECT * FROM users WHERE email = '$email'");
        $user = $result->fetch_array(MYSQLI_ASSOC);
		/*if(!is_null($user['activation'])){
			trigger_error('Account is not activated! <a href="resend_activation.php">Resend activation email</a>');
		}
        else */if($user['password_hash'] === $hash){
            // login successful, write userid into session
            $_SESSION['userid'] = $user['userid'];
            self::set_logged_in(TRUE);
            return $user['userid'];

        }
        else{
            trigger_error('Invalid email/password combination.');
            return FALSE;
        }
    }

    public static function logout(){
        better_session_destroy();
        self::set_logged_in(FALSE);
        better_session_start();
    }

	public static function activate($code){
		$result = $GLOBALS['mysqli']->query( "SELECT * FROM users WHERE activation = '$code'");
		if($result->fetch_array(MYSQLI_ASSOC)){
			if($GLOBALS['mysqli']->query( "UPDATE users SET activation = NULL WHERE activation = '$code'")){
				return true;
			}
			else{
				trigger_error("Database error.");
			}
		}
		else{
			trigger_error("Account is already activated or doesn't exist.");
		}
		return false;
	}
	
	public static function send_activation_email($userid){
		global $mysqli;
		$result = $mysqli->query("select activation from users where userid = $userid");
		$array = $result->fetch_array();
		mail($email, "Activation email for HSJobs", "Click this link to activate your account: \n
			<http://192.168.189.100/activate.php?id={$array['activation']}>\n
			If this fails, go to <http://192.168.189.100/activate.php> and enter the code\n
			$activation", "From: do_not_reply@hsjobs.org");

	}
	
    public static function is_logged_in(){
        if(self::$logged_in){
            return true;
        }
        else{
            return false;
        }
    }

    public static function set_logged_in($bool){
        if($bool)
        self::$logged_in = TRUE;
        else
        self::$logged_in = FALSE;
    }

    public static function username_exists($username){
        $username = $GLOBALS['mysqli']->real_escape_string($username);
        $result = $GLOBALS['mysqli']->query( "SELECT * FROM users WHERE username = '$username'");
		if($return = $result->fetch_array())
			return $return['userid'];
		else
			return false;
    }
    
    public static function exists($userid){
        $result = $GLOBALS['mysqli']->query( "SELECT * FROM users WHERE userid = $userid");
        return (bool) $result->fetch_array();
    }
    
    public static function email_exists($email){
        $email = $GLOBALS['mysqli']->real_escape_string( $email);
        $result = $GLOBALS['mysqli']->query( "SELECT * FROM users WHERE email = '$email'");
        return (bool) ($result->fetch_array());
    }
    public static function create($username, $email, $password, $usertype, $permissions, $data){
    	$email = strtolower($email);
    	
        $hash = hash(HASH_ALG, $password.$email); //hash salt is email

		$activation = hash(HASH_ALG, rand(0, 4294967295).$username);
        //not really necessary, but just in case.
        $escaped_username = $GLOBALS['mysqli']->real_escape_string( $username);
        $escaped_hash = $GLOBALS['mysqli']->real_escape_string( $hash);
        $escaped_email = $GLOBALS['mysqli']->real_escape_string( $email);
		$escaped_activation =  $GLOBALS['mysqli']->real_escape_string( $activation);
        $data_to_write = $GLOBALS['mysqli']->real_escape_string(serialize(array('usertype'=>$usertype,'permissions'=>$permissions,'data'=>$data)));
		
        //everything is fine: write team info to database
        if(!$GLOBALS['mysqli']->query( "INSERT INTO users (username, email, password_hash, activation, data) VALUES ('$escaped_username', '$escaped_email', '$escaped_hash', '$activation', '$data_to_write')")){
            trigger_error("Database failure, please contact us if the problem persists.");
            return FALSE;
        }
        else{
			$userid = $GLOBALS['mysqli']->insert_id;
			$this->send_activation_email($userid);
            // return userid
			return $userid;
        }
    }

	
    public function change_password($old_password, $new_password, $verify){

		$hash = hash(HASH_ALG, $new_password.$this->email);

		if($new_password !== $verify){
			trigger_error("Passwords do not match.");
		}
		else if(hash(HASH_ALG,$old_password.$this->email) !== $this->password_hash){
			trigger_error("Old password is incorrect.");
        }
		else if(!$GLOBALS['mysqli']->query( "UPDATE users SET password_hash = '{$hash}' WHERE userid = {$this->userid}")){
				trigger_error("Database failure");
		}
		else{
			return true;
		}
		return false;
    }

    public function get_by_id($userid){
    	$userid = (int) $userid;
        $result = $GLOBALS['mysqli']->query( "SELECT * FROM users WHERE userid = $userid");
        if(($user = $result->fetch_array(MYSQLI_ASSOC)) != FALSE){

            $this->userid = $user['userid'];
            $this->username = $user['username'];
            $this->email = $user['email'];
            $this->password_hash = $user['password_hash'];
            $this->data = unserialize($user['data']);
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
	
    public function get_data(){
        return $this->data['data'];
    }

    public function get_usertype(){
        return $this->data['usertype'];
    }

    public function check_permissions(){
        if($this->userid == 1) return true; //root user
        $num_args = func_num_args();
        for($i = 0; $i < $num_args; $i++){
            
            $arg = func_get_arg($i);
            if($arg === 'ROOT'){
                return false;
            }
            if($this->data['permissions'][$arg] !== true){
                return false;
            }
        }
        return true;
    }

    public function check_permissions_arr($arr){//array in format $permission => {TRUE, FALSE, NULL}
        if(is_array($arr)){
            foreach($arr as $permission => $test){
                if($test === TRUE){
                    if(!$this->check_permissions($permission))
                    return false;
                }
            }
        }
        return true;
    }

    public function set_permissions(){
        $num_args = func_num_args();
        for($i = 0; $i < $num_args; $i++){
            $this->data['permissions'][func_get_arg($i)] = TRUE;
        }
        return $this->flush_data_to_db($this->data);
    }

    public function clear_permissions(){
        $num_args = func_num_args();
        for($i = 0; $i < $num_args; $i++){
            $arg = func_get_arg($i);
            if(!is_null($this->data['permissions'][$arg])){
                unset($this->data['permissions'][$arg]);
            }
        }
        return $this->flush_data_to_db($this->data);
    }

    public function get_email(){
        return $this->email;
    }

    public function get_username(){
        return $this->username;
    }

    public function get_id(){
        return $this->userid;
    }
    public function flush_data_to_db($data){
        $serialized_new_data = $GLOBALS['mysqli']->real_escape_string(
        serialize($this->data));
        if($GLOBALS['mysqli']->query("UPDATE users SET data = '{$serialized_new_data}' WHERE userid = {$this->userid}")){
            return true;
        }
        else{
            return false;
        }
    }
}