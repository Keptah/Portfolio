<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User registration | PHP</title>
    <link rel="stylesheet" type="text/css" href="library/bootstrap-5/css/bootstrap.min.css">
</head>
    <div class="container">
        <form action="registration.php" method="post" class="row g-3">  
            <div class="row justify-content-md-center">
                <div class="col-xs-1 text-center mt-4"> 
                    <h1>Vítejte</h1>
                    <br>
                </div>  
            </div>
            <div class="row justify-content-md-center">
                <div class="col col-lg-5 text-start">
                    <div class="row justify-content-md-center">
                        <a href="registration.php" class="btn btn-outline-primary btn-lg text-right" role="button">Zaregistrovat se</a>       
                        <p class="m-3">Máte již založený účet?</p>
                        <a href="login.php" class="btn btn-outline-secondary btn-lg text-right" role="button">Přihlásit se</a>
                    </div>  
                </div>
            </div>     
        </form>
    </div>
</body>
</html>