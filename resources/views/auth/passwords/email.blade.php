@extends('layouts.general')

@section('content')
<div class="container">
    <div class="row justify-content-center position-relative  mt-3" style="top: 55px;">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-dark text-white">{{ __('Recuperar Contraseña') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @else
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label text-md-right">{{ __('Dirección de Correo') }}</label>

                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Correo">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Enviar Correo de Recuperación') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
