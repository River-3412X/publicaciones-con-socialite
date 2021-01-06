@extends('layouts.general')
@section('scripts')
     
    <script type="text/javascript" src="{{ asset('js/register/question.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/edit/question.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/delete/question.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/register/commentary.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/edit/commentary.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/delete/commentary.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/register/subcommentary.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/edit/subcommentary.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/delete/subcommentary.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/all.css') }} ">
    
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <link rel="stylesheet" href="{{ asset('css/richtext.min.css') }}">
    
@endsection
@section('content')

<div class="row text-center mb-2 mt-3">
    <div class="col-12  col-sm-8 offset-sm-2">
        <form class="form-inline my-2 my-lg-0 d-block w-100" method="GET">
            <div class="form-row justify-content-center mt-3">
                <input class="form-control mr-1" type="search" placeholder="¿Qué estás buscando?" aria-label="Search" style="width:400px; max-width:70%" name="consulta" value="{{ $consulta }}">
                <button class="btn btn-outline-success" type="submit" style="max-width:25%">Buscar</button>
            </div>
        </form>
    </div>
</div>
@auth
<div class="row mt-0">
    <div class="col-12">
        <form method="post" action="{{ route('storage_question') }}" id="form_question">
            @csrf
            <div class="from-group m-0">
                <textarea name="question" id="question" placeholder="Escribir Pregunta..." class="form-control"></textarea>
            </div>
            <div class="form-row justify-content-end"><input type="submit" value="Publicar" class="btn btn-primary my-2 mr-1"  @auth id="btn-storage-questions" @endauth></div>
        </form>
    </div>
</div>

@endauth
@isset($questions)
    <div id="preguntas">
        @include('ajax.questions')
    </div>
@endisset
@endsection