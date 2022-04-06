<div class="table-responsive" v-if="!helper.archivePage && !helper.presenceGrid">
	<table class="table table-hover mb-0 cursor-pointer">
		<thead>
			<tr>
				<th class="decrease-col-size">
					No
				</th>
				<th class="small-pad-left">{+ lang AdminAbsensi.absensi_mapel +}</th>
				{if $_SESSION['userLevel'] === '2'}
				<th>{+ lang AdminKelas.kelas_nama +}</th>
				{endif}
				<th>{+ lang AdminAbsensi.absensi_isi_jurnal +}</th>
				<th>{+ lang Admin.tanggal +}</th>
				<th>{+ lang Admin.aksi +}</th>
			</tr>
		</thead>
		<tbody>
			<tr v-for="(item, index) in journalArchive" :key="index" class="soft-dark">
				<td scope="row" class="decrease-col-size">{{ index + 1 }}</td>
				<td class="small-pad-left">{{ item.lesson_name }}</td>
				{if $_SESSION['userLevel'] === '2'}
				<td class="small-pad-left">{{ item.grade_name }}</td>
				{endif}
				<td class="small-pad-left">{{ item.description | substr(25) }}</td>
				<td>{{ item.created | substr(10, '') | formatDate }}</td>
				<td>
					<button type="button" class="btn btn-icon btn-info mr-1" data-toggle="tooltip" data-placement="top"
						title="{+ lang Admin.tampilkan +}" @click="showPresenceArchive(item)">
						<i class="la la-eye"></i>
					</button>
				</td>
			</tr>
		</tbody>
	</table>
</div>
