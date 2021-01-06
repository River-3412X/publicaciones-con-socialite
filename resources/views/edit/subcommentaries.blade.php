<li class="list-group-item overflow-auto p-0">
    
    <div class="rounded card-header p-2 bg-dark text-white" style="flex:auto">
        <div class="d-flex">
            <div class="mr-1">
                @if ($subcommentary->user->socialite)
                    <img src="{{ $subcommentary->user->socialite->avatar }}" style="border-radius: 50%; width:35px">
                @else
                    <i class="fas fa-user"></i>
                @endif
            </div>
            <p class="m-0"><strong>{{ $subcommentary->user->name }}</strong> hace {{ $subcommentary->tiempo_transcurrido() }}</p>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('update_subcommentary',["id"=>$subcommentary->id]) }}" method="post" class="subcommentary_update">
            @csrf
            @method("put")
            <textarea name="descripcion">{!! $subcommentary->descripcion !!}</textarea>
            <button type="submit" class="btn btn-success btn-sm">Guardar</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
        </form>
    </div>
</li>