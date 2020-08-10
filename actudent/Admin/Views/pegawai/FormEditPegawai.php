<!-- Modal -->
<div class="modal fade text-left" id="editPegawaiModal" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true">
    <!-- Error message -->
    <alert-msg :alert-class="alert.class" 
        :header="alert.header" :text="alert.text" v-if="alert.show">
    </alert-msg>
    <!-- #End error message -->

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.staff_edit_title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formEditPegawai">
                    <div class="form-body"> 
                        <div class="form-group">
                            <label for="userinput5">{{ lang.staff_id }}</label>
                            <input class="form-control border-primary" type="text" v-model="staffDetail.staff_nik"
                            minlength="10" maxlength ="10" :placeholder="lang.staff_input_id" name="staff_nik">
                            <form-error :msg="error.staff_nik" />
                        </div>
                        <div class="form-group">
                            <label for="userinput5">{{ lang.staff_label_nama }}</label>
                            <input class="form-control border-primary" type="text" v-model="staffDetail.staff_name"
                            :placeholder="lang.staff_input_nama" name="staff_name">
                            <form-error :msg="error.staff_name" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.staff_label_telp }}</label>
                            <input class="form-control border-primary" type="text" v-model="staffDetail.staff_phone"
                            minlength="11" maxlength="13" :placeholder="lang.staff_input_telp" name="staff_phone">
                            <form-error :msg="error.staff_phone" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.staff_label_jenis }}</label>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 skin skin-square" id="staffType">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <fieldset>
                                                <input type="radio" name="staff_type" id="teacher" value="teacher" >
                                                <label>{{ lang.staff_guru }}</label>
                                            </fieldset>
                                        </div>
                                        <div class="col-sm-6">
                                            <fieldset>
                                                <input type="radio" name="staff_type" id="staff" value="staff" >
                                                <label>{{ lang.staff_pegawai }}</label>
                                            </fieldset>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <form-error :msg="error.staff_type" />
                        </div>
                        <div class="form-group">
                            <label for="userinput5">{{ lang.staff_label_jabatan }}</label>
                            <form name="update-files" id="update-files" method="post" enctype="multipart/form-data">
                            </form>
                            <input class="form-control border-primary" type="text" v-model="staffDetail.staff_title"
                            :placeholder="lang.staff_input_jabatan" name="staff_title">
                            <form-error :msg="error.staff_title" />
                        </div>

                        <input type="hidden"  name="image_feature" v-model="helper.filename">
                        <div class="form-group">
                            <label>{{ lang.staff_label_photo }}</label>
                            <form name="update-file" id="update-file" method="post" enctype="multipart/form-data">
                                <input class="form-control border-primary" type="file" accept="image/*" name="staff_photo" @change="helper.filename">
                                <p class="text-bold success-text" v-if="helper.uploadProgress">{{ lang.staff_foto_upload_progress }}</p>
                                <form-error :msg="error.staff_photo" />
                            </form>
                        </div>
                        <img class="img-thumbnail img-fluid" :src="helper.imageBase64 + helper.updateImage" alt="no image">

                        <!-- <img class="img-thumbnail img-fluid" :src="helper.imageURL + timelineDetail.timeline_image"
                            itemprop="thumbnail" alt="Image description" width="250" height="156" v-if="!helper.validImage" /> -->
                        <input type="hidden" name="update_image" v-model="helper.updateImage">
                        <input type="hidden" name="current_image" v-model="helper.currentImage">

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
                <button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary" 
                    @click="save(true, staffDetail.user_id)"> {+ lang Admin.simpan +}
                </button>
            </div>
        </div>
    </div>
</div>
