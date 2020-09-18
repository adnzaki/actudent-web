<!-- Modal -->
<div class="modal fade text-left" id="tambahNilaiModal" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true" v-if="helper.daftarNilai">
    <!-- Error message -->
    <alert-msg :alert-class="alert.class" 
        :header="alert.header" :text="alert.text" v-if="alert.show">
    </alert-msg>
    <!-- #End error message -->

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {{ lang.nilai_add_title }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formTambahNilai">
                    <div class="form-body skin skin-square">                        
                        <div class="form-group">
                            <label for="userinput5">{{ lang.nilai_label_kategori }}</label>
                            <select class="select2 form-control mb-10" id="tipeNilai" style="width: 100%;" name="score_category">
                                <option selected value="Tugas">Tugas</option>
                                <option value="UH">Ulangan Harian</option>
                                <option value="PTS">Penilaian Tengah Semester</option>
                                <option value="PAS">Penilaian Akhir Semester</option>
                                <option value="Kinerja">Kinerja</option>
                                <option value="Proyek">Proyek</option>
                            </select>
                            <form-error :msg="error.score_category" />
                        </div>
                        
                        <div class="form-group">
                            <label for="userinput6">{{ lang.nilai_label_deskripsi }}</label>
                            <input class="form-control border-primary" type="text" :placeholder="lang.nilai_input_deskripsi" name="score_description">
                            <form-error :msg="error.score_description" />
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
