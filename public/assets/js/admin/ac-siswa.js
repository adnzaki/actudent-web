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
        siswa: `${admin}siswa/`,
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
        this.runSelect2()
        this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminSiswa')
    },
    methods: {
        showFormTambah() {
            $.ajax({
                url: `${this.siswa}get-kelas`,
                dataType: 'json',
                success: data => {
                    this.daftarKelas = data
                }
            })
        },
        getSiswa() {
            this.getData({
                lang: bahasa,
                limit: 10,
                offset: 0,
                orderBy: 'student_name',
                searchBy: 'student_nis-student_name-grade_name',
                sort: 'ASC',
                search: '',
                url: `${this.siswa}get-siswa/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        }
    }
})