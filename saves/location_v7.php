<?php
require_once "session/session.php"; 
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
                            if(isset($_POST['nickname'])) {
                                    echo 'form post';
                                    $value_injection = $_POST['nickname'];
                                }elseif(isset($_SESSION['input_nickname'])){
                                    echo 'from session';
                                    $value_injection = $_SESSION['input_nickname'];
                             
                                }else{
                                    echo 'empty';
                                    $value_injection = '';
                                }
                                ?>
                            <input class="form-control" value="<?php echo $value_injection ??''; ?>" type="text" id="nickname" 
                            name="nickname" onchange="this.form.submit()" required>
                        </div>
                    </form>
                    <?php
                        $disable_create = '';
                        if(isset($_POST['nickname']) && $_POST['nickname'] != '') {
                            $_SESSION['input_nickname'] = $_POST['nickname'];
                            $stations_name = get_locations_names($user_id, $db);
                            foreach($stations_name as $key => $row) {
                                if($row == $_POST['nickname']) {
                                    $disable_create = 'disabled';
                                    echo '<p class="text-warning">Tato jméno jste již použili</p>';
                                    break;
                                }elseif ($key === array_key_last($stations_name) ) {
                                    echo '<p class="text-success">Toto jméno je volné</p>';
                                }       
                            }
                        }
                    ?>  
                    <!-- ***Region input********************************************************************************************************* -->
                    <form action = "location.php" method = "GET">
                        <div class="mt-3">
                            <label for="region_dselect" class="form-label">Kraj*</label>
                            <?php
                                //***Saving selected region to sesssion so that is does not disappear on with onchange submit()" district/town*******
                                if(isset($_GET['region']) && $_GET['region'] != '') { 
                                    $_SESSION['input_region_name'] = $_GET['region'];
                                }                            
                            ?>  
                            <!-- ***Default value of input must be set to $_SESSION['input_region_name'] not $_GET['region']
                                    because GET is destroyed on sumbiting = changing the next form = district select **************************** -->
                            <input class="form-control"  value="<?php echo $_SESSION['input_region_name'] ??''; ?>"  list="region" id="region_dselect" 
                            name="region" placeholder="Vyhledat..." onchange="this.form.submit()" required>
                            <datalist id="region">
                                <?php
                                    foreach($region_result as $row1) {
                                        echo '<option value="' .$row1["region_name"].'">' .$row1["id"]. '';
                                }
                                ?>
                            </datalist>
                        </div>
                    </form>
                    <?php
                        //
                        if(isset($_SESSION['input_region_name'])) { 
                            $district_disabled = '';
                            $region_query = "SELECT id FROM region WHERE region_name = ?";
                            if(isset($_GET['region'])) {
                            $stmtinsert = $db->prepare($region_query);
                            $stmtinsert->execute([$_GET['region']]);
                            $reg_id = $stmtinsert->fetchColumn();
                            $_SESSION['input_region_id'] = $reg_id;    
                            } 
                        }else{
                            $district_disabled = 'disabled';
                        }
                    ?>
                    <!-- ***District input******************************************************************************************************* -->
                    <form action = "<?php $_PHP_SELF ?>" method = "GET">
                        <div>
                            <label for="district_dselect" class="form-label">Okres*</label>
                            <input class="form-control" value="<?php echo $_GET['district']??''; ?>" list="district" id="district_dselect" 
                            name="district" placeholder="Vyhledat..." onchange="this.form.submit()" required <?php echo $district_disabled; ?> >
                            <datalist id="district">   
                                <?php    
                                    $selected_region_id = get_input_region_id();  
                                    $district_query = "SELECT district_name, id FROM district WHERE region_id = '$selected_region_id' ORDER BY district_name ASC";
                                    $district_result = $db->query($district_query);
                                    foreach($district_result as $row2) {
                                        echo '<option value="' .$row2["district_name"].'">';
                                    }
                                ?>
                            </datalist>
                        </div>
                    </form>
                    <?php
                        if(isset($_GET['district'])) {
                            $town_disabled = '';
                            $district_query = "SELECT id FROM district WHERE district_name = ?";
                            $stmtinsert = $db->prepare($district_query);
                            $stmtinsert->execute([$_GET['district']]);
                            $dist_id = $stmtinsert->fetchColumn();
                            set_input_district($dist_id,$_GET['district']);
                        }else{
                            $town_disabled = 'disabled';
                        }

                    ?>
                    <!-- ***Town input*********************************************************************************************************** -->
                    <form action="location.php" method="post" class="row">
                            <label for="town_dselect" class="form-label">Město*</label>
                            <input class="form-control" list="town" id="town_dselect" name="town" placeholder="Vyhledat..." required <?php echo $town_disabled; ?>>
                            <datalist id="town">
                                <?php   
                                    $selected_district_id = get_input_district_id();  
                                    $town_query = "SELECT town_name, id FROM town WHERE district_id  = '$selected_district_id' ORDER BY town_name ASC";
                                    $town_result = $db->query($town_query);
                                    foreach($town_result as $row3) {
                                        echo '<option value="' .$row3["town_name"].'">' .$row3["id"]. '';
                                    }
                                ?>
                            </datalist>
                            <?php
                                if(isset($_POST['town'])) {
                                $town_query = "SELECT id FROM town WHERE town_name = ?";
                                $stmtinsert = $db->prepare($town_query);
                                $stmtinsert->execute([$_POST['town']]);
                                $town_id = $stmtinsert->fetchColumn();
                                $_SESSION['input_town_id'] = $town_id; 
                                }
                            ?>
                            <!-- <label for="street">Ulice </label>
                            <input type="text" class="form-control" name="street"/>
                            <label for="house_number">Číslo popisné </label>
                            <input type="text" class="form-control" name="house_number"/> -->
                        <?php
                            echo '<input type="submit" '.$disable_create.' class="btn btn-primary btn-lg text-center mt-3" id="new_location" name="new_location" value="Vytvořit">';
                        ?>
                    </form>
                    <form method="post" class="row" action="location.php">  
                        <div>
                            <input type="submit" class="btn btn-outline-secondary btn-lg text-center mt-2" id="unset" name="unset" value="Zrušit">
                        </div>
                    </form>
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
        if (isset($_POST['new_location']) && isset($_SESSION['input_nickname']) && isset($_SESSION['input_region_id']) && isset($_SESSION['input_district_id']) ) {
            $nick = $_SESSION['input_nickname'];
            $region_id =    $_SESSION['input_region_id'];
            $district_id =  $_SESSION['input_district_id'];
            $town_id =      $_SESSION['input_town_id'];
            echo 'nick is set to: '.$nick.BR;
            echo 'region: '.$_SESSION['input_region_name'].' with value: '.$region_id.BR;
            echo 'dist: '.$_SESSION['input_district_name'].' with value: '.$district_id.BR;
            echo 'town: '.$_POST['town'].' with value: '.$town_id.BR;
            $insert_array = [$nick, $region_id, $district_id, $town_id, $user_id];
            print_r($insert_array);
            $sql = "INSERT INTO location(nickname, town_district_region_id, town_district_id, town_id, user_id)
            VALUES(?,?,?,?,?)";
            $stmtinsert = $db->prepare($sql);
            $result = $stmtinsert->execute($insert_array);
            if($result) { 
                echo '<script type="text/javascript">',
                    'alert_new_location_success();',
                    'unset($_SESSION["input_region_id"]);',
                    'unset( $_SESSION["input_region_name"]);',
                    'unset( $_SESSION["input_district_id"]);',
                    'unset( $_SESSION["input_district_name"]);',
                    'unset($_SESSION["input_nickname"]);',
                    '</script>'; 
                // echo '<script type="text/javascript">',
                //     'alert_new_location_success();',
                //     'unset_input_region();',
                //     'unset_input_district();',
                //     'unset_input_nick();',
                //     '</script>';      
                    
            }else {
                echo '<script type="text/javascript">',
                    'alert_new_location_fail();',
                    '</script>';
                    header('location:index.php');
            }
        }   
    ?>
</body>
</html>