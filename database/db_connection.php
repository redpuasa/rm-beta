<?php
/**
 * Database Connection Page
 * DO NOT EDIT THIS PAGE
 *
 * @author Ammar Rosli
 * @version 1.0
 */
mysqli_report(MYSQLI_REPORT_OFF);
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

// $mysqli_ogpc = new mysqli(DB_HOST, OGPC_DB_USER, OGPC_DB_PASSWORD, OGPC_DB_NAME);

// // Check connection
// if ($mysqli_ogpc -> connect_errno) {
//   echo "Failed to connect to MySQL: " . $mysqli_ogpc -> connect_error;
//   exit();
// }

// $mysqli_ad_request = new mysqli(DB_HOST, OGPC_DB_USER, OGPC_DB_PASSWORD,AD_REQUEST_DB_NAME);

// // Check connection
// if ($mysqli_ad_request -> connect_errno) {
//   echo "Failed to connect to MySQL: " . $mysqli_ogpc -> connect_error;
//   exit();
// }

?>