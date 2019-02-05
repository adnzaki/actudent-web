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
            class: 'alert bg-danger', show: false,
            header: 'Sukses', text: 'heheheh',
        },
        flashAlert: {
            class: 'bg-success', show: false,
            title: 'Sukses', text: 'Data peserta didik baru berhasil disimpan', 
            icon: 'la-thumbs-o-up'
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
        this.getLanguageResources()
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
        testSimpan() {
            this.alert.class = 'alert bg-success'
            this.alert.text = this.lang.siswa_add_sukses
            this.alert.header = this.lang.sukses
            this.alert.show = true
            setTimeout(() => { this.alert.show = false }, 4000);
        },
        getSiswa() {
            this.getData({
                limit: 10,
                offset: 0,
                orderBy: 'student_name',
                searchBy: 'student_nis-student_name-grade_name',
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