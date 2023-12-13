@extends('layouts.main')
  @section('sidebar')
    @include('layouts.sidebar')
  @endsection
  @section('content')
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
    <div class="mt-4">
      <div class="btn-group" role="group">
        <a class="btn btn-outline-dark" href="{{ route('home') }}">All</a>
        <a class="btn btn-outline-dark" href="{{ route('auctions') }}">Auctions</a>
        <a class="btn btn-outline-dark" href="{{ route('buy-now') }}">Buy Now</a>
      </div>
      <div class="items mt-4">
        <div class="row">
            @foreach ($auctions as $auction)
            <div class="col-4 card-group">
                @include('components.itemcard')
            </div>
            @endforeach
          {!! $auctions->links() !!}
        </div>
      </div>
    </div>
    
    
  @endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection