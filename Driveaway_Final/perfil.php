<?php  
  session_start();
  include "config.php";

    

    $sql = "SELECT telefone, email, morada, username, password, facebook_id FROM pessoa WHERE pessoa.idpessoa=".$_SESSION['idpessoa'];
    $stmt=$conPdo->query($sql);         
    if($stmt->execute()){           
      if($stmt->rowCount() == 1){             
        $row=$stmt->fetch(PDO::FETCH_ASSOC);


       $param_telefone = $row['telefone'];
       $param_email = $row['email'];            
       $param_morada = $row['morada'];
       $param_username = $row['username'];

      if(isset($_GET['enviar'])){
       try {
        $conPdo->beginTransaction();
        
        $sql_update = "UPDATE pessoa SET      
          telefone=:telefone,
          email=:email,      
          morada=:morada,     
          username=:username, password=:password WHERE
          idpessoa=".$_SESSION['idpessoa'];

          if($stmt = $conPdo->prepare($sql_update)){

            $stmt->bindParam(':telefone', $param_telefone, PDO::PARAM_STR);
            $stmt->bindParam(':email', $param_email, PDO::PARAM_STR);            
            $stmt->bindParam(':morada', $param_morada, PDO::PARAM_STR);
            $stmt->bindParam(':username', $param_username, PDO::PARAM_STR);  
            $stmt->bindParam(':password', $param_password, PDO::PARAM_STR);           
            
            $param_telefone = $_POST['phone'];
            $param_email = $_POST['email'];            
            $param_morada = $_POST['address'];
            $param_username = $_POST['username'];
            $pswPassword = $_POST['password'];
           
            if(empty($_POST['password']) || empty($_POST['nova_password']) || ($_POST['password'] != $_POST['nova_password'])){
              $param_password = $row['password'];
            }else{
              $pswHash = password_hash($pswPassword, PASSWORD_BCRYPT); 
              $param_password = $pswHash; 
            }
            

            $stmt->execute();
            $conPdo->commit();
            echo "<h1>Sucesso!</h1>";
          }
      }catch (PDOException $e) {
        $conPdo->rollBack();
        die("Erro. Não foi possível executar a query $sql_update".$e->getMessage());
      }
    }
    


?>
<link rel="stylesheet" type="text/css" href="css/bootstrap-social/bootstrap-social.css">
  <link rel="stylesheet" type="text/css" href="css/bootstrap-social/assets/css/font-awesome.css">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="formulario_perfil">
  <div class="container-fluid">
    <div class="col-lg-5">
      <div class="form-group">
        <?php echo '<img src="user_images/'.$_SESSION['idpessoa'].'.png" width="50px" height="50px" style="border-radius: 50%"> ';echo $_SESSION['nome'];?>
          
      </div>
    </div>
  </div> 
  <div class="container-fluid">
    <div class="col-lg-5">
      <div class="form-group">
        <label>Username:</label>
        <input type="text" name="username" id="username" class="form-control" value="<?php echo $param_username;?>" readonly>
        <span id="username_exist" class="help-block"></span>
      </div>
    </div>
  </div>
  <div class="container-fluid">  
    <div class="col-lg-7">
      <div class="form-group">
        <label>Nova Password:</label>
        <input type="password" name="password" id="password" class="form-control">
        <span class="help-block"><?php echo $pswPassword_err; ?></span>
        <label>Confirmar Password:</label>
        <input type="password" name="nova_password" id="nova_password" class="form-control">
        <span class="help-block"><?php echo $pswPassword_err; ?></span>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="col-lg-4">  
      <div class="form-group">
        <label for="phone">Telefone:</label>
        <input type="tel" pattern="^\d{9}" title="xxxxxxxxx" name="phone" id="phone" class="form-control" value="<?php  echo $param_telefone; ?>">
        <span class="help-block"><?php echo $numPhone_err; ?></span>
      </div>
    </div>
    <div class="col-lg-8">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo $param_email; ?>">
        <span class="help-block"><?php echo $txtEmail_err; ?></span>
      </div>
    </div>
  </div>  
  <div class="container-fluid">
    <div class="col-lg-12">
      <div class="form-group">
        <label>Morada:</label>
        <input type="text" name="address" id="address" class="form-control" value="<?php echo $param_morada; ?>">
        <span class="help-block"><?php echo $txtAddress_err; ?></span>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="col-lg-12">
      <div class="form-group">
        <label>Facebook:</label>
        <?php
          if($row['facebook_id']!="" && $row['facebook_id']!=null){
            echo "Conta já associada ao facebook.";
          }else{
            echo '<button class="btn btn-social-icon btn-facebook" id="facebook_perfil"><span class="fa fa-facebook"></span></button>
        <div id="status"></div>';
          }
        ?>        
      </div>
    </div>
  </div>
                 
</form>

<script type="text/javascript">
  $(document).ready(function(){
   var id;

   $("#username,#phone,#fiscalNumber,#email").keypress(function(event) {    

      if(event.which === 32){
        event.preventDefault();
      }
    });

   $("#phone,#fiscalNumber").keypress(function(e) {
        if( (e.which < 48 || e.which >57) && e.which!= 127 && e.which!= 8){
          e.preventDefault();
        }
      });
   
    // initialize and set up facebook javascript sdk
    
    
    $(document).on("click", "#facebook_perfil", function(){      
      login();
      return false;
    });


      window.fbAsyncInit = function() {
        FB.init({
          appId      : '170697620345126',
          cookie     : true,
          xfbml      : true,        
          version    : 'v2.11'
        });
        
        FB.AppEvents.logPageView();  

          
        };

      (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));


      function login(){

        FB.login(function(response){        
          //console.log("entrou aqui");
          if(response.status === "connected"){
            document.getElementById("status").innerHTML="Okay you are connected";
            info();
          }else if(response.status==="not_authorized"){
            document.getElementById("status").innerHTML="You are not connected.";
          }else{
            document.getElementById("status").innerHTML="You are not logged in facebook account.";
          }
        });
      }

      function info(){
         
         FB.api('/me','GET',{fields: 'name, email, id'}, function(response){
            
              id = response.id;             
              
              $.ajax({
                url: 'facebook.php?facebook_operation=1&response_id='+id,
                type: 'GET',                  
                success:function(data){
                  //sucesso
                }
              });
         });
      }
       
})


</script>
<?php  

      }
    }
?>