
<?php include_once("../view/main/include_system.php"); ?>

<!-- Mark this page as restricted to logged in users -->
<?php include_once("" . RESTRICTED_PAGE); ?>

<!-- Set this page's name -->
<?php define("PAGE_NAME", "Dashboard"); ?>
<?php include_once("" . HEADER_PAGE); ?>

    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?php echo INDEX_PAGE; ?>">Home</a></li>
              <li class="breadcrumb-item active"><?php echo PAGE_NAME; ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <?php if (isDev()) { ?>
          <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 class="count"><?php echo $totalProjects; ?></h3>
                <p>Projects</p>
              </div>
              <div class="icon">
                <i class="fas fa-tasks"></i>
              </div>
              <a href="<?php echo PROJECTS_PAGE; ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 class="count"><?php echo $totalAllRequests; ?></h3>
                <p>Tickets</p>
              </div>
              <div class="icon">
                <i class="fas fa-file-contract"></i>
              </div>
              <a href="<?php echo REQUESTS_PAGE; ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 class="count"><?php echo $totalVMs; ?></h3>
                <p>Virtual Machines</p>
              </div>
              <div class="icon">
                <i class="fas fa-server"></i>
              </div>
              <a href="<?php echo VIRTUAL_MACHINES_PAGE; ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 class="count"><?php echo $totalODBs; ?></h3>
                <p>Oracle Databases</p>
              </div>
              <div class="icon">
                <i class="fas fa-database"></i>
              </div>
              <a href="<?php echo ORACLE_DATABASES_PAGE; ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <?php
          }

          if (isDev()) {
          ?>
          <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3 class="count"><?php echo $totalIPs; ?></h3>
                <p>IP Addresses</p>
              </div>
              <div class="icon">
                <i class="fas fa-network-wired"></i>
              </div>
              <a href="<?php echo IP_ADDRESSES_PAGE; ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3 class="count"><?php echo $totalUsers; ?></h3>
                <p>Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
              <a href="<?php echo USERS_PAGE; ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <?php
          }

          if (isRiskChampion() || isSubRiskChampion()) {
          ?>
          <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 class="count"><?php echo $totalAllRequests; ?></h3>
                <p>Tickets</p>
              </div>
              <div class="icon">
                <i class="fas fa-file-contract"></i>
              </div>
              <a href="<?php echo REQUESTS_PAGE; ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 class="count"><?php echo $totalOpenIncidentRequests; ?></h3>
                <p>Opened Incident</p>
              </div>
              <div class="icon">
                <i class="fas fa-folder-open"></i>
              </div>
              <a href="<?php echo REQUESTS_PAGE; ?>?status=open&category=incident" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 class="count"><?php echo $totalOpenServiceRequests; ?></h3>
                <p>Opened Service Request</p>
              </div>
              <div class="icon">
                <i class="fas fa-folder-open"></i>
              </div>
              <a href="<?php echo REQUESTS_PAGE; ?>?status=open&category=serviceRequest" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 class="count"><?php echo $totalTicketsDueToday; ?></h3>
                <p>Due Today</p>
              </div>
              <div class="icon">
                <i class="fas fa-exclamation"></i>
              </div>
              <a href="<?php echo REQUESTS_PAGE . "?status=duetoday"; ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3 class="count"><?php echo $totalTicketsDueSoon; ?></h3>
                <p>Due Soon</p>
              </div>
              <div class="icon">
                <i class="fas fa-exclamation"></i>
              </div>
              <a href="<?php echo REQUESTS_PAGE . "?status=duesoon"; ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3 class="count"><?php echo $totalTicketsOverdue; ?></h3>
                <p>Overdue</p>
              </div>
              <div class="icon">
                <i class="fas fa-exclamation"></i>
              </div>
              <a href="<?php echo REQUESTS_PAGE . "?status=overdue"; ?>" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <?php } ?>
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header border-0">
                <h5 class="card-title">Service Tickets</h5>
                <div class="card-tools">
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=open" class="dropdown-item">View open requests</a>
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=escalate" class="dropdown-item">View escalated requests</a>
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=inProgress" class="dropdown-item">View in progress requests</a>
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=statusQuery" class="dropdown-item">View status query requests</a>
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=pending" class="dropdown-item">View pending requests</a>
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=completed" class="dropdown-item">View completed requests</a>
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=cancelled" class="dropdown-item">View cancelled requests</a>
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=closed" class="dropdown-item">View closed requests</a>
                      <div class="dropdown-divider"></div>
                      <a href="<?php echo REQUESTS_PAGE; ?>" class="dropdown-item">View all requests</a>
                    </div>
                  </div>
                </div>
                <!-- /.card-tools-->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-9">
                    <p class="text-center">
                      <strong>Last 12 Months</strong>
                    </p>

                    <div class="position-relative mb-2">
                      <canvas id="requestsChart" height="200"></canvas>
                    </div>

                    <div class="d-flex flex-row justify-content-end">
                      <span class="mr-2">
                        <i class="fas fa-square text-gray"></i> Opened
                      </span>

                      <span>
                        <i class="fas fa-square text-primary"></i> Closed
                      </span>
                    </div>
                    <!-- /.d-flex -->
                  </div>
                  <!-- /.col -->
                  <div class="col-md-3">
                    <p class="text-center">
                      <strong>Statistics</strong>
                    </p>

                    <?php
                    if (isset($_SESSION['loggedIn'])) {

                    $query = "SELECT id, name, label,
                      (SELECT COUNT(requests.statusId)
                        FROM requests
                        WHERE ";
                    $query .= isSuperAdmin() || isServiceDeskManager() || isReviewer() ? "" : "(teamId = " . $_SESSION["teamId"] . " OR FIND_IN_SET('" . $_SESSION["teamId"] . "', teamIds) > 0 ) AND ";
                    $query .= "requests.categoryId = request_categories.id) AS opened,
                      (SELECT COUNT(requests.statusId)
                        FROM requests
                        WHERE ";
                    $query .= isSuperAdmin() || isServiceDeskManager() || isReviewer() ? "" : "(teamId = " . $_SESSION["teamId"] . " OR FIND_IN_SET('" . $_SESSION["teamId"] . "', teamIds) > 0 ) AND "; 
                    $query .= "requests.categoryId = request_categories.id
                        AND (requests.statusId = 8 OR requests.statusId = 10)) AS closed";
                   
                    $query .= " FROM request_categories";
                    if (isAdmin() || isReviewer()) {
            
                    } else {
                      $query .= " WHERE id = 2 OR id = 3 ";
                    }
                      $query .= " ORDER BY name";

                    $result = mysqli_query($mysqli, $query);

                    if (mysqli_num_rows($result) > 0) {
                      // output data of each row
                      while($row = mysqli_fetch_assoc($result)) {
                        if($row["id"] == 2){
                          $category = "incident";
                        } else if ($row["id"] == 3) {
                          $category = "serviceRequest";
                        } else if ($row["id"] == 4) {
                          $category = "projectRequest";
                        } else if ($row["id"] == 5) {
                          $category = "issue";
                        } else if ($row["id"] == 6) {
                          $category = "infraOperation";
                        } else if ($row["id"] == 7) {
                          $category = "generalEnquiry";
                        }
                    ?>
                      <div class="progress-group">
                        <a href="<?php echo REQUESTS_PAGE . "?category=" . $category; ?>"><?php echo $row["name"]; ?></a>
                        <span class="float-right">
                          <span class="count"><?php echo $row["closed"]; ?></span><small class="text-muted">/<?php echo number_format($row["opened"]); ?></small>
                        </span>
                        <div class="progress progress-sm" style="border-radius: 10px">
                          <div class="progress-bar <?php echo $row["label"]; ?>" style="width: <?php if($row["closed"] != 0 && $row["opened"] != 0) { echo $row["closed"] / $row["opened"] * 100;} else { echo 0; } ?>%"></div>
                        </div>
                      </div>
                      <!-- /.progress-group -->
                    <?php
                      }
                    }
                  }
                    ?>
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- ./card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <!-- Onboarding projects graph -->
          <div class="col-md-7">
            <?php if (isAdmin() || isReviewer()) { ?>
            <div class="card bg-gradient-info">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-th mr-1"></i> Onboarding Projects
                </h3>
                <div class="card-tools">
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="<?php echo PROJECTS_PAGE; ?>" class="dropdown-item">View all projects</a>
                    </div>
                  </div>
                </div>
                <!-- /.card-tools-->
              </div>
              <div class="card-body">
                <canvas class="chart" id="line-chart" style="min-height: 150px; height: 150px; max-height: 150px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
              <div class="card-footer bg-transparent">
                <div class="row">
                  <?php
                  $query = "SELECT COUNT(*) AS Project
                    FROM projects
                    WHERE statusId = 4"; // Live
                  $result = mysqli_query($mysqli, $query);

                  if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                      $liveProjects = $row["Project"];
                    }
                  }
                  
                  $query = "SELECT COUNT(*) AS Project
                    FROM projects
                    WHERE statusId = 3"; // System Development
                  $result = mysqli_query($mysqli, $query);

                  if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                      $developmentProjects = $row["Project"];
                    }
                  }
                  
                  $query = "SELECT COUNT(*) AS Project
                    FROM projects
                    WHERE statusId = 5"; // Decommissioned
                  $result = mysqli_query($mysqli, $query);

                  if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                      $decommissonedProjects = $row["Project"];
                    }
                  }
                  ?>
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="<?php echo $liveProjects; ?>" data-width="60" data-height="60" data-bgColor="#3c8dbc" data-fgColor="#01ff70">
                    <div class="text-white">Live</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="<?php echo $developmentProjects; ?>" data-width="60" data-height="60" data-bgColor="#3c8dbc" data-fgColor="#ffc107">
                    <div class="text-white">System Development</div>
                  </div>
                  <!-- ./col -->
                  <div class="col-4 text-center">
                    <input type="text" class="knob" data-readonly="true" value="<?php echo $decommissonedProjects; ?>" data-width="60" data-height="60" data-bgColor="#3c8dbc" data-fgColor="#6c757d">
                    <div class="text-white">Decommissioned</div>
                  </div>
                  <!-- ./col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
            <?php } ?>

            <!-- Recently added requests  -->
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Recently Added Requests</h3>
                <div class="card-tools">
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=open" class="dropdown-item">View open requests</a>
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=inProgress" class="dropdown-item">View in progress requests</a>
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=statusQuery" class="dropdown-item">View status query requests</a>
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=completed" class="dropdown-item">View completed requests</a>
                      <a href="<?php echo REQUESTS_PAGE; ?>?status=closed" class="dropdown-item">View closed requests</a>
                      <div class="dropdown-divider"></div>
                      <a href="<?php echo REQUESTS_PAGE; ?>" class="dropdown-item">View all requests</a>
                    </div>
                  </div>
                </div>
                <!-- /.card-tools-->
              </div>

              <div class="card-body p-0">
                <ul class="products-list product-list-in-card pl-3 pr-3">
                  <?php
                  if (isset($_SESSION['loggedIn'])) {

                  $query = "SELECT requests.id, requests.title, requests.userId, requests.createdAt, request_categories.name AS categoryName, request_status.name AS requestStatus, request_status.label AS statusLabel, users.name AS userName, projects.name AS projectName FROM requests
                    INNER JOIN request_categories ON requests.categoryId = request_categories.id
                    INNER JOIN request_status ON requests.statusId = request_status.id
                    INNER JOIN users ON requests.userId = users.id
                    LEFT JOIN projects ON requests.projectId = projects.id";
                  $query .= isSuperAdmin() || isReviewer() ? "" : " WHERE requests.teamId = " . $_SESSION["teamId"];
                  $query .= " ORDER BY requests.createdAt DESC
                    LIMIT 5";
                  $result = mysqli_query($mysqli, $query);
                  if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                  ?>
                  <li class="item">
                    <a href="<?php echo REQUEST_PAGE; ?>?id=<?php echo $row["id"]; ?>" class="product-title">
                      <?php echo $row["title"]; ?>
                    </a>
                    <div class="float-right">
                      <span class="badge bg-lightblue"><?php echo $row["categoryName"]; ?></span>
                      <span class="badge <?php echo $row["statusLabel"]; ?>"><?php echo $row["requestStatus"]; ?></span>
                    </div>
                    <br />
                    <small class="text-muted">
                      SR-<?php echo date('Ymd', strtotime($row["createdAt"])) . "-" . $row["id"]; ?> &bull; Submitted by <a href="<?php echo USER_PAGE . "?id=" . $row["userId"]; ?>" class="text-reset"><?php echo $row["userName"]; ?></a> <abbr title="<?php echo date("l, l, j F Y g:i:s A", strtotime($row["createdAt"])); ?>"><?php echo @time_elapsed_string(date($row["createdAt"])); ?></abbr>
                    </small>
                  </li>
                  <?php
                    } }
                  } else {
                    echo '<li class="item">None</li>';
                  }
                  ?>
                </ul>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <div class="col-md-5">
            <?php if (isAdmin() || isReviewer()) { ?>
            <!-- Ministry projects graph -->
            <div class="card bg-gradient-olive">
              <div class="card-header border-0">
                <h3 class="card-title">
                  <i class="fas fa-building"></i> Projects by Ministries
                </h3>
              </div>
              <div class="card-body">
                <div class="position-relative mb-2">
                  <canvas id="sales-chart" height="230"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-lime"></i> Live
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> Decommissioned
                  </span>
                </div>
                <!-- /.d-flex -->
              </div>
            </div>
            <!-- /.card -->
            <?php } ?>

            <!-- Recently online -->
            <div class="card">
              <div class="card-header border-0">
                <h3 class="card-title">Recently Online</h3>
                <div class="card-tools">
                  <div class="btn-group">
                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                      <i class="fas fa-bars"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" role="menu">
                      <a href="<?php echo USERS_PAGE; ?>" class="dropdown-item">View all users</a>
                    </div>
                  </div>
                </div>
                <!-- /.card-tools-->
              </div>

              <div class="card-body p-0">
                <ul class="users-list clearfix">
                  <?php
                  $query = "SELECT * FROM users
                  ORDER BY lastLogin DESC
                  LIMIT 8";
                  $result = mysqli_query($mysqli, $query);
                  if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                      $lastLogin = $row["lastLogin"] == NULL ? "Never" : @timeElapsedOnline(date($row["lastLogin"]));
                      $lastLoginAbbr = $row["lastLogin"] == NULL ? "Never" : date("l, j F Y g:i:s A", strtotime($row["lastLogin"]));
                  ?>
                  <li>
                    <a href="<?php echo USER_PAGE . "?id=" . $row["id"]; ?>" title="<?php echo $row["name"]; ?>"><img src="https://ui-avatars.com/api/?background=3c8dbc&color=fff&name=<?php echo $row["name"]; ?>" alt="User Image"></a>
                    <a class="users-list-name" href="<?php echo USER_PAGE . "?id=" . $row["id"]; ?>" title="<?php echo $row["name"]; ?>"><?php echo $row["name"]; ?></a>
                    <span class="users-list-date"><?php echo '<abbr title="' . $lastLoginAbbr . '">' . $lastLogin . '</abbr>'; ?></span>
                  </li>
                  <?php
                    }
                  }
                  ?>
                </ul>
              </div>
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->

      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
<?php include_once("" . FOOTER_PAGE); ?>