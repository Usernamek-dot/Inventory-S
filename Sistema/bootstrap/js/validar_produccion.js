(function() {

    //acceder al formulario
    var formulario = document.getElementsByName("formulario")[0],
        elementos = formulario.elements, //se accede a los elementos  
        boton = document.getElementById("boton");


         var validarUsuario = function(e) {
        if (!formulario.usuario.value) {
            alert("Elija el empleado encargado.");
            e.preventDefault();
        }
    };


    var validarFecha = function(e) {

        if (formulario.fecha.value == '' || formulario.fecha.value == 0) {
            alert("Elija una fecha de creación de la orden de producción.");
           e.preventDefault();
        }

    };

 
//   var validarReceta = function(e) {
//         // Se accede por nombre del campo, incluyendo los corchetes
//         // Se analiza el valor, no el campo
//         if (formulario.receta.value == 0) {
//             alert("Complete el campo receta.");
//              e. stopPropagation();  
//       } 
//     };

//       var validarCantidad = function(e) {
//         // Se accede por nombre del campo, incluyendo los corchetes
//         // Se analiza el valor, no el campo
//         if (formulario.cantidad.value == 0) {
//             alert("Complete el campo cantidad.");
//             e. stopPropagation();
//       } 

// };




    var validar = function(e) {
        validarUsuario(e);
        validarFecha(e);
        // validarReceta(e);
        // validarCantidad(e);
       
    };

    formulario.addEventListener("submit", validar);}())