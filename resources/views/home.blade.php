@extends('layouts.main')

  @section('content')
      @section('sidebar')
        @include('layouts.sidebar')
      @endsection
   
    <div class="col-md-10">
      <div class="row">
          @foreach ($auctions as $auction)
          <div class="col-6 card-group">
              @include('components.itemcard')
          </div>
          @endforeach
        {!! $auctions->links() !!}
      </div>
    </div>
  @endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection