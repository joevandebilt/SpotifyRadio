<div class="my-3 text-center" id="helpPane">
    <p>Search for something on Spotify</p>
</div>

<div class="my-3 row" id="queuePane">      
    <div class="col-sm-12 my-3">

        <div class="form-group d-flex flex-row">
            <input type="text" class="form-control" id="trackSeach" name="trackSearch" />
            <button type="button" class="btn btn-primary ms-2" onclick="RoomControls.SearchSong();">Search</button>
        </div>
    </div>

    <div class="col-sm-12 my-3">
        <div class="list-group" id="track-search-results"></div>
        
        <div class="list-group-item border-0 row py-2 bg-dark d-flex flex-row hidden" data-template="track-search-listing">
            <div class="col-3 p-0 d-none d-lg-block">
                <img src="" class="img-fluid img-thumbnail img-search-result" data-field="artwork" />
            </div>
            <div class="col-4 p-0 d-lg-none">
                <img src="" class="img-fluid img-thumbnail img-search-result" data-field="artwork" />
                <button type="button" class="btn btn-primary flex-grow-1 w-100 add-to-queue " onclick="return;" data-field="QueueTrack">Queue</button>
            </div>
            <div class="col-8 col-md-6 p-0 text-white">
                <h3 data-field="TrackTitle"></h3>
                <h6 data-field="Artist"></h6>
                <p data-field="Album"></p>
            </div>
            <div class="col-3 py-auto d-none d-lg-block">
                <button type="button" class="btn btn-primary flex-grow-1 w-100 add-to-queue" onclick="return;" data-field="QueueTrack">Queue</button>
            </div>
        </div>

    </div>
</div>