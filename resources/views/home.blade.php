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
            <a class="btn btn-outline-dark" href="{{ route('home', ['type' => 'Auction', 'category' => $category]) }}">Auctions</a>
            <a class="btn btn-outline-dark" href="{{ route('home', ['type' => 'Buy-Now', 'category' => $category]) }}">Buy Now</a>
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
      <div class="items mt-4" >
        <div class="row">
          @livewire('search-auctions', ['category' => $category, 'type' => $type])
        </div>
        </div>
      </div>
  @endsection
  @section('scripts')
  <script src="https://cdn.jsdelivr.net/npm/algoliasearch@4.22.0/dist/algoliasearch-lite.umd.js" integrity="sha256-/2SlAlnMUV7xVQfSkUQTMUG3m2LPXAzbS8I+xybYKwA=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/instantsearch.js@4.62.0/dist/instantsearch.production.min.js" integrity="sha256-nXIfriS+Lsxm+4lKjyIuaeo1kkt4qmWB+QvNY7Nx6X4=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@algolia/autocomplete-js@1.12.2/dist/umd/index.production.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@algolia/autocomplete-plugin-query-suggestions@1.12.2/dist/umd/index.production.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@algolia/autocomplete-plugin-recent-searches@1.12.2/dist/umd/index.production.min.js"></script>

  @endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/instantsearch.css@8.1.0/themes/reset-min.css" integrity="sha256-2AeJLzExpZvqLUxMfcs+4DWcMwNfpnjUeAAvEtPr0wU=" crossorigin="anonymous">

@endsection