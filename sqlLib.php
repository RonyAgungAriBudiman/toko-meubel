<?php
class sqlLib
{
	var $srvr;
	var $db;
	var $usr;
	var $psw;

	//function sqlLib()
	function __construct()
	{
		include dirname(__FILE__) . "/config.php";
		$this->srvr = $srvr;
		$this->db = $db;
		$this->usr = $usr;
		$this->psw = $psw;
		$this->conn = new mysqli($this->srvr, $this->usr, $this->psw, $this->db);
		if (!$this->conn) print "Connection not establish!!!";
	}

	function antisqlinject($string)
	{
		$string = stripslashes($string);
		$string = strip_tags($string);
		$string = mysqli_real_escape_string($this->conn, $string);
		return $string;
	}

	function select($sql = "")
	{
		if (empty($sql) || empty($this->conn))
			return false;
		$result = mysqli_query($this->conn, $sql);
		if (empty($result)) {
			return false;
		}
		if (!$result) {
			mysqli_free_result($result);
			return false;;
		}
		$data = array();
		$inc = 0;
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[$inc] = $row;
			$inc++;
		}
		mysqli_free_result($result);
		return $data;
	}

	function insert($sql = "")
	{
		$status = "";
		if (empty($sql)) {
			return false;
		}
		$sql = trim($sql);
		/*if (!eregi("^insert", $sql))
		{ 
			$status = "wrong command, it's insert command only"; 
		}*/
		$conn = $this->conn;
		$result = mysqli_query($this->conn, $sql) or $status = "0";

		if ($result) {
			$status = "1";
		}

		return $status;
	}

	function update($sql = "")
	{
		$status = "";
		if (empty($sql)) {
			return false;
		}
		$sql = trim($sql);
		/*
		if (!eregi("^update", $sql))
		{ 
			echo"wrong command, it's update command only"; 
		} 
		*/
		$conn = $this->conn;
		$result = mysqli_query($this->conn, $sql) or $status = "0";

		if ($result) {
			$status = "1";
		}

		return $status;
	}
	function delete($sql = "")
	{
		$status = "";
		$sql = trim($sql);
		if (empty($sql)) {
			return false;
		}
		/*
		if (!eregi("^delete", $sql))
		{ 
			echo"wrong command, it's delete command only"; 
			return false; 
		} */
		if (empty($this->conn)) {
			return false;
		}

		$result = mysqli_query($this->conn, $sql) or $status = "0";

		if ($result) {
			$status = "1";
		}

		return $status;
	}
}



function encrypt($string, $key)
{
	$result = '';
	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) + ord($keychar));
		$result .= $char;
	}
	return base64_encode($result);
}

function decrypt($string, $key)
{
	$result = '';
	$string = base64_decode($string);

	for ($i = 0; $i < strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) - ord($keychar));
		$result .= $char;
	}
	return $result;
}


function antisqlinject($string)
{
	include dirname(__FILE__) . "/config.php";

	$link = mysqli_connect($srvr, $usr, $psw, $db);
	$string = stripslashes($string);
	$string = strip_tags($string);
	$string = mysqli_real_escape_string($link, $string);
	return $string;
}

function acakacak($action, $string)
{
	$output = false;

	$encrypt_method = "AES-256-CBC";
	$secret_key = 'This is my secret key';
	$secret_iv = 'This is my secret iv';

	// hash
	$key = hash('sha256', $secret_key);

	// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
	$iv = substr(hash('sha256', $secret_iv), 0, 16);

	if ($action == 'encode') {
		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);
	} else if ($action == 'decode') {
		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
	}

	return $output;
}

	//	error_reporting(1);
