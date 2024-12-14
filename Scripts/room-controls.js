var RoomControls = (function ($) {

    var progressBarInterval;

    $(document).ready(function () {
        if ($("#room").length > 0) {
            initRoom();
        }
    });

    function initRoom() {
        //Get the room code from a hidden token or url parameter?
        $(".refresh-room").addClass("hidden");
        APIRequest("RoomReady", null, (roomResponse) => {
            if (roomResponse.StatusCode != 200) {
                disableQueueButton("Room not Connected to Spotify");
                apiError(roomResponse);
            }
            else {
                $("#subHeader").html("Connected to " + roomResponse.Payload);
                getCurrentTrack();

                var currentUrl = window.location.href;

                $("#roomLink").attr("href", currentUrl);
                $("#roomLink").html("/room/" + getRoomCode());
                $("#qrCodeImage").attr("src", generateQR(currentUrl));


                var cleanUrl = currentUrl.replace("https://", "");
                $("#facebookShare").attr("href", "https://www.facebook.com/sharer/sharer.php?u=" + cleanUrl);
                $("#twitterShare").attr("href", "https://twitter.com/intent/tweet?text=Join%20my%20Spotify%20room%20" + cleanUrl)

            }
        });
    }

    function getCurrentTrack() {
        clearInterval(progressBarInterval);
        APIRequest("GetCurrentTrack", null, (response) => {
            if (response.StatusCode == 200) {
                var meta = response.Payload;
                var track = meta.item;

                $("#nowPlayingImage").attr("src", track.album.images[0].url);

                var link = "<a class='btn btn-lg btn-link text-primary ps-0 ms-0 no-underline' target='_blank' href='" + track.external_urls.spotify + "'>" + track.name + "</a>";
                $("#nowPlayingTrack").html(link);

                var artists = track.artists.map(function (a) { return a.name }).join(", ");
                link = "<a class='btn btn-lg btn-link text-primary ps-0 pb-0 ms-0 no-underline' target='_blank' href='" + track.artists[0].external_urls.spotify + "'>" + artists + "</a>";
                $("#nowPlayingArtist").html(link);

                var time = track.duration_ms / 1000;
                var minutes = Math.floor(time / 60);
                var seconds = Math.round(time - (minutes * 60));
                $("#nowPlayingTimestamp").html(minutes + ":" + seconds);

                var triggerAgain = track.duration_ms - meta.progress_ms + 1000;
                setTimeout(getCurrentTrack, triggerAgain);

                var percentagePerSecond = (100 / (track.duration_ms / 1000)).toFixed(2);
                var currentPercentPlayed = (meta.progress_ms / track.duration_ms) * 100;
                $("#progressBar").attr("data-percentagepersecond", percentagePerSecond);


                $("#progressBar").css("width", currentPercentPlayed + "%");

                progressBarInterval = setInterval(increasePercentage, 1000);

                getCurrentQueue();
            }
            else if (response.StatusCode == 204) {
                disableQueueButton("No active player found");
            }
            else {
                $("#nowPlayingPane").hide();
            }
        });
    }

    function getCurrentQueue() {
        APIRequest("GetQueue", null, (response) => {
            var queueInfo = response.Payload;
            if (queueInfo.queue) {
                $("#nextUpList").empty();
                var min = Math.min(3, queueInfo.queue.length);
                for (var i = 0; i < min; i++) {

                    

                    var queuedTrack = queueInfo.queue[i];
                    var $queuedTrackCard = $("<div />").addClass("text-start").addClass("ps-4").addClass("pt-2");

                    $queuedTrackCard.append($("<h4 />").html(queuedTrack.name));

                    var artists = queuedTrack.artists.map(function (a) { return a.name }).join(", ");
                    $queuedTrackCard.append($("<p/>").html(artists));

                    var $artwork = $("<div />").addClass("text-start").append($("<img />").attr("src", queuedTrack.album.images[0].url).addClass("img-fluid").addClass("album-artwork"));
                    var $seperator = $("<div />").addClass("nextUpSeperator").addClass("fs-3").addClass("fw-bold").addClass("align-middle").html("&rArr;");

                    $("#nextUpList").append($seperator);
                    $("#nextUpList").append($artwork);
                    $("#nextUpList").append($queuedTrackCard);
                }
            }
        });
    }

    function increasePercentage() {
        var percentage = $("#progressBar")[0].style.width;
        var increase = parseFloat($("#progressBar").attr("data-percentagepersecond"));

        percentage = parseFloat(percentage.replace("%", ""));
        $("#progressBar").css("width", percentage + increase + "%");
    }

    function submitToQueue() {
        var trackLink = $("#trackLink").val();
        if (trackLink !== undefined && trackLink !== null && trackLink !== "") {
            var urlParts = trackLink.split("/");
            var trackUri = urlParts[urlParts.length - 1];
            if (trackUri !== "") {
                var trackId = trackUri.split("?")[0];
                verifyTrackId(trackId);
            }
            else {
                $("#trackLink").addClass("is-invalid");
                apiError("Submit to Queue - Track URI Could not be determined");
            }
        }
        else {
            $("#trackLink").addClass("is-invalid");
            apiError("Submit to Queue - Track Link is Empty");
        }
    }

    function verifyTrackId(trackId) {
        APIRequest("GetTrackInfo", { TrackUri: trackId }, processTrackInfoResponse);
    }

    function searchSong() {
        var searchText = $("#trackSeach").val();
        $("#track-search-results").empty();
        APIRequest("Search", { SearchText: searchText }, processTrackSearchResponse);
    }

    function processTrackInfoResponse(response) {
        if (response.StatusCode == 200) {
            $("#trackLink").removeClass("is-invalid");
            track = response.Payload;
            if (track != null) {
                $("#queuedTrack").html(track.name)

                var artists = track.artists.map(function (a) { return a.name }).join(", ");
                $("#queuedArtist").html(artists)

                var image = track.album.images[0].url;
                $("#queuedImage").attr("src", image);

                APIRequest("QueueTrack", { TrackUri: track.uri }, (response) => {
                    if (response.StatusCode == 204) {
                        var myToastEl = document.getElementById('resultToast')
                        var myToast = bootstrap.Toast.getOrCreateInstance(myToastEl)
                        myToast.show();

                        getCurrentQueue();

                        $("#trackLink").val("");
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

    function processTrackSearchResponse(response) {
        if (response.StatusCode == 200) {
            var tracks = response.Payload.tracks.items;
            var $trackSearchTemplate = $("[data-template='track-search-listing']");

            tracks.forEach(track => {
                var $trackSearch = $trackSearchTemplate.clone();

                $trackSearch.find("[data-field='artwork']").attr("src", track.album.images[0].url);

                var artists = track.artists.map(function (a) { return a.name }).join(", ");
                $trackSearch.find("[data-field='TrackTitle']").html(track.name);

                $trackSearch.find("[data-field='Artist']").html(artists);
                $trackSearch.find("[data-field='Album']").html(track.album.name);

                $trackSearch.find("[data-field='QueueTrack']").attr("onclick", "RoomControls.VerifyTrackId('" + track.id + "');")

                $trackSearch.removeClass("hidden");
                $("#track-search-results").append($trackSearch);
            });
        }
        else {
            $("#track-search-results").append("<p>Failed to get search results: " + response.Message + "</p>");
        }

    }

    function enableQueueButton() {
        $(".add-to-queue").removeAttr("disabled")
        $(".add-to-queue").removeClass("disabled");
        $(".add-to-queue").html("Queue");
        $("#nowPlayingPane").show();
    }

    function disableQueueButton(message) {
        $(".add-to-queue").attr("disabled", "disabled");
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
        //Append Room Code to Payload
        if (Data == null) { Data = {}; }
        Data.RoomCode = getRoomCode();

        //Send the Request via the API Handler
        APIHandler.Send("Room", Action, Data, Callback, apiError);
    }

    function getRoomCode() {
        var pathName = window.location.pathname;
        var urlParams = pathName.split('/');

        return urlParams[urlParams.length - 1];
    }

    function generateQR(currentUrl) {
        return "https://chart.googleapis.com/chart?cht=qr&choe=UTF-8&chs=400x400&chl=" + currentUrl;
    }

    return {
        GetCurrentTrack: function () {
            return getCurrentTrack();
        },
        ProcessTrackInfoResponse: function (track) {
            return processTrackInfoResponse(track);
        },
        SubmitToQueue: function () {
            return submitToQueue();
        },
        SearchSong: function () {
            return searchSong();
        },
        VerifyTrackId: function (trackId) {
            return verifyTrackId(trackId)
        },
        Init: function () {
            initRoom();
        }
    }

})(jQuery);
