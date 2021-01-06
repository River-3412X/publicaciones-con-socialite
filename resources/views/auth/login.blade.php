@extends('layouts.general')

@section('content')
    <div class="row justify-content-center mt-3 " style="position: relative; top: 55px">
        
        <div class="col-md-6">
            <div class="row">
                <div class="col">
                    @if (session('mensaje'))
                        <div class="alert alert-danger p-1 text-center  ">
                            {{ session('mensaje') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-dark text-white">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label">{{ __('Correo') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo">
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-row pl-4">
                            <div class="col form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Recordar') }}
                                </label>
                            </div>
                            <div class="col ">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Iniciar Sesión') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tu Contraseña?') }}
                                </a>
                            @endif
                        </div>
                        <p class="text-center text-secondary">O</p>
                        <div class="form-group">
                            <a href="{{ url('login/facebook') }}" class="btn btn-primary btn-block">Continuar con Facebook</a>
                        </div>
                        <div class="form-row">
                            <a href="{{ url('login/google') }}" class="btn btn-danger btn-block">Continuar con Google</a>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
