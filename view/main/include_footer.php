</div>
  <!-- /.content-wrapper -->
  
  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> <?php echo PORTAL_VERSION; ?>
    </div>
    Copyright &copy; 2015-<?php echo date("Y"); ?> Cloud Infrastructure. Powered by <strong><a href="http://www.cloud.gov.bn">One Government Private Cloud</a></strong>. All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- DataTables & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="plugins/datatables-colreorder/js/dataTables.colReorder.min.js"></script>
<script src="plugins/datatables-fixedheader/js/dataTables.fixedHeader.min.js"></script>
<!-- Ion Slider -->
<script src="plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- AdminLTE -->
<script src="js/adminlte.js"></script>

<!-- page script -->
<script src="js/dark-mode-switch.js"></script>
<script>
  <?php if (ltrim(parse_url(CURRENT_PAGE, PHP_URL_PATH), '/') == PROJECT_PAGE || ltrim(parse_url(CURRENT_PAGE, PHP_URL_PATH), '/') == RESOURCE_REQUEST ) { ?>
    //hide other tabs if one tab is selected
    function formTab(evt, tabName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.className += " active";
    }
    document.getElementById("tab1").click();
    
    //function for the previous and next button
    function prevNext(evt, tabName, tabId) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(tabName).style.display = "block";
      evt.currentTarget.className += " active";
      document.getElementById(tabId).click();
      
      //anchor jump without showing the anchor at the end of the url
      var url = location.href;
      location.href = "#top"
      history.replaceState(null, null, url);
      
      // document.body.scrollTop = 300;
      // document.documentElement.scrollTop = 300;
    }
  <?php } ?>

  if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
  }
