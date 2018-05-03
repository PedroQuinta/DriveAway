<?php
    session_start();
    $var ="#";
    //Verifies if the user of the session was set
    if(isset($_SESSION['nome'])) {
        echo "<p style='color:white;'>Bem vindo, <span id='perfil_modal' data-toggle='modal' style='font-weight:bold; text-decoration:underline;'>".$_SESSION['nome']."</span>&nbsp;&nbsp;<a href='logout.php' style='color:white;'><span class='glyphicon glyphicon-log-out' style='color:white;'>Logout</a></span></p>";               
    } else {
        echo '
            <p style="color:white;"><span class="glyphicon glyphicon-log-in"><a href="login.php">Login
            </a></span></p>
          ';
    }                            
?>        