<?php
$userId = $_SESSION["userId"];

// Get total number of projects
$query = "SELECT COUNT(*) AS totalProjects FROM ";
$query .= isAdmin() || isCloudAdmin() || isReviewer() ? "projects" : "users_projects WHERE userId = $userId";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$totalProjects = $row["totalProjects"];

// $userProjects = NULL;

// if (isTenant()) {
//   // Get user projects and add prefix for sql statement
//   $userProjects = preg_filter('/^/', "projectId = ", getUserProjects($userId));
// }

// Category name and query
$requestType = array(
  "Incident" => "(requests.categoryId = 2)", // all Incident request
  "Service" => "(requests.categoryId = 3)", // all Service request
  "Other" => "(requests.categoryId != 2 AND requests.categoryId != 3)", // all Other request
  "All" => "", //for dashboard all tickets
  "Open" => "(requests.statusId != 8 AND requests.statusId != 10)",
  "OpenIncident" => "(requests.statusId != 8 AND requests.statusId != 10 AND requests.categoryId = 2)",
  "OpenService" => "(requests.statusId != 8 AND requests.statusId != 10 AND requests.categoryId = 3)",
  "OpenOther" => "(requests.statusId != 8 AND requests.statusId != 10 AND requests.categoryId != 2 AND requests.categoryId != 3)",
  "ClosedIncident" => "(requests.statusId = 10 AND requests.categoryId = 2)",
  "ClosedService" => "(requests.statusId = 10 AND requests.categoryId = 3)",
  "ClosedOther" => "(requests.statusId = 10 AND requests.categoryId != 2 AND requests.categoryId != 3)",
  "CompletedIncident" => "(requests.statusId = 9 AND requests.categoryId = 2)",
  "CompletedService" => "(requests.statusId = 9 AND requests.categoryId = 3)",
  "CompletedOther" => "(requests.statusId = 9 AND requests.categoryId != 2 AND requests.categoryId != 3)",
  "StatusQueryIncident" => "(requests.statusId = 3 AND requests.categoryId = 2)",
  "StatusQueryService" => "(requests.statusId = 3 AND requests.categoryId = 3)",
  "StatusQueryOther" => "(requests.statusId = 3 AND requests.categoryId != 2 AND requests.categoryId != 3)",
  "InProgressIncident" => "(requests.statusId = 2 AND requests.categoryId = 2)",
  "InProgressService" => "(requests.statusId = 2 AND requests.categoryId = 3)",
  "InProgressOther" => "(requests.statusId = 2 AND requests.categoryId != 2 AND requests.categoryId != 3)",
  "EscalatedIncident" => "(requests.statusId = 4 AND requests.categoryId = 2)",
  "EscalatedService" => "(requests.statusId = 4 AND requests.categoryId = 3)",
  "EscalatedOther" => "(requests.statusId = 4 AND requests.categoryId != 2 AND requests.categoryId != 3)",
  "PendingIncident" => "(requests.statusId = 0 AND requests.categoryId = 2)",
  "PendingService" => "(requests.statusId = 0 AND requests.categoryId = 3)",
  "PendingOther" => "(requests.statusId = 0 AND requests.categoryId != 2 AND requests.categoryId != 3)",
  "CancelledIncident" => "(requests.statusId = 8 AND requests.categoryId = 2)",
  "CancelledService" => "(requests.statusId = 8 AND requests.categoryId = 3)",
  "CancelledOther" => "(requests.statusId = 8 AND requests.categoryId != 2 AND requests.categoryId != 3)"
);

// Get the project's requests
foreach ($requestType as $categoryName => $categoryQuery) {
  $query = "SELECT COUNT(DISTINCT(requests.id)) AS totalRequests
	  FROM requests
	  LEFT JOIN tickets_assignments ON requests.id = tickets_assignments.requestId AND requests.teamId != " . $_SESSION["teamId"] . "
	  ";
  $query .= isSuperAdmin() || isServiceDeskManager() || isReviewer() ? "" : "WHERE (requests.teamId = " . $_SESSION["teamId"] . " OR FIND_IN_SET('" . $_SESSION['teamId'] . "', teamIds) > 0)"; // isSuperAdmin replaced to isAdmin
  // $query .= isAdmin() || isReviewer() ? "" : " (" . implode(" OR ", $userProjects) . ") AND";
  if($categoryName != "All") {
    $query .= isSuperAdmin() || isServiceDeskManager() || isReviewer() ? "WHERE " . $categoryQuery : "AND " . $categoryQuery;
  }
  $query .= isServiceDeskTeam() ? " AND (requests.categoryId = 2 OR requests.categoryId = 3)" : "";

  $result = mysqli_query($mysqli, $query);
  $row = mysqli_fetch_assoc($result);
  ${"total" . $categoryName . "Requests"} = $row["totalRequests"];
}

// Ticket name and query
$ticketType = array(
  "DueSoon" => "((priorityId = 1 AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) > (day - 3) AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) < day) OR (priorityId = 2 AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) > (day - 3) AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) < day) 
  OR (priorityId = 3 AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) > (day - 1) AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) < day)) AND requests.statusId != 8 AND requests.statusId != 10",
  "DueToday" => "((priorityId = 1 AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) = day) OR (priorityId = 2 AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) = day) 
  OR (priorityId = 3 AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) = day) OR (priorityId = 4 AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) = day)) AND requests.statusId != 8 AND requests.statusId != 10",
  "Overdue" => "((priorityId = 1 AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) > day) OR (priorityId = 2 AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) > day) 
  OR (priorityId = 3 AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) > day) OR (priorityId = 4 AND DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) > day)) AND requests.statusId != 8 AND requests.statusId != 10"
);

// Get tickets
foreach ($ticketType as $ticketName => $ticketQuery) {
  $query = "SELECT COUNT(*) AS totalTickets FROM (SELECT DISTINCT requests.id, request_priorities.`day` AS `day`
    FROM requests
    INNER JOIN request_priorities ON request_priorities.id = requests.priorityId 
    LEFT JOIN tickets_assignments ON requests.id = tickets_assignments.requestId
    WHERE ";
  $query .= isSuperAdmin() || isServiceDeskManager() || isReviewer() ? "" : "(requests.teamId = " . $_SESSION["teamId"] . " OR FIND_IN_SET('" . $_SESSION['teamId'] . "', teamIds) > 0) AND "; // isSuperAdmin replaced to isAdmin
  $query .= $ticketQuery;
  if (CURRENT_PAGE == NULL || CURRENT_PAGE == INDEX_PAGE || CURRENT_PAGE == "portal"){

  } else {
    if ($_GET["category"] == "incident") {
      $query .= " AND requests.categoryId = 2";
    } else if ($_GET["category"] == "serviceRequest") {
      $query .= " AND requests.categoryId = 3";
    } else if ($_GET["category"] == "others") {
      $query .= " AND requests.categoryId != 2 AND requests.categoryId != 3";
    } else {
   
    }
  }
  $result = mysqli_query($mysqli, $query);
  $row = mysqli_fetch_assoc($result);
  ${"totalTickets" . $ticketName} = $row["totalTickets"];
}

