var APIHandler = (function($) {

    function sendRequestToAPI(area, action, payload, successcallback, failurecallback)
    {
        $.ajax({
            url: "/api.php",
            type: "POST",
            contentType: "application/json",
            dataType: "json",
            data: JSON.stringify({
                "Area": area,
                "Action": action,
                "SessionID": localStorage.getItem('SessionID'),
                "Payload": payload
            }),
            success: successcallback,
            error: failurecallback
        });
    }

    return {
        Send: function(area, action, payload, successcallback, failurecallback) {
            return sendRequestToAPI(area, action, payload, successcallback, failurecallback);
        }
    }

})(jQuery);