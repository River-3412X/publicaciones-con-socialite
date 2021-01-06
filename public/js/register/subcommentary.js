$().ready(function(){
    forms_subcommentaries($(".form_sub_commentaries"));
    form_subcommentary_like_events($(".form_sub_commentaries_like"),"primary");
    form_subcommentary_like_events($(".form_sub_commentaries_dislike"),"danger");
    next_page_subcommentaries_button($(".nextPageSubcommentaries"));
});
function forms_subcommentaries(selector){
    selector.each(function(){ 
        $(this).submit(function(e){
            e.preventDefault();
            var formulario = $(this);
            var token = formulario.find("input[name=_token]");
            $.ajax({
                headers:{"X-CSRF-TOKEN":token},
                url:formulario.attr("action"),
                type:formulario.attr("method"),
                data:formulario.serialize(),
                success:function(respuesta){
                    
                    formulario.parent().next().prepend(respuesta);
                    form_subcommentary_like_events(formulario.parent().next().find(".form_sub_commentaries_like:first"),"primary");
                    form_subcommentary_like_events(formulario.parent().next().find(".form_sub_commentaries_dislike:first"),"danger");
                    show_toast("Acabas de Responder un Comentario!<br>"+formulario.find("textarea").val());

                                                  
                    events_subcommentary_edit(formulario.parent().next().find(".subcommentary-edit:first"));
                    events_subcommentary_delete(formulario.parent().next().find(".subcommentary-delete:first"));
                    

                    formulario.find("textarea").val("");
                },error:function(error){
                    if(error.responseJSON.message=="Unauthenticated."){
                        location.href=$("#root").attr("href")+"/login";
                    }
                }
            });
        });
    });
}
function form_subcommentary_like_events(selector,clase){
    
    selector.each(function(){
        
        $(this).submit(function(e){
            e.preventDefault();
            var p=  $(this).find("p");
            var button=$(this).find("button");
            button.attr("disabled",true);
            var elemento =$(this);
            $.ajax({
                headers:{"X-CSRF-token":$(this).find("input[name=_token]")},
                url:$(this).attr("action"),
                type:$(this).attr("method"),
                data:$(this).serialize(),
                success:function(response){
                    var x= JSON.parse(response);                       
                    
                    if(clase=="primary"){
                        var el=elemento.parent().find(".dislike_total_subcommentary");
                        if(el.html()!="" ){
                            if( parseInt(el,10) != x.dislikes ){
                                elemento.parent().find(".btn_dislike_total_subcommentary").removeClass("btn-danger");
                                elemento.parent().find(".btn_dislike_total_subcommentary").addClass("btn-outline-danger");
                                el.html(x.dislikes);
                            }
                        }
                        p.html(x.likes);
                        
                    }
                    else{
                        var el=elemento.parent().find(".like_total_subcommentary");
                        if(el.html()!="" ){
                            if( parseInt(el,10) != x.likes ){
                                elemento.parent().find(".btn_like_total_subcommentary").removeClass("btn-primary");
                                elemento.parent().find(".btn_like_total_subcommentary").addClass("btn-outline-primary");
                                el.html(x.likes);
                            }
                        }
                        p.html(x.dislikes);
                    }
                    
    
                    if(button.hasClass("btn-outline-"+clase)){
                        button.removeClass("btn-outline-"+clase);
                        button.addClass("btn-"+clase);
                    }
                    else{
                        button.removeClass("btn-"+clase);
                        button.addClass("btn-outline-"+clase);
                    }
                    button.attr("disabled",false);
                },
                error:function(error){
                    if(error.responseJSON.message=="Unauthenticated."){
                        location.href=$("#root").attr("href")+"/login";
                    }
                }
            });
        });
    });
}
function next_page_subcommentaries_button(selector){
    selector.each(function(){
        $(this).click(function(e){
            e.preventDefault();
            botton=$(this);
            elemento=botton.parent();
            $.ajax({
                url:$(this).attr("href"),
                type:"get",
                beforeSend:function(){
                    var botton_temp = botton;
                    botton_temp.remove();
                    $(elemento).append(spinner_commentary);
                },
                complete:function(){
                    $("#spinner_commentary").remove();
                },
                success:function(response){ 
                    elemento.append(response);

                    var cant_new_elements=$(response).find(".form_sub_commentaries_like").length;
                    var cant_total=elemento.find(".form_sub_commentaries_like").length;
                    
                    form_subcommentary_like_events(elemento.find(".form_sub_commentaries_like").slice(cant_total-cant_new_elements),"primary");
                    form_subcommentary_like_events(elemento.find(".form_sub_commentaries_dislike").slice(cant_total-cant_new_elements),"danger");
 
                    cant_new_elements=$(response).find(".subcommentary-edit").length;
                    cant_total=elemento.find(".subcommentary-edit").length;
                    
                    events_subcommentary_edit(elemento.find(".subcommentary-edit").slice(cant_total-cant_new_elements));
                    events_subcommentary_delete(elemento.find(".subcommentary-delete").slice(cant_total-cant_new_elements));

                    if(elemento.find(".nextPageCommentaries").length==1){
                        next_page_commentaries_button(elemento.find(".nextPageCommentaries"));
                    }
                },
                error:function(error){
                    elemento.append(botton);
                    if(error.responseJSON.message=="Unauthenticated."){
                        location.href=$("#root").attr("href")+"/login";
                    }
                }
            });
        });
    });
}