// Get total number of VMs
$query = "SELECT COUNT(*) AS totalVMs FROM resources WHERE categoryId = 1";
// $query .= isAdmin() || isReviewer() ? "" : " AND (" . implode(" OR ", $userProjects) . ")";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$totalVMs = $row["totalVMs"];

// Get total number of ODBs
$query = "SELECT COUNT(*) AS totalODBs FROM resources WHERE categoryId != 1";
// $query .= isAdmin() || isReviewer() ? "" : " AND (" . implode(" OR ", $userProjects) . ")";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$totalODBs = $row["totalODBs"];

// Get total number of IPs
$query = "SELECT COUNT(*) AS totalIPs FROM ip_addresses";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$totalIPs = $row["totalIPs"];

// Get total number of users
$query = "SELECT COUNT(*) AS totalUsers FROM users";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$totalUsers = $row["totalUsers"];

// Get total number of links
$query = "SELECT COUNT(*) AS totalLinks FROM links";
$query .= isAdmin() || isReviewer() ? "" : " WHERE tags LIKE '%tenant%'";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$totalLinks = $row["totalLinks"];

// Get total number of guides
$query = "SELECT COUNT(*) AS totalGuides FROM guides";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);
$totalGuides = $row["totalGuides"];

//Get total number of Pending project requests
$query = "SELECT COUNT(*) as totalPendingApproval FROM ogpc_project_approval WHERE statusId = 1";
$result = mysqli_query($mysqli_ogpc, $query);
$row = mysqli_fetch_assoc($result);
$totalPendingApproval = $row["totalPendingApproval"];

//Get total number of Approved project requests
$query = "SELECT COUNT(*) as totalApprovedProject FROM ogpc_project_approval WHERE statusId = 2";
$result = mysqli_query($mysqli_ogpc, $query);
$row = mysqli_fetch_assoc($result);
$totalApprovedProject = $row["totalApprovedProject"];

//Get total number of Rejected project requests
$query = "SELECT COUNT(*) as totalRejectedProject FROM ogpc_project_approval WHERE statusId = 3";
$result = mysqli_query($mysqli_ogpc, $query);
$row = mysqli_fetch_assoc($result);
$totalRejectedProject = $row["totalRejectedProject"];


// Variables
$showAlert = false;
$alertMessage = "";

// Check if form submitted
if (isset($_POST["submitTicket"])) {
  $fieldNames = [];
  $fieldValues = [];

  foreach (array_keys($_POST) as $fieldName) {
    if ($fieldName == "submitTicket" || $fieldName == "files") {
    } else { // ignore the submit field
      // ${$fieldName} = NULL; // create a new variable name
      $fieldValue = mysqli_real_escape_string($mysqli, $_POST[$fieldName]); // assign variable name with value
      $fieldValue = preg_replace('/[\x{200B}-\x{200D}]/u', '', $fieldValue);
      // Ignore empty fields
      if ($fieldValue == "") {
        continue;
      }
      // Boolean check
      if ($fieldValue == "on") { // checkbox ticked
        $fieldValue = 1;
      }

      // Add to array
      $fieldNames[] = $fieldName;
      $fieldValues[] = "'" . $fieldValue . "'";
    }
  }

  // Query
  $query = "INSERT INTO requests (" . implode(", ", $fieldNames) . ") VALUES (" . implode(", ", $fieldValues) . ")";

  if ($mysqli->query($query) === TRUE) {
    $latestId = mysqli_insert_id($mysqli);

    //get the team email for the selected service
    $sql = "SELECT teams.name AS teamName, teams.email AS teamEmail, services.name AS serviceName, teams.id AS teamId FROM services INNER JOIN teams ON teams.id = services.teamId WHERE services.id = " . $_POST["serviceId"];
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);
    $teamName = $row["teamName"];
    $teamId = $row["teamId"];
    $teamEmail = $row["teamEmail"];
    $services = $row["serviceName"];

    $title = $_POST["title"];

    //the get the ticket reference
    $sql = "SELECT requests.*,  request_categories.code AS categoryCode, ministries.name AS ministryName FROM requests
    INNER JOIN request_categories ON requests.categoryId = request_categories.id
    LEFT JOIN ministries ON requests.requestorMinistryId = ministries.id
    WHERE requests.id = $latestId";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result); // get the only row result
    $requestorName = $row["requestorName"];
    $requestorMinistry = $row["ministryName"];
    $requestorDepartment = $row["requestorDepartment"];

    //ticket reference
    $ticket = $row["categoryCode"] . "-" . date('Ymd', strtotime($row["createdAt"])) . "-" . $row["id"];

    // Query
    $query = "INSERT INTO request_activities (description, requestId, userId, statusId) VALUES ('Status updated to: Assigned to $teamName', '$latestId', " . $_POST["userId"] . ", '4');\n";
    $query .= "UPDATE requests SET teamIds = " . $teamId . ", statusId = '4', updateUserId = " . $_POST["userId"] . " WHERE id = $latestId;\n";
    $query .= "INSERT INTO tickets_assignments (requestId, teamId) VALUES ('$latestId', " . $teamId . ");";

    if ($mysqli->multi_query($query)) {
      //email the assigned team
      emailed($teamName, $teamEmail, $ticket, $title, $requestorName, $requestorMinistry, $requestorDepartment, 1, $services, $latestId);

      // variables
      //$reference = "SC-".date('Ymd')."-".mysqli_insert_id($mysqli);

      // Mail it
      emailed($_SESSION["name"], $_SESSION["email"], $ticket, $_POST["title"], $requestorName, $requestorMinistry, $requestorDepartment, 0, $services, $latestId);
      // echo "Email sent";
      $_SESSION['createNew'] = "  <h5> Success!</h5>
      Request <strong>" . $_POST["title"] . "</strong> has been successfully recorded.";
      echo "<script>window.location = '" . REQUEST_PAGE . "?id=" . $latestId . "'</script>";
    }
  } else {
    $_SESSION['unsuccessful'] = "  <h5> Alert!</h5>
      SQL statement: " . $query . "<br />Error: " . $mysqli->error;
  }
} else if (isset($_POST["search"])) {
  $search = $_POST["search"];
  header("Location: " . REQUESTS_PAGE . "?search=" . $search);
}



