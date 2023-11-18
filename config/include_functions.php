<?php
date_default_timezone_set("Asia/Brunei");

function timeElapsedOnline($datetime, $full = false) {
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  $string = array(
    'y' => 'year',
    'm' => 'month',
    'w' => 'week',
    'd' => 'day',
    'h' => 'hr',
    'i' => 'min',
    's' => 'sec',
  );
  foreach ($string as $k => &$v) {
    if ($diff->$k) {
      $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    } else {
      unset($string[$k]);
    }
  }

  if (!$full) $string = array_slice($string, 0, 1);
  return $string ? implode(', ', $string) . ' ago' : 'Online';
}

function time_elapsed_string($datetime, $full = false) {
  $now = new DateTime;
  $ago = new DateTime($datetime);
  $diff = $now->diff($ago);

  $diff->w = floor($diff->d / 7);
  $diff->d -= $diff->w * 7;

  $string = array(
    'y' => 'year',
    'm' => 'month',
    'w' => 'week',
    'd' => 'day',
    'h' => 'hour',
    'i' => 'minute',
    's' => 'second',
  );
  foreach ($string as $k => &$v) {
    if ($diff->$k) {
      $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
    } else {
      unset($string[$k]);
    }
  }

  if (!$full) $string = array_slice($string, 0, 1);
  return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function getDurationFromMonth($monthNum) {
  $y = $monthNum / 12;
  $m = $monthNum % 12;

  $month = '';
  if ($m >= 1) {
    $month = ' ' . $m . ' month' . ($m > 1 ? 's' : '');
  }

  if ($y >= 1) {
    $r = floor($y);
    return $r . ' year' . ($r > 1 ? 's' : '') . $month;
  }

  return $monthNum . ' month' . ($monthNum > 1 ? 's' : '');
}

function isDev() {
  if(isset($_SESSION["role_id"])) {
    if (strpos($_SESSION["role_id"], 1) !== false) {
      return true;
    }
    return false;
  }
}

function isRiskChampion() {
    if(isset($_SESSION["role_id"])) {
      if (strpos($_SESSION["role_id"], 2) !== false) {
        return true;
      }
      return false;
    }
  }

  function isSubRiskChampion() {
    if(isset($_SESSION["role_id"])) {
      if (strpos($_SESSION["role_id"], 3) !== false) {
        return true;
      }
      return false;
    }
  }

  function isRiskAnalyst() {
    if(isset($_SESSION["role_id"])) {
      if (strpos($_SESSION["role_id"], 4) !== false) {
        return true;
      }
      return false;
    }
  }

  function isDivisionLeader() {
    if(isset($_SESSION["role_id"])) {
      if (strpos($_SESSION["role_id"], 5) !== false) {
        return true;
      }
      return false;
    }
  }


function getUserId(){
  $query = "SELECT FROM WHERE";
  
}

function getRiskRegisteredBySection($section_id) {
    global $mysqli; // get the global mysqli connection
  
    $array = [];
  
    // Get the user's projects
    $query = "SELECT risk.section_id FROM risk
      WHERE risk.section_id = $section_id
      ORDER BY risk_id";
    $result = mysqli_query($mysqli, $query);
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $array[] = $row["projectId"];
      }
    }
    return $array;
}

// function getUserProjects($userId) {
//   global $mysqli; // get the global mysqli connection

//   $array = [];

//   // Get the user's projects
//   $query = "SELECT users_projects.projectId FROM users_projects
//     WHERE users_projects.userId = $userId
//     ORDER BY projectId";
//   $result = mysqli_query($mysqli, $query);
//   if (mysqli_num_rows($result) > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//       $array[] = $row["projectId"];
//     }
//   }

//   return $array;
// }

// function getProjectUsers($projectId) {
//   global $mysqli; // get the global mysqli connection

//   $array = [];

//   // Get the user's projects
//   $query = "SELECT users_projects.userId FROM users_projects
//     WHERE users_projects.projectId = $projectId
//     ORDER BY userId";
//   $result = mysqli_query($mysqli, $query);
//   if (mysqli_num_rows($result) > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//       $array[] = $row["userId"];
//     }
//   }

//   return $array;
// }

