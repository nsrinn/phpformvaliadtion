<?php
$servername = "localhost"; // Replace with your database server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "demo_database"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }
// echo "Connected successfully<br>";

$sql = "CREATE TABLE registration_table (
    id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    gender VARCHAR(50) NOT NULL,
    city  VARCHAR(50) NOT NULL,
    adress  VARCHAR(50) NOT NULL,
    country  VARCHAR(50) NOT NULL,
    subject  VARCHAR(50) NOT NULL,
    message  VARCHAR(50) NOT NULL,
    fileurl  VARCHAR(50) NOT NULL
)";

// if ($conn->query($sql) === TRUE) {
//     echo "Table 'register' created successfully";
// } else {
//     echo "Error creating table: " . $conn->error;
// }





?>

