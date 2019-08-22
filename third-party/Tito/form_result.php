
<?php

$home = $_POST['home_addr'];
$home_time = $_POST['home_time'];
$work = $_POST['work_addr'];

include 'getTrafficData.php';


//**************SQL variables*********************
$servername = getenv('TITODBSERVER');
$username = getenv('TITODBUSERNAME');
$password = getenv('TITODBPASSWORD');
$tablename = "TitoTable";
$dbname = "TitoDB";
//*************************************************
/*
// Réception des variables
$hour_home_departure = $_POST['hour_home_departure'];
$hour_work_departure = $_POST['hour_work_departure'];

//nettoyage des variables
$home = str_replace(' ', '%20', $home);
$work = str_replace(' ', '%20', $work);


//**************Fonctions*********************
dataconversion($hour_home_departure, $hour_work_departure);
GetDataFromGoogle();
CreateStats();
*/
echo "<div class='parallax-container' data-parallax='scroll' data-speed='0.1' data-bleed='50' data-natural-height='223' data-image-src='./asset/img/bg.jpg'>";
echo "<section>";

if(!isset($result['error'])){
    displayInfo($result, $home, $home_time, $work);
    }
    else{
    echo "Google Error";
}
/*
DisplayTable();
DisplayStats();
*/
echo "</section>";
echo "</div>";

showmap($home, $work);
writeintodb();
//****************************************

