<?php
    require_once "session/session.php";
    require_once "navbar.php";

    if(!is_logged_in()) {
        logout();
        header('location:index.php');
    }
    $user_id = get_login_id();
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
                        sweater.weather.cz je stránka umožnující amatérským meteorologům zadávat naměřené hodnoty 
                        ze svých stanic do sdílené databáze. Data jsou následně zpracována a zpřístupněna věřejnosti v sekci 
                    </span>
                    <a href="stat.php">Statistika</a><span>.</span>
                </div>
                <div class="ms-3">
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
                        <sapn>Email: email.placeholder@email.com</span>
                        <br>
                        <span>nebo</span>
                        <br>
                        <span>Telofon: +420 123 456 789</span>
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
                <div class="col col-lg-4 mt-4text-start">  
                    <?php
                        $infobox_data = get_user_infobox_data($user_id, $db);                 
                        if($infobox_data['validated']) { 
                            $valid_check = 'bi-check-lg text-success" style="font-size: 32px;"';
                        }else{
                            $valid_check = 'bi-x-lg text-danger" style="font-size: 28px;"';
                        }
                        if($infobox_data['got_station']) { 
                            $station_check = 'bi-check-lg text-success" style="font-size: 32px;"';
                        }else{
                            $station_check = 'bi-x-lg text-danger" style="font-size: 28px;"';
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
            <div class="text-center fixed-bottom">
                <span>Vytvořil Hynek Navrátil</span>
                <br/>
            </div>
        </div>
    </div>
</body>
</html>