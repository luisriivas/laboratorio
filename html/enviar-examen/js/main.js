const inputs = document.querySelectorAll(".input");

function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}

inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});

document.addEventListener("DOMContentLoaded", (event) => {
    let select = document.querySelector('#id_examen');
    $('#id_examen').children('option:not(:first)').remove();
    $.ajax({
        url: "../../php/obtener_examenes.php",
        success: function(data){
            data = JSON.parse(data);
            if(data.code === 200) {
                for(let i of data.data){
                    let opt = document.createElement('option');
                    opt.value = i.id_examen;
                    opt.innerHTML = i.nombre+' '+i.nombre_examen;
                    select.appendChild(opt);
                }
            } else if(data.code === 404) {
                $("#alerta").html(data.mensaje);
                $("#alert").fadeIn();
            }
        },
        error: function(){
            $("#alerta").html("<div id='alert' class='alert alert-warning collapse'>Hubo un error con la llamada Ajax. Por favor, inténtelo más tarde.<a class='close' data-dismiss='alert'>&times;</a></div>");
        }
    });
});

$("form").submit(function(event){
    event.preventDefault();
    var datatopost = $(this).serializeArray();
    $.ajax({
        url: "../../php/enviar_examen.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            data = JSON.parse(data);
            console.log(data);
            

            try {
                if(data.cUpdate === 200) {
                    var html = "<div class='child-div'>" + data.update + "</div>";
                    $("#alerta").prepend(html);
                    $("#alert").fadeIn();
                }
                if(data.cUpdate === 400) {
                    var html = "<div class='child-div'>" + data.update + "</div>";
                    $("#alerta").prepend(html);
                    $("#alert").fadeIn();
                }
                if (data.codecorreo === 200) {
                    var html = "<div class='child-div'>" + data.correo + "</div>";
                    $("#alerta").prepend(html);
                    $("#alert").fadeIn();
                }
                if(data.codecorreo === 400) {
                    var html = "<div class='child-div'>" + data.correo + "</div>";
                    $("#alerta").prepend(html);
                    $("#alert").fadeIn();
                }
            } catch (error) {
                console.log('ERROR. Recibido:', data);

            }
        },
        error: function(){
            $("#alerta").html("<div id='alert' class='alert alert-warning collapse'>Hubo un error con la llamada Ajax. Por favor, inténtelo más tarde.<a class='close' data-dismiss='alert'>&times;</a></div>");
        }
    });
});