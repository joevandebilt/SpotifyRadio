<?php
//Joe's handy php functions

//generates a string of alphanumeric characters for a specified length
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

//generates a string of numbers for a specified length
function generateRandomNumber($length) {
    $characters = '0123456789';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

//Redirects page to a given location
function PageRedirect($Page) {
		$string = '<script type="text/javascript">';
		$string .= 'window.location = "' . $Page . '"';
		$string .= '</script>';

		echo $string;
}

//Output a read only
function AlertBox($AlertMessage) {
	echo '<script type="text/javascript">alert("'.$AlertMessage.'")</script>';
}

//great for debugging
function Output($OutputMessage) {
	echo '<script type="text/javascript">prompt("Sample Text","'.$OutputMessage.'")</script>';
}

function GetWebsiteURL()
{
    if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'];// . $_SERVER['REQUEST_URI'];
}
?>