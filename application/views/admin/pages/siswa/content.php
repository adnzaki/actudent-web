<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Data Siswa</h4>
                <a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload" @click="reloadData" ><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <button type="button" class="btn mr-1 mb-1 btn-primary btn-sm"><i class="la la-plus"></i> Tambah</button>
                                <button type="button" class="btn mr-1 mb-1 btn-danger btn-sm"><i class="la la-trash"></i> Hapus</button>
                                <button type="button" class="btn mr-1 mb-1 btn-light btn-sm"><i class="la la-filter"></i> Filter</button>
                            </div>
                        </div>
                        <div class="col-3">
                            <fieldset class="form-group">
                                <select class="form-control" v-model="rows" id="basicSelect" v-on:change="showPerPage">
                                    <option value="10">10 baris</option>
                                    <option value="25">25 baris</option>
                                    <option value="50">50 baris</option>
                                    <option value="100">100 baris</option>
                                    <option value="250">250 baris</option>
                                </select>
                            </fieldset>
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
                    <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th @click="sortData('studentNis')" class="cursor-pointer">NIS<i class="la la-sort"></th>
                            <th @click="sortData('studentName')" class="cursor-pointer">Nama Siswa<i class="la la-sort"></th>
                            <th @click="sortData('gradeName')" class="cursor-pointer">Kelas<i class="la la-sort"></th>
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
        </div>
    </div>
</div>
