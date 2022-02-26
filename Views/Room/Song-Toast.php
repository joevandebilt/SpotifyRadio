<div class="toast-container position-absolute top-0 end-0 p-3" id="toastPlacement" aria-live="polite" aria-atomic="true">
    <div class="toast hide" id="resultToast">
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