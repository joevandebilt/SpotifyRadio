<?php
    class DISpotify
    {
        const scope = "user-modify-playback-state user-read-currently-playing";
        const response_type = "code";
        const redirect_uri = "https://spotify.nkode.uk/authorize.php";  

        function GetClientID()
        {
            return Secrets::$SPOTIFY_CLIENT;
        }

        function GetClientSecret()
        {
            return Secrets::$SPOTIFY_SECRET;
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
            return $this->SendSpotifyAPIRequest("v1", "/me/player/queue?uri=".urlencode($trackUri), $access_token, "POST", null);
        }

        function Search($access_token, $searchString)
        {
            return $this->SendSpotifyAPIRequest("v1", "/search?q=".urlencode($searchString)."&type=track", $access_token, "GET", null);
        }

        function SendSpotifyAPIRequest($api_version, $api_endpoint, $access_token, $method, $data)
        {
            
            $url = "https://api.spotify.com/".$api_version.$api_endpoint;
            $options = array (
                "http" => array(
                    "header" => "Authorization: Bearer ".$access_token."\r\n".
                                "Content-Type: application/x-www-form-urlencoded\r\n".
                                "Content-Length: 0",
                    "method" => $method,
                    "ignore_errors" => true
                )
            );
            if ($data != null)
            {
                array_push($options["http"], "content", http_build_query($data));
            }
            
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            //This value comes out of nowehere when the above ^ statement is complete
            $status_line = $http_response_header[0];
            preg_match('{HTTP\/\S*\s(\d{3})}', $status_line, $match);
            $status = $match[1];

            $response = new Response($status);
            if ($result != false) {
                $response->SetPayload(json_decode($result));
            }
            return $response;
        }
    }
?>