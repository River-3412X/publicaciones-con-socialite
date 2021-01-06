@extends('layouts.general')

@section('content')
<div class="container">
    
    <div class="row justify-content-center position-relative mt-3" style="top: 55px" >
        <div class="col col-sm-8 col-md-6 ">
            <div class="card">
                <div class="card-header bg-dark text-white">{{ __('Confirmar Contraseña') }}</div>

                <div class="card-body">
                    {{ __('Para continuar, por favor confirma tu contraseña.') }}

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group">
                            <label for="password" class="form-label text-md-right">{{ __('Contraseña') }}</label>

                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Contraseña">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Confirmar contraseña') }}
                            </button>

                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('¿Olvidaste tu Contraseña?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
