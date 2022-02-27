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
				<div class="button-group d-flex flex-row">
					<button type="button" class="btn btn-primary flex-grow-1 add-to-queue" onclick="RoomControls.SubmitToQueue();" >Queue</button>
					<button type="button" class="btn btn-secondary flex-shrink-1 refresh-room hidden" onclick="RoomControls.Init();"><i class="fa-solid fa-arrows-rotate"></i></button>
				</div>
			</div>
		</div>

		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Room/Now-Playing.php') ?>

		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Room/Song-Toast.php') ?>

	</div>

</main>