</script>
<script>
$(document).ready(function () {
  // the code below will break datatables view, need to declare MESSAGES_PAGE in include_constants.php
  // <?php //if (CURRENT_PAGE == MESSAGES_PAGE || strpos(CURRENT_PAGE, MESSAGES_PAGE) !== false) { ?>
  // $("#chatbox").animate({ 
  //   scrollTop: $('#chatbox').get(0).scrollHeight
  // }, 1000);
  // <?php //} ?>
  
  $("#example1").DataTable({
    aLengthMenu: [
      [15, 30, 100, -1],
      [15, 30, 100, "All"]
    ],
    "ordering": true,
    colReorder: true,
    fixedHeader: true,
    "buttons": [
      {
        extend: 'csv',
        exportOptions: {
            columns: ':visible'
        }
      },
      {
        extend: 'excel',
        exportOptions: {
            columns: ':visible'
        }
      },
      {
        extend: 'pdf',
        exportOptions: {
            columns: ':visible'
        }
      },
      {
        extend: 'print',
        exportOptions: {
            columns: ':visible'
        }
      },
      "colvis"]
  }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

  $(".normalTable").DataTable({
    "ordering": false,
    colReorder: true,
    fixedHeader: true,
  });

  $(".sortTable").DataTable({
    "ordering": true,
    colReorder: true,
    fixedHeader: true,
  });

  <?php if (ltrim(parse_url(CURRENT_PAGE, PHP_URL_PATH), '/') == REQUESTS_PAGE ) { ?>
  var t = $('#ajaxTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "scripts/server_processing.php",
                "data": {
                    "category"    : '<?= $_GET['category'] ?>',
                    "categoryId"  : '<?= $_GET['categoryId'] ?>',
                    "status"      : '<?= $_GET['status'] ?>',
                    "teamId"      : '<?= $_SESSION['teamId'] ?>',
                    "week"        : '<?= $_GET['week'] ?>',
                    "month"       : '<?= $_GET['month'] ?>',
                    "year"        : '<?= $_GET['year'] ?>',
                    "weekClosed"  : '<?= $_GET['weekClosed'] ?>',
                    "monthClosed" : '<?= $_GET['monthClosed'] ?>',
                    "yearClosed"  : '<?= $_GET['yearClosed'] ?>',
                    "searchTicket": '<?= $_GET['search'] ?>',
                    "serviceName" : '<?= $_GET['serviceName'] ?>',
                    "teamIdGet"   : '<?= $_GET['teamId'] ?>',
                }
            },
            columnDefs: [ 
              {
                targets     : [5,6,7],
                visible     : false,
                searchable  : true,
              }, 
              {
                targets     : [0],
                searchable  : false,
              },  
              { 
                className   : "dt-center", 
                targets     : [2,3,4],
              },
            ],
  });

  t.on('order.dt search.dt', function() {
    let i = 1;

    t.cells(null, 0, {
      search: 'applied', 
      order: 'applied' 
    }).every(function(cell) {
        this.data(i++);
    });
  }).draw();
  <?php } ?>
  
  <?php if (ltrim(parse_url(CURRENT_PAGE, PHP_URL_PATH), '/') == MINISTRY_REQUESTS ) { ?>
  var x = $('#ministryAjaxTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                "url": "scripts/server_processing_ministry.php",
                "data": {
                    "category"    : '<?= $_GET['category'] ?>',
                    "categoryId"  : '<?= $_GET['categoryId'] ?>',
                    "status"      : '<?= $_GET['status'] ?>',
                    "teamId"      : '<?= $_SESSION['teamId'] ?>',
                    "week"        : '<?= $_GET['week'] ?>',
                    "month"       : '<?= $_GET['month'] ?>',
                    "year"        : '<?= $_GET['year'] ?>',
                    "searchTicket": '<?= $_GET['search'] ?>',
                    "ministryId": '<?= $_GET['ministryId'] ?>',
                }
            },
            columnDefs: [ 
              {
                targets     : [4,5,6],
                visible     : false,
                searchable  : true,
              }, 
              {
                targets     : [0],
                searchable  : false,
              },  
              { 
                className   : "dt-center", 
                targets     : [2,3],
              },
            ],
  });

  x.on('order.dt search.dt', function() {
    let i = 1;

    x.cells(null, 0, {
      search: 'applied', 
      order: 'applied' 
    }).every(function(cell) {
        this.data(i++);
    });
  }).draw();
  <?php } ?>

  $("#projectResources").DataTable({
    aLengthMenu: [
      [10, 25, 100, -1],
      [10, 25, 100, "All"]
    ],
    "ordering": false,
    colReorder: true,
    fixedHeader: true,
    "buttons": ["csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#projectResources_wrapper .col-md-6:eq(0)');

  // IP addresses table
  $('#dataTableIP').DataTable({
    // aLengthMenu: [
    //     [50, 100, 200, -1],
    //     [50, 100, 200, "All"]
    // ],
    "paging": false,
    "lengthChange": true,
    "searching": true,
    "ordering": false,
    colReorder: true,
    fixedHeader: true,
    "info": true,
    "autoWidth": true,
    "buttons": ["csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#dataTableIP_wrapper .col-md-6:eq(0)');

  $('#vmTable').DataTable({
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": false,
    colReorder: true,
    fixedHeader: true,
    "info": true,
    "buttons": ["csv", "excel", "pdf", "print"]
  }).buttons().container().appendTo('#vmTable_wrapper .col-md-6:eq(0)');
  
  // Initialize Select2 Elements
  $('.select2').val([]);
  $('.select2').select2({
    placeholder: {
      id: '-1', // the value of the option
      text: 'Select one'
    }
  });
  $('.select2Filled').select2({
    placeholder: {
      id: '-1', // the value of the option
      text: 'Select one'
    }
  });

  // Select2 with subtitle
  $('.select2Subtitle').val([]);
  $('.select2Subtitle').select2({
    placeholder: {
      id: '-1', // the value of the option
      text: 'Select one'
    },
    templateResult: selectionWithSubtitle
  });
  $('.select2SubtitleFilled').select2({
    placeholder: {
      id: '-1', // the value of the option
      text: 'Select one'
    },
    templateResult: selectionWithSubtitle
  });

  function selectionWithSubtitle(selection) {
	  if (!selection.id) { return selection.text; }
		var $selection = $('<span>' + selection.text + '<br /><small>' + selection.element.dataset.subtitle + '</small></span>');
		return $selection;
	};

  // Summernote
  $('textarea[id="summernote"]').summernote({
    placeholder: 'Write here...',
    tabsize: 2,
    height: 200,
    dialogsInBody: true,
    toolbar: [
      ['font', ['bold', 'italic', 'underline', 'clear']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['view', ['fullscreen']]
    ]
  })

  $('textarea[id="summernoteGuide"]').summernote({
    placeholder: 'Write here...',
    tabsize: 2,
    height: 200,
    dialogsInBody: true,
    toolbar: [
      // ['font', ['bold', 'italic', 'underline', 'clear']],
      // ['para', ['ul', 'ol', 'paragraph']],
      // ['table', ['table']]
      ['style', ['style']],
      ['font', ['bold', 'italic', 'underline', 'clear']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'picture']], // , 'video'
      ['view', ['fullscreen']] // , 'codeview'
    ]
  })

  // Reset button
  $('button[name="reset"]').on('click', function(e) {
    $('.select2').val(null).trigger('change');
    $('textarea[id="summernote"]').summernote('reset');
  });

  // Checkbox
  $('input[type="checkbox"]').click(function() {
    this.value = +this.checked;
  });

  // Menu with dropdown filter
  $('select[name="dropdownMenu"]').on('change', function() {
    var url = $(this).val(); // get selected value
    if (url) { // require a URL
      window.location = url; // redirect
    }
    return false;
  });

  bsCustomFileInput.init();

  $("#upload").on('click', function(e) {
    e.preventDefault();
    $("#uploadInvoice:hidden").trigger('click');
  });

  $('.count').each(function () {
    $(this).prop('Counter', 0).animate({
      Counter: parseInt($(this).text()) || 0
    }, {
      duration: 1000,
      easing: 'swing',
      step: function (now) {
        $(this).text(Math.ceil(now).toLocaleString('en'));
      }
    });
  });

  $('.percentage').each(function () {
    $(this).prop('Counter', 0).animate({
      Counter: parseInt($(this).text()) || 0
    }, {
      duration: 1000,
      easing: 'swing',
      step: function (now) {
          $(this).text((Math.ceil(now * 10) / 10).toLocaleString('en', { minimumFractionDigits: 1 }));
      }
    });
  });

  $('.money').each(function () {
    $(this).prop('Counter', 0).animate({
      Counter: parseInt($(this).text()) || 0
    }, {
      duration: 1000,
      easing: 'swing',
      step: function (now) {
          $(this).text((Math.ceil(now * 100) / 100).toLocaleString('en', { minimumFractionDigits: 2 }));
      }
    });
  });

  // Coming soon modal
  $('.toastsDefaultAutohide').click(function() {
    $(document).Toasts('create', {
      class: 'bg-info',
      title: 'Alert',
      subtitle: 'Coming Soon',
      autohide: true,
      delay: 3000,
      body: 'Hold on tight. This feature will be added real soon.'
    })
  });

  $('.maskedUrl').click(function(e){
    e.preventDefault();
    var original_convention = $(this).data('original');
    location.href = "https://dev.cloud.gov.bn/portal/a" + original_convention;
  });
});
</script>

<script>
$(function () {
  'use strict'

  /* jQueryKnob */
  $('.knob').knob()

  /* Chart */
  Chart.defaults.global.defaultFontFamily = "Rubik"

  var ticksStyle = {
    fontColor: '#495057',
    // fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true
  <?php if (ltrim(parse_url(CURRENT_PAGE, PHP_URL_PATH), '/') == REQUEST_PAGE ) { ?>
  // Request progress slider
  $('#progressSlider').ionRangeSlider({
    type: 'single',
    postfix: '%',
    min: 0,
    max: 100.00,
    from: <?php echo $requestProgress ? $requestProgress : 0; ?>,
    from_fixed: true,
    to_fixed: true,
    step: 10
  });
  <?php } ?>

  <?php if (CURRENT_PAGE == NULL || CURRENT_PAGE == INDEX_PAGE || CURRENT_PAGE == "portal") { ?> // index.php page
    
  //---------------------------
  // - SERVICE REQUESTS CHART -
  //---------------------------

  <?php
  if (isset($_SESSION['loggedIn'])) {
  // Gathering data for requestsChart
  $months = array();
  $closedCalls = array();
  $openedCalls = array();
  
  $query = "SELECT count(*) AS 'Opened Calls', RIGHT(YEAR(createdAt), 2) AS 'Year', LEFT(MONTHNAME(createdAt), 3) AS 'Month'
    FROM requests
    WHERE statusId != 8
    ";
  $query .= isSuperAdmin() || isServiceDeskManager() || isReviewer() ? "" : " AND (teamId = " . $_SESSION["teamId"] . " OR FIND_IN_SET('" . $_SESSION['teamId'] . "', teamIds) > 0)";
  $query .= isServiceDeskTeam() ? " AND (categoryId = 2 OR categoryId = 3)" : "";
  $query .= " GROUP BY  Year, Month ORDER BY year DESC, STR_TO_DATE(CONCAT( '0001 ', MONTH, ' 01' ),'%Y %M %d') DESC
    LIMIT 12";

  $result = mysqli_query($mysqli, $query);

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $months[] = $row["Month"]." ".$row["Year"];
        $openedCalls[$row["Month"]." ".$row["Year"]] = $row["Opened Calls"];
    }

    // reverse the order
    $months = array_reverse($months);
    $openedCalls = array_reverse($openedCalls);

    // Initialise closedCalls month's values to zero
    foreach ($months as $month) {
      $closedCalls[$month] = 0;
    }
  }

  $query = "SELECT count(*) AS 'Closed Calls', RIGHT(YEAR(createdAt), 2) AS 'Year', LEFT(MONTHNAME(createdAt), 3) AS 'Month'
    FROM requests
    WHERE statusId = 10 ";
  $query .= isSuperAdmin() || isServiceDeskManager() || isReviewer() ? "" : " AND (teamId = " . $_SESSION["teamId"] . " OR FIND_IN_SET('" . $_SESSION['teamId'] . "', teamIds) > 0)";
  $query .= isServiceDeskTeam() ? " AND (categoryId = 2 OR categoryId = 3)" : "";
  $query .= " GROUP BY  Year, Month ORDER BY year DESC, STR_TO_DATE(CONCAT( '0001 ', MONTH, ' 01' ),'%Y %M %d') DESC
    LIMIT 12";
  $result = mysqli_query($mysqli, $query);

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $closedCalls[$row["Month"]." ".$row["Year"]] = $row["Closed Calls"];
    }
  }
}
  ?>
  <?php
  if (isset($_SESSION['loggedIn'])) {
  ?>
  var $requestsChart = $('#requestsChart')
  // eslint-disable-next-line no-unused-vars
  var requestsChart = new Chart($requestsChart, {
    data: {
      labels: <?php print_r(json_encode($months)); ?>,
      datasets: [{
        label: 'Closed',
        type: 'line',
        data: <?php print_r(json_encode(array_values($closedCalls))); ?>,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        pointBorderColor: '#007bff',
        pointBackgroundColor: '#007bff',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      },
      {
        label: 'Opened',
        type: 'line',
        data: <?php print_r(json_encode(array_values($openedCalls))); ?>,
        backgroundColor: 'tansparent',
        borderColor: '#ced4da',
        pointBorderColor: '#ced4da',
        pointBackgroundColor: '#ced4da',
        fill: false
        // pointHoverBackgroundColor: '#ced4da',
        // pointHoverBorderColor    : '#ced4da'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            color: 'rgba(0, 0, 0, .1)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: false
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: $.extend({
            fontStyle: 'bold'
          }, ticksStyle)
        }]
      }
    }
  })
  <?php
  }
  ?>

  //-------------------------------
  // - END SERVICE REQUESTS CHART -
  //-------------------------------
  
  //------------------------------
  // - ONBOARDING PROJECTS CHART -
  //------------------------------

  <?php
  $provProjYears = array();
  $provProjNums = array();
  
  $query = "SELECT COUNT(*) AS Project, YEAR(provisionedDate) AS Year
    FROM projects
    WHERE provisionedDate IS NOT NULL
    GROUP BY YEAR(provisionedDate)
    ORDER BY Year";
  $result = mysqli_query($mysqli, $query);

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $provProjYears[] = $row["Year"];
      $provProjNums[] = $row["Project"];
    }
  }
  ?>

  var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')

  var salesGraphChartData = {
    labels: <?php print_r(json_encode($provProjYears)); ?>,
    datasets: [
      {
        label: 'Projects',
        fill: false,
        // borderWidth: 2,
        // lineTension: 0,
        // spanGaps: true,
        borderColor: '#efefef',
        // pointRadius: 3,
        // pointHoverRadius: 7,
        pointColor: '#efefef',
        pointBackgroundColor: '#efefef',
        data: <?php print_r(json_encode($provProjNums)); ?>
      }
    ]
  }

  var salesGraphChartOptions = {
    maintainAspectRatio: false,
    responsive: true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        ticks: {
          fontColor: '#efefef',
          fontStyle: 'bold'
        },
        gridLines: {
          display: true,
          color: 'transparent',
          zeroLineColor: 'rgba(255, 255, 255, .1)',
          drawBorder: false
        }
      }],
      yAxes: [{
        ticks: {
          stepSize: 5,
          fontColor: '#efefef'
        },
        gridLines: {
          display: true,
          color: 'rgba(255, 255, 255, .1)',
          zeroLineColor: 'rgba(255, 255, 255, .1)',
          drawBorder: false
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  // eslint-disable-next-line no-unused-vars
  var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
    type: 'line',
    data: salesGraphChartData,
    options: salesGraphChartOptions
  })

  //----------------------------------
  // - END ONBOARDING PROJECTS CHART -
  //----------------------------------

  //---------------------------------
  // - PROJECTS BY MINISTRIES CHART -
  //---------------------------------

  <?php
  $ministries = array();
  $activeProjects = array();
  $inactiveProjects = array();
  
  $query = "SELECT ministries.shortName AS ministry,
    (SELECT COUNT(*) FROM projects
      WHERE ministryId = ministries.id AND statusId != 5) AS active,
    (SELECT COUNT(*) FROM projects
      WHERE ministryId = ministries.id AND statusId = 5) AS decommissioned
    FROM projects
    INNER JOIN ministries ON projects.ministryId = ministries.id
    GROUP BY ministries.id
    ORDER BY ministry";
  $result = mysqli_query($mysqli, $query);

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $ministries[] = $row["ministry"];
      $activeProjects[] = $row["active"];
      $inactiveProjects[] = $row["decommissioned"];
    }
  }
  ?>

  var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: <?php print_r(json_encode($ministries)); ?>,
      datasets: [
        {
          label: 'Decommissioned',
          backgroundColor: '#6c757d',
          borderColor: '#6c757d',
          data: <?php print_r(json_encode($inactiveProjects)); ?>
        },
        {
          label: 'Active',
          backgroundColor: '#01ff70',
          borderColor: '#01ff70',
          data: <?php print_r(json_encode($activeProjects)); ?>
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          stacked: true,
          gridLines: {
            display: true,
            color: 'rgba(255, 255, 255, .1)',
            zeroLineColor: 'rgba(255, 255, 255, .1)',
          },
          ticks: {
            beginAtZero: true,
            fontColor: '#efefef',

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              // return '$' + value
              return value
            }
          }
        }],
        xAxes: [{
          stacked: true,
          display: true,
          gridLines: {
            display: false
          },
          ticks: {
            fontColor: '#efefef',
            fontStyle: 'bold'
          }
        }]
      }
    }
  })

  //-------------------------------------
  // - END PROJECTS BY MINISTRIES CHART -
  //-------------------------------------
  <?php } ?>

  <?php if (CURRENT_PAGE == SUMMARY_RESPONSE || strpos(CURRENT_PAGE, SUMMARY_RESPONSE) !== false) { ?>
  //---------------------------
  // - RESPONSE TIME CHART -
  //---------------------------

  <?php 
  $responseTime = array();
  $closedRequest = array();

  $query2 = "SELECT a.dateDiff, COUNT(*) AS closedRequests 
    FROM (
      SELECT id, TIMESTAMPDIFF(DAY, createdAt, updatedAt) AS responseTime,
      CASE 
        WHEN TIMESTAMPDIFF(DAY, createdAt, updatedAt) <= 7 THEN 'Within a week'
          WHEN TIMESTAMPDIFF(DAY, createdAt, updatedAt) BETWEEN 8 AND 14 THEN 'In two weeks'
          WHEN TIMESTAMPDIFF(DAY, createdAt, updatedAt) BETWEEN 15 AND 30 THEN 'In a month'
          ELSE 'Over a month'
        END AS 'dateDiff' FROM requests
      WHERE statusId = 10 AND updatedAt IS NOT NULL";
  $query2 .= isServiceManager() || isServiceTeam() ? " AND teamId = " . $_SESSION["teamId"] : "";
  if ($_GET["year"]) {
    $query2 .= " AND YEAR(createdAt) = ". $_GET["year"];
  }
  $query2 .= " ) a
    GROUP BY a.dateDiff ORDER BY CASE
    WHEN a.dateDiff = 'Within a week' THEN 1
    WHEN a.dateDiff = 'In two weeks' THEN 2
    WHEN a.dateDiff = 'In a month' THEN 3
    ELSE
      4
  END";
    
  $result2 = mysqli_query($mysqli, $query2);
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row2 = mysqli_fetch_assoc($result2)) {
      $responseTime[] = $row2["dateDiff"];
      $closedRequest[] = $row2["closedRequests"];
    }
  }
  ?>

  var $requestsChart = $('#responseTimeChart')
  // eslint-disable-next-line no-unused-vars
  var requestsChart = new Chart($requestsChart, {
    data: {
      labels: <?php print_r(json_encode( $responseTime )); ?>,
      datasets: [{
        label: 'Closed',
        type: 'line',
        data: <?php print_r(json_encode(array_values($closedRequest))); ?>,
        backgroundColor: 'transparent',
        borderColor: '#007bff',
        pointBorderColor: '#007bff',
        pointBackgroundColor: '#007bff',
        fill: false
        // pointHoverBackgroundColor: '#007bff',
        // pointHoverBorderColor    : '#007bff'
      }]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            color: 'rgba(0, 0, 0, .1)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: false
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: $.extend({
            fontStyle: 'bold'
          }, ticksStyle)
        }]
      }
    }
  })
  
  //-------------------------------
  // - END RESPONSE TIME CHART -
  //-------------------------------
  <?php } ?>
  
})
</script>



