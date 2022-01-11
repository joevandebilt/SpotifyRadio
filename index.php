<!DOCTYPE html>
<html>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

  <title>Joe's Playlist Quererer</title>
  
  <?php
  
	$client_id = "046f25af5f1444a881c64cec8ec3f716";
	$auth_token = file_get_contents("https://joe.nkode.uk/API/spotify/authorize.php?app=".$client_id);
  
  ?>
  
</head>
<body>
	<div class="d-grid m-3 text-center">
		<h1>Queue A Song </h1>
		<h6 id="subHeader"></h6>
		
		<div class="m-2 row" id="helpPane">
			<p>Enter a spotify song link to queue a track, to get a song link select track, share and Copy Link</p>

			<div class="col-12">
				<img src="./ShareLink.PNG" class="img-fluid" />
			</div>
		</div>


		<div class="m-2 row" id="queuePane">      
			<div class="col-8">
				<input type="text" class="form-control" id="trackLink" placeholder="Copy Link Here" />
			</div>
			<div class="col-4">
				<button type="button" class="btn btn-primary form-control" onclick="submitToQueue();">Queue</button>
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
	<script>

	var auth_token = <?php echo "'".trim($auth_token)."'"; ?>;

	$(document).ready(function() {

		if (auth_token === "") {
			alert("Find Joe he needs to log in again");
			$(".btn").attr("disabled","disabled");
		}
		else {
			SendAPIRequest("https://api.spotify.com/v1/me", "GET", null, (response) => {
				console.log(response)
				$("#subHeader").html("Connected to "+response.display_name+"'s Spotify");
			});
		}
	});

	function submitToQueue() {
		var trackLink = $("#trackLink").val();
		if (trackLink !== undefined && trackLink !== null && trackLink !== "") {
			var urlParts = trackLink.split("/");
			var trackUri = urlParts[urlParts.length-1];
			if (trackUri !== "")
			{
				var trackId = trackUri.split("?")[0];
				verifyTrackId(trackId);
			}
			else 
			{
				SomethingWentWrong();
			}
		}
		else 
		{
			SomethingWentWrong();
		}
	}
	
	function verifyTrackId(trackId) {
		SendAPIRequest("https://api.spotify.com/v1/tracks/"+trackId, "GET", null, processTrackInfoResponse);
	}

	function processTrackInfoResponse(track) {
		if (track != null){
			$("#queuedTrack").html(track.name)

			var artists = track.artists.map(function(a) { return a.name}).join(", ");
			$("#queuedArtist").html(artists)

			var image = track.album.images[0].url;
			$("#queuedImage").attr("src", image);

			$("#resultPane").show();

			$("#queuePane").hide();
			$("#helpPane").hide();

			submitToSpotifyQueue(track);
		}
		else {
			SomethingWentWrong();
		}
	}

	function submitToSpotifyQueue(track) {
		console.log(track);
		SendAPIRequest("https://api.spotify.com/v1/me/player/queue?uri="+track.uri, "POST", null, (response) => console.log(response));
	}

	function SomethingWentWrong() {
		alert("O no hed");
	}
	
	function SendAPIRequest(Url, Method, Data, Callback) {
		$.ajax({
		url: Url,
		type: Method,
		beforeSend: function(request) {
		  request.setRequestHeader('Authorization', 'Bearer ' + auth_token);
		  request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
		},
		data: Data,
		success: Callback,
		error: function (xhr, ajaxOptions, thrownError) {
		  SomethingWentWrong();
		}
	  });
	}

	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>