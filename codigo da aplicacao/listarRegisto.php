<?php 
                        include 'config.php';

                        $sql = "SELECT userpic, nome FROM pessoa ORDER BY nome ASC";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                        if($stmt->rowCount()>0){
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                extract($row);

                                echo "<div class='col-xs-3'>
                                    <p class='page-header'>".$row['nome']."</p> 
                                    <img src='user_images/".$row['userpic']."' class='img-rounded' width='180px' height='180px'>
                                    <p class='page-header'>
                                    <span>
                                    <a class='btn btn-info' href='#' title='clicar para editar'
                                    onclick='return confirm('"."De certeza que quer editar?')'>
                                    <span class='glyphicon glyphicon-edit'></span>Editar</a>
                                     <a class='btn btn-danger' href='#' title='clicar para eliminar'
                                    onclick='return confirm('"."De certeza que quer eliminar?')'>
                                    <span class='glyphicon glyphicon-remove-circle'></span>Eliminar</a>
                                    </span>
                                    </p>
                                    </div>";
                            }
                        }
                    ?>