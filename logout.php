<?php
require_once "session/session.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="library/bootstrap-5/css/bootstrap.min.css">
    <title>Odhlášení</title>
</head>
<body>
    <h1>Odhlášení</h1>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        Swal.fire({
            'title' : 'Odhlášen',
            'text' : 'účet byl úspěšně odhlášen',
            'icon' : 'success'
        });     
    </script> 
    <?php 
        logout();
    ?>

    <script>
        function redirect() {	
            location.href = "index.php";
        }
        setTimeout(redirect, 1500);
    </script>
   
</body>
</html>