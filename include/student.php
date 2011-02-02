<?php
require_once "include/user.php";
require_once "include/db.php";

class Student extends User{
	protected $education;
	protected $about_me;
	protected $real_name;
	protected $location;
	
	public function __construct($userid){
		parent::__construct($userid);
		$this->get_by_id($userid);
		
	}
	public static function create($username, $email, $password){
		if(($userid = parent::create($username, $email, $password, "student", array(), array())) == false){
			return false;
		}
		global $mysqli;
		$query = "INSERT INTO students (userid) VALUES($userid)";
		if(!$mysqli->query($query)){
			trigger_error("Database failure");
			return false;
		}
		return $userid;
	}
	public function set_property($data, $property, $type = 'quoted'){
		global $mysqli;
		$escaped_data = $mysqli->real_escape_string($data);
		$escaped_property = $mysqli->real_escape_string($property);
		if($type == 'unquoted' || $type == 'int') $query = "UPDATE students SET $property = $escaped_data WHERE userid = {$this->userid}";
		else $query = "UPDATE students SET $property = '$escaped_data' WHERE userid = {$this->userid}";
		if(!$mysqli->query($query)){
			trigger_error("Database failure");
			return false;
		}
		return true;
	}	
	public function get_education(){
		return $this->education;
	}
	public function get_about_me(){
		return $this->about_me;
	}
	public function get_real_name(){
		return $this->real_name;
	}
	public function get_location(){
		return $this->location;
	}
	
	public function get_by_id($userid){
		parent::get_by_id($userid);
    	$userid = (int) $userid;
        $result = $GLOBALS['mysqli']->query( "SELECT * FROM students WHERE userid = $userid");
        if(($user = $result->fetch_array(MYSQLI_ASSOC)) != FALSE){
			$this->education = $user['education'];
			$this->about_me = $user['about_me'];
			$this->real_name = $user['real_name'];
			$this->location = $user['location'];
			return TRUE;
        }
        else
            return FALSE;
    }
}
?>
