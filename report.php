<?php
require_once "session/session.php";
require_once "navbar.php";
if(!is_logged_in()) {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="library/bootstrap-5/css/bootstrap.min.css">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
    <title>Document</title>
</head>
<script type="text/javascript">
    //***Defining sweet alert2 alerts**************************************************************************************************************** 
    function alert_submit_success() {
        Swal.fire({
            'title' : 'Úspěch',
            'text' : 'záznam byl úspěšně uložen',
            'icon' : 'success'
        });   
    }
    function alert_submit_fail() {
        Swal.fire({
            'title' : 'Něco se nepovedlo',
            'text' : 'záznam se nepodařilo uložit na úrovni databáze',
            'icon' : 'error'
        });    
    }
    function alert_invalid_prec_combination() {
        Swal.fire({
            'title' : 'Nesprávná kombinace srážek',
            'text' : 'pro žádné srážky zvolte "Nic", pro zadání množství srážek zvolte typ',
            'icon' : 'error'
        });
    }
    function home_redirect() {	
    location.href = "home.php";
    }
</script>
<?php 
    //***Give non-validated user peek of page, alet necessity of validation and rdirect back to home.php*******************************************************
    // $user_info = get_user_infobox_data($user_id, $db);
    // if($user_info['validated'] != 1) { 
    //     echo '<script type="text/javascript">',
    //         'setTimeout(home_redirect, 1500);',
    //         'alert_user_invalid();',
    //         '</script>';
    // }
    date_default_timezone_set('Europe/Prague');
    $current_datetime = date('Y-m-d h:i'); 
?>
<body>
    <div class="container">    
        <div class="row justify-content-md-center"> 
            <form action="report.php" method="post" class="row">   
                <div class="col col-lg-6 text-start">
                    <div>
                        <h1>Měření</h1>
                        <p>Zadejte naměřené údaje z vaší stanice</p>
                        <br>
                    </div>

                    <label for="datetime">Čas*</label>
                    <?php 
                    echo '<input class="form-control" type="datetime-local" id="datetime" name="date" 
                    value="'.$current_datetime.'" max="'.$current_datetime.'" required>';
                    ?>
                    <label class="form-label" for="temperature">Teplota*</label>
                    <div class="input-group mb-3">
                    <input min="-100" max="100" type="number" id="typeNumber" class="form-control" name="temperature" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">°C</span>
                        </div>
                    </div>

                    <label class="form-label" for="humidity">Relativní vlhkost*</label>
                    <div class="input-group mb-3">
                        <input min="0" max="100" type="number" step="0.01" id="typeNumber" class="form-control" name="humidity" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    <label for="pressure">Tlak*</label>
                    <div class="input-group mb-3">
                    <input min="700" max="1400" type="number" id="typeNumber" class="form-control" name="pressure" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">mb</span>
                        </div>
                    </div>

                    <label for="wind_speed">Rychlost větru*</label>
                    <div class="input-group mb-3">
                    <input min="0" max="300" type="number" id="typeNumber" class="form-control"  name="wind_speed" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">km/h</span>
                        </div>
                    </div>

                    <label for="prec_type">Typ srážek*</label>
                    <div class="container mb-3">
                        <div class="input-group">
                            <div class="col col-sm-4 text-start">
                                <input class="form-check-input" type="radio" name="prec_type"
                                value="nothing" id="flexRadioDefault" checked><span class=" me-3 ms-3">Nic</span>
                            </div>  
                            <div class="col col-sm-4 text-start">
                                <input class="form-check-input" type="radio" name="prec_type"
                                value="rain" id="flexRadioDefault"><span class=" me-3 ms-3">Déšť</span>
                            </div>   
                            <div class="col col-sm-4 text-start">
                                <input class="form-check-input" type="radio" name="prec_type"
                                value="snow" id="flexRadioDefault"><span class=" me-3 ms-3">Sníh</span>           
                            </div>
                        </div>
                    </div>
                    
                    <label for="precipation">Srážky*</label>	
                    <div class="input-group mb-3">
                    <input min="0" max="30000" type="number" id="typeNumber" class="form-control"  name="precipitation" value="0" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">mm</span>
                        </div>
                    </div>
                    <br>
                </div>
                <div class="col col-sm-1">
                </div>
                <div class="col col-lg-4">
                    <div>
                        <h1>Vyberte stanici</h1> 
                        <p>Zaklikněte stanici použitou při měření*</p>       
                    </div>        
                    <?php 
                        $user_id  = get_login_id();
                        $locations_id = get_locations_id($user_id, $db);
                        $check_switch = '';//***By deafult uncheck loc radios***
                        //***For user with only one location check radio button automaticly and diable it********************************************
                        if(count($locations_id) == 1) {
                            $loc_data = get_location_data($user_id, $locations_id[0], $db);
                            $check_switch = 'checked';
                            echo '<span class="text-success">
                            Vaše jediná stanice: '.$loc_data['nickname'].' byla automaticky vybrána</span>';
                        //***User with more stations gets to choose what station does the report refer to********************************************
                        }else{
                            $check_switch = '';
                        }
                            //***Run through all stations of user and create radio for each one of them**********************************************
                            foreach($locations_id as $row) {
                                $loc_data = get_location_data($user_id, $row, $db);              
                                echo '
                                    <div class="mb-2">            
                                        <label class="form-check-label" for="flexRadioDefault">
                                            <input class="form-check-input me-3 mb-2" type="radio" name="location_id" value="'.
                                            $row.'" id="flexRadioDefault" '.$check_switch. ' required>'. $loc_data['nickname'].'
                                        </label>
                                    </div>
                                ';
                            } 
                        if(empty(get_locations_id($user_id, $db))) {
                            echo '<span class="text-danger">Pro vyplňování záznamů je nutno přidat stanici</span>';
                            $report_dasable = 'disabled';
                        }else{
                            $report_dasable = '';
                        }
                    ?>   
                </div>
                <div class="row content-center text-center">
                    <div class="row text-center">
                        <?php
                            echo '<input type="submit" class="btn btn-primary btn-lg text-center" name="report" value="Uložit" '.$report_dasable.' >';
                        ?>
                    </div>
                </div> 
            </form> 
        </div>     
    </div>
    <?php
        
    if (isset($_POST['report'])) {
        if($_POST['prec_type'] == 'nothing' && $_POST['precipitation'] != 0 ||
        $_POST['prec_type'] == 'rain' &&  $_POST['precipitation'] < 1 || 
        $_POST['prec_type'] == 'snow' &&  $_POST['precipitation'] < 1) {
            echo '<script type="text/javascript">',
            'alert_invalid_prec_combination();',
            '</script>';
        }else{
            $date = str_replace('T', ' ',$_POST['date']);//***Changing datetime input to mysql format***
            $temperature =          $_POST['temperature'];
            $humidity =             $_POST['humidity'];
            $pressure =             $_POST['pressure'];
            $wind_speed =           $_POST['wind_speed'];
            $precipitation =        $_POST['precipitation'];
            $precipitation_type =   $_POST['prec_type'];
            $location_id =          $_POST['location_id'];
            $user_id =              get_login_id();
            $selected_location =    get_location_data($user_id, $location_id, $db);
            $insert_values = 
                            [$date,$temperature,$humidity,$pressure,$wind_speed,$precipitation,$precipitation_type,
                            $location_id, $selected_location['town_id'],$selected_location['district_id'],$selected_location['region_id'], $user_id];
            // print_r($insert_values);
            $sql = "INSERT INTO `weather` 
            (`date`, `temperature`, `relative_humidity`, `pressure_mb`, `wind_speed_km/h`, `precipitation_mm`, `precipitation_type`,
                `location_id`, `location_town_id`, `location_town_district_id`, `location_town_district_region_id`, `location_user_id`) 
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmtinsert = $db->prepare($sql);
            $result = $stmtinsert->execute($insert_values);
            if($result) { 
                echo '<script type="text/javascript">',
                    'alert_submit_success();',
                    '</script>';
            }else {
                echo '<script type="text/javascript">',
                    'alert_submit_fail();',
                    '</script>';
            }
        }   
    }
    ?>
</body>
</html>
