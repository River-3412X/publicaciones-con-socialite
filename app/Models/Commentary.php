<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\SubCommentary;
use App\Models\User;
use Illuminate\Http\Request;
class Commentary extends Model
{
    use HasFactory;
    public $table="commentaries";
    public $fillable=[
        "descripcion","likes","dislikes","id_questions"
    ];
    public function registrar(){
        return $this->save();
    }
    public function tiempo_transcurrido(){
        
        $fecha = strtotime($this->created_at);
        $fecha_actual = strtotime(Date("Y-m-d H:i:s"));
        $diferencia = $fecha_actual-$fecha;
        if($diferencia<60){
            return $diferencia." segundos";
        }
        elseif( $diferencia < 3600 ){
            return floor(($diferencia/60))." minutos";
        }
        elseif($diferencia < 86400){
            return floor(($diferencia/3600))." horas";
        }else{
            return floor(($diferencia/86400))." dias";
        }
    }
    public function like_this_user($id){
        if($this->user_like()->wherePivot("user_id",$id)->count()==1){
            return true;
        }
        else{
            return false;
        }
    }
    public function dislike_this_user($id){
        if($this->user_dislike()->wherePivot("user_id",$id)->count()==1){
            return true;
        }
        else{
            return false;
        }
    }
    public function show($id){
        $commentaries=$this->orderBy("id","desc")->where("id_questions",$id)->paginate(10,["*"],"commentary_page");
        $commentaries->withPath("comentarios/mostrar");
        $commentaries->appends(["id_question"=>$id]);
        
        return view("ajax.commentaries",compact("commentaries"));
    }
    public function modificar(){
        return $this->update();
    }
    public function eliminar(){
        return $this->delete();
    }
    public function setDescripcion($descripcion){
        $this->descripcion = $descripcion;
    }
    public function getDescripcion(){
        return $this->descripcion;
    }
    public function setLikes($likes){
        $this->likes=$likes;
    }
    public function getLikes(){
        return $this->likes;
    }
    public function setDislikes($dislikes){
        $this->dislikes=$dislikes;
    }
    public function getDislikes(){
        return $this->dislikes;
    }
    
    public function setId_users($id){
        $this->id_users= $id;
    }
    public function getId_users(){
        return $this->id_users;
    }
    public function setId_questions($id){
        $this->id_questions= $id;
    }
    public function getId_questions(){
        return $this->id_questions;
    }
    //relaciones 
    public function Question(){
        return $this->belongsTo(Question::class,"id_questions","id");
    }
    public function Subcommentaries(){
        return $this->hasMany(SubCommentary::class,"id_commentaries","id");
    }
    public function User(){
        return $this->belongsTo(User::class,"id_users","id");
    }
    public function User_like(){
        return $this->belongsToMany(User::class);
    }
    public function User_dislike(){
        return $this->belongsToMany(User::class,"commentary_user_dislike");
    }
}
