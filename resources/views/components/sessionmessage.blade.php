<div x-data="{show: true}" x-init="setTimeout(() => show = false, 10000)" x-show="show">
    @if(Session::has('errors'))
    <div class="d-flex alert alert-danger">
        <ul class="mx-auto justify-content-center">
        @if (is_string(session()->get('errors')))
            <li>{{ session()->get('errors') }}</li>
        @else
            @foreach (session()->get('errors')->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        @endif
        </ul>
    </div>
    @endif
    @if(Session::has('success'))
    <div class="d-flex alert alert-success">
        <ul class="mx-auto justify-content-center">
            @if (is_string(session()->get('success')))
            <li>{{ session()->get('success') }}</li>
        @else
            @foreach (session()->get('success')->all() as $success)
                <li>{{$success}}</li>
            @endforeach
        @endif
        </ul>
    </div>
    @endif
    @if(Session::has('error'))
    <div class="d-flex alert alert-danger">
        <ul class="mx-auto justify-content-center">
            @if (is_string(session()->get('error')))
                <li>{{ session()->get('error') }}</li>
            @else
                @foreach (session()->get('error') as $error)
                    <li>{{$error}}</li>
                @endforeach
            @endif
        </ul>
    </div>
    @endif
</div>