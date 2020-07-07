<div class="card-content collapse show" v-cloak>
    <div class="card-body">
        <div class="row">
            <div class="col-3 col-sm-1" v-if="guru.helper.showAbsen && helper.archivePage">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-warning" @click="openJurnalModal"
                        data-toggle="modal">{+ lang AdminAbsensi.absensi_isi_jurnal +}
                    </button>
                </div>
            </div> 
            <div class="col-4 col-sm-2" v-if="helper.presenceButtons && guru.helper.showAbsen">
            	<div class="form-group">
            		<div class="btn-group mr-1 mb-1">
            			<button type="button" class="btn btn-outline-primary btn-min-width dropdown-toggle"
            				data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">{+ lang Admin.aksi +}</button>
            			<div class="dropdown-menu">
            				<a class="dropdown-item action-list" href="javascript:void(0)" @click="saveAbsen(1)">{+ lang AdminAbsensi.absensi_hadir +}</a>
            				<a class="dropdown-item action-list" href="javascript:void(0)" @click="saveAbsen(3)">{+ lang AdminAbsensi.absensi_sakit +}</a>
            				<a class="dropdown-item action-list" @click="multiPresence" href="javascript:void(0)">{+ lang AdminAbsensi.absensi_izin +}</a>
            				<div class="dropdown-divider"></div>
            				<a class="dropdown-item action-list" href="javascript:void(0)" @click="saveAbsen(0)">{+ lang AdminAbsensi.absensi_alfa +}</a>
            			</div>
            		</div>
            	</div>
            </div>
            <!-- Print report button -->
            {# if $isHomeroom === true #}
            <!-- <div class="col-12 col-lg-2" v-if="guru.helper.showAbsen && helper.archivePage">
                <div class="form-group">
                    <a class="btn btn-outline-success" :href="reportURL" target="_blank"
                        >{+ lang AdminAbsensi.absensi_cetak_laporan +}
                    </a>
                </div>
            </div> -->
            {# endif #}
            <!-- Button to close presence page -->
            <div class="col-12 col-lg-2" v-if="guru.helper.closePresenceButton">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-danger" @click="closePresencePage"
                        data-toggle="modal">{+ lang Admin.tutup +}
                    </button>
                </div>
            </div> 

            <!-- Button to close journal and presence archive -->
            <div class="col-12 col-lg-4" v-if="!helper.archivePage && !helper.backToArchive">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-danger" @click="closeArchive"
                        data-toggle="modal">{+ lang AdminAbsensi.absensi_tutup_arsip +}
                    </button>
                </div>
            </div>
            <div class="col-12 col-lg-4" v-if="helper.backToArchive">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-primary" @click="showArchive"
                        data-toggle="modal">{+ lang AdminAbsensi.absensi_kembali_ke_arsip +}
                    </button>
                </div>
            </div>
        </div>
        
        <div class="row" v-if="guru.helper.showJadwal">  
            <div class="col-12 col-sm-6 col-lg-4 mb-10">
                <div class="input-group">
                    <input type='text' name="scheduleDate"
                    class="form-control border-primary pickadate-selectors pickadate" />
                    <div class="input-group-append">
                        <span class="input-group-text border-primary">
                            <span class="la la-calendar-o"></span>
                        </span>
                    </div>
                </div> 
            </div>
            <div class="col-12 col-sm-4 mb-10" v-if="guru.helper.showJadwal">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-danger" @click="showArchive"
                        data-toggle="modal">{+ lang AdminAbsensi.absensi_arsip_jurnal +}
                    </button>
                </div>
            </div>
        </div>
        <div class="row" v-if="helper.backToArchive">
            <div class="col-12">
                <p><strong>{+ lang AdminAbsensi.absensi_mapel +}:</strong> {{ presenceArchive.lesson }}</p>
                <p><strong>{+ lang AdminAbsensi.absensi_isi_jurnal +}:</strong> {{ presenceArchive.journal }}</p>
                <p v-if="presenceArchive.homework !== ''">
                    <strong>{+ lang AdminAbsensi.absensi_teks_pr +}:</strong> {{ presenceArchive.homework }} 
                    ({+ lang AdminAbsensi.absensi_label_deadline +}: {{ presenceArchive.dueDate | substr(10, '') | formatDate }})
                </p>
            </div>
        </div>
    </div>        
    <div class="table-responsive" v-if="guru.helper.showJadwal">
        <table class="table table-hover mb-0 cursor-pointer">
            {+ include Actudent\Guru\Views\JadwalKehadiran\JadwalHarian +}   
        </table>
    </div>
    <div class="table-responsive" v-if="guru.helper.showAbsen">
        <table class="table table-hover mb-0 cursor-pointer">
            {+ include Actudent\Admin\Views\absensi\ListAbsen +}   
        </table>        
    </div>
    <div class="table-responsive" v-if="!helper.archivePage && !helper.presenceGrid">
        {+ include Actudent\Admin\Views\absensi\ArsipJurnal +}   
    </div>
</div>

