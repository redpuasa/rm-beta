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
      requests.id, requests.title, requests.projectId, requests.statusId, requests.teamId, requests.categoryId, requests.priorityId, requests.userId, requests.updateUserId, requests.helpdeskRef,requests.createdAt As createdAt, requests.updatedAt, DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) AS daypass, requests.teamIds, requests.requestorMinistryId AS requestorMinistryId,
      request_categories.name AS categoryName, request_categories.label AS categoryLabel, request_categories.code AS categoryCode,
      request_status.name AS requestStatus, request_status.label AS requestLabel,
      request_priorities.name AS priorityName, request_priorities.day AS day,
      a.name AS createdBy, b.name AS updatedBy,
      services.name AS serviceName,
      projects.name AS projectName,
      concat(request_categories.code,'-',date_format(requests.createdAt,'%Y%m%d'),'-',requests.id) AS referenceId
      FROM requests
      INNER JOIN services ON requests.serviceId = services.id
      INNER JOIN request_categories ON requests.categoryId = request_categories.id
      INNER JOIN request_status ON requests.statusId = request_status.id
      INNER JOIN request_priorities ON requests.priorityId = request_priorities.id
      INNER JOIN users a ON requests.userId = a.id
      LEFT JOIN users b ON requests.updateUserId = b.id AND requests.updateUserId IS NOT NULL
      LEFT JOIN projects ON requests.projectId = projects.id
    ) temp";

// Table's primary key
$primaryKey = 'id';

if ($_GET["ministryId"] && $_GET["month"] && $_GET["year"]) {
  $year = $_GET["year"];
  $month = $_GET["month"];
  $ministryId = $_GET["ministryId"];

  $whereStatement = "(MONTHNAME(createdAt) = '$month' AND YEAR(createdAt) = '$year') AND requestorMinistryId = '$ministryId'";

} 

else if ($_GET["ministryId"]){
  $ministryId = $_GET["ministryId"];
  $whereStatement = "requestorMinistryId = '$ministryId'";
} 



// Show all service tickets if user is admin/service desk manager/reviewer
// Else show only the team's tickets
if (!(isSuperAdmin() || isServiceDeskManager() || isServiceDeskTeam() || isReviewer())) {
  $whereStatement .= $whereStatement == "" ? "" : " AND ";
  $whereStatement .= "(teamId = " . $_SESSION['teamId'] . " OR FIND_IN_SET('" . $_SESSION['teamId'] . "', teamIds) > 0)";
}
 
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
      'dt' => 4, 
      'formatter' => function( $d, $row ) {
          $GLOBALS['referenceId'] = $d;
      }
    ),
    array( 
      'db' => 'helpdeskRef',
    ),
    array( 
      'db' => 'projectId', 
      'formatter' => function( $d, $row ) {
          $GLOBALS['projectId'] = $d;
      }
    ),
    array( 
      'db' => 'projectName', 
      'dt' => 6,
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
      'formatter' => function( $d, $row ) {
          $GLOBALS['updatedAt'] = $d;
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
      'dt' => 5,
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
      'dt' => 3,
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
        'dt' => 2,
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