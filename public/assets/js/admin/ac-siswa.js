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
            this.getKelas()
        }, 200);
        this.runSelect2()
        this.getSiswaByKelas()
        this.select2ShowPerPage('#showRows')
        this.getLanguageResources('AdminSiswa')
    },
    methods: {
        showFormTambah() {
        },
        getSiswa() {
            this.getData({
                lang: bahasa,
                limit: 25,
                offset: 0,
                orderBy: 'student_name',
                searchBy: ['student_nis', 'student_name', 'grade_name'],
                sort: 'ASC',
                where: null,
                search: '',
                url: `${this.siswa}get-siswa/`,
                linkNum: 4,
                activeClass: 'active',
                linkClass: 'page-item',
            })
        },
        getSiswaByKelas() {
            let obj = this
            $('#selectGrade').on('select2:select', function (e) {
                var data = e.params.data
                obj.whereClause = data.id
                obj.runPaging()
            })
        },
        getKelas() {
            $.ajax({
                url: `${this.siswa}get-kelas`,
                dataType: 'json',
                success: data => {
                    this.daftarKelas = data
                }
            })
        }
    }
})