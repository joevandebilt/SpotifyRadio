var APIHandler = (function($) {

    function sendRequestToAPI(area, action, payload, successcallback, failurecallback)
    {
        grecaptcha.ready(function() {
            grecaptcha.execute(recaptchaSiteKey(), {action: 'submit'}).then(function(token) {
                // Add your logic to submit to your backend server here.
        
                $.ajax({
                    url: "/api.php",
                    type: "POST",
                    contentType: "application/json",
                    dataType: "json",
                    data: JSON.stringify({
                        "Area": area,
                        "Action": action,
                        "SessionID": localStorage.getItem('SessionID'),
                        "Payload": payload,
                        "RecpatchaToken": token
                    }),
                    success: successcallback,
                    error: failurecallback
                });
            });
        });
    }

    return {
        Send: function(area, action, payload, successcallback, failurecallback) {
            return sendRequestToAPI(area, action, payload, successcallback, failurecallback);
        }
    }

})(jQuery);