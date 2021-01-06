$().ready(function(){
    form_question_events();
    next_page_button();
    form_question_like_events($(".form_questions_like"),"primary");
    form_question_like_events($(".form_questions_dislike"),"danger");
    
    $('#question').richText();
    $("#question").val("Escribe una pregunta aquí...").trigger("change");

});
var spinner = `<div class="d-flex justify-content-center mb-3" id="spinner">
                    <div class="spinner-border text-dark text-center" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>`;
function form_question_events(){
    $("#form_question").submit(function(e){
        e.preventDefault();
        if($("#question").val()!="<div><br></div>"){
                                   
            var formulario = $(this);
            var token = formulario.find("input[name=_token]");
            $.ajax({
                headers:{"X-CSRF-TOKEN":token},
                url:formulario.attr("action"),
                type:formulario.attr("method"),
                data:formulario.serialize(),
                success:function(response){
                    $("#preguntas").prepend(response);
                    $("#question").val("Escribe una pregunta aquí...").trigger("change");
                    
                    forms_commentaries($("#preguntas").find(".form_comentaries:first"));
                    form_question_like_events($("#preguntas").find(".form_questions_like:first"),"primary");
                    form_question_like_events($("#preguntas").find(".form_questions_dislike:first"),"danger");

                    events_question_edit($("#preguntas").find(".question-edit:first"));
                    events_question_delete($("#preguntas").find(".question-delete:first"));
                    
                    show_toast("Acabas de Realizar una Pregunta!");
                    $("html, body").animate({
                        scrollTop: $("#preguntas").find(".row:first-child").offset().top-55
                    }, 1000);
                },
                error:function(error){
                    if(error.responseJSON.message=="Unauthenticated."){
                        location.href=$("#root").attr("href")+"/login";
                    }
                }
            });
        }
    });
}
function next_page_button(){
    $("#nextPageQuestions").click(function(e){
        e.preventDefault();
        var button_next =$(this);
        $.ajax({
            url:$(this).attr("href"),
            type:"get",
            beforeSend:function(){
                var button_temp = button_next;
                button_temp.remove();
                $("#preguntas").append(spinner);
            },
            complete:function(){
                $("#spinner").remove();
            },
            success:function(response){
                
                $("#preguntas").append(response);

                var cant_new_elements=$(response).find(".form_comentaries").length;
                var cant_total=$("#preguntas").find(".form_comentaries").length;

                forms_commentaries($("#preguntas").find(".form_comentaries").slice(cant_total-cant_new_elements) );
                form_question_like_events($("#preguntas").find(".form_questions_like").slice(cant_total-cant_new_elements),"primary");
                form_question_like_events($("#preguntas").find(".form_questions_dislike").slice(cant_total-cant_new_elements),"danger");

                cant_new_elements=$(response).find(".form_sub_commentaries").length;
                cant_total=$("#preguntas").find(".form_sub_commentaries").length;

                forms_subcommentaries($("#preguntas").find(".form_sub_commentaries").slice(cant_total-cant_new_elements) );
                form_commentary_like_events($("#preguntas").find(".form_commentaries_like").slice(cant_total-cant_new_elements),"primary");
                form_commentary_like_events($("#preguntas").find(".form_commentaries_dislike").slice(cant_total-cant_new_elements),"danger");

                cant_new_elements=$(response).find(".form_sub_commentaries_like").length;
                cant_total=$("#preguntas").find(".form_sub_commentaries_like").length;
                
                form_subcommentary_like_events($("#preguntas").find(".form_sub_commentaries_like").slice(cant_total-cant_new_elements),"primary");
                form_subcommentary_like_events($("#preguntas").find(".form_sub_commentaries_dislike").slice(cant_total-cant_new_elements),"danger");

                cant_new_elements=$(response).find(".nextPageCommentaries").length;
                cant_total=$("#preguntas").find(".nextPageCommentaries").length;

                next_page_commentaries_button($("#preguntas").find(".nextPageCommentaries").slice(cant_total-cant_new_elements));

                cant_new_elements=$(response).find(".nextPageSubcommentaries").length;
                cant_total=$("#preguntas").find(".nextPageSubcommentaries").length;
                next_page_subcommentaries_button($("#preguntas").find(".nextPageSubcommentaries").slice(cant_total-cant_new_elements));

                cant_new_elements=$(response).find(".question-edit").length;
                cant_total=$("#preguntas").find(".question-edit").length;

                events_question_edit($("#preguntas").find(".question-edit").slice(cant_total-cant_new_elements));
                events_question_delete($("#preguntas").find(".question-delete").slice(cant_total-cant_new_elements));
                
                cant_new_elements=$(response).find(".commentary-edit").length;
                cant_total=$("#preguntas").find(".commentary-edit").length;
                
                events_commentary_edit($("#preguntas").find(".commentary-edit").slice(cant_total-cant_new_elements));
                events_commentary_delete($("#preguntas").find(".commentary-delete").slice(cant_total-cant_new_elements));

                cant_new_elements=$(response).find(".question-edit").length;
                cant_total=$("#preguntas").find(".question-edit").length;

                events_subcommentary_edit($("#preguntas").find(".subcommentary-edit").slice(cant_total-cant_new_elements));
                events_subcommentary_delete($("#preguntas").find(".subcommentary-delete").slice(cant_total-cant_new_elements));
                next_page_button();
            },
            error:function(error){
                $("#preguntas").append(button_next);
                if(error.responseJSON.message=="Unauthenticated."){
                    location.href=$("#root").attr("href")+"/login";
                }
            }
        });
    });
}
function form_question_like_events(selector,clase){
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
                        var el=elemento.parent().find(".dislike_total_question");
                        if(el.html()!="" ){
                            if( parseInt(el,10) != x.dislikes ){
                                elemento.parent().find(".btn_dislike_total_question").removeClass("btn-danger");
                                elemento.parent().find(".btn_dislike_total_question").addClass("btn-outline-danger");
                                el.html(x.dislikes);
                            }
                        }
                        p.html(x.likes);
                        
                    }
                    else{
                        var el=elemento.parent().find(".like_total_question");
                        if(el.html()!="" ){
                            if( parseInt(el,10) != x.likes ){
                                elemento.parent().find(".btn_like_total_question").removeClass("btn-primary");
                                elemento.parent().find(".btn_like_total_question").addClass("btn-outline-primary");
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
  
function show_toast(mensaje){
    var option = {
        animation: true,
        autohide:true,
        delay:5000
    };
    $("#toast-body").html(mensaje);
    $("#tostada").toast(option);
    $("#tostada").toast("show");
}