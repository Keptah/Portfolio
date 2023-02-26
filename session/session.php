<?php
    session_start();
    define('__ROOT__', dirname(dirname(__FILE__)));
    require_once(__ROOT__.'/connect/config.php');    
    function login($user_email) {
    $_SESSION["user_email"] = $user_email;
    }

    //***Declaring a var for logged user id with scope to all pages that require session(vast majority)**********************************************
    if(isset($_SESSION["user_id"])) {
        $user_id = $_SESSION['user_id'];
    }

    function get_user_valid($user_id, $db) { 
        $sql = "SELECT validated FROM `user` WHERE user_id = $user_id";
        $stmtinsert = $db->query($sql);
            $result = $stmtinsert['validated'] ??= 0;
        return $result;
    }
    
    function get_login_eamil() {
        return $_SESSION["user_email"];
    }

    function get_login_id(){ 
        return $_SESSION["user_id"];
    }

    function get_location(){
        $array = [
            "region_id" =>      $_SESSION['region_id'],
            "district_id" =>    $_SESSION['district_id'],
            "town_id" =>        $_SESSION['town_id']   
        ];
        return $array;
    }

    function logout() {
        unset($_SESSION["user_email"]);
        unset($_SESSION["user_id"]);
    }

    function get_valid(){
        return $_SESSION["user_validation"];
    }

    function is_logged_in() {
        if (isset($_SESSION["user_email"])) {
            return true;
        } else {
            return false;
        }
    }

    function set_station($station) {
        $_SESSION['set_station'] = $station; 
    }

    function get_station_id() {
        return $_SESSION['set_station'];
    }

    
    function get_locations_id($user_id, $db) {
        $result = [];
        $sql = "SELECT id FROM `location` WHERE user_id  = $user_id";
        $stmtinsert  =$db->query($sql);
        foreach($stmtinsert as $row) {
            array_push($result,$row['id']);
        }
        return $result;
    }

    function get_user_report_count($user_id, $db) {
        $array = [];
        $sql = "SELECT id FROM `weather` WHERE location_user_id = $user_id";
        $stmtinsert  =$db->query($sql);
        foreach($stmtinsert as $row) {
            array_push($array,$row);
        }
        return count($array);
    }

    function get_locations_names($user_id, $db) {
        $result = [];
        $sql = "SELECT nickname FROM `location` WHERE user_id  = $user_id";
        $stmtinsert  =$db->query($sql);
        foreach($stmtinsert as $row) {
            array_push($result,$row['nickname']);
        }
        return $result;
    }
    
    

    function get_location_data($user_id, $location_id, $db) {
        $sql = "SELECT * FROM `location` WHERE user_id  = $user_id AND id = $location_id";
        $stmtinsert  =  $db->query($sql);
        $fetch =        $stmtinsert->fetch();   
        $result = [
            'id'                =>$fetch['id'],
            'nickname'          =>$fetch['nickname'],
            'town_id'           =>$fetch['town_id'],
            'district_id'       =>$fetch['town_district_id'],
            'region_id'         =>$fetch['town_district_region_id'],
        ];
        return $result;
    }



    //Just a test function to see if login.php is creating vars about user correctly  
    function print_user_info() {
        echo "<div>
                <hr>
                <span>user ". $_SESSION['user_email'] . "    with id " . $_SESSION['user_id'] ."</span>
                </br>
                <span>". $_SESSION['user_first_name'] . " " . $_SESSION['user_last_name'] ."</span>
                </br>
                <span>with status ". $_SESSION['user_validated'] ." is currently logged in</span>                
            </div>";
    }

    function get_user_infobox_data($user_id, $db) {
        $sql = "SELECT * FROM `user` WHERE id = $user_id";
        $stmtinsert =   $db->query($sql);
        $fetch =        $stmtinsert->fetch();
        $got_station = false;
        if(count(get_locations_id($user_id, $db)) > 0) { 
            $got_station = true; 
        }
        $result  = [
            'fname'         =>$fetch['first_name'],
            'lname'         =>$fetch['last_name'],
            'validated'     =>$fetch['validated'],
            'email'         =>$fetch['email'],
            'got_station'   =>$got_station,
        ];
        return $result;
    }




    function print_location_info() {
        echo "<div>
        <hr>
        </br>
        <span> " .$_SESSION['region_name'] . " with code " . $_SESSION['region_id'] . " </span>
        </br>
        <span> " .$_SESSION['district_name'] . " with code " . $_SESSION['district_id'] . " </span>
        </br>
        <span> " .$_SESSION['town_name'] . " with code " . $_SESSION['town_id'] . " </span>
        </div>";

    }
?>

<script>
       function home_redirect() {
        header('location:home.php');
    }

    function index_redirect() {
        header('location:index.php');
    }
</script>