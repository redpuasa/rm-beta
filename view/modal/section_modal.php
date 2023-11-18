<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_section">
Add section
</button>

<!-- Modal -->
<div class="modal fade" id="add_section" tabindex="-1" role="dialog" aria-labelledby="add_section" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_section">Add Section</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" action="#" method="post" novalidate="" enctype="multipart/form-data">
                    <div class="row px-5 pb-5">
                        <div class="col-sm-12">
                            <label for="section_name" class="">Section Name <small class="text-danger">*</small></label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="align-middle" data-feather="file-text"></i></span>
                                    <input type="text" id="section_name" value="" name="section_name" required>
                                <div class="invalid-feedback" style="width:100%">
                                    Section name is required.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row px-5 pb-5">
                        <div class="col-sm-12">
                            <label for="section_abbreviation" class="">Section Abbreviation<small class="text-danger">*</small></label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="align-middle" data-feather="file-text"></i></span>
                                    <input type="text" id="section_abbreviation" value="" name="section_abbreviation" required>
                                <div class="invalid-feedback" style="width:100%">
                                    Section abbreviation is required.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row px-5 pb-5">
                        <div class="col-sm-6">
                            <label for="section_division" class="">Section Division<small class="text-danger">*</small></label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="align-middle" data-feather="layers"></i></span>
                                <select class="form-select" id="section_division" name="section_division" required>
                                    <option value="">Select one</option>

                                    <?php
                                        $query = "SELECT * FROM roles
                                        ORDER BY id";
                                        $result = mysqli_query($mysqli_ogpc, $query); //change the query
                                        if (mysqli_num_rows($result) > 0) {
                                        $num = 1;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>

                                    <option value="<?php echo $row["role_id"]; ?>"><?php echo $row["role_name"]; ?></option>

                                    <?php }} ?>
 
                                    <!-- <option value="1">Technical Risk</option>
                                    <option value="2">External Risk</option>
                                    <option value="3">Organizational Risk</option>
                                    <option value="4">Project Managment Risk</option> -->
                                </select>
                                <div class="invalid-feedback" style="width:100%">
                                    Section division is required.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- hidden -->
                    <input type="text" value="" id="create_at" hidden>
                </form>
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>