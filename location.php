<?php
require_once "session/session.php"; 
if(!is_logged_in()) {
    header('location:index.php');
}
require_once "navbar.php";
//***Pulling tables from databasse to be used as option values for dropdowns
$region_query = "SELECT region_name, id FROM region ORDER BY region_name ASC";
$region_result = $db->query($region_query);

$district_query = "SELECT district_name, id FROM district ORDER BY district_name ASC";
$district_result = $db->query($district_query);

$district_disabled = 'disabled';
$town_disabled = 'disabled';

define('BR','<br/>');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="library/bootstrap-5/css/bootstrap.min.css" rel="stylesheet" />
    <script src="library/bootstrap-5/js/bootstrap.bundle.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
    <title>location</title>
</head>
<script type="text/javascript">
    //***Defining sweetalert2 alerts**************************************************************************************************************** 
    function alert_new_location_success() {
        Swal.fire({
            'title' : 'Úspěch',
            'text' : 'nová stanice úspěšně vytvořena',
            'icon' : 'success'
        });   
    }
    function alert_new_location_fail() {
        Swal.fire({
            'title' : 'Něco se nepovedlo',
            'text' : 'stanici se nepodařilo vytvořit',
            'icon' : 'error'
        });    
    }

    let temp; 

    function redirect_location() {
        window.location.href = "location.php";
    } 

    function reload() {
        temp = setTimeout(redirect_location, 1300);
    }
