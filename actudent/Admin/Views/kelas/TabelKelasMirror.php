<tr v-if="gradeWrapper.length > 0" v-for="(item, index) in gradeWrapper" :key="index" class="soft-dark">
	<td scope="row">{{ index + 1 }}</td>
	<td>{{ item.grade_name }}</td>
	<td>{{ item.period_start }} / {{ item.period_end }}</td>
	<td>{{ item.staff_name }}</td>
	<td>
		<button type="button" class="btn btn-icon btn-info" data-toggle="tooltip" data-placement="top"
			title="{+ lang Admin.perbarui +}" @click="getDetailKelas(item.grade_id)">
			<i class="la la-pencil"></i>
		</button>
		<button type="button" class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top"
			title="{+ lang AdminKelas.kelas_member +}" @click="showAnggotaRombel">
			<i class="la la-group"></i>
		</button>
		<button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top"
			title="{+ lang Admin.hapus +}">
			<i class="la la-trash"></i>
		</button>
	</td>
</tr>