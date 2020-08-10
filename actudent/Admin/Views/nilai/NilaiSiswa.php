<div class="card-content collapse show" v-cloak>
    <div class="card-body">
        <div class="row">
            <div class="col-3 col-lg-1">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-warning"
                        data-toggle="modal">Tambah
                    </button>
                </div>
            </div> 
        </div>
        <div class="row">  
            <div class="col-12 col-sm-6 col-lg-4 mb-10">
                <select class="select2 form-control mb-10" id="pilihKelas" style="width: 100%;">
                    <option selected value="null">{+ lang AdminAbsensi.absensi_pilih_kelas +}</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 mb-10">
                <select class="select2 form-control mb-10" id="pilihTipe" style="width: 100%;">
                    <option selected value="Teori">Teori</option>
                    <option value="Praktik">Praktik</option>
                </select>
            </div>
            <div class="col-12 col-sm-12 col-lg-4">
                <select class="select2 form-control" id="pilihMapel" style="width: 100%;">
                </select>
            </div>            
        </div>
    </div>        
    <!-- <div class="table-responsive" v-if="helper.archivePage || helper.presenceGrid">
        <table class="table table-hover mb-0 cursor-pointer">
            {+ include Actudent\Admin\Views\absensi\ListAbsen +}   
        </table>
    </div>
    <div class="table-responsive" v-if="!helper.archivePage && !helper.presenceGrid">
        {+ include Actudent\Admin\Views\absensi\ArsipJurnal +}   
    </div> -->
</div>

