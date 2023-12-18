<div x-data="{show: true}" x-init="setTimeout(() => show = false, 5000)" x-show="show">
    @if(Session::has('error'))
    <div class="d-flex alert alert-danger">
        <ul class="mx-auto justify-content-center">
            <li>{{ session()->get('error') }}</li>
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
</div>