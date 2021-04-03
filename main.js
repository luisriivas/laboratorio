$("form").submit(function(event){
    event.preventDefault();
    var datatopost = $(this).serializeArray();

    $.ajax({
        url: "./php/login.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            if(data == "success"){
                window.location = "html/dashboard/";
            }else{
                $('#alerta').html(data);
            }
        },
        error: function(){
            $("#alerta").html("<div class='alert alert-warning'>Hubo un error con la llamada Ajax. Por favor, inténtelo más tarde.<a class='close' data-dismiss='alert'>&times;</a></div>");
        }
    });
});