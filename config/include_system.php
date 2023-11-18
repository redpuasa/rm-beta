<?php
// To prevent form resubmission upon hitting back button
// header("Cache-Control: no cache");
// session_cache_limiter("private_no_expire");

// Name of this session
session_name("risk_management");

// Start the session
session_start();

require_once("config/include_constants.php");
require_once('database/db_connection.php');
require_once('config/include_functions.php');
require_once('src/adLDAP.php');

// Define the global catalog information
$ldap_host = "10.240.64.8";
$ldap_port = 3268;
$ldap_base_dn = "";

// Define the service account username and password
$service_username = AD_SVC_USER;
$service_password = AD_SVC_PASSWORD;

// Define the global catalog information (old)
$ldap_host2 = "10.240.31.90";
$ldap_port2 = 3268;
$ldap_base_dn2 = "";

$sessionTime = 1800; // 30 minutes
if (isset($_SESSION['remember'])) {
  $sessionTime = 43200; // 12 hours
}

if (!isset($_SESSION['CREATED'])) {
  $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > $sessionTime) {
  session_regenerate_id(true);  // change session ID for the current session and invalidate old session ID
  $_SESSION['CREATED'] = time();  // update creation time
}
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $sessionTime)) {
  session_unset();   // unset $_SESSION variable for the run-time 
  session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

// Update user last login to DB
if (isset($_SESSION["loggedIn"])) {
  $timestamp = date('Y-m-d H:i:s');
  $userId = $_SESSION["user_id"];
  $query = "UPDATE users SET lastLogin = '$timestamp' WHERE id = $userId";
  mysqli_query($mysqli, $query);

  // Update user role
  $query = "SELECT users.*, teams.id as teamId, teams.name as teamName, roles.name as roleName FROM users
    INNER JOIN teams ON users.teamId = teams.id
    INNER JOIN roles ON users.roleId = roles.id
    WHERE users.id = $userId";
  $result = mysqli_query($mysqli, $query);
  $row = mysqli_fetch_assoc($result);

  if ($row) {
    // Update these values in sessions
    $_SESSION["teamId"] = $row["teamId"];
    $_SESSION["teamName"] = $row["teamName"];
    $_SESSION["roleId"] = $row["roleId"];
    $_SESSION["roleName"] = $row["roleName"];

    $canLogin = $row["canLogin"];

    $query = "UPDATE users SET canLogin = $canLogin WHERE id = $userId";
    mysqli_query($mysqli, $query);
  }
}
?>