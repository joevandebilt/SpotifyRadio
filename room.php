<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Layout.php') ?>

<main id="room" class="DynamicLoad">
	<div class="d-grid m-3 text-center">
		<h1>Queue A Song</h1>
		<h6 id="subHeader"></h6>
		
		<div class="m-3 text-center" id="helpPane">
			<p>Enter a Spotify song link to queue a track, to get a song link select track, share and Copy Link</p>
			<img src="/Images/ShareLink.PNG" class="img-fluid" />
		</div>

		<div class="m-3 row" id="queuePane">      
			<div class="col-sm-8 mt-2">
				<input type="text" class="form-control" id="trackLink" placeholder="Copy Link Here" required />
				<div class="invalid-feedback">Invalid Spotify Track link</div>
			</div>
			<div class="col-sm-4 mt-2">
				<button type="button" class="btn btn-primary form-control add-to-queue" onclick="RoomControls.SubmitToQueue();">Queue</button>
			</div>
		</div>

		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Room/Now-Playing.php') ?>

		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Room/Song-Toast.php') ?>

	</div>

</main>
