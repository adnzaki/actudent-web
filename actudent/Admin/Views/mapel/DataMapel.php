<div class="card-content collapse show">
	<div class="card-body">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-4 col-lg-5 col-xl-6">
				<div class="form-group">
					<button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#tambahMapelModal">{+ lang
						Admin.tambah +}
					</button>
					<button type="button" class="btn btn-outline-danger" @click="multiDeleteConfirm">{+ lang Admin.hapus
						+}</button>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-10">
				<select class="select2 form-control" id="showRows" style="width: 100%;">
					<option value="10">10 {+ lang Admin.baris +}</option>
					<option value="25">25 {+ lang Admin.baris +}</option>
					<option value="50">50 {+ lang Admin.baris +}</option>
					<option value="100">100 {+ lang Admin.baris +}</option>
					<option value="250">250 {+ lang Admin.baris +}</option>
				</select>
			</div>
			<div class="col-12 col-md-4">
				<fieldset>
					<div class="input-group">
						<input type="text" class="form-control" @keyup.enter="filter" v-model="search"
							:placeholder="lang.mapel_cari" aria-describedby="button-addon2">
						<div class="input-group-append">
							<button class="btn btn-primary" type="button" @click="filter">Go</button>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-hover mb-0 cursor-pointer">
			<thead>
				<tr>
					<th class="decrease-col-size">
						<Checkbox v-model="checkAll" color="#0070ff" @change="selectAll"></Checkbox>
					</th>
					<th @click="sortData('lesson_code')">{+ lang AdminMapel.mapel_kode +}<i class="la la-sort"></th>
					<th @click="sortData('lesson_name')">{+ lang AdminMapel.mapel_nama +}<i class="la la-sort"></th>
					<th>{+ lang Admin.aksi +}</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="(item, index) in data" :key="index" class="soft-dark">
					<td scope="row" class="decrease-col-size">
						<Checkbox v-model="lessons" :value="item.lesson_id" color="#0070ff"></Checkbox>
					</td>
					<td>{{ item.lesson_code }}</td>
					<td>{{ item.lesson_name }}</td>
					<td>
						<button type="button" class="btn btn-icon btn-info mr-1" data-toggle="tooltip" data-placement="top"
							title="{+ lang Admin.perbarui +}" @click="getDetailMapel(item.lesson_id)">
							<i class="la la-pencil"></i>
						</button>
						<button type="button" class="btn btn-icon btn-danger mr-1" data-toggle="tooltip" data-placement="top"
							title="{+ lang Admin.hapus +}" @click="singleDeleteConfirm(item.lesson_id)">
							<i class="la la-trash"></i>
						</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<pager :show-paging="showPaging" :link-class="linkClass" :page-links="pageLinks" :num-links="numLinks"
		:active-link="activeLink" :nav="nav" :first="first" :prev="prev" :next="next" :last="last" :row-range="rowRange" />
</div>
