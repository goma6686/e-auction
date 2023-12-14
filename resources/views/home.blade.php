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
      <div class="row">
        <div class="col">
          <div class="btn-group" role="group">
            <a class="btn btn-outline-dark" href="{{ route('home') }}">All</a>
            <a class="btn btn-outline-dark" href="{{ route('auctions') }}">Auctions</a>
            <a class="btn btn-outline-dark" href="{{ route('buy-now') }}">Buy Now</a>
          </div>
        </div>
        <div class="col text-end">
          <div class="dropdown">
            <button class="btn btn-outline-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
              Default sort
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
              <li><a class="dropdown-item" href="#">Lowest Price</a></li>
              <li><a class="dropdown-item" href="#">Highest price</a></li>
              <li><a class="dropdown-item" href="#">Ending soonest</a></li>
              <li><a class="dropdown-item" href="#">Newly listed</a></li>
            </ul>
          </div>
        </div>
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