<?php
require_once "session/session.php";
require_once "navbar.php";

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
<body>
    <div class="container">    
        <div class="row justify-content-md-center"> 
            <div class="col col-lg-5 text-start">
                <form action="report.php" method="post" class="row g-1">   
                    <h1>Měření</h1>
                    <p>Zadejte naměřené údaje z vaší stanice</p>
                    <br>

                    <label for="datetime">Datum a Čas</label>
                    <input class="form-control" type="datetime-local" id="datetime" name="date" required>

                    <label class="form-label" for="temperature">Teplota</label>
                    <div class="input-group mb-3">
                    <input min="-100" max="100" type="number" id="typeNumber" class="form-control" name="temperature" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">°C</span>
                        </div>
                    </div>

                    <label class="form-label" for="humidity">Relativní Vlhkost</label>
                    <div class="input-group mb-3">
                        <input min="0" max="100" type="number" step="0.01" id="typeNumber" class="form-control" name="humidity" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    <label for="pressure">Tlak</label>
                    <div class="input-group mb-3">
                    <input min="700" max="1400" type="number" id="typeNumber" class="form-control" name="pressure" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">mb</span>
                        </div>
                    </div>

                    <label for="wind_speed">Rychlost Větru</label>
                    <div class="input-group mb-3">
                    <input min="0" max="300" type="number" id="typeNumber" class="form-control"  name="wind_speed" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">km/h</span>
                        </div>
                    </div>

                    <label for="wind_speed">Typ Srážek</label>
                    <div class="input-group mb-3">
                        <select class="select" data-mdb-filter="true" name="precipitation_type" required>
                            <option value="rain">Déšť</option>
                            <option value="snow">Sníh</option>
                        </select>
                    </div>
                    
                    <label for="precipation">Srážky</label>	
                    <div class="input-group mb-3">
                    <input min="0" max="30000" type="number" id="typeNumber" class="form-control"  name="precipitation" required/>
                        <div class="input-group-append">
                            <span class="input-group-text">mm</span>
                        </div>
                    </div>

                    <br>
                    <div class="row justify-content-md-center text-center">
                        <div class="row text-center">
                            <input type="submit" class="btn btn-primary btn-lg text-center" id="new_station" name="new_station" value="Uložit">
                        </div>
                    </div>  
                </form>
            </div>
                          
            <div class="col col-lg-5">
                <form action="report.php" method="post">
                    <h1>Vyberte stanici</h1>                
                    <?php 
                        $user_id  = get_login_id();

                        $set_station_id = get_station_id();
                    
                        $locations_id = get_locations_id($user_id, $db);
                        print_r($locations_id);
           
                        //PLACEHOLDER> checks the first looped location#################################
                        //----> try coockie? or pull what location was last used for weather report 
                        if(count($locations_id) == 1) {
                            $loc_data = get_location_data($user_id, $loc_id, $db);
                            $disable = 'disabled';
                            $set_station = $loc_data['id'];
                            set_station($set_station);
                        }else{
                            $disable = '';
                            foreach($locations_id as $row) {
                                echo 'foreach loop row is '.$row;
                                $set_station_id = $_SESSION['set_station'];
                                $loc_data = get_location_data($user_id, $row, $db);

                                    //TODO-> radio remains checked after chosing location##################
                                    
                                    echo '<br>';
                                    echo '$$$$$$$$$$$$$$$$$$$$$$';
                                    echo '<br>';
                                    echo 'set station '.$set_station_id. 'is being tested against'. $row;
                                    echo '<br>';
                                    if($set_station_id == $row) {
                                    $check_switch = 'checked';
                                    echo 'check_switch on !!!!!!!!!!!!!!!!111';
                                    }else{
                                        $check_switch = '';
                                    }
                            echo '
                                <div class="mb-2">            
                                    <label class="form-check-label" for="flexRadioDefault">
                                        <input class="form-check-input" type="radio" name="station" value="'.
                                        $row.'" id="flexRadioDefault1" '.$check_switch. ' '. $disable .'>'. $loc_data['nickname'] .'
                                    </label>
                                </div>
                            ';
                            } 
                        echo '<button class="btn btn-outline-primary btn-sm text-center m-3" role="button" type="submit" name="submit" vlaue="Vybrat">Vybrat</button>';
                    }
                    ?>
                    
                </form>

                <?php
                if(isset($_POST['station'])) { 
                    $post_id = $_POST['station'];
                    echo 'vybrali jste stanici s id' . $post_id;
                    set_station($post_id);
                    $station_set_test = get_station_id();
                    echo'     by melo byt stejne jako '. $station_set_test;
                    echo '<br>';
                }

                if(isset($_SESSION['set_station']) && $_SESSION['set_station'] != '') {
                    $temp_id = get_station_id();
                    $temp = get_location_data($user_id, $temp_id, $db);
                    echo $temp['nickname'] . ' je aktivní stanicí.';
                    echo '<br>';
                }else{
                    echo 'Vyberte stanici';
                }     
                ?>
            </div>
        </div>  
    </div>     
</div>
<script type="text/javascript">
    function submit_swal() {
        Swal.fire({
            'title' : 'Úspěch',
            'text' : 'data byla úspěšně uložena',
            'icon' : 'success'
        });   
    }
</script>
        <?php
            $selected_station = get_station_id();
            echo 'selected station is ' . $selected_station;
            if (isset($_POST['new_station']) && $selected_station != '' ) {
            // submit_swal();
            $date = str_replace('T', ' ',$_POST['date']);
            $temperature = $_POST['temperature'];
            $humidity = $_POST['humidity'];
            $pressure = $_POST['pressure'];
            $wind_speed = $_POST['wind_speed'];
            $precipitation = $_POST['precipitation'];
            $precipitation_type = $_POST['precipitation_type'];
            //#############################################################################################
            print_user_info();
            print_location_info();
            $selected_location = get_location(); 
            $user_id = get_login_id();
            $input_values = 
            [$date,$temperature,$humidity,$pressure,$wind_speed,$precipitation,$precipitation_type,$selected_station,
            $selected_location['town_id'],$selected_location['district_id'],$selected_location['region_id'], $user_id];
            print_r($input_values);

            // (date, temperature, relative_humidity, pressure_mb, wind_speed_km/h, precipitation_mm, precipitation_type, user_id)

            $sql = "INSERT INTO `weather` 
            (`date`, `temperature`, `relative_humidity`, `pressure_mb`, `wind_speed_km/h`, `precipitation_mm`, `precipitation_type`,
             `location_id`, `location_town_id`, `location_town_district_id`, `location_town_district_region_id`, `location_user_id`) 
            VALUES(?,?,?,?,?,?,?,?,?,?,?,?)";
            $stmtinsert = $db->prepare($sql);
            $result = $stmtinsert->execute($input_values);
            if($result) { 
                echo 'Successfully saved';
            }else {
                echo "error while saving data";
            }
        }   
    ?>
</body>
</html>

