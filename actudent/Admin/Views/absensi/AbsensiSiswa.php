<div class="card-content collapse show">
    <div class="card-body">
        <div class="row">
            <div class="col-3 col-sm-1">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-warning" @click="openJurnalModal"
                        data-toggle="modal" :disabled="jurnalDisabled">{+ lang AdminAbsensi.absensi_isi_jurnal +}
                    </button>
                </div>
            </div> 
            <div class="col-4 col-sm-2" v-if="helper.presenceButtons">
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
        </div>
        <div class="row">  
            <div class="col-12 col-sm-6 col-lg-4 mb-10">
                <select class="select2 form-control mb-10" id="pilihKelas" style="width: 100%;">
                    <option selected value="null">{+ lang AdminAbsensi.absensi_pilih_kelas +}</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 mb-10">
                <div class="input-group">
                    <input type='text' name="agendaDateStart"
                    class="form-control border-primary pickadate-selectors pickadate" :placeholder="lang.agenda_input_start" />
                    <div class="input-group-append">
                        <span class="input-group-text border-primary">
                            <span class="la la-calendar-o"></span>
                        </span>
                    </div>
                </div> 
            </div>
            <div class="col-12 col-sm-12 col-lg-4">
                <select class="select2 form-control" id="pilihMapel" style="width: 100%;">
                </select>
            </div>
        </div>
    </div>    
    <div class="table-responsive">
        <table class="table table-hover mb-0 cursor-pointer">
            {+ include Actudent\Admin\Views\absensi\ListAbsen +}   
        </table>
    </div>
    <!-- <pager 
        :show-paging="showPaging"
        :link-class="linkClass"
        :page-links="pageLinks"
        :num-links="numLinks"
        :active-link="activeLink"
        :nav="nav" 
        :first="first" :prev="prev"
        :next="next" :last="last"
        :row-range="rowRange"
    /> -->
</div>

