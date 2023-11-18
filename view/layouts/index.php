<?php include_once("config/include_system.php"); ?>

<!-- Mark this page as restricted to logged in users -->
<?php include_once("" . RESTRICTED_PAGE); ?>

<!-- Set this page's name -->
<?php define("PAGE_NAME", "Dashboard"); ?>

<!-- head -->
<?php include_once("" . HEADER_PAGE); ?>

<!-- body -->
<?php if (isDev() || isRiskAnalyst()){ ?>
<?php include_once("view/layouts/admin_body.php" . ADMIN_BODY); ?>
<?php } ?>

<?php if (isDivisionLeader()){ ?>
<?php include_once("view/layouts/division_leader_body.php" . DIVISION_LEAD_BODY); ?>
<?php } ?>

<?php if (isRiskChampion() || isSubRiskChampion()){ ?>
<?php include_once("view/layouts/risk_user_body.php" . RISK_USER_BODY); ?>
<?php } ?>

<!-- footer -->
<?php include_once("". FOOTER_PAGE); ?>