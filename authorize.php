<?php
    require_once($_SERVER['DOCUMENT_ROOT']."/Classes/Class.Main.php");

    $DISpotify = new DISpotify();
    if (isset($_GET['code']))
    {
        $code = $_GET['code'];
            
        $response = $DISpotify->GetAccessTokenFromAuthCode($code);
        if ($response != null)
        {
            $currentTime = time();
            $Expiry = $response->expires_in;
            $ExpiryTime = $currentTime + $Expiry; 
            $AccessToken = $response->access_token;
            $RefreshToken = $response->refresh_token;

            $DISession = new DISession();
            $sessionResponse = $DISession->UpdateSession(SessionID(), $AccessToken, $RefreshToken, $Expiry, $ExpiryTime, null, null);
            
            //That's us done for the authentication - now we need to close this window
            echo "<script type='text/javascript'>window.close();</script>";
        }
        else 
        {
            var_dump($response);
        }
    }
    else 
    {
        $DISpotify->RedirectToAuthScreen();
    }
?>