var SpotifyControls = (function($) {

    var auth_token = "";

    $(document).ready(function() {

        //Get the room code from a hidden token or url parameter?
        

        if (auth_token === "") {
            $(".add-to-queue").attr("disabled","disabled");
            somethingWentWrong();
        }
        else {
            sendSpotifyAPIRequest("https://api.spotify.com/v1/me", "GET", null, (response) => {
                //console.log(response)
                $("#subHeader").html("Connected to "+response.display_name+"'s Spotify");
                getCurrentTrack();
            });
        }
    });

    function getCurrentTrack() {
        sendSpotifyAPIRequest("https://api.spotify.com/v1/me/player/currently-playing", "GET", null, (response) => {
            console.log(response);

            if (response != undefined) {
                var meta = response;
                var track = meta.item;
                
                $("#nowPlayingImage").attr("src", track.album.images[0].url);

                var link ="<a href='"+track.external_urls.spotify+"'>"+track.name+"</a>";
                $("#nowPlayingTrack").html(link);

                var artists = track.artists.map(function(a) { return a.name}).join(", ");
                $("#nowPlayingArtist").html(artists);

                var time = track.duration_ms / 1000;
                var minutes = Math.floor(time / 60);
                var seconds = Math.round(time - (minutes * 60));
                $("#nowPlayingTimestamp").html(minutes + ":" + seconds);

                var triggerAgain = track.duration_ms - meta.progress_ms + 1000;
                setTimeout(getCurrentTrack, triggerAgain);
            } else {
                $("#nowPlayingPane").hide();
            }
        });
    }

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
                somethingWentWrong();
            }
        }
        else 
        {
            somethingWentWrong();
        }
    }

    function verifyTrackId(trackId) {
        sendSpotifyAPIRequest("https://api.spotify.com/v1/tracks/"+trackId, "GET", null, processTrackInfoResponse);
    }

    function processTrackInfoResponse(track) {
        if (track != null) {
            $("#queuedTrack").html(track.name)

            var artists = track.artists.map(function(a) { return a.name}).join(", ");
            $("#queuedArtist").html(artists)

            var image = track.album.images[0].url;
            $("#queuedImage").attr("src", image);

            $("#resultPane").show();

            $("#queuePane").hide();
            $("#helpPane").hide();
            $("#nowPlayingPane").hide();

            console.log(track);
            sendSpotifyAPIRequest("https://api.spotify.com/v1/me/player/queue?uri="+track.uri, "POST", null, (response) => console.log(response));
        }
        else {
            somethingWentWrong();
        }
    }

    function somethingWentWrong() {
        //alert("O no hed");
    }

    function sendSpotifyAPIRequest(Url, Method, Data, Callback) {
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
                somethingWentWrong();
            }
        });
    }

    return {
        GetCurrentTrack: function(){
            return getCurrentTrack();
        },
        ProcessTrackInfoResponse: function(track) {
            return processTrackInfoResponse(track);
        },
        SubmitToQueue: function() {
            return submitToQueue();
        },
        VerifyTrackId: function(trackId) {
            return verifyTrackId(trackId)
        }
    }

})(jQuery);
