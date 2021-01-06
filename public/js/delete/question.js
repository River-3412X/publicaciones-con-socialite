$().ready(function(){
    events_question_delete($(".question-delete"));
});
var modal_delete= `<div class="modal fade" id="modal_delete">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-dark text-white">
                                    Mensaje
                                    <button class="btn" data-dismiss="modal"><span>&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    <h3 id="title_modal_delete"></h3>
                                    <p class="m-0" id="content_modal_delete"></p>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success" id="modal_delete_success">Aceptar</button>
                                    <button class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>`;
function events_question_delete(selector){
    selector.each(function(){
        $(this).submit(function(e){
            e.preventDefault();
            $("#preguntas").append(modal_delete);
            $("#title_modal_delete").html("¿Estas seguro de eliminar la pregunta?");
            $("#modal_delete_success").attr("onclick","delete_question('"+$(this).attr("id")+"')");
            $("#modal_delete").modal();
        });
    });
}
function delete_question(id){
    $("#modal_delete").modal("hide");
    var formulario = $("#"+id);
    $.ajax({
        headers:{"X-CSRF-TOKEN":formulario.find("input[name=_token]")},
        type:formulario.attr("method"),
        url:formulario.attr("action"),
        data:formulario.serialize(),
        complete:function(){
            $("#modal_delete").remove();
        },
        success:function(response){
            show_toast(response);
            formulario.parent().parent().parent().parent().parent().parent().remove();
        },  
        error:function(error){
            if(error.responseJSON.message=="Unauthenticated."){
                location.href=$("#root").attr("href")+"/login";
            }
        }
    });
}