?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo PORTAL_NAME . " &bull; " . PAGE_NAME; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-colreorder/css/colReorder.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-fixedheader/css/fixedHeader.bootstrap4.min.css">
  <!-- Ion Slider -->
  <link rel="stylesheet" href="plugins/ion-rangeslider/css/ion.rangeSlider.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="./plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="./plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/theme.css">
  <!-- Google Font: Rubik -->
  <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,400i,700" rel="stylesheet">
  <!-- Favicon -->
  <link rel="icon" type="image/png" href="favicon.png">

  <style>
    .image-wrapper img {
      width: 100% !important;
      height: auto;
    }

    .bg-gray-lighter {
      background-color: #e7e7e7;
      color: #555;
    }

    .bg-egnc {
      background-color: #1f4782;
    }

    .sidebar-dark-primary {
      /* background-color: #1f4782; */
      background-image: linear-gradient(#1f4782, #1a5b50);
    }

    .layout-navbar .wrapper .sidebar-dark-primary .brand-link:not([class*="navbar"]) {
      background-color: transparent;
    }

    .dark-mode .sidebar-dark-primary {
      /* background-color: #343a40; */
      background-image: linear-gradient(#1f4782, #343a40);
    }

    .layout-navbar .dark-mode .wrapper .sidebar-dark-primary .brand-link:not([class*="navbar"]) {
      /* background-color: #343a40; */
      background-image: linear-gradient(#1f4782, #343a40);
    }

    .layout-navbar .wrapper .brand-link,
    .layout-navbar.sidebar-mini.sidebar-collapse.text-sm .wrapper .brand-link,
    .layout-navbar.sidebar-mini-md.sidebar-collapse.text-sm .wrapper .brand-link,
    .layout-navbar.sidebar-mini-xs.sidebar-collapse.text-sm .wrapper .brand-link {
      height: 70px;
    }

    .brand-link.text-sm .brand-image-xs,
    .text-sm .brand-link .brand-image-xs,
    .brand-link.text-sm .brand-image-xl,
    .text-sm .brand-link .brand-image-xl {
      margin-top: -0.2rem;
      max-height: 48px;
    }

    .layout-navbar.layout-fixed.text-sm .wrapper .sidebar {
      /* margin-top: 70px; */
      padding-bottom: 40px;
    }

    .logo-xs.brand-image-xs,
    .logo-xl.brand-image-xs,
    .logo-xs.brand-image-xl {
      left: 12px;
      top: 13px;
    }

    .user-panel .info {
      padding: 5px 10px;
      display: block;
    }

    .scroll {
      overflow-x: scroll;
    }

    .scroll::-webkit-scrollbar {
      display: none;
    }

    .btn-link:hover {
      color: red;
    }

    /* Modal background */
    .modal-body {
      background-color: #f4f6f9;
    }

    .dark-mode .modal-body {
      background-color: #454d55;
    }

    /* Messages */
    .direct-chat-messages {
      height: 400px;
    }

    <?php if (ltrim(parse_url(CURRENT_PAGE, PHP_URL_PATH), '/') == PROJECT_PAGE) { ?>

    /* Start here */
    /* Checkbox */
    .form-check-input {
      clear: left;
    }

    .form-check-label {
      margin-left: 0.25em;
      padding: 0.25rem;
    }

    .form-switch.form-switch-sm {
      margin-bottom: 0.5rem;
      /* JUST FOR STYLING PURPOSE */
    }

    .form-switch.form-switch-sm .form-check-input {
      height: 1rem;
      width: calc(1rem + 0.75rem);
      border-radius: 2rem;
    }

    .form-switch.form-switch-md .form-check-input {
      height: 1.5rem;
      width: calc(2rem + 0.75rem);
      border-radius: 3rem;
    }

    .form-switch.form-switch-lg {
      margin-bottom: 1.5rem;
      /* JUST FOR STYLING PURPOSE */
    }

    .form-switch.form-switch-lg .form-check-input {
      height: 2rem;
      width: calc(3rem + 0.75rem);
      border-radius: 4rem;
    }

    .form-switch.form-switch-xl {
      margin-bottom: 2rem;
      /* JUST FOR STYLING PURPOSE */
    }

    .form-switch.form-switch-xl .form-check-input {
      height: 2.5rem;
      width: calc(4rem + 0.75rem);
      border-radius: 5rem;
    }

    .tab {
      overflow: hidden;
      background-color: white;
    }

    .tab button {
      background-color: #E9ECEF;
      float: left;
      border: none;
      outline: none;
      cursor: pointer;
      padding: 10px 12px;
      transition: 0.3s;
      color: black;
      width: 50%;
      border-radius: 20px 20px 0px 0px;
      /* box-shadow: 8px 2px 8px 0px rgba(0,0,0,0.2); */
      border-top: 1px solid #ccc;
      border-left: 1px solid #ccc;
      border-right: 1px solid #ccc;
      position: relative;
    }

    .tab button:hover {
      background-color: #1f4782;
      color: white;
    }

    .tab button.active {
      background-color: #1f4782;
      color: white;
    }

    .tabcontent {
      display: none;
      padding: 20px;
      border-top: 1px solid #ccc;
      box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2);
      border-radius: 0px 0px 15px 15px;
    }

    #box {
      padding-left: 20px;
      padding-right: 20px;
    }

    #declare1,
    #declare2,
    #declare3,
    #declare4 {
      margin-left: 20px;
    }

    #submit {
      background-color: #bdbdbd;
      border: white;
    }


    #summary {
      margin-top: 3px;
    }

    #application {
      box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2);
      padding: 20px 20px 20px 20px;
      margin-bottom: 20px;
      border-radius: 10px 10px 10px 10px;
    }

    #prev {
      padding: 5px 5px 5px 5px;
      border-radius: 5px 5px 5px 5px;
      margin-left: 2px;
      background-color: #E9ECEF;
      cursor: pointer;
      transition: 0.5s;
      padding: 5px 10px 5px 10px;
      float: left;
    }

    #next {
      padding: 5px 5px 5px 5px;
      box-shadow: 0px 4px 8px 0px rgba(0, 0, 0, 0.2);
      border-radius: 5px 5px 5px 5px;
      margin-left: 2px;
      background-color: #1f4782;
      cursor: pointer;

      padding: 5px 10px 5px 10px;
      float: right;
      color: white;
    }

    #prev:hover,
    #next:hover {
      background-color: white;
      color: black;
    }

    #tabfooter {
      border-radius: 0px 0px 15px 15px;
      background-color: #E9ECEF;
      padding: 10px 20px 10px 20px;
      border-top: 1px solid #ccc;
      overflow: hidden;
    }

    <?php } ?>
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar text-sm">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="img/header_logo_dark.png" alt="EGNC Logo" height="60">
    </div> -->

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo INDEX_PAGE; ?>" class="nav-link">Home</a>
        </li>
        <?php if (isSuperAdmin()) { // isSuperAdmin replaced to isAdmin 
        ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Help
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
              <a class="dropdown-item" href="#">FAQ</a>
              <a class="dropdown-item" href="#">Support</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Contact</a>
            </div>
          </li>
        <?php } ?>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline" method="post" action=<?php echo REQUESTS_PAGE ?>>
              <div class="input-group input-group-sm">
                <input name="search" class="form-control form-control-navbar" type="search" placeholder="Search ticket reference" required>
                <div class="input-group-append">
                  <button name="searchTicket" class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="https://i.pravatar.cc/150?img=1" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="https://i.pravatar.cc/150?img=2" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <!-- Message Start -->
              <div class="media">
                <img src="https://i.pravatar.cc/150?img=3" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              <!-- Message End -->
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        </li>

        <?php
        $totalNotifications = 0;

        if ($totalTicketsDueToday > 0) {
          $totalNotifications++;
        }
        if ($totalTicketsOverdue > 0) {
          $totalNotifications++;
        }
        if ($totalCompletedIncidentRequests > 0 || $totalCompletedServiceRequests > 0 || $totalCompletedOtherRequests > 0) {
          $totalNotifications++;
        }
        if ($totalStatusQueryIncidentRequests > 0 || $totalStatusQueryServiceRequests > 0 || $totalStatusQueryOtherRequests > 0) {
          $totalNotifications++;
        }
        if ($totalInProgressIncidentRequests > 0 || $totalInProgressServiceRequests > 0 || $totalInProgressOtherRequests > 0) {
          $totalNotifications++;
        }
        if ($totalEscalatedIncidentRequests > 0 || $totalEscalatedServiceRequests > 0 || $totalEscalatedOtherRequests > 0) {
          $totalNotifications++;
        }
        if ($totalPendingIncidentRequests > 0 || $totalPendingServiceRequests > 0 || $totalPendingOtherRequests > 0) {
          $totalNotifications++;
        }

        if ($totalNotifications > 0) {
        ?>
          <!-- Notifications Dropdown Menu -->
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="far fa-bell"></i>
              <span class="badge badge-warning navbar-badge"><?php echo $totalNotifications; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header"><?php echo $totalNotifications . " Notification" . ($totalNotifications > 1 ? "s" : ""); ?></span>
              <?php if ($totalEscalatedIncidentRequests > 0 || $totalEscalatedServiceRequests > 0  || $totalEscalatedOtherRequests > 0) { ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo REQUESTS_PAGE . "?status=escalated"; ?>" class="dropdown-item">
                  <i class="fas fa-exclamation mr-2"></i> <?php echo $totalEscalatedIncidentRequests + $totalEscalatedServiceRequests + $totalEscalatedOtherRequests . " ticket" . ($totalEscalatedIncidentRequests + $totalEscalatedServiceRequests + $totalEscalatedOtherRequests > 1 ? "s" : ""); ?> escalated
                </a>
              <?php }
              if ($totalInProgressIncidentRequests > 0 || $totalInProgressServiceRequests > 0 || $totalInProgressOtherRequests > 0) { ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo REQUESTS_PAGE . "?status=inProgress"; ?>" class="dropdown-item">
                  <i class="fas fa-exclamation mr-2"></i> <?php echo $totalInProgressIncidentRequests + $totalInProgressServiceRequests + $totalInProgressOtherRequests . " ticket" . ($totalInProgressIncidentRequests + $totalInProgressServiceRequests + $totalInProgressOtherRequests > 1 ? "s" : ""); ?> in progress
                </a>
              <?php }
              if ($totalStatusQueryIncidentRequests > 0 || $totalStatusQueryServiceRequests > 0 || $totalStatusQueryOtherRequests > 0) { ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo REQUESTS_PAGE . "?status=statusQuery"; ?>" class="dropdown-item">
                  <i class="fas fa-exclamation mr-2"></i> <?php echo $totalStatusQueryIncidentRequests + $totalStatusQueryServiceRequests + $totalStatusQueryOtherRequests . " ticket" . ($totalStatusQueryIncidentRequests + $totalStatusQueryServiceRequests + $totalStatusQueryOtherRequests > 1 ? "s" : ""); ?> status query
                </a>
              <?php }
              if ($totalCompletedIncidentRequests > 0 || $totalCompletedServiceRequests > 0 || $totalCompletedOtherRequests > 0) { ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo REQUESTS_PAGE . "?status=completed"; ?>" class="dropdown-item">
                  <i class="fas fa-exclamation mr-2"></i> <?php echo $totalCompletedIncidentRequests + $totalCompletedServiceRequests + $totalCompletedOtherRequests . " ticket" . ($totalCompletedIncidentRequests + $totalCompletedServiceRequests + $totalCompletedOtherRequests > 1 ? "s" : ""); ?> completed
                </a>
              <?php }
              if ($totalPendingIncidentRequests > 0 || $totalPendingServiceRequests > 0 || $totalPendingOtherRequests > 0) { ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo REQUESTS_PAGE . "?status=pending"; ?>" class="dropdown-item">
                  <i class="fas fa-exclamation mr-2"></i> <?php echo $totalPendingIncidentRequests + $totalPendingServiceRequests + $totalPendingOtherRequests . " ticket" . ($totalPendingIncidentRequests + $totalPendingServiceRequests + $totalPendingOtherRequests > 1 ? "s" : ""); ?> pending
                </a>
              <?php }
              if ($totalTicketsDueToday > 0) { ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo REQUESTS_PAGE . "?status=duetoday"; ?>" class="dropdown-item">
                  <i class="fas fa-exclamation mr-2"></i> <?php echo $totalTicketsDueToday . " ticket" . ($totalTicketsDueToday > 1 ? "s" : ""); ?> due today
                  <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
                </a>
              <?php }
              if ($totalTicketsOverdue > 0) { ?>
                <div class="dropdown-divider"></div>
                <a href="<?php echo REQUESTS_PAGE . "?status=overdue&category=" . $_GET["category"]; ?>" class="dropdown-item">
                  <i class="fas fa-exclamation mr-2"></i> <?php echo $totalTicketsOverdue . " ticket" . ($totalTicketsOverdue > 1 ? "s" : ""); ?> overdue
                  <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
                </a>
                <!-- <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> -->
              <?php } ?>
            </div>
          </li>
        <?php } ?>

        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>

        <!-- Dark mode button -->
        <li class="nav-item">
          <button type="button" class="btn btn-block btn-outline-primary btn-xs">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input" id="darkSwitch">
              <label class="custom-control-label" style="padding-top: 2px;" for="darkSwitch">Dark Mode</label>
            </div>
          </button>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?php echo INDEX_PAGE; ?>" class="brand-link logo-switch">
        <img src="img/header_logo_small.png" alt="<?php echo PORTAL_NAME; ?> Logo Small" class="brand-image-xl logo-xs">
        <img src="img/header_logo_light.png" alt="<?php echo PORTAL_NAME; ?> Logo Large" class="brand-image-xs logo-xl">
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3">
          <div class="info">
            <a href="<?php echo USER_PAGE; ?>?id=<?php echo $_SESSION["userId"]; ?>" class="d-block text-wrap"><?php echo $_SESSION["name"]; ?></a>
            <span class="badge bg-lightblue text-wrap"><?php echo $_SESSION["teamName"]; ?></span><br />
            <span class="badge bg-olive text-wrap"><?php echo $_SESSION["roleName"]; ?></span>
          </div>
          <div class="info mt-1">
            <div class="row">
              <div class="col-6">
                <a href="<?php echo LOCKSCREEN_PAGE; ?>"><button type="button" class="btn btn-block btn-outline-light btn-sm"><i class="fas fa-lock mr-1"></i> Lock</button></a>
              </div>
              <div class="col-6">
                <a href="<?php echo LOGOUT_PAGE; ?>"><button type="button" class="btn btn-block btn-outline-light btn-sm"><i class="fas fa-power-off mr-1"></i> Logout</button></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <?php if (!isTenant()) { ?>
            <li class="nav-header">MENU</li>
            <li class="nav-item">
              <a href="<?php echo INDEX_PAGE; ?>" class="nav-link<?php if (CURRENT_PAGE == INDEX_PAGE) echo " active"; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
              </a>
            </li>

            <?php
            $sectionPages = [REQUEST_PAGE . "?category=incident", REQUESTS_PAGE . "?status=open&category=incident", REQUESTS_PAGE . "?status=escalated&category=incident", REQUESTS_PAGE . "?status=inProgress&category=incident", REQUESTS_PAGE . "?status=statusQuery&category=incident", REQUESTS_PAGE . "?status=pending&category=incident", REQUESTS_PAGE . "?status=completed&category=incident", REQUESTS_PAGE . "?status=cancelled&category=incident", REQUESTS_PAGE . "?status=closed&category=incident", REQUESTS_PAGE . "?category=incident"];
            $sectionPages2 = [REQUESTS_PAGE . "?category=serviceRequest", REQUESTS_PAGE . "?status=open&category=serviceRequest", REQUESTS_PAGE . "?status=escalated&category=serviceRequest", REQUESTS_PAGE . "?status=inProgress&category=serviceRequest", REQUESTS_PAGE . "?status=statusQuery&category=serviceRequest", REQUESTS_PAGE . "?status=pending&category=serviceRequest", REQUESTS_PAGE . "?status=completed&category=serviceRequest", REQUESTS_PAGE . "?status=cancelled&category=serviceRequest", REQUESTS_PAGE . "?status=closed&category=serviceRequest", REQUESTS_PAGE .  "?category=serviceRequest"];
            $sectionPages3 = [REQUESTS_PAGE . "?category=others", REQUESTS_PAGE . "?status=open&category=others", REQUESTS_PAGE . "?status=escalated&category=others", REQUESTS_PAGE . "?status=inProgress&category=others", REQUESTS_PAGE . "?status=statusQuery&category=others", REQUESTS_PAGE . "?status=pending&category=others", REQUESTS_PAGE . "?status=completed&category=others", REQUESTS_PAGE . "?status=cancelled&category=others", REQUESTS_PAGE . "?status=closed&category=others", REQUESTS_PAGE .  "?category=others"];
            $sectionPages4 = [PROJECT_REQUEST . "?statusId=1", PROJECT_REQUEST . "?statusId=2", PROJECT_REQUEST . "?statusId=3"];
            ?>
            <li class="nav-item has-treeview<?php if (in_array(CURRENT_PAGE, $sectionPages, TRUE) || in_array(CURRENT_PAGE, $sectionPages2, TRUE) || in_array(CURRENT_PAGE, $sectionPages3, TRUE)) echo " menu-open"; ?>">
              <a href="#" class="nav-link <?php if (in_array(CURRENT_PAGE, $sectionPages, TRUE) || in_array(CURRENT_PAGE, $sectionPages2, TRUE) || in_array(CURRENT_PAGE, $sectionPages3, TRUE)) echo " active"; ?>">
                <i class="nav-icon fas fa-file-contract"></i>
                <p>
                  Tickets
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                
                <?php if (isServiceDeskManager() || isServiceDeskTeam() || isSuperAdmin()) { ?>
                  <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" data-toggle="modal" data-target="#modal-add-ticket">
                      <i class="nav-icon fas fa-plus"></i>
                      <p>
                        Add Ticket
                      </p>
                    </a>
                  </li>
                <?php } ?>
                <li class="nav-item has-treeview<?php if (in_array(CURRENT_PAGE, $sectionPages, TRUE)) echo " menu-open"; ?>">
                  <a href="#" class="nav-link <?php if (in_array(CURRENT_PAGE, $sectionPages, TRUE)) echo " active"; ?>">
                    <i class="nav-icon fas fa-file-contract"></i>
                    <p>
                      Incident
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[1]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[1]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Open
                          <span class="badge badge-secondary right"><?php echo number_format($totalOpenIncidentRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[2]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[2]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Escalated
                          <span class="badge badge-secondary right"><?php echo number_format($totalEscalatedIncidentRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[3]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[3]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          In Progress
                          <span class="badge badge-secondary right"><?php echo number_format($totalInProgressIncidentRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[4]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[4]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Status Query
                          <span class="badge badge-secondary right"><?php echo number_format($totalStatusQueryIncidentRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[5]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[5]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Pending
                          <span class="badge badge-secondary right"><?php echo number_format($totalPendingIncidentRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[6]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[6]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Completed
                          <span class="badge badge-secondary right"><?php echo number_format($totalCompletedIncidentRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[7]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[7]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Cancelled
                          <span class="badge badge-secondary right"><?php echo number_format($totalCancelledIncidentRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[8]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[8]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Closed
                          <span class="badge badge-secondary right"><?php echo number_format($totalClosedIncidentRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[9]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[9]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          All
                          <span class="badge badge-secondary right"><?php echo number_format($totalIncidentRequests); ?></span>
                        </p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item has-treeview<?php if (in_array(CURRENT_PAGE, $sectionPages2, TRUE)) echo " menu-open"; ?>">
                  <a href="#" class="nav-link <?php if (in_array(CURRENT_PAGE, $sectionPages2, TRUE)) echo " active"; ?>">
                    <i class="nav-icon fas fa-file-contract"></i>
                    <p>
                      Service request
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages2[1]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages2[1]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Open
                          <span class="badge badge-secondary right"><?php echo number_format($totalOpenServiceRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages2[2]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages2[2]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Escalated
                          <span class="badge badge-secondary right"><?php echo number_format($totalEscalatedServiceRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages2[3]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages2[3]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          In Progress
                          <span class="badge badge-secondary right"><?php echo number_format($totalInProgressServiceRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages2[4]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages2[4]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Status Query
                          <span class="badge badge-secondary right"><?php echo number_format($totalStatusQueryServiceRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages2[5]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages2[5]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Pending
                          <span class="badge badge-secondary right"><?php echo number_format($totalPendingServiceRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages2[6]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages2[6]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Completed
                          <span class="badge badge-secondary right"><?php echo number_format($totalCompletedServiceRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages2[7]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages2[7]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Cancelled
                          <span class="badge badge-secondary right"><?php echo number_format($totalCancelledServiceRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages2[8]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages2[8]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Closed
                          <span class="badge badge-secondary right"><?php echo number_format($totalClosedServiceRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages2[9]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages2[9]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          All
                          <span class="badge badge-secondary right"><?php echo number_format($totalServiceRequests); ?></span>
                        </p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="nav-item has-treeview<?php if (in_array(CURRENT_PAGE, $sectionPages3, TRUE)) echo " menu-open"; ?>">
                  <a href="#" class="nav-link <?php if (in_array(CURRENT_PAGE, $sectionPages3, TRUE)) echo " active"; ?>">
                    <i class="nav-icon fas fa-file-contract"></i>
                    <p>
                      Others
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages3[1]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages3[1]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Open
                          <span class="badge badge-secondary right"><?php echo number_format($totalOpenOtherRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages3[2]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages3[2]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Escalated
                          <span class="badge badge-secondary right"><?php echo number_format($totalEscalatedOtherRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages3[3]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages3[3]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          In Progress
                          <span class="badge badge-secondary right"><?php echo number_format($totalInProgressOtherRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages3[4]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages3[4]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Status Query
                          <span class="badge badge-secondary right"><?php echo number_format($totalStatusQueryOtherRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages3[5]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages3[5]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Pending
                          <span class="badge badge-secondary right"><?php echo number_format($totalPendingOtherRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages3[6]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages3[6]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Completed
                          <span class="badge badge-secondary right"><?php echo number_format($totalCompletedOtherRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages3[7]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages3[7]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Cancelled
                          <span class="badge badge-secondary right"><?php echo number_format($totalCancelledOtherRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages3[8]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages3[8]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Closed
                          <span class="badge badge-secondary right"><?php echo number_format($totalClosedOtherRequests); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages3[9]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages3[9]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          All
                          <span class="badge badge-secondary right"><?php echo number_format($totalOtherRequests); ?></span>
                        </p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
            <?php } ?>
                  
              <?php  
              $sessionTeam = $_SESSION["teamId"];

              
              if ( $sessionTeam == "6" ||  $sessionTeam == "8" ||  $sessionTeam == "9" || isServiceDeskManager() || isServiceDeskTeam() || isSuperAdmin()) { 
                
                $sectionPages = [FORM_REQUESTS_PAGE . "?formType=cwh", FORM_REQUESTS_PAGE . "?formType=cip", FORM_REQUESTS_PAGE . "?formType=vpn", FORM_REQUESTS_PAGE . "?formType=rff"];
                ?>
                <li class="nav-header">FORMS</li>
                <li class="nav-item has-treeview<?php if (in_array(CURRENT_PAGE, $sectionPages, TRUE) || strpos(implode(" ", $sectionPages), strtok(CURRENT_PAGE, "?")) !== false) echo " menu-open"; ?>">
                  <a href="#" class="nav-link<?php if (in_array(CURRENT_PAGE, $sectionPages, TRUE) || strpos(implode(" ", $sectionPages), strtok(CURRENT_PAGE, "?")) !== false) echo " active"; ?>">
                    <i class="nav-icon fas fa-folder"></i>
                    <p>
                      Form Requests
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  
                  <ul class="nav nav-treeview">
                  <?php if ($sessionTeam == "8" || isServiceDeskManager() || isServiceDeskTeam() || isSuperAdmin()) { ?>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[0]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[0] || strpos(CURRENT_PAGE, $sectionPages[0]) !== false) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Central Web Hosting
                        </p>
                      </a>
                    </li>
                  <?php } ?>
                  <?php if ($sessionTeam == "9" || isServiceDeskManager() || isServiceDeskTeam() || isSuperAdmin()) { ?>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[1]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[1] || strpos(CURRENT_PAGE, $sectionPages[1]) !== false) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Central Intranet Platform
                        </p>
                      </a>
                    </li>
                    <?php } ?>
                    <?php if ($sessionTeam == "6" || isServiceDeskManager() || isServiceDeskTeam() || isSuperAdmin()) { ?>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[2]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[2] || strpos(CURRENT_PAGE, $sectionPages[2]) !== false) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          VPN Account
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[3]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[3] || strpos(CURRENT_PAGE, $sectionPages[3]) !== false) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Routing/Firewall Rule-set
                        </p>
                      </a>
                    </li>
                    <?php } ?>
                  </ul>
                </li>
                <?php } ?>
            <?php
            // Check if current page is the exportable requests
            if (strpos(CURRENT_PAGE, REQUESTS_EXPORTABLE_PAGE) !== false) {
            ?>
              <li class="nav-item">
                <a href="<?php echo CURRENT_PAGE; ?>" class="nav-link<?php if (CURRENT_PAGE == CURRENT_PAGE) echo " active"; ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Exportable Tickets</p>
                </a>
              </li>
          
                <?php } if (isAdmin() || isCloudAdmin() || isReviewer() || isTenant()) { ?>
              <li class="nav-header">CLOUD</li>
              <li class="nav-item">
                <a href="<?php echo PROJECTS_PAGE; ?>" class="nav-link<?php if (CURRENT_PAGE == PROJECTS_PAGE || CURRENT_PAGE == PROJECTS_EXPORTABLE_PAGE) echo " active"; ?>">
                  <i class="nav-icon fas fa-tasks"></i>
                  <p>
                    Projects
                    <span class="badge badge-secondary right"><?php echo number_format($totalProjects); ?></span>
                  </p>
                </a>
              </li>
              <?php if (isAdmin() || isCloudAdmin() || isReviewer()) { ?>
                <li class="nav-item has-treeview<?php if (in_array(CURRENT_PAGE, $sectionPages4, TRUE)) echo " menu-open"; ?>">
                  <a href="#" class="nav-link <?php if (in_array(CURRENT_PAGE, $sectionPages4, TRUE)) echo " active"; ?>">
                    <i class="nav-icon fas fa-file-signature"></i>
                    <p>
                      Project Requests
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <li class="nav-item">
                      <a href="<?php echo PROJECT_REQUEST; ?>?statusId=1" class="nav-link<?php if (CURRENT_PAGE == $sectionPages4[0]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Awaiting Approval
                          <span class="badge badge-secondary right"><?php echo number_format($totalPendingApproval); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo PROJECT_REQUEST; ?>?statusId=2" class="nav-link<?php if (CURRENT_PAGE == $sectionPages4[1]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Approved
                          <span class="badge badge-secondary right"><?php echo number_format($totalApprovedProject); ?></span>
                        </p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="<?php echo PROJECT_REQUEST; ?>?statusId=3" class="nav-link<?php if (CURRENT_PAGE == $sectionPages4[2]) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                          Rejected
                          <span class="badge badge-secondary right"><?php echo number_format($totalRejectedProject); ?></span>
                        </p>
                      </a>
                    </li>
                  </ul>
                </li>
              <?php } ?>

              <li class="nav-item">
                <a href="<?php echo RESOURCE_REQUESTS; ?>" class="nav-link<?php if (CURRENT_PAGE == RESOURCE_REQUESTS) echo " active"; ?>">
                  <i class="nav-icon fas fa-server"></i>
                  <p>Resource Requests</p>
                </a>
              </li>
              <?php
              // Check if current page is the project details
              if (strpos(CURRENT_PAGE, PROJECT_PAGE) !== false) {
              ?>
                <li class="nav-item">
                  <a href="<?php echo CURRENT_PAGE; ?>" class="nav-link<?php if (CURRENT_PAGE == CURRENT_PAGE) echo " active"; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Project Details</p>
                  </a>
                </li>
              <?php
              }

              // Check if current page is the exportable projects
              if (strpos(CURRENT_PAGE, PROJECTS_EXPORTABLE_PAGE) !== false) {
              ?>
                <li class="nav-item">
                  <a href="<?php echo CURRENT_PAGE; ?>" class="nav-link<?php if (CURRENT_PAGE == CURRENT_PAGE) echo " active"; ?>">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Exportable Projects</p>
                  </a>
                </li>
              <?php }

              $sectionPages = [VIRTUAL_MACHINES_PAGE, ORACLE_DATABASES_PAGE];
              ?>
              <li class="nav-item has-treeview<?php if (in_array(CURRENT_PAGE, $sectionPages, TRUE) || strpos(implode(" ", $sectionPages), strtok(CURRENT_PAGE, "?")) !== false) echo " menu-open"; ?>">
                <a href="#" class="nav-link<?php if (in_array(CURRENT_PAGE, $sectionPages, TRUE) || strpos(implode(" ", $sectionPages), strtok(CURRENT_PAGE, "?")) !== false) echo " active"; ?>">
                  <i class="nav-icon fas fa-cloud"></i>
                  <p>
                    Infra
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo $sectionPages[0]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[0] || strpos(CURRENT_PAGE, $sectionPages[0]) !== false) echo " active"; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Virtual Machines
                        <span class="badge badge-secondary right"><?php echo number_format($totalVMs); ?></span>
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo $sectionPages[1]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[1] || strpos(CURRENT_PAGE, $sectionPages[1]) !== false) echo " active"; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Oracle Databases
                        <span class="badge badge-secondary right"><?php echo number_format($totalODBs); ?></span>
                      </p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php
            }

            if (isAdmin() || isReviewer()) {
              $sectionPages = [IP_ADDRESSES_PAGE, IP_ADDRESS_PAGE];
            ?>
              <li class="nav-item has-treeview<?php if (in_array(strtok(CURRENT_PAGE, "?"), $sectionPages, TRUE)) echo " menu-open"; ?>">
                <a href="#" class="nav-link<?php if (in_array(strtok(CURRENT_PAGE, "?"), $sectionPages, TRUE)) echo " active"; ?>">
                  <i class="nav-icon fas fa-network-wired"></i>
                  <p>
                    Network
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo $sectionPages[0]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[0]) echo " active"; ?>">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        IP Addresses
                        <span class="badge badge-secondary right"><?php echo number_format($totalIPs); ?></span>
                      </p>
                    </a>
                  </li>
                  <?php
                  // Check if current page is the subnet details
                  if (strpos(CURRENT_PAGE, $sectionPages[1]) !== false) {
                  ?>
                    <li class="nav-item">
                      <a href="<?php echo CURRENT_PAGE; ?>" class="nav-link<?php if (CURRENT_PAGE == CURRENT_PAGE) echo " active"; ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Subnet Details</p>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php } ?>
            <li class="nav-header">RESOURCES</li>
            <li class="nav-item">
              <a href="<?php echo LINKS_PAGE; ?>" class="nav-link<?php if (CURRENT_PAGE == LINKS_PAGE || strpos(CURRENT_PAGE, LINKS_PAGE) !== false) echo " active"; ?>">
                <i class="nav-icon fas fa-link"></i>
                <p>Links</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo GUIDES_PAGE; ?>" class="nav-link<?php if (CURRENT_PAGE == GUIDES_PAGE) echo " active"; ?>">
                <i class="nav-icon fas fa-clipboard-list"></i>
                <p>Guides</p>
              </a>
            </li>
            <?php if (isAdmin() || isServiceManager() || isServiceTeam()) { ?>
              <li class="nav-header">PERSONAL</li>
              <li class="nav-item">
                <a href="<?php echo OVERTIME_PAGE; ?>" class="nav-link<?php if (CURRENT_PAGE == OVERTIME_PAGE) echo " active"; ?>">
                  <i class="nav-icon fas fa-user-clock"></i>
                  <p>My Overtime</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo MESSAGES_PAGE; ?>" class="nav-link<?php if (CURRENT_PAGE == MESSAGES_PAGE || strpos(CURRENT_PAGE, MESSAGES_PAGE) !== false) echo " active"; ?>">
                  <i class="nav-icon fas fa-comments"></i>
                  <p>Messages</p>
                </a>
              </li>
            <?php
            }

            if (isAdmin() || isServiceManager() || isServiceDeskManager() || isReviewer()) {
              $sectionPages = [SUMMARY_RESPONSE, SUMMARY_REQUESTOR, SUMMARY_PROJECTS, SUMMARY_OVERTIME, SUMMARY_MINISTRIES]; ?>
              <li class="nav-header">REPORTS</li>
              <li class="nav-item has-treeview<?php if (in_array(strtok(CURRENT_PAGE, "?"), $sectionPages, TRUE)) echo " menu-open"; ?>">
                <a href="#" class="nav-link<?php if (in_array(strtok(CURRENT_PAGE, "?"), $sectionPages, TRUE)) echo " active"; ?>">
                  <i class="nav-icon fas fa-chart-line"></i>
                  <p>
                    Summary
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?php echo $sectionPages[0]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[0]) echo " active"; ?>">
                      <i class="nav-icon fas fa-hourglass-end"></i>
                      <p>Response Time</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?php echo $sectionPages[1]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[1]) echo " active"; ?>">
                      <i class="nav-icon fas fa-running"></i>
                      <p>Top Ticket Loggers</p>
                    </a>
                  </li>
                  <?php if (isAdmin() || isCloudAdmin() || isReviewer()) { ?>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[2]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[2]) echo " active"; ?>">
                        <i class="nav-icon fas fa-list-ol"></i>
                        <p>Top Projects</p>
                      </a>
                    </li>
                  <?php }
                  if (isSuperAdmin() || isServiceManager() || isReviewer()) { // isSuperAdmin replaced to isAdmin 
                  ?>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[3]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[3]) echo " active"; ?>">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>Overtime</p>
                      </a>
                    </li>
                    <?php } if (isSuperAdmin() || isServiceManager() || isServiceDeskManager() || isReviewer()) { // isSuperAdmin replaced to isAdmin 
                  ?>
                    <li class="nav-item">
                      <a href="<?php echo $sectionPages[4]; ?>" class="nav-link<?php if (CURRENT_PAGE == $sectionPages[4]) echo " active"; ?>">
                        <i class="nav-icon fa fa-building"></i>
                        <p>Total Request by Ministries</p>
                      </a>
                    </li>
                  <?php } ?>
                </ul>
              </li>
            <?php
            }

            if (isAdmin()) {
            ?>
              <li class="nav-header">SETTINGS</li>
              <?php
              // Initialise empty array
              $sections = [];
              $icons = [];
              $pages = [];

              // Query
              $query = "SELECT settings_pages.name, url, settings_sections.name AS sectionName, settings_sections.icon AS sectionIcon FROM settings_pages
              INNER JOIN settings_sections ON settings_pages.sectionId = settings_sections.id
              ORDER BY settings_pages.sectionId, settings_pages.displayOrder";
              $result = mysqli_query($mysqli, $query);
              if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                  // Add section name into array if it doesn't exist
                  if (!in_array($row["sectionName"], $sections)) {
                    $sections[] = $row["sectionName"];
                  }
                  // Add section icon into array if it doesn't exist
                  if (!in_array($row["sectionIcon"], $icons)) {
                    $icons[] = $row["sectionIcon"];
                  }

                  // Add page row into array
                  $pages[] = $row;
                }
              }

              for ($x = 0; $x < count($sections); $x++) {
                $section = $sections[$x];
                $icon = $icons[$x];

                $key = array_search(strtok(CURRENT_PAGE, '?'), array_column($pages, "url")); // get the index of the current page. strtok is to remove the query string from the parameter
                if ($key !== FALSE) {
                  $thisPage = $pages[$key]; // get the page
                }
              ?>
                <li class="nav-item has-treeview<?php if ($section == $thisPage["sectionName"]) echo " menu-open"; ?>">
                  <a href="#" class="nav-link<?php if ($section == $thisPage["sectionName"]) echo " active"; ?>">
                    <i class="nav-icon <?php echo $icon; ?>"></i>
                    <p>
                      <?php echo $section; ?>
                      <i class="fas fa-angle-left right"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <?php
                    foreach ($pages as $page) {
                      if ($page["sectionName"] == $section) {
                    ?>
                        <li class="nav-item">
                          <a href="<?php echo $page["url"]; ?>" class="nav-link<?php if (CURRENT_PAGE == $page["url"] || strpos(CURRENT_PAGE, $page["url"]) !== false) echo " active"; ?>">
                            <i class="far fa-circle nav-icon"></i>
                            <p>
                              <?php
                              echo $page["name"];

                              if ($page["url"] == USERS_PAGE) {
                                echo '<span class="badge badge-secondary right">' . $totalUsers . '</span>';
                              }
                              ?>
                            </p>
                          </a>
                        </li>
                    <?php
                      }
                    }
                    ?>
                  </ul>
                </li>
            <?php
              }
            }
            ?>
          </ul>
          
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Add ticket modal -->
    <?php if (!isReviewer()) { ?>
      <!-- Add modal -->
      <form role="form" method="post" action="<?php echo REQUESTS_PAGE; ?>">
        <div class="modal fade" id="modal-add-ticket">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header bg-primary">
                <h4 class="modal-title">Add Ticket</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Title <small class="text-danger">(required)</small></label>
                      <input aria-label='Title' class='form-control form-control-sm' id='titleSuggestionInput' name='title' placeholder='Title' type='text' required>
                      <!-- <input name="title" type="text" class="form-control form-control-sm" placeholder="Title of the request" required> -->
                    </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Requestor Name <small class="text-danger">(required)</small></label>
                      <input name="requestorName" type="text" class="form-control form-control-sm" required>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Ministry/Organization <small class="text-danger">(required)</small></label>
                      <select name="requestorMinistryId" class="form-control select2" required>
                        <?php
                        $query = "SELECT * FROM ministries
                      ORDER BY name";
                        $result = mysqli_query($mysqli, $query);
                        if (mysqli_num_rows($result) > 0) {
                          $num = 1;
                          while ($ministryRow = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $ministryRow["id"]; ?>"><?php echo $ministryRow["name"]; ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-group">
                      <label>Department <small class="text-muted">(optional)</small></label>
                      <input name="requestorDepartment" type="text" class="form-control form-control-sm">
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Service <small class="text-danger">(required)</small></label>
                      <?php
                      $query = "SELECT * FROM services";
                      $query .= isServiceManager() || isServiceTeam() ? " WHERE teamId = " . $_SESSION["teamId"] : " WHERE id != 1 AND id != 3 AND id != 4 AND id != 5 AND id != 6 AND id != 7 ";
                      $query .= " ORDER BY name";
                      $result = mysqli_query($mysqli, $query);
                      ?>
                      <select name="serviceId" class="form-control <?php echo mysqli_num_rows($result) == 1 ? "select2Filled" : "select2"; ?>" required>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                          while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row["id"]; ?>" <?php echo mysqli_num_rows($result) == 1 ? " selected" : ""; ?>><?php echo $row["name"]; ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Category <small class="text-danger">(required)</small></label>
                      <select name="categoryId" class="form-control select2" required>
                        <?php
                        $query = "SELECT * FROM request_categories where id = 2 or id = 3 ORDER BY name";
                        $result = mysqli_query($mysqli, $query);
                        if (mysqli_num_rows($result) > 0) {
                          $num = 1;
                          while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Priority <small class="text-danger">(required)</small></label>
                      <select name="priorityId" class="form-control select2Filled" required>
                        <?php
                        $query = "SELECT * FROM request_priorities";
                        $result = mysqli_query($mysqli, $query);
                        if (mysqli_num_rows($result) > 0) {
                          $num = 1;
                          while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row["id"]; ?>" <?php echo $row["name"] == "Normal" ? " selected" : ""; ?>>
                              <?php echo $row["name"]; ?>
                              <!-- <?php if ($row["day"] > 1) { ?>
                      (<?php echo $row["day"] ?> days)
                      <?php } else { ?>
                      (24 hours) <?php } ?> -->
                            </option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <hr>
                <div class="row">
                  <div class="col-sm-12">
                    <div class="form-group">
                      <label>Cloud Tenant Project <small class="text-muted">(optional)</small></label>
                      <select name="projectId" class="form-control select2">
                        <?php
                        // $userProjects = preg_filter('/^/', "id = ", getUserProjects($userId));
                        // $whereStatement = " WHERE (" . implode(" OR ", $userProjects) . ")";

                        $query = "SELECT * FROM projects";
                        // $query .= isTenant() ? $whereStatement : "";
                        $query .= " ORDER BY name";
                        $result = mysqli_query($mysqli, $query);
                        if (mysqli_num_rows($result) > 0) {
                          $num = 1;
                          while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>
                        <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Helpdesk Reference <small class="text-muted">(optional)</small></label>
                      <input name="helpdeskRef" type="text" class="form-control form-control-sm" placeholder="Reference from helpdesk">
                    </div>
                  </div>
                  <!-- /.col -->
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Source <small class="text-muted">(optional)</small></label>
                      <select name="source" class="form-control select2">
                        <option>Email</option>
                        <option>Call</option>
                      </select>
                    </div>
                  </div>
                  <!-- /.col -->
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label>Email Reference <small class="text-muted">(optional)</small></label>
                      <input name="emailRef" type="text" class="form-control form-control-sm" placeholder="email title/date/time">
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
                <hr>
                <div class="form-group">
                  <label>Description <small class="text-danger">(required)</small></label>
                  <textarea id="summernote" name="description" class="form-control form-control-sm" rows="3" placeholder="Description of the request" required></textarea>
                </div>
              </div>
              <div class="modal-footer text-right">
                <input name="userId" type="hidden" value="<?php echo $_SESSION["userId"]; ?>">
                <input name="teamId" type="hidden" value="<?php echo $_SESSION["teamId"]; ?>">
                <button name="submitTicket" type="submit" class="btn btn-primary">Submit</button>
                <button name="reset" type="reset" class="btn btn-default">Reset</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      </form>
      <!-- /.modal -->
    <?php } ?>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">