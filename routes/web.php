<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\QuestionController::class,"index"])->name("inicio");

Auth::routes();

Route::get('/login/{driver}/',[App\Http\Controllers\Auth\LoginController::class,"redirectProvider"])->name("redirectProvider");
Route::get('/login/{driver}/callback',[App\Http\Controllers\Auth\LoginController::class,"handleProviderCallback"] )->name("handleProviderCallback");

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//rutas de preguntas
Route::get("/preguntas/mostrar",[App\Http\Controllers\QuestionController::class,"show"])->name("show_questions");
Route::group(["middleware"=>"auth"],function(){
    //rutas de preguntas
    Route::post("/publicar/pregunta",[App\Http\Controllers\QuestionController::class,"storage"])->name("storage_question");
    Route::post("/preguntas/like",[App\Http\Controllers\QuestionController::class,"like"])->name("like_questions");
    Route::post("/preguntas/dislike",[App\Http\Controllers\QuestionController::class,"dislike"])->name("dislike_questions");

    //rutas comentarios
    Route::post("/publicar/comentario/{id}",[App\Http\Controllers\CommentaryController::class,"storage"])->name("storage_commentary");
    Route::post("/comentarios/like",[App\Http\Controllers\CommentaryController::class,"like"])->name("like_commentaries");
    Route::post("/comentarios/dislike",[App\Http\Controllers\CommentaryController::class,"dislike"])->name("dislike_commentaries");

    //ruta segundo comentario
    Route::post("/publicar/subcomentario/{id}",[App\Http\Controllers\SubCommentaryController::class,"storage"])->name("storage_subcommentary");
    Route::post("/subcomentario/like",[App\Http\Controllers\SubCommentaryController::class,"like"])->name("like_subcommentaries");
    Route::post("/subcomentario/dislike",[App\Http\Controllers\SubCommentaryController::class,"dislike"])->name("dislike_subcommentaries");

    //editar
    Route::get("/preguntas/editar/{id}",[App\Http\Controllers\QuestionController::class,"edit"])->name("edit_question");
    Route::put("/preguntas/editar/{id}",[App\Http\Controllers\QuestionController::class,"update"])->name("update_question");
    
    Route::get("/comentarios/editar/{id}",[App\Http\Controllers\CommentaryController::class,"edit"])->name("edit_commentary");
    Route::put("/comentarios/editar/{id}",[App\Http\Controllers\CommentaryController::class,"update"])->name("update_commentary");

    Route::get("/subcomentarios/editar/{id}",[App\Http\Controllers\SubCommentaryController::class,"edit"])->name("edit_subcommentary");
    Route::put("/subcomentarios/editar/{id}",[App\Http\Controllers\SubCommentaryController::class,"update"])->name("update_subcommentary");

    //eliminar
    Route::delete("/preguntas/eliminar/{id}",[App\Http\Controllers\QuestionController::class,"delete"])->name("delete_question");
    Route::delete("/comentarios/eliminar/{id}",[App\Http\Controllers\CommentaryController::class,"delete"])->name("delete_commentary");
    Route::delete("/subcomentarios/eliminar/{id}",[App\Http\Controllers\SubCommentaryController::class,"delete"])->name("delete_subcommentary");
});
//rutas comentarios
Route::get("/comentarios/mostrar",[App\Http\Controllers\CommentaryController::class,"show"])->name("show_commentaries");

//ruta segundo comentario
Route::get("/subcomentario/mostrar",[App\Http\Controllers\SubCommentaryController::class,"show"])->name("show_subcommentaries");

Route::get("/informacion/confidencial",function(){
    return "Solo es una prueba para ver si jala esta madre y aqui deberia de estar la informacion confidencial";
})->name("prueba_confidencial")->middleware(['password.confirm']);