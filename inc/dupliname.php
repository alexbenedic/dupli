<?php
$servername = "192.168.0.188";
$username = "glpi";
$password = "glpisecret";
$dbname = "glpi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT name,serial,contact, COUNT(".$_GET["type"].") AS duplications
FROM `glpi_computers`
WHERE  `glpi_computers`.`is_deleted` = 0 
AND `glpi_computers`.`is_template` = 0 
GROUP BY serial, name 
HAVING duplications > 1;";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $id= 0;
    ?>
<!DOCTYPE html>
<html>
<head>
<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
</head>
<body>

<h2>Duplication Test for <?php echo $_GET["type"] ?></h2>
   
<table>
  <tr>
    <th>Computer</th>
    <th>Serial</th>
    <th>Username</th>
    <th>No Of Duplication</th>
  </tr>


<?php
    // output data of each row
    while($row = $result->fetch_assoc()) {
          echo '<tr>
    <td ><a href="dupliname.php?id='. $row["name"].'">' . $row["name"]. '</a></td>
    <td>' . $row["serial"]. '</td>
    <td>'. $row["contact"].'</td>
    <td> '.$row["duplications"].'</td>
  </tr>';
       $id ++;
    }
    ?>
    </table>
 <h3>Total Duplications <?php echo $id ?> </h3>
</body>
</html>
    <?php
} else {
    echo "0 results";
}
$conn->close();

?>