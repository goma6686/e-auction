@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div id="content" class="content content-full-width">
                <div class="profile">
                    <div class="profile-header">
                        <!-- profile-header-cover -->
                        <div class="profile-header-cover"></div>
                        <div class="profile-header-content">
                        <div class="profile-header-img">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcReMZX2wlBguwnabKRRtHGtsmUPuOQW50dRPA&usqp=CAU">
                        </div>
                        <div class="profile-header-info">
                            <h4 class="m-t-10 m-b-5">{{ $user->username }}</h4>
                        </div>
                        </div>
                    </div>
                    @if($user->is_active == 0)
                        <div class="container">
                            <h3 style="text-align: center;">This account has been deactivated:(</h3>
                        </div>
                    @else
                        @guest
                            @include('profile.profileactive')
                        @else
                            @if(Auth::user()->uuid == $user->uuid)
                                @include('profile.profilefull')
                            @else
                                @include('profile.profileactive')
                            @endif
                        @endguest
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection