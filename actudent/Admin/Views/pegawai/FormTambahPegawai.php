<!-- Success message -->
<!-- <alert-msg alert-class="bg-success" 
    header="{+ lang Admin.sukses +}" :text="alert.text" v-if="alert.show">
</alert-msg> -->

<!-- Modal -->
<div class="modal fade text-left" id="tambahPegawaiModal" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true">
    <!-- Error message -->
    <alert-msg :alert-class="alert.class" 
        :header="alert.header" :text="alert.text" v-if="alert.show">
    </alert-msg>
    <!-- #End error message -->

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.staff_form_add_title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTambahPegawai">
                    <div class="form-body skin skin-square">                        
                        <div class="form-group">
                            <label for="userinput5">{{ lang.staff_id }}</label>
                            <input class="form-control border-primary" type="text" minlength="10" maxlength ="10" :placeholder="lang.staff_input_id" name="staff_nik">
                            <form-error :msg="error.staff_nik" />
                        </div>
                        <div class="form-group">
                            <label for="userinput5">{{ lang.staff_label_nama }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.staff_input_nama" name="staff_name">
                            <form-error :msg="error.staff_name" />
                        </div>                        
                        <div class="form-group">
                            <label for="userinput6">{{ lang.staff_label_telp }}</label>
                            <input class="form-control border-primary" type="text" minlength="11" maxlength="13" :placeholder="lang.staff_input_telp" name="staff_phone">
                            <form-error :msg="error.staff_phone" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.staff_label_jenis }}</label>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 skin skin-square">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <fieldset>
                                                <input type="radio" name="staff_type" id="teacher" value="teacher" checked>
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
                            <form name="upload-files" id="upload-files" method="post" enctype="multipart/form-data">
                            </form>
                            <input class="form-control border-primary" type="text" :placeholder="lang.staff_input_jabatan" name="staff_title">
                            <form-error :msg="error.staff_title" />
                                                  
                        </div>
                        <input type="hidden"  name="image_feature" v-model="helper.filename">      
                        <div class="form-group">
                            <label>{{ lang.staff_label_photo }}</label>                            
                            <form name="upload-file" id="upload-file" method="post" enctype="multipart/form-data">
                                <input class="form-control border-primary" type="file" accept="image/*" name="staff_photo" @change="helper.filename">
                                <p class="text-bold success-text" v-if="helper.uploadProgress">{{ lang.staff_foto_upload_progress }}</p>
                                <form-error :msg="error.staff_photo" />
                            </form>
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{+ lang AdminUser.user_email +}</label>
                            <div class="input-group">
                                <input class="form-control border-primary"  type="text" placeholder="username" name="user_email" autocomplete="off" >
                                <div class="input-group-append">
                                    <button class="btn btn-light" disabled type="button">@{domainSekolah}</button>
                                </div>    
                            </div>    
                            <form-error :msg="error.user_email" />                     
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{+ lang AdminUser.user_pass +}</label>
                            <input class="form-control border-primary" type="password" name="user_password" autocomplete="off"
                            minlength="8" placeholder="{+ lang AdminUser.user_pass_input +}">
                            <form-error :msg="error.user_password" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{+ lang AdminUser.user_pass_confirm +}</label>
                            <input class="form-control border-primary" type="password" name="user_password_confirm"
                            minlength="8" placeholder="{+ lang AdminUser.user_pass_confirm +}">
                            <form-error :msg="error.user_password_confirm" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
                <button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary" @click="save()"> {+ lang Admin.simpan +}</button>
            </div>
        </div>
    </div>
</div>
