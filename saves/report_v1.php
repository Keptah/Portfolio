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
                <form action="" method="post">
                    <h1>Vyberte stanici</h1>                
                    <?php 
                        $user_id  = get_login_id();

                        $test  = get_locations_id($user_id, $db);
                        print_r($test[0]);
                        $loc_id = $test[0];
                        echo '</br>';
                        $test2  = get_location_data($user_id, $loc_id, $db);
                        print_r($test2);

                        $sql = "SELECT * FROM `location` WHERE user_id  = $user_id";
                        //terrible workaround ik. using fetch with actual $result that is used in foreach loop for
                        //drawing the radio buttons results in no radio buttons being displayed at all??<
                        $result_temp  =$db->query($sql);
                        $fetch =    $result_temp->fetch();



                        // $result = get_locations($id, $db);
                        // echo $result['nickname'];

                        
                        $result = $db->query($sql);
                        $row_count =      $result->rowCount();            
                        //PLACEHOLDER> checks the first looped location 
                        //----> try coockie? or pull what location was last used for weather report 
                        if($row_count < 2) {
                            $disable = 'disabled';
                            $set_station = $fetch['id'];
                            set_station($set_station);
                        }else{
                            $disable = '';
                        }
                        
                        foreach($result as $key => $row) {
                            if($key === array_key_first([$result])) {
                                $temp = 'checked';
                            }else{
                                $temp = '';
                            }
                        echo '
                            <div class="m-1">            
                                <label class="form-check-label" for="flexRadioDefault">
                                    <input class="form-check-input" type="radio" name="station" value="'.
                                    $row['id'] .'" id="flexRadioDefault1" '.$temp. ' '. $disable .'>'. $row['nickname'] .'
                                </label>
                            </div>
                        ';
                        } 
                    ?>
                    <button class="btn btn-outline-primary btn-sm text-center m-3" role="button" type="submit" name="submit" vlaue="Vybrat">Vybrat</button>
                </form>

                <?php
                if(isset($_POST['station'])) { 
                    $set_station = $_POST['station'];
                    set_station($set_station);
                }

                if(isset($set_station)) { 
                    echo $set_station . ' je aktivní stanicí.';
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

