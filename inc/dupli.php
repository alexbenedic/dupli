<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "glpi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT name,serial,contact, COUNT(name) AS duplications
FROM `glpi_computers`
WHERE  `glpi_computers`.`is_deleted` = 0 
AND `glpi_computers`.`is_template` = 0 
GROUP BY serial 
HAVING duplications > 1;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Computer: " . $row["name"]. " - Serial: " . $row["serial"]. "- Username: " . $row["contact"]."- Dupilcation: " . $row["duplications"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();

?>