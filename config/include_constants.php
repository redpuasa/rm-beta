<?php

// Database configuration
define("DB_HOST", "10.241.11.21");
define("DB_USER", "risk_office");
define("DB_PASSWORD", "P@ssword123");
define("DB_NAME", "rms");

// AD Request Database
define("AD_REQUEST_DB_NAME", "ad_account_request");

// AD service account
define("AD_SVC_USER", "EG\ci_svc_glauth");
define("AD_SVC_PASSWORD", '6e95d594c46c5d23!');

// Portal details
define("PORTAL_URL", "https://dev.cloud.gov.bn/rm-beta/");
define("PORTAL_NAME", "Risk Management System");
define("PORTAL_VERSION", "1.0(1)");

// Dependent page names
define("RESTRICTED_PAGE", "view/main/include_restricted.php");
define("HEADER_PAGE", "view/main/include_header.php");
// define("SIDEBAR_PAGE", "include_sidebar.php");
define("FOOTER_PAGE", "view/main/include_footer.php");

// // Content page names
define("CURRENT_PAGE", ltrim(basename($_SERVER['REQUEST_URI']), '/')); // ltrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/')
define("INDEX_PAGE", "index.php");
// define("LOGIN_PAGE", "login.php");
// define("LOGOUT_PAGE", "logout.php");
// define("LOCKSCREEN_PAGE", "lockscreen.php");

define("ADMIN_NAV","view/layouts/index.php");
define("DIVISION_LEAD_NAV", "view/layouts/index.php");
define("RISK_USER_NAV", "view/layouts/index.php");

define("ADMIN_BODY","view/layouts/index.php");
define("DIVISION_LEAD_BODY", "view/layouts/index.php");
define("RISK_USER_BODY", "view/layouts/index.php");

define("NAVIGATION", "view/main/include_navigation");
define("OPI_PAGE", "");
define("ENA_PAGE", "");
define("SMD_PAGE", "");
define("DIG_PAGE", "");
define("COR_PAGE", "");
define("GOV_PAGE", "");
define("HRD_PAGE", "");
define("FIN_PAGE", "");
define("COM_PAGE", "");


//FOR L3 USER CONTENT (RISK CHAMPION || SUB RISK CHAMPION)
define("RISK_L3", "");
define("CHARTS_L3", "");
define("TABLES_L3", "");


// define("DIVISION_PAGE", "division.php");
// define("SETTINGS_PAGE", "setting.php");
// define("ADMINS_PAGE", "admins.php");
// define("ADMIN_PAGE", "admin.php");
// define("USERS_PAGE", "users.php");
// define("USER_PAGE", "user.php");
// define("PROJECTS_PAGE", "projects.php");
// define("PROJECTS_EXPORTABLE_PAGE", "projects-exportable.php");
// define("PROJECT_PAGE", "project.php");
// define("PROJECT_APPROVAL", "project_approval.php");
// define("PROJECT_REQUEST", "project_requests.php");
define("REQUESTS_PAGE", "requests.php");
// define("REQUESTS_EXPORTABLE_PAGE", "requests-exportable.php");
// define("REQUESTS_EXPORTABLE_MINISTRY_PAGE", "requests-exportable-ministry.php");
// define("REQUEST_PAGE", "request.php");
// define("SUMMARY_RESPONSE", "summary-response.php");
// define("SUMMARY_REQUESTOR", "summary-requestors.php");
// define("SUMMARY_PROJECTS", "summary-projects.php");
// define("SUMMARY_OVERTIME", "summary-overtime.php");
// define("SUMMARY_MINISTRIES", "summary-ministries-request.php");
// define("SUMMARY_MONTH", "summary-month-request.php");
// define("MINISTRY_REQUESTS", "ministry-requests.php");
// define("RESOURCES_PAGE", "resources.php");
// define("RESOURCE_REQUEST", "server_and_database_request_form.php");
// define("RESOURCE_APPROVAL", "resource_request.php");
// define("RESOURCE_REQUESTS" , "resource_requests.php");
// define("VIRTUAL_MACHINES_PAGE", "resources.php?id=1");
// define("ORACLE_DATABASES_PAGE", "resources.php?id=2");
// define("VIRTUAL_MACHINE_PAGE", "virtual-machine.php");
// define("IP_ADDRESSES_PAGE", "ip-addresses.php");
// define("IP_ADDRESS_PAGE", "ip-address.php");
// define("LINKS_PAGE", "links.php");
// define("GUIDES_PAGE", "guides.php");
// define("GUIDE_PAGE", "guide.php");
// define("OVERTIME_PAGE", "overtime.php");
// define("FILE_PAGE", "file.php");
// define("FILES_PAGE", "files.php");
// define("FILES_OGPC_PAGE", "files_ogpc.php");
// define("FILES_PROJECT_PAGE", "files_project.php");
// define("FORM_REQUEST_PAGE", "form-request.php");
// define("FORM_REQUESTS_PAGE", "form-requests.php");
// define("MESSAGES_PAGE", "messages.php");

// Folder path config
// define("DIR_PATH", dirname(realpath(INDEX_PAGE)));
// define("UPLOAD_PATH", "/uploads/");

?>