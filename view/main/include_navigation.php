<!-- Start Header Top Area -->
<!-- <div class="header-top-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="logo-area" style="width: 65%;">
                    <a href="#"><img src="public/img/logo/header_logo_light.png" alt="" /></a>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="header-top-menu">
                    <ul class="nav navbar-nav notika-top-nav ">
                        <li class="nav-item dropdown">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span><i class="notika-icon notika-search"></i></span></a>
                            <div role="menu" class="dropdown-menu search-dd animated flipInX">
                                <div class="search-input">
                                    <i class="notika-icon notika-left-arrow"></i>
                                    <input type="text" />
                                </div>
                            </div>
                        </li>
                        <li class="nav-item nc-al"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle"><span><i class="notika-icon notika-alarm"></i></span><div class="spinner4 spinner-4"></div><div class="ntd-ctn"><span>3</span></div></a>
                            <div role="menu" class="dropdown-menu message-dd notification-dd animated zoomIn">
                                <div class="hd-mg-tt">
                                    <h2>Notification</h2>
                                </div>
                                <div class="hd-message-info">
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="img/post/1.jpg" alt="" />
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>David Belle</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="img/post/2.jpg" alt="" />
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>Jonathan Morris</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="img/post/4.jpg" alt="" />
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>Fredric Mitchell</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="img/post/1.jpg" alt="" />
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>David Belle</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="#">
                                        <div class="hd-message-sn">
                                            <div class="hd-message-img">
                                                <img src="img/post/2.jpg" alt="" />
                                            </div>
                                            <div class="hd-mg-ctn">
                                                <h3>Glenn Jecobs</h3>
                                                <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="hd-mg-va">
                                    <a href="#">View All</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- End Header Top Area -->


<!-- DEVELOPER || ADMIN NAVIGATION BAR -->


