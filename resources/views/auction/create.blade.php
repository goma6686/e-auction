@extends('layouts.form')

@section('content')
<div class="py-12">
    <h1 class="latest text-center mb-2">
        @if ($type === '1')
            Create listing
        @else
            Create Auction
        @endif
    </h1>
    <div style="padding-left: 20em; padding-right: 20em;">
        @livewire('create-auction', ['type' => $type])
    </div>
</div>
@endsection