<?php
 
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
$table = 'requests';
$table = <<<EOT
    (
        SELECT row_number() over(ORDER BY requests.id ASC) AS num,
        requests.id, requests.title, requests.createdAt,
        request_categories.name AS categoryName, 
        request_status.name AS requestStatus
        FROM requests
        INNER JOIN services ON requests.serviceId = services.id
        INNER JOIN request_categories ON requests.categoryId = request_categories.id
        INNER JOIN request_status ON requests.statusId = request_status.id
    ) temp  
EOT;

// $table = <<<EOT
//     (
//         SELECT requests.id, requests.title, requests.helpdeskRef, requests.userId, requests.updateUserId, requests.createdAt, requests.updatedAt, services.name AS serviceName, request_categories.name AS categoryName, request_categories.code AS categoryCode, request_status.name AS requestStatus, request_status.label AS statusLabel, a.name AS createdBy, b.name AS updatedBy, projects.id AS projectId, projects.name AS projectName, requests.priorityId AS priorityId, request_priorities.day AS day, DATEDIFF(CURRENT_TIMESTAMP, requests.createdAt) AS daypass FROM requests
//         INNER JOIN services ON requests.serviceId = services.id
//         INNER JOIN request_categories ON requests.categoryId = request_categories.id
//         INNER JOIN request_status ON requests.statusId = request_status.id
//         INNER JOIN request_priorities ON request_priorities.id = requests.priorityId
//         INNER JOIN users a ON requests.userId = a.id
//         LEFT JOIN users b ON requests.updateUserId = b.id AND requests.updateUserId IS NOT NULL
//         LEFT JOIN projects ON requests.projectId = projects.id
//         LEFT JOIN tickets_assignments ON requests.id = tickets_assignments.requestId AND requests.teamId != {$_SESSION["teamId"]}
//     ) temp  
// EOT;
 
$whereStatement .= " " . $whereStatement;

// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
    array( 'db' => 'num', 'dt' => 0 ),
    array( 'db' => 'title', 'dt' => 1 ),
    array( 'db' => 'categoryName', 'dt' => 2 ),
    array( 'db' => 'requestStatus', 'dt' => 3 ),
    array(
        'db'        => 'createdAt',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
            return date( 'j F Y', strtotime($d));
        }
    )
);


// original coding
    // $columns = array(
    //     array( 'db' => 'id', 'dt' => 0 ),
    //     array( 'db' => 'title', 'dt' => 1 ),
    //     array( 'db' => 'categoryId', 'dt' => 2 ),
    //     array( 'db' => 'statusId', 'dt' => 3 ),
    //     array(
    //         'db'        => 'createdAt',
    //         'dt'        => 4,
    //         'formatter' => function( $d, $row ) {
    //             return date( 'j F Y', strtotime($d));
    //         }
    //     ),
    //     // array(
    //     //     'db'        => 'salary',
    //     //     'dt'        => 5,
    //     //     'formatter' => function( $d, $row ) {
    //     //         return '$'.number_format($d);
    //     //     }
    //     // )
    // );

include_once('../include_constants.php');
 
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
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
);
?>