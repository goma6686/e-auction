<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('layouts.head')

<body class="antialiased">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <header>
        @include('layouts.firstnavbar')
    </header>
        <main>
            <div class="content py-5 ">
                @include('components.sessionmessage')
                @yield('content')
            </div>
        </main>
    @livewireScripts
    @vite(['resources/js/app.js'])
</body>
</html>