</script>
<body>
    <div class="container">
        <div class="row justify-content-md-center">                 
            <div class="col col-lg-5 text-start">   
                <h1>Nová Stanice</h1>
                <p>Zadejte informace o vaší stanici</p>
                <div class="row justify-content-md-center">
                    <!-- ***Nickname input ****************************************************************************************************** -->
                    <form action = "<?php $_PHP_SELF ?>" method = "POST">
                        <div>
                            <label for="nickname" class="form-label">Jméno stanice*</label>
                            <?php
                            if(isset($_POST['nickname']) && $_POST['nickname'] != '') { 
                                $_SESSION['input_nickname'] = $_POST['nickname'];
                            }
                            $disable_create = '';
                            if(isset($_SESSION['input_nickname']) && $_SESSION['input_nickname'] != '') {
                                $stations_name = get_locations_names($user_id, $db);
                                foreach($stations_name as $key => $row) {
                                    if($row == $_SESSION['input_nickname']) {
                                        $disable_create = 'disabled';
                                        echo '<p class="text-warning">Toto jméno jste již použili</p>';
                                        break;
                                    }elseif ($key === array_key_last($stations_name) ) {
                                        echo '<p class="text-success">Toto jméno je volné</p>';
                                    }       
                                }
                            }else{
                                echo '<p class="text-success"></p>';
                            }
                            
                                ?>
                            <input class="form-control" value="<?php echo $_SESSION['input_nickname'] ??''; ?>" type="text" id="nickname" 
                            name="nickname" onchange="this.form.submit()" required>
                        </div>
                    </form>
                    <?php
                       
                    ?>  
                    <!-- ***Region input********************************************************************************************************* -->
                    <form action = "location.php" method = "GET">
                        <div class="mt-3">
                            <label for="region_dselect" class="form-label">Kraj*</label>
                            <?php
                                //***Saving selected region to sesssion so that is does not disappear on with onchange submit()" district/town*******
                                if(isset($_GET['region']) && $_GET['region'] != '') { 
                                    $_SESSION['input_region_id'] = $_GET['region'];
                                }                          
                            ?>  
                            <!-- ***Default value of input must be set to $_SESSION['input_region_name'] not $_GET['region']
                                    because GET is destroyed on sumbiting = changing the next form = district select **************************** -->
                            <select class="form-select" aria-label="Kraj" 
                            name="region" id="region" onchange="this.form.submit()" required>
                                <option selected>Vybrete kraj</option>
                                <?php
                                    foreach($region_result as $row1) {
                                        echo '<option value="' .$row1["id"].'">' .$row1["region_name"]. '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </form>
                    <script type="text/javascript">
                            document.getElementById('region').value = "<?php echo $_SESSION['input_region_id'];?>";
                            </script>
                    <?php
                        if(!isset($_SESSION['input_region_id']) && !isset($_GET['region'])) {
                            $district_disabled = 'disabled';    
                        }else{
                            $district_disabled = '';    
                        }
                    ?>
                    <!-- ***District input******************************************************************************************************* -->
                    <form action = "location.php" method = "GET">
                        <div>
                            <label for="district_dselect" class="form-label">Okres*</label>
                            <?php 
                            if(isset($_GET['district']) && $_GET['district'] != '') { 
                                $town_disabled = '';
                                $_SESSION['input_district_id'] = $_GET['district'];
                            }     
                            ?>
                            <select class="form-select" aria-label="Okres" 
                            name="district" id="district" onchange="this.form.submit()" <?php echo $district_disabled; ?> required>
                                <option selected>Vyberte okres</option>
                                <?php    
                                    $selected_region_id =  $_SESSION['input_region_id'];
                                    $district_query = "SELECT district_name, id FROM district WHERE region_id = '$selected_region_id' ORDER BY district_name ASC";
                                    $district_result = $db->query($district_query);
                                    foreach($district_result as $row2) {
                                        echo '<option value="' .$row2["id"].'">' .$row2["district_name"]. '</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </form>
                    <script type="text/javascript">
                        document.getElementById('district').value = "<?php echo $_SESSION['input_district_id'];?>";
                    </script>
                    <?php
                        if(!isset($_SESSION['input_district_id']) && !isset($_GET['district'])) {
                            $town_disabled = 'disabled';    
                        }else{
                            $town_disabled = '';    
                        }
                    ?>
                    <!-- ***Town input*********************************************************************************************************** -->
                    <form action="location.php" method="POST" class="row">
                        <label for="town_dselect" class="form-label">Město*</label>
                        
                        <select class="form-select" aria-label="Okres" 
                        id="town" name="town" <?php echo $town_disabled; ?> required>
                            <option selected>Vyberte město</option>
                            <?php   
                                $selected_district_id =  $_SESSION['input_district_id'];  
                                $town_query = "SELECT town_name, id FROM town WHERE district_id  = '$selected_district_id' ORDER BY town_name ASC";
                                $town_result = $db->query($town_query);
                                foreach($town_result as $row3) {
                                    echo '<option value="' .$row3["id"].'">' .$row3["town_name"]. '</option>';
                                }
                            ?>
                        </select>
                        <?php
                            echo '<input type="submit" '.$disable_create.' class="btn btn-primary btn-lg text-center mt-3" id="new_location" name="new_location" value="Vytvořit">';
                        ?>
                    </form>
                    <script type="text/javascript">
                        document.getElementById('town').value = "<?php echo $_SESSION['input_town_id'];?>";
                    </script>
                    <!-- <form method="post" class="row" action="location.php">  
                        <div>
                            <input type="submit" class="btn btn-outline-secondary btn-lg text-center mt-2" id="unset" name="unset" value="Zrušit">
                        </div>
                    </form> -->
                    <?php
                    if(isset($_POST['unset'])) {
                        unset_input_region();
                        unset_input_district();
                        unset_input_nick();
                        }
                        if(isset($_SESSION['input_region_name'])) {
                            echo $_SESSION['input_region_name'];
                        }
                    ?>  
            </div>    
            <div class="col col-lg-1 text-start">

            </div>
        </div>    
    </div>
    <?php
        //***On sumbmit***
        if (isset($_POST['new_location']) && isset($_SESSION['input_nickname']) && isset($_SESSION['input_region_id']) && isset($_SESSION['input_district_id'])) {
            $nick = $_SESSION['input_nickname'];
            $region_id =    $_SESSION['input_region_id'];
            $district_id =  $_SESSION['input_district_id'];
            $town_id =      $_POST['town'];
            $insert_array = [$nick, $region_id, $district_id, $town_id, $user_id];
            // print_r($insert_array);
            $sql = "INSERT INTO location(nickname, town_district_region_id, town_district_id, town_id, user_id)
            VALUES(?,?,?,?,?)";
            $stmtinsert = $db->prepare($sql);
            $result = $stmtinsert->execute($insert_array);
            if($result) { 
                unset($_SESSION["input_nickname"]);   
                echo '<script type="text/javascript">',
                    'alert_new_location_success();',
                    'reload();', 
                    '</script>';
            }else {
                echo '<script type="text/javascript">',
                    'alert_new_location_fail();',
                    '</script>'; 
            }
        }

    ?>
</body>
</html>