<?php
include_once('../include_system.php');

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

 // DB table to use

$table = "
    (
      SELECT ROW_NUMBER() OVER(ORDER BY requests.id DESC) AS num,
      requests.id, requests.title, requests.projectId, requests.statusId, requests.teamId, requests.categoryId, requests.priorityId, requests.userId, requests.updateUserId, requests.helpdeskRef,requests.createdAt As createdAt, requests.updatedAt, DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) AS daypass, requests.teamIds,
      request_categories.name AS categoryName, request_categories.label AS categoryLabel, request_categories.code AS categoryCode,
      request_status.name AS requestStatus, request_status.label AS requestLabel,
      request_priorities.name AS priorityName, request_priorities.day AS day,
      a.name AS createdBy, b.name AS updatedBy,
      services.name AS serviceName,
      projects.name AS projectName,
      concat(request_categories.code,'-',date_format(requests.createdAt,'%Y%m%d'),'-',requests.id) AS referenceId,
      ministries.name AS ministryName
      FROM requests
      LEFT JOIN services ON requests.serviceId = services.id
      LEFT JOIN request_categories ON requests.categoryId = request_categories.id
      LEFT JOIN request_status ON requests.statusId = request_status.id
      LEFT JOIN request_priorities ON requests.priorityId = request_priorities.id
      LEFT JOIN ministries ON requests.requestorMinistryId = ministries.id
      LEFT JOIN users a ON requests.userId = a.id
      LEFT JOIN users b ON requests.updateUserId = b.id AND requests.updateUserId IS NOT NULL
      LEFT JOIN projects ON requests.projectId = projects.id
    ) temp";

// Table's primary key
$primaryKey = 'id';

if ($_GET["year"]) {
  $year = $_GET["year"];
  if ($_GET["week"]) {
    $week = $_GET["week"];
    $whereStatement .= "(WEEK(createdAt, 1) = $week AND YEAR(createdAt) = $year)";
  } else if ($_GET["month"]) {
    $month = $_GET["month"];
    $whereStatement .= "(MONTHNAME(createdAt) = '$month' AND YEAR(createdAt) = $year)";
  }
} else if ($_GET["yearClosed"]) {
  $year = $_GET["yearClosed"];
  if ($_GET["weekClosed"]) {
    $week = $_GET["weekClosed"];
    $whereStatement .= "(WEEK(updatedAt, 1) = $week AND YEAR(updatedAt) = $year AND statusId = 10)";
  } else if ($_GET["monthClosed"]) {
    $month = $_GET["monthClosed"];
    $whereStatement .= "(MONTHNAME(updatedAt) = '$month' AND YEAR(updatedAt) = $year AND statusId = 10)";
  }
} else if ($_GET["searchTicket"]) {
  $search = ($_GET["searchTicket"]);
  $whereStatement .= "referenceId LIKE '%" . $search . "%'";
} else if ($_GET["categoryId"]) {
  $categoryId = ($_GET["categoryId"]);
  $whereStatement .= "categoryId = " . $categoryId . "";
} else if ($_GET["serviceName"]) {
  $serviceName = $_GET["serviceName"];
  $whereStatement .= "serviceName = '" . $serviceName . "'";
} else if ($_GET["teamIdGet"]) {
  $teamIdGet = $_GET["teamIdGet"];
  $whereStatement .= "teamId = '" . $teamIdGet . "'";
}

