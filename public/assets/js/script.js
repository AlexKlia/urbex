$(function(){
    $('.vote').click(function(){
        var picId = $(this).attr('data-picture-id');
        /*console.log('hello world');*/
        $.ajax({
            method: "post",
            url: $('#ajax_operation_route').val(),
            data: {
                pictureId : picId
            },
            dataType: 'json'
        }).done(function(response){
            $('[data-id='+picId+'] .nbVote').text(response.nbVote);
        }).fail(function(r){console.log(r.responseText)});
    });
});
