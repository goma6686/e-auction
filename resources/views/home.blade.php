@extends('layouts.main')

  @section('content')
      @section('sidebar')
        @include('layouts.sidebar')
      @endsection
   
    <div class="col-md-10">
      <div class="row">
          @foreach ($all_items as $item)
          <div class="col-6">
              @include('components.itemcard')
          </div>
          @endforeach
        {!! $all_items->links() !!}
      </div>
    </div>
  @endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection