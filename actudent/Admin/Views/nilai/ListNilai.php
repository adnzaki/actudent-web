            <thead>
                <tr>
                    <th class="decrease-col-size">
                        No.
                    </th>
                    <th class="small-pad-left">{+ lang AdminNilai.nilai_label_kategori +}</th>
                    <th>{+ lang AdminNilai.nilai_label_deskripsi +}</th>
                    <th>{+ lang Admin.diperbarui +}</th>
                    <th>{+ lang Admin.aksi +}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in scoreList" :key="index" class="soft-dark">
                    <td scope="row" class="decrease-col-size">
                        {{ index + 1 }}
                    </td>
                    <td class="small-pad-left">{{ item.score_category }}</td>
                    <td>{{ item.score_description }}</td>  
                    <td>{{ item.modified }}</td>
                    <td>
                        <button type="button" class="btn btn-icon btn-info" data-toggle="tooltip" data-placement="top"
                            title="{+ lang Admin.perbarui +}" @click="getDetailNilai(item.score_id)">
                            <i class="la la-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top"
                            title="{+ lang Admin.hapus +}" @click="showDeleteConfirm(item.score_id)">
                            <i class="la la-trash"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top"
                            title="{+ lang AdminNilai.nilai_daftar_nilai +}" @click="showKelolaNilai(item.score_id)">
                            <i class="la la-clipboard"></i>
                        </button>
                        <a type="button" class="btn btn-icon btn-secondary" data-toggle="tooltip" data-placement="top"
                            title="{+ lang AdminNilai.nilai_ekspor_excel +}" :href="exportExcel(item.score_id)" target="_blank">
                            <i class="la la-file-text"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