<script>
  //---------------------------
  // - SUGGESTION AUTOCOMPLETE FOR TICKET -
  //---------------------------
  let autocomplete = (inp, arr) => {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  let currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
    let a, //OUTER html: variable for listed content with html-content
      b, // INNER html: filled with array-Data and html
      i, //Counter
      val = this.value;

    /*close any already open lists of autocompleted values*/
    closeAllLists();

    if (!val) {
      return false;
    }

    currentFocus = -1;

    /*create a DIV element that will contain the items (values):*/
    a = document.createElement("DIV");
    
    a.setAttribute("id", this.id + "autocomplete-list");
    a.setAttribute("class", "autocomplete-items list-group text-left");
    
    /*append the DIV element as a child of the autocomplete container:*/
    this.parentNode.appendChild(a);

    /*for each item in the array...*/
    for (i = 0; i < arr.length; i++) {
      for (i = 0; i < arr.length; i++) {
      /*check if the item starts with the same letters as the text field value:*/
      if (arr[i].toUpperCase().indexOf(val.toUpperCase()) > -1) {
        /*create a DIV element for each matching element:*/
        b = document.createElement("DIV");
        b.setAttribute("class","list-group-item list-group-item-action");
        b.innerHTML = arr[i];
        /*insert a input field that will hold the current array item's value:*/
        b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
        /*execute a function when someone clicks on the item value (DIV element):*/
        b.addEventListener("click", function(e) {
          /*insert the value for the autocomplete text field:*/
          inp.value = this.getElementsByTagName("input")[0].value;
          /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
          closeAllLists();
        });
        a.appendChild(b);
      }
     }
    }
  });
  
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
    var x = document.getElementById(this.id + "autocomplete-list");
    if (x) x = x.getElementsByTagName("div");
    if (e.keyCode == 40) {
      /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
      currentFocus++;
      /*and and make the current item more visible:*/
      addActive(x);
    } else if (e.keyCode == 38) {
      //up
      /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
      currentFocus--;
      /*and and make the current item more visible:*/
      addActive(x);
    } else if (e.keyCode == 13) {
      /*If the ENTER key is pressed, prevent the form from being submitted,*/
      e.preventDefault();
      if (currentFocus > -1) {
        /*and simulate a click on the "active" item:*/
        if (x) x[currentFocus].click();
      }
    }
  });
  
  let addActive = (x) => {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = x.length - 1;
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("active");
  }
  
  let removeActive = (x) => {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (let i = 0; i < x.length; i++) {
      x[i].classList.remove("active");
    }
  }
  
  let closeAllLists = (elmnt) => {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function(e) {
    closeAllLists(e.target);
  });
};

