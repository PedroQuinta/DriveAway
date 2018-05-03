<?php  
    session_start();
    // code with the menu that's supposed to be common to each user
    // it is loaded dynamically 
	echo '

	    <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:white;">
                <span class="caret"></span>
                <i class="glyphicon glyphicon-home"></i>
                Home
            </a>
            <ul class="dropdown-menu">
                <li>
                    <a href="#" data-url="pag_comuns/home.php">
                        <i class="glyphicon glyphicon-home"></i>
                        Homepage
                    </a>           
                </li>
                <li>
                    <a href="#" data-url="pag_comuns/QuemSomos.php">
                        <i class="glyphicon glyphicon-list-alt"></i>
                        Quem Somos
                    </a>           
                </li>
                <li>
                    <a href="#" data-url="pag_comuns/horario.php">
                        <i class="glyphicon glyphicon-calendar"></i>
                        Contactos
                    </a>           
                </li>
                <li>
                    <a href="#" data-url="pag_comuns/precos.php">
                        <i class="glyphicon glyphicon-euro"></i>
                        Preçário
                    </a>           
                </li>
                <li>
                    <a href="#" data-url="pag_comuns/faq.php">
                        <i class="glyphicon glyphicon-pencil"></i>
                        FAQs
                    </a>           
                </li>
            </ul>           
        </li>
        
        ';
        // here we verify which type of user logged him and load the menu accordingly
        if (isset($_SESSION['idpessoa'])) {
            if ($_SESSION['tipo']=="aluno") {
                echo '                        
                            <li>
                                <a href="#" data-url="calendario/calendario.php">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                    Calendário
                                </a>           
                            </li>';
                echo    '<li>
                                <a href="#" data-url="gestaoDuvidas.php">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                    Dúvidas
                                </a>           
                            </li>
                            ';
            }else{
                if( $_SESSION["secretaria"]==true){
                    //remember we used data-url to make use of transitions between pages and not href links
                    echo '                        
                            <li>
                                <a href="#" data-url="gestaoAluno.php" style="color:white;">
                                    <i class="glyphicon glyphicon-user"></i>
                                    Alunos
                                </a>           
                            </li>
                            <li>
                                <a href="#" data-url="gestaoFunc.php" style="color:white;">
                                    <i class="glyphicon glyphicon-briefcase"></i>
                                    Funcionários
                                </a>           
                            </li>
                            <li>
                                <a href="#" data-url="gestaoAula.php" style="color:white;">
                                    <i class="glyphicon glyphicon-education"></i>
                                    Aulas
                                </a>           
                            </li>
                            <li>
                                <a href="#" data-url="gestaoVeiculo.php" style="color:white;">
                                    <i class="glyphicon glyphicon-road"></i>
                                    Veículos
                                </a>           
                            </li>
                            <li>
                                <a href="#" data-url="gestaoPedidos.php" style="color:white;">
                                    <i class="glyphicon glyphicon-th-list"></i>
                                    Pedidos
                                </a>           
                            </li>                        
                       '; 
                }
                if($_SESSION['instrutorTeorica']==true || $_SESSION['instrutorPratica']==true){
                    if($_SESSION['secretaria']== false){
                    echo '                        
                            <li>
                                <a href="#" data-url="calendario/calendario.php">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                    Calendário
                                </a>           
                            </li>';

                    echo    '<li>
                                <a href="#" data-url="gestaoDuvidas.php">
                                    <i class="glyphicon glyphicon-question-sign"></i>
                                    Dúvidas
                                </a>           
                            </li>
                            ';
                    }
                    
                }
                
            }
        }
                      


?>