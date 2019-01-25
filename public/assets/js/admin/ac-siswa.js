/**
 * Actudent Data Siswa scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const siswa = new Vue({
    el: '#siswa-content',
    mixins: [SSPaging, plugin],
    data: {
        siswa: `${admin}SiswaController/`,
        error: { 
            studentNis: '', studentName: '', 
            gradeName: '',
        },
        alert: {
            class: 'alert bg-danger', show: true,
            header: 'Sukses', text: 'heheheh',
        },
        helper: {
            saveAndClose: false,
        },
        daftarKelas: '',
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getSiswa()            
        }, 200);
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
    },
    methods: {
        showFormTambah() {
            $.ajax({
                url: `${this.siswa}getKelas`,
                dataType: 'json',
                success: data => {
                    this.daftarKelas = data
                }
            })
        },
        getSiswa() {
            this.getData({
                limit: 10,
                offset: 0,
                orderBy: 'studentName',
                searchBy: 'studentNis-studentName-gradeName',
                sort: 'DESC',
                search: '',
                url: `${this.siswa}getDataSiswa/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        }
    }
})