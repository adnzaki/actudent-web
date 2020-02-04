<!-- Success message -->
<alert-msg alert-class="bg-success" 
    header="{+ lang Admin.sukses +}" :text="alert.text" v-if="alert.show">
</alert-msg>

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
                    <div class="form-body">                        
                        <div class="form-group">
                            <label for="userinput5">{{ lang.ortu_kk }}</label>
                            <input class="form-control border-primary" type="text" minlength="16" maxlength ="16" :placeholder="lang.ortu_input_kk" name="parent_family_card">
                            <form-error :msg="error.parent_family_card" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.ortu_label_ayah }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.ortu_input_ayah" name="parent_father_name">
                            <form-error :msg="error.parent_father_name" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.ortu_label_ibu }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.ortu_input_ibu" name="parent_mother_name">
                            <form-error :msg="error.parent_mother_name" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.ortu_label_telp }}</label>
                            <input class="form-control border-primary" type="text" minlength="11" maxlength="13" :placeholder="lang.ortu_input_telp" name="parent_phone_number">
                            <form-error :msg="error.parent_phone_number" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.ortu_label_user }}</label><br>
                            <p class="text-success" v-if="userCheck && showSelectedUser">
                                <strong>
                                    {{ selectedUser.text }} <i class="la la-check"></i>
                                </strong>
                            </p>
                            <p class="text-danger" v-if="!userCheck && showSelectedUser">
                                <strong>
                                    {{ lang.ortu_user_selected }} <i class="la la-close"></i>
                                </strong>
                            </p>
                            <input type="hidden" name="user_id" v-model="selectedUser.data.user_id">
                            <div class="input-group">
                                <input class="form-control border-primary" type="text" v-model="searchParam" 
                                @focus="searchResultWrapper = true"
                                :placeholder="lang.ortu_input_user" @keyup="searchUser">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" 
                                    @click="clearResult">{+ lang Admin.bersihkan +}</button>
                                </div>                                
                            </div>  
                            <div class="list-group list-group-custom add-margin-top-5px" v-if="searchResultWrapper">
                                <a href="javascript:void()" class="list-group-item active list-group-item-custom">
                                    {+ lang Admin.hasil_cari +} "{{ searchParam }}"
                                </a>
                                <a href="javascript:void()" class="list-group-item list-group-item-action 
                                list-group-item-custom"
                                v-for="item in users" @click="selectUser(item.user_id)">
                                    {{ item.user_name }} ({{ item.user_email }})
                                </a>
                            </div>
                            <form-error :msg="error.user_id" />
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
