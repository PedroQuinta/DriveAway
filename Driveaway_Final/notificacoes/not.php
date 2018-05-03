<?php
    session_start();
    //$_SESSION['root'] =getcwd(); //$_SERVER['DOCUMENT_ROOT'];
    //{ ["tipo"]=> string(11) "funcionario" ["id_tipo"]=> int(2) ["secretaria"]=> string(1) "t" ["id"]=> string(1) "1" ["nome"]=> string(5) "teste" ["instrutor_teorica"]=> string(1) "t" ["instrutor_pratica"]=> string(1) "t" }
    /*
    $_SESSION["tipo"] ="funcionario";
    $_SESSION["id_tipo"] =2;
    $_SESSION["secretaria"] =1;
    $_SESSION["id"] =1;
    $_SESSION["nome"] ="teste";
    $_SESSION["instrutor_teorica"] ="t";
    $_SESSION["instrutor_pratica"] ="t";
    */

?>

<!DOCTYPE html>
<html>
<head>
  <style>
    panel-default{
      height: 39px;
    }
  </style>

</head>
<body>


  <script type="text/javascript" src="notificacoes/notificacoes.js"></script>

    
  <div class="panel-group" id="alertas" >
  <!--  style="display: none;" -->

    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" href="#collapse1">notificações</a>
        </h4>
      </div>

      <div id="collapse1" class="panel-collapse collapse">
        <ul class="list-group">
          <!--<li class="list-group-item">One</li>
          <li class="list-group-item">Two</li>
          <li class="list-group-item">Three</li>-->
        </ul>
        
      </div>
    </div>
  </div>
  



<script type="text/javascript">
        // faz a alteração da div id="content" consuante o like das opeções 
        // é ajax!
        
        $(document).on("click", ".list-group li a",function(){
            $("#conteudo").load($(this).data("url"), function(responseTxt, statusTxt, xhr){
                $(".collapse").collapse('hide');
                //refresh_not();
                if(statusTxt == "error")
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
            });
        });
        
       /*
       $(".list-group li a").click(function(event) {
         $("#conteudo").load($(this).data("url"), function(responseTxt, statusTxt, xhr){
                
                if(statusTxt == "error")
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
            });
       });
       */


    </script>
    
</body>
</html>
