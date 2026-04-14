<div class="modal fade" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="attachmentModalLabel">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('attachment.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="staff_id" value="{{ $staffId }}">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="attachmentModalLabel">Add Attachment</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Description</label>
                        @php
                            $filedescs = [
                                'Application Letter',
                                'Letter of Appointment',
                                'Birth Certificate',
                                'Certificate of Indine',
                                'GEN 75',
                                'NIMC Slip',
                            ];
                        @endphp
                        <select name="filedesc" class="form-control">
                            <option value="">-- Select --</option>
                            @foreach ($filedescs ?? [] as $filedesc)
                                <option value="{{ $filedesc }}">
                                    {{ $filedesc }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>File</label>
                        <input type="file" name="filepath" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Upload</button>
                </div>
            </div>
        </form>
    </div>
</div>