/*An array containing all the country names in the world:*/
let titles = [
  "Create Mailbox",
  "Reconnect Mailbox",
  "Upgrade Mailbox",
  "Add/Remove Secondary Email",
  "SMTP Request",
  "Update Email Address",
  "Email Permission Request (Email)",
  "Create AD Account",
  "Enable Account",
  "Disable Account",
  "Create Distribution / Security Group",
  "Modify Distributiion / Security Group",
  "Update User Profile",
  "Unlock Account",
  "Update User Name",
  "Change Domain",
  "Domain Host Request",
  "Internal Request",
  "VPN Request",
  "RFF Request",
  "Reset VPN Request",
  "External DNS",
  "OGN Request",
  "Upgrade OGN Bandwidth",
  "Wifi/Internet Access",
  "New VM/Server Request",
  "Snapshot Request",
  "Increase VM Storage",
  "Increas vRAM/cCPU",
  "Restart Server Request",
  "Mount ISO File",
  "Terminate Server",
  "vSphere Access",
  "Approval Request (VPN)",
  "Approval Request (RFF)",
  "Approval Request (WIFI)",
  "Reset Password",
  "Inquiry",
  "OGN [x] *LOCATION*",
  "OGN [x] *OGN NUM*",
  "OGN ISSUE [x] *OGN NUM*",

];

