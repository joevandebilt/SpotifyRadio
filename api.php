<?php
	
	header('Content-Type: application/json; charset=utf-8');
	require_once($_SERVER['DOCUMENT_ROOT']."/Classes/Class.Main.php");

	$requestData = json_decode(file_get_contents('php://input'), true);
	$area = $requestData['Area'];
	$action = $requestData['Action'];
	$sessionID = $requestData['SessionID'];
	$payload = $requestData['Payload'];
	$recaptchaToken = $requestData['RecpatchaToken'];

	$DISession = new DISession();
	$DISpotify = new DISpotify();
	$DIRecaptcha = new DIRecaptcha();

	$response = new Response(400, null, "Failed to Complete Operation: ".$area."/".$action);

	//Clean up expired sessions
	$DISession->DeleteExpiredSessions();

	//Verify all API Requests
	if ($DIRecaptcha->VerifyToken($recaptchaToken))
	{
		if ($area == "Admin") 
		{
			if ($action == "GetRoomInfo")
			{			
				$response = $DISession->GetSessionBySessionID($sessionID);
				if ($response->GetPayload() == null)
				{
					$roomCode = strtoupper(generateRandomString(8));
					$roomName = "Room-".$roomCode;
					$response = $DISession->CreateSession($sessionID, $roomName, $roomCode);				
				}
			}
			else if ($action == "UpdateRoomCode")
			{
				$roomCode = $payload["RoomCode"];
				$roomName = $payload["RoomName"];
				$response = $DISession->UpdateSession($sessionID, null, null, null, null, $roomName, $roomCode);
			}
			else if ($action == "ExtendTimeout")
			{
				$sessionResponse = $DISession->GetSessionBySessionID($sessionID);
				$session = $sessionResponse->GetPayload();
				if ($session != null)
				{
					$refresh_token = $session->GetRefreshToken();
					$spotify_response = $DISpotify->GetAccessTokenFromRefresh($refresh_token);

					if ($spotify_response != null) 
					{
						$currentTime = time();
						$expiry = $spotify_response->expires_in;
						$expiryTime = $currentTime + $expiry; 
						$accessToken = $spotify_response->access_token;
						$response = $DISession->UpdateSession($sessionID, $accessToken, null, $expiry, $expiryTime, null, null);
					}
					else 
					{
						$response->SetMessage("Failed to refresh Spotify token");
					}
				}
				else 
				{
					$response = $sessionResponse;
				}
			}
			else if ($action == "DisconnectSession")
			{
				$response = $DISession->UpdateSession($sessionID, "", "", 3600, time()+3600, null, null);
			}
		}
		else if ($area == "Room")
		{
			$room_code = $payload["RoomCode"];

			$RoomSessionResponse= $DISession->GetSessionByRoomCode($room_code);
			$RoomSession = $RoomSessionResponse->GetPayload();

			if ($action == "RoomReady")
			{
				if ($RoomSession != null && strlen($RoomSession->GetAccessToken()) > 0)
				{
					$response->SetMessage(null);
					$roomName = $RoomSession->GetRoomName();
					if ($roomName != null)
					{
						$response->SetPayload($roomName);
						$response->SetStatusCode(200);
					}
					else 
					{
						$response->SetPayload(null);
						$response->SetStatusCode(204);
					}
				}
			}
			else if ($action == "GetUserInfo")
			{
				$response = $DISpotify->GetActiveUserInfo($RoomSession->GetAccessToken());
			}
			else if ($action == "GetCurrentTrack")
			{
				$response = $DISpotify->GetCurrentTrack($RoomSession->GetAccessToken());
			}
			else if ($action == "GetTrackInfo")
			{
				$track_uri = $payload["TrackUri"];
				$response = $DISpotify->GetTrackById($RoomSession->GetAccessToken(), $track_uri);
			}
			else if ($action == "QueueTrack")
			{
				$track_uri = $payload["TrackUri"];
				$response = $DISpotify->AddTrackToQueue($RoomSession->GetAccessToken(), $track_uri);
			}
		}
	}
	else 
	{
		$response = new Response(401, null, "Failed to validate Recaptcha Token");
	}

	echo json_encode($response);
?>