function emailed($teamName, $teamEmail, $ticket, $title, $requestorName, $requestorMinistry, $requestorDepartment, $case, $services, $requestId) {

  global $mysqli;

  if (intval($case == "0")) {
    $to = $teamEmail;
    $subject = "Service Request Added: $title ($ticket)";
    $salutation = "Dear $teamName,";
    $body = '
    A new service request that was recently submitted by you has been added successfully with the following details:<br />
    <br />
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="right" style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt; padding: 0 5px;" width="20%">
                <strong>Reference</strong>
            </td>
            <td style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt;">
                ' . $ticket . '
            </td>
        </tr>
        <tr>
            <td align="right" style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt; padding: 0 5px;">
                <strong>Title</strong>
            </td>
            <td style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt;">
                ' . $title . '
            </td>
        </tr>
        <tr>
            <td align="right" style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt; padding: 0 5px;">
                <strong>Requestor Name</strong>
            </td>
            <td style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt;">
                ' . $requestorName . '
            </td>
        </tr>
        <tr>
            <td align="right" style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt; padding: 0 5px;">
                <strong>Ministry</strong>
            </td>
            <td style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt;">
                ' . $requestorMinistry . '
            </td>
        </tr>
        <tr>
            <td align="right" style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt; padding: 0 5px;">
                <strong>Department</strong>
            </td>
            <td style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt;">
                ' . $requestorDepartment . '
            </td>
        </tr>
        <tr>
            <td align="right" style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt; padding: 0 5px;">
                <strong>Service</strong>
            </td>
            <td style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt;">
                ' . $services . '
            </td>
        </tr>
    </table>
    <br />
    
    <a href="' . PORTAL_URL . '' . REQUEST_PAGE . '?id=' . $requestId . '">Any updates on this call should be made here</a>.<br />
    <br />';
  }

  //send email to support team
  if (intval($case == "1")) {
    $to = $teamEmail;
    $subject = "Ticket Opened: $title ($ticket)";
    $salutation = "Dear $teamName team,";
    $body = ' Ticket number <strong>' . $ticket . '</strong> has been escalated to you for your next action.<br/><br/><a href="' . PORTAL_URL . '' . REQUEST_PAGE . '?id=' . $requestId . '">Please click here to view the ticket.</a><br/><br/>';
  }
  //send email to support team
  if (intval($case == "2")) {
    $to = $teamEmail;
    $subject = "Ticket Completed: $title ($ticket)";
    $salutation = "Dear $teamName team,";
    $body = 'Ticket number <strong>' . $ticket . '</strong> has been marked as completed.<br/><br/><a href="' . PORTAL_URL . '' . REQUEST_PAGE . '?id=' . $requestId . '">Please click here to view the ticket.</a><br/><br/>';
  }
  //send email to helpdesk to inform ticket completion
  if (intval($case == "3")) {
    $to = $teamEmail;
    $subject = "Ticket Completed: $title ($ticket)";
    $salutation = "Dear $teamName team,";
    $body = 'Ticket number <strong>' . $ticket . '</strong> has been marked as completed.<br/><br/><a href="' . PORTAL_URL . '' . REQUEST_PAGE . '?id=' . $requestId . '">Please click here to view the ticket</a><br/><br/>';
  }

  if (intval($case == "4")) {
    $to = $teamEmail;
    $subject = "Ticket Closed: $title ($ticket)";
    $salutation = "Dear $teamName team,";
    $body = 'The ticket number <strong>' . $ticket . '</strong> has been closed.<br/><br/><a href="' . PORTAL_URL . '' . REQUEST_PAGE . '?id=' . $requestId . '">Please click here to view the ticket</a><br/><br/>';
  }

  if (intval($case == "5")) {
    $to = $teamEmail;
    $subject = "Ticket Cancelled: $title ($ticket)";
    $salutation = "Dear $teamName team,";
    $body = 'The ticket number <strong>' . $ticket . '</strong> has been cancelled.<br/><br/><a href="' . PORTAL_URL . '' . REQUEST_PAGE . '?id=' . $requestId . '">Please click here to view the ticket</a><br/><br/>';
  }

  if (intval($case == "6")) {
    $to = $teamEmail;
    $subject = "Ticket Reminder: $title ($ticket)";
    $salutation = "Dear $teamName team,";
    $body = 'The ticket number <strong>' . $ticket . '</strong> has not been been resolve and need your immediate action.<br/><br/><a href="' . PORTAL_URL . '' . REQUEST_PAGE . '?id=' . $requestId . '">Please click here to view the ticket.</a><br/><br/>';
  }

  ini_set("SMTP", "mailrelay.egc.gov.bn");

  $message = '
  <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>' . $subject . '</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    </head>
    <body style="background-color: #f4f6f9">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
            <td bgcolor="#1f4782" style="color: #fff; font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt; padding: 10pt;">
                <span style="font-size: 14pt;"><strong>Cloud Infrastructure</strong></span><br />
                Service Portal
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt; padding: 10pt;">
                ' . $salutation . '<br />
                <br />
                ' . $body . '
                
                <strong>' . PORTAL_NAME .'</strong>
                <br /> E-Government National Centre <br />
                <br />
                <span style="color: #800; font-size: 10pt;">This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.</span>
            </td>
        </tr>
    </table>
    </body>
    </html>';

  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  // Additional headers
  $headers .= 'From: ' . PORTAL_NAME . ' <noreply@egc.gov.bn>' . "\r\n";
  $headers .= 'To: ' . $to . "\r\n";

  mail($to, $subject, $message, $headers);
}

