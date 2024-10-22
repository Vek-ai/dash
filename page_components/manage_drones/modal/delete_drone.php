<!-- Delete Confirmation Modal -->
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteDroneLabel">Delete Drone</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this drone?</p>
            <div id="deleteResponseMessage" style="margin-top: 15px;"></div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
        </div>
    </div>
</div>