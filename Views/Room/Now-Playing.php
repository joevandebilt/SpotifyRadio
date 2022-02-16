<div class="mt-4 ml-2 mr-2 row" id="nowPlayingPane">    
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button bg-dark text-white collapsed " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    Currently Playing
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-dark text-primary">						
                    <div class="row">
                        <div class="col-sm-3 p-0">
                            <img class="img-fluid img-thumbnail" id="nowPlayingImage" alt="Now playing artwork" />
                        </div>			
                        <div class="col-sm-9 text-center text-sm-start fs-2">
                            <h2 id="nowPlayingTrack"></h2>
                            <p id="nowPlayingArtist"></p>
                            <strong id="nowPlayingTimestamp"></strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>			
</div>