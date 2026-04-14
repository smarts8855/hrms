    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Create Bank</h4>
            </div>

            <div class="panel-body">

                <form class="needs-validation" action="{{ route('banks.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank_name">Bank Name <span style="color:red">*</span></label>
                                <input type="text" class="form-control" name="bank_name" id="bank_name"
                                    placeholder="Bank name" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bank_code">Bank Code</label>
                                <input type="text" class="form-control" name="bank_code" id="bank_code"
                                    placeholder="Bank Code">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="sort_code">Sort Code <span style="color:red">*</span></label>
                                <input type="text" class="form-control" name="sort_code" id="sort_code"
                                    placeholder="Sort Code" required>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="recaptcha" id="recaptcha">

                    <button class="btn btn-primary" type="submit">Submit Form</button>
                </form>

            </div> <!-- panel-body -->
        </div> <!-- panel -->
    </div>
