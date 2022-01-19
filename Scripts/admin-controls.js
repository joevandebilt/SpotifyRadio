var AdminControls = (function($) {

    $(document).ready(function() { 

        debugOutput("Hello World");
        APIHandler.Send("Admin", "GetRoomInfo", null, InitDashboard, apiError);
    });

    function InitDashboard(response)
    {
        if (response.StatusCode == 200) {
            var roomInfo = response.Payload;

            if (roomInfo.RoomCode !== "") {
                $("#RoomCode").val(roomInfo.RoomCode);
                $("#roomLink").attr("href", RoomUrl());
                $("#roomLink").html(RoomUrl());
                $("#qrCodeImage").attr("src", generateQR());

                $("#infoPane").append("<p>Room Connected: true</p>");
            }
            else 
            {
                $("#infoPane").append("<p>Room Connected: false</p>");
            }
        }
        else 
        {
            debugOutput("Error Getting Room Info ("+ response.StatusCode +"): "+response.Message);
        }
    }

    function openAuthWindow() {
        var authWindow = window.open("https://spotify.nkode.uk/authorize.php", "", "width=400,height=500");
        authWindow.addEventListener('beforeunload', function(e){
            location.reload();
        });
    }

    function RoomUrl() {
        var roomCode = $("#RoomCode").val();
        var roomUrl = "https://spotify.nkode.uk/room/"+roomCode;
        return roomUrl;
    }

    function generateQR() {
        return "https://chart.googleapis.com/chart?cht=qr&choe=UTF-8&chs=400x400&chl="+RoomUrl();
    }

    function apiError(xhr, ajaxOptions, thrownError) {
        console.log(xhr);
        console.log(ajaxOptions);
        console.log(thrownError);
    }

    function debugOutput(message) {
        $("#informationWindow").append(message+"\r\n");
    }

    return {
        AuthWithSpotify: function(){
            return openAuthWindow();
        },
        SaveRoomInfo: function() {
            
        },
        GenerateQR: function() {
            return generateQR();
        },
        ExtendExpiry: function() {
            
        },
        DisconnectFromSpotify: function() {
            
        }
    }

})(jQuery);