function formEmail($ticket, $title, $formType, $requestorName, $requestorEmail, $case, $formId, $remarks)
{

  global $mysqli_ogpc;

  if ($formType == "vpn") {
    define("DB_TABLE_FORM", "vpn_form");
  }
  if ($formType == "rff") {
    define("DB_TABLE_FORM", "rff_form");
  }
  if ($formType == "cwh") {
    define("DB_TABLE_FORM", "cwh_form");
  }
  if ($formType == "cip") {
    define("DB_TABLE_FORM", "cip_form");
  }

  $sql = "SELECT * FROM " . DB_TABLE_FORM . " WHERE id = $formId";
  $result = mysqli_query($mysqli_ogpc, $sql);
  if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
          $token = $row["token"];
      }
  }

  //notify requestor that the request has been approved and given the ticket reference number for that request
  if (intval($case == "1")) {
    $to = $requestorEmail;
    $subject = "[APPROVED] Request for $title ($ticket)";
    $salutation = "YM, $requestorName";
    $body = 'Your request with the ticket reference: <strong>'. $ticket . '</strong> has been approved.<br/><br/>';
    define("SERVICE_PORTAL", "$title");
    define("PORTAL_NAME_EMAIL", "$title");
  }

  if (intval($case == "2")) {
    $to = $requestorEmail;
    $subject = "[REJECTED] Request for $title ($ticket)";
    $salutation = "YM, $requestorName";
    $body = 'Your request for '. $title .' (Ticket Reference:<strong>'. $ticket.'</strong>)  has been rejected.<br/><br/>Reason: ' . $remarks . '<br/><br/>';
    define("SERVICE_PORTAL", "$title");
    define("PORTAL_NAME_EMAIL", "$title");
  }

  if (intval($case == "3")) {
    $to = $requestorEmail;
    $subject = "[STATUS QUERY] Request for $title";
    $salutation = "YM, $requestorName";
    $body = 'A status query has been sent to you regarding your request.<br/><br/>Click <a href="'. FORM_URL . $formType.'/request.php?token='.$token.'">here</a> to view the query.<br/><br/>';
    define("SERVICE_PORTAL", "$title");
    define("PORTAL_NAME_EMAIL", "$title");
  }

  if (intval($case == "4")) {
    $to = $requestorEmail;
    $subject = "[COMPLETED] Request for $title ($ticket)";
    $salutation = "YM, $requestorName";
    if ($formType == "vpn") {
      $body = 'Your request for '. $title .' (Ticket Reference:<strong>'. $ticket.'</strong>) has been completed.<br/><br/>Remarks:<br/>'.$remarks.'<br/><br/>If you have any issues or enquiries regarding your request please contact our helpdesk team via email: <a href="mailto:helpdesk@egc.gov.bn">helpdesk@egc.gov.bn</a> or call our hotline: 2424959 <br/><br/>';
    } else {
      $body = 'Your request for '. $title .' (Ticket Reference:<strong>'. $ticket.'</strong>) has been completed.<br/><br/>If you have any issues or enquiries regarding your request please contact our helpdesk team via email: <a href="mailto:helpdesk@egc.gov.bn">helpdesk@egc.gov.bn</a> or call our hotline: 2424959 <br/><br/>';
    }
    define("SERVICE_PORTAL", "$title");
    define("PORTAL_NAME_EMAIL", "$title");
  }

  ini_set("SMTP", "mailrelay.egc.gov.bn");

  $message = '
  <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>' . $subject . '</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    </head>
    <body style="background-color: #f4f6f9">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
            <td bgcolor="#1f4782" style="color: #fff; font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt; padding: 10pt;">
                <span style="font-size: 14pt;"><strong>'. SERVICE_PORTAL .'</strong></span><br />
                Service Portal
            </td>
        </tr>
        <tr>
            <td bgcolor="#ffffff" style="font-family: Calibri, Arial, Helvetica, sans-serif; font-size: 11pt; padding: 10pt;">
                ' . $salutation . '<br />
                <br />
                ' . $body . '
                
                <strong>' . PORTAL_NAME_EMAIL .'</strong>
                <br /> E-Government National Centre <br />
                <br />
                <span style="color: #800; font-size: 10pt;">This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.</span>
            </td>
        </tr>
    </table>
    </body>
    </html>';

  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  // Additional headers
  $headers .= 'From: ' . PORTAL_NAME . ' <noreply@egc.gov.bn>' . "\r\n";
  $headers .= 'To: ' . $to . "\r\n";

  mail($to, $subject, $message, $headers);
}

