<?php
session_start();


if (!empty($_GET['SessionID']) && $_GET['SessionID'] != "null")	//Is the user giving us a session id?
{
	$_SESSION['SessionID'] = $_GET['SessionID'];
}
elseif (empty($_SESSION['SessionID'])) //Does the user have a session ID
{
	//Generate an ID and assign it to he user
	$SessionID = generateRandomString(6) . date("YmdHis");
	$_SESSION['SessionID'] = $SessionID;
}
?>