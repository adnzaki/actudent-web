<table class="table table-hover mb-0 cursor-pointer" v-if="helper.daftarPelajaran">
    <thead>
        <tr>
            <th class="decrease-col-size">
                No
            </th>
            <th class="small-pad-left">{+ lang AdminAbsensi.absensi_mapel +}</th>
            <th>{+ lang AdminKelas.kelas_nama +}</th>
            <th>{+ lang Admin.aksi +}</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(item, index) in guru.lessons" :key="index" class="soft-dark">
            <td scope="row" class="decrease-col-size">{{ index + 1 }}</td>
            <td class="small-pad-left">{{ item.lesson_name }}</td>
            <td class="small-pad-left">{{ item.grade_name }}</td>
            <td>
                <button type="button" class="btn btn-icon btn-info mr-1" style="padding: 0.5rem 0.75rem;"
                    data-toggle="tooltip" data-placement="top" title="{+ lang AdminNilai.nilai_daftar_nilai +}"
                    @click="showDaftarNilai(item.grade_id, item.lessons_grade_id)">
                    <i class="la la-edit" style="font-size: 1.6rem;"></i>
                </button>
            </td>
        </tr>
    </tbody>
</table>