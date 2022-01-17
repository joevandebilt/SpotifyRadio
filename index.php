<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Layout.php') ?>

<main id="index" class="DynamicLoad">
	<div class="d-grid m-3 text-center">
		<h1>Spotify Radio</h1>
		<h6 id="subHeader"></h6>
		
		<div class="m-2 row" id="infoPane">
			<div class="col-12">
				<p>Just a nice way of letting everybody queue songs on your spotify device</p>
			</div>
		</div>


		<div class="m-2" id="controlPane">
			<div class="row">
				<div class="col-12">
					<input type="text" class="form-control" placeholder="Room Code" />
				</div>
			</div>

			<div class="row">
				<div class="col-6">
					<button type="button" class="btn btn-primary">Enter Room</button>
				</div>
				<div class="col-6">
					<a href="/authorize.php" class="btn btn-secondary">Create Room</a>
				</div>
			</div>
		</div>
	</div>
</main>
