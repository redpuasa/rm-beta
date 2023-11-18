<!-- RMS Tourguide -->
<!-- <div data-tg-title="Welcome to Risk Management System" data-tg-tour='Strictly please go through with the tour guide for you to understand the system better. You may use your arrow keys for navigation of the tour.' data-tg-order="0"></div> -->

<!-- roles:
1. dev
2. admin || risk analyst
3. risk leader
4. risk champion

isDev() || isRiskAnalyst() -->

<?php 
    $query = "  SELECT * FROM risks";
    $result = mysqli_query($mysqli, $query);
    $result_array = array();
    while ($row = mysqli_fetch_array($result)) {
        $result_array[] = $row;;
    }

    //push the array to js script for tabels
?>
<h1 class="h3 mb-3">Risk Oversight</h1>


<div id="toolbar"></div>

<table
  id="table"
  data-toolbar="#toolbar"
  data-search="true"
  data-show-refresh="true"
  data-show-toggle="true"
  data-show-fullscreen="false"
  data-show-columns="true"
  data-show-columns-toggle-all="true"
  data-detail-view="true"
  data-show-export="true"
  data-click-to-select="true"
  data-detail-formatter="detailFormatter"
  data-minimum-count-columns="2"
  data-show-pagination-switch="true"
  data-pagination="true"
  data-id-field="id"
  data-page-list="[10, 25, 50, 100, all]"
  data-show-footer="true"
  data-side-pagination="server"
  data-url="https://examples.wenzhixin.net.cn/examples/bootstrap_table/data"
  data-response-handler="responseHandler"
  class="table table-bordered">
</table>

<!-- Info boxes -->
<div class="row">
    <div class="col-12 d-flex" data-tg-title="Open Risk" data-tg-tour='The total number of risk that are currently opened.' data-tg-order="10">
        <div class="card flex-fill">
            <div class="card-header">

                <h5 class="card-title mb-0">Latest Risk Registered</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>Division</th>
                        <th>Risk Title</th>
                        <th class="d-none d-xl-table-cell">Date Registered</th>
                        <th>Severity</th>
                        <th>Status</th>
                        <th class="d-none d-md-table-cell">Registered By</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Division 1</td>
                        <td>RT - Risk Title</td>
                        <td class="d-none d-xl-table-cell">01/01/2023</td>
                        <td><span class="text-success">Low</span></td>
                        <td><span class="badge bg-success">Done</span></td>
                        <td class="d-none d-md-table-cell">RC1</td>
                        <td>
                            <a class="" href="#">
                                Details
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Division 2</td>
                        <td>RT - Risk Title</td>
                        <td class="d-none d-xl-table-cell">01/01/2023</td>
                        <td><span class="text-success">Low</span></td>
                        <td><span class="badge bg-danger">Open</span></td>
                        <td class="d-none d-md-table-cell">RC3</td>
                        <td>
                            <a class="" href="#">
                                Details
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Division 5</td>
                        <td>RT - Risk Title</td>
                        <td class="d-none d-xl-table-cell">01/01/2023</td>
                        <td><span class="text-success">Low</span></td>
                        <td><span class="badge bg-success">Closed</span></td>
                        <td class="d-none d-md-table-cell">RC2</td>
                        <td>
                            <a class="" href="#">
                                Details
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Division 2</td>
                        <td>RT - Risk Title</td>
                        <td class="d-none d-xl-table-cell">01/01/2023</td>
                        <td><span class="text-danger">High</span></td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td class="d-none d-md-table-cell">RC5</td>
                        <td>
                            <a class="" href="#">
                                Details
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Division 3</td>
                        <td>RT - Risk Title</td>
                        <td class="d-none d-xl-table-cell">01/01/2023</td>
                        <td><span class="text-success">Low</span></td>
                        <td><span class="badge bg-danger">Open</span></td>
                        <td class="d-none d-md-table-cell">RC5</td>
                        <td>
                            <a class="" href="#">
                                Details
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Division 1</td>
                        <td>RT - Risk Title</td>
                        <td class="d-none d-xl-table-cell">01/01/2023</td>
                        <td><span class="text-success">Low</span></td>
                        <td><span class="badge bg-success">Closed</span></td>
                        <td class="d-none d-md-table-cell">RC2</td>
                        <td>
                            <a class="" href="#">
                                Details
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Division 4</td>
                        <td>RT - Risk Title</td>
                        <td class="d-none d-xl-table-cell">01/01/2023</td>
                        <td><span class="text-warning">Mild</span></td>
                        <td><span class="badge bg-success">Closed</span></td>
                        <td class="d-none d-md-table-cell">RC1</td>
                        <td>
                            <a class="" href="#">
                                Details
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td>Division 1</td>
                        <td>RT - Risk Title</td>
                        <td class="d-none d-xl-table-cell">01/01/2023</td>
                        <td><span class="text-danger">High</span></td>
                        <td><span class="badge bg-warning">Pending</span></td>
                        <td class="d-none d-md-table-cell">RC5</td>
                        <td>
                            <a class="" href="#">
                                Details
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
