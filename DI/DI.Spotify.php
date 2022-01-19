<?php
    class DISpotify
    {
        const scope = "user-read-private user-read-email user-modify-playback-state user-read-currently-playing";
        const response_type = "code";
        const redirect_uri = "https://spotify.nkode.uk/authorize.php";  

        function GetClientID()
        {
            return "046f25af5f1444a881c64cec8ec3f716";
        }

        function GetClientSecret()
        {
            return file_get_contents($_SERVER['DOCUMENT_ROOT']."/client_secret", true);
        }

        function RedirectToAuthScreen()
        {
            $requestUrl = "https://accounts.spotify.com/authorize";
            $requestUrl .= "?client_id=".$this->GetClientID();
            $requestUrl .= "&response_type=".self::response_type;
            $requestUrl .= "&scope=".self::scope;
            $requestUrl .= "&redirect_uri=".self::redirect_uri;
                
            header("Location: ".$requestUrl);
            exit();
        }


        function GetAccessTokenFromAuthCode($code)
        {
            $data = array("code" => $code, "grant_type" => "authorization_code", "redirect_uri" => self::redirect_uri);
            return $this->GetAccessToken($data);
        }
        
        function GetAccessTokenFromRefresh($refresh_token)
        {
            $data = array("refresh_token" => $refresh_token, "grant_type" => "refresh_token", "redirect_uri" => self::redirect_uri);
            return $this->GetAccessToken($data);
        }
        
        function GetAccessToken($data)
        {
            $basic_token = base64_encode($this->GetClientID().":".$this->GetClientSecret());		
            $url = "https://accounts.spotify.com/api/token";
            $options = array (
                "http" => array(
                    "header" => "Authorization: Basic ".$basic_token."\r\n".
                                "Content-Type: application/x-www-form-urlencoded",
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
                        
            return $access_token;
        }

        function GetActiveUserInfo($access_token)
        {
            return $this->SendSpotifyAPIRequest("v1", "/me", $access_token, "GET", null);
        }

        function GetCurrentTrack($access_token)
        {
            return $this->SendSpotifyAPIRequest("v1", "/me/player/currently-playing", $access_token, "GET", null);
        }

        function GetTrackById($access_token, $trackId)
        {
            return $this->SendSpotifyAPIRequest("v1", "/tracks/".$trackId, $access_token, "GET", null);
        }

        function AddTrackToQueue($access_token, $trackUri)
        {
            return $this->SendSpotifyAPIRequest("v1", "/me/player/queue?uri=".$trackUri, $access_token, "POST", null);
        }

        function SendSpotifyAPIRequest($api_version, $api_endpoint, $access_token, $method, $data)
        {
            
            $url = "https://api.spotify.com/".$api_version.$api_endpoint;
            $options = array (
                "http" => array(
                    "header" => "Authorization: Bearer ".$access_token."\r\n".
                                "Content-Type: application/x-www-form-urlencoded",
                    "method" => $method
                )
            );

            if ($data != null)
            {
                array_push($options["http"], "content", http_build_query($data));
            }
            
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);
            if ($result != false) {
                $response = json_decode($result);			
                return $response;
            }
            return null;
        }
    }
?>