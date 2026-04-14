
   
<div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title" style="margin-bottom:30px">Create Bank</h4>
                
                <form class="needs-validation" action="{{route('banks.store')}}" method="POST">
                     @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bank_name">Bank name <span class="astericks" style="color:red">*</span></label>
                                <input type="text" class="form-control" name="bank_name"id="Bank_name" placeholder="Bank name" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="bank_code">Bank Code</label>
                                <input type="text" class="form-control" name="bank_code" id="bank_code" placeholder="Bank Code">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="sort_code">Sort Code <span class="astericks" style="color:red">*</span></label>
                                <input type="text" class="form-control" name="sort_code" id="sort_code" placeholder="Sort Code" required>
                            </div>
                        </div>
                       
                    </div>
                    <input type="hidden" name="recaptcha" id="recaptcha">,
                    
                    <button class="btn btn-primary" type="submit">Submit form</button>
                </form>
            </div>
        </div>
        <!-- end card -->
    </div> <!-- end col -->