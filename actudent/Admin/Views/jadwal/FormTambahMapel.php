<!-- Modal -->
<div class="modal fade text-left" id="tambahMapelModal" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true">

    <!-- Error message -->
    <alert-msg :alert-class="alert.class" 
        :header="alert.header" :text="alert.text" v-if="alert.show">
    </alert-msg>
    <!-- #End error message -->

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.jadwal_add_title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formTambahMapel">
                    <div class="form-body">                        
                        <div class="form-group">
                            <label for="userinput6">{{ lang.jadwal_label_pilih_mapel }}</label>
                            <div class="row">
                                <div class="col-12">
                                    <select class="select2-mapel" style="width: 100%;" id="pilih-mapel" name="lesson_id">
                                        <option value="">{+ lang AdminJadwal.jadwal_input_cari_mapel +}</option>
                                    </select>                                
                                </div>
                            </div>
                            <form-error :msg="error.lesson_id" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.jadwal_label_pilih_guru }}</label>
                            <div class="input-group">
                                <input class="form-control border-primary" type="text" v-model="searchParam" 
                                placeholder="{+ lang AdminKelas.kelas_input_wali +}" @keyup="searchTeacher">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" 
                                    @click="clearResult">{+ lang Admin.bersihkan +}</button>
                                </div>
                            </div>
                            <div class="list-group list-group-custom add-margin-top-5px" v-if="searchResultWrapper">
                                <a v-if="teachers.length === 0" href="javascript:void(0)" class="list-group-item list-group-item-action 
                                    list-group-item-custom">
                                        {+ lang Admin.no_search_result +} "{{ searchParam }}"
                                </a>
                                <a v-else href="javascript:void()" class="list-group-item list-group-item-action 
                                    list-group-item-custom" v-for="item in teachers" @click="selectTeacher(item)">
                                        {{ item.staff_name }} ({{item.staff_nik}})
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.kelas_label_walikelas }}</label>
                            <input class="form-control border-primary" disabled type="text" :placeholder="lang.jadwal_label_pilih_guru" v-model="selectedTeacher.name">
                            <input type="hidden" name="teacher_id" v-model="selectedTeacher.id">                            
                            <form-error :msg="error.teacher_id" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
                <button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary" @click="saveMapel(gradeID)"> {+ lang Admin.simpan +}</button>
            </div>
        </div>
    </div>
</div>
