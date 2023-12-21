<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  
  <div class="container-fluid">
    <div class="ms-auto mb-2 mb-lg-0">
      @auth
      <a class="btn btn-outline-light" href="/profile/{{Auth::user()->uuid}}#favourite" role="button">
        <i class="bi bi-bag-heart"></i>
      </a>
      <a class="btn btn-outline-light" role="button">
        <i class="bi bi-envelope"></i>
      </a>
      @endauth
    </div>
  </div>
</nav>