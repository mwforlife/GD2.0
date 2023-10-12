//Funcion cargar regiones
function listarregiones(){
    $.ajax({
        type: "POST",
        url: "php/cargar/regiones.php",
        success: function(data){
            $(".regiones").html(data);
        }
    });
}

//Funcion listar comunas
function listarcomunas(){
    var region = $(".regiones").val();
    $.ajax({
        type: "POST",
        url: "php/cargar/comunas.php",
        data: "id="+region,
        success: function(data){
            $(".comunas").html(data);
        }
    });
}

//listarCiudades
function listarciudades(){
    var region = $(".regiones").val();
    $.ajax({
        type: "POST",
        url: "php/cargar/ciudades.php",
        data: "id="+region,
        success: function(data){
            $(".ciudades").html(data);
        }
    });
}

function formatoMiles(input) {
    // Elimina cualquier carácter que no sea un número o un punto
    input.value = input.value.replace(/[^\d.]/g, '');
  
    // Divide el valor en partes antes y después del punto decimal
    var parts = input.value.split(',');
    var integerPart = parts[0];
    var decimalPart = parts[1] || '';
  
    // Agrega separadores de miles al número entero
    integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
  
    // Vuelve a unir las partes con el punto decimal
    input.value = integerPart + (decimalPart ? '.' + decimalPart : '');
  }
  