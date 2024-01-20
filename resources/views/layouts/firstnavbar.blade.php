<nav class="navbar navbar-expand-lg navbar-dark bg-dark flex-sm-nowrap flex-wrap">
    <div class="container-fluid">
      <button class="navbar-toggler flex-grow-sm-1 flex-grow-0 me-2" type="button" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand flex-grow-1" id="large"  @if (Route::currentRouteName() !== 'home') href="/home" @else href="/" @endif>
        <i class="fa fa-superpowers" aria-hidden="true"></i> <!-- Icon -->
            GoAuction
      </a>
      <div class="flex-grow-1 justify-content-center" id="large">
        @if (Route::currentRouteName() !== 'home')
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/home">All</a></li>
              @foreach ($categories as $category)
                <li class="breadcrumb-item"><a href="{{ route('home', ['category' => $category->category]) }}">{{$category->category}}</a></li>
              @endforeach
            </ol>
          </nav>
        @endif
      </div>
      @guest
        <div class="d-grid gap-2 d-flex justify-content-end">
            <a class="btn btn-outline-light me-md-2" href="{{ route('login') }}">Login</a>
            <a class="btn btn-outline-light" href="{{ route('register') }}">Register</a>
        </div>
      @else
        <div class="dropdown" id="buttons">
          <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
            {{Auth::user()->username }}
          </button>
          <button type="button" class="btn btn-outline-light balance" data-id="{{Auth::user()->id}}" data-bs-toggle="modal" data-bs-target="#balance">
            {{Auth::user()->balance}} €
          </button>
          <ul class="dropdown-menu">
            <li>
              <a class="dropdown-item secondary" href="{{ route('profile', ['uuid' => Auth::user()->uuid]) }}">
                Profile
              </a>
            </li>
            <div id="mobile">
            <li>
              <a class="dropdown-item secondary" href="/dashboard/{{Auth::user()->uuid}}" role="button">
                Dashboard</a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item secondary" href="/dashboard/{{Auth::user()->uuid}}" role="button">
                Manage auctions
                <i class="bi bi-bell"></i>
              </a>
            </li>
            <li>
              <a class="dropdown-item secondary"  href="/dashboard/{{Auth::user()->uuid}}#won">
                Won Auctions
                <i class="bi bi-cart"></i>
              </a>
            </li>
            <li>
              <a class="dropdown-item secondary" href="/dashboard/{{Auth::user()->uuid}}#favourite" >
                Favourites
                <i class="bi bi-bag-heart"></i>
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            </div>
            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <a style="color: black;" class="dropdown-item secondary" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                this.closest('form').submit();">
                Logout
              </a>
              </form>
            </li>
          </ul>
        </div>
      @endguest
      <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasExampleLabel">CATEGORIES</h5>
          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <div class="flex-grow-1 justify-content-center">
              <ul class=" navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item"><a class="text-decoration-none" href="/home">ALL</a></li>
                @foreach ($categories as $category)
                  <li class="nav-item"><a class="text-decoration-none" href="{{ route('home', ['category' => $category->category]) }}">{{$category->category}}</a></li>
                @endforeach
              </ul>
            </div>
        </div>
      </div>
  </div>
      
  </nav>
  