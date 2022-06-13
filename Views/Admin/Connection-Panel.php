<div class="my-3 row align-middle" id="roomCodeControlPane">
    <h6 class="mb-3">Room Information</h6>
    <div class="col-sm-8 input-lg mb-3">		
        <label for="RoomName" class="form-label">Room Name</label>					
        <input type="text" id="RoomName" name="RoomName" placeholder="Room Name" class="form-control" value="Room-123456" maxlength="20"/>
    </div>
    <div class="col-sm-4 input-lg mb-3">							
        <label for="RoomCode" class="form-label">Room Code</label>
        <div class="input-group">
            <input type="text" id="RoomCode" name="RoomCode" placeholder="Room Code" class="form-control" value="123456" maxlength="8"/>
            <button class="btn btn-primary text-white action-random" type="button"><i class="fa-solid fa-dice"></i></button>
        </div>
    </div>
</div>

<hr />
<p id="expiryBanner">Expires in 120 minutes</p>

<hr />

<div class="my-3 d-flex flex-row flex-wrap align-items-stretch gap-4" id="controlsPane">
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