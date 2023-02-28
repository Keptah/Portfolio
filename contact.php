<?php
require_once 'session/session.php';
if(!is_logged_in()) {
    header('location:index.php');
}
require_once 'navbar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" type="text/css" href="library/bootstrap-5/css/bootstrap.min.css"> -->
    <title>Kontakt</title>
</head>
<body>
    <div class="container">    
        <div class="row justify-content-md-start"> 
            <h1>Kontatkt</h1>
                <div>
                    <span class="">Hynek Navrátil</span>
                    <br>
                    <span class="">Student Gymnázia Tišnov</span>
                </div>
                <div class="col col-2 col-sm-1 col-xs-8  text-start">
                    <a>Email:</a>
                </div>
                <div class="col col-sm-1 text-start">
                    <a>hynek.navratil.hn@gmail.com</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>