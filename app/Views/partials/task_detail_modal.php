<div class="modal fade" id="update_task_modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">Update Task 1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="email-wrapper wrapper">
                    <div class="message-body">
                        <h5>Attachments</h5>
                        <div class="attachments-sections" id="attachments">
                        </div>
                    </div>
                </div>
                <form>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="modalStatus" name="modalStatus" required>
                            <option value="Active">Active</option>
                            <option value="Completed">Completed</option>
                            <option value="On Hold">On Hold</option>
                            <option value="Closed">Closed</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
                <div class="profile-feed">
                    <div class="d-flex align-items-start profile-feed-item">
                        <img src="<?= base_url() ?>vendors/images/faces/face13.jpg" alt="profile"
                             class="img-sm rounded-circle"/>
                        <div class="ml-4">
                            <h6>
                                Mason Beck
                                <small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>10 hours</small>
                            </h6>
                            <p>
                                There is no better advertisement campaign that is low cost and also successful at the
                                same time.
                            </p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start profile-feed-item">
                        <img src="<?= base_url() ?>vendors/images/faces/face16.jpg" alt="profile"
                             class="img-sm rounded-circle"/>
                        <div class="ml-4">
                            <h6>
                                Willie Stanley
                                <small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>10 hours</small>
                            </h6>
                            <img src="<?= base_url() ?>vendors/images/samples/1280x768/12.jpg" alt="sample"
                                 class="rounded mw-100"/>
                        </div>
                    </div>
                    <div class="d-flex align-items-start profile-feed-item">
                        <img src="<?= base_url() ?>vendors/images/faces/face19.html" alt="profile"
                             class="img-sm rounded-circle"/>
                        <div class="ml-4">
                            <h6>
                                Dylan Silva
                                <small class="ml-4 text-muted"><i class="far fa-clock mr-1"></i>10 hours</small>
                            </h6>
                            <p>
                                When I first got into the online advertising business, I was looking for the magical
                                combination
                                that would put my website into the top search engine rankings
                            </p>
                            <img src="<?= base_url() ?>vendors/images/samples/1280x768/5.jpg" alt="sample"
                                 class="rounded mw-100"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Send message</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        $(".updateTaskBtn").on("click", function (e){
            const task_id = $(this).attr("data-id");
            $("#ModalLabel").text($("#task_title_"+task_id).val());
            $("#modalStatus").val($("#task_status_"+task_id).val());
            if($("#task_related_files"+task_id).attr("count") > 0){
                $("#attachments").html($("#task_related_files"+task_id).html());
            }else{
                $("#attachments").html("<p>No Attachment found</p>");
            }

            $('#update_task_modal').modal('show');
        });
</script>
