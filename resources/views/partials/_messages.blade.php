@if (Session::has('success'))
    <div class="container">
        <div class='messages-container'>
            <div class="container-small">
                <div class="alert alert-success" role="alert">
                    <strong>Success:</strong> {!! Session::get('success') !!}
                </div>
            </div>
        </div>
    </div>
@endif

@if (Session::has('warning'))
    <div class="container">
        <div class='messages-container'>
            <div class="container-small">
                <div class="alert alert-warning" role="alert">
                    <strong>Warning:</strong> {!! Session::get('warning') !!}
                </div>
            </div>
        </div>
    </div>
@endif

@if (($errors) && (count($errors)>0))
    <div class="container">
        <div class='messages-container'>
            <div class="container-small">
                <div class="alert alert-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif




