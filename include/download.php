<?php
$title = "Download file";

require_once("include/preload.php"); /* add text here */
require_once("include/upload.php");

$fileid = (int)$_GET['id'];
$upload = new UploadedFile;
$exists = $upload->get_by_id($fileid);
$permissions = $upload->get_permissions();

if (!$exists) { 
    print_err("File does not exist.");
}
else if(is_array($permissions) && (!$user->check_permissions_arr($permissions))){ 
    // not allowed
    print_err("File does not exist."); 
}
else if($upload->is_time_hidden($user->get_id()) && !$user->check_permissions("DOWNLOAD FILES EARLY")){
    // too early
    print_err("You can't download the file yet.");
}
else{
        /* borrowed from http://www.php.net/manual/en/function.readfile.php#99406
         * license: http://creativecommons.org/licenses/by/3.0/
         */
        $realpath = $upload->get_file_path();
        $mtime = ($mtime = filemtime($realpath)) ? $mtime : gmtime();
        $size = intval(sprintf("%u", filesize($realpath)));
        // Maybe the problem is we are running into PHPs own memory limit, so:
        if (intval($size + 1) > return_bytes(ini_get('memory_limit')) && intval($size * 1.5) <= 1073741824) { //Not higher than 1GB
            ini_set('memory_limit', intval($size * 1.5));
        }
        // Maybe the problem is Apache is trying to compress the output, so:
        //@apache_setenv('no-gzip', 1);
        //@ini_set('zlib.output_compression', 0);
        // Maybe the client doesn't know what to do with the output so send a bunch of these headers:
        header("Content-type: application/force-download");
        header('Content-Type: application/octet-stream');
        if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE") != false) {
            header("Content-Disposition: attachment; filename=" . urlencode(basename($upload->get_filename())) . '; modification-date="' . date('r', $mtime) . '";');
        } 
        else {
            header("Content-Disposition: attachment; filename=\"" . basename($upload->get_filename()) . '"; modification-date="' . date('r', $mtime) . '";');
        }
        // Set the length so the browser can set the download timers
        header("Content-Length: " . $size);
        // If it's a large file we don't want the script to timeout, so:
        set_time_limit(300);
        // If it's a large file, readfile might not be able to do it in one go, so:
        $chunksize = 1 * (1024 * 1024); // how many bytes per chunk
        if ($size > $chunksize) {
            $handle = fopen($realpath, 'rb');
            $buffer = '';
            while (!feof($handle)) {
                $buffer = fread($handle, $chunksize);
                echo $buffer;
                ob_flush();
                flush();
            }
            fclose($handle);
        } 
        else {
            readfile($realpath);
        }
        exit; // STOP HERE.
}


require_once("include/layout.php");

function return_bytes($val) { //also borrowed from php manual http://php.net/manual/en/function.ini-get.php
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}
?>

