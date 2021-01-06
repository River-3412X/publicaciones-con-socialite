$().ready(function(){
    events_commentary_edit($(".commentary-edit"));
});
function events_commentary_edit(selector){
    selector.each(function(){
        $(this).click(function(e){
            e.preventDefault();
            var button= $(this);
            $.ajax({
                type:"get",
                url:$(this).attr("href"),
                success:function(response){
                    $("#modal_edit_body").html(response);
                    $("#modal_edit").modal("show"); 
                    event_commentary_update($(".commentary_update"),button);
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
function nl2br (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
function  event_commentary_update(selector,element){
    selector.submit(function(e){
        e.preventDefault();
        $("#modal_edit").modal("hide");
        $.ajax({
            headers:{"X-CSRF-TOKEN":$(this).find("input[name=_token]")},
            url:$(this).attr("action"),
            type:$(this).attr("method"),
            data:$(this).serialize(),
            success:function(response){
                show_toast(response);
                element.parent().parent().parent().next().html(nl2br(selector.find("textarea").val()));
            },
            error:function(error){
                if(error.responseJSON.message=="Unauthenticated."){
                    location.href=$("#root").attr("href")+"/login";
                }
            }
        });
    });
}