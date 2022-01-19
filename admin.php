<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Layout.php'); ?>

<main id="authorize" class="DynamicLoad">
	<div class="d-grid m-3 text-center">	
		<h1>Admin Control Panel</h1>
		<h6 id="subHeader">This is where the fun begins...</h6>

		<div class="m-2 row" id="tabsPane">
			<ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
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

					<div class="mt-2" id="connectionPane"></div>

					<div class="mt-2 row" id="roomCodeControlPane">
						<div class="col-6">
							<input type="text" id="RoomName" name="RoomName" placeholder="Room Name" class="form-control" value="Room-123456" maxlength="20"/>
						</div>
						<div class="col-3">
							<input type="text" id="RoomCode" name="RoomCode" placeholder="Room Code" class="form-control" value="123456" maxlength="8"/>
						</div>
						<div class="col-3">
							<button type="button" class="btn btn-primary action-save" onclick="AdminControls.SaveRoomInfo()">
								<i class="fas fa-save"></i> Save Room
							</button>
						</div>
					</div>

					<div class="mt-2 row" id="controlsPane">
						<div class="col-3">
							<button type="button" class="btn btn-success action-connect" onclick="AdminControls.AuthWithSpotify()">
								<i class="fab fa-spotify"></i> Connect to Spotify
							</button>
						</div>
						<div class="col-3">
							<button type="button" class="btn btn-secondary action-extend" onclick="AdminControls.ExtendExpiry()">
								<i class="fas fa-clock"></i> Extend Expiry
							</button>
						</div>
						<div class="col-3">
							<button type="button" class="btn btn-warning action-disconnect" onclick="AdminControls.DisconnectFromSpotify()">
								<i class="fas fa-plug"></i> Disconnect from Spotify
							</button>
						</div>
						<div class="col-3">
							<a href="/logout.php" class="btn btn-danger action-destroy">
								<i class="fas fa-bomb"></i> Clear all Data
							</a>
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
						<div class="col-12">
							<a href="#" id="roomLink" class="btn btn-link">https://spotify.nkode.uk/room/123456</a>
							<button class="btn btn-secondary"><i class="fas fa-copy"></i> Copy</button>
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