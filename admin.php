<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Layout.php'); ?>

<main id="authorize" class="DynamicLoad">
	<div class="d-grid m-3 text-center">	
		<h1>Admin Control Panel</h1>
		<h6 id="subHeader">This is where the fun begins...</h6>

		<div class="m-2 row" id="InfoPane">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item" role="presentation">
					<button class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" data-bs-target="#tabDashboard" type="button" role="tab" aria-controls="dashboard" aria-selected="true">Dashboard</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="share-tab" data-bs-toggle="tab" data-bs-target="#tabShare" type="button" role="tab" aria-controls="share" aria-selected="false">Share</button>
				</li>
				<li class="nav-item" role="presentation">
					<button class="nav-link" id="debug-tab" data-bs-toggle="tab" data-bs-target="#tabDebug" type="button" role="tab" aria-controls="debug" aria-selected="false">Debug</button>
				</li>
			</ul>

			<div class="tab-content" id="tabContent">
				
				<div class="tab-pane fade show active" role="tabpanel" aria-labelledby="dashboard-tab" id="tabDashboard">

					<div class="mt-2" id="infoPane">
						<p>Room Connected: false</p>
						<p>Connected to Spotify: false</p>
						<p>Expires In 0 Seconds (00:00:00)</p>
					</div>

					<div class="mt-2 row" id="roomCodeControlPane">
						<div class="col-9">
							<input type="text" id="RoomCode" name="RoomCode" placeholder="Room Code" class="form-control" value="123456" maxlength="8"/>
						</div>
						<div class="col-3">
							<button type="button" class="btn btn-primary" onclick="AdminControls.SaveRoomInfo()">Save Room Code</button>
						</div>
					</div>

					<div class="mt-2 row" id="controlsPane">
						<div class="col-3">
							<button type="button" class="btn btn-success" onclick="AdminControls.AuthWithSpotify()">Connect to Spotify</button>
						</div>
						<div class="col-3">
							<button type="button" class="btn btn-secondary" onclick="AdminControls.ExtendExpiry()">Extend Expiry</button>
						</div>
						<div class="col-3">
							<button type="button" class="btn btn-warning" onclick="AdminControls.DisconnectFromSpotify()">Disconnect from Spotify</button>
						</div>
						<div class="col-3">
							<a href="/logout.php" class="btn btn-danger">Clear all Data</a>
						</div>
					</div>
				</div>
			
				<div class="tab-pane fade" role="tabpanel" aria-labelledby="share-tab" id="tabShare">
					<div class="m-2 row">
						<div class="col-12">
							<img src="#" alt=QRCode id="qrCodeImage" />
						</div>
					</div>
					<div class="m-2 row">
						<div class="col-10">
							<a href="#" id="roomLink">https://spotify.nkode.uk/room/{roomcode}</a>
						</div>
						<div class="col-2">
							<button class="btn btn-secondary">Copy</button>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" role="tabpanel" aria-labelledby="debug-tab" id="tabDebug">
					<textarea class="form-control disabled" rows="20" disabled="disabled" id="informationWindow"></textarea>
				</div>

			</div>

		</div>
	</div>
</main>