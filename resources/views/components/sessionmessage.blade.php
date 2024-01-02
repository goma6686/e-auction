<div x-data="{show: true}" x-init="setTimeout(() => show = false, 10000)" x-show="show">
    @if(Session::has('errors'))
    <div class="d-flex alert alert-danger">
        <ul class="mx-auto justify-content-center">
            <li>{{ session()->get('errors') }}</li>
        </ul>
    </div>
    @endif
    @if(Session::has('success'))
    <div class="d-flex alert alert-success">
        <ul class="mx-auto justify-content-center">
            <li>{{ session()->get('success') }}</li>
        </ul>
    </div>
    @endif
    @if(Session::has('error'))
    <div class="d-flex alert alert-danger">
        <ul class="mx-auto justify-content-center">
            @foreach (session()->get('error') as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>