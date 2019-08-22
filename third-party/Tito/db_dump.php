

<?php
$servername = getenv('TITODBSERVER');
$password = getenv('TITODBPASSWORD');
$username = getenv('TITODBUSERNAME');
$tablename = "TitoTable";
$dbname = "TitoDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT home, work, hour_home_departure, hour_work_departure FROM $tablename";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "- " . $row["home"]. " " . $row["work"]. $row["hour_home_departure"] . $row["hour_work_departure"] . "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>