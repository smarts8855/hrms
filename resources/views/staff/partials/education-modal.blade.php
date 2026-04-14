<div class="modal fade" id="educationModal" tabindex="-1" role="dialog" aria-labelledby="educationModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{ route('education.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="staff_id" value="{{ $staffId }}">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="educationModalLabel">Add Education</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category</label>
                        <select name="educations[0][categoryID]" class="form-control" required>
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->edu_categoryID }}">{{ $cat->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Document</label>
                        <input type="file" name="educations[0][document]" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
