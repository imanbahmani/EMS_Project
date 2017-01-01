<?php
$con=mysqli_connect("localhost","root","","EMS");
// Check connection
if ($con->connect_error)
{
    die("Connection failed: " . $con->connect_error);
}
mysqli_set_charset($con,"utf8");
