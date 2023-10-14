@extends('layouts.main')

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
  <div class="row">
    @foreach ($all_items as $item)
      @include('components.itemcard')
    @endforeach
  </div>
  {!! $all_items->render() !!}
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection
