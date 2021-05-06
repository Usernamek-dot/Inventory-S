(function(){

    //acceder al formulario
    var formulario = document.getElementsByName("formulario")[0],
        elementos = formulario.elements,  //se accede a los elementos   
        boton = document.getElementById("boton");

    var validarNit= function(e){
        if(formulario.nit.value == 0){
        alert("No ha digitado el nit.");
        e.preventDefault(); //previniendo el evento submit
        }
    };
    
    var validarNombre= function(e){
        if(formulario.nombre.value == 0){
        alert("falta el nombre del proveedor.");
        e.preventDefault();
        }
    };

    var validarApellido= function(e){
        if(formulario.$apellido.value == 0){
        alert("falta el nombre del contacto.");
        e.preventDefault();
        }
    };

    var validarDireccion= function(e){
        if(formulario.direccion.value == 0){
        alert("falta el la dirección.");
        e.preventDefault();
        }
    };
    
    
    
    var validarTelefono= function(e){
        if(formulario.telefono.value == 0){
        alert("falta el teléfono.");
        e.preventDefault();
        }
    };

    var validarCorreo= function(e){
        if(formulario.correo.value == 0){
        alert("falta el correo.");
        e.preventDefault();
        }
    };

    var validarMunicipio= function(e){
        if(formulario.municipio.value == 0){
        alert("falta el municipio.");
        e.preventDefault();
        }
    };


    
    var validar =  function(e){
        validarNit(e);
        validarNombre(e);
        validarApellido(e);
        validarDireccion(e);
        validarTelefono(e);
        validarCorreo(e);
        validarMunicipio(e);
    };

    formulario.addEventListener("submit",validar);
    }())

    