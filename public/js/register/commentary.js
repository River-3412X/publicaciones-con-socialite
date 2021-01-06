
$().ready(function () {
    forms_commentaries($(".form_comentaries"));
    form_commentary_like_events($(".form_commentaries_like"),"primary");
    form_commentary_like_events($(".form_commentaries_dislike"),"danger");
    next_page_commentaries_button($(".nextPageCommentaries"));
});
 var spinner_commentary = `<div class="d-flex justify-content-center my-2" id="spinner_commentary">
                                <div class="spinner-border spinner-border-sm" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>`;


function forms_commentaries(selector){
    
    selector.each(function () {
        
        $(this).submit(function (e) {
            e.preventDefault();
            var formulario = $(this);
            var token = formulario.find("input[name=_token]");
            $.ajax({
                headers: { "X-CSRF-TOKEN": token },
                url: formulario.attr("action"),
                type: formulario.attr("method"),
                data: formulario.serialize(),
                success: function (response) {
                    formulario.parent().next().prepend(response);
                    forms_subcommentaries(formulario.parent().next().find(".form_sub_commentaries:first"));
                    form_commentary_like_events(formulario.parent().next().find(".form_commentaries_like:first"),"primary");
                    form_commentary_like_events(formulario.parent().next().find(".form_commentaries_dislike:first"),"danger");
                    
                    events_commentary_edit(formulario.parent().next().find(".commentary-edit:first"));
                    events_commentary_delete(formulario.parent().next().find(".commentary-delete:first"));

                    show_toast("Acabas de Responder una Pregunta!<br>"+formulario.find("textarea").val());
                    formulario.find("textarea").val('');

                    
                }, error: function (error) {
                    
                    if(error.responseJSON.message=="Unauthenticated."){
                        location.href=$("#root").attr("href")+"/login";
                    }
                }
            });
        });
    });
}
function form_commentary_like_events(selector,clase){
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
                        var el=elemento.parent().find(".dislike_total_commentary");
                        if(el.html()!="" ){
                            if( parseInt(el,10) != x.dislikes ){
                                elemento.parent().find(".btn_dislike_total_commentary").removeClass("btn-danger");
                                elemento.parent().find(".btn_dislike_total_commentary").addClass("btn-outline-danger");
                                el.html(x.dislikes);
                            }
                        }
                        p.html(x.likes);
                        
                    }
                    else{
                        var el=elemento.parent().find(".like_total_commentary");
                        if(el.html()!="" ){
                            if( parseInt(el,10) != x.likes ){
                                elemento.parent().find(".btn_like_total_commentary").removeClass("btn-primary");
                                elemento.parent().find(".btn_like_total_commentary").addClass("btn-outline-primary");
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
function next_page_commentaries_button(selector){
    selector.each(function(){
        
        $(this).click(function(e){
            e.preventDefault();
            botton=$(this);
            elemento=botton.parent();
            $.ajax({
                url:$(this).attr("href"),
                type:"get",
                beforeSend:function(){
                    var button_temp = botton;
                    button_temp.remove();
                    $(elemento).append(spinner_commentary);
                },  
                complete:function(){
                    $("#spinner_commentary").remove();
                },
                success:function(response){ 
                    elemento.append(response);

                    var cant_new_elements=$(response).find(".form_sub_commentaries").length;
                    var cant_total=elemento.find(".form_sub_commentaries").length;

                    forms_subcommentaries(elemento.find(".form_sub_commentaries").slice(cant_total-cant_new_elements) );
                    form_commentary_like_events(elemento.find(".form_commentaries_like").slice(cant_total-cant_new_elements),"primary");
                    form_commentary_like_events(elemento.find(".form_commentaries_dislike").slice(cant_total-cant_new_elements),"danger");

                    cant_new_elements=$(response).find(".form_sub_commentaries_like").length;
                    cant_total=elemento.find(".form_sub_commentaries_like").length;
                    
                    form_subcommentary_like_events(elemento.find(".form_sub_commentaries_like").slice(cant_total-cant_new_elements),"primary");
                    form_subcommentary_like_events(elemento.find(".form_sub_commentaries_dislike").slice(cant_total-cant_new_elements),"danger");
                    
                    cant_new_elements=$(response).find(".nextPageSubcommentaries").length;
                    cant_total=elemento.find(".nextPageSubcommentaries").length;
                    next_page_subcommentaries_button(elemento.find(".nextPageSubcommentaries").slice(cant_total-cant_new_elements));
                    
                    cant_new_elements=$(response).find(".commentary-edit").length;
                    cant_total=elemento.find(".commentary-edit").length;

                    events_commentary_edit(elemento.find(".commentary-edit").slice(cant_total-cant_new_elements));
                    events_commentary_delete(elemento.find(".commentary-delete").slice(cant_total-cant_new_elements));

                    cant_new_elements=$(response).find(".subcommentary-edit").length;
                    cant_total=elemento.find(".subcommentary-edit").length;

                    events_subcommentary_edit(elemento.find(".subcommentary-edit").slice(cant_total-cant_new_elements));
                    events_subcommentary_delete(elemento.find(".subcommentary-delete").slice(cant_total-cant_new_elements));


                    if(elemento.find(".nextPageCommentaries").length==1){
                        next_page_commentaries_button(elemento.find(".nextPageCommentaries"));
                    }
                },
                error:function(error){
                    $(elemento).append(botton);
                    if(error.responseJSON.message=="Unauthenticated."){
                        location.href=$("#root").attr("href")+"/login";
                    }
                }
            });
        });
    });
}
