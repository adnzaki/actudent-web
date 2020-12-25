<table class="table table-hover mb-0 cursor-pointer">
	<thead>
		<tr>
			<th class="decrease-col-size">
				No
			</th>
			<th class="small-pad-left">{+ lang AdminAbsensi.absensi_mapel +}</th>
			<th>{+ lang AdminKelas.kelas_nama +}</th>
			<th>{+ lang AdminRuang.page_title +}</th>
			<th>{+ lang AdminJadwal.jadwal_label_alokasi +}</th>
			<th>{+ lang AdminJadwal.jadwal_waktu +}</th>
			<th>{+ lang Admin.aksi +}</th>
		</tr>
	</thead>
	<tbody>
		<tr v-for="(item, index) in guru.jadwal" :key="index" class="soft-dark">
			<td scope="row" class="decrease-col-size">{{ index + 1 }}</td>
			<td class="small-pad-left">{{ item.lesson_name }}</td>
			<td class="small-pad-left">{{ item.grade_name }}</td>
			<td class="small-pad-left">{{ item.room_name }}</td>
			<td>{{ item.duration }} {+ lang AdminJadwal.jadwal_jam_pelajaran +}</td>
			<td>{{ item.schedule_start }} - {{ item.schedule_end }}</td>
			<td>
				<button type="button" class="btn btn-icon btn-success mr-1" style="padding: 0.5rem 0.75rem;"
					data-toggle="tooltip" data-placement="top" title="{+ lang GuruAbsensi.absensi_isi_jurnal +}"
					@click="showPresencePage(item.grade_id, item.schedule_id)">
					<i class="la la-calendar-check-o" style="font-size: 1.6rem;"></i>
				</button>
			</td>
		</tr>
	</tbody>
</table>
