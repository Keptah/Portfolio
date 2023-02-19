<?php
require_once('con/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User registration | PHP</title>
    <link rel="stylesheet" type="text/css" href="library/bootstrap-5/css/bootstrap.min.css">
</head>
<body class="background-color: $indigo-200">  

<div class="bg-indigo .bg-lighten-xl">
    <div class="container">
            <form action="registration.php" method="post" class="row g-3">  
                <div class="col-xs-1 text-center">
                <br>    
                <h1>Vítejte</h1>
                <br>
                </div>  
                
                <div class="row justify-content-md-center">
                    <div class="col-md-auto">
                        <!-- 1 of 3 -->
                    </div>
                    <div class="col col-lg-5 text-center">
                        <div class="input-group mb">
                      
                        <hr class="mb-1">
                       
                        <div class="row justify-content-md-center">
                        <a href="registration.php" class="btn btn-outline-primary btn-lg text-right" role="button">Zaregistrovat se</a>
                            <hr>
                            <p>Máte již založený účet?</p>
                            <a href="login.php" class="btn btn-outline-secondary btn-lg text-right" role="button">Přihlásit se</a>
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