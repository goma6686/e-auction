@extends('layouts.form')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card bg-light">
            <div class="card-header text-center">Login</div>

            <div class="card-body">
                <form method="POST" action="{{ route('authenticate') }}">
                    @csrf

                    <div class="row mb-3">
                        <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>

                        <div class="col-md-6">
                            <input id="username" type="username" class="form-control" name="username" required autofocus>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password"  class="col-md-4 col-form-label text-md-end">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required autofocus>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" {{ ('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-dark">
                                Login
                            </button>
                        </div>
                    </div>
                    
                    <div class="row mb-0">
                        <div class="col-md-8 offset-md-3">
                            @if(Session::has('invalid'))
                                <div class="d-flex alert alert-danger">
                                    {{ Session::pull('invalid') }}
                                </div>
                            @endif
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