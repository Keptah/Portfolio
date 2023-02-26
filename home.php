<?php
    require_once "session/session.php";
    require_once "navbar.php";
    if(!is_logged_in()) {
        logout();
        header('location:index.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Domů</title>
</head>
<body>
    <div class="container">    
        <div class="row justify-content"> 
            <div class="col col-lg-8 text-start"> 
                <div class="mb-">
                    <h1>Úvod</h1>
                    <span >
                       Tato aplikace umožňuje amatérským meteorologům zadávat naměřené hodnoty 
                        ze svých stanic do sdílené databáze. Data jsou následně zpracována a zpřístupněna věřejnosti v sekci 
                    </span>
                    <a href="stat.php">Statistika</a><span>.</span>
                </div>
                <div class="">
                    <div class="mb-3">
                        <h2>Přidávání naměřených údajů ze stanic</h1>
                        <span>Nově zaregistrovanému uživateli je umožněn přístup pouze k souhrné statictice.
                        Pokud  máte zájem o přispívání daty naměřených vaší stanicí je nutné být ověřen. 
                        </span>
                    </div>
                    <div class="mb-3">
                        <h4 >Ověření účtu</h3>
                        <span>Pro ověření účtu je poslat žádost na</span>
                        <br>
                        <sapn>Email: hynek.navreatil.hn@gmail.com</span>
                        <br>
                    </div>
                    <div class="mb-3">
                        <h4>Přidávání statnic</h3>
                        <sapn>Po úspěšném ověření účtu je vám umožněno </span><a href="location.php">Přidat stanici</a>
                        </div>
                        <div class="mb-3">
                            <h4>Zadávání naměřených údajů</h3>
                            <span>S přidáním alespoň jedné stanice můžete v sekci </span> <a href="report.php">Záznam</a> zadávat naměřené údaje.
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col col-lg-4 col-md-4 col-sm-8 col-8 mt-4 text-start">  
                   <?php
                        $infobox_data = get_user_infobox_data($user_id, $db);   
                        //***Defining styles for chceck/tic and x icon*******************************************************************************
                        $check_mark_style =     'bi-check-lg text-success" style="font-size: 32px;"';
                        $x_mark_style =         'bi-x-lg text-danger" style="font-size: 28px;"';                     
                        if($infobox_data['validated']) { 
                            $valid_check = $check_mark_style;
                        }else{
                            $valid_check = $x_mark_style;
                        }
                        if($infobox_data['got_station']) { 
                            $station_check = $check_mark_style;
                        }else{
                            $station_check = $x_mark_style;
                        }
                    ?>
                    <h2 class="mt-1">Informace o uživateli</h2>
                    <?php   
                    echo '<i class="'.$valid_check.'"></i>Ověřen</span><br>
                        <i class="'.$station_check.'"></i>Stanice</span>
                        <p class="mt-2">Přihlášen '.$infobox_data['fname'].' '.$infobox_data['lname'].'</p>';  
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>