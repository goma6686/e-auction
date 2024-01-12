@extends('layouts.main')
@section('content')
<div class="container">
  <div class="row ">
    <h3 class="col text-start"><b>All Messages</b></h3>
    <p class="text-end col">
      <a class="btn btn-dark " href="/dashboard/{{Auth::user()->uuid}}" role="button">Dashboard</a>
    </p>
  </div>
  <section class="row  border-top border-dark border-2">
    <div class="col">
      <ul class="list-group">
        {{--@foreach (Auth::user()->getWonAuctions() as $index => $auction)
          <li class="list-group-item">
            <input class="form-check-input me-1" type="checkbox" aria-label="...">
            {{$auction->title}}
          </li>
        @endforeach--}}
        <li class="list-group-item">
          <input class="form-check-input me-1" type="checkbox" aria-label="...">
          {{$auction->title}}
        </li>
      </ul>
    </div>
    <div class="col-8">
      <div class="card border">

        @livewire('chat', ['auction' => $auction, 'receiver' => $receiver])

        
      </div>
    </div>
  </section>
</div>
@livewireScriptConfig 
@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('js/chat.js')}}"></script>
  @include('scripts.pusher-chat')
@endsection
@endsection
@section('styles')
  <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection