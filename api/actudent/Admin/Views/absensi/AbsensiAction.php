<div class="card-body">
	<div class="row">
		<div class="col-12">
			<div class="form-group">
				<button type="button" class="btn btn-outline-warning mr-1" @click="openJurnalModal" data-toggle="modal"
					:disabled="jurnalDisabled" v-if="helper.archivePage">{+ lang AdminAbsensi.absensi_isi_jurnal +}
				</button>
        <div class="btn-group mr-1" v-if="helper.presenceButtons">
					<button type="button" class="btn btn-outline-primary btn-min-width dropdown-toggle" data-toggle="dropdown"
						aria-haspopup="true" aria-expanded="true">{+ lang Admin.aksi
						+}</button>
					<div class="dropdown-menu">
						<a class="dropdown-item action-list" href="javascript:void(0)" @click="saveAbsen(1)">{+ lang
							AdminAbsensi.absensi_hadir +}</a>
						<a class="dropdown-item action-list" href="javascript:void(0)" @click="saveAbsen(3)">{+ lang
							AdminAbsensi.absensi_sakit +}</a>
						<a class="dropdown-item action-list" @click="multiPresence" href="javascript:void(0)">{+
							lang
							AdminAbsensi.absensi_izin +}</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item action-list" href="javascript:void(0)" @click="saveAbsen(0)">{+ lang
							AdminAbsensi.absensi_alfa +}</a>
					</div>
				</div>
        <div class="btn-group mr-1" v-if="!jurnalDisabled">
					<button type="button" class="btn btn-outline-success btn-min-width dropdown-toggle" data-toggle="dropdown"
						aria-haspopup="true" aria-expanded="true">{+ lang
						AdminAbsensi.absensi_cetak_laporan +}</button>
					<div class="dropdown-menu">
						<a class="dropdown-item action-list" :href="journalReportURL" target="_blank">{+ lang
							AdminAbsensi.absensi_cetak_jurnal +}</a>
						<a class="dropdown-item action-list" :href="presenceReportURL" target="_blank">{+ lang
							AdminAbsensi.absensi_cetak_absen +}</a>
					</div>
				</div>
        <button type="button" class="btn btn-outline-danger" 
          @click="showArchive" data-toggle="modal" v-if="archiveStatus && helper.archiveButton">
          {+ lang AdminAbsensi.absensi_arsip_jurnal +}
				</button>
        <button type="button" class="btn btn-outline-danger" 
          v-if="!helper.archivePage && !helper.backToArchive" @click="closeArchive" data-toggle="modal">
          {+ lang AdminAbsensi.absensi_tutup_arsip +}
				</button>
        <button type="button" class="btn btn-outline-primary"
          v-if="helper.backToArchive" @click="showArchive" data-toggle="modal">
          {+ lang AdminAbsensi.absensi_kembali_ke_arsip +}
				</button>
			</div>
		</div>
	</div>

	<div class="row" v-if="helper.archivePage">
		<div class="col-12 col-sm-6 col-lg-4 mb-10">
			<select class="select2 form-control mb-10" id="pilihKelas" style="width: 100%;">
				<option selected value="null">{+ lang AdminAbsensi.absensi_pilih_kelas +}</option>
			</select>
		</div>
		<div class="col-12 col-sm-6 col-lg-4 mb-10">
			<div class="input-group">
				<input type='text' name="agendaDateStart" class="form-control border-primary pickadate-selectors pickadate"
					:placeholder="lang.agenda_input_start" />
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
	<div class="row" v-if="helper.backToArchive">
		<div class="col-12">
			<p><strong>{+ lang AdminAbsensi.absensi_mapel +}:</strong> {{ presenceArchive.lesson }}</p>
			<p><strong>{+ lang AdminAbsensi.absensi_isi_jurnal +}:</strong> {{ presenceArchive.journal }}</p>
			<p v-if="presenceArchive.homework !== ''">
				<strong>{+ lang AdminAbsensi.absensi_teks_pr +}:</strong> {{ presenceArchive.homework }}
				({+ lang AdminAbsensi.absensi_label_deadline +}:
				{{ presenceArchive.dueDate | substr(10, '') | formatDate }})
			</p>
		</div>
	</div>
</div>
