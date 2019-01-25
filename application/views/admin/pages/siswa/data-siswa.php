<div class="card-content collapse show">
    <div class="card-body">
        <div class="row">            
            <div class="col-6">
                <div class="form-group">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button @click="showFormTambah" type="button" class="btn btn-primary box-shadow-1" 
                            data-toggle="modal" data-target="#iconModal">Tambah 
                        </button>
                        <button type="button" class="btn btn-danger box-shadow-1">Hapus</button> 
                        <button type="button" class="btn btn-light box-shadow-1">Filter</button>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <select class="select2 form-control" id="showRows">
                    <option value="10">10 baris</option>
                    <option value="25">25 baris</option>
                    <option value="50">50 baris</option>
                    <option value="100">100 baris</option>
                    <option value="250">250 baris</option>
                </select>
            </div>
            <div class="col-3">
                <fieldset>
                    <div class="input-group">
                        <input type="text" class="form-control" @keyup.enter="filter" v-model="search"
                        placeholder="Cari nama, NIS, kelas" aria-describedby="button-addon2">
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
                <th @click="sortData('studentNis')">NIS<i class="la la-sort"></th>
                <th @click="sortData('studentName')">Nama Siswa<i class="la la-sort"></th>
                <th @click="sortData('gradeName')">Kelas<i class="la la-sort"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in data" :key="index">
                <td scope="row">{{ index + 1 }}</td>
                <td>{{ item.studentNis }}</td>
                <td>{{ item.studentName }}</td>
                <td>{{ item.gradeName }}</td>
            </tr>
        </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="text-left pl-2 mb-3">
                <br><p>{{ rowRange }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12">
            <div class="text-center mb-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center pagination-round">
                        <li v-bind:class="[linkClass]" @click="nav(first)">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <li v-bind:class="[linkClass]" @click="nav(prev)">
                            <a class="page-link" href="#">Prev</a>
                        </li>
                        <li v-for="link in pageLinks" v-bind:class="[linkClass, activeLink(link)]" 
                            v-if="numLinks" @click="nav((link - 1))">
                            <a class="page-link" href="#">{{ link }}</a>
                        </li>
                        <li v-bind:class="[linkClass]" @click="nav(next)">
                            <a class="page-link" href="#">Next</a>
                        </li>
                        <li v-bind:class="[linkClass]" @click="nav(last)">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>                
    </div>
</div>