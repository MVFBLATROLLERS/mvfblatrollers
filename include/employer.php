<?php
require_once "include/user.php";
require_once "include/db.php";

class Employer extends User{
	protected $company;
	protected $details;
	public function __construct($userid){
		parent::__construct($userid);
		$this->get_by_id($userid);
	}
	public static function create($username, $email, $password){
		if(!($userid = parent::create($username, $email, $password, "employer", array("CREATE JOB ENTRY"), array())))
			return false;
		global $mysqli;
		$query = "INSERT INTO employers (userid) VALUES($userid)";
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
		if($type == 'unquoted' || $type == 'int')
			$query = "UPDATE employers SET $property = $escaped_data WHERE userid = {$this->userid}";
		else $query = "UPDATE employers SET $property = '$escaped_data' WHERE userid = {$this->userid}";
		if(!$mysqli->query($query)){
			trigger_error("Database failure");
			return false;
		}
		return true;
	}
	public function get_company(){
		return $this->company;
	}
	public function get_details(){
		return $this->category_id;
	}
	public function get_by_id($userid){
		parent::get_by_id($userid);
    	$userid = (int) $userid;
        $result = $GLOBALS['mysqli']->query( "SELECT * FROM employers WHERE userid = $userid");
        if(($user = $result->fetch_array(MYSQLI_ASSOC)) != FALSE){
			$this->company = $user['company'];
			$this->details = $user['details'];
			return TRUE;
        }
        else
            return FALSE;
    }
}
?>