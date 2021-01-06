$().ready(function(){
    events_commentary_delete($(".commentary-delete"));
});

function events_commentary_delete(selector){
    selector.each(function(){
        $(this).submit(function(e){
            e.preventDefault();
            $("#preguntas").append(modal_delete);
            $("#title_modal_delete").html("¿Estas seguro de eliminar el comentario?");
            $("#modal_delete_success").attr("onclick","delete_commentary('"+$(this).attr("id")+"')");
            $("#modal_delete").modal();
        });
    });
}

function delete_commentary(id){
    $("#modal_delete").modal("hide");
    var formulario= $("#"+id);
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