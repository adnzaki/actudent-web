<div class="row">
	<div class="col-12">
		<div class="card {cardColor}">
			<div class="card-header {cardColor}" v-cloak>
				<h4 class="card-title {cardTitleColor}">{{ cardTitle }}</h4>
				<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
				<div class="heading-elements">
					<ul class="list-inline mb-0">
						<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
						<li><a data-action="reload" @click="showJadwal(gradeID, false)" v-if="helper.showJadwalMapel"><i class="ft-rotate-cw"></i></a></li>
						<li><a data-action="reload" @click="reloadData" v-if="!helper.showJadwalMapel"><i class="ft-rotate-cw"></i></a></li>
						<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
						<li><a v-if="helper.showJadwalMapel" @click="close('jadwal')"><i class="ft-x"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="loader-wrapper" v-if="spinner">
				<div class="loader-container">
					<div class="ball-rotate loader-danger">
						<div></div>
					</div>
				</div>
			</div>
			{+ include Actudent\Admin\Views\siswa\alert +}
			{+ include Actudent\Admin\Views\jadwal\DataKelas +}
			{+ include Actudent\Admin\Views\jadwal\DataMapel +}
			{+ include Actudent\Admin\Views\jadwal\FormTambahMapel +}
			{+ include Actudent\Admin\Views\jadwal\FormEditMapel +}
			{+ include Actudent\Admin\Views\jadwal\JadwalPelajaran +}
			{+ include Actudent\Admin\Views\jadwal\FormKelolaJadwal +}
			{+ include Actudent\Admin\Views\jadwal\FormPengaturan +}
			{+ include Actudent\Admin\Views\jadwal\DeleteConfirm +}
		</div>
	</div>
</div>