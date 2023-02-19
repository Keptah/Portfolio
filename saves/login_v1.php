<?php
require_once "session/session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Přihlášení</title>
    <link rel="stylesheet" type="text/css" href="library/bootstrap-5/css/bootstrap.min.css">
</head>
<body>
    <div>
        <div class="container">
            <div class="col-xs-1 text-center">
                <h1>Přihlášení</h1>
                <br>
            </div>
            <form action="login.php" method="post" class="row">
                <div class="row justify-content-md-center">
                    <div class="col col-lg-5 text-start">
                        <label for="email">E-mail</label>
                        <input class="form-control" type="email" name="email" required>

                        <label for="password">Heslo</label>
                        <input class="form-control" type="password" name="password" required>
                        <br>

                        <div class="row justify-content-md-center">
                            <input type="submit" class="btn btn-primary btn-lg text-right" name="login" value="Přihlásit se">
                        </div>  
                        <hr class="mb-2">
                        <p>Nemáte založený učet?</p>
                        <div class="row justify-content-md-center">
                            <a href="registration.php" role="button" class="btn btn-outline-secondary btn-lg text-right" name="registration_redirect" value="">Přejít na registraci</a>
                        </div>  
                    </div>
                </div>     
            </form>
        </div>
    </div>
    <?php
    if (isset($_POST['login'])) {
        $email =    $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM user WHERE `email` = ? AND `password` = ?";
        $stmtinsert = $db->prepare($sql); 
        $stmtinsert->execute([$email, $password]);
        
        $row =      $stmtinsert->rowCount();
        $fetch =    $stmtinsert->fetch();

        
        if($row > 0) {
            login($email);    
            $_SESSION['user_id'] = $fetch['id'];     
            $_SESSION['user_first_name'] = $fetch['first_name'];
            $_SESSION['user_last_name'] = $fetch['last_name'];
            $_SESSION['user_validated'] = $fetch['validated'];
            header("location: home.php");
        } else{
            echo 
            "<script>alert('Invalid username or password')</script>
            <script>window.location = 'index.php'</script>";
            }
        }
    ?>
</body>
</html>