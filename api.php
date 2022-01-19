<?php
	
	header('Content-Type: application/json; charset=utf-8');
	require_once($_SERVER['DOCUMENT_ROOT']."/Classes/Class.Main.php");

	$requestData = json_decode(file_get_contents('php://input'), true);
	$area = $requestData['Area'];
	$action = $requestData['Action'];
	$payload = $requestData['Payload'];

	$DISession = new DISession();
	$DISpotify = new DISpotify();

	$response = new Response(400, null, "Failed to Complete Operation: ".$area."/".$action);
	$DIResponse = null;

	if ($area == "Admin") 
	{
		if ($action == "GetRoomInfo")
		{			
			$response = $DISession->GetSessionBySessionID();
			if ($response->GetPayload() == null)
			{
				$roomCode = strtoupper(generateRandomString(8));
				$response = $DISession->CreateSession($roomCode);				
			}
		}
		else if ($action == "Update Room Code")
		{
			$roomCode = $payload["RoomCode"];
			$DIResponse = $DISession->UpdateSession(null, null, null, null, $RoomCode);
		}
		else if ($action == "ExtendTimeout")
		{

		}
	}
	else if ($area == "Room")
	{
		$room_code = $payload["RoomCode"];

		$RoomSessionResponse= $DISession->GetSessionByRoomCode($room_code);
		$RoomSession = $RoomSessionResponse->GetPayload();

		if ($action == "RoomReady")
		{
			$DIResponse = false;
			if ($RoomSession != null && strlen($RoomSession->GetAccessToken()) > 0)
			{
				$DIResponse = true;
			}
		}
		else if ($action == "GetUserInfo")
		{
			$DIResponse = $DISpotify->GetActiveUserInfo($RoomSession->GetAccessToken());
		}
		else if ($action == "GetCurrentTrack")
		{
			$DIResponse = $DISpotify->GetCurrentTrack($RoomSession->GetAccessToken());
		}
		else if ($action == "GetTrackInfo")
		{
			$track_uri = $payload["TrackUri"];
			$DIResponse = $DISpotify->GetTrackById($RoomSession->GetAccessToken(), $track_uri);
		}
		else if ($action == "QueueTrack")
		{
			$track_uri = $payload["TrackUri"];
			$DIResponse = $DISpotify->AddTrackToQueue($RoomSession->GetAccessToken(), $track_uri);
		}
	}

	if ($DIResponse != null)
	{
		$response = new Response(200, $DIResponse, null);
	}

	echo json_encode($response);
?>

