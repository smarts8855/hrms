<!-- Page Header -->
<div class="row" style="margin-bottom: 20px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
    <div class="col-xs-12 col-sm-8">
        <h4 style="margin: 0;">Hi, welcome back!</h4>
        <p class="text-muted" style="text-transform: uppercase; margin: 0;">
            {{ Auth::user()->name }}
            {{-- @if (Auth::user()->role_id == 1)
                Super Admin
            @elseif (Auth::user()->role_id == 2)
                Branch: {{ optional(Auth::user()->branch)->name ?? 'Headquarter' }} -
                Role: {{ optional(Auth::user()->role)->name }}
            @elseif (Auth::user()->role_id == 3)
                Branch: {{ optional(Auth::user()->branch)->name ?? 'Headquarter' }} -
                Role: {{ optional(Auth::user()->role)->name }}
            @elseif (Auth::user()->role_id == 4)
                Branch: {{ optional(Auth::user()->branch)->name ?? 'Headquarter' }} -
                Role: {{ optional(Auth::user()->role)->name }}
            @else
                Branch: {{ optional(Auth::user()->branch)->name ?? 'Headquarter' }} -
                Role: {{ optional(Auth::user()->role)->name }}
            @endif --}}
        </p>
    </div>

    {{-- <div class="col-xs-12 col-sm-4 text-right hidden-xs">
        <a href="{{ url()->previous() }}" class="btn btn-default btn-sm">
            <span class="glyphicon glyphicon-arrow-left"></span> Back
        </a>
    </div> --}}
</div>
<!-- End Page Header -->
