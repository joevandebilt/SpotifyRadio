var RoomControls = (function($) {

    $(document).ready(function() {
        if ($("#room").length > 0) 
        {
            initRoom();
        }
    });

    function initRoom() {
        //Get the room code from a hidden token or url parameter?
        $(".refresh-room").addClass("hidden");
        APIRequest("RoomReady", null, (roomResponse) =>{  
            if (roomResponse.StatusCode != 200) {
                disableQueueButton("Room not Connected to Spotify");
                apiError(roomResponse);
            }
            else 
            {
                $("#subHeader").html("Connected to "+roomResponse.Payload);
                getCurrentTrack();
            }
        });
    }

    function getCurrentTrack() {
        APIRequest("GetCurrentTrack", null, (response) => {
            if (response.StatusCode == 200) {
                var meta = response.Payload;
                var track = meta.item;
                
                $("#nowPlayingImage").attr("src", track.album.images[0].url);

                var link ="<a class='btn btn-lg btn-link text-primary ps-0 ms-0' href='"+track.external_urls.spotify+"'>"+track.name+"</a>";
                $("#nowPlayingTrack").html(link);

                var artists = track.artists.map(function(a) { return a.name}).join(", ");
                $("#nowPlayingArtist").html(artists);

                var time = track.duration_ms / 1000;
                var minutes = Math.floor(time / 60);
                var seconds = Math.round(time - (minutes * 60));
                $("#nowPlayingTimestamp").html(minutes + ":" + seconds);

                var triggerAgain = track.duration_ms - meta.progress_ms + 1000;
                setTimeout(getCurrentTrack, triggerAgain);
            } 
            else if (response.StatusCode == 204) {
                disableQueueButton("No active player found");
            }
            else {
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
                $("#trackLink").addClass("is-invalid");
                apiError("Submit to Queue - Track URI Could not be determined");
            }
        }
        else 
        {
            $("#trackLink").addClass("is-invalid");
            apiError("Submit to Queue - Track Link is Empty");
        }
    }

    function verifyTrackId(trackId) {
        APIRequest("GetTrackInfo", { TrackUri: trackId }, processTrackInfoResponse);
    }

    function processTrackInfoResponse(response) {
        if (response.StatusCode == 200)
        {
            $("#trackLink").removeClass("is-invalid");
            track = response.Payload;
            if (track != null) {
                $("#queuedTrack").html(track.name)

                var artists = track.artists.map(function(a) { return a.name}).join(", ");
                $("#queuedArtist").html(artists)

                var image = track.album.images[0].url;
                $("#queuedImage").attr("src", image);

                APIRequest("QueueTrack", { TrackUri: track.uri }, (response) => {
                    if (response.StatusCode == 204) {
                        var myToastEl = document.getElementById('resultToast')
                        var myToast = bootstrap.Toast.getOrCreateInstance(myToastEl)
                        myToast.show();
                    } else {
                        apiError(response);
                    }
                });
            }
            else {
                apiError("Process Track Info Response - Payload is null");
            }
        }
        else {
            apiError(response);
            $("#trackLink").addClass("is-invalid");
        }
    }

    function enableQueueButton() {
        $(".add-to-queue").removeAttr("disabled")
        $(".add-to-queue").removeClass("disabled");
        $(".add-to-queue").html("Queue");
        $("#nowPlayingPane").show();
    }

    function disableQueueButton(message) {
        $(".add-to-queue").attr("disabled","disabled");
        $(".add-to-queue").addClass("disabled");
        $(".add-to-queue").html(message);
        $("#nowPlayingPane").hide();
        $(".refresh-room").removeClass("hidden");
    }

    function apiError(xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
    }

    function APIRequest(Action, Data, Callback) {

        var pathName = window.location.pathname;
        var urlParams = pathName.split('/');
        
        //Append Room Code to Payload
        if (Data == null) { Data = {}; }
        Data.RoomCode = urlParams[urlParams.length-1];

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
        Init: function() {
            initRoom();
        }
    }

})(jQuery);
