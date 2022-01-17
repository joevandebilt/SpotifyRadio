<?php
    class DISpotify
    {
        $scope = "user-read-private user-read-email user-modify-playback-state user-read-currently-playing";
        $response_type = "code";
        $redirect_uri = "https://joe.nkode.uk/API/spotify/authorize.php";  

        function GetClientID()
        {
            return "046f25af5f1444a881c64cec8ec3f716";
        }

        function GetClientSecret()
        {
            return file_get_contents($_SERVER['DOCUMENT_ROOT']."/client_secret", true);
        }
        

        //Check if local file exists
        $authorized = null;
        $currentTime = time();
        $token_filename = "./tokens/auth_token.txt";
        $expiry_filename = "./tokens/auth_expire.txt";
        $refresh_filename = "./tokens/refresh_token.txt";
        
        if (isset($_GET['app']))
        {
            if (file_exists($token_filename) && file_exists($expiry_filename) && file_exists($refresh_filename))
            {
                $expiry_content = intval(file_get_contents($expiry_filename, true));		
                if ($expiry_content > $currentTime) 
                {	
                    //If the token is not expired return it
                    $token_content = file_get_contents($token_filename, true);	
                    $authorized = $token_content;
                    //echo "Got Token ";
                }		
                else 
                {
                    //Refresh our token because it has expired
                    $refresh_content = file_get_contents($refresh_filename, true);
                    
                    DeleteTokens($token_filename, $expiry_filename, $refresh_filename);
                    
                    $response = GetAccessTokenFromRefresh($client_id, $client_secret, $redirect_uri, $refresh_content);
                    $authorized = ProcessAccessTokenResponse($response, $token_filename, $expiry_filename, $refresh_filename);
                    //echo "Refreshed Token ";
                }
            }
            echo $authorized;
        }
        else if (isset($_GET['code']))
        {
            $code = $_GET['code'];
            
            $response = GetAccessTokenFromCode($client_id, $client_secret, $redirect_uri, $code);
            $authorized = ProcessAccessTokenResponse($response, $token_filename, $expiry_filename, $refresh_filename);
            
            //echo "Authorization Complete ";
            echo $authorized;
        }
        else if (isset($_GET['logout']))
        {
            DeleteTokens($token_filename, $expiry_filename, $refresh_filename);
        }
        else if ($authorized == null || isset($_GET['reset'])) 
        {
            $requestUrl = "https://accounts.spotify.com/authorize";
            $requestUrl .= "?client_id=".$client_id;
            $requestUrl .= "&response_type=".$response_type;
            $requestUrl .= "&scope=".$scope;
            $requestUrl .= "&redirect_uri=".$redirect_uri;
                
            header("Location: ".$requestUrl);
            exit();
        }
        
        function GetAccessTokenFromCode($client_id, $client_secret, $redirect_uri, $code)
        {
            $data = array("code" => $code, "grant_type" => "authorization_code", "redirect_uri" => $redirect_uri);
            return GetAccessToken($client_id, $client_secret, $redirect_uri, $data);
        }
        
        function GetAccessTokenFromRefresh($client_id, $client_secret, $redirect_uri, $refresh_token)
        {
            $data = array("refresh_token" => $refresh_token, "grant_type" => "refresh_token", "redirect_uri" => $redirect_uri);
            return GetAccessToken($client_id, $client_secret, $redirect_uri, $data);
        }
        
        function GetAccessToken($client_id, $client_secret, $redirect_uri, $data)
        {
            $bearer_token = base64_encode($client_id.":".$client_secret);		
            $url = "https://accounts.spotify.com/api/token";
            $options = array (
                "http" => array(
                    "header" => "Authorization: Basic ".$bearer_token,
                    "method" => "POST",
                    "content" => http_build_query($data)
                )
            );
            
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result != false) {
                $response = json_decode($result);			
                return $response;
            }
            return null;	
        }
        
        function ProcessAccessTokenResponse($response, $token_filename, $expiry_filename, $refresh_filename)
        {
            $currentTime = time();
            $timeTilExpire = $response->expires_in;
            $expiry = $currentTime + $timeTilExpire; 
            $access_token = $response->access_token;
            $refresh_token = $response->refresh_token;
            
            WriteFileContent($token_filename, $access_token);
            WriteFileContent($expiry_filename, $expiry);
            WriteFileContent($refresh_filename, $refresh_token);
            
            return $access_token;
        }
        
        function WriteFileContent($filename, $content)
        {
            $file = fopen($filename, "w");
            fwrite($file, $content);
            fclose($file);
        }

        function DeleteTokens($token_filename, $expiry_filename, $refresh_filename)
        {
            unlink($token_filename);
            unlink($expiry_filename);
            unlink($refresh_filename);
        }
    }
?>