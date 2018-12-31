/**
 * Actudent Data Siswa scripts
 * 
 * @author      Adnan Zaki
 * @copyright   Wolestech (c) 2018
 */

const siswa = new Vue({
    el: '#siswa-content',
    mixins: [SSPaging],
    data: {
        siswa: `${admin}SiswaController/`,
        error: { 
            studentNis: '', studentName: '', 
            gradeName: '',
        },
        alert: {
            class: 'alert-danger', show: false,
            header: 'Sukses', text: 'heheheh',
        },
        daftarKelas: '',
    },
    mounted() {
        this.reset()
        setTimeout(() => {
            this.getSiswa()            
        }, 200);
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