var RoomControls = (function($) {

    $(document).ready(function() {

        //Get the room code from a hidden token or url parameter?
        APIRequest("RoomReady", null, (response) =>{ 

            if (response.StatusCode != 200) {
                $(".add-to-queue").attr("disabled","disabled");
                $(".add-to-queue").addClass("disabled");
                $(".add-to-queue").html("Room not Connected to Spotify");
                $("#nowPlayingPane").hide();
                apiError();
            }
            else {
                APIRequest("GetUserInfo", null, (response) => {
                    $("#subHeader").html("Connected to "+response.display_name+"'s Spotify");
                    getCurrentTrack();
                });
            }
        });
    });

    function getCurrentTrack() {
        APIRequest("GetCurrentTrack", null, (response) => {
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
                apiError();
            }
        }
        else 
        {
            apiError();
        }
    }

    function verifyTrackId(trackId) {
        var data = {};
        data.TrackUri = trackId;

        APIRequest("GetTrackInfo", data, processTrackInfoResponse);
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
            var data = {
                TrackUri: track.uri
            };
            APIRequest("QueueTrack", data, (response) => console.log(response));
        }
        else {
            apiError();
        }
    }

    function apiError(xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
    }

    function APIRequest(Action, Data, Callback) {

        var queryString = window.location.search;
        var urlParams = new URLSearchParams(queryString);
        
        //Append Room Code to Payload
        if (Data == null) { Data = {}; }
        Data.RoomCode = urlParams.get('RoomCode'); 

        //Send the Request via the API Handler
        APIHandler.Send("Room", Action, Data, Callback, apiError);
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
        },
        NavigateToRoom: function() {
            var roomCode = $("#RoomCode").val();
            if (roomCode != "") {
                window.location = "https://spotify.nkode.uk/room/"+roomCode;
            }
        }
    }

})(jQuery);
