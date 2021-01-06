<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Commentary;
use App\Models\User;
class SubCommentary extends Model
{
    use HasFactory;
    public $table="sub_commentaries";
    public $fillable=[
        "descripcion","likes","dislikes","id_commentaries","id_users"
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
        $subcommentaries= $this->where("id_commentaries",$id)->orderBy("id","desc")->paginate(10,["*"],"subcommentary_page");
        $subcommentaries->withPath("subcomentario/mostrar");
        $subcommentaries->appends(["id_commentary"=>$id]);
        return view("ajax.subcommentaries",compact("subcommentaries"));
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
    public function setId_commentaries($id){
        $this->id_commentaries= $id;
    }
    public function getId_commentaries(){
        return $this->id_commentaries;
    }
    //relacionees

    public function Commentary(){
        return $this->belongsTo(Commentary::class,"id","id_commentaries");
    }
    public function User(){
        return $this->belongsTo(User::class,"id_users","id");
    }
    public function User_like(){
        return $this->belongsToMany(User::class,"sub_commentary_user","subcommentary_id");
    }
    public function User_dislike(){
        return $this->belongsToMany(User::class,"sub_commentary_user_dislike","subcommentary_id");
    }
}
