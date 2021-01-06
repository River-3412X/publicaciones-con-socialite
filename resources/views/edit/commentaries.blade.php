<li class="list-group-item overflow-auto p-0">
    
    <div class="rounded card-header p-2 bg-dark text-white" style="flex:auto">
        <div class="d-flex">
            <div class="mr-1">
                @if ($commentary->user->socialite)
                    <img src="{{ $commentary->user->socialite->avatar }}" style="border-radius: 50%; width:35px">
                @else
                    <i class="fas fa-user"></i>
                @endif
            </div>
            <p class="m-0"><strong>{{ $commentary->user->name }}</strong> hace {{ $commentary->tiempo_transcurrido() }}</p>
        </div>
    </div>
    <div class="card-body">
        <form action="{{ route('update_commentary',["id"=>$commentary->id]) }}" method="post" class="commentary_update">
            @csrf
            @method("put")
            <textarea name="descripcion">{{ str_replace("<br />","",$commentary->descripcion) }}</textarea>
            <button type="submit" class="btn btn-success btn-sm">Guardar</button>
            <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Cancelar</button>
        </form>
    </div>
</li>