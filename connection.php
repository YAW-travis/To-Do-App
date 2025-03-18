<?php
// Connection to database
$dbhostname = 'sql5.freesqldatabase.com';
$dbdatabase = 'sql5768343';
$dbuser = 'sql5768343';
$dbpass = 'nxtHTjDmQi';
$Portnumber: '3306';

// Create connection
$conn = new mysqli($dbhostname, $dbuser, $dbpass, $dbdatabase, $Portnumber);

// Check connection
if ($conn->connect_error) {
    die("Could not connect to DB Server on $dbhostname: " . $conn->connect_error);
}
?>