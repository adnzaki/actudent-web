<!-- Modal -->
<div class="modal fade text-left" id="iconModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header {modalHeaderColor} white">
                <h4 class="modal-title white" id="myModalLabel2"><i class="la la-road2"></i> Basic Modal</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form" id="formTambahSiswa">
                    <div class="form-body">                        
                        <div class="form-group">
                            <label for="userinput5">NIS</label>
                            <input class="form-control border-primary" type="text" placeholder="Nomor Induk Sekolah" name="studentNis">
                            <form-error :msg="error.studentNis" />
                        </div>
                        <div class="form-group">
                            <label for="userinput6">Nama Siswa</label>
                            <input class="form-control border-primary" type="text" placeholder="Nama Lengkap Peserta Didik" name="studentName">
                            <form-error :msg="error.studentName" />
                        </div>
                        <div class="form-group">
                            <label for="userinput7">Kelas</label>
                            <select class="form-control" id="userinput7" name="gradeName">
                                <option v-for="item in daftarKelas" :value="item.gradeID">{{ item.gradeName }}</option>
                            </select>
                            <form-error :msg="error.gradeName" />
                        </div>
                    </div>
                </form>
                <alert-msg :alert-class="alert.class" :header="alert.header" :text="alert.text" v-if="alert.show" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning mr-1" data-dismiss="modal"><i class="ft-x"></i> Cancel</button>
                <button type="button" class="btn btn-primary"><i class="la la-check-square-o"></i> Save</button>
            </div>
        </div>
    </div>
</div>
