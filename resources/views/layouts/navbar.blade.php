<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

  <div class="container-fluid">
    <div class="ms-auto mb-2 mb-lg-0">
      @auth
      <div class="dropdown" id="buttons">
        <button class="btn btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Sell
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            <li><a class="dropdown-item" href="{{ route('create-auction', ['type' => 1]) }}">Buy Now</a></li>
            <li><a class="dropdown-item" href="{{ route('create-auction', ['type' => 2]) }}">Auction</a></li>
        </ul>
        <a class="btn btn-outline-light" href="/dashboard/{{Auth::user()->uuid}}#all" role="button">
          <i class="bi bi-bell"></i>
          @if (Auth::user()->getWaitingForPaymentAuctions()->count() > 0)
            <span class="position-absolute top-0 translate-middle badge rounded-pill bg-danger">
              {{Auth::user()->getWaitingForPaymentAuctions()->count()}}
            </span>
          @endif
        </a>
        <a class="btn btn-outline-light" href="/dashboard/{{Auth::user()->uuid}}#won" role="button">
          <i class="bi bi-cart"></i>
          @if (Auth::user()->winningAuctions()->count() > 0)
            <span class="position-absolute top-0 translate-middle badge rounded-pill bg-danger">
              {{Auth::user()->winningAuctions()->count()}}
            </span>
          @endif
        </a>
        <a class="btn btn-outline-light" href="/dashboard/{{Auth::user()->uuid}}#favourite" role="button">
          <i class="bi bi-bag-heart"></i>
        </a>
      </div>
      @endauth
    </div>
  </div>
</nav>