<?php if(isDev() || isRiskAnalyst()) { ?>
<!-- Mobile Menu start -->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mobile-menu">
                    <nav id="dropdown">
                        <ul class="mobile-menu-nav">
                            <li><a data-toggle="collapse" data-target="#Charts" href="#">Home</a>
                                <ul class="collapse dropdown-header-top">
                                    <li><a href="index.html">Dashboard One</a></li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#demoevent" href="#">OPI</a>
                                <ul id="demoevent" class="collapse dropdown-header-top">
                                    <li><a href="inbox.html">EUC</a></li>
                                    <li><a href="view-email.html">NETWORK</a></li>
                                    <li><a href="compose-email.html">CLOUD INFRA</a></li>
                                    <li><a href="compose-email.html">GNOC 1</a></li>
                                    <li><a href="compose-email.html">GNOC 2</a></li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#democrou" href="#">ENTERPRISE APPLICATION</a>
                                <ul id="democrou" class="collapse dropdown-header-top">
                                    <li><a href="animations.html">CENTRAL INTRA PLATFORM</a></li>
                                    <li><a href="google-map.html">SCOM</a></li>
                                    <li><a href="data-map.html">CWH</a></li>
                                    <li><a href="code-editor.html">ENT COM</a></li>
                                    <li><a href="image-cropper.html">E-SERVICES APP</a></li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#demolibra" href="#">SERVICE MANGEMENT</a>
                                <ul id="demolibra" class="collapse dropdown-header-top">
                                    <li><a href="flot-charts.html">SDBRM</a></li>
                                    <li><a href="bar-charts.html">ACM</a></li>
                                    <li><a href="line-charts.html">TD123</a></li>
                                    <li><a href="area-charts.html">CRM</a></li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#demodepart" href="#">DIGITALISATION</a>
                                <ul id="demodepart" class="collapse dropdown-header-top">
                                    <li><a href="normal-table.html">SAO</a></li>
                                    <li><a href="data-table.html">DMO</a></li>
                                    <li><a href="data-table.html">DSD</a></li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#demo" href="#">GOVERNANCE</a>
                                <ul id="demo" class="collapse dropdown-header-top">
                                    <li><a href="form-elements.html">PGMO</a></li>
                                    <li><a href="form-components.html">PGO</a></li>
                                    <li><a href="form-examples.html">PRMO</a></li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#demo" href="#">CORPORATE</a>
                                <ul id="demo" class="collapse dropdown-header-top">
                                    <li><a href="form-elements.html">ADMINISTRATION</a></li>
                                    <li><a href="form-components.html">SPMF</a></li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#demo" href="#">HR</a>
                                <ul id="demo" class="collapse dropdown-header-top">
                                    <li><a href="form-elements.html">RESOURCE MANAGEMENT</a></li>
                                    <li><a href="form-components.html">CAPABILITY DEVELOPMENT</a></li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#demo" href="#">FINANCIAL MANAGEMENT</a>
                                <ul id="demo" class="collapse dropdown-header-top">
                                    <li><a href="form-elements.html">FINANCE</a></li>
                                    <li><a href="form-components.html">PROCUREMENT</a></li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#demo" href="#">COMPLIANCE</a>
                                <ul id="demo" class="collapse dropdown-header-top">
                                    <li><a href="form-elements.html">LCM</a></li>
                                    <li><a href="form-elements.html">BPIO</a></li>
                                    <li><a href="form-components.html">RMO</a></li>
                                </ul>
                            </li>
                            <li><a data-toggle="collapse" data-target="#Pagemob" href="#">REQUEST</a>
                                <ul id="Pagemob" class="collapse dropdown-header-top">
                                    <li><a href="contact.html">CONTACT</a></li>
                                    <li><a href="contact.html">REQUEST APPLICATION</a></li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Mobile Menu end -->

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

<!-- Main Menu area begin-->
<div class="main-menu-area mg-tb-40">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="nav nav-tabs notika-menu-wrap menu-it-icon-pro">
                    <li class="active <?php if (CURRENT_PAGE == INDEX_PAGE) echo " active"; ?>"><a data-toggle="tab" href="<?php echo INDEX_PAGE ?>"><i class="notika-icon notika-house"></i> Home</a></li>
                    <li class="active <?php if (CURRENT_PAGE == INDEX_PAGE) echo " active"; ?>"><a data-toggle="tab" href="<?php echo OPI_PAGE ?>"><i class="notika-icon notika-mail"></i> OPI</a></li>
                    <li class="active <?php if (CURRENT_PAGE == INDEX_PAGE) echo " active"; ?>"><a data-toggle="tab" href="<?php echo ENA_PAGE ?>"><i class="notika-icon notika-edit"></i> EA</a></li>
                    <li class="active <?php if (CURRENT_PAGE == INDEX_PAGE) echo " active"; ?>"><a data-toggle="tab" href="<?php echo SMD_PAGE ?>"><i class="notika-icon notika-bar-chart"></i> SM</a></li>
                    <li class="active <?php if (CURRENT_PAGE == INDEX_PAGE) echo " active"; ?>"><a data-toggle="tab" href="<?php echo DIG_PAGE ?>"><i class="notika-icon notika-form"></i> Digitalisation</a></li>
                    <li class="active <?php if (CURRENT_PAGE == INDEX_PAGE) echo " active"; ?>"><a data-toggle="tab" href="<?php echo GOV_PAGE ?>"><i class="notika-icon notika-app"></i> Governance</a></li>
                    <li class="active <?php if (CURRENT_PAGE == INDEX_PAGE) echo " active"; ?>"><a data-toggle="tab" href="<?php echo COR_PAGE ?>"><i class="notika-icon notika-support"></i> Corporate</a></li>
                    <li class="active <?php if (CURRENT_PAGE == INDEX_PAGE) echo " active"; ?>"><a data-toggle="tab" href="<?php echo HRD_PAGE ?>"><i class="notika-icon notika-support"></i> HR</a></li>
                    <li class="active <?php if (CURRENT_PAGE == INDEX_PAGE) echo " active"; ?>"><a data-toggle="tab" href="<?php echo FIN_PAGE ?>"><i class="notika-icon notika-support"></i> Finance</a></li>
                    <li class="active <?php if (CURRENT_PAGE == INDEX_PAGE) echo " active"; ?>"><a data-toggle="tab" href="<?php echo COM_PAGE ?>"><i class="notika-icon notika-support"></i> Compliance</a></li>
                </ul>
                    <div class="tab-content custom-menu-content">
                        <div id="<?php echo OPI_PAGE ?>" class="tab-pane in active notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="<?php   ?>">Operation & Infrastructure</a></li>
                                <li><a href="<?php   ?>">End User Computing</a></li>
                                <li><a href="<?php   ?>">Cloud Infrastructure</a></li>
                                <li><a href="<?php   ?>">GNOC 1</a></li>
                                <li><a href="<?php   ?>">GNOC 2</a></li>  
                            </ul>
                        </div>
                        <div id="<?php echo ENA_PAGE ?>" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="index.html">Enterprise Application</a></li>
                                <li><a href="index-2.html">SCOM</a></li>
                                <li><a href="index-3.html">Central Web Hosting</a></li>
                                <li><a href="index-4.html">Enterprise Communication</a></li>
                                <li><a href="analytics.html">E-Services Application</a></li>
                            </ul>
                        </div>
                        <div id="<?php echo SMD_PAGE ?>" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="index.html">Service Management</a></li>
                                <li><a href="index-2.html">Service Desk & Business Relationship Management</a></li>
                                <li><a href="index-3.html">Asset & Capability Management</a></li>
                                <li><a href="index-4.html">TD123 & Problem Management</a></li>
                                <li><a href="analytics.html">Change & Release Management</a></li>
                            </ul>
                        </div>
                        <div id="<?php echo DIG_PAGE ?>" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="index.html">Digitalsation</a></li>
                                <li><a href="index-2.html">Solution Architect Office</a></li>
                                <li><a href="index-3.html">Data Management Office</a></li>
                                <li><a href="index-4.html">Digital Services Development</a></li>
                            </ul>
                        </div>
                        <div id="<?php echo GOV_PAGE ?>" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="index.html">Governance</a></li>
                                <li><a href="index-2.html">Programme Management Office</a></li>
                                <li><a href="index-3.html">Planning & Governance</a></li>
                                <li><a href="index-4.html">Project Management Office</a></li>
                            </ul>
                        </div>
                        <div id="<?php echo COR_PAGE ?>" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="index.html">Corporate</a></li>
                                <li><a href="index-2.html">Administration</a></li>
                                <li><a href="index-3.html">Information & Facilities Management</a></li>
                            </ul>
                        </div>
                        <div id="<?php echo HRD_PAGE ?>" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="index.html">Human Resource</a></li>
                                <li><a href="index-2.html">Resource Management</a></li>
                                <li><a href="index-3.html">Capability Development</a></li>
                            </ul>
                        </div>
                        <div id="<?php echo FIN_PAGE ?>" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="index.html">Financial Management</a></li>
                                <li><a href="index-2.html">Finance</a></li>
                                <li><a href="index-3.html">Procurement</a></li>
                            </ul>
                        </div>
                        <div id="<?php echo COM_PAGE ?>" class="tab-pane notika-tab-menu-bg animated flipInX">
                            <ul class="notika-main-menu-dropdown">
                                <li><a href="index.html">Compliance</a></li>
                                <li><a href="index-2.html">Legal & Contract Management Office</a></li>
                                <li><a href="index-2.html">Business Process Improvement Office</a></li>
                                <li><a href="index-2.html">Risk Management Office</a></li>
                            </ul>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Menu area End-->
<?php } ?>

<!-- DIVISION LEADER NAVIGATION BAR -->

<?php if (isDivisionLeader()){ ?> 
    
    


<?php } ?>



<!-- RISK CHAMPION || SUB RISK CHAMPION NAVGIATION BAR -->


<?php if (isRiskChampion() || isSubRiskChampion()){ ?> 
    
    


<?php } ?>