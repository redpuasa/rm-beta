<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_status">
Add Status
</button>

<!-- Modal -->
<div class="modal fade" id="add_status" tabindex="-1" role="dialog" aria-labelledby="add_status" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_status">Add Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" action="#" method="post" novalidate="" enctype="multipart/form-data">
                    <div class="row px-5 pb-5">
                        <div class="col-sm-12">
                            <label for="status_name" class="">Status Name <small class="text-danger">*</small></label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="align-middle" data-feather="file-text"></i></span>
                                    <input type="text" id="status_name" value="" name="status_name" required>
                                <div class="invalid-feedback" style="width:100%">
                                    Status name is required.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row px-5 pb-5">
                        <div class="col-sm-12">
                            <label for="status_badge" class="">Status Badge <small class="text-danger">*</small></label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="align-middle" data-feather="file-text"></i></span>
                                    <input type="text" id="status_badge" value="" name="status_badge" required>
                                <div class="invalid-feedback" style="width:100%">
                                    Status badge is required.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row px-5 pb-5">
                        <div class="col-sm-12">
                            <label for="status_ability" class="">Status Ability <small class="text-danger">*</small></label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="align-middle" data-feather="file-text"></i></span>
                                    <input type="text" id="status_ability" value="" name="status_ability" required>
                                <div class="invalid-feedback" style="width:100%">
                                    Status ability is required.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row px-5 pb-5">
                        <div class="col-sm-12">
                            <label for="division_leader" class="">Division Leader<small class="text-danger">*</small></label>
                            <div class="input-group has-validation">
                                <span class="input-group-text"><i class="align-middle" data-feather="file-text"></i></span>
                                    <input type="text" id="division_leader" value="" name="division_leader" required>
                                <div class="invalid-feedback" style="width:100%">
                                    Division leader is required.
                                </div>
                            </div>
                        </div>
                    </div> -->

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