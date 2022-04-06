<!-- Modal -->
<div class="modal fade text-left" id="editPenggunaModal" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true">
    <!-- Error message -->
    <alert-msg :alert-class="alert.class" 
        :header="alert.header" :text="alert.text" v-if="alert.show">
    </alert-msg>
    <!-- #End error message -->

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.user_update_title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formEditPengguna">
                    <div class="form-body">                         
                        <div class="form-group">
                            <label for="userinput5">{{ lang.user_label_nama }}</label>
                            <input class="form-control border-primary" readonly="readonly" type="text" v-model="userDetail.user_name"
                             name="user_name">
                            <!-- <form-error :msg="error.staff_name" /> -->
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.user_label_email }}</label>
                            <input class="form-control border-primary" readonly="readonly"  type="text" v-model="userDetail.user_email"
                             name="user_email">
                            <!-- <form-error :msg="error.staff_phone" /> -->
                        </div>                        
                        <div class="form-group">
                            <label for="userinput5">{{ lang.user_label_level }}</label>
                            <input class="form-control border-primary" readonly="readonly" type="text" v-model="userDetail.level_text"
                             name="level_text">
                            <!-- <form-error :msg="error.staff_title" /> -->
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{+ lang AdminUser.user_newPass +}</label>
                            <input class="form-control border-primary" type="password" name="user_password"
                            minlength="8" placeholder="{+ lang AdminUser.user_pass_input +}" autocomplete="off">
                            <form-error :msg="error.user_password" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{+ lang AdminUser.user_newPass_confirm +}</label>
                            <input class="form-control border-primary" type="password" name="user_password_confirm"
                            minlength="8" placeholder="{+ lang AdminUser.user_pass_confirm +}">
                            <form-error :msg="error.user_password_confirm" />
                        </div>                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
                <button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary" 
                    @click="save(userDetail.user_id)"> {+ lang Admin.simpan +}
                </button>
            </div>
        </div>
    </div>
</div>
