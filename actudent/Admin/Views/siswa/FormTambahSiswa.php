<!-- Modal -->
<div class="modal fade text-left" id="iconModal" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.siswa_add_title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formTambahSiswa">
                    <div class="form-body">                        
                        <div class="form-group">
                            <label for="userinput5">NIS</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.siswa_add_title" name="student_nis">
                            <form-error :msg="error.studentNis" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.siswa_nama }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.siswa_input_nama" name="student_name">
                            <form-error :msg="error.studentName" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.siswa_kk }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.siswa_input_kk" name="parent_family_card">
                            <form-error :msg="error.familyCard" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.siswa_label_ayah }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.siswa_input_ayah" name="parent_father_name">
                            <form-error :msg="error.fatherName" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.siswa_label_ibu }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.siswa_input_ibu" name="parent_mother_name">
                            <form-error :msg="error.motherName" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">{{ lang.siswa_label_telp }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.siswa_input_telp" name="parent_phone_number">
                            <form-error :msg="error.phone" />
                        </div>
                        <div class="form-group">
                            <label for="selectGrade">{{ lang.siswa_kelas }}</label>
                            <select class="select2 form-control block" id="selectGrade" name="gradeID" style="width: 100%">
                                <option v-for="item in daftarKelas" :value="item.grade_id">{{ item.grade_name }}</option>
                            </select>
                            <form-error :msg="error.gradeName" />
                        </div>
                    </div>
                </form>
                <alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
                <button type="button" class="btn btn-outline-primary"> {+ lang Admin.simpan +}</button>
                <button type="button" class="btn btn-outline-success"> {+ lang Admin.simpan_tutup +}</button>
            </div>
        </div>
    </div>
</div>
