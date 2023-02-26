<?php
require_once('connect/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User registration | PHP</title>
    <link rel="stylesheet" type="text/css" href="library/bootstrap-5/css/bootstrap.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
</head>
<script type="text/javascript">
    function alert_registration_success() {
        Swal.fire({
            'title' : 'Úspěch',
            'text' : 'Registrace proběhla úspěšně',
            'icon' : 'success'
        });   
    }
    function alert_registration_fail() {
        Swal.fire({
            'title' : 'Něco se nepovedlo',
            'text' : 'Registace selhala',
            'icon' : 'error'
        });    
    }
</script>
<body>  
    <div>
        
        <?php
        if(isset($_POST['create'])){ 
            $firstname =    $_POST['firstname'];
            $lastname =     $_POST['lastname'];
            $email =        $_POST['email'];
            $password =     $_POST['password'];
            $sql = "INSERT INTO `user` (first_name, last_name, email, password) 
            VALUES(?,?,?,?)";
            $stmtinsert = $db->prepare($sql); 
            $result = $stmtinsert->execute([$firstname, $lastname, $email, $password]);
                if($result) { 
                    header("refresh:2;url=login.php");
                    echo '<script type="text/javascript">',
                    'alert_registration_success();',
                    '</script>';
                }else {
                    header("refresh:2;url=login.php");
                    echo '<script type="text/javascript">',
                    'alert_registration_fail();',
                    '</script>';
                }
            }
        ?>
    </div>
    <div class="container">
        <form action="registration.php" method="post" class="row">  
            <div class="col-xs-1 text-center mt-2">   
                <h1>Registrace</h1>
                <p>Pro založení nového účtu vyplňte veškeré údaje</p>
                <br>
            </div>  
            <div class="row justify-content-md-center gap-2">
                <div class="col col-lg-5 text-start">
                    <div class="input-group mb">
                        <div class="col me-2">
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
                        <a href="login.php" class="btn btn-outline-secondary btn-lg text-right" role="button">Přihlásit se</a>
                    </div>  
                </div>
            </div>     
        </form>
    </div>
</body>
</html>