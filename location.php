<?php
require_once "session/session.php"; 
require_once "navbar.php";


//TODO: Improve user experience by making the dropdowns responsive so that selecting your region limits 
//      options in district to districts within selected region, the same goes for town dropdown  
    
//***Pulling tables from databasse to be used as option values for dropdowns
$region_query = "SELECT region_name, id FROM region ORDER BY region_name ASC";
$region_result = $db->query($region_query);

$district_query = "SELECT district_name, id FROM district ORDER BY district_name ASC";
$district_result = $db->query($district_query);

$town_query = "SELECT town_name, id FROM town ORDER BY town_name ASC";
$town_result = $db->query($town_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="library/bootstrap-5/css/bootstrap.min.css" rel="stylesheet" />
    <script src="library/bootstrap-5/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="library/dselect.js"></script> -->

    <title>location</title>
</head>
<body>
    <div class="container">
        <form action="location.php" method="post" class="row g-3">   
            <div class="row justify-content-md-center">                    
                <div class="col col-lg-4 text-start">
                    <br>    
                    <h1>Nová Stanice</h1>
                    <p>Zadejte informace o vaší stanici</p>
                    <br>
                    <div class="row justify-content-md-center">
                        <div>
                            <label for="nickname" class="form-label">Jméno stanice</label>
                            <input class="form-control" type="text" id="nickname" name="nickname">
                        </div>
                        <!-- each drwopdown loads all options pulled from their respective table -->
                        <div>
                            <label for="region_dselect" class="form-label">⋆Kraj</label>
                            <input class="form-control" list="region" id="region_dselect" name="region" placeholder="Vyhledat..." required>
                            <datalist id="region">
                                    <?php
                                    foreach($region_result as $row1) {
                                        echo '<option value="' .$row1["region_name"].'">' .$row1["id"]. '';
                                    }
                                    ?>
                            </datalist>
                        </div>

                        <div>
                            <label for="district_dselect" class="form-label">⋆Okres</label>
                            <input class="form-control" list="district" id="district_dselect" name="district" placeholder="Vyhledat..." required>
                            <datalist id="district">

                                <script type="text/javascript">
                                    var region= document.getElementById('region_dselect');
                                </script>
                                
                                <?php 
                                
                                
                                $selected_region =  "<script>document.writeln(res);</script>";
                                echo $selected_region;
                                

                                foreach($district_result as $row2) {
                                    echo '<option value="' .$row2["district_name"].'">';
                                }
                                ?>
                            </datalist>
                        </div>

                        <div>
                            <label for="town_dselect" class="form-label">⋆Město</label>
                            <input class="form-control" list="town" id="town_dselect" name="town" placeholder="Vyhledat..." required>
                            <datalist id="town">
                            <?php
                            foreach($town_result as $row3) {
                                echo '<option value="' .$row3["town_name"].'">' .$row3["id"]. '';
                            }
                            ?>
                            </datalist>
                            <hr>
                        </div>

                        <label for="street">Ulice </label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="street"/>
                        </div>

                        <label for="house_number">Číslo popisné </label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="house_number"/>
                        </div>

                        <input type="submit" class="btn btn-primary btn-lg text-right" id="new_location" name="new_location" value="Vytvořit">            
                    </div>
                </div>    
            </div>    
        </form>
    </div>
    <?php
    //***On sumbmit***
    if (isset($_POST['new_location'])) {
        $nick = $_POST['nickname'];
        $region_name =    $_POST['region'];
        $district_name = $_POST['district'];
        $town_name = $_POST['town'];

        //declaring a $_SESSION type var seems to be tied to if clause otherwise the error message reads as follows
        //Notice: " Trying to access array offset on value of type bool "

        //***Pulling ids from db. 
        // NOTE: By making id the value of optinon of dropdown and using name as tag/label
        //       this code could be avoided. Sadly the value seems to act as titele. 
        //      ---> find a way to show tag only or get tag value   
        $sql = "SELECT id FROM region WHERE region_name = ?";
        $stmtinsert = $db->prepare($sql); 
        $stmtinsert->execute([$region_name]);
        $row =      $stmtinsert->rowCount();
        $fetch =    $stmtinsert->fetch();
        echo 'if ' . $row . ' is greater then 0 ---->';
        if($row > 0) {
            echo 'code got passed';
            $_SESSION['region_id'] =    $fetch['id'];
            $_SESSION['region_name'] =  $region_name;
        }

        $sql = "SELECT id FROM district WHERE district_name = ?";
        $stmtinsert = $db->prepare($sql); 
        $stmtinsert->execute([$district_name]);
        $row =      $stmtinsert->rowCount();
        $fetch =    $stmtinsert->fetch();
        if($row > 0) {
            $_SESSION['district_id'] =    $fetch['id'];
            $_SESSION['district_name'] =  $district_name;
        }

        
        $sql = "SELECT id FROM town WHERE town_name = ?";
        $stmtinsert = $db->prepare($sql); 
        $stmtinsert->execute([$town_name]);
        $row =      $stmtinsert->rowCount();
        $fetch =    $stmtinsert->fetch();
        if($row > 0) {
            $_SESSION['town_id'] =    $fetch['id'];
            $_SESSION['town_name'] =  $town_name;
        }

        //#############################################################################################
        print_user_info();
        print_location_info();
        $selected_location = get_location(); 
        $user_id = get_login_id();
        $array_print = [$nick, $selected_location['region_id'],  $selected_location['district_id'],  $selected_location['town_id'], $user_id];
        print_r($array_print);

        $sql = "INSERT INTO location(nickname, town_district_region_id, town_district_id, town_id, user_id)
        VALUES(?,?,?,?,?)";
        $stmtinsert = $db->prepare($sql);
        echo strval($selected_location['region_id']);

        $result = $stmtinsert->execute([$nick, strval($selected_location['region_id']),  strval($selected_location['district_id']),  $selected_location['town_id'], $user_id]);
        if($result) { 
            echo 'Successfully saved';
        }else {
            echo "error while saving data";
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


<!-- 
                                    //***If no value has been selected for region dropdown input all districts as options in district dropdown*************************************
                                    if($_POST['region'] = "" ) {
                                        foreach($district_result as $row2) {
                                            echo '<option value="' .$row2["district_name"].'">';
                                        }
                                    }else{
                                        $responsive_region_name = $_POST['region'];
                                        $sql = "SELECT id FROM region WHERE region_name = $responsive_region_name";
                                        $resonsive_region_id = $db->query($sql); 
                                        echo $resonsive_region_id;
                                        $district_query = "SELECT district_name, id FROM district WHERE region_id = $resonsive_region_id ORDER BY district_name ASC";
                                        $district_result = $db->query($district_query);

                                        foreach($district_result as $row2) {
                                            echo '<option value="' .$row2["district_name"].'">';
                                        }
                                    }
                                    $responsive_region_name = $_POST['region'];
                                    echo $responsive_region_name;
                                    echo ' dlkjhljhdfkjldjhlkdf'; -->