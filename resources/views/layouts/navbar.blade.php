<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="conainer-fluid">
    <div class="position-absolute top-0 start-0 ms-3 mt-1">
    <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item">Library</li>
      </ol>
    </nav>
    </div>
  </div>
  <div class="container-fluid">
    <div class="ms-auto mb-2 mb-lg-0">
      @auth
      <a class="btn btn-outline-light" href="/profile/{{Auth::user()->uuid}}#favourite" role="button">
        <i class="bi bi-bag-heart"></i>
      </a>
      <a class="btn btn-outline-light" role="button">
        <i class="bi bi-envelope"></i>
      </a>
      <a class="btn btn-outline-light" role="button">
        <i class="bi bi-bell"></i>
      </a>
      <a class="btn btn-outline-light" role="button">
        <i class="bi bi-bag-check"></i>
      </a>
      @endauth
    </div>
  </div>
</nav>