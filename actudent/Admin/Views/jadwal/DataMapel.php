<div class="card-content collapse show" v-if="helper.showDaftarMapel">
    <div class="card-body">
        <div class="row">         
            <div class="col-12">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-info" 
                        data-toggle="modal" data-target="#tambahMapelModal">{+ lang Admin.tambah +}
                    </button>
                    <button type="button" class="btn btn-outline-danger" @click="multiDeleteConfirm"></i> {+ lang Admin.hapus +}</button>
                    <button type="button" @click="close()"
                        class="btn btn-outline-success"> {+ lang Admin.tutup +}
                    </button>
                </div>
            </div>            
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0 cursor-pointer">
            <thead>
                <tr>
                    <th><Checkbox v-model="checkAll" color="#0070ff" @change="selectAll"></Checkbox></th>
                    <th>{+ lang AdminJadwal.jadwal_nama_mapel +}</th>
                    <th>{+ lang AdminJadwal.jadwal_guru_mapel +}</th>
                    <th>{+ lang Admin.aksi +}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in lessonList" :key="index" class="soft-dark">
                    <td scope="row" class="decrease-col-size">
                        <Checkbox v-model="lessons" :value="item.lessons_grade_id" color="#0070ff"></Checkbox>
                    </td>
                    <td>{{ item.lesson_name }} ({{ item.lesson_code }})</td>
                    <td>{{ item.teacher }}</td>
                    <td>
                        <button type="button" class="btn btn-icon btn-info" data-toggle="tooltip" data-placement="top"
                            title="{+ lang Admin.perbarui +}" @click="getDetailMapel(item.lessons_grade_id)">
                            <i class="la la-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top"
                            title="{+ lang Admin.hapus +}" @click="singleDeleteConfirm(item.lessons_grade_id)">
                            <i class="la la-trash"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row" v-if="lessonList.length === 0">
        <div class="col-12">
            <div class="text-left pl-2 mb-3">
                <br><p>{+ lang Admin.no_data +}</p>
            </div>
        </div>
    </div>
</div>

