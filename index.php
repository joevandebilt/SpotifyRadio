<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Layout.php') ?>

<main id="index" class="DynamicLoad">
	<div class="d-grid m-3 text-center">
		
		<div class="m-3 row" id="infoPane">
			<div class="col-12">
				<p>Just a nice way of letting everybody queue songs on your spotify device</p>
				<small class="text-small">Spotify Premium is required to create a room, it is <b>not required</b> to join a room</small>
			</div>
		</div>

		<div class="m-3 row" id="controlPane">
				<div class="col-sm-6">
					<div class="card text-white bg-secondary">
						<div class="card-body">
							<h5 class="card-title mb-4">Join a Room</h5>
							<div class="input-group input-lg">
								<input type="text" class="form-control" id="RoomCode" placeholder="Room Code" maxlength="8" />
								<button type="button" class="btn btn-lg btn-primary" onclick="NavigateToRoom()">Enter Room</button>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="card text-white bg-secondary">
						<div class="card-body">
							<h5 class="mb-4">Or create your own</h5>
							<a href="/admin" class="btn btn-lg btn-dark">Create Room</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>

<script type="text/javascript">
	function NavigateToRoom() {
        var roomCode = $("#RoomCode").val();
		if (roomCode != "") {
			window.location = "https://spotify.nkode.uk/room/"+roomCode;
        }
	}
</script>
