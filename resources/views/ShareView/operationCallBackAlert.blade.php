
<div class="">
      <div class="col-md-12 mt-2 mb-2">

          @if ((count($errors) > 0))
          <div class="text-left alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
            @foreach ($errors->all() as $error)
              {{ $error }}<br />
            @endforeach
          </div>
          @endif

          @if(session('message'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
             {!! session('message') !!}
          </div>
          @endif
          
          @if(session('msg'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
             {!! session('msg') !!}
          </div>
          @endif
          
          @if(session('success'))
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
             {!! session('success') !!}
          </div>
          @endif

          @if(session('info'))
          <div class="alert alert-info alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
             {!! session('info') !!}
          </div>
          @endif

          @if(session('error'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
             {!! session('error') !!}
          </div>
          @endif
          
          @if(session('err'))
          <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
            </button>
             {!! session('err') !!}
          </div>
          @endif
      </div>
</div>

