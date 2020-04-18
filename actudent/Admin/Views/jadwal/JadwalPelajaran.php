<div class="card-content collapse show" v-if="helper.showJadwalMapel">
    <div class="card-body">
        <div class="row">         
            <div class="col-12">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-info" 
                        data-toggle="modal" @click="getPengaturan">{+ lang Admin.menu_pengaturan +}
                    </button>
                    <button type="button" @click="close('jadwal')"
                        class="btn btn-outline-warning"> {+ lang Admin.tutup +}
                    </button>
                </div>
            </div>            
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0 cursor-pointer">
                <thead>
                    <tr>
                        <th>{+ lang Admin.day1 +}</th>
                        <th>{+ lang Admin.day2 +}</th>
                        <th>{+ lang Admin.day3 +}</th>
                        <th>{+ lang Admin.day4 +}</th>
                        <th>{+ lang Admin.day5 +}</th>
                        <th>{+ lang Admin.day6 +}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="soft-dark">
                        <td>
                            <div class="text-left garis-pembatas" 
                             v-for="(item, index) in scheduleList.senin" :key="index">
                                <a data-toggle="collapse" data-parent="#accordionWrap1" :href="'#accordion-senin-' + index"
                                    aria-expanded="true" :aria-controls="'accordion-senin-' + index" 
                                    :class="[lessonClass, isBreak(item.lesson_grade_id)]">
                                    {{ item.lesson_name }}
                                </a>
                                <div :id="'accordion-senin-' + index" role="tabpanel" aria-labelledby="heading11" class="collapse text-left text-1rem">
                                    {+ lang AdminJadwal.jadwal_durasi +}: {{ item.duration }} 
                                    <span v-if="item.lesson_grade_id === null">{{ lang.jadwal_menit }}</span>
                                    <span v-else>{{ lang.jadwal_jam_pelajaran }}</span><br>
                                    {+ lang AdminJadwal.jadwal_waktu +}: {{ item.schedule_start }} - {{ item.schedule_end }} <br>
                                    <div v-if="item.lesson_grade_id !== null">
                                        {+ lang AdminJadwal.jadwal_guru_mapel +}: {{ item.teacher }}
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top"
                                title="{+ lang Admin.perbarui +}" @click="showJadwalModal('senin')">{+ lang Admin.kelola +}
                            </button>
                        </td>
                        <td>
                            <div class="text-left garis-pembatas" v-for="(item, index) in scheduleList.selasa" :key="index">
                                <a data-toggle="collapse" data-parent="#accordionWrap1" :href="'#accordion-selasa-' + index"
                                    aria-expanded="true" :aria-controls="'accordion-selasa-' + index" 
                                    :class="[lessonClass, isBreak(item.lesson_grade_id)]">
                                    {{ item.lesson_name }}
                                </a>
                                <div :id="'accordion-selasa-' + index" role="tabpanel" aria-labelledby="heading11" class="collapse text-left text-1rem">
                                    {+ lang AdminJadwal.jadwal_durasi +}: {{ item.duration }} 
                                    <span v-if="item.lesson_grade_id === null">{{ lang.jadwal_menit }}</span>
                                    <span v-else>{{ lang.jadwal_jam_pelajaran }}</span><br>
                                    {+ lang AdminJadwal.jadwal_waktu +}: {{ item.schedule_start }} - {{ item.schedule_end }} <br>
                                    <div v-if="item.lesson_grade_id !== null">
                                        {+ lang AdminJadwal.jadwal_guru_mapel +}: {{ item.teacher }}
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top"
                                @click="showJadwalModal('selasa')" title="{+ lang Admin.perbarui +}">{+ lang Admin.kelola +}
                            </button>
                        </td>
                        <td>
                            <div class="text-left garis-pembatas" v-for="(item, index) in scheduleList.rabu" :key="index">
                                <a data-toggle="collapse" data-parent="#accordionWrap1" :href="'#accordion-rabu-' + index"
                                    aria-expanded="true" :aria-controls="'accordion-rabu-' + index" 
                                    :class="[lessonClass, isBreak(item.lesson_grade_id)]">
                                    {{ item.lesson_name }}
                                </a>
                                <div :id="'accordion-rabu-' + index" role="tabpanel" aria-labelledby="heading11" class="collapse text-left text-1rem">
                                    {+ lang AdminJadwal.jadwal_durasi +}: {{ item.duration }} 
                                    <span v-if="item.lesson_grade_id === null">{{ lang.jadwal_menit }}</span>
                                    <span v-else>{{ lang.jadwal_jam_pelajaran }}</span><br>
                                    {+ lang AdminJadwal.jadwal_waktu +}: {{ item.schedule_start }} - {{ item.schedule_end }} <br>
                                    <div v-if="item.lesson_grade_id !== null">
                                        {+ lang AdminJadwal.jadwal_guru_mapel +}: {{ item.teacher }}
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top"
                                @click="showJadwalModal('rabu')" title="{+ lang Admin.perbarui +}">{+ lang Admin.kelola +}
                            </button>
                        </td>
                        <td>
                            <div class="text-left garis-pembatas" v-for="(item, index) in scheduleList.kamis" :key="index">
                                <a data-toggle="collapse" data-parent="#accordionWrap1" :href="'#accordion-kamis-' + index"
                                    aria-expanded="true" :aria-controls="'accordion-kamis-' + index" 
                                    :class="[lessonClass, isBreak(item.lesson_grade_id)]">
                                    {{ item.lesson_name }}
                                </a>
                                <div :id="'accordion-kamis-' + index" role="tabpanel" aria-labelledby="heading11" class="collapse text-left text-1rem">
                                    {+ lang AdminJadwal.jadwal_durasi +}: {{ item.duration }} 
                                    <span v-if="item.lesson_grade_id === null">{{ lang.jadwal_menit }}</span>
                                    <span v-else>{{ lang.jadwal_jam_pelajaran }}</span><br>
                                    {+ lang AdminJadwal.jadwal_waktu +}: {{ item.schedule_start }} - {{ item.schedule_end }} <br>
                                    <div v-if="item.lesson_grade_id !== null">
                                        {+ lang AdminJadwal.jadwal_guru_mapel +}: {{ item.teacher }}
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top"
                                @click="showJadwalModal('kamis')" title="{+ lang Admin.perbarui +}">{+ lang Admin.kelola +}
                            </button>
                        </td>
                        <td>
                            <div class="text-left garis-pembatas" v-for="(item, index) in scheduleList.jumat" :key="index">
                                <a data-toggle="collapse" data-parent="#accordionWrap1" :href="'#accordion-jumat-' + index"
                                    aria-expanded="true" :aria-controls="'accordion-jumat-' + index" 
                                    :class="[lessonClass, isBreak(item.lesson_grade_id)]">
                                    {{ item.lesson_name }}
                                </a>
                                <div :id="'accordion-jumat-' + index" role="tabpanel" aria-labelledby="heading11" class="collapse text-left text-1rem">
                                    {+ lang AdminJadwal.jadwal_durasi +}: {{ item.duration }} 
                                    <span v-if="item.lesson_grade_id === null">{{ lang.jadwal_menit }}</span>
                                    <span v-else>{{ lang.jadwal_jam_pelajaran }}</span><br>
                                    {+ lang AdminJadwal.jadwal_waktu +}: {{ item.schedule_start }} - {{ item.schedule_end }} <br>
                                    <div v-if="item.lesson_grade_id !== null">
                                        {+ lang AdminJadwal.jadwal_guru_mapel +}: {{ item.teacher }}
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top"
                                @click="showJadwalModal('jumat')" title="{+ lang Admin.perbarui +}">{+ lang Admin.kelola +}
                            </button>
                        </td>
                        <td>
                            <div class="text-left garis-pembatas" v-for="(item, index) in scheduleList.sabtu" :key="index">
                                <a data-toggle="collapse" data-parent="#accordionWrap1" :href="'#accordion-sabtu-' + index"
                                    aria-expanded="true" :aria-controls="'accordion-sabtu-' + index" 
                                    :class="[lessonClass, isBreak(item.lesson_grade_id)]">
                                    {{ item.lesson_name }}
                                </a>
                                <div :id="'accordion-sabtu-' + index" role="tabpanel" aria-labelledby="heading11" class="collapse text-left text-1rem">
                                    {+ lang AdminJadwal.jadwal_durasi +}: {{ item.duration }} 
                                    <span v-if="item.lesson_grade_id === null">{{ lang.jadwal_menit }}</span>
                                    <span v-else>{{ lang.jadwal_jam_pelajaran }}</span><br>
                                    {+ lang AdminJadwal.jadwal_waktu +}: {{ item.schedule_start }} - {{ item.schedule_end }} <br>
                                    <div v-if="item.lesson_grade_id !== null">
                                        {+ lang AdminJadwal.jadwal_guru_mapel +}: {{ item.teacher }}
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="top"
                                @click="showJadwalModal('selasa')" title="{+ lang Admin.perbarui +}">{+ lang Admin.kelola +}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

