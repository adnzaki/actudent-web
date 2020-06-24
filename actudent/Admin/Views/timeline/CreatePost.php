<div class="modal fade text-left" id="addPostModal" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true">
    <!-- Error message -->
    <alert-msg :alert-class="alert.class" 
        :header="alert.header" :text="alert.text" v-if="alert.show">
    </alert-msg>
    <!-- #End error message -->
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.timeline_add_post_title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTambahPost">
                    <div class="form-group">
                        <label>{+ lang AdminTimeline.timeline_label_post +}</label>
                        <input class="form-control border-primary" type="text" 
                            placeholder="{+ lang AdminTimeline.timeline_label_post +}" name="timeline_title">
                        <form-error :msg="error.timeline_title" />
                    </div>
                    <div class="form-group">
                        <label>{+ lang AdminTimeline.timeline_label_content +}</label>
                        <textarea rows="6" name="timeline_content" 
                            class="form-control border-primary" 
                            placeholder="{+ lang AdminTimeline.timeline_input_content +}">
                        </textarea>
                        <input type="hidden" name="image_feature" v-model="helper.filename">
                    </div>
                </form>
                <div class="form-group">
                    <label>{+ lang AdminTimeline.timeline_label_image +}</label>
                    <form name="upload-file" id="upload-file" method="post" enctype="multipart/form-data">
                        <input class="form-control border-primary" type="file" accept="image/*" name="timeline_image" @change="helper.filename">                        
                        <p class="text-bold success-text" v-if="helper.uploadProgress">{+ lang AdminTimeline.timeline_upload_progress +}</p>
                        <form-error :msg="error.timeline_image" />
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-warning" data-dismiss="modal"> {+ lang Admin.batal +}</button>
                <button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary" @click="save('draft')"> {{ lang.timeline_save_as_draft }}</button>
                <button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-success" @click="save()"> {{ lang.timeline_publish }}</button>
            </div>
        </div>
    </div>

</div>

<button type="button" class="btn btn-primary box-shadow-4
floating round btn-min-width mr-1 mb-1" @click="showAddPostModal">
    <strong>
        <span class="la la-pencil extend-la"></span>
    </strong>
</button>