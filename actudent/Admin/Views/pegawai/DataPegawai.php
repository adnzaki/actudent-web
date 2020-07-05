<div class="card-content collapse show">
    <div class="card-body">        
        <div class="row">         
            <div class="col-12 col-md-4 col-lg-4 col-xl-3">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-info" 
                        data-toggle="modal" data-target="#tambahPegawaiModal"  @click="showAddPegawaiForm">{+ lang Admin.tambah +}                        
                    </button>
                    <button type="button" class="btn btn-outline-danger" @click="multiDeleteConfirm">{+ lang Admin.hapus +}</button> 
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3 mb-10">
                <select class="select2 form-control block" id="selectStaff" name="staff_type" style="width: 100%">
                    <option selected value="null">{+ lang AdminPegawai.staff_semua_bagian +}</option>
                    <option value="teacher">{+ lang AdminPegawai.staff_guru +}</option>
                    <option value="staff">{+ lang AdminPegawai.staff_pegawai +}</option>
                </select>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-2 mb-10">
                <select class="select2 form-control" id="showRows" style="width: 100%;">
                    <option value="10">10 {+ lang Admin.baris +}</option>
                    <option value="25">25 {+ lang Admin.baris +}</option>
                    <option value="50">50 {+ lang Admin.baris +}</option>
                    <option value="100">100 {+ lang Admin.baris +}</option>
                    <option value="250">250 {+ lang Admin.baris +}</option>
                </select>
            </div>
            <div class="col-12 col-xl-4">
                <fieldset>
                    <div class="input-group">
                        <input type="text" class="form-control" @keyup.enter="filter" v-model="search"
                        placeholder="{+ lang AdminPegawai.staff_cari +}" aria-describedby="button-addon2">
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
                <th class="decrease-col-size">
                    <Checkbox v-model="checkAll" color="#0070ff" @change="selectAll"></Checkbox>
                </th>
                <th @click="sortData('staff_nik')">{+ lang AdminPegawai.staff_id +}<i class="la la-sort"></th>
                <th @click="sortData('staff_name')">{+ lang AdminPegawai.staff_nama +}<i class="la la-sort"></th>
                <th @click="sortData('staff_phone')">{+ lang AdminPegawai.staff_label_telp +}<i class="la la-sort"></th>
                <th @click="sortData('staff_title')">{+ lang AdminPegawai.staff_label_jabatan +}<i class="la la-sort"></th>
                <th>{+ lang Admin.aksi +}</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in data" :key="index" class="soft-dark">
                <td scope="row" class="decrease-col-size">
                    <Checkbox v-model="staff" :value="item.staff_id + '-' + item.user_id" color="#0070ff"></Checkbox>
                </td>
                <td>{{ item.staff_nik }}</td>
                <td>{{ item.staff_name }}</td>
                <td>{{ item.staff_phone }}</td>
                <td>{{ item.staff_title }}</td>
                <td>
                    <button type="button" class="btn btn-icon btn-info mr-1" 
                        data-toggle="tooltip" data-placement="top" title="{+ lang Admin.perbarui +}"
                        @click="getDetailPegawai(item.user_id)">
                        <i class="la la-pencil"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-danger mr-1"
                        data-toggle="tooltip" data-placement="top" title="{+ lang Admin.hapus +}"
                        @click="singleDeleteConfirm(item.staff_id, item.user_id)">
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