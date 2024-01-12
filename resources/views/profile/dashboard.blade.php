@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div id="content" class="content content-full-width">
                <h3 class="text-start"><b>{{Auth::user()->username}} dashboard</b></h3>
                <div class="profile">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="all-tab" href="#all" data-bs-toggle="tab" data-bs-target="#all"role="tab" aria-controls="all" aria-selected="true">Edit Auctions</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="payment-tab" href="#payment" data-bs-toggle="tab" data-bs-target="#payment"role="tab" aria-controls="payment" aria-selected="false">Waiting for payment</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="bids-tab" href="#bids" data-bs-toggle="tab" data-bs-target="#bids" role="tab" aria-controls="bids" aria-selected="false">Active Bids</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="won-tab" href="#won" data-bs-toggle="tab" data-bs-target="#won" role="tab" aria-controls="won" aria-selected="false">Won Auctions</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="favourite-tab" href="#favourite" data-bs-toggle="tab" data-bs-target="#favourite" role="tab" aria-controls="favourite" aria-selected="false">Favourites</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="history-tab" href="#history" data-bs-toggle="tab" data-bs-target="#history" role="tab" aria-controls="history" aria-selected="false">History</a>
                        </li>
                        <div class="a" >
                            <a class="nav-link"  href="/dashboard/{{Auth::user()->uuid}}/messages">Messages</a>
                        </div>
                    </ul>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                        @if(count(Auth::user()->AllUserAuctions()) > 0)
                            @include('components.sessionmessage')
                            @includeWhen(count(Auth::user()->getActionRequiredAuctions()), 'auction.components.auctiontable', ['all_auctions' => Auth::user()->getActionRequiredAuctions(), 'text' => 'Auctions that need your attention:'])
                            @include('auction.components.auctiontable', ['all_auctions' => Auth::user()->AllUserAuctions(), 'text' => 'All auctions:'])
                        @else
                            <h3 style="text-align: center;">No listings found :(</h3>
                        @endif
                        </div>
                        <div class="tab-pane fade" id="bids" role="tabpanel" aria-labelledby="bids-tab">
                            @include('components.list', ['list' => Auth::user()->getActiveBids(), 'word' => 'active'])
                        </div>
                        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                            @include('auction.components.payment', ['word' => 'payment'])
                        </div>
                        <div class="tab-pane fade" id="won" role="tabpanel" aria-labelledby="won-tab">
                            @include('auction.components.won')
                        </div>
                        <div class="tab-pane fade" id="favourite" role="tabpanel" aria-labelledby="favourite-tab">
                            @include('components.list', ['list' => Auth::user()->getFavouriteAuctions(), 'word' => 'favourited'])
                        </div>
                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection