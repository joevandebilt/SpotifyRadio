<?php require_once($_SERVER['DOCUMENT_ROOT'].'/Views/Layout.php') ?>

<main id="room" class="DynamicLoad">
	<div class="d-grid m-3 text-center">
		<h1>Queue A Song</h1>
		<h6 id="subHeader"></h6>
		
		<div class="m-2 row" id="helpPane">
			<p>Enter a spotify song link to queue a track, to get a song link select track, share and Copy Link</p>

			<div class="col-12">
				<img src="/Images/ShareLink.PNG" class="img-fluid" />
			</div>
		</div>


		<div class="m-2 row" id="queuePane">      
			<div class="col-8">
				<input type="text" class="form-control" id="trackLink" placeholder="Copy Link Here" />
			</div>
			<div class="col-4">
				<button type="button" class="btn btn-primary form-control add-to-queue" onclick="submitToQueue();">Queue</button>
			</div>
		</div>


		<div class="mt-4 ml-2 mr-2 row" id="nowPlayingPane">    
			<div class="accordion" id="accordionExample">
				<div class="accordion-item">
					<h2 class="accordion-header" id="headingOne">
					<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						Currently Playing
					</button>
					</h2>
					<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
						<div class="accordion-body">						
							<div class="row">
								<div class="col-3 p-0">
									<img class="img-fluid img-thumbnail" id="nowPlayingImage" alt="Now playing artwork" />
								</div>			
								<div class="col-9 text-start">
									<h5 id="nowPlayingTrack"></h5>
									<p id="nowPlayingArtist"></p>
									<strong id="nowPlayingTimestamp"></strong>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>


		<div class="m-2 row" id="resultPane" style="display: none;">
			<div class="col-12">
				<div class="card">
					<img src="#" id="queuedImage" class="card-img-top" alt="album-art" />
					<div class="card-body">
						<h5 id="queuedTrack" class="card-title"></h5>
						<p class="text-muted">by</p>
						<p id="queuedArtist" class="card-text"></p>
						<button class="btn btn-primary" onclick="location.reload()">Another One</button>
					</div>
				</div>
			</div>
		</div>
	</div>

</main>
