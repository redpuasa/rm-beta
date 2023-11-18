<!-- RMS Tourguide -->
<!-- <div data-tg-title="Welcome to Risk Management System" data-tg-tour='Strictly please go through with the tour guide for you to understand the system better. You may use your arrow keys for navigation of the tour.' data-tg-order="0"></div> -->

<!-- roles:
1. dev
2. admin || risk analyst
3. risk leader
4. risk champion
5. disabled

isDev() || isRiskAnalyst() -->

<?php 
    $query = "SELECT COUNT(*) AS risk FROM risks";
    $result = mysqli_query($mysqli, $query);
    if (mysqli_num_rows( $result ) > 0) {
        while( $row = mysqli_fetch_assoc($result) ) {
            $total_risk = $row["Risk"];
        }
    }

    $query = "SELECT COUNT(*) AS risk FROM risks status_id = 5";
    $result = mysqli_query($mysqli, $query);
    if (mysqli_num_rows( $result ) > 0) {
        while( $row = mysqli_fetch_assoc($result) ) {
            $review_risk = $row["Risk"];
        }
    }

    $query = "SELECT COUNT(*) AS risk FROM risks WHERE status_id = 1";
    $result = mysqli_query($mysqli, $query);
    if (mysqli_num_rows( $result ) > 0) {
        while( $row = mysqli_fetch_assoc($result) ) {
            $opened_risk = $row["Risk"];
        }
    }

    $query = "SELECT COUNT(*) AS risk FROM risks WHERE status_id = 2";
    $result = mysqli_query($mysqli, $query);
    if (mysqli_num_rows( $result ) > 0) {
        while( $row = mysqli_fetch_assoc($result) ) {
            $pending_risk = $row["Risk"];
        }
    }

    $query = "SELECT COUNT(*) AS risk FROM risks WHERE status_id = 3";
    $result = mysqli_query($mysqli, $query);
    if (mysqli_num_rows( $result ) > 0) {
        while( $row = mysqli_fetch_assoc($result) ) {
            $closed_risk = $row["Risk"];
        }
    }
    
    //percentage closed
    $x = $opened_risk;
    $y = $closed_risk;
    $division = $x / $y;
    $percentage = $division * 100;
?>


<h1 class="h3 mb-3">Risk Oversight</h1>

<!-- Info boxes -->
<div class="row">
    <!-- change the user roles -->
    <?php if (isDev() || isRiskAnalyst()) { ?>
        <div class="col-lg-2 col-4">
        <!-- small card -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 class="count"><?php echo $total_risk; ?></h3>
                    <p>Risks Registered</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tasks"></i>
                </div>
            </div>
        </div><!-- ./col -->

        <div class="col-lg-2 col-4">
            <!-- small card -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 class="count"><?php echo $opened_risk; ?></h3>
                    <p>Opened Risk</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-contract"></i>
                </div>
            </div>
        </div><!-- ./col -->

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
            </div>
        </div><!-- ./col -->

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
            </div>
        </div><!-- ./col -->

    <?php } if () { ?>

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
    </div><!-- ./col -->

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
    </div><!-- ./col -->

    <!-- Change the user role -->
    <?php } if (isServiceDeskManager() || isServiceDeskTeam() || isServiceManager() || isServiceTeam()) { ?>
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
    </div><!-- ./col -->

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
    </div><!-- ./col -->

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
    </div><!-- ./col -->

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
    </div><!-- ./col -->

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
    </div><!-- ./col -->

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
    </div><!-- ./col -->

    <?php } ?>
</div><!-- /.row -->