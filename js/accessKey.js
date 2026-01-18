document.addEventListener('DOMContentLoaded', function() {
    document.onkeydown = function(event) {
        var key_press = String.fromCharCode(event.keyCode);
        var key_code = event.keyCode;
       

        if (key_code==119) {
            var dinero = document.getElementById("dinero");
            if (dinero) dinero.focus();
           
           
        } 
        if (key_code==118) {
            var search = document.getElementById("search");
            if (search) search.focus();
           
        }
       if (key_code==120) {
            var searchK = document.getElementById("searchK");
            if (searchK) searchK.focus();
           
        } if (key_code==17) {
            var unidadId = document.getElementById("UnidadId");
            if (unidadId) unidadId.focus();
           
        }
      
       
    };
});