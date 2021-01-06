@extends('layouts.general')

@section('content')
<div class="container">
    <div class="row justify-content-center mt-3" style="position: relative; top:55px">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">{{ __('Registrarse') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group m-1">
                            <label for="name" class="form-label">{{ __('Nombre') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Nombre">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group m-1">
                            <label for="email" class="form-label">{{ __('Correo') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Correo">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group m-1">
                            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Contraseña">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="form-label text-md-right">{{ __('Confirmar Contraseña') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirmar Contraseña">
                        </div>

                        <div class="form-group m-2">
                            <button type="submit" class="btn btn-success btn-sm">
                                {{ __('Registrar') }}
                            </button>
                        </div>
                        <div class="form-group m-2">
                            <a href="{{ url('login/facebook') }}" class="btn btn-primary btn-block btn-sm">
                                {{ __('Registrar con Facebook') }}
                            </a>
                        </div>
                        <div class="form-group m-2">
                            <a href="{{ url('login/google') }}" class="btn btn-danger btn-block btn-sm">
                                {{ __('Registrar con Google') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
