<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <div class="collapse navbar-collapse " id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
          @guest
            <a class="btn btn-outline-light me-2" href="{{ route('login') }}">Login</a>
            <a class="btn btn-outline-light me-2" href="{{ route('register') }}">Register</a>
          @else
          <div class="dropdown" id="buttons">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
              {{Auth::user()->username }}
            </button>
            <button type="button" class="btn btn-secondary balance" data-id="{{Auth::user()->id}}" data-bs-toggle="modal" data-bs-target="#balance">
              {{Auth::user()->balance/100}} €
            </button>
            <ul class="dropdown-menu">
              <li>
                <form action="#" method="POST">
                  @csrf
                  <a style="color: black;" class="dropdown-item secondary" href="#"
                  onclick="event.preventDefault();
                                  this.closest('form').submit();">
                  Logout
                </a>
                </form>
              </li>
            </ul>
          </div>
          @endguest
        </ul>
      </div>
    </div>
</nav>