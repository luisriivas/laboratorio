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
    
    let select = document.querySelector('#id_cliente');

    $.ajax({
        url: "../../php/obtener_clientes.php",
        success: function(data){
            data = JSON.parse(data);
            if(data.code === 200) {
                for(let i of data.data){
                    var opt = document.createElement('option');
                    opt.value = i.id_cliente;
                    opt.innerHTML = i.nombre+" | "+i.cedula;
                    select.appendChild(opt);
                }
            } else if(data.code === 404) {
                loader.style.display = 'none';
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
        url: "../../php/solicitar_examen.php",
        type: "POST",
        data: datatopost,
        success: function(data){
            data = JSON.parse(data);
            if(data.code === 200) {
                $("#alerta").html("<div id='alert' class='alert alert-info collapse'>Fue ingresado correctamente en la base de datos.<a class='close' data-dismiss='alert'>&times;</a></div>");
                $("#alert").fadeIn();
            } else if(data.code === 400) {
                $("#alerta").html(data.data);
                $("#alert").fadeIn();
            }
        },
        error: function(){
            $("#alerta").html("<div id='alert' class='alert alert-warning collapse'>Hubo un error con la llamada Ajax. Por favor, inténtelo más tarde.<a class='close' data-dismiss='alert'>&times;</a></div>");
        }
    });
});