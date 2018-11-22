<?php 

require "config.php";

// Create connection
$conn = mysqli_connect($host, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = file_get_contents('data/init.sql');
$result = mysqli_multi_query($conn, $sql);

if (false === $result) {
  printf("Error: %s\n", mysqli_error($conn));
} else {
  echo "DB and Table successfully created!";
}

mysqli_close($conn);