(function(){

    //acceder al formulario
    var formulario = document.getElementsByName("formulario")[0],
        elementos = formulario.elements,  //se accede a los elementos   
        boton = document.getElementById("boton");

    var validarNit= function(e){
        if(!formulario.nit.value){
        alert("Ingrese el nit.");
        e.preventDefault(); //previniendo el evento submit
        }
    };
    
    var validarNombre= function(e){
        if(formulario.nombre.value == 0){
        alert("Ingrese el nombre del proveedor.");
        e.preventDefault();
        }
    };

    var validarApellido= function(e){
        if(formulario.apellido.value == 0){
        alert("Ingrese el apellido del proveedor.");
        e.preventDefault();
        }
    };

    var validarDireccion= function(e){
        if(formulario.direccion.value == 0){
        alert("Ingrese la dirección.");
        e.preventDefault();
        }
    };
    
    
    
    var validarTelefono= function(e){
        if(formulario.telefono.value == 0){
        alert("Ingrese el teléfono.");
        e.preventDefault();
        }
    };

    var validarCorreo= function(e){
        if(formulario.correo.value == 0){
        alert("Ingrese el correo.");
        e.preventDefault();
        }
    };

    var validarDepartamento= function(e){
        if(formulario.departamento.value == 0){
        alert("Ingrese el departamento.");
        e.preventDefault();
        }
    };

    var validarMunicipio= function(e){
        if(formulario.municipio.value == 0){
        alert("Ingrese el municipio.");
        e.preventDefault();
        }
    };


    
    var validar =  function(e){
        validarNit(e);
        validarNombre(e);
        validarApellido(e);
        validarTelefono(e);
        validarCorreo(e);
        validarDireccion(e);
        validarDepartamento(e);
        validarMunicipio(e);
    };

    formulario.addEventListener("submit",validar);
    }())

    