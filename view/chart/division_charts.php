<!-- This section of web app is for division's charts section. 
The data for the chart will be seggregated by javascript based on the pulled data from the RMS DB.

<!-- Row 1 - start-->
<!-- Components of row 1 of the web app:
1. Number of Open, Pending & Closed risks.
2. Number of percentage Closed risks.
3. Number of Total risk regiestered.
4. Number of Awaiting risk to be reviewed by risk analyst. -->


<?php
    
// if (isset($_SESSION['loggedIn'])) {

// $query = "SELECT id, name, label,
//     (SELECT COUNT(requests.statusId)
//     FROM requests
//     WHERE ";
// $query .= isSuperAdmin() || isServiceDeskManager() || isReviewer() ? "" : "(teamId = " . $_SESSION["teamId"] . " OR FIND_IN_SET('" . $_SESSION["teamId"] . "', teamIds) > 0 ) AND ";
// $query .= "requests.categoryId = request_categories.id) AS opened,
//     (SELECT COUNT(requests.statusId)
//     FROM requests
//     WHERE ";
// $query .= isSuperAdmin() || isServiceDeskManager() || isReviewer() ? "" : "(teamId = " . $_SESSION["teamId"] . " OR FIND_IN_SET('" . $_SESSION["teamId"] . "', teamIds) > 0 ) AND "; 
// $query .= "requests.categoryId = request_categories.id
//     AND (requests.statusId = 8 OR requests.statusId = 10)) AS closed";

// $query .= " FROM request_categories";
// if (isAdmin() || isReviewer()) {

// } else {
//     $query .= " WHERE id = 2 OR id = 3 ";
// }
//     $query .= " ORDER BY name";

// $result = mysqli_query($mysqli, $query);

// if (mysqli_num_rows($result) > 0) {
//     // output data of each row
//     while($row = mysqli_fetch_assoc($result)) {
//     if($row["id"] == 2){
//         $category = "incident";
//     } else if ($row["id"] == 3) {
//         $category = "serviceRequest";
//     } else if ($row["id"] == 4) {
//         $category = "projectRequest";
//     } else if ($row["id"] == 5) {
//         $category = "issue";
//     } else if ($row["id"] == 6) {
//         $category = "infraOperation";
//     } else if ($row["id"] == 7) {
//         $category = "generalEnquiry";
// }
?>


<?php if(isDev()) { ?>

<?php 
    // add select from where $user_id (current user id)
    // then by using the user id to get the section id
    // then by using the section id push to the count below


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

    $query = "SELECT COUNT(*) AS risk FROM risks WHERE status_id = 1 AND section_id = $section_id";
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

<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title  text-center mb-0">Assessment</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        
                        <p class="text-center">Open</p>
                        <h5 class="text-center"><?php echo $opened_risk ?></h5>
                    </div>
                    <div class="col-4">
                        <p class="text-center">Pending</p>
                        <h5 class="text-center"><?php echo $pending_risk ?></h5>
                    </div>
                    <div class="col-4">
                        <p class="text-center">Closed</p>
                        <h5 class="text-center"><?php echo $closeed_risk ?></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title  text-center mb-0">% Closed</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">												
                        <br>										
                        <h3 class="text-center mb-3"><?php echo number_format((float)$percentage,2,'.', '');?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title  text-center mb-0">Total Risk</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <br>										
                        <h3 class="text-center mb-3"><?php echo $total_risk ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title  text-center mb-0">Awaiting Review</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">												
                        <br>										
                        <h3 class="text-center mb-3"><?php echo $review_risk ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row 1 - End-->
<?php } ?>

