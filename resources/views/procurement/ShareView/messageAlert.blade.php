<div class="row">
      <div class="col-lg-12">
        
        @if (count($errors) > 0)
        <div class="alert alert-info alert-dismissible text-left" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          @foreach ($errors->all() as $error)
          <p>{{ $error }}</p>
          @endforeach
        </div>
        @endif

        @if(session('message'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <!--<strong>Success!</strong><br /> -->
          {{ session('message') }}
        </div>                        
        @endif

        @if(session('error'))
        <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <!--<strong>Not Success!</strong><br /> -->
          {{ session('error') }}
        </div>                        
        @endif
        
        @if(session('msg'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
            <strong>Success!</strong> {{ session('msg') }}
        </div>
        @endif
        @if(session('err'))
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                <!--<strong>Operation Error !<br>-->
                </strong> {{ session('err') }}
            </div>
        @endif 
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <!--<strong>Success!</strong><br />--> 
          {{ session('success') }}
        </div>                        
        @endif
        
         @if(session('info'))
        <div class="alert alert-info alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
          </button>
          <!--<strong>Success!</strong><br />--> 
          {{ session('info') }}
        </div>                        
        @endif
        
      </div>
</div>



