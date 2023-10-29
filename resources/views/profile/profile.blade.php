@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
           <div id="content" class="content content-full-width">
              <div class="profile">
                 <div class="profile-header">
                    <!-- BEGIN profile-header-cover -->
                    <div class="profile-header-cover"></div>
                    <!-- END profile-header-cover -->
                    <!-- BEGIN profile-header-content -->
                    <div class="profile-header-content">
                       <!-- BEGIN profile-header-img -->
                       <div class="profile-header-img">
                              <img
                                 src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcReMZX2wlBguwnabKRRtHGtsmUPuOQW50dRPA&usqp=CAU">
                       </div>
                       <!-- END profile-header-img -->
                       <!-- BEGIN profile-header-info -->
                       <div class="profile-header-info">
                          <h4 class="m-t-10 m-b-5">{{ $user->username }}</h4>
                          @if(Auth::user()->uuid == $user->uuid && Auth::user()->is_active == 1)
                           <a href="#" class="btn btn-dark " role="button">Edit Profile</a>
                           <a href="#" role="button" class="btn btn-dark">Add Item</a>
                           <a href="#" role="button" class="btn btn-dark">Items Won</a>
                          @endif
                       </div>
                       <!-- END profile-header-info -->
                    </div>
                    <!-- END profile-header-content -->
              </div>
              <!-- begin profile-content -->
              <div class="profile-content">
                 <!-- begin tab-content -->
                 <div class="tab-content">
                    <!-- begin #profile-items tab -->
                    <div class="tab-pane fade active show mt-3" id="profile-items">
                      <div class="container mt-2">
                        @if($user->is_active)
                            @if (isset($items))
                            <div class="container px-4 px-lg-5 mt-5">
                            <div class="row gx-3 gy-3 row-cols-2 row-cols-md-3 row-cols-xl-3">
                            @foreach ($items as $item)
                                @if ($item->is_active == 1)
                                    @include('components.itemcard')
                                @endif
                            @endforeach
                            </div>
                            </div>
                            @else
                            <div class="container px-4 px-lg-5 mt-5">
                                <h3 style="text-align: center;">No items found :(</h3>
                            </div>
                            @endif
                        @elseif(Auth::user()->id == $user->id)
                           <div class="container px-4 px-lg-5 mt-5">
                              <h3 style="text-align: center;">Your account has been deactivated:(</h3>
                           </div>
                        @elseif(Auth::user()->id != $user->id)
                           <div class="container px-4 px-lg-5 mt-5">
                              <h3 style="text-align: center;">This account has been deactivated:(</h3>
                           </div>
                        @endif
                      </div>
                       <!-- end timeline -->
                    </div>
                    <!-- end #profile-post tab -->
                 </div>
                 <!-- end tab-content -->
              </div>
              <!-- end profile-content -->
           </div>
        </div>
     </div>
</div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection