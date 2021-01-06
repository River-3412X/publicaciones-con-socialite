<div class="row mb-3">
    <div class="col">
        <div class="card shadow">
            <div class="card-header p-2 bg-dark text-white d-flex justify-content-between align-items-center">
                <div>
                    @if (isset($question->user->Socialite->avatar))
                        <img src="{{ $question->user->Socialite->avatar }}" style="width: 40px; border-radius:50%">
                    @else
                        <i class="fas fa-user"></i>
                    @endif 
                    {{ $question->user->name }} hace {{ $question->tiempo_transcurrido() }}
                    
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body p-2 overflow-auto">
                <form action="{{ route('update_question',["id"=>$question->id]) }}" method="post" class="question_update">
                    @csrf
                    @method("put")
                    <textarea name="descripcion" id="question_edit" >{{ $question->descripcion }}</textarea>
                    <input type="submit" value="Guardar" class="btn btn-success btn-sm" >
                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
    </div>
</div>