<div class="modal fade text-left" id="addPostForm" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.timeline_add_post_title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="summernote">
                    <div class="form-group">
                        <label>Judul Post</label>
                        <input class="form-control border-primary" type="text" placeholder="Judul post"
                            name="timeline_title">
                        <!-- <form-error :msg="error.agenda_name" /> -->
                    </div>
                
                    <textarea name="editordata" id="summernote"></textarea>
                </form>
                <br>
                <div class="form-group">
                    <label>Gambar fitur</label>
                    <form action="" name="upload-file" id="upload-file" method="post" enctype="multipart/form-data">
                        <input class="form-control border-primary" type="file" accept="image/*" name="timeline_image">
                    </form>
                    <!-- <form-error :msg="error.timeline_image" /> -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" data-dismiss="modal"> {+ lang Admin.batal +}</button>
                <button type="button" class="btn btn-outline-primary"> {{ lang.timeline_save_draft }}</button>
                <button type="button" class="btn btn-outline-success"> {{ lang.timeline_publish }}</button>
            </div>
        </div>
    </div>

</div>

<button type="button" class="btn btn-primary box-shadow-4
floating round btn-min-width mr-1 mb-1" @click="showAddPostForm">
    <strong>
        <span class="la la-pencil extend-la"></span>
    </strong>
</button>