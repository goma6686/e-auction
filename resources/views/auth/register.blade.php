@extends('layouts.form')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card bg-light">
            <div class="card-header text-center">Register</div>
            <div class="card-body">
                <form method="POST" action="{{ route('store') }}">
                    @csrf
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">email</label>
                        
                        <div class="col-md-6">
                            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" required autofocus>  
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>
                        
                        <div class="col-md-6">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" required autofocus>  
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end">Password</label>
                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" >
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-auto offset-md-4">
                            <button type="submit" class="btn btn-dark">
                                Register
                            </button>
                        </div>
                    </div>

                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-3">
                            @if(Session::has('error'))
                                <div class="d-flex alert alert-danger">
                                    <ul class="mx-auto justify-content-center">
                                    @foreach ( Session::pull('error') as $error )
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection