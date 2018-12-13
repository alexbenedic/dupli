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
 $sql = "SELECT name,serial,contact, COUNT(serial) AS duplications
FROM `glpi_computers`
WHERE  `glpi_computers`.`is_deleted` = 0 
AND `glpi_computers`.`is_template` = 0 
GROUP BY serial, name 
HAVING duplications > 1;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $a=0;
        while($row = $result->fetch_assoc()) {
            $sqlb = "UPDATE `glpi_computers` SET `glpi_computers`.`is_deleted`='1' WHERE `glpi_computers`.`name` = '". $row["name"]."'
 ORDER BY `glpi_computers`.`date_mod` asc limit 1";
if ($conn->query($sqlb) === TRUE) {
 echo "done<br>";
} else {
    echo "Error updating record: " . $conn->error;
}
$a++;
    }
    echo $a;
}  



$conn->close();

?>