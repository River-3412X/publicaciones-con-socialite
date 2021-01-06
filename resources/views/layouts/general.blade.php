<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/jquery.js') }}" type="text/javascript"></script>
    @yield('scripts')
</head>
<body>
    
    <div class="toast position-fixed m-2 hide" id="tostada" style="position: fixed;width: 300px;z-index: 100;bottom: 0px;right: 0px;">
        <div class="toast-header bg-dark text-white">
  
          <i class="far fa-bell pr-1"></i>
  
          <strong class="mr-auto">{{ env("APP_NAME") }}</strong>
          <small>Justo Ahora</small>
          <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="toast-body bg-white overflow-auto" id="toast-body" style="max-height: 400px">
          
        </div>
    </div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_edit">
        Launch demo modal
    </button>
    
    <!-- Modal -->
    <div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="modal_edit_label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-body p-0" id="modal_edit_body">

                </div>
            </div>
        </div>
    </div>  
      
    <div class="container-fluid p-0">
        
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark shadow fixed-top" >
            <a class="navbar-brand" href="{{ route('inicio') }}" id="root">{{ env('APP_NAME') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav w-100 justify-content-end">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('inicio') }}">Inicio <span class="sr-only">(current)</span></a>
                </li>
                @auth
                    
                    <li class="nav-item d-flex align-items-center">
                        @if (auth()->user()->Socialite)
                            <img src="{{ auth()->user()->Socialite->avatar }}" style="max-width: 35px" class="rounded">
                        @else
                            <i class="fas fa-user text-white"></i>
                        @endif
                        
                        <p class="text-white m-0 ml-1">{{ auth()->user()->name }}</p>
                    </li>
                    <!--<li class="nav-item dropdown">-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre><i class="fas fa-cogs"></i></a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit(); ">Cerrar Sesión</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <div class="dropdown-divider"></div>
                        </div>
                    </li>
                    
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                    </li>
                @endauth
              </ul>
            </div>
          </nav>
    </div>
    <div class="container">
        @auth
            
        @endauth
        
        @yield('content')    
    </div>
    
    <script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('js/richtext.js') }}"></script>
</body>
</html>