@foreach ($questions as $item)
    <div class="row mb-3">
        <div class="col">
            <div class="card shadow">
                <div class="card-header p-2 bg-dark text-white d-flex justify-content-between align-items-center">
                    <div>
                        @if (isset($item->user->Socialite->avatar))
                            <img src="{{ $item->user->Socialite->avatar }}" style="width: 40px; border-radius:50%">
                        @else
                            <i class="fas fa-user"></i>
                        @endif 
                        {{ $item->user->name }} hace {{ $item->tiempo_transcurrido() }}
                    </div>
                    @auth
                        @if ($item->id_users==auth()->user()->id)
                            <div class="dropdown">
                                <i class="fas fa-ellipsis-v p-1 " id="acciones{{ $item->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                                </i>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acciones{{ $item->id }}">
                                    <a class="dropdown-item question-edit" href="{{ route('edit_question',["id"=>$item->id]) }}">Editar</a>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('delete_question',['id'=>$item->id]) }}" method="post" class="question-delete" id="delete_question{{ $item->id }}">
                                        @csrf
                                        @method("delete")
                                        <button type="submit" class="dropdown-item">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endauth
                    
                </div>
                <div class="card-body p-2 overflow-auto">
                    <div class="card-text">{!! $item->descripcion !!}</div>
                    @if ($item->commentaries->count()>0)
                        <small class="d-block text-right ">{{ $item->commentaries->count() }} comentarios</small>
                    @endif
                </div>
                <div class="card-footer text-muted px-2 py-1" >
                    <div class="d-flex justify-content-between overflow-auto">
                        <div class="d-flex">
                            <form method="post" class="form_questions_like" action="{{ route('like_questions',['id'=>$item->id]) }}">
                                @csrf
                                @auth
                                    <button type="submit" class="btn 
                                    @if($item->like_this_user(auth()->user()->id))
                                        btn-primary
                                    @else
                                        btn-outline-primary
                                    @endif
                                    btn-sm mr-2 d-flex btn_like_total_question align-items-center px-0 py-1"><i class="fas fa-thumbs-up mx-1"></i><strong class="px-1">Me Gusta</strong><p class="like_total_question m-0 px-1">{{ $item->likes }}</p> </button>
                                @else
                                    <button type="submit" class="btn btn-outline-primary btn-sm mr-2 d-flex btn_like_total_question align-items-center px-0 py-1"><i class="fas fa-thumbs-up mx-1"></i><strong class="px-1">Me Gusta</strong><p class="like_total_question m-0 px-1">{{ $item->likes }}</p> </button>
                                @endauth
                            </form>
                            <form method="post" class="form_questions_dislike" action="{{ route('dislike_questions',['id'=>$item->id]) }}">
                                @csrf
                                
                                @auth
                                    <button type="submit" class="btn 
                                    @if($item->dislike_this_user(auth()->user()->id))
                                        btn-danger
                                    @else
                                        btn-outline-danger
                                    @endif
                                     btn-sm mr-2 d-flex btn_dislike_total_question align-items-center px-0 py-1"><i class="fas fa-thumbs-down mx-1 p-1"></i><strong class="d-block">No Me Gusta</strong><p class="dislike_total_question m-0 px-1">{{ $item->dislikes }}</p> </button>
                                @else
                                    <button type="submit" class="btn btn-outline-danger btn-sm mr-2 d-flex btn_dislike_total_question align-items-center px-0 py-1"><i class="fas fa-thumbs-down mx-1 p-1"></i><strong>No Me Gusta</strong><p class="dislike_total_question m-0 px-1">{{ $item->dislikes }}</p> </button>
                                @endauth
                            </form>
                        </div>
                        <div class="form group">
                            <label for="comentar{{ $item->id }}" class="btn btn-outline-secondary btn-sm ">Comentar</label>
                            <input type="checkbox" name="comentar" id="comentar{{ $item->id }}" class="d-none" onclick="document.getElementById('comentario{{ $item->id }}').classList.remove('d-none'); document.getElementById('nuevo_comentario{{ $item->id }}').focus()">
                        </div>
                    </div>
                    
                    <ul class="list-group list-group-flush d-none" id="comentario{{ $item->id }}">
                        <li class="list-group-item p-0">
                            <form method="post" class="form_comentaries" action="{{ route('storage_commentary',['id'=>$item->id]) }}" id="form_comentaries{{ $item->id }}">
                                @csrf
                                <div class="input-group">
                                    <textarea name="comentario" id="nuevo_comentario{{ $item->id }}" placeholder="Escribe un comentario..." class="form-control form-control-sm mr-1" rows="1" cols="30"></textarea>
                                    <span class="input-group-text bg-white"><input type="submit" value="Comentar" class="btn btn-outline-primary btn-sm "></span>
                                </div>
                            </form>
                        </li>
                        
                        <div id="comentarios{{ $item->id }}">
                            @if ($item->commentaries->count()>=1)
                                {{ $item->commentaries->first()->show($item->id) }}
                            @endif
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endforeach
@if ($questions->nextPageUrl()!=null)
    @php
    $page= $questions->currentPage()+1;
        $nextPageQuestions= "?consulta=".$consulta."&".$questions->getPageName()."=".$page;
    @endphp
    
    <a id="nextPageQuestions" href="{{ route('show_questions') }}{{ $nextPageQuestions }}" class="btn btn-outline-secondary btn-sm btn-block mb-3">Mostrar más Preguntas</a>
@endif