/*initiate the autocomplete function on the "titleSuggestionInput" element, and pass along the titiles array as possible autocomplete values:*/
autocomplete(document.getElementById("titleSuggestionInput"), titles);

// adding additional field on "add activity" when escalated is selected
$("#activityStatus").change(function() {
  if ($(this).val() == 4) {
    $('#escalateDiv').show();
    $('#escalateField').attr('required', '');
    // $('#escalateField').attr('data-error', 'error message');
  } else {
    $('#escalateDiv').hide();
    $('#escalateField').removeAttr('required');
    // $('#escalateField').removeArtr('data-error');
  }
});
$("#activityStatus").trigger("change");
</script>

<?php if(ltrim(parse_url(CURRENT_PAGE, PHP_URL_PATH), '/') == RESOURCE_REQUEST) { ?>
<script>
  //---------------------------
  // - SERVER AND DATABASE REQUEST PAGE -
  //---------------------------
    $(document).ready(function() {
        var serverArray = [];
        $("#serverForm").on('submit', function(e) {
            e.preventDefault();
            var formArray = $(this).serializeArray();//get field name and field value
            serverArray.push(formArray);//push to Array

            var VMNumber = serverArray.length
         

            // serverArray[VMNumber-1].unshift({
            //   name: 'name',
            //   value: '<?php echo "OGC". $row["ministryCode"] . "0" . sprintf("%02d", $row['ministryLastIndex']) . "AVP" ?>' + VMNumber.toString().padStart(3, "0")
            //   value: 'OGC'+ministryCode+'AVP'+VMNumber.toString().padStart(3, "0")
            // })
            console.log (serverArray[VMNumber-1]);
            

            if (serverArray.length > 0) {
                $.ajax({
                    url: 'update_server_table.php',
                    method: 'post',
                    data: {serverPhp : serverArray},
                    success: function(response) {
                        $('#serverList').html(response)
                       
                    }
                });
            }
        });
    });
</script>
<?php }?>
<?php
  if (ltrim(parse_url(CURRENT_PAGE, PHP_URL_PATH), '/') == REQUEST_PAGE) { ?> // index.php page
    <script>
      $(document).on('click', 'a', function() {
        document.getElementById("deleteToken").setAttribute("value", this.id)
      });

      $(document).ready(function() {
        var $submit = $("#deleteProjectFile").hide(),
        $cbs = $('input[name="deleteCheckbox"]').click(function() {
            $submit.toggle( $cbs.is(":checked") );
        });
      });
    </script>
  <?php } ?>
