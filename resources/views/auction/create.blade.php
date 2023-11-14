@extends('layouts.main')

@section('content')
<div class="py-12">
    <h1 class="latest text-center mb-2">Create Auction</h1>
    <div class="max-w-7xl sm:px-6 lg:px-8 p-5">
        @livewire('create-auction', ['categories' => $categories])
    </div>
</div>
<script type="text/javascript">
    config = {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "\Carbon\Carbon::now()->toDateString()",
    }

    flatpickr("input[type=datetime-local]", config);
</script>
@endsection