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

        echo $firstname . "shitttttttttttt " . $lastname . " " . $email . " " . $password;
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
                                <input class="form-control" type="text" name="firstname" required>
                            </div>  

                            <div class="col">
                                <label for="lastname">Příjmení</label>
                                <input class="form-control " type="text" name="lastname" required>
                            </div>
                        </div>

                        <label for="email">E-mail</label>
                        <input class="form-control" type="email" name="eamil" required>

                        <label for="password">Heslo</label>
                        <input class="form-control input-sm" type="password" name="password" required>
                        <br>

                        <div class="row justify-content-md-center">
                            <input type="submit" class="btn btn-primary btn-lg text-right" name="create" value="Vytvořit">
                        </div>  
                        <hr class="mb-1">
                        <p>Máte již založený účet?</p>
                        <div class="row justify-content-md-center">
                            <input type="submit" class="btn btn-outline-secondary btn-lg text-right" name="create" value="Přejít na přihlášení">
                        </div>  
                    </div>
                    <div class="col-md-auto">
                    <!--  -->
                </div> 
            </div>     
        </form>
    </div>
</div>
</body>
</html>