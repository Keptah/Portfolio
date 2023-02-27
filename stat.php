<?php
    require_once "session/session.php";
    if(!is_logged_in()) {
        header('location:index.php');
    }
    require_once "navbar.php";
    $selected_data_type = '';
    $public_checked_switch = '';
    $private_label_style = '';
    $private_disabled_switch = '';
    if(count(get_locations_id($_SESSION['user_id'], $db)) < 1) {
        $private_disabled_switch = 'disabled';
        $private_label_style = 'text-muted';
        $public_checked_switch = 'checked';   
    }
    if(get_user_report_count($user_id, $db) < 1) {
        $private_disabled_switch = 'disabled';
        $private_label_style = 'text-muted';
        $public_checked_switch = 'checked';   
    }   
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<title>Statistika</title>
</head>
<body>
  <h1>Statistika</h1>
  <?php echo'<span>'.$selected_data_type.'</span>'; ?>
  <div id="chart" calss=""></div>
    <div class="container">    
        <form action="stat.php" method="post" class="row"> 
            <div class="row justify-content-md-center">  
                <div class="col col-lg-5 text-center"> 
                    <h1>Filtry</h1>
                    <label class="form-check-label me-5" for="radio_filter">
                    </label>
                    <?php
                        if($private_disabled_switch == 'disabled') {  
                            echo '<br> <p class="text-warning">Zatím nemáte žádné záznamy</p>';    
                            $diabled_style_injection = 'class="text-black-50" style="--bs-text-opacity: .5;';
                        }else{
                            $diabled_style_injection = '';
                        }
                        echo '
                        <div class="button-toolbar">
                        <input class="form-check-input me-3 mb-2" type="radio" name="radio_filter"
                        value="public" id="flexRadioDefault" '.$public_checked_switch.'><span class="me-3">Sdílená</span>';

                        echo '
                        <input class="form-check-input ms-3 me-3 mb-2" type="radio" name="radio_filter" 
                        value="private" id="flexRadioDefault" required '.$private_disabled_switch.'>
                        <span '.$diabled_style_injection.'">Osobní</span>       
                        </div>';
                        ?>        
                    <script type="text/javascript">
                    document.getElementById('unit_dropdown').value = "<?php echo $_POST['unit_dropdown'];?>";
                    </script>
                    <select class="form-select mt-2" name="unit_dropdown" id="unit_dropdown">
                        <option value="" >Vybrat veličinu</option>
                        <option value="temperature">Teplota</option>
                        <option value="relative_humidity">Vlhkost</option>
                        <option value="wind_speed_km/h">Rychlost Větru</option>
                        <option value="precipitation_mm">Srážky</option>
                        <option value="pressure_mb">Tlak</option>
                    </select>
                    <!-- ***Keep slected unit after submiting filters so that it is clear what does the graph represents************************* -->
                    <script type="text/javascript">
                        document.getElementById('unit_dropdown').value = "<?php echo $_POST['unit_dropdown'];?>";
                    </script>
                    <div class="row content-center text-center">
                        <input type="submit" class="btn btn-primary btn-md text-center mt-3" name="filter" value="Použít">
                    </div>
                </div>
            </div>
        </form>
        <div class="text-center">
            <?php 
                $data_value_array  =[];//***Declaring arrays to hold values for graph***
                $datetime_array  =[];
                $data_select = '';
                if(isset($_POST['filter'])  && $_POST['unit_dropdown'] != '') {
                    $data_select =                  $_POST['unit_dropdown'];
                    $radio_filter =                 $_POST['radio_filter'];
                    $_SESSION['unit_select'] =      $_POST['unit_dropdown'];
                    $_SESSION['db_type_radio'] =    $_POST['radio_filter'];
                    $selected_data_type = $data_select;
                    $sql_addon = '';
                    if($radio_filter == 'private') { 
                        $id = get_login_id();
                        $sql_addon = 'WHERE location_user_id = '.$id.' ORDER BY `date` ASC';
                    }else {
                        $sql_addon = '';
                    }
                    $sql = 'SELECT * FROM weather '.$sql_addon;
                    $result = $db->query($sql);  
                    if($result) {         
                        foreach($result as $row) {
                            array_push($data_value_array, $row[$data_select]);
                            array_push($datetime_array, $row['date']);
                            echo '<hr>';
                            echo $row[$data_select];
                            echo '<br>';
                            echo $row['date'];
                        }  
                    }else{
                    }
                }
            ?>         
            <script>
                <?php
                //***Converting php array to js so it can be used as input for apexchart*************************************************************
                $js_array1 = json_encode($data_value_array);
                echo "var javascript_array1 = ". $js_array1 . ";\n";
                $js_array2 = json_encode($datetime_array);
                echo "var javascript_array2 = ". $js_array2 . ";\n";
                ?>

                var options = {
                    chart: {
                        type: 'line',
                        width: '95%',
                        height: '50%'
                    },
                    series: [{
                        name: 'y',
                        data: javascript_array1
                    }],
                    xaxis: {
                        categories: javascript_array2
                    }
                }
                var chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            </script>
        </div>
    </div>  
 </body>
</html>
