<?php
// Connection to database
$dbhostname = 'localhost';
$dbdatabase = 'db_form';
$dbuser = 'root';
$dbpass = '';

// Create connection
$conn = new mysqli($dbhostname, $dbuser, $dbpass, $dbdatabase);

// Check connection
if ($conn->connect_error) {
    die("Could not connect to DB Server on $dbhostname: " . $conn->connect_error);
}
?>
