 $(function() {
    $(".nav > li").click(function() {
    //Busca todos los elementos del lista que tengan la clase active y los elimina
  $(this).closest('.nav').find('li').removeClass('active');
  //Al elemento seleccionado agrega la clase active
          $(this).addClass('active');
          
      });
});

 
 
