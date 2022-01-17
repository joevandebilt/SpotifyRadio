var APIHandler = (function($) {

    function sendRequestToAPI(area, action, payload, successcallback, failurecallback)
    {
        $.ajax({
            url: "/api.php",
            type: "POST",
            data: {
                "Area": area,
                "Action": action,
                "Payload": payload
            },
            success: successcallback,
            error: failurecallback
        });
    }


    return {
        Send: function(area, action, payload, callback, successcallback, failurecallback) {
            return sendRequestToAPI(area, action, payload, successcallback, failurecallback);
        }
    }

})(jQuery);