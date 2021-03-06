
<h4 class="my-3">Your Spotify Room</h4>
<p id="expiryBanner" data-expiry="">Expires in 120 minutes</p>
<hr />

<div class="my-3 text-start" id="roomCodeControlPane">
    <div class="form-group my-4">
        <label for="RoomName" class="form-label d-lg-none h6">Room Name</label>
        <div class="input-group input-group-lg">						
            <span for="RoomName" class="input-group-text bg-primary btn-primary text-white d-none d-lg-block">Room Name</span>
            <input type="text" id="RoomName" name="RoomName" placeholder="Room Name" class="form-control" value="Room-123456" maxlength="20"/>
        </div>
    </div>

    <div class="form-group my-4">    
        <label for="RoomName" class="form-label d-lg-none h6">Join Code</label>
        <div class="input-group input-group-lg">
            <span for="RoomName" class="input-group-text bg-primary btn-primary text-white d-none d-lg-block"">Join Code</span>
            <input type="text" id="RoomCode" name="RoomCode" placeholder="Room Code" class="form-control" value="123456" maxlength="8"/>
            <button class="btn btn-primary text-white action-random" type="button">
                <span class="d-lg-none"><i class="fa-solid fa-dice"></i></span>
                <span class="d-none d-lg-block"> <i class="fa-solid fa-dice"></i> Randomize</span>
            </button>
        </div>
    </div>

</div>

<hr />

<div class="my-4 d-flex flex-row flex-wrap align-items-stretch gap-4" id="controlsPane">
    <button type="button" class="btn btn-lg btn-primary flex-grow-1 action-save" onclick="AdminControls.SaveRoomInfo()">
        <i class="fas fa-save"></i> Save Room
    </button>
    <button type="button" class="btn btn-lg btn-success flex-grow-1 action-connect" onclick="AdminControls.AuthWithSpotify()">
        <i class="fab fa-spotify"></i> Connect to Spotify
    </button>
    <button type="button" class="btn btn-lg btn-secondary flex-grow-1 action-extend" onclick="AdminControls.ExtendExpiry()">
        <i class="fas fa-clock"></i> Extend Expiry
    </button>
    <button type="button" class="btn btn-lg btn-warning  flex-grow-1 action-disconnect" onclick="AdminControls.DisconnectFromSpotify()">
        <i class="fas fa-plug"></i> Disconnect from Spotify
    </button>
    <a href="/logout.php" class="btn btn-lg btn-danger flex-grow-1 action-destroy">
        <i class="fas fa-bomb"></i> Clear all Data
    </a>
</div>