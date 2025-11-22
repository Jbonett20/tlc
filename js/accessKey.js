 document.onkeydown = function(event) {
    var key_press = String.fromCharCode(event.key_Code);
    var key_code = event.key_Code;
   

    if (key_code==119) {
        document.getElementById("dinero").focus();
       
       
    } 
    if (key_code==118) {
        document.getElementById("search").focus();
       
    }
   if (key_code==120) {
        document.getElementById("searchK").focus();
       
    } if (key_code==17) {
        document.getElementById("UnidadId").focus();
       
    }
  
   
}