            <thead>
                <tr>
                    <th class="decrease-col-size">
                        <Checkbox v-model="checkAll" color="#0070ff" @change="selectAll"></Checkbox>
                    </th>
                    <th class="small-pad-left">{+ lang AdminSiswa.siswa_nama +}</th>
                    <th>Status</th>
                    <th class="hide-on-mobile" v-if="!helper.backToArchive">{+ lang Admin.aksi +}</th>
                    <th class="hide-on-mobile">{+ lang AdminAbsensi.absensi_keterangan +}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in siswa" :key="index" class="soft-dark">
                    <td scope="row" class="decrease-col-size">
                        <Checkbox v-model="absenSiswa" :value="item.id" color="#0070ff"></Checkbox>
                    </td>
                    <td class="small-pad-left" v-if="!isSmallScreen">{{ item.name }}</td>
                    <td class="small-pad-left" v-if="isSmallScreen">{{ item.name | substr(22) }}</td>
                    <td><div :class="['badge', presenceClass(item.statusID)]">{{ item.status }}</div></td>                    
                    <td class="hide-on-mobile" v-if="!helper.backToArchive">
                        <div class="btn-group" role="group" aria-label="Basic example" v-if="helper.presenceButtons">
                            <button type="button" class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top"
                                title="{+ lang AdminAbsensi.absensi_hadir +}" @click="saveAbsen(1, item.id)">
                                <i class="la la-check"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-secondary" data-toggle="tooltip" data-placement="top"
                                title="{+ lang AdminAbsensi.absensi_sakit +}" @click="saveAbsen(3, item.id)">
                                <i class="la la-medkit"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-info" data-toggle="tooltip" data-placement="top"
                                title="{+ lang AdminAbsensi.absensi_izin +}" @click="openIzinModal(item.id, item.note)">
                                <i class="la la-info"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-danger" data-toggle="tooltip" data-placement="top"
                                title="{+ lang AdminAbsensi.absensi_alfa +}" @click="saveAbsen(0, item.id)">
                                <i class="la la-minus-circle"></i>
                            </button>
                        </div>
                    </td>
                    <td class="hide-on-mobile" width="200">{{ statusNote(item.note) }}</td>
                </tr>
            </tbody>
