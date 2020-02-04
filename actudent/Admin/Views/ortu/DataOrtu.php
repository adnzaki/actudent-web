<div class="card-content collapse show">
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-6 col-xl-7">
                <div class="form-group">
                    <button type="button" class="btn btn-outline-info" 
                        data-toggle="modal" data-target="#tambahOrtuModal">{+ lang Admin.tambah +}
                    </button>
                    <button type="button" class="btn btn-outline-danger"></i> {+ lang Admin.hapus +}</button>
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
            <div class="col-3">
                <fieldset>
                    <div class="input-group">
                        <input type="text" class="form-control" @keyup.enter="filter" v-model="search"
                        placeholder="{+ lang AdminOrtu.ortu_cari +}" aria-describedby="button-addon2">
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
        <thead class="skin skin-square">
            <tr>
                <th><input type="checkbox" id="input-1"></th>
                <th @click="sortData('parent_family_card')">{+ lang AdminOrtu.ortu_kk +}<i class="la la-sort"></th>
                <th @click="sortData('parent_father_name')">{+ lang AdminOrtu.ortu_label_ayah +}<i class="la la-sort"></th>
                <th @click="sortData('parent_mother_name')">{+ lang AdminOrtu.ortu_label_ibu +}<i class="la la-sort"></th>
                <th @click="sortData('parent_phone_number')">{+ lang AdminOrtu.ortu_label_telp +}<i class="la la-sort"></th>
            </tr>
        </thead>
        <tbody class="">
            <tr v-for="(item, index) in data" :key="index">
                <td scope="row">
                    <div class="skin skin-square">
                        <fieldset>
                            <input type="checkbox" :id="'p-' + index">
                        </fieldset>                    
                    </div>
                </td>
                <td>{{ item.parent_family_card }}</td>
                <td>{{ item.parent_father_name }}</td>
                <td>{{ item.parent_mother_name }}</td>
                <td>{{ item.parent_phone_number }}</td>
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