<?php
class DIRecaptcha
{
    //V3
    function VerifyToken($token)
    {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $url .= "?secret=".Secrets::$RECAPTCHA_SECRET_KEY;
        $url .= "&response=".$token;
        $method = "POST";

        $options = array (
            "http" => array(
                "method" => $method,
                "header" => "Content-Type: application/x-www-form-urlencoded\r\n".
                            "Content-Length: 0",
                "ignore_errors" => true
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        $response = json_decode($result);
        return $response->success;
    }
}
?>