<?php
require_once "session/session.php"; 
require_once "navbar.php";
$user_id = get_login_id();
// unset_input_region();
//TODO: Improve user experience by making the dropdowns responsive so that selecting your region limits 
//      options in district to districts within selected region, the same goes for town dropdown  
    
//***Pulling tables from databasse to be used as option values for dropdowns
$region_query = "SELECT region_name, id FROM region ORDER BY region_name ASC";
$region_result = $db->query($region_query);

$district_query = "SELECT district_name, id FROM district ORDER BY district_name ASC";
$district_result = $db->query($district_query);

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
    //***Defining sweet alert2 alerts**************************************************************************************************************** 
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
            <div class="col col-lg-4 text-start"> 
                <form method="post">  
                <input type="submit" name="button1" value="Button1"/>

                </form>
                <?php
                   if(isset($_POST['button1'])) {
                    unset_input_region();
                    unset_input_district();
                    unset_input_nick();
                    }

                    if(isset($_SESSION['input_region_name'])) {
                        echo $_SESSION['input_region_name'];
                    }
                ?>
            </div>                  
            <div class="col col-lg-4 text-start">   
                <h1>Nová Stanice</h1>
                <p>Zadejte informace o vaší stanici</p>
                <div class="row justify-content-md-center">
                    <form action = "<?php $_PHP_SELF ?>" method = "POST">
                        <div>
                            <label for="nickname" class="form-label">Jméno stanice*</label>
                            <?php
                            if(isset($_POST['nickname'])) {
                                    echo '1';
                                    $value_injection = $_POST['nickname'];
                                }elseif(isset($_SESSION['input_nickname'])){
                                    echo '2';
                                    $value_injection = $_SESSION['input_nickname'];
                             
                                }else{
                                    echo '3';
                                    $value_injection = '';
                                }
                                ?>
                            <input class="form-control" value="<?php echo $value_injection ??''; ?>" type="text" id="nickname" 
                            name="nickname" onchange="this.form.submit()">
                        </div>
                    <!-- ***Nickname input ****************************************************************************************************** -->
                    </form>
                    <?php
                    $disable_create = '';
                    if(isset($_POST['nickname']) && $_POST['nickname'] != '') {
                        $_SESSION['input_nickname'] = $_POST['nickname'];
                        echo $_POST['nickname'];
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
                    <!-- each drwopdown loads all options pulled from their respective table -->
                    <form action = "location_v3.php" method = "GET">
                        <div>
                            <label for="region_dselect" class="form-label">Kraj*</label>
                            <?php
                                if(isset($_GET['region'])) {
                                    echo '1';
                                    $value_injection = $_GET['region'];
                                }elseif(isset($_SESSION['input_region_name'])){
                                    echo '2';
                                    $value_injection = get_input_region_name();
                             
                                }else{
                                    echo '3';
                                    $value_injection = '';
                                }
                            ?>
                            <input class="form-control"  value="<?php echo $value_injection ??''; ?>"  list="region" id="region_dselect" 
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
             
                    <!-- ### Validate region input else unset or set to like 'bad'########################################## -->
                    <?php
                    //  echo $_GET['region'];
                        if(isset($_GET['region'])) { 
                            $region_query = "SELECT id FROM region WHERE region_name = ?";
                            $stmtinsert = $db->prepare($region_query);
                            $stmtinsert->execute([$_GET['region']]);
                            $reg_id = $stmtinsert->fetchColumn();
                            set_input_region($reg_id, $_GET['region']);    
                            echo 'XXXXXXXXXXXXXXXXXXX<br>';
                            echo 'region name: '.get_input_region_name();
                            echo '<br>';
                            echo 'region id'.get_input_region_id();  
                        }
                    ?>
                    <!-- ***District input******************************************************************************************************* -->
                    <form action = "<?php $_PHP_SELF ?>" method = "GET">
                        <div>
                            <label for="district_dselect" class="form-label">Okres*</label>
                            <input class="form-control" value="<?php echo $_GET['district']??''; ?>" list="district" id="district_dselect" 
                            name="district" placeholder="Vyhledat..." onchange="this.form.submit()" required>
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
                            $district_query = "SELECT id FROM district WHERE district_name = ?";
                            $stmtinsert = $db->prepare($district_query);
                            $stmtinsert->execute([$_GET['district']]);
                            $dist_id = $stmtinsert->fetchColumn();
                            set_input_district($dist_id,$_GET['district']);
                            echo 'XXXXXXXXXXXXXXXXXXX<br>';
                            echo 'district name: '.get_input_district_name();
                            echo '<br>';
                            echo 'district id: '.get_input_district_id();
                        }
                    ?>
                    <!-- ***Town input*********************************************************************************************************** -->
                    <form action="location_v3.php" method="post" class="row">                           <div>
                            <label for="town_dselect" class="form-label">Město*</label>
                            <input class="form-control" list="town" id="town_dselect" name="town" placeholder="Vyhledat..." required>
                            <datalist id="town">
                                <?php   
                                    // $town_query = "SELECT town_name, id FROM town ORDER BY town_name ASC";
                                    // $town_result = $db->query($town_query);

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
                                echo 'setting town id session to: '.$town_id;
                                $_SESSION['input_town_id'] = $town_id; 
                                }
                            ?>
                        </div>
                    
                 
                        <div class="m-4">
                            <label for="street">Ulice </label>
                            <input type="text" class="form-control" name="street"/>
                            <label for="house_number">Číslo popisné </label>
                            <input type="text" class="form-control" name="house_number"/>
                        </div>
                        <?php
                            echo '<input type="submit" '.$disable_create.' class="btn btn-primary btn-lg text-right" id="new_location" name="new_location" value="Vytvořit">';
                        ?>
                    </form>
                </div>
            </div>    
        </div>    
    </div>
    <?php
        //***On sumbmit***
        if (isset($_POST['new_location'])) {
            echo 'main form'.BR;
            $nick = $_SESSION['input_nickname'];
            $region_id =    $_SESSION['input_region_id'];
            $district_id =  $_SESSION['input_district_id'];
            $town_id =      $_SESSION['input_town_id'];
        
            echo 'nick is set to: '.$nick.BR;
            echo 'region: '.$_SESSION['input_region_name'].' with value: '.$region_id.BR;
            echo 'dist: '.$_SESSION['input_district_name'].' with value: '.$district_id.BR;
            echo 'town: '.$_POST['town'].' with value'.$town_id.BR;

            // $sql = "SELECT id FROM region WHERE region_name = ?";
            // $stmtinsert = $db->prepare($sql); 
            // $stmtinsert->execute([$region_name]);
            // $row =      $stmtinsert->rowCount();
            // $fetch =    $stmtinsert->fetch();
            // if($row > 0) {
            //     $_SESSION['region_id'] =    $fetch['id'];
            //     $_SESSION['region_name'] =  $region_name;
            // }
            // $sql = "SELECT id FROM district WHERE district_name = ?";
            // $stmtinsert = $db->prepare($sql); 
            // $stmtinsert->execute([$district_name]);
            // $row =      $stmtinsert->rowCount();
            // $fetch =    $stmtinsert->fetch();
            // if($row > 0) {
            //     $_SESSION['district_id'] =    $fetch['id'];
            //     $_SESSION['district_name'] =  $district_name;
            // }
            // $sql = "SELECT id FROM town WHERE town_name = ?";
            // $stmtinsert = $db->prepare($sql); 
            // $stmtinsert->execute([$town_name]);
            // $row =      $stmtinsert->rowCount();
            // $fetch =    $stmtinsert->fetch();
            // if($row > 0) {
            //     $_SESSION['town_id'] =    $fetch['id'];
            //     $_SESSION['town_name'] =  $town_name;
            // }
            // $selected_location = get_location(); 
            // $user_id = get_login_id();
            $insert_array = [$nick, $region_id, $district_id, $town_id, $user_id];
            print_r($insert_array);
            $sql = "INSERT INTO location(nickname, town_district_region_id, town_district_id, town_id, user_id)
            VALUES(?,?,?,?,?)";
            $stmtinsert = $db->prepare($sql);
            $result = $stmtinsert->execute($insert_array);
            if($result) { 
                echo '<script type="text/javascript">',
                    'alert_new_location_success();',
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
<script>
var select_box_element = document.querySelector('#select_box');
dselect(select_box_element, {
    search: true
});
</script>