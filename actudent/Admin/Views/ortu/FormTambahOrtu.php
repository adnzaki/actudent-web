<!-- Modal -->
<div class="modal fade text-left" id="tambahOrtuModal" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true">
    <!-- Error message -->
    <alert-msg :alert-class="alert.class" 
        :header="alert.header" :text="alert.text" v-if="alert.show">
    </alert-msg>
    <!-- #End error message -->

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.ortu_form_add_title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formTambahOrtu">
                    <div class="form-body skin skin-square">                        
                        <div class="form-group">
                            <label for="userinput5">{{ lang.ortu_kk }}</label>
                            <input class="form-control border-primary" type="text" minlength="16" maxlength ="16" :placeholder="lang.ortu_input_kk" name="parent_family_card">
                            <form-error :msg="error.parent_family_card" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.ortu_label_ayah }}</label>
                            <div class="input-group">
                                <input class="form-control border-primary" type="text" v-model="fatherName" :placeholder="lang.ortu_input_ayah" name="parent_father_name">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary disable-hover" 
                                    data-toggle="tooltip" data-placement="left" :title="lang.ortu_set_acc_name" type="button">
                                        <fieldset>
                                            <input type="radio" name="user_name" checked id="ayah" :value="fatherName">
                                        </fieldset>
                                    </button>
                                </div>    
                            </div> 
                            <form-error :msg="error.parent_father_name" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.ortu_label_ibu }}</label>
                            <div class="input-group">
                                <input class="form-control border-primary" type="text"
                                v-model="motherName" :placeholder="lang.ortu_input_ibu" name="parent_mother_name">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary disable-hover"
                                    data-toggle="tooltip" data-placement="left" :title="lang.ortu_set_acc_name" type="button">
                                        <fieldset>
                                            <input type="radio" name="user_name" id="ibu" :value="motherName">
                                        </fieldset>
                                    </button>
                                </div>    
                            </div> 
                            <form-error :msg="error.parent_mother_name" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.ortu_label_telp }}</label>
                            <input class="form-control border-primary" type="text" minlength="11" maxlength="13" :placeholder="lang.ortu_input_telp" name="parent_phone_number">
                            <form-error :msg="error.parent_phone_number" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{+ lang AdminUser.user_email +}</label>
                            <div class="input-group">
                                <input class="form-control border-primary" autocomplete="off" type="text" placeholder="username" name="user_email">
                                <div class="input-group-append">
                                    <button class="btn btn-light" disabled type="button">@{domainSekolah}</button>
                                </div>    
                            </div>    
                            <form-error :msg="error.user_email" />                     
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{+ lang AdminUser.user_pass +}</label>
                            <input class="form-control border-primary" autocomplete="off" type="password" name="user_password"
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
