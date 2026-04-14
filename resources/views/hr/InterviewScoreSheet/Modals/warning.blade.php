<div class="modal fade" id="delModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: red;">
                <h5 class="modal-title">Delete Confirmation!!!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('Score.delete') }}" method="get">
                <div class="modal-body">
                    Are you sure you want to delete this Score Sheet??
                    <input type="hidden" name="id" id="delID" value="{{ session('deleteModal') }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-danger" value="Delete">
                </div>
            </form>

        </div>
    </div>
</div>