</body>

<?php
  if (ltrim(parse_url(CURRENT_PAGE, PHP_URL_PATH), '/') == OVERTIME_PAGE) { ?> // overtime.php page
    <script>
      function updateHours() {
        document.getElementById("totalHours").value = (document.getElementById("claimType").value - document.getElementById("claimType").value % 60)/60;
        document.getElementById("totalMins").value = document.getElementById("claimType").value % 60;
        
        if(document.getElementById("claimType").value == "0") {
          document.getElementById("totalHours").value = null;
          document.getElementById("totalMins").value = null;
          document.getElementById("totalHours").readOnly = false;
          document.getElementById("totalMins").readOnly = false;
        }
        else {
          document.getElementById("totalHours").readOnly = true;
          document.getElementById("totalMins").readOnly = true;
        }
      } 

      //actions when total hours and total minutes are entered
      function validate() {
        if(document.getElementById("totalHours").value == "0" && document.getElementById("totalMins").value == "0") {
          document.getElementById("totalHours").value = null;
          document.getElementById("totalMins").value = null;
        }

        if(document.getElementById("totalHours").value != null && document.getElementById("totalMins").value != null) {
          totalMins = document.getElementById("totalHours").value * 60 + parseInt(document.getElementById("totalMins").value);
          if(totalMins > 450) {
            alert("Total in-lieus cannot be more than 7 hours 30 mins.");
            document.getElementById("totalHours").value = null;
            document.getElementById("totalMins").value = null;
          }
          availableTime = document.getElementById("availableTime").value;
          if(totalMins > availableTime) {

            hour1 = (availableTime - availableTime % 60)/60;
            hour2 = hour1 > 1 ? "s " : " ";
            min1 = availableTime % 60;
            min2 = min1 > 1 ? "s" : " ";

            alert("Total in-lieus cannot be more than " + hour1 + " hour" + hour2 + min1 + " min" + min2 + ".")
          }
        }
      }

      //actions when date in-lieu is selected
      function showAvailableTime(date,user) { 
        //clear total hours and total mins value claimType
        document.getElementById("claimType").selectedIndex = -1;
        document.getElementById("totalHours").value = "";
        document.getElementById("totalMins").value = "";

        //if date not selected, hide available in-lieu time
        if (date == "") {
          document.getElementById("timeHint").innerHTML = "";
          return;
        } else { //calculate available in-lieu time
          var xmlhttp = new XMLHttpRequest();
          xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) { //readyState = 4 means request finish and response is ready. status = 200 means OK              
              var myObj = JSON.parse(this.responseText);
              dateInLieu = document.getElementById("dateInLieu").value;
              earlierDate = new Date(dateInLieu);
              futureDate = new Date(dateInLieu);
              //alert("early date: "+earlierDate+"\nfuture date: "+futureDate);

              var previousDay, nextDay;
              //if monday and saturday, calculate previous date
              if (earlierDate.getDay() == 1 || earlierDate.getDay() == 6) {
                earlierDate.setDate(earlierDate.getDate() -2);
                var minusTwoDays = earlierDate;
                previousDay = minusTwoDays.toISOString().split('T')[0];
              } else {
                earlierDate.setDate(earlierDate.getDate() -1);
                var minusOneDay = earlierDate;
                previousDay = minusOneDay.toISOString().split('T')[0];
              }

              //if thursday and saturday, calulate next day
              if (futureDate.getDay() == 4 || futureDate.getDay() == 6) {
                futureDate.setDate(futureDate.getDate() + 2);
                var plusTwoDays = futureDate;
                nextDay = plusTwoDays.toISOString().split('T')[0]; 
              } else {
                futureDate.setDate(futureDate.getDate() +1);
                var plusTwoDays = futureDate;
                nextDay = plusTwoDays.toISOString().split('T')[0];
              }
              
              //check if date selected is on the same day or the next day after in-lieu taken
              if (myObj.concatDate.includes(document.getElementById("dateInLieu").value)){ 
                alert("You have taken an in-lieu on " + (new Date(document.getElementById("dateInLieu").value)).toLocaleDateString("en-GB") + ". Please select another date.");
                document.getElementById("dateInLieu").value = null;
              } else if(myObj.concatDate.includes(previousDay)){ 
                alert("You have taken an in-lieu on earlier date, " + earlierDate.toLocaleDateString("en-GB") + ". Please select another date.");
                document.getElementById("dateInLieu").value = null;
              } else if(myObj.concatDate.includes(nextDay)){ 
                alert("You have taken an in-lieu on future date, " + futureDate.toLocaleDateString("en-GB") + ". Please select another date.");
                document.getElementById("dateInLieu").value = null;
              }else {
                //do nothing
              }             

              if(myObj.totalTime < 180) {
                $("option[value='450']").attr("disabled", "disabled");
                $("option[value='270']").attr("disabled", "disabled");
                $("option[value='180']").attr("disabled", "disabled");
                $("option[value='0']").attr("disabled", false);
              } else if(myObj.totalTime < 270) {
                $("option[value='450']").attr("disabled", "disabled");
                $("option[value='270']").attr("disabled", "disabled");
                $("option[value='180']").attr("disabled", false);
                $("option[value='0']").attr("disabled", false);
              } else if (myObj.totalTime < 450) {
                $("option[value='450']").attr("disabled", "disabled");
                $("option[value='270']").attr("disabled", false);
                $("option[value='180']").attr("disabled", false);
                $("option[value='0']").attr("disabled", false);
              } else {
                $("#claimType option").attr("disabled", false);
              }
              
              hour1 = (myObj.totalTime - myObj.totalTime % 60)/60;
              hour2 = hour1 > 1 ? "s " : " ";
              min1 = myObj.totalTime % 60;
              min2 = min1 > 1 ? "s " : " ";

              document.getElementById("timeHint").innerHTML = "Available in-lieu time: " + hour1 + " hour" + hour2 + min1 + " min" + min2;
              document.getElementById("availableTime").value = myObj.totalTime;
            }
          };
          xmlhttp.open("GET","gettime.php?d="+date+"&u="+user,true);
          xmlhttp.send();
        }
      }

      //datepicker restrict friday and sunday
      const picker = document.getElementById('dateInLieu');
      picker.addEventListener('input', function(e){
        var day = new Date(this.value).getUTCDay();
        if([5].includes(day)){
          e.preventDefault();
          this.value = '';
          alert('You selected Friday. Please pick another working date.');
        }
        if([0].includes(day)){
          e.preventDefault();
          this.value = '';
          alert('You selected Sunday. Please pick another working date.');
        }
      });
    </script>
<?php } ?>

</html>