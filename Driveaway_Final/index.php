<?php 
  
  $root = __DIR__;
  include 'mailer.php';
  include 'notificacoes/nova_notificacao.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>DriveAway</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="styles.css">
 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.js"></script> 
  <script type="text/javascript" src="main_page.js"></script>

</head>
<body>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#" data-url="pag_comuns/home.php"><img src="driver-512.png" height="45" width="41" id="logotipo"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav" id="main_links">
         <?php
            include "menu.php";                   
          ?>
          <li id="login_sm">
              <?php
                include "login_link.php";                           
              ?>
          </li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        
        <li>
          <?php
            include "login_link.php";                           
          ?>        
        </li>

      </ul>
    </div>
  </div>
</nav>

 <div class="modal fade" id="perfil" role="dialog">
    <div class="modal-dialog">                    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
              
              <h4 class="modal-title">Perfil de Utilizador</h4>
            </div>
            <div class="modal-body" id="perfil_modal_body">
              
            </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-primary" name="submit" value="Atualizar Perfil" id="modal_perfil">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

            </div>
      </div>                      
    </div>
</div> 
<div class="container text-center">
  <div class="row">
    <div class="col-sm-12">
      <?php 
        if(isset($_SESSION['tipo'])){
          include $root."/notificacoes/not.php";
        }
        
     ?>
    </div>
     
  </div>
</div>
<div class="container-fluid text-center">    
  <div class="row content">    
    <div class="col-sm-12" id="conteudo"> 
      
    </div>    
  </div>
</div>

<footer class="container-fluid text-center footer navbar-fixed-bottom">
  <ul id="footer_items" class="list-unstyled">
    <li><a href="#" data-url="pag_comuns/home.php">Home</a></li>
    <li><a href="#" data-url="pag_comuns/faq.php">FAQS</a></li>
    <li><a href="#" data-url="pag_comuns/precos.php">Preçário</a></li>
    <li><a href="#" data-url="pag_comuns/QuemSomos.php">Quem Somos</a></li>
    <li><a href="#" data-url="pag_comuns/horario.php">Contactos</a></li>    
  </ul>
</footer>

<script type="text/javascript">
  var sessao_tipo ='<?php echo $_SESSION["tipo"]; ?>';
  var root_dir ='<?php echo $root; ?>'; 

  var eSecretaria ='<?php echo $_SESSION['secretaria']; ?>'; 


  if(sessao_tipo=="aluno" || (sessao_tipo=="funcionario" && eSecretaria!=true)){
    refresh("calendario/calendario.php");
  }else{
    refresh("pag_comuns/home.php");
  }
  $(document).ready(function(){
    $('.carousel').carousel({
      interval: 2000
    });  
  });
</script>
</body>
</html>