function serviceRequestEmail($id)
{
  global $mysqli_ad_request;

  $sql = "SELECT requests.*, requests.createdAt AS requestCreatedAt, name FROM requests 
    LEFT JOIN ad_requests ON requests.id = ad_requests.requestId 
    LEFT JOIN service_requests ON requests.id = service_requests.requestId
    WHERE requests.id = '$id'";

  $result = mysqli_query($mysqli_ad_request, $sql);
  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
  }

  $to = "khairunajaah.kamis@egc.gov.bn"; //ISO TEAM EMAIL
  $subject = "New Request for Government Account (" . $row["requestType"] . ")";
  $title = "New Request for Government Account (" . $row["requestType"] . ")";
  $salutation = "Dear ISO Team,";
  $body = 'A new ' . $row["requestType"] . ' request has been submitted.  Ticket Reference: <strong>SR-' . date("Ymd", strtotime($row["requestCreatedAt"])) . "-" . $row["ticketId"] . '</strong><br/><br/><a href="' . PORTAL_AD . '/service_acc_view.php?requestId=' . $id . '">Please click here to process the request.</a>';

  ini_set("SMTP", "mailrelay.egc.gov.bn");

  $message = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>' . $subject . '</title>
            <!-- Tell the browser to be responsive to screen width -->
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <!-- Style -->
            <style type="text/css">
            body {
                -webkit-font-smoothing: antialiased;
                -webkit-text-size-adjust: none;
                background-color: #f8f9fa !important;
                font-family: \'Segoe UI\', Calibri, Arial, Helvetica, sans-serif;
                font-size: 12px;
            }
        
            table,
            td,
            th {
                border: 1px solid gray;
            }
        
            table {
                /* width: 100%; */
                border-collapse: collapse;
            }
        
            td {
                padding: 3px 6px;
            }
        
            mark {
                background-color: yellow;
            }
            </style>
        </head>
        <body>
            <table cellpadding="0" cellspacing="0" width="600px">
                <tr>
                    <td bgcolor="#292759" style="color: #fff; padding: 12px;">
                    <center><span style="font-size: 16px;"><strong>E-Government National Centre</strong></span></center>
                    <center> Request for Government Account </center>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding: 12px;">
                        <center>
                            <h3>
                            <strong>' . $title . '</strong>
                            </h3>
                        </center>' . $salutation . ' <br />
                        <br />' . $body . '<br />
                        <br />
                        <strong>Request for Government Account</strong>
                        <br /> E-Government National Centre <br />
                        <br />
                        <span style="color: #c55; font-size: 12px;">Please note: This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.</span>
                    </td>
                </tr>
            </table>
        </body>
        </html>';

  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  // Additional headers
  $headers .= 'From: Request for Government Account <noreply@egc.gov.bn>' . "\r\n";
  $headers .= 'To: ' . $to . "\r\n";

  mail($to, $subject, $message, $headers);
}