if ( $_GET['status'] ) {
  $whereStatement .= $whereStatement == "" ? "" : " AND ";
  if ( $_GET['status'] == "open") {
    $whereStatement .= "(statusId != 8 AND statusId != 10)";
  } else if ( $_GET['status'] == "closed") {
    $whereStatement .= "(statusId = 10)"; 
  } else if ( $_GET['status'] == "escalated") {
    $whereStatement .= "(statusId = 4)";
  } else if ( $_GET['status'] == "completed") {
    $whereStatement .= "(statusId = 9)";
  } else if ( $_GET['status'] == "inProgress") {
    $whereStatement .= "(statusId = 2)";
  } else if ( $_GET['status'] == "statusQuery") {
    $whereStatement .= "(statusId = 3)";
  } else if ( $_GET['status'] == "cancelled") {
    $whereStatement .= "(statusId = 8)";
  } else if ( $_GET['status'] == "pending") {
    $whereStatement .= "(statusId = 0)";
  } else if ( $_GET['status'] == "overdue") {
    $whereStatement .= "(((priorityId = 1 AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) > day) OR (priorityId = 2 AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) > day) 
    OR (priorityId = 3 AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) > day) OR (priorityId = 4 AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) > day)) AND statusId != 8 AND statusId != 10)";
  } else if ( $_GET['status'] == "duetoday") {
    $whereStatement .= "(((priorityId = 1 AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) = day) OR (priorityId = 2 AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) = day) 
    OR (priorityId = 3 AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) = day) OR (priorityId = 4 AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) = day)) AND statusId != 8 AND statusId != 10)";
  } else if ( $_GET['status'] == "duesoon") {
    $whereStatement .= "(((priorityId = 1 AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) > (day - 3) AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) < day) OR (priorityId = 2 AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) > (day - 3) AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) < day) 
    OR (priorityId = 3 AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) > (day - 1) AND DATEDIFF(CURRENT_TIMESTAMP, createdAt) < day)) AND statusId != 8 AND statusId != 10)";
  }
}

if( $_GET['category'] ) {
  $whereStatement .= $whereStatement == "" ? "" : " AND ";
  if ($_GET['category'] == "incident") {
    $whereStatement .= "(categoryName = 'Incident')";
  } else if ($_GET['category'] == "serviceRequest") {
    $whereStatement .= "(categoryName = 'Service Request')";
  } else if ($_GET['category'] == "projectRequest") {
    $whereStatement .= "(categoryName = 'Project Request')";
  } else if ($_GET['category'] == "issue") {
    $whereStatement .= "(categoryName = 'Issue')";
  } else if ($_GET['category'] == "infraOperation") {
    $whereStatement .= "(categoryName = 'Infra Operation')";
  } else if ($_GET['category'] == "generalEnquiry") {
    $whereStatement .= "(categoryName = 'General Enquiry')";
  } else if ($_GET['category'] == "others") {
    $whereStatement .= "(categoryName != 'Incident' AND categoryName != 'Service Request')";
  } 
}

// Show all service tickets if user is admin/service desk manager/reviewer
// Else show only the team's tickets
if (!(isSuperAdmin() || isServiceDeskManager() || isReviewer())) {
  $whereStatement .= $whereStatement == "" ? "" : " AND ";
  $whereStatement .= "(teamId = " . $_SESSION['teamId'] . " OR FIND_IN_SET('" . $_SESSION['teamId'] . "', teamIds) > 0)";
}

