<?php
ob_start();
error_reporting(8192);
ini_set("date.timezone", "Europe/London");
  /* mysql media organiser database connection */
  DEFINE('DB_USERNAME', 'root');
  DEFINE('DB_PASSWORD', 'root');
  DEFINE('DB_HOST', 'localhost');
  DEFINE('DB_DATABASE', 'mediaorganiser');

  $dbmo = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
  mysqli_set_charset($dbmo, "utf8");
  if (mysqli_connect_error()) {
    die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
  }

session_start();

/* generic functions */
function clean_data($input) {
	$input=strip_tags($input);
  $input=str_replace("#","%23",$input);
	$input=str_replace("{","%7B",$input);
	$input=str_replace("}","%7D",$input);
	$input=str_replace("~","%7E",$input);
	$input=str_replace(";","%3B",$input);
  $input=str_replace("'","&#39;",$input);
	$input=str_replace("<scr","",$input);
	$input=str_replace("ipt>","",$input);
	$input=str_replace("javascript:","",$input);
	$input=str_replace("javascript","",$input);
$input=str_replace("%3c","",$input);
    $input=str_replace("%3e","",$input);
    $input=trim($input);
    return $input;
}
function clean_get($input) {
	$input=strip_tags($input);
    $input=str_replace("<","",$input);
    $input=str_replace(">","",$input);
    $input=str_replace("#","",$input);
    $input=str_replace("'","",$input);
	$input=str_replace('"','',$input);
	$input=str_replace("|","",$input);
	$input=str_replace("`","",$input);
    $input=str_replace(";","",$input);
    $input=str_replace("script","",$input);
	$input=str_replace("xss","",$input);
	$input=str_replace("<scr","",$input);
	$input=str_replace("ipt>","",$input);
	$input=str_replace("(","",$input);
	$input=str_replace(")","",$input);
	$input=str_replace("javascript","",$input);
	$input=str_replace("{","",$input);
	$input=str_replace("}","",$input);
    $input=str_replace("%3c","",$input);
    $input=str_replace("%3e","",$input);
    $input=trim($input);
    return $input;
}
function urlclean($input) {
	$input=str_replace("+","-",$input);
	$input=str_replace(" ","-",$input);
	$input=str_replace("/","",$input);
	$input=str_replace("(","",$input);
	$input=str_replace(")","",$input);
	$input=str_replace(".","",$input);
	$input=str_replace(",","-",$input);
	$input=str_replace("---","-",$input);
	$input=str_replace("--","-",$input);
	$input=ltrim($input);
	$input=rtrim($input);
	$input=trim($input);
	return $input;
}
function special_clean($input) {
    $input=str_replace("#","",$input);
    $input=str_replace("'","`",$input);
	$input=str_replace('"','',$input);
    $input=str_replace(";","",$input);
    $input=str_replace("script","",$input);
	$input=str_replace("xss","",$input);
	$input=str_replace("<scr","",$input);
	$input=str_replace("ipt>","",$input);
	$input=str_replace("javascript","",$input);
	$input=str_replace("{","",$input);
	$input=str_replace("}","",$input);
    $input=str_replace("%3c","",$input);
    $input=str_replace("%3e","",$input);
	$input=str_replace("<img","",$input);
	$input=str_replace("<input","",$input);
	$input=str_replace("<script","",$input);
	$input=str_replace("<a","",$input);
	$input=str_replace("<marquee","",$input);
    $input=trim($input);
    return $input;
}
function is_valid_email($input) {
	$result = true;
	if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $input)/i) {
		$result = false;
	}
	return $result;
}
function currentFile() {
	$currentfile = $_SERVER['SCRIPT_NAME'];
	$parts = explode('/', $currentfile);
	$currentfile = $parts[count($parts) - 1];
	$currentfile = str_replace("/~admin526", "", $currentfile);
	return $currentfile;
}
/* logged in functions */
function checkLoggedin($type, $url) {
	if($type == "secure") {
		if($_SESSION['loggedin'] !== true || !isset($_SESSION['account_id'])) {
			header("Location: https://".$_SERVER['HTTP_HOST']."/".$url."");
			exit();
		}
	}
	if($type == "insecure") {
		if($_SESSION['loggedin'] == true && isset($_SESSION['account_id'])) {
			header("Location: https://".$_SERVER['HTTP_HOST']."/".$url."");
			exit();
		}
	}
}
?>
