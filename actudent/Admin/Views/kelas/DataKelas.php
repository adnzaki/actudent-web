<div class="card-content collapse show">
    <div class="card-body">
        <div class="row">         
            <div class="col-12 col-sm-6 col-md-4 col-lg-5 col-xl-6">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-info" 
                        data-toggle="modal" data-target="#iconModal">{+ lang Admin.tambah +}
                    </button>
                    <button type="button" class="btn btn-outline-danger">{+ lang Admin.hapus +}</button> 
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
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
                <th>{+ lang Admin.aksi +}<i class="la la-sort"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in data" :key="index">
                <td scope="row">{{ index + 1 }}</td>
                <td>{{ item.grade_name }}</td>
                <td>{{ item.period_from }} / {{ item.period_until }}</td>
                <td>{{ item.staff_name }}</td>
                <td>
                    <button type="button" class="btn btn-icon btn-info"
                        data-toggle="tooltip" data-placement="top" title="{+ lang Admin.perbarui +}"
                        >
                        <i class="la la-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-success"
                        data-toggle="tooltip" data-placement="top" title="{+ lang AdminKelas.kelas_member +}"
                        >
                        <i class="la la-group"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-danger"
                        data-toggle="tooltip" data-placement="top" title="{+ lang Admin.hapus +}"
                        >
                        <i class="la la-trash"></i>
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