<?php
//DB means Database//
$servername = "localhost";
$DBUsername = "root";
$DBPassword = "";
$DBname = "loginsystem";
$conn = mysqli_connect($servername , $DBUsername , $DBPassword , $DBname);
if (!$conn) {
  die("connection failed : " . mysqli_connect_error());
}
