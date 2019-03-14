<div class="card-content collapse show">
    <div class="card-body">
        <div class="row">   
            <div class="col-sm-12">
                <flash-alert :alert-class="flashAlert.class" :title="flashAlert.title" :icon="flashAlert.icon" 
                :text="flashAlert.text" v-if="flashAlert.show" />
            </div>
        </div>
        <div class="row">         
            <div class="col-12 col-md-4 col-lg-6 col-xl-7">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-info" 
                        data-toggle="modal" data-target="#iconModal">{{ lang.tambah }}
                    </button>
                    <button type="button" class="btn btn-outline-danger">{{ lang.hapus }}</button> 
                    <button type="button" class="btn btn-outline-warning">Filter</button>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">
                <select class="select2 form-control" id="showRows" style="width: 100%;">
                    <option value="10">10 {+ lang Admin.baris +}</option>
                    <option value="25">25 {+ lang Admin.baris +}</option>
                    <option value="50">50 {+ lang Admin.baris +}</option>
                    <option value="100">100 {+ lang Admin.baris +}</option>
                    <option value="250">250 {+ lang Admin.baris +}</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <fieldset>
                    <div class="input-group">
                        <input type="text" class="form-control" @keyup.enter="filter" v-model="search"
                        :placeholder="lang.siswa_cari" aria-describedby="button-addon2">
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
                <th @click="sortData('grade_name')">{+ lang Admin.kelas_nama +}<i class="la la-sort"></th>
                <th @click="sortData('period_from')">Periot Start<i class="la la-sort"></th>
                <th @click="sortData('period_until')">Periot Last<i class="la la-sort"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in data" :key="index">
                <td scope="row">{{ index + 1 }}</td>
                <td>{{ item.grade_name }}</td>
                <td>{{ item.period_from }}</td>
                <td>{{ item.period_until }}</td>
            </tr>
        </tbody>
        </table>
    </div>
    <pager 
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