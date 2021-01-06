<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
class QuestionController extends Controller
{
    public $modelo;
    public function __construct(){
        $this->modelo=new Question;
    }
    public function index(Request $request){
        $consulta="";
        if($request->get('consulta')!=null){
            $consulta=$request->consulta;
            $questions=$this->modelo->consultar($request->consulta);
        }else{
            $questions=$this->modelo->consultar("");
        }
        return view("index",compact("questions","consulta"));
    }
    public function storage(Request $request){
        $request->validate([
            "question"=>"required"
        ],[
            "required"=>"Escribe la pregunta antes de publicar"
        ]);
        
        $this->modelo->setId_users(Auth::user()->id);
        $this->modelo->setDescripcion(nl2br($request->question));
        if($this->modelo->registrar()){
            $questions=$this->modelo->whereId($this->modelo->id)->paginate(1);
            return view("ajax.questions",compact("questions"));
        }

    }
    public function show(Request $request){
        $consulta="";
        if($request->get("consulta")!=null ){
            $consulta=$request->consulta;
            $questions=$this->modelo->consultar($request->consulta);
        }else{
            $questions=$this->modelo->consultar("");
        }
        return view("ajax.questions",compact("questions","consulta"));
    }
    public function edit($id){
        $question = $this->modelo->findOrFail($id);
        return view("edit.questions",compact("question"));
    }
    public function update(Request $request,$id){
        $request->validate([
            "descripcion"=>"required"
        ]);
        $this->modelo= $this->modelo->findOrFail($id);
        $this->modelo->setDescripcion($request->descripcion);
        if($this->modelo->modificar()){
            return "Se modificó la pregunta correctamente!";
        }
    }
    public function delete($id){
        $this->modelo=$this->modelo->findOrFail($id);
        if($this->modelo->eliminar()){
            return "Se eliminó la pregunta correctamente";
        }
    }
    public function like(Request $request){
        if($request->get("id")!=null){
            $retorno=[];
            $this->modelo=$this->modelo->findOrFail($request->id);
            if($this->modelo->dislike_this_user(Auth::user()->id)){
                $this->modelo->User_dislike()->detach(Auth::user()->id);
                $this->modelo->setDislikes($this->modelo->getDislikes()-1);
                if($this->modelo->getDislikes()==0){
                    $this->modelo->setDislikes(null);
                }
            }
            if($this->modelo->like_this_user(Auth::user()->id)){
                $this->modelo->User_like()->detach(Auth::user()->id);
                $this->modelo->setLikes($this->modelo->getLikes()-1);
                if($this->modelo->getLikes()==0){
                    $this->modelo->setLikes(null);
                }
            }
            else{
                $this->modelo->User_like()->attach(Auth::user()->id);
                if($this->modelo->getLikes()==null){
                    $this->modelo->setLikes(1);
                }
                else{
                    $this->modelo->setLikes($this->modelo->getLikes()+1);
                }
            }
            $this->modelo->save();
            $retorno["likes"]=$this->modelo->getLikes();
            $retorno["dislikes"]=$this->modelo->getDislikes();
            
            return json_encode($retorno);
        }
    }
    public function dislike(Request $request){
        
        if($request->get("id")!=null){
            $retorno=[];
            $this->modelo=$this->modelo->findOrFail($request->id);
            if($this->modelo->like_this_user(Auth::user()->id)){
                $this->modelo->User_like()->detach(Auth::user()->id);
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
            $retorno["likes"]=$this->modelo->getLikes();
            $retorno["dislikes"]=$this->modelo->getDislikes();
            
            return json_encode($retorno);
        }
    }
}
