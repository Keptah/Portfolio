<?php
require_once('config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User registration | PHP</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body class="background-color: $indigo-200">  
<div>
    <?php
    if(isset($_POST['create'])){
        $firstname =    $_POST['firstname'];
        $lastname =     $_POST['lastname'];
        $email =        $_POST['email'];
        $password =     $_POST['password'];

        $sql = "INSERT INTO user (first_name, last_name, email, password) 
        VALUES(?,?,?,?)";
        $stmtinsert = $db->prepare($sql); 
        $result = $stmtinsert->execute([$firstname, $lastname, $email, $password]);
            if($result) { 
                echo 'Successfully saved';
            }else {
                echo "error while saving data";
            }
        }
    
    ?>
</div>

<div class="bg-indigo .bg-lighten-xl">
    <div class="container">
            <form action="registration.php" method="post" class="row g-3">  
                <div class="col-xs-1 text-center">
                <br>    
                <h1>Registrace</h1>
                <p>Pro založení nového účtu vyplňte veškeré údaje</p>
                <br>
                </div>  
                
                <div class="row justify-content-md-center">
                    <div class="col-md-auto">
                        <!-- 1 of 3 -->
                    </div>
                    
                    <div class="col col-lg-5 text-start">
                        <div class="input-group mb">
                            <div class="col">
                                <label for="firstname">Jméno</label>
                                <input class="form-control" type="text" id="firstname" name="firstname" required>
                            </div>  

                            <div class="col">
                                <label for="lastname">Příjmení</label>
                                <input class="form-control " type="text" id="lastname" name="lastname" required>
                            </div>
                        </div>

                        <label for="email">E-mail</label>
                        <input class="form-control" type="email" id="email" name="email" required>

                        <label for="password">Heslo</label>
                        <input class="form-control input-sm" type="password" id="password" name="password" required>
                        <br>

                        <div class="row justify-content-md-center">
                            <input type="submit" class="btn btn-primary btn-lg text-right" id="register" name="create" value="Vytvořit">
                        </div>  
                        <hr class="mb-1">
                        <p>Máte již založený účet?</p>
                        <div class="row justify-content-md-center">
                            <!-- <input type="submit" class="btn btn-outline-secondary btn-lg text-right" name="log_redirect" value="Přejít na přihlášení" href="/login.php"> -->
                            <a href="login.php" class="btn btn-outline-secondary btn-lg text-right" role="button">Přihlásit se</a>

                        </div>  
                    </div>
                    <div class="col-md-auto">
                    <!-- 3 of 3 -->
                </div> 
            </div>     
        </form>
    </div>
</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script type="text/javascript">
    $(function(){
            $('#register').click(function(){
                   
                })
                Swal.fire({
                    'title' : 'Hello',
                    'text' : 'sweet alert is sweet',
                    'icon' : 'success'
            });         
        });
        
</script>
</body>
</html>