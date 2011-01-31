<?php
require_once("db.php");
require_once("error.php");

define("UPLOAD_DIR", $_SERVER['DOCUMENT_ROOT']."/upload/");
$upload_allowed_types=
array(
        'pdf' => 'application/pdf' // pdf ONLY
);

define("MAX_FILE_SIZE", 16000000);
define("MAX_NAME_LEN", 256);
define("MAX_EXT_LEN", 16);
define("MAX_TYPE_LEN", 256);

class UploadedFile{
    private $fileid;
    private $name;
    private $ext;
    private $size;
    private $created_date;
    private $ip;
    private $permissions;
    private $hide_until;
    /*
     * Files cannot be downloaded before $hide_until unless they have "CAN_DOWNLOAD FILES EARLY" and only by users with permissions in $permissions.
     * If there are no permissions set in $permissions, users do not need to be logged in.
     * This will be enforced by download.php
     */
    public function get_file_path(){
        return UPLOAD_DIR.($this->fileid);
    }

    public static function add_time_exception($fileid, $userid, $start_time, $end_time){
        $userid = (int) $userid;
        $start_time = is_null($start_time)?"NULL":(int) $start_time;
        $end_time = is_null($end_time)?"NULL":(int) $end_time;
        if(!$GLOBALS['mysqli']->query("INSERT INTO dl_time_exceptions
        (userid, fileid, start_time, end_time) VALUES ({$userid}, {$fileid}, {$start_time}, {$end_time})")){
        print_err("Database failure.");
        return false;
        }
        else return true;
    }

    private static function verify_temporary_file($file_form_name){
        global $upload_allowed_types;
        if($_FILES[$file_form_name]["error"] !=  UPLOAD_ERR_OK){
            print_err("Error uploading file. Errno:". $_FILES[$file_form_name]["error"] ); // upload errors
            return false;
        }
        else if($_FILES[$file_form_name]["size"] > MAX_FILE_SIZE){
            print_err("File is too large".$_FILES[$file_form_name]["size"].MAX_FILE_SIZE ); //check file size
            return false;
        }
        else{
            foreach($upload_allowed_types as $name => $type){ //check each type
                if ($_FILES[$file_form_name]["type"] == $type) return true;
            }
            print_err("File type is invalid");
            return false;
        }
    }

    public static function save_temporary_file($file_form_name, $permissions = array(), $hide_until = 0x80000001 /* very long ago */){
        if(self::verify_temporary_file($file_form_name)){
            //create new entry in database
            $pathinfo = pathinfo($_FILES[$file_form_name]['name']);
            $escaped_name = $GLOBALS['mysqli']->real_escape_string( $pathinfo['filename']);
            $escaped_ext = $GLOBALS['mysqli']->real_escape_string( $pathinfo['extension']);
            $escaped_type = $GLOBALS['mysqli']->real_escape_string( $_FILES[$file_form_name]['type']);
            $escaped_ip = $GLOBALS['mysqli']->real_escape_string( $_SERVER['REMOTE_ADDR']);
            //truncate names
            $escaped_name = substr($escaped_name, 0, MAX_NAME_LEN);
            $escaped_ext = substr($escaped_ext, 0, MAX_EXT_LEN);
            $escaped_type = substr($escaped_type, 0, MAX_TYPE_LEN);

            $time = $_SERVER['REQUEST_TIME']; //time of request

            $to_write_permissions = $GLOBALS['mysqli']->real_escape_string(serialize($permissions));
            $hide_until = (int) $hide_until;

            if(!$GLOBALS['mysqli']->query( "INSERT INTO files
                (name, ext, type, size, created_date, ip, permissions, hide_until)
                VALUES ('{$escaped_name}', 
                '{$escaped_ext}',
                '{$escaped_type}',
                {$_FILES[$file_form_name]['size']},
                {$time},
                '{$escaped_ip}',
                '{$to_write_permissions}',
                {$hide_until})")
                ){
                    print_err("Database error");
                    return false;
                }
				
                $fileid = $GLOBALS['mysqli']->insert_id;
                if(!move_uploaded_file($_FILES[$file_form_name]['tmp_name'], UPLOAD_DIR.$fileid)){
                    print_err("Filesystem error");
                    return false;
                }
                else{
                    return $fileid; // get last file's id
                }
        }
        else{
            return false;
        }
    }

    public static function delete_file($fileid){
        $result = $GLOBALS['mysqli']->query( "DELETE FROM files WHERE fileid = {$fileid}");
        if($result->fetch_array() !== FALSE){
            return true;
            if(unlink("UPLOAD_DIR".$fileid)){
                print_err("Filesystem error");
                return false;
            }
        }
        else{
            print_err("Database failure");
            return false;
        }
    }


    public function get_by_id($fileid){
        $result = $GLOBALS['mysqli']->query( "SELECT * FROM files WHERE fileid = {$fileid}");
        $result_array = $result->fetch_array(MYSQLI_ASSOC);
        if($result_array){
            $this->fileid = $result_array['fileid'];
            $this->name = $result_array['name'];
            $this->ext = $result_array['ext'];
            $this->size = $result_array['size'];
            $this->created_date = strtotime($result_array['created_date']);
            $this->ip = $result_array['ip'];
            $this->permissions = unserialize($result_array['permissions']);
            $this->hide_until = $result_array['hide_until'];
            return true;
        }
        else{
            return false; //file does not exist
        }
    }

    public function get_fileid(){
        return $this->fileid;
    }

    public function get_filename(){
        return $this->name.'.'.$this->ext;
    }

    public function get_permissions(){
        return $this->permissions;
    }

    public function is_time_hidden($userid){
        if($_SERVER['REQUEST_TIME'] > $this->hide_until){    
            return false;
        }
        if(!($result = $GLOBALS['mysqli']->query("SELECT * FROM dl_time_exceptions
        WHERE userid = {$userid} AND fileid = {$this->get_fileid()} ORDER BY start_time ASC"))){
            print_err("Database failure");            
            return true;
        }
        $result_array = $result->fetch_array();        
        if($result_array == FALSE){
            return true;
        }
        $start_time = $result_array['start_time'];
        $end_time = $result_array['end_time'];
        if((is_null($start_time) || $start_time <= $_SERVER['REQUEST_TIME']) && (is_null($end_time) || $end_time >= $_SERVER['REQUEST_TIME'])){            
            return false;
        }
        return true;
    }
}