<div x-data class="modal modal-sm fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">
                    <i class="bi bi-exclamation-octagon-fill"></i> Confirmation
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Post# <span x-text="$store.post.postId"></span></strong> will delete permanently. Are you
                    sure?</p>
            </div>
            <div class="modal-footer">
                <div class="spinner-border spinner-border-sm" role="status" x-show="$store.post.isDeleting">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <button type="button" class="btn btn-danger" @click="$store.post.confirm()"
                    x-bind:disabled="$store.post.isDeleting">Agreed</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    x-bind:disabled="$store.post.isDeleting">Cancel</button>
            </div>
        </div>
    </div>
</div>
