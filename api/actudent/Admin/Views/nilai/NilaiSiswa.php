<div class="card-body">
	<div class="row">
		<div class="col-3 col-lg-1">
			<div class="form-group">
				<button type="button" class="btn btn-outline-warning" :disabled="disableAddBtn" @click="showFormTambahNilai">{+
					lang Admin.tambah +}
				</button>
			</div>
		</div>
		{if $_SESSION['userLevel'] === '2'}
		<div class="col-4 col-lg-1">
			<div class="form-group">
				<button type="button" class="btn btn-outline-danger" @click="closeDaftarNilai">{+ lang Admin.tutup
					+}
				</button>
			</div>
		</div>
		{endif}
	</div>
	<div class="row">
		{if $_SESSION['userLevel'] === '1'}
		<div class="col-12 col-sm-6 col-lg-4 mb-10">
			<select class="select2 form-control mb-10" id="pilihKelas" style="width: 100%;">
				<option selected value="null">{+ lang AdminAbsensi.absensi_pilih_kelas +}</option>
			</select>
		</div>
		{endif}
		<div class="col-12 col-sm-6 col-lg-4 mb-10">
			<select class="select2 form-control mb-10" id="pilihTipe" style="width: 100%;">
				<option selected value="Teori">Teori</option>
				<option value="Praktik">Praktik</option>
			</select>
		</div>
		{if $_SESSION['userLevel'] === '1'}
		<div class="col-12 col-sm-12 col-lg-4">
			<select class="select2 form-control" id="pilihMapel" style="width: 100%;">
			</select>
		</div>
		{endif}
	</div>
</div>
