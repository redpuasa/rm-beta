<h5 class="text-center p-3"> New Risk Register </h5>
<form class="needs-validation" action="#" method="post" novalidate="" enctype="multipart/form-data">

    <div class="row px-5 pb-5">
        <div class="col-sm-12">
            <label for="divisionType" class="">Risk Title <small class="text-danger">*</small></label>
            <div class="input-group has-validation">
                <span class="input-group-text"><i class="align-middle" data-feather="file-text"></i></span>
                <textarea class="form-control" id="risk_title" rows="2"></textarea>
                <!-- <small class="text-danger">Limited to 50 characters only</small> -->
                <div class="invalid-feedback" style="width:100%">
                    Risk title is required.
                </div>
            </div>
        </div>
    </div>

    <div class="row p-5">
        <div class="col-sm-6">
            <label for="sectionType" class="">Section<small class="text-danger">*</small></label>
            <div class="input-group has-validation">
                <span class="input-group-text"><i class="align-middle" data-feather="layers"></i></span>
                <select class="form-select" id="sectionType" name="sectionType" required>
                    <option value="">Select one</option>

                    <?php
                        $query = "SELECT * FROM sections
                        ORDER BY id";
                        $result = mysqli_query($mysqli_ogpc, $query); //change the query
                        if (mysqli_num_rows($result) > 0) {
                        $num = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                    <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>

                    <?php }} ?>
                </select>
                <div class="invalid-feedback" style="width:100%">
                    Section is required.
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <label for="category" class="">Risk Category<small class="text-danger">*</small></label>
            <div class="input-group has-validation">
                <span class="input-group-text"><i class="align-middle" data-feather="layers"></i></span>
                <select class="form-select" id="divisionType" name="categoryType" required>
                    <option value="">Select one</option>

                    <?php
                        $query = "SELECT * FROM categories
                        ORDER BY id";
                        $result = mysqli_query($mysqli_ogpc, $query); //change the query
                        if (mysqli_num_rows($result) > 0) {
                        $num = 1;
                        while ($row = mysqli_fetch_assoc($result)) {
                    ?>

                    <option value="<?php echo $row["id"]; ?>"><?php echo $row["name"]; ?></option>

                    <?php }} ?>

                    <!-- <option value="1">Technical Risk</option>
                    <option value="2">External Risk</option>
                    <option value="3">Organizational Risk</option>
                    <option value="4">Project Managment Risk</option> -->
                </select>
                <div class="invalid-feedback" style="width:100%">
                    Risk category is required.
                </div>
            </div>
        </div>
    </div>

    <div class="row px-5 pb-5">
        <div class="col-sm-12">
            <label for="risk_description" class="">Risk Description<small class="text-danger">*</small></label>
            <div class="input-group has-validation">
                <span class="input-group-text"><i class="align-middle" data-feather="file-text"></i></span>
                <textarea class="form-control" id="risk_description" rows="10"></textarea>

                <!-- <small class="text-danger">Limited to 50 characters only</small> -->
                <div class="invalid-feedback" style="width:100%">
                    Risk description is required.
                </div>
            </div>
        </div>
    </div>

    <div class="row row px-5 pb-5">
        <div class="col-sm-12">
            <label for="riskTrigger" class="">Risk Impact<small class="text-danger">*</small></label>
            <table class="table table-bordered table-striped" >
                <tr>
                    <th class="align-middle text-center" style="width: 90%;">Risk Impact</th>
                    <th class="align-middle text-center" style="width: 10%;">Action</th>
                </tr>
                <tbody id="tbody">
                    <tr>
                        <td>
                            <div class="input-group has-validation">
                                <textarea class="form-control" id="risk_impact0" name='risk_impact[]' rows="2"></textarea>
                                <div class="invalid-feedback">
                                    Risk impact is required
                                </div>
                            </div>
                        </td>
                        <td class='align-middle text-center'><a href='#table' onclick='deleteRow(this);'><i class="align-middle" data-feather="file-minus"></i></a></td>
                    </tr>
                </tbody>
            </table>
            <div style="margin-left:auto; margin-right:0;">
                <a href="#table" onclick="addItem();"><i class="align-middle" data-feather="file-plus"></i> Add Item</a>
            </div>
        </div>
    </div>

    <div class="row row px-5 pb-5">
        <div class="col-sm-12">
            <label for="riskTrigger" class="">Risk Trigger<small class="text-danger">*</small></label>
            <table class="table table-bordered table-striped" >
                <tr>
                    <th class="align-middle text-center" style="width: 90%;">Risk Trigger</th>
                    <th class="align-middle text-center" style="width: 10%;">Action</th>
                </tr>
                <tbody id="tbody">
                    <tr>
                        <td>
                            <div class="input-group has-validation">
                                <textarea class="form-control" id="risk_trigger0" name='risk_trigger[]' rows="2"></textarea>
                                <div class="invalid-feedback">
                                    Risk trigger is required
                                </div>
                            </div>
                        </td>
                        <td class='align-middle text-center'><a href='#table' onclick='deleteRow(this);'><i class="align-middle" data-feather="file-minus"></i></a></td>
                    </tr>
                </tbody>
            </table>
            <div style="margin-left:auto; margin-right:0;">
                <a href="#table" onclick="addItem();"><i class="align-middle" data-feather="file-plus"></i> Add Item</a>
            </div>
        </div>
    </div>

    <div class="row row px-5 pb-5">
        <div class="col-sm-12">
            <label for="riskTrigger" class="">Risk Mitigation<small class="text-danger">*</small></label>
            <table class="table table-bordered table-striped" >
                <tr>
                    <th class="align-middle text-center" style="width: 90%;">Risk Mitigation</th>
                    <th class="align-middle text-center" style="width: 10%;">Action</th>
                </tr>
                <tbody id="tbody">
                    <tr>
                        <td>
                            <div class="input-group has-validation">
                                <textarea class="form-control" id="risk_mitigation0" name='risk_mitigation[]' rows="2"></textarea>
                                <div class="invalid-feedback">
                                    Risk mitigation is required
                                </div>
                            </div>
                        </td>
                        <td class='align-middle text-center'><a href='#table' onclick='deleteRow(this);'><i class="align-middle" data-feather="file-minus"></i></a></td>
                    </tr>
                </tbody>
            </table>
            <div style="margin-left:auto; margin-right:0;">
                <a href="#table" onclick="addItem();"><i class="align-middle" data-feather="file-plus"></i> Add Item</a>
            </div>
        </div>
    </div>

    <div class="row row px-5 pb-5">
        <div class="col-sm-12">
            <label for="riskTrigger" class="">Risk Control<small class="text-danger">*</small></label>
            <table class="table table-bordered table-striped" >
                <tr>
                    <th class="align-middle text-center" style="width: 90%;">Risk Control</th>
                    <th class="align-middle text-center" style="width: 10%;">Action</th>
                </tr>
                <tbody id="tbody">
                    <tr>
                        <td>
                            <div class="input-group has-validation">
                                <textarea class="form-control" id="risk_control0" name='risk_control[]' rows="2"></textarea>
                                <div class="invalid-feedback">
                                    Risk control is required
                                </div>
                            </div>
                        </td>
                        <td class='align-middle text-center'><a href='#table' onclick='deleteRow(this);'><i class="align-middle" data-feather="file-minus"></i></a></td>
                    </tr>
                </tbody>
            </table>
            <div style="margin-left:auto; margin-right:0;">
                <a href="#table" onclick="addItem();"><i class="align-middle" data-feather="file-plus"></i> Add Item</a>
            </div>
        </div>
    </div>

    <!-- input hidden -->
    <!-- Risk ID -->
    <input type="text" id="risk_id" name="risk_id" value="risk_id" hidden>
    <!-- username -->
    <input type="text" id="username" name="username" value="risk_champion" hidden>
    <!-- date today  -->
    <input type="text" id="date_today" name="registered_date" value="date_today" hidden>
    <!-- division type -->
    <input type="text" id="" name="division_type" value="division_type" hidden>
    <!-- division leader -->
    <input type="text" id="" name="division_officer" value="division_officer" hidden>
    <!-- division leader -->
    <input type="text" id="" name="division_leader" value="division_leader" hidden>
    <!-- division leader -->
    <input type="text" id="" name="risk_status" value="risk_status" hidden>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script>
    let date_today = document.getElementById('date_today').value
    let edit_date = document.getElementById('edit_date').value
    let review_date = document.getElementById('review_date').value
    let date_format = moment().format('DD-MM-YYYY, h:mm:ss a')

    window.addEventListener('load', function(){
        date_today = date_format
        edit_date = date_format
        review_date = date_format
    })
</script>


<!-- <script>
    let section = document.getElementById('section_type').value
    let division = document.getElementById('division_type').innerHTML
    if(section == 1 || section == 2 || section == 3 || section == 4 || section == 5){
        division = 'Operations & Infrastructure Division (OPI)'
    }
    else if (section == 6 || section == 7 || section == 8 || section == 9 || section == 10){
        division = 'Enterprise Applications Division (EAD)'
    }
    else if (section == 6 || section == 7 || section == 8 || section == 9 || section == 10)
</script> -->