function displayInfo($result, $home, $home_time, $work){

    ?>
    <div class="container">
        <div class="row">
            <div class="span12">
                <h2 id="titleResult" style="color: white;"><i class="fa fa-car"></i> Average commuting time</h2>
            </div>
        </div>
        <div style="background-color: rgba(0,0,0, 0.5); border: 1px solid white; margin-bottom: 10px;">
            <div class="row text-center">
                <div class="col-lg-5 col-md-5">
                    <h2 class="text-center" style="margin-top:30px; margin-bottom: 30px; color: white;"><?php echo str_replace(',%20France', '', $home); ?></h2>
                </div>
                <div class="col-lg-2 col-md-2">
                    <i class="fa fa-arrows-h fa-3x" style="color: white;margin-top:30px; margin-bottom: 30px;"></i>
                </div>
                <div class="col-lg-5 col-md-5">
                    <h2 class="text-center" style="margin-top:30px; margin-bottom: 30px; color: white;"><?php echo str_replace(',%20France', '', $work); ?></h2>
                </div>
            </div>
            <div class="table-responsive" style="margin: 0px 10px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Monday</th>
                            <th>Tuesday</th>
                            <th>Wednesday</th>
                            <th>Thursday</th>
                            <th>Friday</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>Home to work</td>
                            <td>
                                <?php
                                foreach($result['monday']['home_to_work']['range_less'] as $hour => $time){
                                    $date = new \DateTime();
                                    $date->setTimestamp($hour);
                                    if($time[1]){
                                        echo "<span class='min-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else if ($time[2]){
                                        echo "<span class='max-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else{
                                        echo $date->format('H:i') .' - '. secondsToTime($time[0]) . '</br>';
                                    }
                                }
                                ?>
                                <?php
                                if(count($result['monday']['home_to_work']['range_less']) > 0 && $result['monday']['home_to_work']['min']){
                                    echo "<span class='min-range'>".$home_time." - ".secondsToTime($result['monday']['home_to_work']['time']) . '</span></br>';
                                }
                                if(count($result['monday']['home_to_work']['range_less']) > 0 && $result['monday']['home_to_work']['max']){
                                    echo "<span class='max-range'>".$home_time." - ".secondsToTime($result['monday']['home_to_work']['time']) . '</span></br>';
                                }else{
                                    echo $home_time." - ".secondsToTime($result['monday']['home_to_work']['time']) . '</br>';
                                }
                                ?>
                                <?php
                                foreach($result['monday']['home_to_work']['range_more'] as $hour => $time){
                                    $date = new \DateTime();
                                    $date->setTimestamp($hour);
                                    if($time[1]){
                                        echo "<span class='min-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else if ($time[2]){
                                        echo "<span class='max-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else{
                                        echo $date->format('H:i') .' - '. secondsToTime($time[0]) . '</br>';
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach($result['tuesday']['home_to_work']['range_less'] as $hour => $time){
                                    $date = new \DateTime();
                                    $date->setTimestamp($hour);
                                    if($time[1]){
                                        echo "<span class='min-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else if ($time[2]){
                                        echo "<span class='max-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else{
                                        echo $date->format('H:i') .' - '. secondsToTime($time[0]) . '</br>';
                                    }
                                }
                                ?>
                                <?php
                                if(count($result['tuesday']['home_to_work']['range_less']) > 0 && $result['tuesday']['home_to_work']['min']){
                                    echo "<span class='min-range'>".$home_time." - ".secondsToTime($result['tuesday']['home_to_work']['time']) . '</span></br>';
                                }
                                if(count($result['tuesday']['home_to_work']['range_less']) > 0 && $result['tuesday']['home_to_work']['max']){
                                    echo "<span class='max-range'>".$home_time." - ".secondsToTime($result['tuesday']['home_to_work']['time']) . '</span></br>';
                                }else{
                                    echo $home_time." - ".secondsToTime($result['tuesday']['home_to_work']['time']) . '</br>';
                                }
                                ?>
                                <?php
                                foreach($result['tuesday']['home_to_work']['range_more'] as $hour => $time){
                                    $date = new \DateTime();
                                    $date->setTimestamp($hour);
                                    if($time[1]){
                                        echo "<span class='min-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else if ($time[2]){
                                        echo "<span class='max-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else{
                                        echo $date->format('H:i') .' - '. secondsToTime($time[0]) . '</br>';
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach($result['wednesday']['home_to_work']['range_less'] as $hour => $time){
                                    $date = new \DateTime();
                                    $date->setTimestamp($hour);
                                    if($time[1]){
                                        echo "<span class='min-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else if ($time[2]){
                                        echo "<span class='max-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else{
                                        echo $date->format('H:i') .' - '. secondsToTime($time[0]) . '</br>';
                                    }
                                }
                                ?>

                                <?php
                                if(count($result['wednesday']['home_to_work']['range_less']) > 0 && $result['wednesday']['home_to_work']['min']){
                                    echo "<span class='min-range'>".$home_time." - ".secondsToTime($result['wednesday']['home_to_work']['time']) . '</span></br>';
                                }
                                if(count($result['wednesday']['home_to_work']['range_less']) > 0 && $result['wednesday']['home_to_work']['max']){
                                    echo "<span class='max-range'>".$home_time." - ".secondsToTime($result['wednesday']['home_to_work']['time']) . '</span></br>';
                                }else{
                                    echo $home_time." - ".secondsToTime($result['wednesday']['home_to_work']['time']) . '</br>';
                                }
                                ?>

                                <?php
                                foreach($result['wednesday']['home_to_work']['range_more'] as $hour => $time){
                                    $date = new \DateTime();
                                    $date->setTimestamp($hour);
                                    if($time[1]){
                                        echo "<span class='min-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else if ($time[2]){
                                        echo "<span class='max-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else{
                                        echo $date->format('H:i') .' - '. secondsToTime($time[0]) . '</br>';
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach($result['thursday']['home_to_work']['range_less'] as $hour => $time){
                                    $date = new \DateTime();
                                    $date->setTimestamp($hour);
                                    if($time[1]){
                                        echo "<span class='min-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else if ($time[2]){
                                        echo "<span class='max-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else{
                                        echo $date->format('H:i') .' - '. secondsToTime($time[0]) . '</br>';
                                    }
                                }
                                ?>


                                <?php
                                if(count($result['thursday']['home_to_work']['range_less']) > 0 && $result['thursday']['home_to_work']['min']){
                                    echo "<span class='min-range'>".$home_time." - ".secondsToTime($result['thursday']['home_to_work']['time']) . '</span></br>';
                                }
                                if(count($result['thursday']['home_to_work']['range_less']) > 0 && $result['thursday']['home_to_work']['max']){
                                    echo "<span class='max-range'>".$home_time." - ".secondsToTime($result['thursday']['home_to_work']['time']) . '</span></br>';
                                }else{
                                    echo $home_time." - ".secondsToTime($result['thursday']['home_to_work']['time']) . '</br>';
                                }
                                ?>

                                <?php
                                foreach($result['thursday']['home_to_work']['range_more'] as $hour => $time){
                                    $date = new \DateTime();
                                    $date->setTimestamp($hour);
                                    if($time[1]){
                                        echo "<span class='min-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else if ($time[2]){
                                        echo "<span class='max-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else{
                                        echo $date->format('H:i') .' - '. secondsToTime($time[0]) . '</br>';
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                foreach($result['friday']['home_to_work']['range_less'] as $hour => $time){
                                    $date = new \DateTime();
                                    $date->setTimestamp($hour);
                                    if($time[1]){
                                        echo "<span class='min-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else if ($time[2]){
                                        echo "<span class='max-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else{
                                        echo $date->format('H:i') .' - '. secondsToTime($time[0]) . '</br>';
                                    }
                                }
                                ?>

                                <?php
                                if(count($result['friday']['home_to_work']['range_less']) > 0 && $result['friday']['home_to_work']['min']){
                                    echo "<span class='min-range'>".$home_time." - ".secondsToTime($result['friday']['home_to_work']['time']) . '</span></br>';
                                }
                                if(count($result['friday']['home_to_work']['range_less']) > 0 && $result['friday']['home_to_work']['max']){
                                    echo "<span class='max-range'>".$home_time." - ".secondsToTime($result['friday']['home_to_work']['time']) . '</span></br>';
                                }else{
                                    echo $home_time." - ".secondsToTime($result['friday']['home_to_work']['time']) . '</br>';
                                }
                                ?>
                                <?php
                                foreach($result['friday']['home_to_work']['range_more'] as $hour => $time){
                                    $date = new \DateTime();
                                    $date->setTimestamp($hour);
                                    if($time[1]){
                                        echo "<span class='min-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else if ($time[2]){
                                        echo "<span class='max-range'>".$date->format('H:i') .' - '. secondsToTime($time[0]) . '</span></br>';
                                    }else{
                                        echo $date->format('H:i') .' - '. secondsToTime($time[0]) . '</br>';
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Work to home</td>
                            <td><?php echo secondsToTime($result['monday']['work_to_home']['time']); ?></td>
                            <td><?php echo secondsToTime($result['tuesday']['work_to_home']['time']); ?></td>
                            <td><?php echo secondsToTime($result['wednesday']['work_to_home']['time']); ?></td>
                            <td><?php echo secondsToTime($result['thursday']['work_to_home']['time']); ?></td>
                            <td><?php echo secondsToTime($result['friday']['work_to_home']['time']); ?></td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td><?php echo secondsToTime($result['monday']['total']); ?></td>
                            <td><?php echo secondsToTime($result['tuesday']['total']); ?></td>
                            <td><?php echo secondsToTime($result['wednesday']['total']); ?></td>
                            <td><?php echo secondsToTime($result['thursday']['total']); ?></td>
                            <td><?php echo secondsToTime($result['friday']['total']); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
    displayStats($result['total']);
}

//Show maps
function showmap($home, $work) {

    // echo '<div class="jumbotron text-center">';

    echo '<iframe width="100%" height="100%" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/directions?origin=' . $home . '&destination=' . $work . '&key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk" allowfullscreen></iframe>';
    //  echo '</div>';
}

//conversion d'une durée en secondes en format humain
function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    $result = $dtF->diff($dtT);
    $stringResult = "";
    if ($result->format("%a") != 0) {
        $stringResult .= $result->format("%a") . " day" . ($result->format("%a") > 1 ? "s" : "") . " ";
    }
    if ($result->format("%h") != 0) {
        $stringResult .= $result->format("%h") . " hour" . ($result->format("%h") > 1 ? "s" : "") . " ";
    }
    $stringResult .= $result->format("%i") . " minute" . ($result->format("%i") > 1 ? "s" : "") . " ";
    return $stringResult;
}

//create stats
function DisplayStats($week) {
    $stats = [];
    $stats['week'] = $week;
    $stats['month'] = $stats['week'] * 4;
    $stats['year'] = $stats['month'] * 12;
    $stats['life'] = $stats['year'] * 40;

    echo "<div class='container'>";
    echo "<div class='row'>";

    // Create stat block for each $stat (week, month, year, life)
    //$class_colors = array('week' => 'stat-block-blue', 'month' => 'stat-block-yellow', 'year' => 'stat-block-black', 'life' => 'stat-block-green');
    $class_colors = array();
    foreach ($stats as $key => $val) {
        echo createStatBlock($key, $val, (isset($class_colors[$key]) ? $class_colors[$key] : "stat-block-default"));
    }
    echo "</div>";
    echo "</div>";
}

function createStatBlock($key, $seconds, $class_color) {
    $block = "<div class='col-lg-3 col-md-3 col-sm-6 col-xs-12'>";
    $block .= "<div class='stat-block $class_color'>";

    $block .= "<div class='row'>";
    $block .= "<div class='col-lg-6 col-md-6 text-center'>";
    $block .= "<h3>" . ucfirst($key) . "</h3>";
    $block .= "</div>";

    $tmp = getRoundedTime($seconds);
    $block .= "<div class='col-lg-6 col-md-6'>";
    $block .= "<h1>" . $tmp['time'] . "</h1>";
    $block .= "<p>" . $tmp['unit'] . "</p>";
    $block .= "</div>";
    $block .= "</div>";

    $block .= "</div>";
    $block .= "</div>";
    return $block;
}

function getRoundedTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    $result = $dtF->diff($dtT);
    if ($result->format('%a') > 0) {
        return array('time' => $result->format('%a'), 'unit' => "day" . ($result->format("%a") > 1 ? "s" : ""));
    }
    if ($result->format('%h') > 0) {
        return array('time' => $result->format('%h'), 'unit' => "hour" . ($result->format("%h") > 1 ? "s" : ""));
    }
    return array('time' => $result->format('%i'), 'unit' => "minute" . ($result->format("%i") > 1 ? "s" : ""));
}
/*
//convertit les données au format nécessaire pour Google
function dataconversion($hour_home_departure, $hour_work_departure) {

    //calcul des dates de départ de la maison
    global $weekdays_home_departure;
    foreach ($weekdays_home_departure as $day) {
        $weekdays_home_departure[$day] = strtotime("next " . $day . "+" . substr($hour_home_departure, 0, 2) . "hours +" . substr($hour_home_departure, 3, 2) . "minutes");
    }

    //calcul des dates de départ du travail
    global $weekdays_work_departure;
    foreach ($weekdays_work_departure as $day) {
        $weekdays_work_departure[$day] = strtotime("next " . $day . "+" . substr($hour_work_departure, 0, 2) . "hours +" . substr($hour_work_departure, 3, 2) . "minutes");
    }
}


//Obtention des infos de Google
function GetDataFromGoogle() {
    global $weekdays_home_duration;
    global $weekdays_work_duration;
    global $home;
    global $work;
    global $weekdays_home_departure;
    global $weekdays_work_departure;

    $weekdays_home_duration_result = array();
    foreach ($weekdays_home_duration as $key => $day) {

        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $home . "&destination=" . $work . "&departure_time=" . $weekdays_home_departure[$day] . "&traffic_model=pessimistic&key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        $weekdays_home_duration_result[$day] = $response->routes[0]->legs[0]->duration_in_traffic->value;
        //unset($weekdays_home_duration[$key]);
    }
    $weekdays_home_duration = $weekdays_home_duration_result;

    $weekdays_work_duration_result = array();
    foreach ($weekdays_work_duration as $key => $day) {

        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $work . "&destination=" . $home . "&departure_time=" . $weekdays_work_departure[$day] . "&traffic_model=pessimistic&key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        $weekdays_work_duration_result[$day] = $response->routes[0]->legs[0]->duration_in_traffic->value;
        //unset($weekdays_work_duration[$key]);
    }
    $weekdays_work_duration = $weekdays_work_duration_result;
}

//Affichage du tableau
function DisplayTable() {
    global $stats;
    global $weekdays_home_duration;
    global $weekdays_work_duration;
    global $home;
    global $work;
    ?>

    <div class="container">
        <div class="row">
            <div class="span12">
                <h2 id="titleResult" style="color: white;"><i class="fa fa-car"></i> Average commuting time</h2>
            </div>
        </div>
        <div style="background-color: rgba(0,0,0, 0.5); border: 1px solid white; margin-bottom: 10px;">
            <div class="row text-center">
                <div class="col-lg-5 col-md-5">
                    <?php
                    $home = str_replace(',%20France', '', $home);
                    echo "<h2 class='text-center' style='margin-top:30px; margin-bottom: 30px; color: white;'>" . str_replace('%20', ' ', $home) . "</h2>";
                    ?>
                </div>
                <div class="col-lg-2 col-md-2">
                    <i class="fa fa-arrows-h fa-3x" style="color: white;margin-top:30px; margin-bottom: 30px;"></i>
                </div>
                <div class="col-lg-5 col-md-5">
                    <?php
                    $work = str_replace(',%20France', '', $work);
                    echo "<h2 class='text-center' style='margin-top:30px; margin-bottom: 30px; color: white;'>" . str_replace('%20', ' ', $work) . "</h2>";
                    ?>
                </div>
            </div>
            <div class="table-responsive" style="margin: 0px 10px;">
                <table class="table">
                    <thead>
                        <tr>
                            <th></th>
                            <?php
                            foreach ($weekdays_home_duration as $key => $day) {
                                echo "<th class=''>" . $key . "</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <th scope="row">Home <i class="fa fa-long-arrow-right"></i> Work</th>
                            <?php
                            foreach ($weekdays_home_duration as $key => $day) {
                                echo "<td>" . secondsToTime($weekdays_home_duration["$key"]) . "</td>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <th scope="row">Work <i class="fa fa-long-arrow-right"></i> Home</th>
                                <?php
                                foreach ($weekdays_work_duration as $key => $day) {
                                    echo "<td>" . secondsToTime($weekdays_work_duration["$key"]) . "</td>";
                                }
                                ?>
                        </tr>
                        <tr style="background: rgba(33, 64, 155, 0.5);">
                            <th scope="row">Total</th>
                            <?php
                            foreach ($weekdays_work_duration as $key => $day) {
                                echo "<td>" . secondsToTime($weekdays_home_duration["$key"] + $weekdays_work_duration["$key"]) . "</td>";
                                //workaround car le tableau a un offset de trop!
                            }
                            ?>
                        </tr>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
}

*/

function writeintodb() {
    //variables SQL
    global $servername;
    global $username;
    global $password;
    global $dbname;
    global $tablename;

    //Autres
    global $home;
    global $work;
    global $hour_home_departure;
    global $hour_work_departure;


// Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "INSERT INTO $tablename (home, work, hour_home_departure, hour_work_departure) VALUES ('$home', '$work', '$hour_home_departure', '$hour_work_departure')";
    if ($conn->query($sql) === TRUE) {

    } else {
        echo "Error writing values: " . $conn->error;
    }
    $conn->close();
}


?>