if (isServiceDeskTeam()) {
  $whereStatement .= $whereStatement == "" ? "" : " AND ";
  $whereStatement .= "(categoryId = 2 OR categoryId = 3)";
}
$_GET["test"] = $whereStatement;
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
    array( 
      'db' => 'num', 
      'dt' => 0
    ),
    array( 
      'db' => 'id', 
      'formatter' => function( $d, $row ) {
          $GLOBALS['requestId'] = $d;
      }
    ),
    array( 
      'db' => 'referenceId', 
      'dt' => 5, 
      'formatter' => function( $d, $row ) {
          $GLOBALS['referenceId'] = $d;
      }
    ),
    array( 
      'db' => 'helpdeskRef',
      'formatter' => function( $d, $row ) {
        $GLOBALS['helpdeskRef'] = $d;
      }
    ),
    array( 
      'db' => 'ministryName', 
      'formatter' => function( $d, $row ) {
          $GLOBALS['ministryName'] = $d;
      }
    ),
    array( 
      'db' => 'projectId', 
      'formatter' => function( $d, $row ) {
          $GLOBALS['projectId'] = $d;
      }
    ),
    array( 
      'db' => 'projectName', 
      'dt' => 7,
      'formatter' => function( $d, $row ) {
        $GLOBALS['projectName'] = $d;
      }
    ),
    array( 
      'db' => 'statusId', 
      'formatter' => function( $d, $row ) {
          $GLOBALS['statusId'] = $d;
      }
    ),
    array( 
      'db' => 'userId', 
      'formatter' => function( $d, $row ) {
          $GLOBALS['userId'] = $d;
      }
    ),
    array( 
      'db' => 'createdAt',
      'formatter' => function( $d, $row ) {
          $GLOBALS['createdAt'] = $d;
      }
    ),
    array( 
      'db' => 'createdBy', 
      'formatter' => function( $d, $row ) {
          $GLOBALS['createdBy'] = $d;
      }
    ),
    array( 
      'db' => 'updatedAt', 
      'dt' => 2,
      'formatter' => function( $d, $row ) {
          $GLOBALS['updatedAt'] = $d;
          if ($d == ""){
            return "-";
          } else {
            return date("j M Y", strtotime($d));
          }          
      }
    ),
    array( 
      'db' => 'updatedBy', 
      'formatter' => function( $d, $row ) {
          $GLOBALS['updatedBy'] = $d;
      }
    ),
    array( 
      'db' => 'updateUserId', 
      'formatter' => function( $d, $row ) {
          $GLOBALS['updateUserId'] = $d;
      }
    ),
    array( 
      'db' => 'serviceName', 
      'dt' => 6,
      'formatter' => function( $d, $row ) {
        $GLOBALS['serviceName'] = $d;
      }
    ),
    array( 
      'db' => 'priorityName', 
      'formatter' => function( $d, $row ) {
          $GLOBALS['priorityName'] = $d;
      }
    ),
    array( 
      'db' => 'day', 
      'formatter' => function( $d, $row ) {
          $GLOBALS['day'] = $d;
      }
    ),
    array( 
      'db' => 'daypass', 
      'formatter' => function( $d, $row ) {
          $GLOBALS['daypass'] = $d;
      }
    ),
    array( 
      'db' => 'requestLabel', 
      'formatter' => function( $d, $row ) {
        $GLOBALS['requestLabel'] = $d;
      }
    ),
    array( 
      'db' => 'requestStatus', 
      'dt' => 4,
      'formatter' => function( $d, $row ) {
        $GLOBALS['requestStatus'] = $d;
        return "<span class='badge " . $GLOBALS['requestLabel'] . "'>" . $d . "</span>";
      }
    ),
    array( 
      'db' => 'categoryCode', 
      'formatter' => function( $d, $row ) {
        $GLOBALS['categoryCode'] = $d;
      }
    ),   
    array( 
      'db' => 'title',
      'dt' => 1,
      'formatter' => function( $d, $row ) {    

        // Calculate time lapse after request is opened
        $dayLapse = 0;
 
        if ($GLOBALS['statusId'] == 10) { // Status is closed
          $dayLapse = abs( (strtotime($GLOBALS['updatedAt']) - strtotime($GLOBALS['createdAt'])) / (60 * 60 * 24) );
        } else {
          $dayLapse = abs( (time() - strtotime($GLOBALS['createdAt'])) / (60 * 60 * 24) ); // Ongoing request: current time minus the time it was created
        }
        
        // Round numbers down to the nearest integer
        $dayLapse = floor($dayLapse);
    
        if ($GLOBALS['priorityName'] == "Critical") {
          $overdue = $GLOBALS['day'];
          $dueToday = $GLOBALS['day'];
          $dueSoon = $GLOBALS['day'];

        } if ($GLOBALS['priorityName'] == "High") {
          $overdue = $GLOBALS['day'];
          $dueToday = $GLOBALS['day'];
          $dueSoon = $GLOBALS['day']- 2;

        } else {
          $overdue = $GLOBALS['day'];
          $dueToday = $GLOBALS['day'];
          $dueSoon = $GLOBALS['day'] - 3;
        }

        if ($GLOBALS['requestStatus'] != "Closed" && $GLOBALS['requestStatus'] != "Cancelled") {

          if ($GLOBALS['daypass'] > $overdue) {
            $status = '<span class="badge badge-danger mr-1">Overdue</span> ';
          } else if ($GLOBALS['daypass'] == $dueToday) {
            $status = '<span class="badge badge-warning mr-1">Due Today</span> ';
          } else if ($GLOBALS['daypass'] > $dueSoon && $GLOBALS['daypass'] < $dueToday) {
            $status = '<span class="badge badge-primary mr-1">Due Soon</span> ';
          }
        }

        $output = $status . "<a href='" . REQUEST_PAGE . "?id=" . $GLOBALS['requestId']  . "'>" . $d . "</a><br>
        <small class='text-muted'>
          Submitted by <a href=".  USER_PAGE . "?id=" . $GLOBALS['userId'] . " class='text-reset'> " . $GLOBALS['createdBy'] . "</a> <abbr title='" . date('l, j F Y g:i:s A', strtotime($GLOBALS['createdAt'])) . "'>" . time_elapsed_string(date($GLOBALS['createdAt'])) . "</abbr>";
  
        if ( $GLOBALS['updatedAt'] != null) { 
          $output .= " &bull; Updated by <a href=" . USER_PAGE . "?id=" . $GLOBALS['updateUserId'] . " class='text-reset'>" . $GLOBALS["updatedBy"] . "</a> <abbr title='" . date("l, j F Y g:i:s A", strtotime($GLOBALS['updatedAt'])) . "'>" . time_elapsed_string(date($GLOBALS['updatedAt'])) . "</abbr>";
        }
        
        $output .= "</small><br><br>";

        $output .= <<<EOT

        <div class="row small">
          <div class="col-3">
            <dl>
              <dt class="text-muted">Reference</dt>
              <dd> 
        EOT; 
        
        $output .= $GLOBALS['referenceId'];
        
        $output .= <<<EOT
              </dd>
            </dl>
          </div>
            
          <div class="col-3">
            <dl>
              <dt class="text-muted">Helpdesk Reference</dt>
              <dd>
        EOT; 

        $output .= $GLOBALS["helpdeskRef"] == NULL ? "&ndash;" : $GLOBALS["helpdeskRef"];

        $output .= <<<EOT
              </dd>
            </dl>
          </div>
          <div class="col-6">
            <dl>
              <dt class="text-muted">Service</dt>
              <dd>
        EOT;

        $output .=  $GLOBALS["serviceName"];

        $output .= <<<EOT
              </dd>
            </dl>
          </div>
            
          <div class="col-12">
            <dl>
              <dt class="text-muted">Agency</dt>
              <dd>
        EOT; 

        $output .= $GLOBALS["ministryName"] == NULL ? "&ndash;" : $GLOBALS["ministryName"];

        $output .= <<<EOT
              </dd>
            </dl>
          </div>
        EOT;

        if ( $GLOBALS["projectId"] ) {

        $output .= <<<EOT
          <div class="col-6">
            <dl>
              <dt class="text-muted">Project</dt>
              <dd><a href='"
        EOT;

        $output .=  PROJECT_PAGE . "id=" . $GLOBALS['projectId'] . "' class='text-reset'>" . $GLOBALS['projectName'];

        $output .= <<<EOT
              </a></dd>
            </dl>
          </div>
          <div class="col-3">
            <dl>
              <dt class="text-muted">Created At</dt>
              <dd>
        EOT;

        $output .=  date("jS F Y", strtotime($GLOBALS['createdAt']));

        $output .= <<<EOT
              </dd>
            </dl>
          </div>
        EOT;
        }

        // Check if this ticket is not new
        if ($GLOBALS['requestStatus'] != "New") {
          $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
          $query = "SELECT * FROM request_activities WHERE requestId = " . $GLOBALS['requestId'] . " ORDER BY id DESC LIMIT 1";
          $activityResult = mysqli_query($mysqli, $query);
          $activityRow = mysqli_fetch_assoc($activityResult);

          if ($activityRow["description"] ) {
            $output .= <<<EOT
            <div class="col-12">
              <hr>
            </div>

            <div class="col-12">
              <dl>
                <dt class="text-muted">Last Activity</dt>
                <dd>
            EOT;

            $output .= $activityRow["description"];

            $output .= <<<EOT
                </dd>
              </dl>
            </div>

            </div>
            EOT;
          }
        }
        return $output;
      }
    ),
    array( 
        'db' => 'categoryLabel', 
        'formatter' => function( $d, $row ) {
          $GLOBALS['categoryLabel'] = $d;
        }
    ),
    array( 
        'db' => 'categoryName', 
        'dt' => 3,
        'formatter' => function( $d, $row ) {
          return "<span class='badge " . $GLOBALS['categoryLabel'] . "'>" . $d . "</span>";
        }
    ),
);
 
// SQL server connection information
$sql_details = array(
    'user' => DB_USER,
    'pass' => DB_PASSWORD,
    'db'   => DB_NAME,
    'host' => DB_HOST
);
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );

echo json_encode(
    //SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, $whereStatement, null )
    SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns, null, $whereStatement )
);
?>