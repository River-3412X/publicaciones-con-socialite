<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Commentary;
class Question extends Model
{
    use HasFactory;
    public $fillable=["descripcion","likes","dislikes","id_users"];
    Public $table="questions";

    public function consultar($consulta){
        return $this->where("descripcion","like","%".$consulta."%")->orderBy("id","desc")->paginate(10,['*'],"questions_page");
    }
    public function registrar(){
        return $this->save();
    }
    public function modificar(){
        return $this->update();
    }
    public function eliminar(){
        return $this->delete();
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
        if($this->User_like()->wherePivot("user_id",$id)->count() >= 1 ){
            return true;
        }
        else{
            return false;
        }
    }
    public function dislike_this_user($id){
        if($this->User_dislike()->wherePivot("user_id",$id)->count() >=1){
            return true;
        }
        else{
            return false;
        }
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
    /** Relaciones */
    public function User(){
        return $this->belongsTo(User::class,"id_users","id");
    }
    public function Commentaries(){
        return $this->hasMany(Commentary::class,"id_questions","id");
    }
    public function User_like(){
        return $this->belongsToMany(User::class);
    }
    public function User_dislike(){
        return $this->belongsToMany(User::class,"question_user_dislike");
    }
}