function cancelResourceRequestEmail($id)
{
  global $mysqli;

  $sql = "SELECT resource_requests.* , a.name AS projectName, b.name AS typeName FROM resource_requests
  INNER JOIN projects a ON resource_requests.projectId = a.id
  INNER JOIN resource_request_type b ON resource_requests.typeId = b.id
  WHERE resource_requests.id = $id";

  $result = mysqli_query($mysqli, $sql);
  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
  }

  $to = "khairunajaah.kamis@egc.gov.bn"; //CLOUD TEAM EMAIL
  $subject = "Resource Requests Cancelled";
  $title = "Resource Requests Cancelled";
  $salutation = "Dear Cloud Team,";
  $body = 'A Resource Request has been cancelled. Ticket reference: <strong>SR-' . date("Ymd", strtotime($row["createdAt"])) . "-" . $row["ticketId"] .'</strong></br></br> <a href="' . PORTAL_URL .'/resource_request.php?project_id=' . $row['projectId'] .'&request_id=' . $id .'">Please click here for more details</a>';

  ini_set("SMTP", "mailrelay.egc.gov.bn");

  $message = '<!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>' . $subject . '</title>
            <!-- Tell the browser to be responsive to screen width -->
            <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
            <!-- Style -->
            <style type="text/css">
            body {
                -webkit-font-smoothing: antialiased;
                -webkit-text-size-adjust: none;
                background-color: #f8f9fa !important;
                font-family: \'Segoe UI\', Calibri, Arial, Helvetica, sans-serif;
                font-size: 12px;
            }
        
            table,
            td,
            th {
                border: 1px solid gray;
            }
        
            table {
                /* width: 100%; */
                border-collapse: collapse;
            }
        
            td {
                padding: 3px 6px;
            }
        
            mark {
                background-color: yellow;
            }
            </style>
        </head>
        <body>
            <table cellpadding="0" cellspacing="0" width="600px">
                <tr>
                    <td bgcolor="#292759" style="color: #fff; padding: 12px;">
                    <center><span style="font-size: 16px;"><strong>E-Government National Centre</strong></span></center>
                    <center> Cloud Portal </center>
                    </td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff" style="padding: 12px;">
                        <center>
                            <h3>
                            <strong>' . $title . '</strong>
                            </h3>
                        </center>' . $salutation . ' <br />
                        <br />' . $body . '<br />
                        <br />
                        <strong>Cloud Portal</strong>
                        <br /> E-Government National Centre <br />
                        <br />
                        <span style="color: #c55; font-size: 12px;">Please note: This email was sent from a notification-only address that cannot accept incoming email. Please do not reply to this message.</span>
                    </td>
                </tr>
            </table>
        </body>
        </html>';

  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  // Additional headers
  $headers .= 'From: Cloud Portal <noreply@egc.gov.bn>' . "\r\n";
  $headers .= 'To: ' . $to . "\r\n";

  mail($to, $subject, $message, $headers);
}


function splitStartTime($startTime, $endTime, $duration = "450") {
  $returnArray = array(); // Define output
  $startTime    = strtotime($startTime); //Get Timestamp
  $endTime      = strtotime($endTime); //Get Timestamp

  $addMins  = $duration * 60;

  while ($startTime <= $endTime) { //Run loop
    $returnArray[] = date("Y-m-d H:i:s", $startTime);
    $startTime += $addMins; //Endtime check
  }
  return $returnArray;
}

function splitEndTime($startTime, $endTime, $duration = "450") {
  $returnArray = array(); // Define output
  $startTime    = strtotime($startTime); //Get Timestamp
  $endTime      = strtotime($endTime); //Get Timestamp

  $addMins  = $duration * 60;

  while ($startTime <= $endTime) { //Run loop
    $startTime += $addMins; //Endtime check
    if ($startTime < $endTime) {
      $returnArray[] = date("Y-m-d H:i:s", $startTime);
    } else {
      $returnArray[] = date("Y-m-d H:i:s", $endTime);
    }
  }
  return $returnArray;
}
