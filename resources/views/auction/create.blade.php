@extends('layouts.form')

@section('content')
<div class="py-12 row">
    <h1 class="latest text-center mb-2">
        @if ($type === '1')
            Create listing
        @else
            Create Auction
        @endif
    </h1>
    <div class="col-md-2 col-lg-2"></div>
    <div class="col px-5">
        @livewire('create-auction', ['type' => $type])
    </div>
    <div class="col-md-2 col-lg-2"></div>
</div>
@endsection