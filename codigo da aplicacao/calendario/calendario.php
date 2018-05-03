<?php 
  
  session_start();
  //$_SESSION['tipo'] = "aluno";
  /*
  $_SESSION['tipo'] = "funcionario";
  $_SESSION["id_tipo"] = 2;
  $_SESSION["secretaria"] = true;
  */
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>Collapsible sidebar using Bootstrap 3</title>

         <!-- Bootstrap CSS CDN 
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      -->
        
        <!-- Custom CSS -->      
        

        <!-- Scripts JavaScript        
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>                
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  -->

    <style type="text/css">
      .calendar_table, .calendar_table th, .calendar_table td {
          border: 1px solid black;
          border-collapse: collapse;
          text-align: center;
          margin: auto;
          font-size: 10pt;

      }

      p{display: block;}

      .calendar_table td, .calendar_table th{width: 100px; height: 50px;}
      #semanas{display: inline-block;}
      

      .red{background-color: red;}
      .green{background-color: green;}
      .yellow{background-color: yellow;}
      .lightgray{background-color: lightgray;}
      .purple{background-color: purple;}

      .calendar_table td {
            text-align: center;
            table-layout:fixed
        }

       

        
        
        @media screen and (min-width: 1000px) {
            .calendar_table {
                display: inline-table;    
            }
            
            .calendar_table:not(:nth-of-type(1)) td:first-of-type {
                display: none;    
            }
            
            .calendar_table td{border: 1px solid black;height: 30px; max-width: 100px; overflow:hidden;white-space: nowrap; text-overflow: ellipsis; }
            
        }
         @media screen and (max-width: 1000px) {
            
           
            .calendar_table td{height: 30px;font-size: 30px;}

            .calendar_table td:nth-of-type(2){
                width: 80%;
                
            }



            textarea{
              width: 10em;
            }

            .modal-dialog{
              width: 90%;
              margin: auto;

            }
            .btn{
              font-size: 15px;
              
            }
            #pedir_aula{

            }

        }
    </style>
      
    </style>
  </head>
  <body>
    <div class="container-fluid">
    <h1> Calendário </h1>

      <div id="semanas_dinamicas">
        <button id="anterior"><-</button>
        <div id="semanas"></div>
        <button id="seguinte"> -> </button>
      </div>

      <br>

      
    <div class="tabela" id='tab'>
      
      
    </div>

    <div>
      <p><span class="red">&nbsp&nbsp</span> pedidos de cancelamento de aulas
      <span class="green">&nbsp&nbsp</span> aulas marcadas
      <span class="yellow">&nbsp&nbsp</span> pedidos de novas aulas
      <span class="lightgray">&nbsp&nbsp</span> aulas teoricas
      <span class="purple">&nbsp&nbsp</span> exames marcados</p>
    </div>


    <div class="modal fade " id="modal_aula" role="dialog">
        <div class="modal-dialog">                    
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body" id="modal_aula_body"></div>
          </div>                      
        </div>
    </div>

  </div>


        <!-- jQuery CDN -
         <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
         Bootstrap js CDN 
         <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
       -->


         <script>
        $(document).ready(function(){

          //var tipo_pessoa = '<?php //echo $_SESSION['tipo']; ?>';

          
          var id_tipo = '<?php if(isset($_GET["id_tipo"])){
            echo $_GET["id_tipo"];
          } 
          else{
            echo $_SESSION['id_tipo'];
          }?>';

          var secretaria = '<?php echo $_SESSION["secretaria"]; ?>';



          //console.log(sessao_tipo);//é o debaixo
          console.log(id_tipo);
          var get_dia = '<?php echo $_GET["dia"]; ?>';
          console.log(get_dia);
          if(get_dia != ""){
            var hoje =  new Date(String(get_dia));
          }else{
            var hoje =  new Date();
          }
          
         

          var domingo_data = domingo(hoje);
          var sabado_data=sabado(hoje);




          function domingo(d) {
              d = new Date(d);
              var day = d.getDay();
              var diff = d.getDate() - day; 
              dia =  new Date(d.setDate(diff));
              return dia; 
            }

            function sabado(d) {
               d = new Date(d);
                var day = d.getDay(),
                diff = d.getDate() - day + 6; 
                dia =  new Date(d.setDate(diff));
                
                return dia; 
            }


          //var g = getMonday(new Date());


          var d = new Date().getDate();
          var m = new Date().getMonth()+1;
          var a = new Date().getFullYear();


  


                //Hoje - Mês seguinte de hoje

                /*
                console.log("leu");
                // o mes é 0 based 
                console.log(new Date(2017,10,26).getDay()); // Dia da Semana[Domigo(0)-Sabado(7)]
                console.log(new Date(2017,10,26)); // Sun Nov 26 2017 00:00:00 GMT+0000 (WET)
                console.log(new Date().getDay()); // Dia da Semana de hoje
                console.log(new Date()); // Hoje
                console.log(new Date("2017-11-26").getDay());// Funciona bem!
                console.log(new Date("2017-11-26")); // Funciona bem!
                console.log(new Date("21-12-2017")); // Não funciona
                //$("#content").append("<tr><td>teste</td></tr>");
                */
                  


                // i é hora
                // j é dia da semana
                
                function loadCalendario(){

                  $(document).off("click","td");// retirar clicks!
                  // resolve problema de reptição de clicks na tabela que estavam a aparecer janelas duplicadas


                  //$("#tab").html("table name='tempo'><thead><tr><th></th><th>Domingo</th><th>Segunda</th><th>Terça</th><th>Quarta</th><th>Quinta</th><th>Sexta</th><th>Sabado</th></tr></thead><tbody id='content'></tbody></table>");

                  $("#tab").empty();
                  var temp_tabela = "";
               

                  var dias = ["domingo", "segunda", "terça","quarta","quinta","sexta","sabado"];
                  for(var i=0; i<=6 ; i++){

                    var data_do_dia = new Date(domingo_data);
                      data_do_dia.setDate(data_do_dia.getDate() + i);  
                      var d = data_do_dia.getDate() + "/" +(data_do_dia.getMonth()+1) + "/" +data_do_dia.getFullYear();
                      var temp_html = "<table id='table"+i+"' class='calendar_table'>";
                      temp_html += "<tr><td></td><td>"+dias[i]+"<span id='th"+i+"'></span></td></tr>";

                      for(var j=8; j<=20 ; j++){

                          temp_html += "<tr><td>"+j+":00</td><td id=" +j+"-"+i+ " data-data='"+d+"' data-hora='"+j+"'></td>";
                         

                      } 

                      temp_html += "</table>";
                      $("#tab").append(temp_html);
                       for(var j =0;j<=6;j++){
                          var data_do_dia = new Date(domingo_data);
                          data_do_dia.setDate(data_do_dia.getDate() + j);  
                          var d = data_do_dia.getDate() + "/" +(data_do_dia.getMonth()+1) + "/" +data_do_dia.getFullYear();
                          $("#th"+j).html('<br>'+d);
                      }

                  }

                }

                function laodAulasPraticas(tipo_sql){

                    //tipo_sql = dados --alterar depois

                    
                    var dom =  domingo_data.getDate() + "/" +(domingo_data.getMonth()+1) + "/" +domingo_data.getFullYear();
                    var sab =sabado_data.getDate() + "/" +(sabado_data.getMonth()+1) + "/" +sabado_data.getFullYear();

                       //console.log("pesquisa.php?tipo=aluno&dados="+tipo_sql+"&domingo="+dom+ "&sabado="+sab);
                    

                    $.ajax({
                    url: 'calendario/pesquisa.php?tipo='+sessao_tipo+'&dados='+tipo_sql+"&domingo="+dom+ "&sabado="+sab+"&id_tipo="+id_tipo,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                      var a = response.aula;                  
                      console.log(a);

                      for(var x=0;x<a.length;x++){
                        var d = new Date(a[x].dia).getDay() // Dia da Semana da Data na Base de Dados

                        var hora = parseInt(a[x].hora);

                        var aula_info_temp = "";//maensagem que aparece no td
                        if(sessao_tipo == "aluno"){
                          
                          aula_info_temp = "<p id='"+a[x].idaula+"' data-tipo_sql='"+tipo_sql+"'>"+a[x].nome+": "+a[x].marca+"-"+a[x].modelo+"</p>";
                        }
                        if(sessao_tipo == "funcionario"){
                          
                          aula_info_temp= "<p id='"+a[x].idaula+"' data-tipo_sql='"+tipo_sql+"'>"+a[x].nomealuno+": "+a[x].marca+"-"+a[x].modelo+"</p>";
                        }

                        $('#'+hora+"-"+d).html(aula_info_temp);

                        //$('#'+hora+"-"+d).removeClass()

                        if(tipo_sql == 0){
                          $('#'+hora+"-"+d).addClass("green");
                        }
                        if(tipo_sql == 1){
                          $('#'+hora+"-"+d).addClass("yellow");
                          $('#'+hora+"-"+d).html("<p id='"+a[x].idaula+"' data-tipo_sql='"+tipo_sql+"'>Pedido de aula</p>");
                        }

                        if(tipo_sql == 2){
                          $('#'+hora+"-"+d).addClass("red");
                        }
                        if(tipo_sql == 3){
                          $('#'+hora+"-"+d).addClass("purple");
                        }
    

                      }
                    }
                  });
                }

                function laodAulasTeoricas(tipo_sql){

                    //tipo_sql = dados --alterar depois
                    

                    var dom =  domingo_data.getDate() + "/" +(domingo_data.getMonth()+1) + "/" +domingo_data.getFullYear();
                    var sab =sabado_data.getDate() + "/" +(sabado_data.getMonth()+1) + "/" +sabado_data.getFullYear();
                     


                    $.ajax({
                    url: 'calendario/pesquisa.php?tipo='+sessao_tipo+'&dados='+tipo_sql+"&domingo=" +dom+ "&sabado="+sab+"&id_tipo="+id_tipo,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                      var a = response.aula;                
                      console.log(a);

                      for(var x=0;x<a.length;x++){
                        var d = new Date(a[x].dia).getDay() // Dia da Semana da Data na Base de Dados

                        var hora = parseInt(a[x].hora);
                        $('#'+hora+"-"+d).html("<p id='"+a[x].idaula+"' data-tipo_sql='"+tipo_sql+"'> Aula Teorica: "+a[x].descricao+"</p>");

                        if(tipo_sql == 4){
                          $('#'+hora+"-"+d).addClass("lightgray");
                        }

                        /*
                        $('#'+hora+"-"+d+" p").click(function(event) {
                         
                        });
                        */

                      }
                    }
                  });
                }
                

              function loads(){
                loadCalendario();
                //alert(id_tipo);
                laodAulasTeoricas(4);//aulas teoricas
                laodAulasPraticas(0);//aulas ja marcadas
                laodAulasPraticas(3);//exame
                if (sessao_tipo == "aluno") {
                  laodAulasPraticas(1);//pedidos de aulas
                }
                laodAulasPraticas(2);//pedido de cancelamento
                loadClicks(); // atribuir clicks! não haver duplicados
              }


              function getSemana(){
                domingo_data = domingo(hoje);
                sabado_data = sabado(hoje);
                //console.log(domingo_data + " - " + sabado_data);

                var semana = domingo_data.getDate() + "/" +(domingo_data.getMonth()+1) + "/" +domingo_data.getFullYear()+ " - "+sabado_data.getDate() + "/" +(sabado_data.getMonth()+1) + "/" +sabado_data.getFullYear();

                $('#semanas').html(semana);
                loads();
              }

              getSemana();

              $('#anterior').click(function(){
                  hoje.setDate(hoje.getDate()-7);
                  getSemana();
               }); 

               $('#seguinte').click(function(){
                  hoje.setDate(hoje.getDate()+7);
                  getSemana();
               }); 


               function loadClicks(){
                $(document).on('click','td p',function(event){
                  event.stopImmediatePropagation();
                //if($(this).html() == "&nbsp"){ alert("branco")}

                  var idaula = $(this).attr('id');
                  var sql = $(this).data('tipo_sql');
                  $.ajax({
                    type: "POST",
                    url: "calendario/ver_editar_aula.php?idaula="+idaula+"&dados="+sql,                      
                    success: function(data){
                      $("#modal_aula_body").html(data);
                      $("#modal_aula").modal("show");
                      
                    }


                  });
              });
              $(document).on('click', '#update_aula', function(event) {
                event.stopImmediatePropagation();
                $(this).attr("disabled", true);
                $.ajax({
                    type: "POST",
                    url: "calendario/ver_editar_aula.php?enviar=1",
                    data: $("#formulario_aula").serialize(),                      
                    success: function(data){
                      $("#modal_aula_body").html(data);
                      $("#modal_aula").modal("show");
                      //loads();
                    }              
                  });
              });

              
              $(document).on('click', '#cancelar_aula', function(event) {
                event.stopImmediatePropagation();
                //console.log("cancelou aula");
                
                if (confirm('tem a certeza que pretende cancelar a aula?')) {
                  $(this).attr("disabled", true);
                  $.ajax({
                    type: "POST",
                    url: "calendario/ver_editar_aula.php?enviar=2",
                    data: $("#formulario_aula").serialize(),                      
                    success: function(data){
                      $("#modal_aula_body").html(data);
                      $("#modal_aula").modal("hide");
                      //loads();
                    }              
                  });
                } 
                             
              });
              

              
              if(sessao_tipo == "aluno"){

                  $(document).on('click','td',function(event){
                    event.stopImmediatePropagation()
                    if($(this).html() == ""){
                      
                      var dia_aula = $(this).data('data');
                      var hora_aula = $(this).data('hora');

                      $.ajax({
                        type: "POST",
                        url: "calendario/pedir_aula.php?dia=" + dia_aula + "&hora="+hora_aula+ "&tipo="+sessao_tipo,                      
                        success: function(data){
                          $("#modal_aula_body").html(data);
                          $("#modal_aula").modal("show");
                        }              
                      });
                      
                    }
                  });

                $(document).on('click', '#pedir_aula', function(event) {
                  event.stopImmediatePropagation();
                  $(this).attr("disabled", true);
                  $.ajax({
                      type: "POST",
                      url: "calendario/pedir_aula.php?&enviar=1&tipo="+sessao_tipo+"&id_tipo="+id_tipo,
                      data: $("#formulario_pedir_aula").serialize(),                      
                      success: function(data){
                        $("#modal_aula_body").html(data);
                        $("#modal_aula").modal("hide");
                        //loads();
                        
                      }              
                    });
                  }); 
              }//fim do if aluno

              if(secretaria){
                console.log("entrou");
                $(document).on('click','td',function(event){
                  event.stopImmediatePropagation()
                    if($(this).html() == ""){
                      
                      var dia_aula = $(this).data('data');
                      var hora_aula = $(this).data('hora');

                      $.ajax({
                        type: "POST",
                        url: "calendario/marcar_aula.php?dia=" + dia_aula + "&hora="+hora_aula+ "&tipo="+sessao_tipo + "&id_tipo="+id_tipo,                      
                        success: function(data){
                          $("#modal_aula_body").html(data);
                          $("#modal_aula").modal("show");
                        }              
                      });
                      
                    }
                  });

                
                $(document).on('click', '#marcar_aula', function(event) {
                  //alert(id_tipo+" click");
                  event.stopImmediatePropagation();//parou de fazer multiplos clicks
                  $(this).attr("disabled", true);
                  $.ajax({
                        type: "POST",
                        url: "calendario/marcar_aula.php?enviar=1",
                        data: $("#formulario_marcar_aula").serialize(),                      
                        success: function(data){
                          $("#modal_aula_body").html(data);

                          $("#modal_aula").modal("hide");
                           //alert("modalclose : "+id_tipo);
                          //loads();
                        }              
                      });
                });

                $(document).on('click', '#cancelar_exame', function(event) {
                  //alert(id_tipo+" click");
                  event.stopImmediatePropagation();//parou de fazer multiplos clicks
                  $(this).attr("disabled", true);
                    if (confirm('tem a certeza que pretende cancelar o exame?')) {
                      $.ajax({
                            type: "POST",
                            url: "calendario/ver_editar_aula.php?enviar=3",
                            data: $("#formulario_aula").serialize(),                      
                            success: function(data){
                              $("#modal_aula_body").html(data);

                              $("#modal_aula").modal("hide");
                               //alert("modalclose : "+id_tipo);
                              //loads();
                            }              
                      });
                    }
                });
                

                $(document).on('click', '#rejeitar_pedido', function(event) {
                   event.stopImmediatePropagation();//parou de fazer multiplos clicks
                  $(this).attr("disabled", true);
                  $.ajax({
                        type: "POST",
                        url: "calendario/marcar_aula.php?enviar=2",
                        data: $("#formulario_marcar_aula").serialize(),                      
                        success: function(data){
                          $("#modal_aula_body").html(data);
                          $("#modal_aula").modal("hide");
                          //loads();
                        }              
                      });
                });

                $(document).on('click', '#ignorar_pedido', function(event) {
                   event.stopImmediatePropagation();//parou de fazer multiplos clicks
                  $(this).attr("disabled", true);
                  $.ajax({
                        type: "POST",
                        url: "calendario/marcar_aula.php?enviar=3",
                        data: $("#formulario_marcar_aula").serialize(),                      
                        success: function(data){
                          $("#modal_aula_body").html(data);
                          $("#modal_aula").modal("show");
                          //loads();
                        }              
                      });
                });
               }
  
              } //fim de if(secretaria)
              

              $("#modal_aula").on('hidden.bs.modal', function(event) {
                $("#modal_aula_body").empty();
                loads();
              });
            
        });
      </script>
  
        
  </body>
</html>