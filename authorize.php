<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Layout.php'); 
	
	$DISession = new DISession();
	$Session = $DISession->GetSessionBySessionID(SessionID());
	
	if ($Session == null)
	{
		$randomCode = generateRandomString(8);
		$SessionResponse = $DISession->CreateSession(null, null, 0, 0, $randomCode);
		if ($SessionResponse != null)
		{
			$Session = $SessionResponse->GetPayload();
		}
	}

	$RoomCode = "";
	if ($Session != null)
	{
		$RoomCode = $Session->GetRoomCode();
	}
?>

<main id="authorize" class="DynamicLoad">
	<div class="d-grid m-3 text-center">
	
		<div class="m-2 row" id="InfoPane">
			<textarea class="form-control disabled" rows="20" disabled="disabled" id="informationWindow">
				<?php 
					echo "My Session ID is ".SessionID() ."\r\n"; 
					if ($Session == null) 
					{
						echo "Failed to generate Session, so that's fucked.\r\n";
					}
					else if ($Session->AccessToken == null) 
					{
						echo "Connect to Spotify to get started\r\n";
					}
					else if ($SessionResponse != null && $SessionResponse->GetStatusCode() != 200)
					{
						echo "Error ".$SessionResponse->GetStatusCode().": ".$SessionResponse->GetMessage()."\r\n";
					}
				?>
			</textarea>
		</div>

		<div class="m-2 row" id="DetailsPane">
			<input type="text" name="RoomCode" placeholder="Room Code" class="form-control" value="<?php echo $RoomCode; ?>" maxlength="8"/>
		</div>

		<div class="m-2 row" id="ControlsPane">
			<div class="col-2"><button type="button" class="btn btn-success">Connect to Spotify</button></div>
			<div class="col-2"><button type="button" class="btn btn-primary">Save Room Info</button></div>
			<div class="col-2"><button type="button" class="btn btn-info">Generate QR Code</button></div>
			<div class="col-2"><button type="button" class="btn btn-secondary">Extend Expiry</button></div>
			<div class="col-2"><button type="button" class="btn btn-warning">Disconnect from Spotify</button></div>
			<div class="col-2"><a href="/logout.php" class="btn btn-danger">Clear all Data</a></div>
		</div>

</main>