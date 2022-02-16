<div class="toast-container position-absolute p-3 top-0 end-0 bg-dark text-primary">
    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" id="resultToast">
        <div class="toast-header">
            <strong class="me-auto"><i class="fab fa-spotify"></i> Song Queued</strong>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <div class="card">
                <img src="#" id="queuedImage" class="card-img-top img-fluid" alt="album-art" />
                <div class="card-body bg-dark text-primary">
                    <h5 id="queuedTrack" class="card-title"></h5>
                    <p class="text-muted">by</p>
                    <p id="queuedArtist" class="card-text"></p>
                </div>
            </div>
        </div>
    </div>
</div>