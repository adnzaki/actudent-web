<div class="card-content collapse show" v-if="helper.showDaftarKelas">
    <div class="card-body">
        <div class="row">         
            <div class="col-12 col-sm-6 col-md-4 col-lg-5 col-xl-6">
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2 mb-10">
                <select class="select2 form-control" id="showRows" style="width: 100%;">
                    <option value="10" selected>10 {+ lang Admin.baris +}</option>
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
                        :placeholder="lang.kelas_cari" aria-describedby="button-addon2">
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
                    <th>#</th>
                    <th @click="sortData('grade_name')">{+ lang AdminKelas.kelas_nama +}<i class="la la-sort"></th>
                    <th @click="sortData('period_from')">{+ lang AdminKelas.kelas_tahun +}<i class="la la-sort"></th>
                    <th @click="sortData('staff_name')">{+ lang AdminKelas.kelas_wali +}<i class="la la-sort"></th>
                    <th>{+ lang Admin.aksi +}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(item, index) in data" :key="index" class="soft-dark">
                    <td scope="row">{{ index + 1 }}</td>
                    <td>{{ item.grade_name }}</td>
                    <td>{{ item.period_start }} / {{ item.period_end }}</td>
                    <td>{{ item.staff_name }}</td>
                    <td>
                        <button type="button" class="btn btn-icon btn-info" data-toggle="tooltip" data-placement="top"
                            title="{+ lang AdminJadwal.jadwal_daftar_mapel +}" @click="showMapel(item.grade_id)">
                            <i class="la la-list-alt"></i>
                        </button>
                        <button type="button" class="btn btn-icon btn-success" data-toggle="tooltip" data-placement="top"
                            title="{+ lang AdminJadwal.jadwal_jadwal_mapel +}" @click="showJadwal(item.grade_id)">
                            <i class="la la-book"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <pager 
        :show-paging="showPaging"
        :link-class="linkClass"
        :page-links="pageLinks"
        :num-links="numLinks"
        :active-link="activeLink"
        :nav="nav" 
        :first="first" :prev="prev"
        :next="next" :last="last"
        :row-range="rowRange"
    />
</div>

