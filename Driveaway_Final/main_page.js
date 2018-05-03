function refresh(url){
    $("#conteudo").load(url);
}
$(document).ready(function () {



  

    $(document).on('click', '.datepicker', function() {                                  
        $(this).datepicker({
            format: 'yyyy-mm-dd'
        });                    
    });        
   
    /*
    $(document).on('click','.navbar-nav li a', function(){
       $("#conteudo").load($(this).data('url'));      
     
    });
    */
    $(".navbar-nav li a, a.navbar-brand").click(function(event) {
      $("#conteudo").load($(this).data('url'));  
    });

    $(".footer li a").click(function(){
      $("#conteudo").load($(this).data('url'));
    });
    
     $(document).on('click', '#perfil_modal', function(){
        $.ajax({
          type: "POST",
          url: "perfil.php",                      
          success: function(data){
            $("#perfil_modal_body").html(data);
            $("#perfil").modal("toggle");
          }              
        });
    });
     
     
     $(document).on('click', '#modal_perfil', function(){
        if($("#phone").val()!="" && $("#email").val()!="" && $("#address").val()!=""){
            $.ajax({
              type: "POST",
              url: "perfil.php?enviar=1",
              data: $("#formulario_perfil").serialize(),                      
              success: function(data){
                $("#perfil_modal_body").html(data);
                $("#perfil").modal();
              }              
            });
          }

          else{
            alert("So pode deixar os campos da password em branco.");
          }
    });


    $("#perfil").on('hidden.bs.modal', function(event) {
        $("#perfil_modal_body").empty();
      });              
      
 });                 