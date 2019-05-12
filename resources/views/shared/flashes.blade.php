@if(session()->has('success'))
    <div class="row bd-flash-messages">
        <div class="col-12 success alert-success">
            {{ session()->get('success') }}
        </div>
    </div>
@endif

@if(session()->has('error'))
    <div class="row bd-flash-messages">
        <div class="col-12 danger alert-danger">
            {{ session()->get('error') }}
        </div>
    </div>
@endif