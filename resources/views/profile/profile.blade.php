@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div id="content" class="content content-full-width">
            <div class="profile">
                @if($user->is_active == 0)
                    <div class="container">
                        <h3 style="text-align: center;">This account has been deactivated:(</h3>
                    </div>
                @else
                    {{--@include('profile.profileactive', ['auctions' => $user->ActiveUserAuctions()])--}}
                    <div class="profile-header">
                        <!-- profile-header-cover -->
                        <div class="profile-header-cover"></div>
                        <div class="profile-header-content">
                            <div class="profile-header-img" id="non-mobile">
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcReMZX2wlBguwnabKRRtHGtsmUPuOQW50dRPA&usqp=CAU">
                            </div>
                            <div class="profile-header-info d-grid gap-3">
                                <h4 class="ps-3">{{ $user->username }}</h4>
                                <h4 class="ps-3">{{ $user->email }}</h4>
                            </div>
                            @auth
                                @if (Auth::user()->uuid == $user->uuid)
                                    <a class="m-3 btn btn-outline-light" href="/dashboard/{{Auth::user()->uuid}}" role="button">Dashboard</a>
                                @endif
                            @endauth
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row d-flex flex-wrap justify-content-evenly">
        @if(count( $user->ActiveUserAuctions()) > 0)
            @foreach ( $user->ActiveUserAuctions() as $auction)
                @include('auction.components.itemcard')
            @endforeach
        @else
            <h3 style="text-align: center;">No items found :(</h3>
        @endif
    </div>
</div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection