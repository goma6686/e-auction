<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard</title>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js">
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
    
                $('#dataTable').DataTable({
                    "pageLength": 15,
                    "order": [[ 0, "desc" ]],
                    "search": {
                        regex: true,
                        caseInsensitive: true,
                      },
                });
            } );
        </script>
        <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
              <div class="container-fluid">
                <div class="collapse navbar-collapse " id="navbarSupportedContent"><ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                  @guest
                    <a class="btn btn-outline-light me-2" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-outline-light me-2" href="{{ route('register') }}">Register</a>
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
                </ul>
                </div>
              </div>
          </nav>
    </header>
    
  
  <div class="container-fluid">
    <div class="row">
      <nav id="sidebarMenu" class="col-md-2 col-lg-1 d-md-block bg-dark sidebar collapse">
        <div class="position-sticky pt-3">
          <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="/">
                  Main
                </a>
              </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('back', ['page' => 'auctions']) }}">
                Auctions
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('back', ['page' => 'users']) }}">
                Users
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('back', ['page' => 'items']) }}">
                Items
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{ route('back', ['page' => 'categories']) }}">
                Categories
              </a>
            </li>
          </ul>
        </div>
      </nav>
  
      <main class="col-md-9 ms-sm-auto col-lg-11 px-md-4">
        <div class="content col">
            <div class="container-fluid px-4">
                <h1 class="mt-4">Tables</h1>
                <div class="card mb-4">
                    <div class="card-body">
                        @include('components.sessionmessage')
                        <table id="dataTable" class="table table-striped nowrap" style="width: 100%">
                        @switch($page)
                            @case($page == 'auctions')
                                @include('admin.auctions', ['tableTitle' => 'Auctions', 'data' => $data])
                                @break
                            @case($page == 'items')
                                @include('admin.items', ['tableTitle' => 'Items', 'data' => $data])
                                @break
                            @case($page == 'users')
                                @include('admin.users', ['tableTitle' => 'users', 'data' => $data])
                                @break
                            @default
                                @include('admin.categories', ['tableTitle' => 'Categories', 'data' => $data])
                        @endswitch
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </main>
    </div>
  </div>
  
</html>
