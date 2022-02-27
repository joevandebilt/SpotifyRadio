function NavigateToRoom() {
    var roomCode = $("#RoomCode").val();
    if (roomCode != "") {
        window.location = "https://spotify.nkode.uk/room/"+roomCode;
    }
}

function recaptchaSiteKey() {
    var url = $("#recaptchaScript").attr("src");
    var urlParts = url.split('=');
    return urlParts.pop();
}

window.addEventListener("load", function(e) {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});