var AdminControls = (function($) {

    $(document).ready(function() { 

        debugOutput("Loading...");
        APIHandler.Send("Admin", "GetRoomInfo", null, InitDashboard, apiError);
    });

    function InitDashboard(response)
    {
        if (response.StatusCode == 200) {
            var roomInfo = response.Payload;

            //Clear the input panel
            $("#connectionPane").empty();

            //Room Code
            if (roomInfo.RoomName !== "" && roomInfo.RoomCode !== "") {
                debugOutput("Loaded Admin for room "+roomInfo.RoomCode);
                $("#RoomName").val(roomInfo.RoomName);
                $("#RoomCode").val(roomInfo.RoomCode);
                $("#roomLink").attr("href", roomUrl());
                $("#roomLink").html(roomUrl());
                $("#qrCodeImage").attr("src", generateQR());

                $("#connectionPane").append("<p>Room Connected <i class='fas fa-check'></i></p>");
            }
            else 
            {
                debugOutput("Could not load or create room information");
                $("#connectionPane").append("<p>Room Connected <i class='fas fa-times'></i></p>");
                disableButton(".action-save");
                disableButton(".action-connect");
                disableButton(".action-extend");
                disableButton(".action-disconnect");
            }

            //Spotify Connection
            debugOutput("Checking for Spotify Connection");
            if (roomInfo.AccessToken !== "") {
                debugOutput("Spotify Account Connected");
                $("#connectionPane").append("<p>Connected to Spotify <i class='fas fa-check'></i></p>");
                disableButton(".action-connect");

                //Expiry
                if (roomInfo.ExpiryTime !== null) {
                    var expiryTime = new Date(roomInfo.ExpiryTime * 1000);
                    $("#connectionPane").append("<p>Connection Expires at " + expiryTime.toLocaleString() + "</p>");

                    debugOutput("Ready!");
                }
            }
            else {
                debugOutput("Spotify access token not found - please connect to your spotify account");
                $("#connectionPane").append("<p>Connected to Spotify <i class='fas fa-times'></i></p>");

                enableButton(".action-connect");
                disableButton(".action-extend");
                disableButton(".action-disconnect");
            }
        }
        else 
        {
            debugOutput("Error Getting Room Info ("+ response.StatusCode +"): "+response.Message);
            disableButton(".action-save");
            disableButton(".action-connect");
            disableButton(".action-extend");
            disableButton(".action-disconnect");
        }
    }

    function SaveRoomInfo() {
        debugOutput("Saving Room Information");
        var data = { 
            "RoomName": $("#RoomName").val(),
            "RoomCode": $("#RoomCode").val() 
        };
        APIHandler.Send("Admin", "UpdateRoomCode", data, InitDashboard, apiError);
    }

    function extendConnection() {
        APIHandler.Send("Admin", "ExtendTimeout", null, InitDashboard, apiError);
    }

    function disconnectSession() {
        APIHandler.Send("Admin", "DisconnectSession", null, InitDashboard, apiError);
    }

    function openAuthWindow() {
        var authWindow = window.open("https://spotify.nkode.uk/authorize.php", "", "width=400,height=500");
        var timer = setInterval(function() { 
            if(authWindow.closed) {
                clearInterval(timer);
                location.reload();
            }
        }, 1000);
    }

    function roomUrl() {
        var roomCode = $("#RoomCode").val();
        var roomUrl = "https://spotify.nkode.uk/room/"+roomCode;
        return roomUrl;
    }

    function generateQR() {
        return "https://chart.googleapis.com/chart?cht=qr&choe=UTF-8&chs=400x400&chl="+roomUrl();
    }

    function apiError(xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
    }

    function enableButton(selector) {
        $(selector).removeAttr("disabled");
        $(selector).removeClass("disabled");
    }

    function disableButton(selector) {
        $(selector).attr("disabled", "disabled");
        $(selector).addClass("disabled");
    }

    function debugOutput(message) {
        $("#informationWindow").append(message+"\r\n");
    }

    return {
        AuthWithSpotify: function() {
            return openAuthWindow();
        },
        SaveRoomInfo: function() {
            return SaveRoomInfo();
        },
        GenerateQR: function() {
            return generateQR();
        },
        ExtendExpiry: function() {
            return extendConnection();
        },
        DisconnectFromSpotify: function() {
            return disconnectSession();
        }
    }

})(jQuery);