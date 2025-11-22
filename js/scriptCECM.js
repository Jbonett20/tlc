function codigoFuncion(){
    var codigoProductoNum=Math.round(Math.random()*999999);
  document.guardarProducto.CodigoProducto.value=codigoProductoNum;
}

function ClearSearch(){
  document.getElementById("search").value="";

}
function ClearUnidad(){
  document.getElementById("UnidadId").value="";
  
}
function ClearFraccion(){
  document.getElementById("fraccionID").value="";
  
}
// function ValueFocus(){
//   document.getElementById("dinero").value=0;
	
// }

function limpia(elemento)
{
elemento.value = "";
}
function format(input)
{
// var num = input.value.replace(/\./g,'');
// if(!isNaN(num)){
// num = num.toString().split('').reverse().join('').replace(/(?=\d*\.?)(\d{3})/g,'$1.');
// num = num.split('').reverse().join('').replace(/^[\.]/,'');
// input.value = num;
// }
 
// else{ alert('Solo se permiten numeros');
// input.value = input.value.replace(/[^\d\.]*/g,'');
// }
}
 

   function CambiarT(){
    var vista = document.getElementById('vistaProducto');
    var checkbox = document.getElementById('EnableVista');
  if(checkbox.value=='[+]'){
    document.getElementById('vistaProducto').className = "col-md-9";
    checkbox.value='[-]'
     // document.getElementById('vistaProducto').classList.add = ("col-md-8");
     // alert("col-md-8");
  }else if (checkbox.value=='[-]'){
    
    document.getElementById('vistaProducto').className = "col-md-12";
    checkbox.value='[+]'
   // document.getElementById('vistaProducto').classList.add = ("col-md-12");
    // alert("col-md-12");
  }
} 
function CambiarTD(){
    // var vista = document.getElementById('vistaProducto');
    var checkbox = document.getElementById('EnableVista');
  if(checkbox.value=='[+]'){
    // document.getElementById('vistaProducto').className = "col-md-8";
    checkbox.value='[-]'
     // document.getElementById('vistaProducto').classList.add = ("col-md-8");
     // alert("col-md-8");
  }else if (checkbox.value=='[-]'){
    
    // document.getElementById('vistaProducto').className = "col-md-12";
    checkbox.value='[+]'
   // document.getElementById('vistaProducto').classList.add = ("col-md-12");
    // alert("col-md-12");
  }
}

$("#number").on({
    "focus": function (event) {
        $(event.target).select();
    },
    "keyup": function (event) {
        $(event.target).val(function (index, value ) {
            return value.replace(/\D/g, "")
                        .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
        });
    }
});



