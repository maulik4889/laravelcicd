

$(document).on('click', '.userstatus', function (e) {
    e.preventDefault();
    var id = $(this).data('id');
    var user_id = $(this).data('user_id');
    var status = $(this).data('status');
if(status == 1)
{
  status_value = "activate";
 
}
else
{
      status_value = "deactivate";
      
}
    swal({
            title: "Are you sure you want to " + status_value + " the post?",
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes!",
            showCancelButton: true,
        },
        function() {

            $.ajax({
                type: "get",
                url: "reportedPosts/status",
                data: {id:id, status:status,user_id:user_id},
                success: function (data) {

                  var response = JSON.parse(data);


                  if(response["status"] == 200){

                    swal(
                      'Success',
                      response["response"],
                      'success'
                    )
                    setTimeout(function(){
                        location.reload();
                      }, 2000);

                  }else{
                    swal(
                      'Error',
                      response["response"],
                      'error'
                    )
                  }

                    }
            });
    });
});



$(document).on('click', '.u_status_single', function (e) {
    e.preventDefault();
     var id = $(this).data('id');
     var user_id = $(this).data('user_id');
    var status = $(this).data('status');
if(status == 1)
{
  status_value = "activate";
 
}
else
{
      status_value = "deactivate";
      
}
    swal({
            title: "Are you sure you want to " + status_value + " the post?",
            type: "error",
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes!",
            showCancelButton: true,
        },
        function() {

            $.ajax({
                type: "get",
                url: "../reportedPosts/status",
                data: {id:id, status:status,user_id:user_id},
                success: function (data) {

                  var response = JSON.parse(data);


                  if(response["status"] == 200){

                    swal(
                      'Success',
                      response["response"],
                      'success'
                    )
                    setTimeout(function(){
                        location.reload();
                      }, 2000);

                  }else{
                    swal(
                      'Error',
                      response["response"],
                      'error'
                    )
                  }

                    }
            });
    });
});
