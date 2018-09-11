function notification_update (url,data) {
	$.ajax({
        url:url,
        type:"PUT",
        dataType:'json',
        data:data,
        success: function(response) {
            if(response.success == 'Operation Successful'){
                $('#exampleModal').modal('show');
            } else if(response.error) {
                alert(response.error);
            }
        },
        error: function(e) {
            var obj = $.parseJSON(e.responseText);
            var err_msg='';
            $.each(obj,function (i,error){
                err_msg+= error +"<br>";
            });
            msg   = err_msg;
            alert(msg);
        }
    });
}

function like_dislike (url,data) {
	$.ajax({
        url:url,
        type:"PUT",
        dataType:'json',
        data:data,
        success: function(response) {
            if(response.success){
                alert(response.success);
                location.reload();
            } else if(response.error) {
                alert(response.error);
            }
        },
        error: function(e) {
            var obj = $.parseJSON(e.responseText);
            var err_msg='';
            $.each(obj,function (i,error){
                err_msg+= error +"<br>";
            });
            msg   = err_msg;
            alert(msg);
        }
    });
}