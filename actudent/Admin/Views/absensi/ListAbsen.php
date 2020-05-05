            <thead>
                <tr>
                    <th class="decrease-col-size">
                        <Checkbox v-model="checkAll" color="#0070ff" @change="selectAll"></Checkbox>
                    </th>
                    <th @click="sortData('grade_name')" class="small-pad-left">Nama Siswa<i class="la la-sort"></th>
                    <th @click="sortData('period_from')">Status<i class="la la-sort"></th>
                    <th class="hide-on-mobile">{+ lang Admin.aksi +}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in siswa" :key="index" class="soft-dark">
                    <td scope="row" class="decrease-col-size">
                        <Checkbox v-model="siswa" :value="'eek'" color="#0070ff"></Checkbox>
                    </td>
                    <td class="small-pad-left" v-if="!isSmallScreen">{{ item.nama }}</td>
                    <td class="small-pad-left" v-if="isSmallScreen">{{ item.nama | substr(22) }}</td>
                    <td><div class="badge badge-success">Hadir</div></td>
                    <td class="hide-on-mobile">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top"
                                title="{+ lang AdminAbsensi.absensi_hadir +}">
                                <i class="la la-check"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-secondary" data-toggle="tooltip" data-placement="top"
                                title="{+ lang AdminAbsensi.absensi_sakit +}">
                                <i class="la la-medkit"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-info" data-toggle="tooltip" data-placement="top"
                                title="{+ lang AdminAbsensi.absensi_izin +}">
                                <i class="la la-info"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top"
                                title="{+ lang AdminAbsensi.absensi_alfa +}">
                                <i class="la la-minus-circle"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
