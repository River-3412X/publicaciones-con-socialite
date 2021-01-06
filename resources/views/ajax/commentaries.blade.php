@foreach ($commentaries as $commentary)
    <li class="list-group-item overflow-auto p-0">
        <div class="d-flex">
            <div class="mr">
                @if ($commentary->user->socialite)
                    <img src="{{ $commentary->user->socialite->avatar }}" style="border-radius: 50%; width:35px">
                @else
                    <div class="text-center" style="width: 35px">
                        <i class="fas fa-user"></i>
                    </div>
                @endif
            </div>
            <div class="rounded card-header p-2" style="flex:auto">
                <div class="d-flex justify-content-between">
                    <p class="m-0"><strong>{{ $commentary->user->name }}</strong> hace {{ $commentary->tiempo_transcurrido() }}</p>
                    @auth
                        @if ($commentary->id_users==auth()->user()->id)
                        <div class="dropdown">
                            <i class="fas fa-ellipsis-v px-2 " id="acciones{{ $commentary->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                            </i>

                            <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="acciones{{ $commentary->id }}">
                                <a class="dropdown-item commentary-edit" href="{{ route('edit_commentary',["id"=>$commentary->id]) }}">Editar</a>
                                
                                <form action="{{ route('delete_commentary',['id'=>$commentary->id]) }}" method="post" class="commentary-delete" id="commentary_delete{{ $commentary->id }}">
                                    @csrf
                                    @method("delete")
                                    <button type="submit" class="dropdown-item">Eliminar</button>
                                </form>
                            </div>
                        </div>
                        @endif
                    @endauth
                </div>
                <div class="descripcion-commentary">
                    {!! $commentary->descripcion !!}
                </div>
                @if ($commentary->subcommentaries->count()>0)
                    <small class="d-block text-right">{{ $commentary->subcommentaries->count() }} respuestas</small>
                @endif
                <div class="d-flex justify-content-between">
                    <div class="d-flex">
                        <form method="post" action="{{ route('like_commentaries',['id'=>$commentary->id]) }}" class="form_commentaries_like">
                            @csrf
                            @auth
                                <button type="submit" class="btn 
                                @if($commentary->like_this_user(auth()->user()->id))
                                    btn-primary
                                @else
                                    btn-outline-primary
                                @endif
                                btn-sm mr-2 d-flex btn_like_total_commentary align-items-center px-0 py-1"><i class="fas fa-thumbs-up mx-1 py-1"></i><strong>Me Gusta</strong><p class="like_total_commentary m-0 px-1">{{ $commentary->likes }}</p> </button>
                            @else
                            <button type="submit" class="btn btn-outline-primary btn-sm mr-2 d-flex btn_like_total_commentary align-items-center px-0 py-1"><i class="fas fa-thumbs-up mx-1 py-1"></i><strong>Me Gusta</strong><p class="like_total_commentary m-0 px-1">{{ $commentary->likes }}</p> </button>
                            @endauth
                        </form>
                        <form method="post" action="{{ route('dislike_commentaries',['id'=>$commentary->id]) }}" class="form_commentaries_dislike">
                            @csrf
                            @auth
                                <button type="submit" class="btn 
                                @if ($commentary->dislike_this_user(auth()->user()->id))
                                    btn-danger
                                @else
                                    btn-outline-danger
                                @endif
                                 btn-sm mr-2 d-flex btn_dislike_total_commentary align-items-center px-0 py-1"><i class="fas fa-thumbs-down mx-1 p-1"></i><strong>No Me Gusta</strong><p class="dislike_total_commentary m-0 px-1">{{ $commentary->dislikes }}</p> </button>
                            @else
                                <button type="submit" class="btn btn-outline-danger btn-sm mr-2 d-flex btn_dislike_total_commentary align-items-center px-0 py-1"><i class="fas fa-thumbs-down mx-1 p-1"></i><strong>No Me Gusta</strong><p class="dislike_total_commentary m-0 px-1">{{ $commentary->dislikes }}</p> </button>
                            @endauth
                        </form>
                    </div>
                    
                    <button type="button" class="btn btn-outline-secondary btn-sm  mr-1" onclick="document.getElementById('subcomentarios{{ $commentary->id }}').classList.remove('d-none'); document.getElementById('nuevo_subcomentario{{ $commentary->id }}').focus()">Responder</button>
                    
                </div>
                <ul class="list-group list-group-flush d-none" id="subcomentarios{{ $commentary->id }}">
                    <li class="list-group-item py-1 px-0">
                        <form  method="post" action="{{ route('storage_subcommentary',['id'=>$commentary->id]) }}" class="form_sub_commentaries">
                            @csrf
                            <div class="input-group">
                                <textarea name="subcomentario" id="nuevo_subcomentario{{ $commentary->id }}" placeholder="Escribe un comentario..." class="form-control form-control-sm mr-1" rows="1" cols="30" ></textarea>
                                <span class="input-group-text bg-white"><input type="submit" value="Responder" class="btn btn-outline-primary btn-sm "></span>
                            </div>
                        </form>
                    </li>
                    
                    <div id="subcommentarios{{ $commentary->id }}">
                        @if ($commentary->Subcommentaries()->first()!=null)
                            {{ $commentary->Subcommentaries()->first()->show($commentary->id) }}
                        @endif
                    </div>
                </ul>
            </div>
        </div>
    </li>
@endforeach

@if ( method_exists($commentaries,"nextPageUrl"))
   @if ($commentaries->nextPageUrl()!=null)
        <a href="{{ $commentaries->nextPageUrl() }}" class="btn btn-outline-secondary btn-sm btn-block nextPageCommentaries">Mostrar más Comentarios</a>
   @endif
@endif
