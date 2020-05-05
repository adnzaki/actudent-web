<!-- Modal -->
<div class="modal fade text-left" id="jurnalModal" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true">

    <!-- Error message -->
    <alert-msg :alert-class="alert.class" 
        :header="alert.header" :text="alert.text" v-if="alert.show">
    </alert-msg>
    <!-- #End error message -->

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> {+ lang AdminAbsensi.absensi_jurnal_title +}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formJurnal">
                    <div class="form-body">
                    	<div class="form-group">
                    		<label for="userinput6">{{ lang.absensi_isi_jurnal }}</label>
                    		<textarea class="form-control border-primary"
                    			name="description" :placeholder="lang.absensi_konten_jurnal">
                            </textarea>
                            <form-error :msg="error.lesson_hour" />
                    	</div>
                        <div class="form-group">
                            <Checkbox v-model="helper.homework" color="#0070ff">{{ lang.absensi_sertakan_pr }}</Checkbox>
                        </div>
                        <div class="form-group" v-if="helper.homework">
                    		<label for="userinput6">{{ lang.absensi_label_pr }}</label>
                    		<textarea class="form-control border-primary"
                    			name="homework" :placeholder="lang.absensi_detail_pr">
                            </textarea>
                            <form-error :msg="error.lesson_hour" />
                    	</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-dismiss="modal"> {+ lang Admin.batal +}</button>
                <button type="button" :disabled="helper.disableSaveButton" class="btn btn-outline-primary"> {+ lang Admin.simpan +}</button>
            </div>
        </div>
    </div>
</div>
