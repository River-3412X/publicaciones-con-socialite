<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SubCommentary;

class SubCommentaryController extends Controller
{
    public $modelo;
    public function __construct(){
        $this->modelo=new SubCommentary;
    }
    public function storage(Request $request,$id){
        $request->validate([
            "subcomentario"=>"required"
        ],[
            "required"=>"Escribe el comentario"
        ]);
        $this->modelo->setId_users(Auth::user()->id);
        $this->modelo->setDescripcion(nl2br($request->subcomentario));
        $this->modelo->setId_commentaries($id);
        if($this->modelo->registrar()){
            $subcommentaries[0]=$this->modelo;
            return view("ajax.subcommentaries",compact("subcommentaries"));
        }
    }
    public function show(Request $request){
        return $this->modelo->show($request->id_commentary);
    }    
    public function edit($id){
        $subcommentary =$this->modelo->findOrFail($id);
        return view("edit.subcommentaries",compact("subcommentary"));
    }
    public function update(Request $request,$id){
        $request->validate([
            "descripcion"=>"required"
        ]);
        $this->modelo=$this->modelo->findOrFail($id);
        $this->modelo->setDescripcion(nl2br($request->descripcion));
        if($this->modelo->modificar()){
            return "Se Modificó el comentario correctamente";
        }
    }
    public function delete($id){
        $this->modelo=$this->modelo->findOrFail($id);
        if($this->modelo->eliminar()){
            return "Se Eliminó el commentario correctamente";
        }
    }
    public function like(Request $request){
        if($request->get("id")!=null){
            $this->modelo=$this->modelo->findOrFail($request->id);
            if($this->modelo->dislike_this_user(Auth::user()->id)){
                $this->modelo->User_dislike()->detach(Auth::user()->id);
                $this->modelo->setDislikes($this->modelo->getDislikes()-1);
                if($this->modelo->getDislikes()==0){
                    $this->modelo->setDislikes(null);
                }
            }
            if($this->modelo->like_this_user(Auth::user()->id)){
                $this->modelo->user_like()->detach(Auth::user()->id);
                $this->modelo->setLikes($this->modelo->getLikes()-1);
                if($this->modelo->getLikes()==0 ){
                    $this->modelo->setLikes(null);
                }
            }
            else{
                $this->modelo->user_like()->attach(Auth::user()->id);
                if($this->modelo->getLikes()==null){
                    $this->modelo->setLikes(1);
                }
                else{
                    $this->modelo->setLikes($this->modelo->getLikes()+1);
                }
            }
            $this->modelo->save();
            $retorno["likes"]=$this->modelo->getLikes();
            $retorno['dislikes']=$this->modelo->getDislikes();
            return json_encode($retorno);
        }
    }
    public function dislike(Request $request){
        if($request->get("id")!=null){
            $this->modelo=$this->modelo->findOrFail($request->id);
            if($this->modelo->like_this_user(Auth::user()->id)){
                $this->modelo->user_like()->detach(Auth::user()->id);
                $this->modelo->setLikes($this->modelo->getLikes()-1);
                if($this->modelo->getLikes()==0){
                    $this->modelo->setLikes(null);
                }
            }
            if($this->modelo->dislike_this_user(Auth::user()->id)){
                $this->modelo->User_dislike()->detach(Auth::user()->id);
                $this->modelo->setDislikes($this->modelo->getDislikes()-1);
                if($this->modelo->getDislikes()==0){
                    $this->modelo->setDislikes(null);
                }
            }
            else{
                $this->modelo->User_dislike()->attach(Auth::user()->id);
                if($this->modelo->getDislikes()==null){
                    $this->modelo->setDislikes(1);
                }
                else{
                    $this->modelo->setDislikes($this->modelo->getDislikes()+1);
                }
            }
            $this->modelo->save();
            $retorno['likes']=$this->modelo->getLikes();
            $retorno['dislikes']=$this->modelo->getDislikes();
            return json_encode($retorno);
        }
    }
}
