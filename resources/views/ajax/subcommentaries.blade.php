@foreach ($subcommentaries as $subcommentary)
    <li class="list-group-item p-0">
        <div class="p-2 " style="flex:auto">
            <div class="d-flex justify-content-between">
                <p class="m-0"> 
                    @if($subcommentary->user->socialite)
                        <img src="{{ $subcommentary->user->socialite->avatar }}" style="width: 30px; border-radius:50%;">
                    @else
                        <i class="fas fa-user"></i>
                    @endif
                    <strong>{{ $subcommentary->user->name }}</strong> hace {{ $subcommentary->tiempo_transcurrido() }}
                </p>
                @auth
                    @if ($subcommentary->id_users==auth()->user()->id)
                    <div class="dropdown">
                        <i class="fas fa-ellipsis-v px-2 " id="acciones{{ $subcommentary->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                        </i>

                        <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="acciones{{ $subcommentary->id }}">
                            <a class="dropdown-item subcommentary-edit" href="{{ route('edit_subcommentary',["id"=>$subcommentary->id]) }}">Editar</a>
                            
                            <form action="{{ route('delete_subcommentary',['id'=>$subcommentary->id]) }}" method="post" class="subcommentary-delete" id="subcommentaries_delete{{ $subcommentary->id }}">
                                @csrf
                                @method("delete")
                                <button type="submit" class="dropdown-item">Eliminar</button>
                            </form>
                        </div>
                    </div>
                    @endif
                @endauth
            </div>
            <p class="m-0">{!! $subcommentary->descripcion !!}</p>
            <div class="d-flex">
                <form method="post" class="form_sub_commentaries_like" action="{{ route('like_subcommentaries',['id'=>$subcommentary->id]) }}">
                    @csrf                        
                    @auth
                        <button type="submit" class="btn 
                        @if ($subcommentary->like_this_user(auth()->user()->id))
                            btn-primary
                        @else
                            btn-outline-primary
                        @endif
                        btn-sm mr-2 d-flex btn_like_total_subcommentary align-items-center px-0 py-1"><i class="fas fa-thumbs-up mx-1 p-1"></i><strong>Me Gusta</strong><p class="like_total_subcommentary m-0 px-1">{{ $subcommentary->likes }}</p> </button>
                    @else
                        <button type="submit" class="btn btn-outline-primary btn-sm mr-2 d-flex btn_like_total_subcommentary align-items-center px-0 py-1"><i class="fas fa-thumbs-up mx-1 p-1"></i><strong>Me Gusta</strong><p class="like_total_subcommentary m-0 px-1">{{ $subcommentary->likes }}</p> </button>
                    @endauth
                     
                </form>
                <form method="post" class="form_sub_commentaries_dislike" action="{{ route('dislike_subcommentaries',['id'=>$subcommentary->id]) }}">
                    @csrf
                    @auth
                        <button type="submit" class="btn 
                        @if ($subcommentary->dislike_this_user(auth()->user()->id))
                            btn-danger
                        @else
                            btn-outline-danger
                        @endif
                         btn-sm mr-2 d-flex btn_dislike_total_subcommentary align-items-center px-0 py-1"><i class="fas fa-thumbs-down mx-1 p-1"></i><strong>No Me Gusta</strong><p class="dislike_total_subcommentary m-0 px-1">{{ $subcommentary->dislikes }}</p> </button>
                    @else
                        <button type="submit" class="btn btn-outline-danger btn-sm mr-2 d-flex btn_dislike_total_subcommentary align-items-center px-0 py-1"><i class="fas fa-thumbs-down mx-1 p-1"></i><strong>No Me Gusta</strong><p class="dislike_total_subcommentary m-0 px-1">{{ $subcommentary->dislikes }}</p> </button>
                    @endauth
                </form>
            </div>
        </div>
    </li>
@endforeach
@if (method_exists($subcommentaries,"nextPageUrl"))
    @if ($subcommentaries->nextPageUrl()!=null)
        <a href="{{ $subcommentaries->nextPageUrl() }}" class="btn btn-outline-secondary btn-sm btn-block nextPageSubcommentaries">Mostrar más Respuestas</a>
    @endif
@endif
