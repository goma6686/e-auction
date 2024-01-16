<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')

<body class="antialiased">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <header>
        @include('layouts.firstnavbar')
        @include('layouts.navbar')
    </header>
        @if (Route::currentRouteName() !== 'welcome')
        <main id="root" class="row">
            <div class="sidebar col-1">
                @yield('sidebar')
            </div>
            <div class="content col-9">
                @yield('content')
            </div>
        </main>
        @else
        <main>
            <div class="content">
                @yield('content')
            </div>
        </main>
        @endif
    </main>
    @livewireScripts
    @vite(['resources/js/app.js'])
    <script type="text/javascript" src="{{asset('js/profile-tabs.js')}}"></script>
</body>
</html>
